<?php

class Adjustment_item_model extends CORE_Model {
    protected  $table="adjustment_items";
    protected  $pk_id="adjustment_item_id";
    protected  $fk_id="adjustment_id";

    function __construct() {
        parent::__construct();
    }


    public function per_product($type, $from, $to) {
        $sql = "SELECT 
            ai.adjustment_code,
            d.department_name,
            IF(ai.adjustment_type = 'IN', IF(ai.is_returns = 1, 'Sales Return', 'IN'), 
                CASE 
                    WHEN inv_type_id = 1 THEN 'Sales Return'
                    WHEN inv_type_id = 2 THEN 'Sales Return'
                    WHEN inv_type_id = 3 THEN 'Purchase Return'
                    ELSE ai.adjustment_type
                END) as adjustment_type,
            ai.date_adjusted,
            p.product_desc,
            rp.product_type,
            aii.adjust_qty,
            u.unit_name,
            aii.exp_date,
            aii.batch_no,
            aii.adjust_price,
            aii.adjust_line_total_price,
            ai.remarks
        FROM
            adjustment_items aii
                LEFT JOIN
            adjustment_info ai ON ai.adjustment_id = aii.adjustment_id
                LEFT JOIN
            products p ON p.product_id = aii.product_id
                LEFT JOIN
            suppliers s ON s.supplier_id = p.supplier_id
                LEFT JOIN
            units u ON u.unit_id = aii.unit_id
                LEFT JOIN
            refproduct rp ON rp.refproduct_id = p.refproduct_id
                LEFT JOIN
            departments d ON d.department_id = ai.department_id
        WHERE
            ai.adjustment_type = '$type' AND 
            ai.is_deleted = 0 AND 
            ai.is_active = 1 AND 
            DATE(ai.date_adjusted) BETWEEN '$from' AND '$to'";
        return $this->db->query($sql)->result();
    }

}



?>