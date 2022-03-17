<?php

class Sales_order_item_model extends CORE_Model
{
    protected $table = "sales_order_items";
    protected $pk_id = "sales_order_item_id";
    protected $fk_id = "sales_order_id";

    function __construct()
    {
        parent::__construct();
    }


    function get_products_with_balance_qty($sales_order_id){
        $sql="SELECT o.*,(o.so_line_total-o.non_tax_amount)as tax_amount FROM

                (SELECT n.*,

                ((n.so_price*n.so_qty)-(n.so_discount*n.so_qty))as so_line_total,
                ((n.so_price*n.so_qty)/(1+tax_rate_decimal))as non_tax_amount,
                (n.so_discount*n.so_qty) as so_line_total_discount


                FROM
                (SELECT main.*,p.purchase_cost, p.size, (main.so_tax_rate/100)as tax_rate_decimal,p.product_code,p.product_desc,p.unit_id,u.unit_name FROM

                (
                SELECT
                m.sales_order_id,
                m.so_no,m.product_id,m.batch_no,m.exp_date,
                m.product_category,
                MAX(m.so_price)as so_price,
                MAX(m.so_discount)as so_discount,
                MAX(m.so_tax_rate)as so_tax_rate,
                (SUM(m.SoQty)-SUM(m.InvQty))as so_qty


                FROM

                (
                    SELECT so.sales_order_id,so.so_no,soi.product_id,so_price as price,SUM(soi.so_qty) as SoQty,0 as InvQty,
                    soi.so_price,soi.so_discount,soi.so_tax_rate,soi.batch_no,soi.exp_date,soi.product_category FROM sales_order as so
                    INNER JOIN (SELECT *, IF(ROUND(so_price) = 0, 'free','paid') as product_category FROM sales_order_items) soi ON so.sales_order_id=soi.sales_order_id
                    WHERE so.sales_order_id=$sales_order_id AND so.is_active=TRUE AND so.is_deleted=FALSE
                    GROUP BY so.so_no,soi.product_id,soi.product_category


                    UNION ALL
                    

                    SELECT so.sales_order_id,so.so_no,sii.product_id,inv_price as price,0 as SoQty,SUM(sii.inv_qty) as InvQty,
                    0 as so_price,0 as so_discount,0 as so_tax_rate,sii.batch_no,sii.exp_date,sii.product_category FROM (sales_invoice as si
                    INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
                    INNER JOIN (SELECT *, IF(ROUND(inv_price) = 0, 'free','paid') as product_category FROM sales_invoice_items) as sii ON si.sales_invoice_id=sii.sales_invoice_id
                    WHERE so.sales_order_id=$sales_order_id AND si.is_active=TRUE AND si.is_deleted=FALSE
                    GROUP BY so.so_no,sii.product_id,sii.product_category)as

                    m GROUP BY m.so_no,m.product_id,m.product_category HAVING so_qty>0

                )as main


                LEFT JOIN products as p ON main.product_id=p.product_id
                LEFT JOIN units as u ON p.unit_id=u.unit_id)as n) as o";

        return $this->db->query($sql)->result();

    }


    function get_list_open_sales($customer_id=0){
        $sql="SELECT o.* FROM

                (SELECT n.*

                FROM
                (SELECT main.*,p.product_code,p.product_desc,rp.product_type,c.customer_name FROM

                (
                SELECT
                m.sales_order_id,
                m.so_no,m.product_id,
                max(m.date_invoice) as last_invoice_date,
                m.SoQty as SoQtyTotal,
                (m.SoQty - (SUM(m.SoQty)-SUM(m.InvQty))) as SoQtyDelivered,
                (SUM(m.SoQty)-SUM(m.InvQty))as SoQtyBalance,
                m.product_category,
                m.customer_id

                FROM

                (
                    SELECT so.customer_id,so.sales_order_id,so.so_no,'' as date_invoice,soi.product_id,soi.so_price as price,SUM(soi.so_qty) as SoQty,0 as InvQty,soi.product_category
                    FROM sales_order as so
                    INNER JOIN (SELECT *, IF(ROUND(so_price) = 0, 'free','free') as product_category FROM sales_order_items) soi ON so.sales_order_id=soi.sales_order_id
                    WHERE  so.is_active=TRUE AND so.is_deleted=FALSE AND (so.order_status_id=1 OR so.order_status_id=3) AND so.is_closed = FALSE ".($customer_id == 0 ? '' : 'AND so.customer_id ='.$customer_id)."
                    GROUP BY so.so_no,soi.product_id,soi.product_category

                    UNION ALL

                    SELECT so.customer_id,so.sales_order_id,so.so_no,max(si.date_invoice),sii.product_id,sii.inv_price as price,0 as SoQty,SUM(sii.inv_qty) as InvQty,sii.product_category
                    FROM (sales_invoice as si
                    INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
                    INNER JOIN (SELECT *, IF(ROUND(inv_price) = 0, 'free','free') as product_category FROM sales_invoice_items) as sii ON si.sales_invoice_id=sii.sales_invoice_id
                    WHERE  si.is_active=TRUE AND si.is_deleted=FALSE ".($customer_id == 0 ? '' : 'AND so.customer_id ='.$customer_id)."
                    GROUP BY so.so_no,sii.product_id,sii.product_category

                    )as

                    m GROUP BY m.so_no,m.product_id,m.product_category HAVING SoQtyBalance>0

                )as main

                LEFT JOIN customers as c ON main.customer_id=c.customer_id
                LEFT JOIN products as p ON main.product_id=p.product_id
                LEFT JOIN refproduct as rp ON rp.refproduct_id=p.refproduct_id
              )as n) as o";


        return $this->db->query($sql)->result();
    }


    function get_so_no_of_open_sales(){
        $sql="SELECT o.* FROM

                (SELECT n.*

        


                FROM
                (SELECT DISTINCT main.so_no FROM

                (
                SELECT
                m.sales_order_id,
                m.so_no,m.product_id,
            
                m.SoQty as SoQtyTotal,
   
                (SUM(m.SoQty)-SUM(m.InvQty))as SoQtyBalance,
                m.product_category


                FROM

                (
                    SELECT so.sales_order_id,so.so_no,soi.product_id,soi.so_price as price,SUM(soi.so_qty) as SoQty,0 as InvQty,soi.product_category
                    FROM sales_order as so
                    INNER JOIN (SELECT *, IF(ROUND(so_price) = 0, 'free','paid') as product_category FROM sales_order_items) soi ON so.sales_order_id=soi.sales_order_id
                    WHERE  so.is_active=TRUE AND so.is_deleted=FALSE AND (so.order_status_id=1 OR so.order_status_id=3) AND so.is_closed = FALSE
                    GROUP BY so.so_no,soi.product_id,soi.product_category


                    UNION ALL
                    

                    SELECT so.sales_order_id,so.so_no,sii.product_id,sii.inv_price as price,0 as SoQty,SUM(sii.inv_qty) as InvQty,sii.product_category
                    FROM (sales_invoice as si
                    INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
                    INNER JOIN (SELECT *, IF(ROUND(inv_price) = 0, 'free','paid') as product_category FROM sales_invoice_items) as sii ON si.sales_invoice_id=sii.sales_invoice_id
                    WHERE  si.is_active=TRUE AND si.is_deleted=FALSE
                    GROUP BY so.so_no,sii.product_id,sii.product_category)as

                    m GROUP BY m.so_no,m.product_id,m.product_category HAVING SoQtyBalance>0

                )as main


                LEFT JOIN products as p ON main.product_id=p.product_id
               )as n) as o";




        return $this->db->query($sql)->result();


    }


}


?>