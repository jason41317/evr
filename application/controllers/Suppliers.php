<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Suppliers_model');
        $this->load->model('Supplier_photos_model');
        $this->load->model('Tax_model');
        $this->load->model('Trans_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
    }

    public function index() {
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
        $data['suppliers']=$this->Suppliers_model->get_list(array('suppliers.is_deleted'=>FALSE));
        $data['title']='Supplier Management';


        $data['tax_types']=$this->Tax_model->get_list(array('tax_types.is_deleted'=>FALSE));

        (in_array('5-2',$this->session->user_rights)? 
        $this->load->view('suppliers_view', $data)
        :redirect(base_url('dashboard')));        
    }


    function transaction($txn=null) {
        switch($txn) {
            case 'list':
                $m_suppliers=$this->Suppliers_model;
                $response['data']=$m_suppliers->get_list(
                        array('suppliers.is_deleted'=>FALSE),
                        'suppliers.*,tax_types.tax_type,tax_types.tax_rate',

                        array(
                            array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
                        )

                );
                echo json_encode($response);

                break;

            case 'create':
                $m_suppliers=$this->Suppliers_model;
                $m_photos=$this->Supplier_photos_model;

                $m_suppliers->set('date_created','NOW()');
                
                $m_suppliers->supplier_name=$this->input->post('supplier_name',TRUE);
                $m_suppliers->contact_name=$this->input->post('contact_name',TRUE);
                $m_suppliers->address=$this->input->post('address',TRUE);
                $m_suppliers->email_address=$this->input->post('email_address',TRUE);
                $m_suppliers->contact_no=$this->input->post('contact_no',TRUE);
                $m_suppliers->tin_no=$this->input->post('tin_no',TRUE);
                $m_suppliers->photo_path=$this->input->post('photo_path',TRUE);

                $m_suppliers->tax_type_id=$this->input->post('tax_type_id',TRUE);
                $m_suppliers->posted_by_user=$this->session->user_id;
                $m_suppliers->save();

                $supplier_id=$m_suppliers->last_insert_id();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Supplier Information successfully created.';
                $response['row_added']= $m_suppliers->get_list(

                    $supplier_id,

                    'suppliers.*,tax_types.tax_type,tax_types.tax_rate',

                    array(
                        array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')

                    )

                );

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=51; // TRANS TYPE
                $m_trans->trans_log='Created a Supplier: '.$this->input->post('supplier_name',TRUE);
                $m_trans->save();
                                
                echo json_encode($response);

                break;

            case 'delete':
                $m_suppliers=$this->Suppliers_model;
                $m_photos=$this->Supplier_photos_model;
                $supplier_id=$this->input->post('supplier_id',TRUE);

                $m_suppliers->is_deleted=1;
                if($m_suppliers->modify($supplier_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='supplier information successfully deleted.';

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_suppliers=$this->Suppliers_model;
                $m_photos=$this->Supplier_photos_model;

                $supplier_id=$this->input->post('supplier_id',TRUE);
                $m_suppliers->supplier_name=$this->input->post('supplier_name',TRUE);
                $m_suppliers->contact_name=$this->input->post('contact_name',TRUE);
                $m_suppliers->address=$this->input->post('address',TRUE);
                $m_suppliers->email_address=$this->input->post('email_address',TRUE);
                $m_suppliers->contact_no=$this->input->post('contact_no',TRUE);
                $m_suppliers->tin_no=$this->input->post('tin_no',TRUE);
                $m_suppliers->photo_path=$this->input->post('photo_path',TRUE);
                $m_suppliers->tax_type_id=$this->input->post('tax_type_id',TRUE);
                $m_suppliers->modify($supplier_id);

                $m_photos->delete_via_fk($supplier_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Supplier Information successfully updated.';
                $response['row_updated']=$m_suppliers->get_list(
                    $supplier_id,
                        'suppliers.*,tax_types.tax_type,tax_types.tax_rate',

                        array(
                            array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')

                        ));
                echo json_encode($response);

                break;

            case 'upload':
                $allowed = array('png', 'jpg', 'jpeg','bmp');

                $data=array();
                $files=array();
                $directory='assets/img/supplier/';

                foreach($_FILES as $file){

                    $server_file_name=uniqid('');
                    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $file_path=$directory.$server_file_name.'.'.$extension;
                    $orig_file_name=$file['name'];

                    if(!in_array(strtolower($extension), $allowed)){
                        $response['title']='Invalid!';
                        $response['stat']='error';
                        $response['msg']='Image is invalid. Please select a valid photo!';
                        die(json_encode($response));
                    }

                    if(move_uploaded_file($file['tmp_name'],$file_path)){
                        $response['title']='Success!';
                        $response['stat']='success';
                        $response['msg']='Image successfully uploaded.';
                        $response['path']=$file_path;
                        echo json_encode($response);
                    }
                }
                break;
            case 'payables':
                $supplier_id=$this->input->get('id',TRUE);
                $department_id=$this->input->get('depid',TRUE);
                $start_date=date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));
                $end_date=date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));

                $m_suppliers=$this->Suppliers_model;

                $data['payables']=$m_suppliers->get_supplier_payable_list($supplier_id,$start_date,$end_date,$department_id);
                $structured_content=$this->load->view('template/supplier_payables_list',$data,TRUE);
                echo $structured_content;

                break;

            case 'print-masterfile':
                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $data['suppliers']= $this->Suppliers_model->get_list(
                    array('suppliers.is_deleted'=>FALSE),
                    'suppliers.*,tax_types.tax_type,tax_types.tax_rate',
                    array(
                        array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
                    )

            );
                    $this->load->view('template/supplier_masterfile_content',$data);

            break;

            case 'export-supplier':

                $excel = $this->excel;

                $m_company_info=$this->Company_model;
                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $suppliers=$this->Suppliers_model->get_list(
                        array('suppliers.is_deleted'=>FALSE),
                        'suppliers.*,tax_types.tax_type,tax_types.tax_rate',
                        array(
                            array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
                        )

                );
                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Supplier Masterfile");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Supplier Masterfile')
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','')
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('30');
    

                 $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:G9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','Company Name')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Tin')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Address')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Contact Person')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Contact No')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Email Address')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Tax Types')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);

                $i=10;



                foreach ($suppliers as $supplier) {


                $excel->getActiveSheet()->setCellValue('A'.$i,$supplier->supplier_name)
                                        ->setCellValue('B'.$i,$supplier->tin_no)
                                        ->setCellValue('C'.$i,$supplier->address)
                                        ->setCellValue('D'.$i,$supplier->contact_name)
                                        ->setCellValue('E'.$i,$supplier->contact_no)
                                        ->setCellValue('F'.$i,$supplier->email_address)
                                        ->setCellValue('G'.$i,$supplier->tax_type);


                $i++;

                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Supplier Masterfile '.date('M-d-Y',NOW()).'.xlsx"');
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
