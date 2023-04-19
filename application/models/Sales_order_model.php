<?php

class Sales_order_model extends CORE_Model
{
    protected $table = "sales_order";
    protected $pk_id = "sales_order_id";

    function __construct()
    {
        parent::__construct();
    }


    function get_so_balance_qty($id){
        $sql="SELECT SUM(x.Balance)as Balance
        FROM
        (SELECT
        m.sales_order_id,
        m.so_no,m.product_id,

        SUM(m.SoQty) as SoQty,
        SUM(m.InvQty)as InvQty,
        (SUM(m.SoQty)-SUM(m.InvQty))as Balance


        FROM

        (SELECT so.sales_order_id,so.so_no,soi.product_id,SUM(soi.so_qty) as SoQty,0 as InvQty FROM sales_order as so
        INNER JOIN sales_order_items as soi ON so.sales_order_id=soi.sales_order_id
        WHERE so.sales_order_id=$id AND so.is_active=TRUE AND so.is_deleted=FALSE
        GROUP BY so.so_no,soi.product_id


        UNION ALL

        SELECT so.sales_order_id,so.so_no,sii.product_id,0 as SoQty,SUM(sii.inv_qty) as InvQty FROM (sales_invoice as si
        INNER JOIN sales_order as so ON si.sales_order_id=so.sales_order_id)
        INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
        WHERE so.sales_order_id=$id AND si.is_active=TRUE AND si.is_deleted=FALSE
        GROUP BY so.so_no,sii.product_id)as

        m GROUP BY m.so_no,m.product_id) as x


        WHERE x.soQty != 0";

        return $this->db->query($sql)->result();
    }


    function get_so_balance_qty_picklist($id){
        $sql="SELECT SUM(x.Balance)as Balance
        FROM
        (SELECT
        m.sales_order_id,
        m.so_no,m.product_id,

        SUM(m.SoQty) as SoQty,
        SUM(m.PlQty)as PlQty,
        (SUM(m.SoQty)-SUM(m.PlQty))as Balance


        FROM

        (SELECT so.sales_order_id,so.so_no,soi.product_id,SUM(soi.so_qty) as SoQty,0 as PlQty FROM sales_order as so
        INNER JOIN sales_order_items as soi ON so.sales_order_id=soi.sales_order_id
        WHERE so.sales_order_id=$id AND so.is_active=TRUE AND so.is_deleted=FALSE
        GROUP BY so.so_no,soi.product_id


        UNION ALL

        SELECT so.sales_order_id,so.so_no,pli.product_id,0 as SoQty,SUM(pli.so_qty) as PlQty FROM (picklist as pl
        INNER JOIN sales_order as so ON pl.sales_order_id=so.sales_order_id)
        INNER JOIN picklist_items as pli ON pl.picklist_id=pli.picklist_id
        WHERE so.sales_order_id=$id AND pl.is_active=TRUE AND pl.is_deleted=FALSE
        GROUP BY so.so_no,pli.product_id)as

        m GROUP BY m.so_no,m.product_id) as x


        WHERE x.soQty != 0";

        return $this->db->query($sql)->result();
    }

    function so_product_export($asOfDate){
        $sql=
            "SELECT
                so.so_no,
                p.product_desc,
                p.product_code,
                u.unit_name,
                c.customer_name,
                sp.acr_name,
                so.address,
                (soi.so_qty - ifnull(si_o.qty_ordered,0)) as so_balance,  soi.*
            from sales_order_items as soi
            inner join sales_order  as so on so.sales_order_id = soi.sales_order_id
            inner join products as p on p.product_id = soi.product_id
            left join customers as c on c.customer_id = so.customer_id
            left join salesperson as sp on sp.salesperson_id = so.salesperson_id
            left join units as u on u.unit_id = p.unit_id
            left join (
                select sum(qty_ordered) as qty_ordered, product_id, sales_order_id  from (
                select sii.inv_qty as qty_ordered, sii.product_id, si.sales_order_id
                from sales_invoice_items as sii
                inner join sales_invoice as si on si.sales_invoice_id = sii.sales_invoice_id
                where si.is_deleted = 0 and si.is_active = 1 and si.sales_order_id != 0 and si.date_invoice <= '$asOfDate'
                union all
                select osii.inv_qty as qty_ordered, osii.product_id, osi.sales_order_id
                from other_sales_invoice_items as osii
                inner join other_sales_invoice as osi on osi.sales_invoice_id = osii.sales_invoice_id
                where osi.is_deleted = 0 and osi.is_active = 1 and osi.sales_order_id != 0 and osi.date_invoice <= '$asOfDate'
                ) as ordered_sales group by ordered_sales.product_id, ordered_sales.sales_order_id
            ) as si_o on si_o.product_id = soi.product_id and si_o.sales_order_id = soi.sales_order_id
            where
            so.order_status_id in (1,3)
            and so.is_deleted = 0
            and so.is_active = 1
            and so.date_order <= '$asOfDate'
            and so.is_finalized = 1
            and (soi.so_qty - ifnull(si_o.qty_ordered,0)) > 0
            order by so.so_no, p.product_desc;";

        return $this->db->query($sql)->result();
    }



}


?>