<?php

class Payable_payment_list_model extends CORE_Model
{
    protected $table = "payable_payments_list";
    protected $pk_id = "payment_list_id";

    function __construct()
    {
        parent::__construct();
    }

    function get_invoices($payment_id){

        $sql="SELECT 
		    dr.dr_invoice_no,
		    dr.date_due,
		    dr.terms,
		    dr.external_ref_no,
		    dr.remarks,
		    ppl.payment_amount
		FROM
		    payable_payments_list ppl
		    LEFT JOIN delivery_invoice dr ON dr.dr_invoice_id = ppl.dr_invoice_id
		    WHERE ppl.payment_id = ".$payment_id;

        return $this->db->query($sql)->result();

    }

}



?>