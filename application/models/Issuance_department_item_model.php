<?php

class Issuance_department_item_model extends CORE_Model {
    protected  $table="issuance_department_items";
    protected  $pk_id="issuance_department_item_id";
    protected  $fk_id="issuance_department_id";

    function __construct() {
        parent::__construct();
    }

    function per_product($from, $to) {
        $sql = "SELECT 
            id.trn_no,
            td.department_name AS to_department,
            fd.department_name AS from_department,
            id.date_issued,
            p.product_desc,
            rp.product_type,
            idi.issue_qty,
            u.unit_name,
            idi.exp_date,
            idi.batch_no,
            idi.issue_price,
            idi.issue_line_total_price,
            id.remarks
        FROM
            issuance_department_items idi
                LEFT JOIN
            issuance_department_info id ON id.issuance_department_id = idi.issuance_department_id
                LEFT JOIN
            products p ON p.product_id = idi.product_id
                LEFT JOIN
            suppliers s ON s.supplier_id = p.supplier_id
                LEFT JOIN
            units u ON u.unit_id = idi.unit_id
                LEFT JOIN
            refproduct rp ON rp.refproduct_id = p.refproduct_id
                LEFT JOIN
            departments td ON td.department_id = id.to_department_id
                LEFT JOIN
            departments fd ON fd.department_id = id.from_department_id
        WHERE id.is_deleted = 0 AND id.is_active = 1 AND DATE(id.date_issued) BETWEEN '$from' AND '$to'";
        return $this->db->query($sql)->result();
    }

}



?>