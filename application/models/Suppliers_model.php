<?php

class Suppliers_model extends CORE_Model {
    protected  $table="suppliers";
    protected  $pk_id="supplier_id";

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function get_supplier_list($supplier_id=null) {
        $sql="  SELECT
                  a.*,b.photo_path
                FROM
                  suppliers as a
                LEFT JOIN
                    supplier_photos as b
                ON
                  a.supplier_id=b.supplier_id
                WHERE
                    a.is_deleted=FALSE AND a.is_active=TRUE
                ".($supplier_id==null?"":" AND a.supplier_id=$supplier_id")."
            ";
        return $this->db->query($sql)->result();
    }

    //returns list of purchase invoice of supplier that are unpaid
    function get_supplier_payable_list($supplier_id,$start_date,$end_date) {
        $sql="SELECT 
            unp.*,
            IFNULL(pay.dr_payment_amount, 0) AS dr_payment_amount,
            (IFNULL(unp.total_dr_amount, 0) - IFNULL(pay.dr_payment_amount, 0)) AS net_payable
        FROM
            (SELECT
                ji.txn_no,
                ji.journal_id,
                di.dr_invoice_id,
                di.dr_invoice_no,
                di.date_due,
                di.external_ref_no,
                di.remarks,
                di.supplier_id,
                s.supplier_name,
                CONCAT_WS(' ', di.terms, di.duration) AS term_description,
                SUM(ja.cr_amount) AS total_dr_amount
                FROM
                (journal_info ji
                INNER JOIN (SELECT * FROM journal_accounts WHERE account_id = (SELECT payable_account_id FROM account_integration)) ja ON ja.journal_id = ji.journal_id)
                LEFT JOIN suppliers s ON s.supplier_id = ji.supplier_id
                LEFT JOIN delivery_invoice di ON di.journal_id = ji.journal_id
                WHERE
                ji.is_deleted=FALSE
                AND ji.is_active=TRUE
                AND ji.book_type = 'PJE'
                AND ji.supplier_id = $supplier_id
                AND di.date_due BETWEEN '".$start_date."' AND '".$end_date."'
                GROUP BY ji.journal_id) AS unp
                LEFT JOIN
            (SELECT 
                ppl.payment_id,
                    ppl.dr_invoice_id,
                    SUM(ppl.payment_amount) AS dr_payment_amount
            FROM
                (payable_payments_list AS ppl
            INNER JOIN delivery_invoice AS di ON ppl.dr_invoice_id = di.dr_invoice_id)
            INNER JOIN payable_payments AS pp ON ppl.payment_id = pp.payment_id
            WHERE
                pp.is_active = TRUE
                    AND pp.is_deleted = FALSE
                    AND di.is_paid = FALSE
                    AND pp.supplier_id = $supplier_id
            GROUP BY ppl.dr_invoice_id) AS pay ON unp.dr_invoice_id = pay.dr_invoice_id
        HAVING net_payable > 0";
        return $this->db->query($sql)->result();
    }


    function get_current_payable_amount($supplier_id){
        $sql="SELECT IFNULL((SUM(m.total_payable)-SUM(m.total_payment)),0) as net_payable
            FROM
            (SELECT SUM(di.total_after_tax) as total_payable,0 as total_payment FROM delivery_invoice as di
            WHERE di.is_active=TRUE AND di.is_deleted=FALSE AND di.supplier_id=$supplier_id GROUP BY di.supplier_id


            UNION


            SELECT 0 as total_payable,SUM(pp.total_paid_amount) as total_payment FROM payable_payments as pp
            WHERE pp.is_active=TRUE AND pp.is_deleted=FALSE AND pp.supplier_id=$supplier_id GROUP BY pp.supplier_id)as m";

        $result=$this->db->query($sql)->result();

        return (float)($result[0]->net_payable);
    }


    function recalculate_supplier_payable($supplier_id){
        $sql="UPDATE suppliers SET total_payable_amount=".$this->get_current_payable_amount($supplier_id)." WHERE supplier_id=$supplier_id";
        return $this->db->query($sql);
    }



}
?>