<?php
// ini_set('memory_limit', '4096M');
// ini_set('max_execution_time', 0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory_report extends CORE_Controller
{
    function __construct()
    {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(
            array
            (
                'Departments_model',
                'Company_model',
                'Users_model',
                'Products_model',
                'Suppliers_model',
                'Refproduct_model',
                'Account_integration_model'
            )
        );
        $this->load->library('excel');
    }

    public function index() {

        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['title'] = 'Inventory Report';

        $data['suppliers']=$this->Suppliers_model->get_list(array('is_deleted'=>FALSE));
        $data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        $data['product_types']=$this->Refproduct_model->get_list(array('is_deleted'=>FALSE));
        
        (in_array('11-5',$this->session->user_rights)? 
        $this->load->view('inventory_view',$data)
        :redirect(base_url('dashboard')));
    }



    public function transaction($txn=null){
        switch($txn){
            case 'get-inventory':
                $m_products = $this->Products_model;
                $ccf = null;
                $date = date('Y-m-d',strtotime($this->input->post('date',TRUE)));
                $department_id = $this->input->post('depid',TRUE);
                $supplier_id = $this->input->post('supid',TRUE);
                $prod_type_id = $this->input->post('prod_type_id',TRUE);
                $currentcountfilter = $this->input->post('ccf',TRUE);

                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter == 1){ 
                    $ccf = null; 
                }else if ($currentcountfilter == 2) { 
                    $ccf = ' > 0'; 
                }else if($currentcountfilter == 3){ 
                    $ccf = ' < 0'; 
                }else if($currentcountfilter == 4){ 
                    $ccf = ' = 0';
                }

                $response['data']=$m_products->get_inventory_report($date,$prod_type_id,$ccf,$supplier_id,$department_id);

                echo json_encode($response);
                break;

            case 'preview-inventory-with-total':
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}
                $info = $m_department->get_department_list($depid);
                $data['products']=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf,1);
                // $data['products'] = $m_products->get_product_list_inventory($date,$depid,$account);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $data['department'] =$info[0]->department_name;
                }else{
                    $data['department'] = 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $this->load->view('template/batch_inventory_report_with_total',$data);
                break;

            case 'export-inventory':

                $excel = $this->excel;
                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);
                $supplier_id = $this->input->get('supid',TRUE);
                $prod_type_id = $this->input->get('prod_type_id',TRUE);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                $ccf = null;

                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter == 1){ 
                    $ccf = null; 
                }else if ($currentcountfilter == 2) { 
                    $ccf = ' > 0'; 
                }else if($currentcountfilter == 3){ 
                    $ccf = ' < 0'; 
                }else if($currentcountfilter == 4){ 
                    $ccf = ' = 0';
                }

                if($currentcountfilter  == 1){ 
                    $ccf_data = 'All Count Items'; 
                }else if ($currentcountfilter  == 2) { 
                    $ccf_data = 'Items Greater than Zero'; 
                }else if($currentcountfilter  == 3){ 
                    $ccf_data = 'Items Less than Zero'; 
                }else if($currentcountfilter  == 4){ 
                    $ccf_data = 'Items Equal to Zero';
                }

                $products=$m_products->get_inventory_report($date,$prod_type_id,$ccf,$supplier_id,$depid);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department= 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('45');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('45');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

    
                $excel->getActiveSheet()
                        ->getStyle('F9:H9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:H9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','Product')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Unit')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Product Type')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Supplier')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Category')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Purchase')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','SRP')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','On Hand')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);

                $i=10;

                foreach($products as $product){

                        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('45');
                        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('10');
                        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('45');
                        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()
                                ->getStyle('F'.$i.':H'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                        $excel->getActiveSheet()->setCellValue('A'.$i,$product->product_desc);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$product->unit_name);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$product->product_type);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$product->supplier_name);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$product->category_name);

                        $excel->getActiveSheet()->getStyle('G'.$i.':H'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');                        

                        $excel->getActiveSheet()->setCellValue('F'.$i,$product->purchase_cost);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$product->sale_price);
                        $excel->getActiveSheet()->setCellValue('H'.$i,$product->on_hand);
                        $i++;                  
                }
                if(count($products)==0){

                        $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');

                }

                $excel->getActiveSheet()->getStyle('A'.$i.':'.'H'.$i)->applyFromArray( $style_header );

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Inventory Report '.date('M-d-Y',NOW()).'.xlsx"');
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

            case 'export-inventory-with-total':

                $excel = $this->excel;
                $account_integration =$this->Account_integration_model;
                $a_i=$account_integration->get_list();
                $account =$a_i[0]->sales_invoice_inventory;
                $ci_account =$a_i[0]->cash_invoice_inventory;
                $account_dis =$a_i[0]->dispatching_invoice_inventory;
                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));
                $depid = $this->input->get('depid',TRUE);
                $info = $m_department->get_department_list($depid);

                $currentcountfilter = $this->input->get('ccf',TRUE);
                // Current Quantity Current Count Filter , 1 for ALL, 2 for Greater than 0, 3 for Less than Zero
                if($currentcountfilter  == 1){ $ccf = null; }else if ($currentcountfilter  == 2) { $ccf = ' > 0'; }
                else if($currentcountfilter  == 3){ $ccf = ' < 0'; }else if($currentcountfilter  == 4){ $ccf = ' = 0';}

                if($currentcountfilter  == 1){ $ccf_data = 'All Count Items'; }else if ($currentcountfilter  == 2) { $ccf_data = 'Items Greater than Zero'; }
                else if($currentcountfilter  == 3){ $ccf_data = 'Items Less than Zero'; }else if($currentcountfilter  == 4){ $ccf_data = 'Items Equal to Zero';}


                $products=$m_products->product_list($account,$date,null,null,null,1,null,$depid,$ci_account,$account_dis,$ccf,1);
                $data['date'] = date('m/d/Y',strtotime($date));

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department= 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('30');
    
    
                $excel->getActiveSheet()
                        ->getStyle('E9:J9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:J9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','PLU')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Description')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Category')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Unit')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Quantity In')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Quantity Out')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Balance')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Bulk Balance')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','Unit Cost')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('J9','Total')
                                        ->getStyle('J9')->getFont()->setBold(TRUE);

                $i=10;
                $gtotal=0;
                foreach($products as $product){
                        $excel->getActiveSheet()->getColumnDimension('A')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('B')->setWidth('40');
                        $excel->getActiveSheet()->getColumnDimension('C')->setWidth('30');
                        $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                        $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $excel->getActiveSheet()
                                ->getStyle('E'.$i.':J'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $excel->getActiveSheet()->setCellValue('A'.$i,$product->product_code);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$product->product_desc);
                        $excel->getActiveSheet()->setCellValue('C'.$i,$product->category_name);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$product->product_unit_name);


                        $excel->getActiveSheet()->getStyle('E'.$i.':J'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');
                                         
                        $excel->getActiveSheet()->setCellValue('E'.$i,number_format($product->quantity_in,2));      
                        $excel->getActiveSheet()->setCellValue('F'.$i,number_format($product->quantity_out,2));
                        $excel->getActiveSheet()->setCellValue('G'.$i,number_format($product->total_qty_balance,2));
                        $excel->getActiveSheet()->setCellValue('H'.$i,number_format($product->total_qty_bulk,2)); 
                        $excel->getActiveSheet()->setCellValue('I'.$i,number_format($product->purchase_cost,2)); 
                        $excel->getActiveSheet()->setCellValue('J'.$i,number_format((round($product->purchase_cost,2) * round($product->total_qty_bulk,2)),2));



                        $gtotal += (round($product->purchase_cost,2) * round($product->total_qty_bulk,2));
                        $i++;                  
                }

                        $excel->getActiveSheet()->setCellValue('A'.$i,'Grand Total');
                        $excel->getActiveSheet()->setCellValue('J'.$i,number_format($gtotal,2));
                        $excel->getActiveSheet()->getStyle('J'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)');


                $excel->getActiveSheet()
                        ->getStyle('J'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $excel->getActiveSheet()
                        ->getStyle('J'.$i)->getFont()->setBold(TRUE);
                 $excel->getActiveSheet()
                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);

                        $i++;


                if(count($products)==0){

                        $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');

                }

                $excel->getActiveSheet()->getStyle('A'.$i.':'.'J'.$i)->applyFromArray( $style_header );

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Inventory Report '.date('M-d-Y',NOW()).'.xlsx"');
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