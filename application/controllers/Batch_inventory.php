<?php
// ini_set('memory_limit', '4096M');
// ini_set('max_execution_time', 0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_inventory extends CORE_Controller
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
        $data['title'] = 'Batch Inventory Report';

        $data['suppliers']=$this->Suppliers_model->get_list(array('is_deleted'=>FALSE));
        $data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        $data['product_types']=$this->Refproduct_model->get_list(array('is_deleted'=>FALSE));

        (in_array('11-6',$this->session->user_rights)? 
        $this->load->view('batch_inventory_report_view',$data)
        :redirect(base_url('dashboard')));
    }



    public function transaction($txn=null){
        switch($txn){
            case 'get-inventory':
                $m_products = $this->Products_model;
                $ccf = null;

                $supid = $this->input->post('supid',TRUE);
                $prod_type_id = $this->input->post('prod_type_id',TRUE);
                $depid = $this->input->post('depid',TRUE);
                $currentcountfilter = $this->input->post('ccf',TRUE);
                $date = date('Y-m-d',strtotime($this->input->post('date',TRUE)));

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

                $response['data']=$m_products->batch_inventory($supid,$prod_type_id,$depid,$ccf,$date);


                echo json_encode($response);    
                break;

            case 'product-batch-history':
                $m_products = $this->Products_model;
                $uniq_id=$this->input->get('uniq_id');
                $department_id=$this->input->get('depid');
                $as_of_date=date('Y-m-d',strtotime($this->input->get('date')));

                $data['items']=$m_products->batch_inventory_history($uniq_id,$department_id,$as_of_date);
                $this->load->view('template/batch_inventory_history',$data);
                break;

            case 'export-batch-inventory':

                $excel = $this->excel;

                $m_products = $this->Products_model;
                $m_department = $this->Departments_model;

                $ccf = null;
                $type = $this->input->get('type',TRUE);
                $supid = $this->input->get('supid',TRUE);
                $prod_type_id = $this->input->get('prod_type_id',TRUE);
                $depid = $this->input->get('depid',TRUE);
                $currentcountfilter = $this->input->get('ccf',TRUE);
                $date = date('Y-m-d',strtotime($this->input->get('date',TRUE)));

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

                $info=$m_department->get_list($depid);
                $as_of_date = date('m/d/Y',strtotime($date));
                $batches=$m_products->batch_inventory($supid,$prod_type_id,$depid,$ccf,$date);

                if(isset($info[0])){
                    $department =$info[0]->department_name;
                }else{
                    $department = 'All';
                }

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Batch Inventory Report");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Batch Inventory Report - '.$department)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','As of '.$as_of_date)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8',$ccf_data)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('45');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('45');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('10');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
    
                $excel->getActiveSheet()
                        ->getStyle('H10:J10')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                $excel->getActiveSheet()->getStyle('A10:J10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A10', 'Product')
                    ->setCellValue('B10', 'Unit')
                    ->setCellValue('C10', 'Product type')
                    ->setCellValue('D10', 'Supplier')
                    ->setCellValue('E10', 'Category')
                    ->setCellValue('F10', 'Batch')
                    ->setCellValue('G10', 'Expiration')
                    ->setCellValue('H10', 'Purchase')
                    ->setCellValue('I10', 'SRP')
                    ->setCellValue('J10', 'On Hand');

                $i=11;

                foreach($batches as $batch){

            
                        $excel->getActiveSheet()
                                ->getStyle('A'.$i.':G'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                        $excel->getActiveSheet()
                                ->getStyle('H'.$i.':J'.$i)
                                ->getAlignment()
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);


                        $excel->getActiveSheet()->setCellValue('A'.$i,$batch->product_desc);
                        $excel->getActiveSheet()->setCellValue('B'.$i,$batch->size);                 
                        $excel->getActiveSheet()->setCellValue('C'.$i,$batch->product_type);
                        $excel->getActiveSheet()->setCellValue('D'.$i,$batch->supplier_name);
                        $excel->getActiveSheet()->setCellValue('E'.$i,$batch->category_name);
                        $excel->getActiveSheet()->setCellValue('F'.$i,$batch->batch_no);
                        $excel->getActiveSheet()->setCellValue('G'.$i,$batch->exp_date);
                        $excel->getActiveSheet()->setCellValue('H'.$i,$batch->purchase_cost);
                        $excel->getActiveSheet()->setCellValue('I'.$i,$batch->sale_price);
                        $excel->getActiveSheet()->setCellValue('J'.$i,$batch->on_hand_per_batch);
                        $i++;                  
                }

                if(count($batches)==0){
                    $excel->getActiveSheet()->setCellValue('A'.$i,'No Records Found');
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Batch Inventory Report '.date('M-d-Y',NOW()).'.xlsx"');
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