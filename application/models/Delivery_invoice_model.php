<?php

class Delivery_invoice_model extends CORE_Model {
    protected  $table="delivery_invoice";
    protected  $pk_id="dr_invoice_id";

    function __construct() {
        parent::__construct();
    }

    function check_product($product_id,$exp_date,$batch_no,$dr_invoice_id=null){
        $sql="SELECT 
                    di.dr_invoice_no,
                    p.product_desc,
                    DATE_FORMAT(dii.exp_date,'%m/%d/%Y') as exp_date,
                    dii.batch_no
                FROM
                delivery_invoice_items dii
                    LEFT JOIN
                delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
                    LEFT JOIN
                products p ON p.product_id = dii.product_id
                WHERE di.is_deleted = FALSE
                AND di.is_active = TRUE
                AND dii.product_id = $product_id
                AND dii.exp_date = '".$exp_date."'
                AND dii.batch_no = '".$batch_no."' 
                ". ($dr_invoice_id==null ? '' : 'AND di.dr_invoice_id!='.$dr_invoice_id.'')." 
                ";
        return $this->db->query($sql)->result();
    }

    function get_report_summary($refproduct_id=null,$startDate,$endDate){
        $sql="SELECT 
            x.external_ref_no AS invoice_number_of_supplier,
            x.*
            FROM (SELECT
            s.supplier_id,
            s.supplier_name,
            di.date_delivered,
            di.external_ref_no,
            di.total_after_tax,
            tt.tax_type,
            rp.product_type
            FROM 
            delivery_invoice AS di
            LEFT JOIN suppliers AS s ON s.supplier_id = di.supplier_id
            LEFT JOIN tax_types AS tt ON tt.tax_type_id = di.tax_type_id
            INNER JOIN delivery_invoice_items AS dii ON dii.`dr_invoice_id`=di.`dr_invoice_id`
            LEFT JOIN products AS p ON p.`product_id`=dii.product_id
            LEFT JOIN refproduct AS rp ON rp.`refproduct_id`=p.`refproduct_id`
            WHERE date_delivered BETWEEN '$startDate' AND '$endDate' ". ($refproduct_id==3 ? '' : 'AND rp.refproduct_id='.$refproduct_id.'')." AND di.is_active=TRUE AND di.is_deleted=FALSE
            GROUP BY di.dr_invoice_id
            ORDER BY di.date_delivered,di.dr_invoice_id ASC) AS x";

        return $this->db->query($sql)->result();
    }

    function get_report_detailed($refproduct_id=null,$startDate,$endDate){
        $sql="SELECT
            rp.*,
            di.*,
            s.*,
            p.product_desc,
            p.`purchase_cost`,
            dii.`dr_qty`,
            dii.*,
            dr_line_total_price AS total_amount,
            rp.*
            FROM 
            delivery_invoice AS di
            LEFT JOIN suppliers AS s ON s.supplier_id = di.`supplier_id`
            INNER JOIN delivery_invoice_items AS dii ON dii.`dr_invoice_id`=di.`dr_invoice_id`
            LEFT JOIN products AS p ON p.`product_id`=dii.`product_id`
            LEFT JOIN refproduct AS rp ON rp.refproduct_id=p.refproduct_id
            WHERE date_delivered BETWEEN '$startDate' AND '$endDate' ". ($refproduct_id==3 ? '' : 'AND rp.refproduct_id='.$refproduct_id.'')." AND di.is_active=TRUE AND di.is_deleted=FALSE
            ORDER BY di.date_delivered,di.dr_invoice_id ASC";

        return $this->db->query($sql)->result();
    }


    function get_journal_entries($purchase_invoice_id){
        $sql="SELECT main.* FROM(SELECT
            p.expense_account_id as account_id,
            '' as memo,
            SUM(dii.dr_non_tax_amount) dr_amount,
            0 as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            GROUP BY p.expense_account_id

            UNION ALL


            SELECT input_tax.account_id,input_tax.memo,
            SUM(input_tax.dr_amount)as dr_amount,0 as cr_amount

             FROM
            (SELECT dii.product_id,

            (SELECT input_tax_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            SUM(dii.dr_tax_amount) as dr_amount,
            0 as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            )as input_tax GROUP BY input_tax.account_id

            UNION ALL

            SELECT acc_payable.account_id,acc_payable.memo,
            0 as dr_amount,SUM(acc_payable.cr_amount) as cr_amount
             FROM
            (SELECT dii.product_id,

            (SELECT payable_account_id FROM account_integration) as account_id
            ,
            '' as memo,
            0 dr_amount,
            SUM(dii.dr_line_total_price) as cr_amount

            FROM `delivery_invoice_items` as dii
            INNER JOIN products as p ON dii.product_id=p.product_id
            WHERE dii.dr_invoice_id=$purchase_invoice_id AND p.expense_account_id>0
            ) as acc_payable GROUP BY acc_payable.account_id)as main WHERE main.dr_amount>0 OR main.cr_amount>0";

        return $this->db->query($sql)->result();

    }

    // function get_journal_entries($purchase_invoice_id){
    //     $sql="SELECT 
    //             main.*
    //         FROM
    //             (SELECT 
    //                 p.expense_account_id AS account_id,
    //                     '' AS memo,
    //                     SUM(dii.dr_non_tax_amount) dr_amount,
    //                     0 AS cr_amount
    //             FROM
    //                 `delivery_invoice_items` AS dii
    //             INNER JOIN products AS p ON dii.product_id = p.product_id
    //             WHERE
    //                 dii.dr_invoice_id = $purchase_invoice_id
    //                     AND p.expense_account_id > 0
    //             GROUP BY p.expense_account_id 
                
    //             UNION ALL 
                
    //             SELECT 
    //                 input_tax.account_id,
    //                     input_tax.memo,
    //                     SUM(input_tax.dr_amount) AS dr_amount,
    //                     0 AS cr_amount
    //             FROM
    //                 (SELECT 
    //                 dii.product_id,
    //                     (SELECT input_tax_account_id FROM account_integration) AS account_id,
    //                     '' AS memo,
    //                     SUM(dii.dr_tax_amount) AS dr_amount,
    //                     0 AS cr_amount
    //             FROM
    //                 `delivery_invoice_items` AS dii
    //             INNER JOIN products AS p ON dii.product_id = p.product_id
    //             WHERE
    //                 dii.dr_invoice_id = $purchase_invoice_id
    //                     AND p.expense_account_id > 0) AS input_tax
    //             GROUP BY input_tax.account_id 
                
    //             UNION ALL 
                
    //             SELECT 
    //                 acc_payable.account_id,
    //                     acc_payable.memo,
    //                     0 AS dr_amount,
    //                     SUM(acc_payable.cr_amount) AS cr_amount
    //             FROM
    //                 (SELECT 
    //                 dii.product_id,
    //                     (SELECT 
    //                             payable_account_id
    //                         FROM
    //                             account_integration) AS account_id,
    //                     '' AS memo,
    //                     0 dr_amount,
    //                     SUM(dii.dr_line_total_price) AS cr_amount
    //             FROM
    //                 `delivery_invoice_items` AS dii
    //             INNER JOIN products AS p ON dii.product_id = p.product_id
    //             WHERE
    //                 dii.dr_invoice_id = $purchase_invoice_id
    //                     AND p.expense_account_id > 0) AS acc_payable
    //             GROUP BY acc_payable.account_id
                
    //             UNION ALL
                
    //            -- SELECT 
    //            --      acc_payable.account_id,
    //            --          acc_payable.memo,
    //            --          0 AS dr_amount,
    //            --          SUM(acc_payable.cr_amount) AS cr_amount
    //            --  FROM
    //            --      (SELECT 
    //            --          (SELECT 
    //            --                  payable_discount_account_id
    //            --              FROM
    //            --                  account_integration) AS account_id,
    //            --          '' AS memo,
    //            --          0 dr_amount,
    //            --          SUM(di.total_discount+di.total_overall_discount_amount) AS cr_amount
    //            --  FROM
    //            --      `delivery_invoice` AS di
    //            --  WHERE
    //            --      di.dr_invoice_id = $purchase_invoice_id) AS acc_payable
    //            --  WHERE acc_payable.account_id > 0 
    //            --  GROUP BY acc_payable.account_id 

    //             SELECT 
    //                 p.pd_account_id AS account_id,
    //                     '' AS memo,
    //                     0 dr_amount,
    //                     SUM(dii.dr_qty * dii.dr_discount) AS cr_amount
    //             FROM
    //                 `delivery_invoice_items` AS dii
    //             INNER JOIN products AS p ON dii.product_id = p.product_id
    //             WHERE
    //                 dii.dr_invoice_id = $purchase_invoice_id
    //                     AND p.pd_account_id > 0
    //             GROUP BY p.pd_account_id 

                
    //             ) AS main
    //         WHERE
    //             main.dr_amount > 0 OR main.cr_amount > 0";

    //     return $this->db->query($sql)->result();

    // }

}



?>