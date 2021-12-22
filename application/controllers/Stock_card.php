<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Stock_card extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->library('excel');
			$this->load->model(
				array(
					'Delivery_invoice_model',
					'Suppliers_model',
					'Company_model',
            		'Departments_model',
					'Products_model'
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
        	$data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        	
	        $data['products']= $this->Products_model->get_list(array('is_active'=>TRUE,'is_deleted'=>FALSE ),'product_id,product_desc');
        	$data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
	        $data['title'] = 'Stock Card Report';

	        (in_array('8-6',$this->session->user_rights)? 
	        $this->load->view('stock_card_view', $data)
	        :redirect(base_url('dashboard')));	        
		}

		function transaction($txn=null){
			switch($txn){
			
				case 'stock-history':

                $product_id=$this->input->get('id');
                $depid=$this->input->get('depid');
                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $m_products=$this->Products_model;
                $balance_as_of = $m_products->get_product_balance_as_of_date($product_id,$startDate,$depid)[0]; 
                $data['balance_as_of'] =$balance_as_of;
                $data['products']=$m_products->get_product_history($product_id,$startDate,$endDate,$balance_as_of->balance,$depid);
                $data['as_of_date'] = $startDate;
                $data['product_id']=$product_id;
                $this->load->view('template/product_history',$data);
                break;


				case 'export':
					$m_delivery_invoice=$this->Delivery_invoice_model;

	                $type=$this->input->get('type');
	                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
	                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
	                $refproduct_id=$this->input->get('rid',TRUE);

	                $excel=$this->excel;
	                $excel->setActiveSheetIndex(0);

	                if($type == 'summary')
	                {
		                $excel->getActiveSheet()->setTitle('Purchase Invoice (Summary)');

		                //header
		                //create headers
		                $excel->getActiveSheet()->getStyle('A4:F4')->getFont()->setBold(TRUE);
		                $excel->getActiveSheet()->setCellValue('A4','Supplier')
		                	->setCellValue('B4','Invoice Date')
		                	->setCellValue('C4','Invoice #')
		                	->setCellValue('D4','Vat Type')
		                	->setCellValue('E4','Product Type')
		                	->setCellValue('F4','Amount');

		                $suppliers=$m_delivery_invoice->get_list(
		                	'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
	                            'DISTINCT(suppliers.supplier_name), delivery_invoice.supplier_id',
	                            array(
	                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
	                            )
		                );

		                $purchase_invoice_summary=$m_delivery_invoice->get_report_summary($refproduct_id,$startDate,$endDate);

		                $rows=array();

		                foreach($purchase_invoice_summary as $x){
		                	$rows[]=array(
		                		$x->supplier_name,
		                		$x->date_delivered,
		                		$x->external_ref_no,
		                		$x->tax_type,
		                		$x->product_type,
		                		$x->total_after_tax
		                	);
		                }

		                $max_rows=count($purchase_invoice_summary)+4;

		                for($i=5;$i<=$max_rows;$i++){
		                	$excel->getActiveSheet()->getStyle('F'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');
		                }

		                //autofit column
		                foreach(range('A','F') as $columnID)
		                {
		                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
		                }

		                $excel->getActiveSheet()->getStyle('A4:F4')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('4caf50');

		                $excel->getActiveSheet()->fromArray($rows,NULL,'A5');

		                // Redirect output to a client’s web browser (Excel2007)
		                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		                header('Content-Disposition: attachment;filename=PIRS '.$startDate.' '.$endDate.'.xlsx');
		                header('Cache-Control: max-age=0');
		                // If you're serving to IE 9, then the following may be needed
		                header('Cache-Control: max-age=1');

		                // If you're serving to IE over SSL, then the following may be needed
		                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		                header ('Pragma: public'); // HTTP/1.0

		                
	                } else if($type=='detailed') {
	                	$excel->getActiveSheet()->setTitle('Purchase Invoice (Detailed)');

		                //header
		                //create headers
		                $excel->getActiveSheet()->getStyle('A4:G4')->getFont()->setBold(TRUE);
		                $excel->getActiveSheet()->setCellValue('A4','Supplier')
		                	->setCellValue('B4','Invoice #')
		                	->setCellValue('C4','Product')
		                	->setCellValue('D4','Product Type')
		                	->setCellValue('E4','Qty')
		                	->setCellValue('F4','Unit Cost')
		                	->setCellValue('G4','Total Amount');

		                 $purchase_invoice_detailed=$m_delivery_invoice->get_report_detailed($refproduct_id,$startDate,$endDate);

		                $rows=array();

		                foreach($purchase_invoice_detailed as $x){
		                	$rows[]=array(
		                		$x->supplier_name,
		                		$x->external_ref_no,
		                		$x->product_desc,
		                		$x->product_type,
		                		$x->dr_qty,
		                		$x->dr_price,
		                		$x->dr_line_total_price
		                	);
		                }

		                $max_rows=count($purchase_invoice_detailed)+4;

		                for($i=5;$i<=$max_rows;$i++){
		                	$excel->getActiveSheet()->getStyle('F'.$i.':G'.$i)->getNumberFormat()->setFormatCode('###,##0.0000;(###,##0.0000)');
		                }

		                //autofit column
		                foreach(range('A','G') as $columnID)
		                {
		                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
		                }

		                $excel->getActiveSheet()->getStyle('A4:G4')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('4caf50');

		                $excel->getActiveSheet()->fromArray($rows,NULL,'A5');

		                // Redirect output to a client’s web browser (Excel2007)
		                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		                header('Content-Disposition: attachment;filename=PIRD '.$startDate.' '.$endDate.'.xlsx');
		                header('Cache-Control: max-age=0');
		                // If you're serving to IE 9, then the following may be needed
		                header('Cache-Control: max-age=1');

		                // If you're serving to IE over SSL, then the following may be needed
		                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		                header ('Pragma: public'); // HTTP/1.0

	                }

	                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            		$objWriter->save('php://output');
				break;

	            case 'purchase-invoice':
	                $m_company_info=$this->Company_model;

	                $company_info=$m_company_info->get_list();
	                $data['company_info']=$company_info[0];

	                $m_delivery_invoice=$this->Delivery_invoice_model;

	                $type=$this->input->get('type');
	                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
	                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
	                $refproduct_id=$this->input->get('rid',TRUE);


	                if ($type=='summary') {

                        $data['suppliers']=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(suppliers.supplier_name), delivery_invoice.supplier_id',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );

                        $data['purchase_invoice_summary']=$m_delivery_invoice->get_report_summary($refproduct_id,$startDate,$endDate);
	                	$this->load->view('template/purchase_invoice_summary',$data);
	                } 

	                if ($type=='detailed') {


                        $data['invoice_numbers']=$m_delivery_invoice->get_list(
                            'date_delivered BETWEEN "'.$startDate.'" AND "'.$endDate.'" AND  delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE',
                            'DISTINCT(delivery_invoice.external_ref_no), delivery_invoice.supplier_id,delivery_invoice.dr_invoice_id,delivery_invoice.supplier_id,suppliers.supplier_name',
                            array(
                                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left')
                            )
                        );

                        $data['purchase_invoice_detailed']=$m_delivery_invoice->get_report_detailed($refproduct_id,$startDate,$endDate);
	                	$this->load->view('template/purchase_invoice_detailed',$data);
	                }
	            break;
			}
		}
	}
?>