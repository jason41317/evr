<?php

class Payable_payment_model extends CORE_Model
{
    protected $table = "payable_payments";
    protected $pk_id = "payment_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_payment($payment_id){

        $sql="SELECT 
                pp.payment_id,
                receipt.receipt_type,
                pp.receipt_no,
                d.department_name,
                method.payment_method,
                s.supplier_name,
                pp.date_paid,
                pp.total_paid_amount,
                pp.check_date,
                pp.check_no,
                COALESCE(banks.bank_name,'') as bank_name,
                pp.remarks,
                CONCAT_WS(' ',ua.user_fname,ua.user_mname,ua.user_lname) as posted_by
            FROM
                payable_payments pp
                LEFT JOIN suppliers s ON s.supplier_id = pp.supplier_id
                LEFT JOIN departments d ON d.department_id = pp.department_id
                LEFT JOIN payment_methods method ON method.payment_method_id = pp.payment_method_id
                LEFT JOIN receipt_types receipt ON receipt.receipt_type_id = pp.receipt_type
                LEFT JOIN banks ON banks.bank_id = pp.bank_id
                LEFT JOIN user_accounts ua ON ua.user_id = pp.created_by_user
            WHERE pp.payment_id = ".$payment_id;

        return $this->db->query($sql)->result();

    }

    function get_journal_entries($payment_id){

        $sql="SELECT
                ai.payable_account_id as account_id,
                (
                    SELECT rp.total_paid_amount FROM payable_payments as rp WHERE rp.payment_id=$payment_id
                ) as dr_amount, 0 as cr_amount,'' as memo

                FROM `account_integration` as ai

                UNION ALL

                SELECT

                ai.payment_to_supplier_id as account_id, 0 as dr_amount ,
                (
                    SELECT rp.total_paid_amount FROM payable_payments as rp WHERE rp.payment_id=$payment_id
                ) as cr_amount,'' as memo

                FROM `account_integration` as ai";

        return $this->db->query($sql)->result();
    }


}



?>