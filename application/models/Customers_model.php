<?php

class Customers_model extends CORE_Model{

    protected  $table="customers"; //table name
    protected  $pk_id="customer_id"; //primary key id



    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_customer_list_for_sales_report(){
        $sql="SELECT 
            customer_id,
            customer_name
        FROM
            customers
        WHERE
            is_deleted = FALSE AND is_active = TRUE AND customer_id != 1969

        UNION 

        SELECT 
            CONCAT(department_id, '(DR)') AS customer_id,
            CONCAT(department_name, ' (DR)') AS customer_name
        FROM
            departments
        WHERE
            is_deleted = FALSE AND is_active = TRUE AND department_id != 1";

        return $this->db->query($sql)->result();
    }

    function get_customer_list($customer_id=null){
        $sql="  SELECT
                  a.*,b.photo_path
                FROM
                  customers as a
                LEFT JOIN
                    customer_photos as b
                ON
                  a.customer_id=b.customer_id
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($customer_id==null?"":" AND a.customer_id=$customer_id")."
            ";
        return $this->db->query($sql)->result();
    }

    //returns list of sales invoice of customer that are unpaid
    // function get_customer_receivable_list($customer_id,$start_date,$end_date,$filter_accounts,$department_id=0) {
    //     $sql="SELECT 
    //             unp.*,
    //             IFNULL(pay.sales_payment_amount, 0) AS sales_payment_amount,
    //             (IFNULL(unp.total_sales_amount, 0) - IFNULL(pay.sales_payment_amount, 0)) AS net_receivable
    //         FROM
    //             (SELECT 
    //                     ji.txn_no,
    //                     ji.journal_id,
    //                     si.sales_invoice_id,
    //                     si.sales_inv_no,
    //                     si.date_due,
    //                     si.remarks,
    //                     si.customer_id,
    //                     c.customer_name,
    //                     jaccounts.total_sales_amount
    //                 FROM
    //                     (journal_info ji
    //                     INNER JOIN (SELECT 
    //                         ja.journal_id,
    //                         SUM(ja.dr_amount) as total_sales_amount
    //                     FROM
    //                         journal_accounts ja
    //                     WHERE
    //                         ja.account_id IN ($filter_accounts)) jaccounts ON jaccounts.journal_id = ji.journal_id)
    //                         LEFT JOIN
    //                     customers c ON c.customer_id = ji.customer_id
    //                         LEFT JOIN
    //                     sales_invoice si ON si.journal_id = ji.journal_id
    //                 WHERE
    //                     ji.is_deleted = FALSE
    //                         AND ji.is_active = TRUE
    //                         AND ji.book_type = 'SJE'
    //                         AND ji.customer_id = $customer_id
    //                         AND si.date_due BETWEEN '".$start_date."' AND '".$end_date."'
    //                         ".($department_id==0?"":" AND si.department_id=$department_id")."

    //                 GROUP BY ji.journal_id) AS unp

    //                 LEFT JOIN
    //             (SELECT 
    //                 rpl.payment_id,
    //                     rpl.sales_invoice_id,
    //                     SUM(rpl.payment_amount) AS sales_payment_amount
    //             FROM
    //                 (receivable_payments_list AS rpl
    //             INNER JOIN sales_invoice AS si ON rpl.sales_invoice_id = si.sales_invoice_id)
    //             INNER JOIN receivable_payments AS rp ON rpl.payment_id = rp.payment_id
    //             WHERE
    //                 rp.is_active = TRUE
    //                     AND rp.is_deleted = FALSE
    //                     AND si.is_paid = FALSE
    //                     AND rp.customer_id = $customer_id
    //             GROUP BY rpl.sales_invoice_id) AS pay ON unp.sales_invoice_id = pay.sales_invoice_id
    //         HAVING net_receivable > 0";
                
    //     return $this->db->query($sql)->result();
    // }

    function get_customer_receivable_list($customer_id,$start_date,$end_date,$department_id=0) {
        $sql="SELECT unp.*,IFNULL(pay.sales_payment_amount,0) as sales_payment_amount,
                (IFNULL(unp.total_sales_amount,0)-IFNULL(pay.sales_payment_amount,0))as net_receivable
                FROM
                (SELECT si.sales_invoice_id,si.sales_inv_no,date_due,si.remarks,si.customer_id,s.customer_name,
                (si.total_after_tax)As total_sales_amount
                FROM (sales_invoice as si
                LEFT JOIN customers as s ON si.customer_id=s.customer_id)
                WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.is_paid=FALSE
                AND si.customer_id=$customer_id
                AND si.date_due BETWEEN '".$start_date."' AND '".$end_date."'
                ".($department_id==0?"":" AND si.department_id=$department_id")."
                )as unp

                LEFT JOIN

                (SELECT rpl.payment_id,rpl.sales_invoice_id,
                SUM(rpl.payment_amount)as sales_payment_amount
                FROM (receivable_payments_list as rpl
                INNER JOIN sales_invoice as si ON rpl.sales_invoice_id=si.sales_invoice_id)
                INNER JOIN receivable_payments as rp ON rpl.payment_id=rp.payment_id
                WHERE rp.is_active=TRUE AND rp.is_deleted=FALSE AND si.is_paid=FALSE
                AND rp.customer_id=$customer_id
                GROUP BY rpl.sales_invoice_id
                )As pay

                ON unp.sales_invoice_id=pay.sales_invoice_id HAVING net_receivable>0";
                
        return $this->db->query($sql)->result();
    }

    function get_current_receivable_amount($customer_id){
        $sql="SELECT IFNULL((SUM(m.total_receivable)-SUM(m.total_payment)),0) as net_receivable
            FROM
            (SELECT SUM(si.total_after_tax) as total_receivable,0 as total_payment FROM sales_invoice as si
            WHERE si.is_active=TRUE AND si.is_deleted=FALSE AND si.customer_id=$customer_id GROUP BY si.customer_id

            UNION

            SELECT 0 as total_receivable,SUM(rp.total_paid_amount) as total_payment FROM receivable_payments as rp
            WHERE rp.is_active=TRUE AND rp.is_deleted=FALSE AND rp.customer_id=$customer_id GROUP BY rp.customer_id)as m";


        $result=$this->db->query($sql)->result();
        return (float)($result[0]->net_receivable);

    }


    function recalculate_customer_receivable($customer_id){
        $sql="UPDATE customers SET total_receivable_amount=".$this->get_current_receivable_amount($customer_id)." WHERE customer_id=$customer_id";
        return $this->db->query($sql);
    }




}




?>