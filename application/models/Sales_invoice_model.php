<?php

class Sales_invoice_model extends CORE_Model
{
    protected $table = "sales_invoice";
    protected $pk_id = "sales_invoice_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_journal_entries($sales_invoice_id){
        $sql="SELECT main.* FROM(SELECT
            p.income_account_id as account_id,
            '' as memo,
            SUM(sii.inv_non_tax_amount) cr_amount,
            0 as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            GROUP BY p.income_account_id

            UNION ALL


            SELECT output_tax.account_id,output_tax.memo,
            SUM(output_tax.cr_amount)as cr_amount,0 as dr_amount
             FROM
            (SELECT sii.product_id,

            (SELECT output_tax_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            SUM(sii.inv_tax_amount) as cr_amount,
            0 as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            )as output_tax GROUP BY output_tax.account_id

            UNION ALL

            SELECT acc_receivable.account_id,acc_receivable.memo,
            0 as cr_amount,SUM(acc_receivable.dr_amount) as dr_amount
             FROM
            (SELECT sii.product_id,

            (SELECT receivable_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 cr_amount,
            SUM(sii.inv_line_total_price) as dr_amount

            FROM `sales_invoice_items` as sii
            INNER JOIN products as p ON sii.product_id=p.product_id
            WHERE sii.sales_invoice_id=$sales_invoice_id AND p.income_account_id>0
            ) as acc_receivable GROUP BY acc_receivable.account_id)as main WHERE main.dr_amount>0 OR main.cr_amount>0";

        return $this->db->query($sql)->result();
    }

    function get_sales_summary($start=null,$end=null){ // ORIGINAL SALES SUMMARY  05-28-2020 -> SEARCH FOR get_sales_summary_2020 for the revised one. Sales return module was added there.
        $sql="SELECT mQ.*,DATE_FORMAT(mQ.date_invoice,'%m/%d/%Y') as inv_date,(mQ.sales-mQ.cost_of_sales) as net_profit
                FROM
                (

                SELECT nQ.*,
                (

                    IF(
                        nQ.inv_price=0,
                        nQ.purchase_cost*nQ.fg, /**change @ 3/8/2017 even if it is free, show the cost when it was invoice**/
                        nQ.purchase_cost*nQ.inv_qty
                    )

                )as cost_of_sales

                FROM
                (SELECT si.sales_inv_no,si.date_invoice,sii.inv_price, CONCAT(sp.firstname, ' ', sp.lastname, ' - ', sp.acr_name) AS salesperson_name,
                '' as dr_si,'' as vr,c.customer_name,
                IF(sii.inv_price=0,CONCAT(pr.product_desc,' (Free)'),pr.product_desc)as product_desc,
                refp.product_type,

                IF(sii.inv_price=0,0,SUM(sii.inv_qty))as inv_qty,

                IF(sii.inv_price=0,SUM(sii.inv_qty),0) as fg, /**this free item**/

                pr.size,
                s.supplier_name,sii.inv_price as srp,
                IFNULL(SUM(sii.inv_line_total_price),0) as sales,

                IF(sii.inv_price=0,
                  sii.cost_upon_invoice, /**change @ 3/8/2017 even if it is free, show the cost when it was invoice**/
                  sii.cost_upon_invoice
                )as purchase_cost /**GET THE COST OF THE PRODUCT WHEN IT WAS INVOICED**/



                FROM sales_invoice as si

                LEFT JOIN customers as c ON si.customer_id=c.customer_id
                INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
                LEFT JOIN (products as pr  LEFT JOIN refproduct as refp ON refp.refproduct_id=pr.refproduct_id)ON sii.product_id=pr.product_id
                LEFT JOIN suppliers as s ON pr.supplier_id=s.supplier_id
                LEFT JOIN salesperson as sp ON sp.salesperson_id=si.salesperson_id

                WHERE si.date_invoice BETWEEN '$start' AND '$end' AND si.is_active=TRUE AND si.is_deleted=FALSE

                GROUP BY si.sales_inv_no,sii.product_id,sii.inv_price,IF(sii.inv_price=0,
                  0,
                  sii.cost_upon_invoice
                ))as nQ) mQ
                ";

            return $this->db->query($sql)->result();
    }


    function get_sales_summary_2020($start=null,$end=null){// REVISED SALES SUMMARY  05-28-2020 -> SEARCH FOR get_sales_summary for the original one. Sales return module was added here.
        $sql="SELECT mQ.*,DATE_FORMAT(mQ.date_invoice,'%m/%d/%Y') as inv_date,(mQ.sales-mQ.cost_of_sales) as net_profit
                FROM
                (

                SELECT nQ.*,
                (

                    IF(
                        nQ.inv_price=0,
                        nQ.purchase_cost*nQ.fg, /**change @ 3/8/2017 even if it is free, show the cost when it was invoice**/
                        nQ.purchase_cost*nQ.inv_qty
                    )

                )as cost_of_sales

                FROM
                (SELECT si.sales_inv_no,si.date_invoice,sii.inv_price, CONCAT(sp.firstname, ' ', sp.lastname, ' - ', sp.acr_name) AS salesperson_name,

                (CASE 
                    WHEN isnull(si.date_delivered) 
                    THEN ''
                    ELSE DATE_FORMAT(si.date_delivered,'%m/%d/%Y')
                END) as date_delivered,

                '' as dr_si,'' as vr,c.customer_name,
                IF(sii.inv_price=0,CONCAT(pr.product_desc,' (Free)'),pr.product_desc)as product_desc,
                refp.product_type,
                IF(sii.inv_price=0,0,SUM(sii.inv_qty) - IFNULL(returns.return_qty,0) )as inv_qty,
                IF(IFNULL(returns.return_qty,0) =0, '', 'Yes') as with_returns,
                returns.return_invoices,
                IF(sii.inv_price=0,SUM(sii.inv_qty) - IFNULL(returns.return_qty,0) ,0) as fg, /**this free item**/

                pr.size,
                s.supplier_name,sii.inv_price as srp,
                IFNULL(SUM(sii.inv_line_total_price) - IFNULL(returns.return_line_total_price,0) ,0) as sales,
                IFNULL(SUM(sii.inv_tax_amount) - IFNULL(returns.return_tax_amount,0) ,0) as tax_amount,
                IFNULL(SUM(sii.inv_non_tax_amount) - IFNULL(returns.return_non_tax_amount,0) ,0) as non_tax_amount,

                IF(sii.inv_price=0,
                  sii.cost_upon_invoice, /**change @ 3/8/2017 even if it is free, show the cost when it was invoice**/
                  sii.cost_upon_invoice
                )as purchase_cost /**GET THE COST OF THE PRODUCT WHEN IT WAS INVOICED**/



                FROM sales_invoice as si

                LEFT JOIN customers as c ON si.customer_id=c.customer_id
                INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
                LEFT JOIN (products as pr  LEFT JOIN refproduct as refp ON refp.refproduct_id=pr.refproduct_id)ON sii.product_id=pr.product_id
                LEFT JOIN suppliers as s ON pr.supplier_id=s.supplier_id
                LEFT JOIN salesperson as sp ON sp.salesperson_id=si.salesperson_id
                LEFT JOIN (
                SELECT 
                    ai.inv_no,
                    group_concat(DISTINCT(ai.adjustment_code)) as return_invoices,
                    aii.product_id, 
                    aii.adjust_price,
                    SUM(aii.adjust_qty) as return_qty,
                    SUM(aii.adjust_line_total_price) return_line_total_price,
                    SUM(aii.adjust_tax_amount) return_tax_amount,
                    SUM(aii.adjust_non_tax_amount) return_non_tax_amount

                    FROM adjustment_items aii 
                    LEFT JOIN adjustment_info ai ON ai.adjustment_id = aii.adjustment_id  

                    WHERE ai.is_returns = TRUE
                    AND ai.is_deleted = FALSE AND ai.is_active = TRUE
                    GROUP BY ai.inv_no, aii.product_id , aii.adjust_price
                
                ) as returns ON returns.inv_no = si.sales_inv_no AND returns.product_id = sii.product_id AND returns.adjust_price = sii.inv_price
                
                WHERE si.date_invoice BETWEEN '$start' AND '$end' AND si.is_active=TRUE AND si.is_deleted=FALSE

                GROUP BY si.sales_inv_no,sii.product_id,sii.inv_price,IF(sii.inv_price=0,
                  0,
                  sii.cost_upon_invoice
                ))as nQ) mQ



            ";

            return $this->db->query($sql)->result();
    }

    function get_customers_sales_summary($start=null,$end=null,$customer_id=null){
        $sql="SELECT n.* FROM(          
            SELECT main_sales.sales_invoice_id,
            main_sales.sales_inv_no,main_sales.customer_id,main_sales.customer_name,'SI' as type,main_sales.address,main_sales.contact_no,main_sales.email_address, 
            (IFNULL(main_sales.inv_line_total_price,0) - IFNULL(returns_sales.return_line_total_price,0)) as total_amount_invoice FROM 
            
            (SELECT si.sales_invoice_id,
            si.sales_inv_no,si.customer_id,c.customer_name,'SI' as type,c.address,c.contact_no,c.email_address,
            SUM(sii.inv_line_total_price)as inv_line_total_price

            FROM (sales_invoice as si
            LEFT JOIN customers as c ON c.customer_id=si.customer_id)
            INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
            WHERE si.is_active=TRUE AND si.is_deleted=FALSE
            AND si.date_invoice BETWEEN '$start' AND '$end' AND si.inv_type=1
            GROUP BY si.customer_id) main_sales
            
            LEFT JOIN 

            (SELECT si.customer_id,
            SUM(aii.adjust_line_total_price) as return_line_total_price 
            FROM  adjustment_items aii 
                LEFT JOIN adjustment_info ai ON ai.adjustment_id  =aii.adjustment_id  
                LEFT JOIN sales_invoice si On si.sales_inv_no = ai.inv_no
                WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE AND ai.is_returns = TRUE
                AND  si.is_active = TRUE AND si.is_deleted = FALSE AND
                si.date_invoice BETWEEN '$start' AND '$end' AND si.inv_type=1
                GROUP BY si.customer_id
            ) as returns_sales ON main_sales.customer_id= returns_sales.customer_id
           


            UNION ALL



            SELECT 
            main_sales_other.sales_invoice_id,
            main_sales_other.sales_inv_no,main_sales_other.customer_id,
            main_sales_other.customer_name, 'DR' as type,'' as address,'' as contact_no,'' as email_address,
            (IFNULL(main_sales_other.inv_line_total_price,0) - IFNULL(returns_sales_other.return_line_total_price,0)) as total_amount_invoice
            
            FROM (SELECT si.sales_invoice_id,
            si.sales_inv_no,d.department_id as customer_id,
            CONCAT(d.department_name,' (DR)') as customer_name,'DR' as type,'' as address,'' as contact_no,'' as email_address,
            SUM(sii.inv_line_total_price)as inv_line_total_price

            FROM (sales_invoice as si
            LEFT JOIN departments as d ON d.department_id=si.issue_to_department)
            INNER JOIN sales_invoice_items as sii ON si.sales_invoice_id=sii.sales_invoice_id
            WHERE si.is_active=TRUE AND si.is_deleted=FALSE
            AND si.date_invoice BETWEEN '$start' AND '$end' AND si.inv_type=2
            GROUP BY si.issue_to_department) as main_sales_other
            
            LEFT JOIN
       
            (SELECT si.issue_to_department as customer_id,
            SUM(aii.adjust_line_total_price) as return_line_total_price 
            FROM  adjustment_items aii 
                LEFT JOIN adjustment_info ai ON ai.adjustment_id  =aii.adjustment_id  
                LEFT JOIN sales_invoice si On si.sales_inv_no = ai.inv_no
                WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE AND ai.is_returns = TRUE
                AND  si.is_active = TRUE AND si.is_deleted = FALSE AND
                si.date_invoice BETWEEN '$start' AND '$end' AND si.inv_type=2
                GROUP BY si.issue_to_department
            ) as returns_sales_other ON returns_sales_other.customer_id= main_sales_other.customer_id


            ) as n ".($customer_id == 'all' || $customer_id == null ? 'ORDER By n.customer_name' : 'WHERE n.customer_id='."'".$customer_id."'");
        return $this->db->query($sql)->result();
    }

    function get_report_summary($startDate=null,$endDate=null,$customer_id=null){
            $sql="SELECT 
                    n.*
                FROM
                (SELECT 
                    si.sales_invoice_id,
                        si.sales_inv_no,
                        si.customer_id,
                        si.date_invoice,
                        si.remarks,
                        c.customer_name,
                        'SI' AS type,
                        c.address,
                        c.contact_no,
                        c.email_address,
                        SUM(sii.inv_line_total_price) AS total_after_tax
                FROM
                    (sales_invoice AS si
                LEFT JOIN customers AS c ON c.customer_id = si.customer_id)
                INNER JOIN sales_invoice_items AS sii ON si.sales_invoice_id = sii.sales_invoice_id
                WHERE
                    si.is_active = TRUE
                        AND si.is_deleted = FALSE
                        AND si.date_invoice BETWEEN '$startDate' AND '$endDate'
                        AND si.inv_type = 1
                GROUP BY si.customer_id 
                
            UNION ALL
                
                SELECT 
                    si.sales_invoice_id,
                        si.sales_inv_no,
                        d.department_id AS customer_id,
                        si.date_invoice,
                        si.remarks,
                        CONCAT(d.department_name, ' (DR)') AS customer_name,
                        'DR' AS type,
                        '' AS address,
                        '' AS contact_no,
                        '' AS email_address,
                        SUM(sii.inv_line_total_price) AS total_after_tax
                FROM
                    (sales_invoice AS si
                LEFT JOIN departments AS d ON d.department_id = si.issue_to_department)
                INNER JOIN sales_invoice_items AS sii ON si.sales_invoice_id = sii.sales_invoice_id
                WHERE
                    si.is_active = TRUE
                        AND si.is_deleted = FALSE
                        AND si.date_invoice BETWEEN '$startDate' AND '$endDate'
                        AND si.inv_type = 2
                GROUP BY si.department_id) AS n ".($customer_id == 'all' || $customer_id == null ? 'ORDER By n.customer_name' : 'WHERE n.customer_id='."'".$customer_id."'");

        return $this->db->query($sql)->result();
    }

    function get_salesperson_report_summary($start=null,$end=null,$salesperson_id=null){
        $sql="SELECT 
            si.salesperson_id,
            si.sales_invoice_id,
            si.sales_inv_no,
            CONCAT(sp.firstname, ' ', sp.lastname) AS salesperson_name,
            si.date_invoice as date_invoice,
            si.remarks,
            sii.inv_line_total_price AS total_amount_invoice
        FROM
            (sales_invoice AS si
            INNER JOIN salesperson AS sp ON sp.salesperson_id = si.salesperson_id)
                INNER JOIN
            sales_invoice_items AS sii ON sii.sales_invoice_id = si.sales_invoice_id
        WHERE
            si.is_active = TRUE
                AND si.is_deleted = FALSE
                AND si.date_invoice BETWEEN '$start' AND '$end' ".($salesperson_id == 'all' || $salesperson_id == null ? '' : 'AND sp.salesperson_id='."'".$salesperson_id."'")."
                
                
        UNION ALL
        
        SELECT si.salesperson_id,
            si.sales_invoice_id,
            CONCAT(ai.adjustment_code, ' (', si.sales_inv_no,')') as sales_inv_no,
            CONCAT(sp.firstname, ' ', sp.lastname) AS salesperson_name,
            ai.date_adjusted as date_invoice,
            si.remarks,
            (aii.adjust_line_total_price * -1) as total_amount_invoice 
            FROM  adjustment_items aii 
                LEFT JOIN adjustment_info ai ON ai.adjustment_id  =aii.adjustment_id  
                LEFT JOIN sales_invoice si On si.sales_inv_no = ai.inv_no
                LEFT JOIN salesperson AS sp ON sp.salesperson_id = si.salesperson_id
                WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE AND ai.is_returns = TRUE
                AND  si.is_active = TRUE AND si.is_deleted = FALSE AND
                si.date_invoice BETWEEN '$start' AND '$end'  AND si.inv_type = 1   ".($salesperson_id == 'all' || $salesperson_id == null ? '' : 'AND sp.salesperson_id='."'".$salesperson_id."'")."     
        

         ORDER BY salesperson_id";

        return $this->db->query($sql)->result();
    }

    function get_salesperson_sales_summary($start=null,$end=null,$salesperson_id,$refproduct_id=null,$supplier_id=null){
        $sql="SELECT
            main_sales.salesperson_id,
            main_sales.sales_invoice_id,
            main_sales.sales_inv_no,
            main_sales.salesperson_name,
            IFNULL(main_sales.inv_line_total_price,0) - IFNULL(main_returns.return_line_total_price,0) as total_amount_invoice FROM (SELECT 
            si.salesperson_id,
            si.sales_invoice_id,
            si.sales_inv_no,
            CONCAT(sp.firstname, ' ', sp.lastname) AS salesperson_name,
            SUM(sii.inv_line_total_price) AS inv_line_total_price
        FROM
            (sales_invoice AS si
            INNER JOIN salesperson AS sp ON sp.salesperson_id = si.salesperson_id)
                INNER JOIN
            sales_invoice_items AS sii ON sii.sales_invoice_id = si.sales_invoice_id
            INNER JOIN products AS p ON p.product_id = sii.product_id
        WHERE
            si.is_active = TRUE
            ".($refproduct_id == 'all' || $refproduct_id == null ? '' : 'AND p.refproduct_id='."'".$refproduct_id."'")."
            ".($supplier_id == 'all' || $supplier_id == null ? '' : 'AND p.supplier_id='."'".$supplier_id."'")."
                AND si.is_deleted = FALSE
                AND si.date_invoice BETWEEN '$start' AND '$end' ".($salesperson_id == 'all' || $salesperson_id == null ? '' : 'AND sp.salesperson_id='."'".$salesperson_id."'")."
        GROUP BY si.salesperson_id) as main_sales
        
        LEFT JOIN 
        (SELECT si.salesperson_id,
            SUM(aii.adjust_line_total_price) as return_line_total_price 
            FROM  adjustment_items aii 
                LEFT JOIN adjustment_info ai ON ai.adjustment_id  =aii.adjustment_id  
                LEFT JOIN sales_invoice si On si.sales_inv_no = ai.inv_no
                LEFT JOIN products p ON p.product_id = aii.product_id
                WHERE ai.is_active = TRUE AND ai.is_deleted = FALSE AND ai.is_returns = TRUE
                AND  si.is_active = TRUE AND si.is_deleted = FALSE
                ".($refproduct_id == 'all' || $refproduct_id == null ? '' : 'AND p.refproduct_id='."'".$refproduct_id."'")."
                ".($supplier_id == 'all' || $supplier_id == null ? '' : 'AND p.supplier_id='."'".$supplier_id."'")."
                AND si.date_invoice BETWEEN '$start' AND '$end' AND si.inv_type = 1 ".($salesperson_id == 'all' || $salesperson_id == null ? '' : 'AND si.salesperson_id='."'".$salesperson_id."'")."
                GROUP BY si.salesperson_id) as main_returns on main_returns.salesperson_id = main_sales.salesperson_id

         ";
        return $this->db->query($sql)->result();
    }


}


?>