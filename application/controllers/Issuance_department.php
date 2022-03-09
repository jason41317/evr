<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Issuance_department extends CORE_Controller
{
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Issuance_department_model');
        $this->load->model('Issuance_department_item_model');
        $this->load->model('Departments_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Products_model');
        $this->load->model('Company_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Users_model');
        $this->load->model('Trans_model');
        $this->load->model('Account_integration_model');
        $this->load->library('excel');

    }
    public function index() {
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);

        //data required by active view
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE',null,null,'refproduct.refproduct_id'
        );
        $data['accounts']=$this->Account_integration_model->get_list(1);
        $data['title'] = 'Issuance to Department';

        (in_array('11-1',$this->session->user_rights)? 
        $this->load->view('issuance_department_view', $data)
        :redirect(base_url('dashboard')));
        
    }
    function transaction($txn = null,$id_filter=null) {
        switch ($txn){

            case'close-invoice':  
            $m_invoice=$this->Issuance_department_model;
                $issuance_department_id =$this->input->post('issuance_department_id');
            if($this->input->post('trn_type') == 'From'){

                $m_invoice->closing_reason_from = $this->input->post('closing_reason');
                $m_invoice->closed_by_user_from = $this->session->user_id;
                $m_invoice->is_closed_from = TRUE;
                $m_invoice->modify($issuance_department_id);
            }else if($this->input->post('trn_type') == 'To'){
                $m_invoice->closing_reason_to = $this->input->post('closing_reason');
                $m_invoice->closed_by_user_to = $this->session->user_id;
                $m_invoice->is_closed_to = TRUE;
                $m_invoice->modify($issuance_department_id);
            }



            $iss_inv_no=$m_invoice->get_list($issuance_department_id,'trn_no');
            $m_trans=$this->Trans_model;
            $m_trans->user_id=$this->session->user_id;
            $m_trans->set('trans_date','NOW()');
            $m_trans->trans_key_id=11; //CRUD
            $m_trans->trans_type_id=66; // TRANS TYPE
            $m_trans->trans_log='Closed/Did Not Post Issuance Department '.$this->input->post('trn_type').' : '.$iss_inv_no[0]->trn_no.' from General Journal Pending with reason: '.$this->input->post('closing_reason');
            $m_trans->save();
            $response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Issuance Department successfully closed.';
            echo json_encode($response);    
            break;


            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_issuance=$this->Issuance_department_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $response['data']=$this->response_rows(
                    "issuance_department_info.is_active=TRUE AND issuance_department_info.is_deleted=FALSE AND DATE(issuance_department_info.date_issued) BETWEEN '$tsd' AND '$ted'".($id_filter==null?'':' AND issuance_department_info.issuance_department_id='.$id_filter)
                );
                echo json_encode($response);
                break;


            case 'issuance-department-for-review':  //this returns JSON of Issuance to be rendered on Datatable of accounting issuance
                $response['data']=$this->Issuance_department_model->issuance_department_for_review();
                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Issuance_department_item_model;
                $response['data']=$m_items->get_list(
                    array('issuance_department_id'=>$id_filter),
                    array(
                        'issuance_department_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'units.unit_id',
                        'units.unit_name'
                    ),
                    array(
                        array('products','products.product_id=issuance_department_items.product_id','left'),
                        array('units','units.unit_id=products.unit_id','left')
                    ),
                    'issuance_department_items.issuance_department_item_id DESC'
                );
                echo json_encode($response);
                break;

            //***************************************create new Items************************************************
            case 'create':
                $m_issuance=$this->Issuance_department_model;
                $m_products=$this->Products_model;

                if(count($m_issuance->get_list(array('trn_no'=>$this->input->post('trn_no',TRUE))))>0){
                    $response['title'] = 'Invalid!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Transfer No. already exists.';
                    echo json_encode($response);
                    exit;
                }
                $m_issuance->begin();
                $m_issuance->set('date_created','NOW()'); //treat NOW() as function and not string
                $m_issuance->remarks=$this->input->post('remarks',TRUE);
                $m_issuance->date_issued=date('Y-m-d',strtotime($this->input->post('date_issued',TRUE)));
                $m_issuance->terms=$this->input->post('terms',TRUE);
                $m_issuance->from_department_id=$this->input->post('from_department_id',TRUE);
                $m_issuance->to_department_id=$this->input->post('to_department_id',TRUE);

                // OK
                $m_issuance->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_issuance->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_issuance->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_issuance->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_issuance->posted_by_user=$this->session->user_id;
                $m_issuance->save();
                $issuance_department_id=$m_issuance->last_insert_id();
                $m_issue_items=$this->Issuance_department_item_model;
                $prod_id=$this->input->post('product_id',TRUE);
                $issue_qty=$this->input->post('issue_qty',TRUE);
                $issue_price=$this->input->post('issue_price',TRUE);
                $issue_discount=$this->input->post('issue_discount',TRUE);
                $issue_line_total_discount=$this->input->post('issue_line_total_discount',TRUE);
                $issue_tax_rate=$this->input->post('issue_tax_rate',TRUE);
                $issue_line_total_price=$this->input->post('issue_line_total_price',TRUE);
                $issue_tax_amount=$this->input->post('issue_tax_amount',TRUE);
                $issue_non_tax_amount=$this->input->post('issue_non_tax_amount',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);
        
                for($i=0;$i<count($prod_id);$i++){
                    $m_issue_items->issuance_department_id=$issuance_department_id;
                    $m_issue_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_issue_items->issue_qty=$this->get_numeric_value($issue_qty[$i]);
                    $m_issue_items->issue_price=$this->get_numeric_value($issue_price[$i]);
                    $m_issue_items->issue_discount=$this->get_numeric_value($issue_discount[$i]);
                    $m_issue_items->issue_line_total_discount=$this->get_numeric_value($issue_line_total_discount[$i]);
                    $m_issue_items->issue_tax_rate=$this->get_numeric_value($issue_tax_rate[$i]);
                    $m_issue_items->issue_line_total_price=$this->get_numeric_value($issue_line_total_price[$i]);
                    $m_issue_items->issue_tax_amount=$this->get_numeric_value($issue_tax_amount[$i]);
                    $m_issue_items->issue_non_tax_amount=$this->get_numeric_value($issue_non_tax_amount[$i]);
                    $m_issue_items->batch_no=$batch_no[$i];
                    $m_issue_items->exp_date=date('Y-m-d',strtotime($exp_date[$i]));
                    $m_issue_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                    $m_issue_items->unit_id=$unit_id[0]->unit_id;

                    $department_id=$this->input->post('from_department_id',TRUE);
                    $on_hand=$m_products->get_product_current_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])),$department_id);
                    
                    if ($this->get_numeric_value($issue_qty[$i]) > $this->get_numeric_value($on_hand)) {
                        $prod_description=$unit_id[0]->product_desc;

                        $response['title'] = 'Insufficient!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'The item <b><u>'.$prod_description.'</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>'.number_format($on_hand,2).'</u></b>. <br /><br /> Item : <b>'.$prod_description.'</b><br /> Batch # : <b>'.$batch_no[$i].'</b><br />Expiration : <b>'.$exp_date[$i].'</b><br />On Hand : <b>'.number_format($on_hand,2).'</b><br />';
                        $response['current_row_index'] = $i;
                        die(json_encode($response));
                    }

                    $m_issue_items->save();
                }

                //update invoice number base on formatted last insert id
                $m_issuance->trn_no='TRN-'.date('Ymd').'-'.$issuance_department_id;
                $m_issuance->modify($issuance_department_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=66; // TRANS TYPE
                $m_trans->trans_log='Created Issuance No: TRN-'.date('Ymd').'-'.$issuance_department_id;
                $m_trans->save();

                $m_issuance->commit();

                if($m_issuance->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Items successfully issued.';
                    $response['row_added']=$this->response_rows($issuance_department_id);
                    echo json_encode($response);
                }

                break;
            ////***************************************update Items************************************************
            case 'update':
                $m_issuance=$this->Issuance_department_model;
                $m_products=$this->Products_model;

                $issuance_department_id=$this->input->post('issuance_department_id',TRUE);
                $m_issuance->begin();

                $m_issuance->remarks=$this->input->post('remarks',TRUE);
                $m_issuance->date_issued=date('Y-m-d',strtotime($this->input->post('date_issued',TRUE)));
                $m_issuance->from_department_id=$this->input->post('from_department_id',TRUE);
                $m_issuance->to_department_id=$this->input->post('to_department_id',TRUE);
                $m_issuance->terms=$this->input->post('terms',TRUE);

                $m_issuance->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_issuance->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_issuance->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_issuance->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));

                $m_issuance->modified_by_user=$this->session->user_id;

                $m_issuance->modify($issuance_department_id);
                $m_issue_items = $this->Issuance_department_item_model;
                $m_issue_items->delete_via_fk($issuance_department_id); //delete previous items then insert those new
                $prod_id=$this->input->post('product_id',TRUE);
                $issue_price=$this->input->post('issue_price',TRUE);
                $issue_discount=$this->input->post('issue_discount',TRUE);
                $issue_line_total_discount=$this->input->post('issue_line_total_discount',TRUE);
                $issue_tax_rate=$this->input->post('issue_tax_rate',TRUE);
                $issue_qty=$this->input->post('issue_qty',TRUE);
                $issue_line_total_price=$this->input->post('issue_line_total_price',TRUE);
                $issue_tax_amount=$this->input->post('issue_tax_amount',TRUE);
                $issue_non_tax_amount=$this->input->post('issue_non_tax_amount',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);

                for($i=0;$i<count($prod_id);$i++){
                    $m_issue_items->issuance_department_id=$issuance_department_id;
                    $m_issue_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_issue_items->issue_price=$this->get_numeric_value($issue_price[$i]);
                    $m_issue_items->issue_discount=$this->get_numeric_value($issue_discount[$i]);
                    $m_issue_items->issue_line_total_discount=$this->get_numeric_value($issue_line_total_discount[$i]);
                    $m_issue_items->issue_tax_rate=$this->get_numeric_value($issue_tax_rate[$i]);
                    $m_issue_items->issue_qty=$this->get_numeric_value($issue_qty[$i]);
                    $m_issue_items->issue_line_total_price=$this->get_numeric_value($issue_line_total_price[$i]);
                    $m_issue_items->issue_tax_amount=$this->get_numeric_value($issue_tax_amount[$i]);
                    $m_issue_items->issue_non_tax_amount=$this->get_numeric_value($issue_non_tax_amount[$i]);
                    $m_issue_items->batch_no=$batch_no[$i];
                    $m_issue_items->exp_date=date('Y-m-d',strtotime($exp_date[$i]));
                    $m_issue_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);   

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                    $m_issue_items->unit_id=$unit_id[0]->unit_id;

                    $department_id=$this->input->post('from_department_id',TRUE);
                    $on_hand=$m_products->get_product_current_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])), $department_id);
                    
                    if ($this->get_numeric_value($issue_qty[$i]) > $this->get_numeric_value($on_hand)) {
                        $prod_description=$unit_id[0]->product_desc;

                        $response['title'] = 'Insufficient!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'The item <b><u>'.$prod_description.'</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>'.number_format($on_hand,2).'</u></b>. <br /><br /> Item : <b>'.$prod_description.'</b><br /> Batch # : <b>'.$batch_no[$i].'</b><br />Expiration : <b>'.$exp_date[$i].'</b><br />On Hand : <b>'.number_format($on_hand,2).'</b><br />';
                        $response['current_row_index'] = $i;
                        die(json_encode($response));
                    }

                    $m_issue_items->save();
                }


                $iss_info=$m_issuance->get_list($issuance_department_id,'trn_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=66; // TRANS TYPE
                $m_trans->trans_log='Updated Issuance No: '.$iss_info[0]->trn_no;
                $m_trans->save();
                $m_issuance->commit();

                if($m_issuance->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Issue items successfully updated.';
                    $response['row_updated']=$this->response_rows($issuance_department_id);
                    echo json_encode($response);
                }

                break;
            //***************************************************************************************
            case 'delete':
                $m_issuance=$this->Issuance_department_model;
                $m_issuance_items=$this->Issuance_department_item_model;
                $issuance_department_id=$this->input->post('issuance_department_id',TRUE);
                //mark Items as deleted
                $m_issuance->set('date_deleted','NOW()'); //treat NOW() as function and not string, set deletion date
                $m_issuance->deleted_by_user=$this->session->user_id;
                $m_issuance->is_deleted=1;
                $m_issuance->modify($issuance_department_id);
                //update product on_hand after issuance is deleted...

                //end update product on_hand after issuance is deleted...
                $iss_info=$m_issuance->get_list($issuance_department_id,'trn_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=66; // TRANS TYPE
                $m_trans->trans_log='Deleted Transfer Issuance No: '.$iss_info[0]->trn_no;
                $m_trans->save();
                
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);
                break;
            //***************************************************************************************

            case 'export':
                $excel = $this->excel;

                $m_company_info=$this->Company_model;

                $from = date('Y-m-d',strtotime($this->input->get('from')));
                $to = date('Y-m-d',strtotime($this->input->get('to')));


                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $issuances=$this->response_rows(
                    "issuance_department_info.is_active=TRUE AND issuance_department_info.is_deleted=FALSE AND DATE(issuance_department_info.date_issued) BETWEEN '$from' AND '$to'"
                );


                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Item Transfer");
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
                $excel->getActiveSheet()->setCellValue('A7','Period : '.date('F d, Y', strtotime($from)).' to '.date('F d, Y', strtotime($to)))
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('40');
    

                $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:D9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','Transfer #')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','From Department')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','To Department')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Remarks')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);

                $i=10;



                foreach ($issuances as $issuance) {
                    $excel->getActiveSheet()
                        ->setCellValue('A'.$i,$issuance->trn_no)
                        ->setCellValue('B'.$i,$issuance->from_department_name)
                        ->setCellValue('C'.$i,$issuance->to_department_name)
                        ->setCellValue('D'.$i,$issuance->remarks);
                    $i++;
                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Item Transfer '.date("F d, Y", strtotime($from)).' to '.date("F d, Y", strtotime($to)).'.xlsx"');
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
//**************************************user defined*************************************************
    function response_rows($filter_value){
        return $this->Issuance_department_model->get_list(
            $filter_value,
            array(
                'issuance_department_info.issuance_department_id',
                'issuance_department_info.trn_no',
                'issuance_department_info.remarks',
                'issuance_department_info.from_department_id',
                'issuance_department_info.to_department_id',
                'issuance_department_info.date_created',
                'DATE_FORMAT(issuance_department_info.date_issued,"%m/%d/%Y") as date_issued',
                'issuance_department_info.terms',
                'departments.department_id',
                'departments.department_name as to_department_name',
                'depfrom.department_name as from_department_name',
                'issuance_department_info.is_journal_posted_from',
                'issuance_department_info.is_journal_posted_to'
            ),
            array(
                array('departments','departments.department_id=issuance_department_info.to_department_id','left'),
                array('departments as depfrom','depfrom.department_id=issuance_department_info.from_department_id','left')
                //array('customers','customers.customer_id=issuance_info.issued_to_person','left')
            ),
            'issuance_department_info.issuance_department_id DESC'
        );
    }
//***************************************************************************************
}
