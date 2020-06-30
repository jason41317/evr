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

	        (in_array('8-7',$this->session->user_rights)? 
	        $this->load->view('sales_returns_report_view', $data)
	        :redirect(base_url('dashboard')));	        
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


				break;

				case 'export':
	                $tsd = date('Y-m-d',strtotime($this->input->get('startDate')));
	                $ted = date('Y-m-d',strtotime($this->input->get('endDate')));
	                $company_info= $this->Company_model->get_list();

	                $returns = $this->Adjustment_item_model->get_list(
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

	                $excel=$this->excel;
	                $excel->setActiveSheetIndex(0);
                    //name the worksheet
                    $excel->getActiveSheet()->setTitle("Sales Returns Report");

                    $excel->getActiveSheet()
                          ->getStyle('A1:H1')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                          ->getStyle('A2:H2')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $excel->getActiveSheet()
                          ->getStyle('A3:H3')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
                    $excel->getActiveSheet()
                          ->getStyle('A4:H4')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  
                    $excel->getActiveSheet()
                          ->getStyle('A5:H5')
                          ->getAlignment()
                          ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);        

                    $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE)
                                            ->setSize(16);
                    $excel->getActiveSheet()->mergeCells('A1:H1');
                    $excel->getActiveSheet()->mergeCells('A2:H2');
                    $excel->getActiveSheet()->mergeCells('A3:H3');
                    $excel->getActiveSheet()->mergeCells('A4:H4');
                    $excel->getActiveSheet()->mergeCells('A5:H5');
                    $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                            ->setCellValue('A2',$company_info[0]->company_address)
                                            ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no) 
                                            ->setCellValue('A5','SALES RETURNS REPORT');  

		                $excel->getActiveSheet()->getStyle('A6:H6')->getFont()->setBold(TRUE);
		                $excel->getActiveSheet()->setCellValue('A6','Invoice')
		                	->setCellValue('B6','Date Invoice')
		                	->setCellValue('C6','Date Returned')
		                	->setCellValue('D6','Customer')
		                	->setCellValue('E6','Product')
		                	->setCellValue('F6','Qty')
		                	->setCellValue('G6','Price')
		                	->setCellValue('H6','Total');
                    		$excel->getActiveSheet()->getStyle('G6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    		$excel->getActiveSheet()->getStyle('H6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

		                $i = 7; $total = 0;
		                foreach ($returns as $return) {
		                	$excel->getActiveSheet()->setCellValue('A'.$i,$return->inv_no);
		                	$excel->getActiveSheet()->setCellValue('B'.$i,$return->date_invoice);
		                	$excel->getActiveSheet()->setCellValue('C'.$i,$return->date_returned);
		                	$excel->getActiveSheet()->setCellValue('D'.$i,$return->customer_name);
		                	$excel->getActiveSheet()->setCellValue('E'.$i,$return->product_desc);
                     		$excel->getActiveSheet()->setCellValue('F'.$i,number_format($return->adjust_qty,0));
                     		$excel->getActiveSheet()->setCellValue('G'.$i,number_format($return->adjust_price,2));
                     		$excel->getActiveSheet()->setCellValue('H'.$i,number_format($return->adjust_line_total_price,2));
                     		$excel->getActiveSheet()->getStyle('G'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                     		$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');

                    		$excel->getActiveSheet()->getStyle('G'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    		$excel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    		$total += $return->adjust_line_total_price;
                     		$i++;
		                }

						$excel->getActiveSheet()->setCellValue('H'.$i,number_format($total,2));
						$excel->getActiveSheet()->getStyle('H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
						$excel->getActiveSheet()->getStyle('H'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

						foreach(range('A','H') as $columnID) {
						    $excel->getActiveSheet()->getColumnDimension($columnID)
						        ->setAutoSize(true);
						}
		                // Redirect output to a client’s web browser (Excel2007)
		                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		                header('Content-Disposition: attachment;filename=Sales Returns '.$tsd.' '.$ted.'.xlsx');
		                header('Cache-Control: max-age=0');
		                // If you're serving to IE 9, then the following may be needed
		                header('Cache-Control: max-age=1');

		                // If you're serving to IE over SSL, then the following may be needed
		                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		                header ('Pragma: public'); // HTTP/1.0

		                
	               
	                $objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
            		$objWriter->save('php://output');
				break;
			}
		}
	}
?>