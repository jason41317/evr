<?php

class Products_model extends CORE_Model {
    protected  $table="products";
    protected  $pk_id="product_id";

    function __construct() {
        parent::__construct();
    }

    function getDepartment()
    {
        $query = $this->db->query('SELECT department_name FROM departments');
        return $query->result();
    }

    function getCode() {
        $query = $this->db->query('SELECT product_code FROM products');
        return $query->result();
    }


    //function to get the Merchandise Inventory on COST OF GOODS SOLD REPORt
    function get_inventory_costing($as_of_date,$department=null){
        $sql="SELECT n.*,FORMAT(n.AvgCost,4)as AvgCost,FORMAT((n.BalanceQty*n.AvgCost),4)as TotalAvgCost
                FROM
                (SELECT

                m.*,

                (m.ReceiveQty+m.AdjInQty-m.AdjOutQty-m.IssueQty-m.SalesQty) as BalanceQty

                FROM

                (SELECT

                p.product_id,p.`product_desc`,
                IFNULL((recQuery.AvgCost+adjInQuery.AdjAvgCost)/2,0) as AvgCost,
                IFNULL(recQuery.ReceiveQty,0)as ReceiveQty,
                IFNULL(adjInQuery.AdjInQty,0) as AdjInQty,
                IFNULL(adjOutQuery.AdjOutQty,0) as AdjOutQty,
                IFNULL(issQuery.IssueQty,0) as IssueQty,
                IFNULL(salesQuery.SalesQty,0) as SalesQty


                FROM products as p LEFT JOIN

                (

                SELECT

                dii.product_id,
                SUM(dii.dr_qty) as ReceiveQty,

                /***get the average cost of all price, if 0 this means it is free***/
                AVG(IF(dii.dr_price>0,dii.dr_price,NULL)) as AvgCost

                FROM `delivery_invoice_items` as dii
                INNER JOIN `delivery_invoice` as di
                ON di.`dr_invoice_id`=dii.`dr_invoice_id`

                WHERE di.is_active=1 AND di.is_deleted=0 AND di.date_delivered<='$as_of_date'

                ".($department==1||$department==null?"":" AND di.department_id=$department")."

                GROUP BY dii.product_id

                ) as recQuery ON recQuery.product_id=p.product_id

                LEFT JOIN

                (

                SELECT

                aii.product_id,
                SUM(aii.adjust_qty)as AdjInQty,
                 AVG(IF(aii.adjust_price>0 AND aii.adjust_qty>0,aii.adjust_price,NULL)) as AdjAvgCost /**get the average of stock in adjustment**/

                FROM adjustment_items as aii
                INNER JOIN adjustment_info as ai
                ON ai.`adjustment_id`=aii.`adjustment_id`
                WHERE ai.is_active=1
                AND ai.is_deleted=0
                AND ai.`adjustment_type`='IN' AND ai.date_adjusted<='$as_of_date'
                ".($department==1||$department==null?"":" AND ai.department_id=$department")."
                GROUP BY aii.product_id

                ) as adjInQuery ON adjInQuery.product_id=p.product_id


                LEFT JOIN


                (

                SELECT

                aii.product_id,
                SUM(aii.adjust_qty)as AdjOutQty

                FROM adjustment_items as aii
                INNER JOIN adjustment_info as ai
                ON ai.`adjustment_id`=aii.`adjustment_id`
                WHERE ai.is_active=1
                AND ai.is_deleted=0
                AND ai.`adjustment_type`='OUT' AND ai.date_adjusted<='$as_of_date'
                ".($department==1||$department==null?"":" AND ai.department_id=$department")."
                GROUP BY aii.product_id


                )as adjOutQuery ON adjOutQuery.product_id=p.product_id


                LEFT JOIN


                (

                SELECT

                iii.product_id,
                SUM(iii.`issue_qty`)as IssueQty

                FROM `issuance_items` as iii
                INNER JOIN `issuance_info` as ii
                ON ii.`issuance_id`=iii.`issuance_id`
                WHERE ii.`is_active`=1 AND ii.date_issued<='$as_of_date'
                ".($department==1||$department==null?"":" AND ii.issued_department_id=$department")."
                AND ii.`is_deleted`=0


                GROUP BY iii.product_id

                ) as issQuery ON issQuery.product_id=p.product_id


                LEFT JOIN



                (

                SELECT
                sii.product_id,
                SUM(sii.`inv_qty`)as SalesQty

                FROM `sales_invoice_items` as sii
                INNER JOIN `sales_invoice` as si
                ON si.`sales_invoice_id`=sii.`sales_invoice_id`
                WHERE si.is_active=1 AND si.`is_deleted`=0 AND si.date_invoice<='$as_of_date'
                ".($department==1||$department==null?"":" AND si.department_id=$department")."

                GROUP BY sii.product_id

                ) as salesQuery ON salesQuery.product_id=p.product_id


                WHERE p.is_deleted=0) as m)as n WHERE n.BalanceQty<>0 ORDER BY product_desc";

            return $this->db->query($sql)->result();

    }

    function get_order_list($product_type_id=3,$description,$department_id=null,$supplier_id=null){
        $sql="SELECT
                p.product_id,
                p.product_code,
                p.product_desc,
                p.product_desc1,
                rp.product_type,
                s.supplier_name,
                c.category_name,
                p.is_tax_exempt,
                tt.tax_type,
                p.size,
                p.unit_id,
                u.unit_name,
                IFNULL(tt.tax_rate,0) as tax_rate,
                FORMAT(p.sale_price,4) as sale_price,
                FORMAT(p.dealer_price,4) as dealer_price,
                FORMAT(p.distributor_price,4) as distributor_price,
                FORMAT(p.discounted_price,4) as discounted_price,
                FORMAT(p.public_price,4) as public_price,
                FORMAT(p.purchase_cost,4) as purchase_cost,
                FORMAT(p.purchase_cost,4)as cost,
                FORMAT(COALESCE(m.on_hand,0),2) as on_hand

                FROM
                
                products p
                
                LEFT JOIN

                (SELECT n.product_id,
                AVG(IF(n.in_qty>0,n.avg_cost,null))as avg_cost,/**********get the AVG of in qty only**********/
                SUM(n.in_qty) as quantity_in,
                SUM(n.out_qty) as quantity_out,
                (SUM(n.in_qty)-SUM(n.out_qty)) as on_hand

                FROM

                (           
                            /* Delivery Invoice */
                            SELECT dii.product_id,AVG(dii.dr_price) as avg_cost,SUM(dii.dr_qty)as in_qty,0 as out_qty FROM delivery_invoice_items as dii
                            INNER JOIN delivery_invoice as di ON di.dr_invoice_id=dii.dr_invoice_id

                            WHERE 
                                di.is_active=TRUE AND 
                                di.is_deleted=FALSE
                                ".($department_id==null?"":" AND di.department_id=".$department_id)."

                            GROUP BY dii.product_id

                            /* Item Issuance */

                            UNION ALL

                            SELECT iss.product_id,0 AS avg_cost,0 as in_qty,SUM(iss.issue_qty)as out_qty FROM issuance_items as iss
                            INNER JOIN issuance_info as ii ON ii.issuance_id=iss.issuance_id

                            WHERE 
                                ii.is_active=TRUE AND 
                                ii.is_deleted=FALSE
                                ".($department_id==null?"":" AND ii.issued_department_id=".$department_id)."

                            GROUP BY iss.product_id

                            /* Adjustment IN */

                            UNION ALL

                            SELECT aii.product_id,adjust_price AS avg_cost,SUM(aii.adjust_qty) as in_qty,0 as out_qty FROM adjustment_items as aii
                            INNER JOIN adjustment_info as ai ON ai.adjustment_id=aii.adjustment_id

                            WHERE 
                                ai.is_active=TRUE AND 
                                ai.is_deleted=FALSE AND 
                                ai.adjustment_type='IN'
                                ".($department_id==null?"":" AND ai.department_id=".$department_id)."

                            GROUP BY aii.product_id

                            /* Adjustment OUT */

                            UNION ALL

                            SELECT aii.product_id,0 AS avg_cost,0 as in_qty,SUM(aii.adjust_qty) as out_qty FROM adjustment_items as aii
                            INNER JOIN adjustment_info as ai ON ai.adjustment_id=aii.adjustment_id

                            WHERE 
                                ai.is_active=TRUE AND 
                                ai.is_deleted=FALSE AND 
                                ai.adjustment_type='OUT'
                                ".($department_id==null?"":" AND ai.department_id=".$department_id)."

                            GROUP BY aii.product_id

                            /* Sales Invoice */

                            UNION ALL

                            SELECT sii.product_id,0 AS avg_cost,0 as in_qty,SUM(sii.inv_qty)as out_qty FROM sales_invoice_items as sii
                            INNER JOIN sales_invoice as si ON si.sales_invoice_id=sii.sales_invoice_id

                            WHERE 
                                si.is_active=TRUE AND 
                                si.is_deleted=FALSE
                                ".($department_id==null?"":" AND si.department_id=".$department_id)."
                            GROUP BY sii.product_id

                            /* Other Sales Invoice */

                            UNION ALL

                            SELECT sii.product_id,0 AS avg_cost,SUM(sii.inv_qty) as in_qty,0 as out_qty FROM sales_invoice_items as sii
                            INNER JOIN sales_invoice as si ON si.sales_invoice_id=sii.sales_invoice_id

                            WHERE 
                                si.is_active=TRUE AND 
                                si.is_deleted=FALSE AND 
                                si.inv_type=2
                                ".($department_id==null?"":" AND si.issue_to_department=".$department_id)."
                            GROUP BY sii.product_id

                            /* Item Transfer from */

                            UNION ALL

                            SELECT idii.product_id, 0 as avg_cost, 0 as in_qty, SUM(idii.issue_qty) as out_qty
                            FROM issuance_department_items as idii
                            INNER JOIN issuance_department_info as idi ON idi.issuance_department_id = idii.issuance_department_id

                            WHERE 
                                idi.is_active=TRUE AND
                                idi.is_deleted=FALSE
                                ".($department_id==null?"":" AND idi.from_department_id=".$department_id)."
                            GROUP BY idii.product_id

                            /* Item Transfer to */

                            UNION ALL

                            SELECT idii.product_id, 0 as avg_cost, SUM(idii.issue_qty) as in_qty, 0 as out_qty
                            FROM issuance_department_items as idii
                            INNER JOIN issuance_department_info as idi ON idi.issuance_department_id = idii.issuance_department_id

                            WHERE 
                                idi.is_active=TRUE AND
                                idi.is_deleted=FALSE 
                                ".($department_id==null?"":" AND idi.to_department_id=".$department_id)."
                            GROUP BY idii.product_id                            



                ) as n GROUP BY n.product_id

                ) as m ON m.product_id = p.product_id

                LEFT JOIN refproduct as rp ON rp.refproduct_id=p.refproduct_id
                LEFT JOIN suppliers as s ON s.supplier_id=p.supplier_id
                LEFT JOIN categories as c ON c.category_id=p.category_id
                LEFT JOIN tax_types as tt ON tt.tax_type_id=p.tax_type_id
                LEFT JOIN units as u ON u.unit_id=p.unit_id
                WHERE p.is_deleted=FALSE AND
                (p.product_code LIKE '".$description."%' OR p.product_desc LIKE '%".$description."%' OR p.product_desc1 LIKE '%".$description."%')
                ".($product_type_id==3?"":" AND p.refproduct_id=".$product_type_id)."
                ORDER BY p.product_desc";

            return $this->db->query($sql)->result();

    }

    //inventory as of date,
    function get_inventory($as_of_date,$product_type_id=3,$is_show_all=TRUE,$supplier_id=0,$department_id=0){
        $sql="SELECT

                m.*,
                p.product_id,p.product_code,p.product_desc,p.product_desc1,rp.product_type,s.supplier_name,c.category_name,
                p.purchase_cost,p.sale_price,tt.tax_type,u.unit_name

                FROM


                (SELECT n.product_id,
                AVG(IF(n.in_qty>0,n.avg_cost,null))as avg_cost,/**********get the AVG of in qty only**********/
                (SUM(n.in_qty)-SUM(n.out_qty)) as on_hand

                FROM

                (
                            /* Delivery Invoice */
                            SELECT dii.product_id,AVG(dii.dr_price) as avg_cost,SUM(dii.dr_qty)as in_qty,0 as out_qty FROM delivery_invoice_items as dii
                            INNER JOIN delivery_invoice as di ON di.dr_invoice_id=dii.dr_invoice_id

                            WHERE 
                                di.is_active=TRUE AND 
                                di.is_deleted=FALSE AND 
                                di.date_delivered<='$as_of_date'
                                ".($department_id==0?"":" AND di.department_id=".$department_id)."

                            GROUP BY dii.product_id

                            /* Item Issuance */

                            UNION ALL

                            SELECT iss.product_id,0 AS avg_cost,0 as in_qty,SUM(iss.issue_qty)as out_qty FROM issuance_items as iss
                            INNER JOIN issuance_info as ii ON ii.issuance_id=iss.issuance_id

                            WHERE 
                                ii.is_active=TRUE AND 
                                ii.is_deleted=FALSE AND 
                                ii.date_issued<='$as_of_date'
                                ".($department_id==0?"":" AND ii.issued_department_id=".$department_id)."

                            GROUP BY iss.product_id

                            /* Adjustment IN */

                            UNION ALL

                            SELECT aii.product_id,adjust_price AS avg_cost,SUM(aii.adjust_qty) as in_qty,0 as out_qty FROM adjustment_items as aii
                            INNER JOIN adjustment_info as ai ON ai.adjustment_id=aii.adjustment_id

                            WHERE 
                                ai.is_active=TRUE AND 
                                ai.is_deleted=FALSE AND 
                                ai.date_adjusted<='$as_of_date' AND
                                ai.adjustment_type='IN'
                                ".($department_id==0?"":" AND ai.department_id=".$department_id)."

                            GROUP BY aii.product_id

                            /* Adjustment OUT */

                            UNION ALL

                            SELECT aii.product_id,0 AS avg_cost,0 as in_qty,SUM(aii.adjust_qty) as out_qty FROM adjustment_items as aii
                            INNER JOIN adjustment_info as ai ON ai.adjustment_id=aii.adjustment_id

                            WHERE 
                                ai.is_active=TRUE AND 
                                ai.is_deleted=FALSE AND 
                                ai.date_adjusted<='$as_of_date' AND
                                ai.adjustment_type='OUT'
                                ".($department_id==0?"":" AND ai.department_id=".$department_id)."

                            GROUP BY aii.product_id

                            /* Sales Invoice */

                            UNION ALL

                            SELECT sii.product_id,0 AS avg_cost,0 as in_qty,SUM(sii.inv_qty)as out_qty FROM sales_invoice_items as sii
                            INNER JOIN sales_invoice as si ON si.sales_invoice_id=sii.sales_invoice_id

                            WHERE 
                                si.is_active=TRUE AND 
                                si.is_deleted=FALSE AND 
                                si.date_invoice<='$as_of_date'
                                ".($department_id==0?"":" AND si.department_id=".$department_id)."
                            GROUP BY sii.product_id

                            /* Other Sales Invoice */

                            UNION ALL

                            SELECT sii.product_id,0 AS avg_cost,SUM(sii.inv_qty) as in_qty,0 as out_qty FROM sales_invoice_items as sii
                            INNER JOIN sales_invoice as si ON si.sales_invoice_id=sii.sales_invoice_id

                            WHERE 
                                si.is_active=TRUE AND 
                                si.is_deleted=FALSE AND 
                                si.inv_type=2 AND
                                si.date_invoice<='$as_of_date' 
                                ".($department_id==0?"":" AND si.issue_to_department=".$department_id)."
                            GROUP BY sii.product_id

                            /* Item Transfer from */

                            UNION ALL

                            SELECT idii.product_id, 0 as avg_cost, 0 as in_qty, SUM(idii.issue_qty) as out_qty
                            FROM issuance_department_items as idii
                            INNER JOIN issuance_department_info as idi ON idi.issuance_department_id = idii.issuance_department_id

                            WHERE 
                                idi.is_active=TRUE AND
                                idi.is_deleted=FALSE AND
                                idi.date_issued<='$as_of_date' 
                                ".($department_id==0?"":" AND idi.from_department_id=".$department_id)."
                            GROUP BY idii.product_id

                            /* Item Transfer to */

                            UNION ALL

                            SELECT idii.product_id, 0 as avg_cost, SUM(idii.issue_qty) as in_qty, 0 as out_qty
                            FROM issuance_department_items as idii
                            INNER JOIN issuance_department_info as idi ON idi.issuance_department_id = idii.issuance_department_id

                            WHERE 
                                idi.is_active=TRUE AND
                                idi.is_deleted=FALSE AND
                                idi.date_issued<='$as_of_date' 
                                ".($department_id==0?"":" AND idi.to_department_id=".$department_id)."
                            GROUP BY idii.product_id                            

                ) as n GROUP BY n.product_id

                ) as m

                LEFT JOIN products as p ON p.product_id=m.product_id
                LEFT JOIN refproduct as rp ON rp.refproduct_id=p.refproduct_id
                LEFT JOIN suppliers as s ON s.supplier_id=p.supplier_id
                LEFT JOIN categories as c ON c.category_id=p.category_id
                LEFT JOIN tax_types as tt ON tt.tax_type_id=p.tax_type_id
                LEFT JOIN units as u ON u.unit_id=p.unit_id
                WHERE p.is_deleted=FALSE
                ".($product_type_id==3?"":" AND rp.refproduct_id=".$product_type_id)."
                ".($is_show_all==TRUE?"":" AND m.on_hand>0")."
                ".($supplier_id==0?"":" AND p.supplier_id=".$supplier_id)."
                ORDER BY p.product_desc
                ";

        return $this->db->query($sql)->result();
    }

    //inventory as of date,
    function get_inventory_report($as_of_date,$product_type_id=3,$ccf=null,$supplier_id=0,$department_id=0){
        $sql="SELECT

                m.avg_cost,
                m.quantity_in,
                m.quantity_out,
                m.on_hand,
                p.product_id,p.product_code, p.product_desc,p.product_desc1,rp.product_type,s.supplier_name,c.category_name,
                p.purchase_cost,p.sale_price,tt.tax_type,u.unit_name

                FROM
                
                products p

                LEFT JOIN

                (SELECT n.product_id,
                AVG(IF(n.in_qty>0,n.avg_cost,null))as avg_cost,/**********get the AVG of in qty only**********/
                SUM(n.in_qty) as quantity_in,
                SUM(n.out_qty) as quantity_out,
                (SUM(n.in_qty)-SUM(n.out_qty)) as on_hand

                FROM

                (           
                            /* Delivery Invoice */
                            SELECT dii.product_id,AVG(dii.dr_price) as avg_cost,SUM(dii.dr_qty)as in_qty,0 as out_qty FROM delivery_invoice_items as dii
                            INNER JOIN delivery_invoice as di ON di.dr_invoice_id=dii.dr_invoice_id

                            WHERE 
                                di.is_active=TRUE AND 
                                di.is_deleted=FALSE AND 
                                di.date_delivered<='$as_of_date'
                                ".($department_id==0?"":" AND di.department_id=".$department_id)."

                            GROUP BY dii.product_id

                            /* Item Issuance */

                            UNION ALL

                            SELECT iss.product_id,0 AS avg_cost,0 as in_qty,SUM(iss.issue_qty)as out_qty FROM issuance_items as iss
                            INNER JOIN issuance_info as ii ON ii.issuance_id=iss.issuance_id

                            WHERE 
                                ii.is_active=TRUE AND 
                                ii.is_deleted=FALSE AND 
                                ii.date_issued<='$as_of_date'
                                ".($department_id==0?"":" AND ii.issued_department_id=".$department_id)."

                            GROUP BY iss.product_id

                            /* Adjustment IN */

                            UNION ALL

                            SELECT aii.product_id,adjust_price AS avg_cost,SUM(aii.adjust_qty) as in_qty,0 as out_qty FROM adjustment_items as aii
                            INNER JOIN adjustment_info as ai ON ai.adjustment_id=aii.adjustment_id

                            WHERE 
                                ai.is_active=TRUE AND 
                                ai.is_deleted=FALSE AND 
                                ai.date_adjusted<='$as_of_date' AND
                                ai.adjustment_type='IN'
                                ".($department_id==0?"":" AND ai.department_id=".$department_id)."

                            GROUP BY aii.product_id

                            /* Adjustment OUT */

                            UNION ALL

                            SELECT aii.product_id,0 AS avg_cost,0 as in_qty,SUM(aii.adjust_qty) as out_qty FROM adjustment_items as aii
                            INNER JOIN adjustment_info as ai ON ai.adjustment_id=aii.adjustment_id

                            WHERE 
                                ai.is_active=TRUE AND 
                                ai.is_deleted=FALSE AND 
                                ai.date_adjusted<='$as_of_date' AND
                                ai.adjustment_type='OUT'
                                ".($department_id==0?"":" AND ai.department_id=".$department_id)."

                            GROUP BY aii.product_id

                            /* Sales Invoice */

                            UNION ALL

                            SELECT sii.product_id,0 AS avg_cost,0 as in_qty,SUM(sii.inv_qty)as out_qty FROM sales_invoice_items as sii
                            INNER JOIN sales_invoice as si ON si.sales_invoice_id=sii.sales_invoice_id

                            WHERE 
                                si.is_active=TRUE AND 
                                si.is_deleted=FALSE AND 
                                si.date_invoice<='$as_of_date'
                                ".($department_id==0?"":" AND si.department_id=".$department_id)."
                            GROUP BY sii.product_id

                            /* Other Sales Invoice */

                            UNION ALL

                            SELECT sii.product_id,0 AS avg_cost,SUM(sii.inv_qty) as in_qty,0 as out_qty FROM sales_invoice_items as sii
                            INNER JOIN sales_invoice as si ON si.sales_invoice_id=sii.sales_invoice_id

                            WHERE 
                                si.is_active=TRUE AND 
                                si.is_deleted=FALSE AND 
                                si.inv_type=2 AND
                                si.date_invoice<='$as_of_date' 
                                ".($department_id==0?"":" AND si.issue_to_department=".$department_id)."
                            GROUP BY sii.product_id

                            /* Item Transfer from */

                            UNION ALL

                            SELECT idii.product_id, 0 as avg_cost, 0 as in_qty, SUM(idii.issue_qty) as out_qty
                            FROM issuance_department_items as idii
                            INNER JOIN issuance_department_info as idi ON idi.issuance_department_id = idii.issuance_department_id

                            WHERE 
                                idi.is_active=TRUE AND
                                idi.is_deleted=FALSE AND
                                idi.date_issued<='$as_of_date' 
                                ".($department_id==0?"":" AND idi.from_department_id=".$department_id)."
                            GROUP BY idii.product_id

                            /* Item Transfer to */

                            UNION ALL

                            SELECT idii.product_id, 0 as avg_cost, SUM(idii.issue_qty) as in_qty, 0 as out_qty
                            FROM issuance_department_items as idii
                            INNER JOIN issuance_department_info as idi ON idi.issuance_department_id = idii.issuance_department_id

                            WHERE 
                                idi.is_active=TRUE AND
                                idi.is_deleted=FALSE AND
                                idi.date_issued<='$as_of_date' 
                                ".($department_id==0?"":" AND idi.to_department_id=".$department_id)."
                            GROUP BY idii.product_id                            



                ) as n GROUP BY n.product_id

                ) as m ON m.product_id = p.product_id

                LEFT JOIN refproduct as rp ON rp.refproduct_id=p.refproduct_id
                LEFT JOIN suppliers as s ON s.supplier_id=p.supplier_id
                LEFT JOIN categories as c ON c.category_id=p.category_id
                LEFT JOIN tax_types as tt ON tt.tax_type_id=p.tax_type_id
                LEFT JOIN units as u ON u.unit_id=p.unit_id
                WHERE p.is_deleted=FALSE
                ".($product_type_id==3?"":" AND rp.refproduct_id=".$product_type_id)."
                ".($ccf==null?"":" AND m.on_hand ".$ccf )."
                ".($supplier_id==0?"":" AND p.supplier_id=".$supplier_id)."
                ORDER BY p.product_desc
                ";

        return $this->db->query($sql)->result();
    }



    function get_product_history($product_id,$start,$end,$balance,$department_id=0){
        $this->db->query("SET @nBalance:=$balance;");
        $sql="


                SELECT n.*,p.product_desc,@nBalance:=(@nBalance+(n.in_qty-n.out_qty)) as balance

                FROM

                (SELECT m.*

                FROM
                (SELECT

                (ai.date_adjusted) as txn_date,
                ai.date_created,
                ai.adjustment_code as ref_no,
                ('Adjustment In')as type,
                CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                aii.product_id,aii.exp_date,aii.`batch_no`,
                (aii.adjust_qty) as in_qty,
                0 as out_qty


                 FROM adjustment_info as ai
                INNER JOIN `adjustment_items` as aii ON aii.adjustment_id=ai.adjustment_id
                LEFT JOIN departments d ON d.department_id = ai.department_id
                WHERE ai.adjustment_type='IN' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                AND aii.product_id=$product_id AND ai.date_adjusted BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND ai.department_id=".$department_id)."

                UNION ALL


                SELECT

                (ai.date_adjusted) as txn_date,
                ai.date_created,
                ai.adjustment_code as ref_no,
                ('Adjustment Out')as type,
                CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                aii.product_id,aii.exp_date,aii.`batch_no`,
                0 as in_qty,
                (aii.adjust_qty)  as out_qty


                 FROM adjustment_info as ai
                INNER JOIN `adjustment_items` as aii ON aii.adjustment_id=ai.adjustment_id
                LEFT JOIN departments d ON d.department_id = ai.department_id
                WHERE ai.adjustment_type='OUT' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                AND aii.product_id=$product_id AND ai.date_adjusted BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND ai.department_id=".$department_id)."


                UNION ALL


                SELECT

                di.date_delivered as txn_date,
                di.date_created,
                di.dr_invoice_no as ref_no,
                ('Purchase Invoice') as type,
                CONCAT(IFNULL(s.supplier_name,''),' (Supplier)') as Description,
                dii.product_id,
                dii.exp_date,dii.batch_no,
                (dii.dr_qty)as in_qty,0 as out_qty

                FROM (delivery_invoice as di
                LEFT JOIN suppliers as s ON s.supplier_id=di.supplier_id)
                INNER JOIN delivery_invoice_items as dii
                ON dii.dr_invoice_id=di.dr_invoice_id
                WHERE di.is_active=TRUE AND di.is_deleted=FALSE
                AND dii.product_id=$product_id  AND di.date_delivered BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND di.department_id=".$department_id)."

                UNION ALL


                SELECT

                si.date_invoice as txn_date,
                si.date_created,
                si.sales_inv_no as ref_no,
                ('Sales Invoice') as type,
                CONCAT(IFNULL(c.customer_name,''),' (Customer)') as Description,
                sii.product_id,
                sii.exp_date,sii.batch_no,
                0 as in_qty,(sii.inv_qty) as out_qty

                FROM (sales_invoice as si
                LEFT JOIN customers as c ON c.customer_id=si.customer_id)
                INNER JOIN sales_invoice_items as sii
                ON sii.sales_invoice_id=si.sales_invoice_id
                WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=1
                AND sii.product_id=$product_id  AND si.date_invoice BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND si.department_id=".$department_id)."

                UNION ALL


                SELECT

                ii.date_issued as txn_date,
                ii.date_created,
                ii.slip_no as ref_no,
                'Issuance' as type,
                ii.issued_to_person as Description,

                iit.product_id,iit.exp_date,iit.batch_no,0 as in_qty,
                issue_qty as out_qty

                FROM issuance_info as ii
                INNER JOIN issuance_items as iit ON iit.issuance_id=ii.issuance_id

                WHERE ii.is_active=TRUE AND ii.is_deleted=FALSE
                AND iit.product_id=$product_id  AND ii.date_issued BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND ii.issued_department_id=".$department_id)."

                UNION ALL

                SELECT
                si.date_invoice as txn_date,
                si.date_created,
                si.sales_inv_no as ref_no,
                ('Other Sales Invoice') as type,
                CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                sii.product_id,
                sii.exp_date,sii.batch_no,
                (sii.inv_qty) as in_qty,0 as out_qty

                FROM (sales_invoice as si
                LEFT JOIN departments as d ON d.department_id=si.department_id)
                INNER JOIN sales_invoice_items as sii
                ON sii.sales_invoice_id=si.sales_invoice_id
                WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=2 AND sii.product_id=$product_id

                AND si.date_invoice BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND si.issue_to_department=".$department_id)."

                UNION ALL


                SELECT
                si.date_invoice as txn_date,
                si.date_created,
                si.sales_inv_no as ref_no,
                ('Other Sales Invoice') as type,
                CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                sii.product_id,
                sii.exp_date,sii.batch_no,
                0 as in_qty,(sii.inv_qty) as out_qty

                FROM (sales_invoice as si
                LEFT JOIN departments as d ON d.department_id=si.issue_to_department)
                INNER JOIN sales_invoice_items as sii
                ON sii.sales_invoice_id=si.sales_invoice_id
                WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=2 AND sii.product_id=$product_id

                AND si.date_invoice BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND si.department_id=".$department_id)."

                UNION ALL


                SELECT

                idi.date_issued as txn_date,
                idi.date_created,
                idi.trn_no as ref_no,
                ('Item Transfer') as type,
                CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                idii.product_id,
                idii.exp_date,idii.batch_no,
                (idii.issue_qty) as in_qty,0 as out_qty

                FROM (issuance_department_info as idi
                LEFT JOIN departments as d ON d.department_id=idi.to_department_id)
                INNER JOIN issuance_department_items as idii
                ON idii.issuance_department_id = idi.issuance_department_id
                WHERE idi.is_active=TRUE AND idi.is_deleted=FALSE AND idii.product_id=$product_id

                AND idi.date_issued BETWEEN '$start' AND '$end' 
                ".($department_id==0?"":" AND idi.to_department_id=".$department_id)."


                UNION ALL

                SELECT

                idi.date_issued as txn_date,
                idi.date_created,
                idi.trn_no as ref_no,
                ('Item Transfer') as type,
                CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                idii.product_id,
                idii.exp_date,idii.batch_no,
                0 as in_qty,(idii.issue_qty) as out_qty

                FROM (issuance_department_info as idi
                LEFT JOIN departments as d ON d.department_id=idi.from_department_id)
                INNER JOIN issuance_department_items as idii
                ON idii.issuance_department_id = idi.issuance_department_id
                WHERE idi.is_active=TRUE AND idi.is_deleted=FALSE AND idii.product_id=$product_id

                AND idi.date_issued BETWEEN '$start' AND '$end'
                ".($department_id==0?"":" AND idi.from_department_id=".$department_id)."


                ) as m ORDER BY m.txn_date ASC, m.date_created ASC) as n  LEFT JOIN products as p ON n.product_id=p.product_id";

        return $this->db->query($sql)->result();
    }

    function get_product_balance_as_of_date($product_id,$date,$department_id=0){
        $sql="SELECT main.product_id,
        (IFNULL(adjin.adj_in,0) +
        IFNULL(salin.sal_in,0) +
        IFNULL(itfin.itf_in,0) + 
        IFNULL(drin.dr_in,0) - 
        IFNULL(adjout.adj_out,0) -
        IFNULL(salout.sal_out,0) -
        IFNULL(issout.iss_out,0) - 
        IFNULL(itfout.itf_out,0)) as balance 
        FROM

        products   as main

        /* Adjustment IN */

        LEFT JOIN 
        (SELECT
        aii.product_id,
        SUM(aii.adjust_qty) as adj_in

        FROM adjustment_info as ai
        INNER JOIN adjustment_items as aii ON aii.adjustment_id=ai.adjustment_id
        WHERE ai.adjustment_type='IN' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
        AND aii.product_id = $product_id AND ai.date_adjusted < '$date'
        ".($department_id==0?"":" AND ai.department_id=".$department_id)."

        GROUP BY aii.product_id) as adjin ON adjin.product_id = main.product_id

        /* Delivery Invoice */

        LEFT JOIN
        (SELECT
        dii.product_id,
        SUM(dii.dr_qty)as dr_in

        FROM delivery_invoice di
        INNER JOIN delivery_invoice_items as dii
        ON dii.dr_invoice_id=di.dr_invoice_id
        WHERE di.is_active=TRUE AND di.is_deleted=FALSE
        AND dii.product_id = $product_id AND di.date_delivered < '$date'
        ".($department_id==0?"":" AND di.department_id=".$department_id)."
        GROUP BY dii.product_id)  as drin ON drin.product_id = main.product_id 

        /* Adjustment OUT */

        LEFT JOIN
        (SELECT
        aii.product_id,
        SUM(aii.adjust_qty)  as adj_out

        FROM adjustment_info as ai
        INNER JOIN adjustment_items as aii ON aii.adjustment_id=ai.adjustment_id
        WHERE ai.adjustment_type='OUT' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
        AND aii.product_id = $product_id AND ai.date_adjusted < '$date'
        ".($department_id==0?"":" AND ai.department_id=".$department_id)."
        GROUP BY aii.product_id) as adjout ON adjout.product_id = main.product_id 

        /* Sales Invoice */

        LEFT JOIN

        (SELECT
        sii.product_id,
        SUM(sii.inv_qty) as sal_out

        FROM sales_invoice as si
        INNER JOIN sales_invoice_items as sii
        ON sii.sales_invoice_id=si.sales_invoice_id
        WHERE si.is_active=TRUE AND si.is_deleted=FALSE 
        AND sii.product_id = $product_id AND si.date_invoice < '$date'
        ".($department_id==0?"":" AND si.department_id=".$department_id)."
        GROUP BY sii.product_id) as salout ON salout.product_id = main.product_id 

        /* Item Issuance */

        LEFT JOIN
        (SELECT
        iit.product_id,
        SUM(issue_qty) as iss_out

        FROM issuance_info as ii
        INNER JOIN issuance_items as iit ON iit.issuance_id=ii.issuance_id
        WHERE ii.is_active=TRUE AND ii.is_deleted=FALSE
        AND iit.product_id=$product_id AND ii.date_issued < '$date'
        ".($department_id==0?"":" AND ii.issued_department_id=".$department_id)."
        GROUP BY iit.product_id) as issout ON issout.product_id = main.product_id

        /* Other Sales Invoice */

        LEFT JOIN 
        (SELECT
        sii.product_id,
        SUM(sii.inv_qty) as sal_in

        FROM sales_invoice as si
        INNER JOIN sales_invoice_items as sii
        ON sii.sales_invoice_id=si.sales_invoice_id
        WHERE si.is_active=TRUE AND si.is_deleted=FALSE 
        AND si.inv_type=2
        AND sii.product_id = $product_id AND si.date_invoice < '$date'
        ".($department_id==0?"":" AND si.issue_to_department=".$department_id)."
        GROUP BY sii.product_id
        ) as salin ON salin.product_id = main.product_id

        /* Item Transfer (From) */

        LEFT JOIN 
        (SELECT
        idii.product_id,
        SUM(idii.issue_qty) as itf_out

        FROM issuance_department_info as idi
        INNER JOIN issuance_department_items as idii
        ON idii.issuance_department_id = idi.issuance_department_id
        WHERE idi.is_active=TRUE AND idi.is_deleted=FALSE
        AND idii.product_id=$product_id AND idi.date_issued < '$date'
        ".($department_id==0?"":" AND idi.from_department_id=".$department_id)."
        GROUP BY idii.product_id
        ) as itfout ON itfout.product_id = main.product_id


        /* Item Transfer (to) */

        LEFT JOIN 
        (SELECT
        idii.product_id,
        SUM(idii.issue_qty) as itf_in

        FROM issuance_department_info as idi
        INNER JOIN issuance_department_items as idii
        ON idii.issuance_department_id = idi.issuance_department_id
        WHERE idi.is_active=TRUE AND idi.is_deleted=FALSE
        AND idii.product_id=$product_id AND idi.date_issued < '$date'
        ".($department_id==0?"":" AND idi.to_department_id=".$department_id)."
        GROUP BY idii.product_id
        ) as itfin ON itfin.product_id = main.product_id


        WHERE main.product_id = $product_id 
        ";

        return $this->db->query($sql)->result();
    }



    function get_product_current_qty($batch_no,$product_id,$expire_date,$department_id=0){
        $sql="SELECT `get_product_qty_per_batch`('$batch_no',$product_id,'$expire_date','$department_id') as batch_qty";
        $result=$this->db->query($sql)->result();
        return (count($result)>0?$result[0]->batch_qty:0);
    }



    function get_current_item_list($criteria="",$type=3,$department_id=0){


            //adjusted 1/3/2017
            //added adjustment IN and OUT on Query
            //modified Unique ID based on Batch Number

            $sql="SELECT rc.*,p.*,u.unit_name,

                IFNULL(tt.tax_rate,0) as tax_rate,FORMAT(sale_price,4) as srp
                ,IFNULL(sinv.out_qty,0) as out_qty,

                FORMAT(dealer_price,4) as srp_dealer,
                FORMAT(distributor_price,4) as srp_distributor,
                FORMAT(public_price,4) as srp_public,
                FORMAT(discounted_price,4) as srp_discounted,
                FORMAT(purchase_cost,2) as cost_price,
                FORMAT(rc.item_cost,4) as srp_cost,
                (rc.in_qty -
                (IFNULL(sinv.out_qty,0) + 
                IFNULL(iss.out_qty,0) +
                IFNULL(aoQ.out_qty,0) + 
                IFNULL(itf.out_qty,0))) as on_hand_per_batch

                    FROM

                    (

                        SELECT inQ.*,inQ.product_item_cost as item_cost,SUM(inQ.receive_qty)as in_qty

                        FROM
                        /**to get the recent cost of each batch, derive query is created to ORDER DESC by date_created**/
                        (

                            /*******************************************/
                            SELECT dii.product_id,dii.batch_no,dii.exp_date,
                            CONCAT_WS('-',dii.batch_no,dii.product_id,dii.exp_date)as unq_id,
                            dii.dr_qty as receive_qty,dii.product_item_cost

                            FROM

                            (

                                /* Delivery Invoice */

                                SELECT dii.product_id,dii.batch_no,dii.exp_date,
                                CONCAT_WS('-',dii.batch_no,dii.product_id,dii.exp_date)as unq_id,
                                dii.dr_qty,dii.dr_price as product_item_cost,di.date_created
                                FROM delivery_invoice_items as dii
                                INNER JOIN delivery_invoice as di
                                ON dii.dr_invoice_id=di.dr_invoice_id
                                WHERE di.is_active=TRUE AND di.is_deleted=FALSE
                                ".($department_id==0?"":" AND di.department_id=".$department_id)."


                                UNION ALL

                                /* Adjustment IN */

                                SELECT aii.product_id,aii.batch_no,aii.exp_date,
                                CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                                aii.adjust_qty as receive_qty,aii.adjust_price as product_item_cost,ai.date_created
                                FROM adjustment_items as aii
                                INNER JOIN adjustment_info as ai
                                ON aii.adjustment_id=ai.adjustment_id
                                WHERE ai.adjustment_type='IN' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                                ".($department_id==0?"":" AND ai.department_id=".$department_id)."

                                UNION ALL

                                SELECT sii.product_id,sii.batch_no,sii.exp_date,
                                CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                                sii.inv_qty as receive_qty,sii.cost_upon_invoice as product_item_cost,si.date_created
                                FROM sales_invoice_items as sii
                                INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
                                WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=2
                                ".($department_id==0?"":" AND si.issue_to_department=".$department_id)."


                                UNION ALL

                                SELECT idii.product_id,idii.batch_no,idii.exp_date,
                                CONCAT_WS('-',idii.batch_no,idii.product_id,idii.exp_date)as unq_id,
                                idii.issue_qty as receive_qty,idii.cost_upon_invoice as product_item_cost,idi.date_created
                                FROM issuance_department_items as idii
                                INNER JOIN issuance_department_info as idi 
                                ON idii.issuance_department_id = idi.issuance_department_id
                                WHERE idi.is_active=TRUE AND idi.is_deleted=FALSE
                                ".($department_id==0?"":" AND idi.to_department_id=".$department_id)."


                            )as dii ORDER BY dii.date_created DESC


                        /*******************************************/
                        ) as inQ

                        GROUP By inQ.product_id,inQ.batch_no,inQ.exp_date




                    )as rc


                    /* Sales Invoice */

                    LEFT JOIN


                    (SELECT sii.product_id,
                    CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                    SUM(sii.inv_qty) as out_qty
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE
                    ".($department_id==0?"":" AND si.department_id=".$department_id)."
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date) as sinv

                    ON rc.unq_id=sinv.unq_id

                    /* Item Issuance */

                    LEFT JOIN

                    (  SELECT iss.product_id,
                    CONCAT_WS('-',iss.batch_no,iss.product_id,iss.exp_date)as unq_id,
                    SUM(iss.issue_qty) as out_qty
                    FROM issuance_items as iss INNER JOIN issuance_info as iin ON iin.issuance_id=iss.issuance_id
                    WHERE iin.is_active=TRUE AND iin.is_deleted=FALSE
                    ".($department_id==0?"":" AND iin.issued_department_id=".$department_id)."
                    GROUP BY iss.product_id,iss.batch_no,iss.exp_date)as iss

                    ON rc.unq_id=iss.unq_id

                    /* Adjustment OUT */

                    LEFT JOIN

                    (
                    SELECT aii.product_id,aii.batch_no,aii.exp_date,
                    CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                    SUM(aii.adjust_qty) as out_qty
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='OUT' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    ".($department_id==0?"":" AND ai.department_id=".$department_id)."
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date
                    )as aoQ

                    ON rc.unq_id=aoQ.unq_id

                    /* Item Transfer (From) */

                    LEFT JOIN

                    (SELECT idii.product_id,
                    CONCAT_WS('-',idii.batch_no,idii.product_id,idii.exp_date)as unq_id,
                    SUM(idii.issue_qty) as out_qty
                    FROM issuance_department_info as idi
                    INNER JOIN issuance_department_items as idii 
                    ON idii.issuance_department_id = idi.issuance_department_id
                    WHERE idi.is_active=TRUE AND idi.is_deleted=FALSE
                    ".($department_id==0?"":" AND idi.from_department_id=".$department_id)."
                    GROUP BY idii.product_id,idii.batch_no,idii.exp_date
                    ) as itf

                    ON rc.unq_id=itf.unq_id

                    LEFT JOIN

                    (SELECT * FROM products where is_active = true and is_deleted = false) as p ON rc.product_id=p.product_id

                    LEFT JOIN tax_types as tt ON p.tax_type_id=tt.tax_type_id
                    LEFT JOIN units as u ON p.unit_id=u.unit_id


                    WHERE ".($type==3?"":" p.refproduct_id=".$type." AND ")." (p.product_desc LIKE '%".$criteria."%' OR p.product_code LIKE '%".$criteria."%' OR p.product_desc1 LIKE '%".$criteria."%' OR CAST(p.product_id AS CHAR) LIKE '%".$criteria."%') HAVING on_hand_per_batch>0";


        return $this->db->query($sql)->result();
    }


    //per expiration inventory report
    function get_all_items_inventory($date){
        // $sql="SELECT rc.*,p.*,rp.product_type,cat.category_name,DATE_FORMAT(exp_date,'%m/%d/%Y')as expiration,IFNULL(sinv.out_qty,0) as out_qty,(rc.in_qty-IFNULL(sinv.out_qty,0)-IFNULL(iss.out_qty,0)) as on_hand
        //             FROM
        //             (
        //             SELECT dii.product_id,di.batch_no,di.dr_invoice_id,dii.exp_date,
        //             CONCAT_WS('-',dii.dr_invoice_id,dii.product_id,dii.exp_date)as unq_id,
        //             SUM(dii.dr_qty) as in_qty
        //             FROM delivery_invoice_items as dii
        //             INNER JOIN delivery_invoice as di
        //             ON dii.dr_invoice_id=di.dr_invoice_id
        //             WHERE di.date_created<='".$date." 00:00:00' AND di.is_deleted=FALSE AND di.is_active=TRUE
        //             GROUP BY dii.product_id,dii.dr_invoice_id)as rc
        //             LEFT JOIN
        //             (SELECT sii.product_id,
        //             CONCAT_WS('-',sii.dr_invoice_id,sii.product_id,sii.exp_date)as unq_id,
        //             SUM(sii.inv_qty) as out_qty
        //             FROM sales_invoice_items as sii
        //             INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
        //             WHERE si.date_created<='".$date." 00:00:00' AND si.is_deleted=FALSE AND si.is_active=TRUE
        //             GROUP BY sii.product_id,sii.dr_invoice_id) as sinv
        //             ON rc.unq_id=sinv.unq_id
        //             LEFT JOIN
        //             ( SELECT iss.product_id,
        //             CONCAT_WS('-',iss.dr_invoice_id,iss.product_id,iss.exp_date)as unq_id,
        //             SUM(iss.issue_qty) as out_qty
        //             FROM issuance_items as iss
        //             INNER JOIN issuance_info as ii ON iss.issuance_id=ii.issuance_id
        //             WHERE ii.date_created<='".$date." 00:00:00' AND ii.is_deleted=FALSE AND ii.is_active=TRUE
        //             GROUP BY iss.product_id,iss.dr_invoice_id)as iss
        //             ON rc.unq_id=iss.unq_id
        //             LEFT JOIN
        //             products as p ON rc.product_id=p.product_id
        //             LEFT JOIN refproduct as rp ON rp.refproduct_id=p.refproduct_id
        //             LEFT JOIN categories as cat ON cat.category_id=p.category_id
        //             ORDER BY p.product_desc,exp_date
        //             ";

        $sql="SELECT main.* FROM (SELECT rc.*,
                p.product_code,
                p.product_desc,
                p.size,
                p.refproduct_id,
                c.category_name,DATE_FORMAT(rc.exp_date,'%m/%d/%Y')as expiration,
                    FORMAT(sale_price,2) as srp
                    ,IFNULL(sinv.out_qty,0) as out_qty,
                    (rc.in_qty-IFNULL(sinv.out_qty,0)-IFNULL(iss.out_qty,0)-IFNULL(aoQ.out_qty,0)) as on_hand_per_batch
                    FROM
                    (
                    SELECT inQ.*,SUM(inQ.receive_qty)as in_qty
                    FROM
                    (SELECT dii.product_id,dii.batch_no,dii.exp_date,
                    CONCAT_WS('-',dii.batch_no,dii.product_id,dii.exp_date)as unq_id,
                    SUM(dii.dr_qty) as receive_qty
                    FROM delivery_invoice_items as dii
                    INNER JOIN delivery_invoice as di
                    ON dii.dr_invoice_id=di.dr_invoice_id
                    WHERE di.is_active=TRUE AND di.is_deleted=FALSE
                    AND di.date_delivered<='$date'
                    GROUP BY dii.product_id,dii.`batch_no`,dii.exp_date

                    UNION ALL

                    SELECT aii.product_id,aii.batch_no,aii.exp_date,
                    CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                    SUM(aii.adjust_qty) as receive_qty
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='IN' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    AND ai.date_adjusted<='$date'
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date) as inQ
                    GROUP By inQ.product_id,inQ.batch_no,inQ.exp_date
                    )as rc


                    LEFT JOIN
                    (SELECT sii.product_id,
                    CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                    SUM(sii.inv_qty) as out_qty
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si
                    ON sii.sales_invoice_id=si.sales_invoice_id
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE
                    AND si.date_invoice<='$date'
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date) as sinv
                    ON rc.unq_id=sinv.unq_id

                    LEFT JOIN
                    (SELECT iss.product_id,
                    CONCAT_WS('-',iss.batch_no,iss.product_id,iss.exp_date)as unq_id,
                    SUM(iss.issue_qty) as out_qty
                    FROM issuance_items as iss
                    INNER JOIN issuance_info as iin
                    ON iss.issuance_id=iin.issuance_id
                    WHERE iin.date_issued<='$date' AND iin.is_active=TRUE AND iin.is_deleted=FALSE
                    GROUP BY iss.product_id,iss.batch_no,iss.exp_date)as iss
                    ON rc.unq_id=iss.unq_id

                    LEFT JOIN
                    (
                    SELECT aii.product_id,aii.batch_no,aii.exp_date,
                    CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                    SUM(aii.adjust_qty) as out_qty
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='OUT' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    AND ai.date_adjusted<='$date'
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date
                    )as aoQ
                    ON rc.unq_id=aoQ.unq_id
                    LEFT JOIN

                    (SELECT * FROM products where is_deleted = false AND is_active = TRUE) as p ON rc.product_id=p.product_id
                    LEFT JOIN (SELECT category_id,category_name FROM categories) as c ON p.category_id=c.category_id
                    ORDER BY p.product_desc,exp_date) as main
                    WHERE on_hand_per_batch > 0
                    ";


        return $this->db->query($sql)->result();
    }

    function batch_inventory($supplier_id=0,$prod_type_id=3,$department_id=0,$count=null,$as_of_date){
        
        $sql="
            SELECT m.* FROM
            (SELECT p.product_code, p.product_desc, 
                p.size, s.supplier_name, c.category_name, rp.product_type,
                p.purchase_cost, p.sale_price,
                main.product_id,
                main.batch_no,
                DATE_FORMAT(main.exp_date,'%m/%d/%Y') as exp_date,
                main.unq_id,
                SUM(main.qty_in) as qty_in,
                SUM(main.qty_out) as qty_out,
                (SUM(main.qty_in) - SUM(main.qty_out)) as on_hand_per_batch
                    
            FROM 

            (
                /*Delivery Invoice*/
                SELECT 
                        dii.product_id,
                        dii.batch_no,
                        dii.exp_date,
                        CONCAT_WS('-',dii.batch_no,dii.product_id,dii.exp_date)as unq_id,
                        SUM(dii.dr_qty) as qty_in,
                        0 as qty_out
                    FROM delivery_invoice_items as dii
                    INNER JOIN delivery_invoice as di
                    ON dii.dr_invoice_id=di.dr_invoice_id
                    WHERE di.is_active=TRUE AND di.is_deleted=FALSE
                    ".($department_id==0?"":" AND di.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND di.date_delivered <= '".$as_of_date."'")."        
                    GROUP BY dii.product_id,dii.batch_no,dii.exp_date
                
                /*Adjustment IN*/
                UNION ALL
                
                    SELECT 
                        aii.product_id,
                        aii.batch_no,
                        aii.exp_date,
                        CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                        SUM(aii.adjust_qty) as qty_in,
                        0 as qty_out
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='IN' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    ".($department_id==0?"":" AND ai.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND ai.date_adjusted <= '".$as_of_date."'")."                            
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date
                
                /*Sales Invoice*/
                UNION ALL
                
                    SELECT 
                        sii.product_id,
                        sii.batch_no,
                        sii.exp_date,
                        CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(sii.inv_qty) as qty_out
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE
                    ".($department_id==0?"":" AND si.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND si.date_invoice <= '".$as_of_date."'")."                        
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date

                /*Other Sales Invoice*/
                UNION ALL
                
                    SELECT 
                        sii.product_id,
                        sii.batch_no,
                        sii.exp_date,
                        CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                        SUM(sii.inv_qty) as qty_in,
                        0 as qty_out
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=2
                    ".($department_id==0?"":" AND si.issue_to_department=".$department_id."")."
                    ".($as_of_date==null?"":" AND si.date_invoice <= '".$as_of_date."'")."                        
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date                    
                    
                /*Issuance*/
                UNION ALL 
                
                    SELECT 
                        iss.product_id,
                        iss.batch_no,
                        iss.exp_date,
                        CONCAT_WS('-',iss.batch_no,iss.product_id,iss.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(iss.issue_qty) as qty_out
                    FROM issuance_items as iss INNER JOIN issuance_info as iin ON iin.issuance_id=iss.issuance_id
                    WHERE iin.is_active=TRUE AND iin.is_deleted=FALSE
                    ".($department_id==0?"":" AND iin.issued_department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND iin.date_issued <= '".$as_of_date."'")."   
                    GROUP BY iss.product_id,iss.batch_no,iss.exp_date
                    
                /*Adjustment OUT*/
                UNION ALL
                
                    SELECT 
                        aii.product_id,
                        aii.batch_no,
                        aii.exp_date,
                        CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(aii.adjust_qty) as qty_out
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='OUT' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    ".($department_id==0?"":" AND ai.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND ai.date_adjusted <= '".$as_of_date."'")."                    
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date

                /*Item Transfer IN*/
                UNION ALL
                
                    SELECT 
                        idi.product_id,
                        idi.batch_no,
                        idi.exp_date,
                        CONCAT_WS('-',idi.batch_no,idi.product_id,idi.exp_date)as unq_id,
                        SUM(idi.issue_qty) as qty_in,
                        0 as qty_out
                    FROM issuance_department_items as idi
                    INNER JOIN issuance_department_info as id
                    ON idi.issuance_department_id=id.issuance_department_id
                    WHERE id.is_active=TRUE AND id.is_deleted=FALSE    
                    ".($department_id==0?"":" AND id.to_department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND id.date_issued <= '".$as_of_date."'")."                    
                    GROUP BY idi.product_id,idi.batch_no,idi.exp_date     

                /*Item Transfer OUT*/
                UNION ALL
                
                    SELECT 
                        idi.product_id,
                        idi.batch_no,
                        idi.exp_date,
                        CONCAT_WS('-',idi.batch_no,idi.product_id,idi.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(idi.issue_qty) as qty_out
                    FROM issuance_department_items as idi
                    INNER JOIN issuance_department_info as id
                    ON idi.issuance_department_id=id.issuance_department_id
                    WHERE id.is_active=TRUE AND id.is_deleted=FALSE    
                    ".($department_id==0?"":" AND id.from_department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND id.date_issued <= '".$as_of_date."'")."                    
                    GROUP BY idi.product_id,idi.batch_no,idi.exp_date                                         

            ) as main

            LEFT JOIN products p ON p.product_id = main.product_id
            LEFT JOIN suppliers s ON s.supplier_id = p.supplier_id
            LEFT JOIN categories c ON c.category_id = p.category_id
            LEFT JOIN refproduct rp ON rp.refproduct_id = p.refproduct_id
            WHERE p.is_deleted = FALSE AND p.is_active = TRUE AND p.item_type_id = 1
            ".($prod_type_id==3?"":" AND p.refproduct_id=".$prod_type_id)."
            ".($supplier_id==0?"":" AND p.supplier_id=".$supplier_id)."

            GROUP BY main.unq_id
            ORDER BY p.product_desc ASC, main.exp_date ASC, main.batch_no ASC ) as m

            ".($count==null?"":" HAVING m.on_hand_per_batch ".$count."")." ";
        return $this->db->query($sql)->result();
    }


    function batch_inventory_history($unq_id,$department_id=0,$as_of_date){
         $this->db->query("SET @nBalance:=0.00;");
         $sql="
            SELECT  m.*,
                    @nBalance:=(@nBalance+(m.qty_in-m.qty_out)) as balance 

            FROM

            (SELECT main.* FROM

            (
                /*Delivery Invoice*/
                SELECT 
                    di.date_delivered as txn_date,
                    di.dr_invoice_no as ref_no,
                    'Purchase Invoice' as txn_type,
                    CONCAT(s.supplier_name,' (Supplier)') as description,
                    dii.product_id,
                    dii.batch_no,
                    dii.exp_date,
                    CONCAT_WS('-',dii.batch_no,dii.product_id,dii.exp_date) as unq_id,
                    SUM(dii.dr_qty) as qty_in,
                    0 as qty_out,
                    di.date_created
                FROM delivery_invoice_items as dii
                INNER JOIN delivery_invoice as di ON dii.dr_invoice_id=di.dr_invoice_id
                LEFT JOIN suppliers s ON s.supplier_id = di.supplier_id
                WHERE di.is_active=TRUE AND di.is_deleted=FALSE
                AND CONCAT_WS('-',dii.batch_no,dii.product_id,dii.exp_date) = '$unq_id'
                ".($department_id==0?"":" AND di.department_id=".$department_id."")."
                ".($as_of_date==null?"":" AND di.date_delivered <= '".$as_of_date."'")."
                GROUP BY dii.product_id,dii.batch_no,dii.exp_date,di.dr_invoice_id
                
                /*Adjustment IN*/
                UNION ALL
                    
                    SELECT 
                        ai.date_adjusted as txn_date,
                        ai.adjustment_code as ref_no,
                        'Adjustment IN' as txn_type,
                        'Inventory Adjustment' as description,
                        aii.product_id,
                        aii.batch_no,
                        aii.exp_date,
                        CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                        SUM(aii.adjust_qty) as qty_in,
                        0 as qty_out,
                        ai.date_created
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='IN' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    AND CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND ai.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND ai.date_adjusted <= '".$as_of_date."'")."                  
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date,ai.adjustment_id
                
                /*Sales Invoice*/
                UNION ALL
                
                    SELECT 
                        si.date_invoice as txn_date,
                        si.sales_inv_no as ref_no,
                        'Charge Invoice' as txn_type,
                        CONCAT(c.customer_name,' (Customer)') as description,
                        sii.product_id,
                        sii.batch_no,
                        sii.exp_date,
                        CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(sii.inv_qty) as qty_out,
                        si.date_created
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
                    LEFT JOIN customers c ON c.customer_id = si.customer_id
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=1
                    AND CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND si.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND si.date_invoice <= '".$as_of_date."'")."                    
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date,si.sales_invoice_id
                    
                /*Other Sales Invoice*/
                UNION ALL
                
                    SELECT 
                        si.date_invoice as txn_date,
                        si.sales_inv_no as ref_no,
                        'Charge Invoice' as txn_type,
                        CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                        sii.product_id,
                        sii.batch_no,
                        sii.exp_date,
                        CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                        SUM(sii.inv_qty) as qty_in,
                        0 as qty_out,
                        si.date_created
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
                    LEFT JOIN departments d ON d.department_id = si.issue_to_department
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=2
                    AND CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND si.issue_to_department=".$department_id."")."
                    ".($as_of_date==null?"":" AND si.date_invoice <= '".$as_of_date."'")."                    
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date,si.sales_invoice_id
                
                
                /*Other Sales Invoice*/
                UNION ALL
                
                    SELECT 
                        si.date_invoice as txn_date,
                        si.sales_inv_no as ref_no,
                        'Charge Invoice' as txn_type,
                        CONCAT(IFNULL(d.department_name,''),' (Branch)') as Description,
                        sii.product_id,
                        sii.batch_no,
                        sii.exp_date,
                        CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(sii.inv_qty) as qty_out,
                        si.date_created
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si ON sii.sales_invoice_id=si.sales_invoice_id
                    LEFT JOIN departments d ON d.department_id = si.department_id
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.inv_type=2
                    AND CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND si.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND si.date_invoice <= '".$as_of_date."'")."                    
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date,si.sales_invoice_id

                /*Issuance*/
                UNION ALL
                
                    SELECT 
                        iin.date_issued as txn_date,
                        iin.slip_no as ref_no,
                        'Issuance' as txn_type,
                        iin.issued_to_person as description,
                        iss.product_id,
                        iss.batch_no,
                        iss.exp_date,
                        CONCAT_WS('-',iss.batch_no,iss.product_id,iss.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(iss.issue_qty) as qty_out,
                        iin.date_created
                    FROM issuance_items as iss 
                    INNER JOIN issuance_info as iin ON iin.issuance_id=iss.issuance_id
                    WHERE iin.is_active=TRUE AND iin.is_deleted=FALSE
                    AND CONCAT_WS('-',iss.batch_no,iss.product_id,iss.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND iin.issued_department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND iin.date_issued <= '".$as_of_date."'")."
                    GROUP BY iss.product_id,iss.batch_no,iss.exp_date,iin.issuance_id
                
                /*Adjustment OUT*/
                UNION ALL
                
                    SELECT 
                        ai.date_adjusted as txn_date,
                        ai.adjustment_code as ref_no,
                        'Adjustment OUT' as txn_type,
                        'Inventory Adjustment' as description, 
                        aii.product_id,
                        aii.batch_no,
                        aii.exp_date,
                        CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(aii.adjust_qty) as qty_out,
                        ai.date_created
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='OUT' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    AND CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND ai.department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND ai.date_adjusted <= '".$as_of_date."'")."           
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date,ai.adjustment_id
                
                /*Transfer IN*/
                UNION ALL
                
                    SELECT 
                        id.date_issued as txn_date,
                        id.trn_no as ref_no,
                        'Transfer Issuance IN' as txn_type,
                        CONCAT(u.user_fname,' ', u.user_lname) as description,
                        idi.product_id,
                        idi.batch_no,
                        idi.exp_date,
                        CONCAT_WS('-',idi.batch_no,idi.product_id,idi.exp_date)as unq_id,
                        SUM(idi.issue_qty) as qty_in,
                        0 as qty_out,
                        id.date_created
                    FROM issuance_department_items as idi
                    INNER JOIN issuance_department_info as id ON idi.issuance_department_id=id.issuance_department_id
                    LEFT JOIN user_accounts u on u.user_id = id.posted_by_user
                    WHERE id.is_active=TRUE AND id.is_deleted=FALSE
                    AND CONCAT_WS('-',idi.batch_no,idi.product_id,idi.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND id.to_department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND id.date_issued <= '".$as_of_date."'")."          
                    GROUP BY idi.product_id,idi.batch_no,idi.exp_date,id.issuance_department_id
                
                /*Transfer OUT*/
                UNION ALL
                
                    SELECT 
                        id.date_issued as txn_date,
                        id.trn_no as ref_no,
                        'Transfer Issuance OUT' as txn_type,
                        CONCAT(u.user_fname,' ', u.user_lname) as description,
                        idi.product_id,
                        idi.batch_no,
                        idi.exp_date,
                        CONCAT_WS('-',idi.batch_no,idi.product_id,idi.exp_date)as unq_id,
                        0 as qty_in,
                        SUM(idi.issue_qty) as qty_out,
                        id.date_created
                    FROM issuance_department_items as idi
                    INNER JOIN issuance_department_info as id ON idi.issuance_department_id=id.issuance_department_id
                    LEFT JOIN user_accounts u on u.user_id = id.posted_by_user
                    WHERE id.is_active=TRUE AND id.is_deleted=FALSE
                    AND CONCAT_WS('-',idi.batch_no,idi.product_id,idi.exp_date) = '$unq_id'
                    ".($department_id==0?"":" AND id.from_department_id=".$department_id."")."
                    ".($as_of_date==null?"":" AND id.date_issued <= '".$as_of_date."'")."           
                    GROUP BY idi.product_id,idi.batch_no,idi.exp_date,id.issuance_department_id

            ) as main 

            ORDER BY main.txn_date ASC, main.date_created ASC ) as m ";
        return $this->db->query($sql)->result();
    }

    //per expiration inventory report
    function get_all_items_inventory_excel($date,$product_type_id=3,$supplier_id){
        $sql="SELECT main.*,s.supplier_name,rf.product_type FROM (SELECT rc.*,
                p.product_code,
                p.product_desc,
                p.size,
                p.refproduct_id,
                p.supplier_id,
                p.purchase_cost,
                p.sale_price,
                c.category_name,DATE_FORMAT(rc.exp_date,'%m/%d/%Y')as expiration,
                    FORMAT(sale_price,2) as srp
                    ,IFNULL(sinv.out_qty,0) as out_qty,
                    (rc.in_qty-IFNULL(sinv.out_qty,0)-IFNULL(iss.out_qty,0)-IFNULL(aoQ.out_qty,0)) as on_hand_per_batch
                    FROM
                    (
                    SELECT inQ.*,SUM(inQ.receive_qty)as in_qty
                    FROM
                    (SELECT dii.product_id,dii.batch_no,dii.exp_date,
                    CONCAT_WS('-',dii.batch_no,dii.product_id,dii.exp_date)as unq_id,
                    SUM(dii.dr_qty) as receive_qty
                    FROM delivery_invoice_items as dii
                    INNER JOIN delivery_invoice as di
                    ON dii.dr_invoice_id=di.dr_invoice_id
                    WHERE di.is_active=TRUE AND di.is_deleted=FALSE
                    AND di.date_delivered<='$date'
                    GROUP BY dii.product_id,dii.`batch_no`,dii.exp_date

                    UNION ALL

                    SELECT aii.product_id,aii.batch_no,aii.exp_date,
                    CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                    SUM(aii.adjust_qty) as receive_qty
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='IN' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    AND ai.date_adjusted<='$date'
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date) as inQ
                    GROUP By inQ.product_id,inQ.batch_no,inQ.exp_date
                    )as rc


                    LEFT JOIN
                    (SELECT sii.product_id,
                    CONCAT_WS('-',sii.batch_no,sii.product_id,sii.exp_date)as unq_id,
                    SUM(sii.inv_qty) as out_qty
                    FROM sales_invoice_items as sii
                    INNER JOIN sales_invoice as si
                    ON sii.sales_invoice_id=si.sales_invoice_id
                    WHERE si.is_active=TRUE AND si.is_deleted=FALSE
                    AND si.date_invoice<='$date'
                    GROUP BY sii.product_id,sii.batch_no,sii.exp_date) as sinv
                    ON rc.unq_id=sinv.unq_id

                    LEFT JOIN
                    (SELECT iss.product_id,
                    CONCAT_WS('-',iss.batch_no,iss.product_id,iss.exp_date)as unq_id,
                    SUM(iss.issue_qty) as out_qty
                    FROM issuance_items as iss
                    INNER JOIN issuance_info as iin
                    ON iss.issuance_id=iin.issuance_id
                    WHERE iin.date_issued<='$date' AND iin.is_active=TRUE AND iin.is_deleted=FALSE
                    GROUP BY iss.product_id,iss.batch_no,iss.exp_date)as iss
                    ON rc.unq_id=iss.unq_id

                    LEFT JOIN
                    (
                    SELECT aii.product_id,aii.batch_no,aii.exp_date,
                    CONCAT_WS('-',aii.batch_no,aii.product_id,aii.exp_date)as unq_id,
                    SUM(aii.adjust_qty) as out_qty
                    FROM adjustment_items as aii
                    INNER JOIN adjustment_info as ai
                    ON aii.adjustment_id=ai.adjustment_id
                    WHERE ai.adjustment_type='OUT' AND ai.is_active=TRUE AND ai.is_deleted=FALSE
                    AND ai.date_adjusted<='$date'
                    GROUP BY aii.product_id,aii.batch_no,aii.exp_date
                    )as aoQ
                    ON rc.unq_id=aoQ.unq_id
                    LEFT JOIN
                    
                    (SELECT * FROM products where is_deleted = false AND is_active = TRUE
                    ) as p ON rc.product_id=p.product_id
                    LEFT JOIN (SELECT category_id,category_name FROM categories) as c ON p.category_id=c.category_id
                    ORDER BY p.product_desc,exp_date) as main
                    LEFT JOIN (select supplier_id, supplier_name FROM suppliers where is_active = TRUE and is_deleted = FALSE) as s on s.supplier_id=main.supplier_id
                    LEFT JOIN refproduct rf ON rf.refproduct_id = main.refproduct_id
                    WHERE on_hand_per_batch > 0

                    ".($product_type_id==3?"":" AND main.refproduct_id=".$product_type_id)."
                    ".($supplier_id==0?"":" AND main.supplier_id=".$supplier_id)."
                    ";


        return $this->db->query($sql)->result();
    }





}
?>