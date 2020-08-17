<?php

class Transaction_module_model extends CORE_Model{

    protected  $table="transaction_module"; //table name
    protected  $pk_id="module_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function get_locked_transactions($type_id=0,$start_date=null,$end_date=null,$is_locked=null){
        $sql="SELECT 
				    main.*,
				    DATE_FORMAT(main.invoice_date,'%m/%d/%Y') as invoice_date
				FROM
				    (SELECT 
				        1 AS type_id,
				            di.dr_invoice_id AS invoice_id,
				            di.dr_invoice_no AS invoice_no,
				            s.supplier_name AS particular,
				            d.department_name AS branch,
				            di.external_ref_no AS reference_no,
				            di.date_delivered AS invoice_date,
				            di.remarks
				    FROM
				        delivery_invoice AS di
				    LEFT JOIN suppliers s ON s.supplier_id = di.supplier_id
				    LEFT JOIN departments d ON d.department_id = di.department_id
				    WHERE
				        di.is_active = TRUE
				            AND di.is_deleted = FALSE
				            AND di.date_delivered BETWEEN '$start_date' AND '$end_date'
				            AND di.is_locked = $is_locked UNION ALL SELECT 
				        2 AS type_id,
				            si.sales_invoice_id AS invoice_id,
				            si.sales_inv_no AS invoice_no,
				            c.customer_name AS particular,
				            d.department_name AS branch,
				            so.so_no AS reference_no,
				            si.date_invoice AS invoice_date,
				            si.remarks
				    FROM
				        sales_invoice AS si
				    LEFT JOIN customers c ON c.customer_id = si.customer_id
				    LEFT JOIN departments d ON d.department_id = si.department_id
				    LEFT JOIN sales_order so ON so.sales_order_id = si.sales_order_id
				    WHERE
				        si.is_active = TRUE
				            AND si.is_deleted = FALSE
				            AND si.inv_type = 1
				            AND si.date_invoice BETWEEN '$start_date' AND '$end_date' 
				            AND si.is_locked = $is_locked UNION ALL SELECT 
				        3 AS type_id,
				            si.sales_invoice_id AS invoice_id,
				            si.sales_inv_no AS invoice_no,
				            c.customer_name AS particular,
				            d.department_name AS branch,
				            so.so_no AS reference_no,
				            si.date_invoice AS invoice_date,
				            si.remarks
				    FROM
				        sales_invoice AS si
				    LEFT JOIN customers c ON c.customer_id = si.customer_id
				    LEFT JOIN departments d ON d.department_id = si.department_id
				    LEFT JOIN sales_order so ON so.sales_order_id = si.sales_order_id
				    WHERE
				        si.is_active = TRUE
				            AND si.is_deleted = FALSE
				            AND si.inv_type = 2
				            AND si.date_invoice BETWEEN '$start_date' AND '$end_date' 
				            AND si.is_locked = $is_locked UNION ALL SELECT 
				        4 AS type_id,
				            ai.adjustment_id AS invoice_id,
				            ai.adjustment_code AS invoice_no,
				            '' AS particular,
				            d.department_name AS branch,
				            ai.inv_no AS reference_no,
				            ai.date_adjusted AS invoice_date,
				            ai.remarks
				    FROM
				        adjustment_info AS ai
				    LEFT JOIN departments d ON d.department_id = ai.department_id
				    WHERE
				        ai.is_active = TRUE
				            AND ai.is_deleted = FALSE
				            AND ai.date_adjusted BETWEEN '$start_date' AND '$end_date'
				            AND ai.adjustment_type = 'IN'
				            AND ai.is_locked = $is_locked UNION ALL SELECT 
				        5 AS type_id,
				            ai.adjustment_id AS invoice_id,
				            ai.adjustment_code AS invoice_no,
				            '' AS particular,
				            d.department_name AS branch,
				            ai.inv_no AS reference_no,
				            ai.date_adjusted AS invoice_date,
				            ai.remarks
				    FROM
				        adjustment_info AS ai
				    LEFT JOIN departments d ON d.department_id = ai.department_id
				    WHERE
				        ai.is_active = TRUE
				            AND ai.is_deleted = FALSE
				            AND ai.date_adjusted BETWEEN '$start_date' AND '$end_date'
				            AND ai.adjustment_type = 'OUT'
				            AND ai.is_locked = $is_locked) AS main
				WHERE
				    main.type_id = $type_id";
        return $this->db->query($sql)->result();
    }

    function checkInvoice($table_name,$table_invoice_id,$invoice_id){
    	$sql="SELECT is_locked FROM $table_name WHERE $table_invoice_id = $invoice_id";
        return $this->db->query($sql)->result();
    }
}


?>