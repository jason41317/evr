<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Sales_returns_report extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->library('excel');
			$this->load->model(
				array(
					'Adjustment_item_model',
					'Company_model',
				)
			);
		}

		public function index()
		{
		 	$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Sales Returns Report';


	        $this->load->view('sales_returns_report_view',$data);
		}

		function transaction($txn=null){
			switch($txn){
				case 'list':
	                $tsd = date('Y-m-d',strtotime($this->input->get('startDate')));
	                $ted = date('Y-m-d',strtotime($this->input->get('endDate')));
					$response['data'] = $this->Adjustment_item_model->get_list(
						 "adjustment_info.is_deleted = FALSE
						 AND adjustment_info.is_active= TRUE 
						 AND adjustment_info.is_returns = TRUE 
						 AND DATE(adjustment_info.date_adjusted) BETWEEN '$tsd' AND '$ted' ",

						'adjustment_items.*,
						adjustment_info.inv_no,
						customers.customer_name,
						products.product_desc,
						DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice,
						DATE_FORMAT(adjustment_info.date_adjusted,"%m/%d/%Y") as date_returned,
						',
						array(
							array('adjustment_info','adjustment_info.adjustment_id = adjustment_items.adjustment_id', 'left'),
							array('sales_invoice','sales_invoice.sales_inv_no = adjustment_info.inv_no', 'left'),
							array('customers','customers.customer_id = sales_invoice.customer_id','left'),
							array('products','products.product_id = adjustment_items.product_id','left')

							)

						);
					echo json_encode($response);

				break;

				case 'print-report':
	                $tsd = date('Y-m-d',strtotime($this->input->get('startDate')));
	                $ted = date('Y-m-d',strtotime($this->input->get('endDate')));
	                $data['company_info']= $this->Company_model->get_list()[0];
					$data['returns'] = $this->Adjustment_item_model->get_list(
						 "adjustment_info.is_deleted = FALSE
						 AND adjustment_info.is_active= TRUE 
						 AND adjustment_info.is_returns = TRUE 
						 AND DATE(adjustment_info.date_adjusted) BETWEEN '$tsd' AND '$ted' ",
						 
						'adjustment_items.*,
						adjustment_info.inv_no,
						customers.customer_name,
						products.product_desc,
						DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice,
						DATE_FORMAT(adjustment_info.date_adjusted,"%m/%d/%Y") as date_returned,
						',
						array(
							array('adjustment_info','adjustment_info.adjustment_id = adjustment_items.adjustment_id', 'left'),
							array('sales_invoice','sales_invoice.sales_inv_no = adjustment_info.inv_no', 'left'),
							array('customers','customers.customer_id = sales_invoice.customer_id','left'),
							array('products','products.product_id = adjustment_items.product_id','left')

							)

						);
					 $this->load->view('template/sales_returns_report_content',$data);

				break;
			}
		}
	}
?>