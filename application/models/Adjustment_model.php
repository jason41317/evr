<?php

class Adjustment_model extends CORE_Model
{
protected $table = "adjustment_info";
protected $pk_id = "adjustment_id";

	function __construct()
	{
		parent::__construct();
	}

     function get_adjustments_for_review(){
        $sql='SELECT main.*

			FROM(SELECT 
			ai.adjustment_id,
			ai.adjustment_code,
			ai.inv_no,
			ai.remarks,
			(CASE 
                WHEN ai.inv_type_id = 1 THEN "Sales Return"
                WHEN ai.inv_type_id = 2 THEN "Sales Return"
                WHEN ai.inv_type_id = 3 THEN "Purchase Return"
                ELSE ai.adjustment_type
            END) as adjustment_type,
			ai.date_created,
			DATE_FORMAT(ai.date_adjusted,"%m/%d/%Y") as date_adjusted,
			d.department_id,
			d.department_name

			FROM adjustment_info ai
			LEFT JOIN departments d ON d.department_id = ai.department_id

			WHERE
			ai.is_active=TRUE AND
			ai.is_deleted=FALSE AND 
			ai.is_journal_posted=FALSE
			AND ai.adjustment_type = "IN"
			AND ai.is_closed = FALSE

			UNION ALL

			SELECT 

			ai.adjustment_id,
			ai.adjustment_code,
			ai.inv_no,
			ai.remarks,
			(CASE 
                WHEN ai.inv_type_id = 1 THEN "Sales Return"
                WHEN ai.inv_type_id = 2 THEN "Sales Return"
                WHEN ai.inv_type_id = 3 THEN "Purchase Return"
                ELSE ai.adjustment_type
            END) as adjustment_type,			
			ai.date_created,
			DATE_FORMAT(ai.date_adjusted,"%m/%d/%Y") as date_adjusted,
			d.department_id,
			d.department_name

			FROM adjustment_info ai
			LEFT JOIN departments d ON d.department_id = ai.department_id

			WHERE
			ai.is_active=TRUE AND
			ai.is_deleted=FALSE AND 
			ai.is_journal_posted=FALSE
			AND ai.adjustment_type = "OUT"
			AND ai.is_closed = FALSE) as main

			ORDER BY main.adjustment_id';
        return $this->db->query($sql)->result();

    }


	function get_journal_entries_salesreturn($adjustment_id){
		$sql="SELECT 
        main.* 
        FROM(
        /* Sales Return */
		SELECT
		p.sales_return_account_id as account_id,
		SUM(IFNULL(adj.adjust_non_tax_amount,0) + IFNULL(adj.adjust_line_total_discount,0) + IFNULL(adj.global_discount_amount,0) ) as dr_amount,
		0 as cr_amount,
		
		'' as memo
		FROM adjustment_items adj
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id= $adjustment_id AND p.sales_return_account_id > 0
		GROUP BY p.sales_return_account_id

		/* Inventory */
		UNION ALL

        SELECT
		p.expense_account_id as account_id,
		SUM(adj.adjust_qty * adj.cost_upon_invoice) as dr_amount,
		0 as cr_amount,
		
		'' as memo

		FROM 
		adjustment_items adj 
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id = $adjustment_id AND p.expense_account_id > 0
		GROUP BY p.expense_account_id

		/* Output Tax */
	    UNION ALL

	    SELECT output_tax.account_id,
	    SUM(output_tax.dr_amount) as dr_amount,
	    0 as cr_amount,
	    output_tax.memo
	     FROM
	    (SELECT adj.product_id,

	    (SELECT output_tax_account_id FROM account_integration) as account_id
	    ,
	    '' as memo,
	    SUM(adj.adjust_tax_amount) as dr_amount,
	    0 as cr_amount
	    FROM `adjustment_items` as adj
	    INNER JOIN products as p ON adj.product_id=p.product_id
	    WHERE adj.adjustment_id=$adjustment_id AND p.income_account_id>0
	    )as output_tax GROUP BY output_tax.account_id

	    /* AR / Cash */ 
		UNION ALL
				
		SELECT 
			main.*
		FROM
			(SELECT (CASE WHEN ai.inv_type_id = 1 THEN (SELECT receivable_account_id FROM account_integration)
						WHEN ai.inv_type_id = 2 THEN (SELECT payment_from_customer_id FROM account_integration)
						ELSE 0
					END) AS account_id,
					0 AS dr_amount,
					SUM(IFNULL(adj.adjust_line_total_price, 0)) AS cr_amount,
					'' AS memo
			FROM
				adjustment_items adj
			INNER JOIN products p ON p.product_id = adj.product_id
			LEFT JOIN adjustment_info ai ON ai.adjustment_id = adj.adjustment_id
			WHERE
				adj.adjustment_id = $adjustment_id) AS main
		WHERE
			main.account_id > 0
		GROUP BY main.account_id
		
		/* Cost of Sales */
		UNION ALL
        
        SELECT
		p.cos_account_id as account_id,
		0 as dr_amount,
		SUM(adj.adjust_qty * adj.cost_upon_invoice) as cr_amount,
		'' as memo
		FROM 
		adjustment_items adj 
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id = $adjustment_id AND p.cos_account_id > 0
		GROUP BY p.cos_account_id

		/* Discount */
		UNION ALL

		SELECT
		p.sd_account_id as account_id,
		0 as dr_amount,
		SUM(IFNULL(adj.adjust_line_total_discount,0) + IFNULL(adj.global_discount_amount,0) ) as cr_amount,
		
		'' as memo
		FROM adjustment_items adj
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id= $adjustment_id AND p.sd_account_id > 0
		GROUP BY p.sd_account_id
       
        

		) as main 
		WHERE main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();
	}


	function get_journal_entries_purchasereturn($adjustment_id){
		$sql="SELECT 
			    main.*
			FROM
			    (

			    SELECT 
			        main.*
			    FROM
			        (SELECT 
			        	(SELECT payable_account_id FROM account_integration) AS account_id,
			            SUM(IFNULL(adj.adjust_line_total_price, 0)) AS dr_amount,
			            0 AS cr_amount,
			            '' AS memo
			    FROM
			        adjustment_items adj
			    INNER JOIN products p ON p.product_id = adj.product_id
			    LEFT JOIN adjustment_info ai ON ai.adjustment_id = adj.adjustment_id
			    WHERE
			        adj.adjustment_id = $adjustment_id) AS main
			    WHERE
			        main.account_id > 0
			    GROUP BY main.account_id 


			    UNION ALL 


			    SELECT 
			        p.pd_account_id AS account_id,
			            SUM(IFNULL(adj.adjust_line_total_discount, 0)) AS dr_amount,
			            0 AS cr_amount,
			            '' AS memo
			    FROM
			        adjustment_items adj
			    INNER JOIN products p ON p.product_id = adj.product_id
			    WHERE
			        adj.adjustment_id = $adjustment_id
			            AND p.pd_account_id > 0
			    GROUP BY p.pd_account_id 


			    UNION ALL 

			    SELECT 
			        p.po_return_account_id AS account_id,
			            0 AS dr_amount,
			            SUM(IFNULL((adj.adjust_qty * adj.adjust_price)-adj.adjust_tax_amount, 0)) AS cr_amount,
			            '' AS memo
			    FROM
			        adjustment_items adj
			    INNER JOIN products p ON p.product_id = adj.product_id
			    WHERE
			        adj.adjustment_id = $adjustment_id
			            AND p.po_return_account_id > 0
			    GROUP BY p.po_return_account_id 

			    
			    UNION ALL 


			    SELECT 
			        input_tax.account_id,
			            0 AS dr_amount,
			            SUM(input_tax.dr_amount) AS cr_amount,
			            input_tax.memo
			    FROM
			        (SELECT 
			        adj.product_id,
			            (SELECT 
			                    input_tax_account_id
			                FROM
			                    account_integration) AS account_id,
			            '' AS memo,
			            SUM(adj.adjust_tax_amount) AS dr_amount,
			            0 AS cr_amount
			    FROM
			        adjustment_items AS adj
			    INNER JOIN products AS p ON adj.product_id = p.product_id
			    WHERE
			        adj.adjustment_id = $adjustment_id
			            AND p.expense_account_id > 0) AS input_tax
			    GROUP BY input_tax.account_id) AS main
			WHERE
			    main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();
	}


// OUT ADJUSTMENT
 function get_journal_entries_2($adjustment_id){
        $sql="SELECT 
        main.* 
        FROM(

        SELECT
		(SELECT adj_debit_id FROM account_integration) as account_id,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as dr_amount,
		0 as cr_amount,
		'' as memo

		FROM 
		adjustment_items adj 
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id = $adjustment_id AND p.expense_account_id > 0
		GROUP BY adj.adjustment_id

		UNION ALL

		SELECT 
		p.expense_account_id as account_id,
		0 as dr_amount,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as cr_amount,
		'' as memo

		FROM adjustment_items adj
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id= $adjustment_id AND p.expense_account_id > 0
		GROUP BY p.expense_account_id) as main 
		WHERE main.dr_amount > 0 OR main.cr_amount > 0";
        return $this->db->query($sql)->result();

    }
// IN ADJUSTMENT
     function get_journal_entries_2_in($adjustment_id){
        $sql="SELECT 
        main.* 
        FROM(
		SELECT
		p.expense_account_id as account_id,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as dr_amount,
		0 as cr_amount,
		
		'' as memo
		FROM adjustment_items adj
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id= $adjustment_id AND p.expense_account_id > 0
		GROUP BY p.expense_account_id



		UNION ALL

        SELECT
		(SELECT adj_credit_id FROM account_integration) as account_id,
		0 as dr_amount,
		SUM(IFNULL(adj.adjust_non_tax_amount,0)) as cr_amount,
		
		'' as memo

		FROM 
		adjustment_items adj 
		INNER JOIN products p ON p.product_id = adj.product_id
		WHERE adj.adjustment_id = $adjustment_id AND p.expense_account_id > 0
		GROUP BY adj.adjustment_id

		) as main 
		WHERE main.dr_amount > 0 OR main.cr_amount > 0";

        return $this->db->query($sql)->result();



    }

	function list_per_supplier($supplier_id = null){
        $sql="SELECT 
			    di.dr_invoice_no,
				DATE_FORMAT(di.date_delivered,'%m/%d/%Y') as date_delivered,
				'3' as inv_type_id,
			    di.is_journal_posted,
			    p.product_code,
			    p.product_desc,
			    dii.dr_qty,
			    u.unit_name,
			    p.sale_price,
			    IF(di.is_journal_posted = TRUE,
			        'Note: Invoice is posted in Accounting',
			        'Note: Invoice is not yet posted in Accounting') AS note,
			    dii.*
			FROM
			    delivery_invoice_items dii
			        LEFT JOIN
			    delivery_invoice di ON di.dr_invoice_id = dii.dr_invoice_id
			        LEFT JOIN
			    products p ON p.product_id = dii.product_id
			        LEFT JOIN
			    units u ON u.unit_id = dii.unit_id
			WHERE
			    di.is_active = TRUE
			        AND di.is_deleted = FALSE
			        AND di.supplier_id = $supplier_id";
        return $this->db->query($sql)->result();

    }


	function list_per_customer($customer_id = null,$start_date,$end_date){
        $sql="SELECT 
        	sii.*,
        	DATE_FORMAT(sii.exp_date,'%m/%d/%Y') as exp_date,
			si.sales_inv_no,
			si.is_journal_posted,
			si.date_invoice,
			si.total_overall_discount,
			(((sii.inv_qty * sii.inv_price) - sii.inv_line_total_discount)*(si.total_overall_discount/100)) as global_discount_amount,			
			'1' as inv_type_id,
			p.product_code,
			p.product_desc,
			sii.inv_qty,
			u.unit_name,
			p.sale_price,
			IF(si.is_journal_posted = TRUE, 'Note: Invoice is posted in Accounting', 'Note: Invoice is not yet posted in Accounting') as note,
			sii.* FROM sales_invoice_items sii

			LEFT JOIN sales_invoice si ON si.sales_invoice_id = sii.sales_invoice_id
			LEFT JOIN products p ON p.product_id = sii.product_id
			LEFT JOIN units u ON u.unit_id = sii.unit_id	
			WHERE si.is_active = TRUE 
			AND si.is_deleted = FALSE
			AND si.customer_id= '$customer_id'
			AND (si.date_invoice BETWEEN '".$start_date."' AND '".$end_date."')";

        return $this->db->query($sql)->result();

    }

}


?>