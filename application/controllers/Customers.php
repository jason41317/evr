<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CORE_Controller {

    function __construct()
    {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Customers_model');
        $this->load->model('Customer_photos_model');
        $this->load->model('Departments_model');
        $this->load->model('RefCustomerType_model');
        $this->load->model('Soa_settings_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
    }

    public function index()
    {
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);
        $data['title']='Customer Management';

        $data['departments'] = $this->Departments_model->get_list(array('departments.is_deleted'=>FALSE));
        $data['refcustomertype'] = $this->RefCustomerType_model->get_list(array('refcustomertype.is_deleted'=>FALSE));

        (in_array('5-3',$this->session->user_rights)? 
        $this->load->view('customers_view', $data)
        :redirect(base_url('dashboard')));        
    }


    function transaction($txn=null){
        switch($txn){
            //****************************************************************************************************************
            case 'list':
                $m_customers=$this->Customers_model;
                $response['data']=$this->response_rows(array('customers.is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'getcustomer':
                $department_id = $this->input->post('department_id', TRUE);
                $get = "";
                $is_active = $this->input->post('is_active', TRUE);
                if($department_id > 1){
                    $get = array('customers.department_id'=>$department_id,'customers.is_deleted'=>FALSE);
                    if ($is_active != -1) {
                        $get = array('customers.department_id'=>$department_id,'customers.is_deleted'=>FALSE, 'customers.is_active' => $is_active);
                    }
                }else {
                    $get = array('customers.is_deleted'=>FALSE);
                    if ($is_active != -1) {
                        $get = array('customers.is_deleted'=>FALSE, 'customers.is_active' => $is_active);
                    }
                }

                $response['data'] = $this->response_rows($get);
                echo json_encode($response);
                break;

            //****************************************************************************************************************
            case 'create':
                $m_customers=$this->Customers_model;
                $m_photos=$this->Customer_photos_model;

                $m_customers->customer_name=$this->input->post('customer_name',TRUE);
                $m_customers->contact_name=$this->input->post('contact_name',TRUE);
                $m_customers->address=$this->input->post('address',TRUE);
                $m_customers->email_address=$this->input->post('email_address',TRUE);
                $m_customers->contact_no=$this->input->post('contact_no',TRUE);
                $m_customers->tin_no=$this->input->post('tin_no',TRUE);
                $m_customers->refcustomertype_id=$this->input->post('refcustomertype_id',TRUE);
                $m_customers->department_id=$this->input->post('department_id',TRUE);
                $m_customers->photo_path=$this->input->post('photo_path',TRUE);
                $m_customers->term=$this->input->post('term',TRUE);
                $m_customers->credit_limit=$this->input->post('credit_limit',TRUE);

                $m_customers->set('date_created','NOW()');
                $m_customers->posted_by_user=$this->session->user_id;

                $m_customers->save();

                $customer_id=$m_customers->last_insert_id();//get last insert id

                $m_photos->customer_id=$customer_id;
                $m_photos->photo_path=$this->input->post('photo_path',TRUE);
                $m_photos->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Customer Information successfully created.';
                $response['row_added']=$this->response_rows($customer_id);
                echo json_encode($response);

                break;
            //****************************************************************************************************************
            case 'delete':
                $m_customers=$this->Customers_model;
                $m_photos=$this->Customer_photos_model;
                $customer_id=$this->input->post('customer_id',TRUE);

                $m_customers->set('date_deleted','NOW()');
                $m_customers->deleted_by_user=$this->session->user_id;
                $m_customers->is_deleted=1;
                if($m_customers->modify($customer_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Customer Information successfully deleted.';
                    //$response['row_updated']=$m_customers->get_customer_list($customer_id);
                    echo json_encode($response);
                }



                break;
            //****************************************************************************************************************
            case 'update':
                $m_customers=$this->Customers_model;
                $m_photos=$this->Customer_photos_model;

                $customer_id=$this->input->post('customer_id',TRUE);
                $m_customers->customer_name=$this->input->post('customer_name',TRUE);
                $m_customers->contact_name=$this->input->post('contact_name',TRUE);
                $m_customers->address=$this->input->post('address',TRUE);
                $m_customers->email_address=$this->input->post('email_address',TRUE);
                $m_customers->contact_no=$this->input->post('contact_no',TRUE);
                $m_customers->tin_no=$this->input->post('tin_no',TRUE);
                $m_customers->refcustomertype_id=$this->input->post('refcustomertype_id',TRUE);
                $m_customers->department_id=$this->input->post('department_id',TRUE);
                $m_customers->photo_path=$this->input->post('photo_path',TRUE);
                $m_customers->term=$this->input->post('term',TRUE);
                $m_customers->credit_limit=$this->input->post('credit_limit',TRUE);

                $m_customers->set('date_modified','NOW()');
                $m_customers->modified_by_user=$this->session->user_id;

                $m_customers->modify($customer_id);

                $m_photos->delete_via_fk($customer_id);
                $m_photos->customer_id=$customer_id;
                $m_photos->photo_path=$this->input->post('photo_path',TRUE);
                $m_photos->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Customer Information successfully updated.';
                $response['row_updated']=$this->response_rows($customer_id);
                echo json_encode($response);

                break;

            case 'activate-deactivate':
                $m_customers=$this->Customers_model;

                $customer_id=$this->input->post('customer_id',TRUE);

                $m_customers->is_active = $this->input->post('is_active',TRUE) ? 1 : 0;
                // $m_products->is_deleted=1;
                if($m_customers->modify($customer_id)){         
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Customer information successfully '.($m_customers->is_active ? 'Activated' : 'Deactivated').'.';
                    $response['row_updated']=$this->response_rows($customer_id);
                    echo json_encode($response);
                }

                break;

            //****************************************************************************************************************
            case 'upload':
                $allowed = array('png', 'jpg', 'jpeg','bmp');

                $data=array();
                $files=array();
                $directory='assets/img/customer/';


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


            case 'receivables':
                $m_customers=$this->Customers_model;

                $accounts=$this->Soa_settings_model->get_list(null,'soa_account_id');
                $acc = [];

                $department_id=$this->input->get('depid',TRUE);
                $customer_id=$this->input->get('id',TRUE);
                $start_date=date('Y-m-d',strtotime($this->input->get('start_date',TRUE)));
                $end_date=date('Y-m-d',strtotime($this->input->get('end_date',TRUE)));

                foreach ($accounts as $account) { $acc[]=$account->soa_account_id; }
                $filter_accounts =  implode(",", $acc);

                $data['receivables']=$m_customers->get_customer_receivable_list($customer_id,$start_date,$end_date,$filter_accounts,$department_id);
                $structured_content=$this->load->view('template/customer_receivable_list',$data,TRUE);
                echo $structured_content;

                break;

            case 'print-masterfile':
                $m_company_info=$this->Company_model;
                $m_department=$this->Departments_model;

                $department_id = $this->input->get('id', TRUE);
                $is_active = $this->input->get('status', TRUE);

                $filter = "";
                $filter_active = "";
                $data['department_name']="All Departments";
                $data['status']="All";

                if($department_id!=0){
                    $filter = " AND department_id=".$department_id;
                    $data['department_name'] = $m_department->get_list($department_id)[0]->department_name;
                }

                if($is_active!=-1){
                    $filter_active = " AND is_active=".$is_active;
                    $data['status'] = $is_active == 1 ? 'Active' : 'Inactive';
                } 

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $data['customers']=$this->Customers_model->get_list('is_deleted=FALSE '.$filter.' '.$filter_active);
                    $this->load->view('template/customer_masterfile_content',$data);

            break;

            case 'export-customer':
                $excel = $this->excel;

                $m_department=$this->Departments_model;
                $m_company_info=$this->Company_model;

                $department_id = $this->input->get('id', TRUE);
                $is_active = $this->input->get('status', TRUE);

                $filter = "";
                $filter_active = "";
                $department_name="All Departments";
                $status="All";

                if($department_id!=0){
                    $filter = " AND department_id=".$department_id;
                    $department_name = $m_department->get_list($department_id)[0]->department_name;
                }

                if($is_active!=-1){
                    $filter_active = " AND is_active=".$is_active;
                    $status = $is_active == 1 ? 'Active' : 'Inactive';
                } 


                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $customers=$this->Customers_model->get_list('is_deleted=FALSE '.$filter.' '.$filter_active);



                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Customer Masterfile");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Customer Masterfile')
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Department : '.$department_name)
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','Status : '.$status)
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A9','')
                                        ->getStyle('A9')->getFont()->setItalic(TRUE);

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


                $excel->getActiveSheet()->getStyle('A10:G10')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A10','Customer Name')
                                        ->getStyle('A10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B10','Contact Name')
                                        ->getStyle('B10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C10','Contact No')
                                        ->getStyle('C10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D10','Address')
                                        ->getStyle('D10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E10','Email Address')
                                        ->getStyle('E10')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F10','TIN')
                                        ->getStyle('F10')->getFont()->setBold(TRUE);

                $i=11;



                foreach ($customers as $customer) {


                $excel->getActiveSheet()->setCellValue('A'.$i,$customer->customer_name)
                                        ->setCellValue('B'.$i,$customer->contact_name)
                                        ->setCellValue('C'.$i,$customer->contact_no)
                                        ->setCellValue('D'.$i,$customer->address)
                                        ->setCellValue('E'.$i,$customer->email_address)
                                        ->setCellValue('F'.$i,$customer->tin_no);
                $i++;

                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Customer Masterfile '.date('M-d-Y',NOW()).'.xlsx"');
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


    function response_rows($filter){
        return $this->Customers_model->get_list(
            $filter,

            'customers.*,departments.department_name,refcustomertype.customer_type',

            array(
                array('departments','departments.department_id=customers.department_id','left'),
                array('refcustomertype','refcustomertype.refcustomertype_id=customers.refcustomertype_id','left')
            )
        );
    }
}
            