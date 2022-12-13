<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Adjustments extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Adjustment_model');
        $this->load->model('Adjustment_item_model');
        $this->load->model('Customers_model');
        $this->load->model('Departments_model');
        $this->load->model('Products_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Trans_model');
        $this->load->model('Company_model');
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
            'is_deleted=FALSE'
        );


        $data['products']=$this->Products_model->get_list(

            'products.is_deleted=FALSE AND products.is_active=TRUE',

            array(
                'products.product_id',
                'products.product_code',
                'products.product_desc',
                'products.product_desc1',
                'products.is_tax_exempt',
                'FORMAT(products.sale_price,2)as sale_price',
                'FORMAT(products.purchase_cost,2)as purchase_cost',
                'products.unit_id',
                'units.unit_name'
            ),
            array(
                // parameter (table to join(left) , the reference field)
                array('units','units.unit_id=products.unit_id','left'),
                array('categories','categories.category_id=products.category_id','left')

            )

        );
        $data['customers']=$this->Customers_model->get_list(array("is_deleted"=>FALSE,"is_active"=>TRUE));
        $data['title'] = 'Inventory Adjustment';
        
        (in_array('11-3',$this->session->user_rights)? 
        $this->load->view('adjustment_view', $data)
        :redirect(base_url('dashboard')));

    }




    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $m_adjustment=$this->Adjustment_model;
                $response['data']=$this->response_rows(
                    "adjustment_info.is_active=TRUE AND adjustment_info.adjustment_type='IN' AND adjustment_info.is_deleted=FALSE
                    AND DATE(adjustment_info.date_adjusted) BETWEEN '$tsd' AND '$ted'
                    ".($id_filter==null?"":" AND adjustment_info.adjustment_id=".$id_filter)
                );
                echo json_encode($response);
                break;

             case 'adjustment-for-review': 
                $m_adjustment=$this->Adjustment_model;
                $response['data']=$m_adjustment->get_adjustments_for_review();
                echo json_encode($response);
                break;

            case 'list-for-approved':
                $m_adjustment=$this->Adjustment_model;
                $response['data']=$this->response_rows(
                    "adjustment_info.is_active=TRUE AND adjustment_info.adjustment_type='IN' AND adjustment_info.is_deleted=FALSE
                    AND adjustment_info.is_approved=FALSE
                    ".($id_filter==null?"":" AND adjustment_info.adjustment_id=".$id_filter)
                );
                echo json_encode($response);
                break;

            case 'mark-approved':  //this returns JSON of Issuance to be rendered on Datatable
                $m_adjustments=$this->Adjustment_model;
                $adjustment_id=$this->input->post('adjustment_id',TRUE); 

                $m_adjustments->set('date_approved','NOW()'); //treat NOW() as function and not string, set date of approval
                $m_adjustments->approved_by_user=$this->session->user_id; //deleted by user
                $m_adjustments->is_approved=1; //1 means approved
                if($m_adjustments->modify($adjustment_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Adjustment successfully approved.';
                    echo json_encode($response);
                }
                break;
    
            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Adjustment_item_model;
                $response['data']=$m_items->get_list(
                    array('adjustment_id'=>$id_filter),
                    array(
                        'adjustment_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'units.unit_id',
                        'units.unit_name',
                        'DATE_FORMAT(adjustment_items.exp_date,"%m/%d/%Y")as expiration'
                    ),
                    array(
                        array('products','products.product_id=adjustment_items.product_id','left'),
                        array('units','units.unit_id=adjustment_items.unit_id','left')
                    ),
                    'adjustment_items.adjustment_item_id DESC'
                );


                echo json_encode($response);
                break;


            //***************************************create new Items************************************************
            case 'create':
                $m_adjustment=$this->Adjustment_model;

                if(count($m_adjustment->get_list(array('adjustment_code'=>$this->input->post('adjustment_code',TRUE))))>0){
                    $response['title'] = 'Invalid!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Slip No. already exists.';

                    echo json_encode($response);
                    exit;
                }



                $m_adjustment->begin();

                //$m_adjustment->set('date_adjusted','NOW()'); //treat NOW() as function and not string
                $m_adjustment->set('date_created','NOW()'); //treat NOW() as function and not string


                $m_adjustment->department_id=$this->input->post('department',TRUE);
                $m_adjustment->adjustment_type='IN';
                $m_adjustment->remarks=$this->input->post('remarks',TRUE);
                $m_adjustment->inv_type_id=$this->input->post('inv_type_id',TRUE);
                $m_adjustment->is_returns=$this->input->post('adjustment_is_return',TRUE);
                $m_adjustment->customer_id=$this->input->post('customer_id',TRUE);
                $m_adjustment->inv_no=$this->input->post('inv_no',TRUE);
                $m_adjustment->date_adjusted=date('Y-m-d',strtotime($this->input->post('date_adjusted',TRUE)));
                $m_adjustment->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_adjustment->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_adjustment->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_adjustment->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_adjustment->posted_by_user=$this->session->user_id;
                $m_adjustment->save();

                $adjustment_id=$m_adjustment->last_insert_id();

                $m_adjustment_items=$this->Adjustment_item_model;

                $prod_id=$this->input->post('product_id',TRUE);
                $adjust_qty=$this->input->post('adjust_qty',TRUE);
                $adjust_price=$this->input->post('adjust_price',TRUE);
                $adjust_discount=$this->input->post('adjust_discount',TRUE);
                $adjust_global_discount=$this->input->post('adjust_global_discount',TRUE);
                $global_discount_amount=$this->input->post('global_discount_amount',TRUE);
                $adjust_line_total_discount=$this->input->post('adjust_line_total_discount',TRUE);
                $adjust_tax_rate=$this->input->post('adjust_tax_rate',TRUE);
                $adjust_line_total_price=$this->input->post('adjust_line_total_price',TRUE);
                $adjust_tax_amount=$this->input->post('adjust_tax_amount',TRUE);
                $adjust_non_tax_amount=$this->input->post('adjust_non_tax_amount',TRUE);
                $exp_date = $this->input->post('exp_date',TRUE);
                $batch_no = $this->input->post('batch_code',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_adjustment_items->adjustment_id=$adjustment_id;
                    $m_adjustment_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_adjustment_items->adjust_qty=$this->get_numeric_value($adjust_qty[$i]);
                    $m_adjustment_items->adjust_price=$this->get_numeric_value($adjust_price[$i]);
                    $m_adjustment_items->adjust_discount=$this->get_numeric_value($adjust_discount[$i]);
                    $m_adjustment_items->adjust_line_total_discount=$this->get_numeric_value($adjust_line_total_discount[$i]);
                    $m_adjustment_items->adjust_global_discount=$this->get_numeric_value($adjust_global_discount[$i]);
                    $m_adjustment_items->global_discount_amount=$this->get_numeric_value($global_discount_amount[$i]);
                    $m_adjustment_items->adjust_tax_rate=$this->get_numeric_value($adjust_tax_rate[$i]);
                    $m_adjustment_items->adjust_line_total_price=$this->get_numeric_value($adjust_line_total_price[$i]);
                    $m_adjustment_items->adjust_tax_amount=$this->get_numeric_value($adjust_tax_amount[$i]);
                    $m_adjustment_items->adjust_non_tax_amount=$this->get_numeric_value($adjust_non_tax_amount[$i]);
                    $m_adjustment_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_adjustment_items->batch_no=$batch_no[$i];

                    if($exp_date[$i]==null||$exp_date[$i]==""){
                        $response['title'] = 'Invalid Expiration!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'Expiration date is required.';
                        $response['current_row_index'] = $i;

                        die(json_encode($response));
                    }

                    //$m_adjustment_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                    $m_adjustment_items->unit_id=$unit_id[0]->unit_id;

                    $m_adjustment_items->save();
                }

                //update invoice number base on formatted last insert id
                $m_adjustment->adjustment_code='ADJ-'.date('Ymd').'-'.$adjustment_id;
                $m_adjustment->modify($adjustment_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=15; // TRANS TYPE
                $m_trans->trans_log='Created Adjustment No: ADJ-'.date('Ymd').'-'.$adjustment_id;
                $m_trans->save();

                $m_adjustment->commit();



                if($m_adjustment->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Items successfully Adjusted.';
                    $response['row_added']=$this->response_rows($adjustment_id);

                    echo json_encode($response);
                }


                break;


            ////***************************************update Items************************************************
            case 'update':
                $m_adjustment=$this->Adjustment_model;
                $adjustment_id=$this->input->post('adjustment_id',TRUE);


                $m_adjustment->begin();
                $m_adjustment->set('date_modified','NOW()'); 
                $m_adjustment->department_id=$this->input->post('department',TRUE);
                $m_adjustment->remarks=$this->input->post('remarks',TRUE);
                $m_adjustment->adjustment_type='IN';
                $m_adjustment->inv_type_id=$this->input->post('inv_type_id',TRUE);
                $m_adjustment->is_returns=$this->get_numeric_value($this->input->post('adjustment_is_return',TRUE));
                $m_adjustment->customer_id=$this->input->post('customer_id',TRUE);
                $m_adjustment->inv_no=$this->input->post('inv_no',TRUE);
                $m_adjustment->date_adjusted=date('Y-m-d',strtotime($this->input->post('date_adjusted',TRUE)));
                $m_adjustment->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_adjustment->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_adjustment->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_adjustment->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_adjustment->modified_by_user=$this->session->user_id;
                $m_adjustment->modify($adjustment_id);


                $m_adjustment_items=$this->Adjustment_item_model;

                $m_adjustment_items->delete_via_fk($adjustment_id); //delete previous items then insert those new

                $prod_id=$this->input->post('product_id',TRUE);
                $adjust_price=$this->input->post('adjust_price',TRUE);
                $adjust_discount=$this->input->post('adjust_discount',TRUE);
                $adjust_line_total_discount=$this->input->post('adjust_line_total_discount',TRUE);
                $adjust_global_discount=$this->input->post('adjust_global_discount',TRUE);
                $global_discount_amount=$this->input->post('global_discount_amount',TRUE);
                $adjust_tax_rate=$this->input->post('adjust_tax_rate',TRUE);
                $adjust_qty=$this->input->post('adjust_qty',TRUE);
                $adjust_line_total_price=$this->input->post('adjust_line_total_price',TRUE);
                $adjust_tax_amount=$this->input->post('adjust_tax_amount',TRUE);
                $adjust_non_tax_amount=$this->input->post('adjust_non_tax_amount',TRUE);
                $exp_date = $this->input->post('exp_date',TRUE);
                $batch_no = $this->input->post('batch_code',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_adjustment_items->adjustment_id=$adjustment_id;
                    $m_adjustment_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_adjustment_items->adjust_price=$this->get_numeric_value($adjust_price[$i]);
                    $m_adjustment_items->adjust_discount=$this->get_numeric_value($adjust_discount[$i]);
                    $m_adjustment_items->adjust_line_total_discount=$this->get_numeric_value($adjust_line_total_discount[$i]);
                    $m_adjustment_items->adjust_global_discount=$this->get_numeric_value($adjust_global_discount[$i]);
                    $m_adjustment_items->global_discount_amount=$this->get_numeric_value($global_discount_amount[$i]);
                    $m_adjustment_items->adjust_tax_rate=$this->get_numeric_value($adjust_tax_rate[$i]);
                    $m_adjustment_items->adjust_qty=$this->get_numeric_value($adjust_qty[$i]);
                    $m_adjustment_items->adjust_line_total_price=$this->get_numeric_value($adjust_line_total_price[$i]);
                    $m_adjustment_items->adjust_tax_amount=$this->get_numeric_value($adjust_tax_amount[$i]);
                    $m_adjustment_items->adjust_non_tax_amount=$this->get_numeric_value($adjust_non_tax_amount[$i]);
                    $m_adjustment_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_adjustment_items->batch_no=$batch_no[$i];

                    if($exp_date[$i]==null||$exp_date[$i]==""){
                        $response['title'] = 'Invalid Expiration!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'Expiration date is required.';
                        $response['current_row_index'] = $i;

                        die(json_encode($response));
                    }

                    //$m_adjustment_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');

                    $unit_id=$m_products->get_list(array('product_id'=>$prod_id[$i]));
                    $m_adjustment_items->unit_id=$unit_id[0]->unit_id;

                    $m_adjustment_items->save();



                }

                $adj_info=$m_adjustment->get_list($adjustment_id,'adjustment_code');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=15; // TRANS TYPE
                $m_trans->trans_log='Updated Adjustment No: '.$adj_info[0]->adjustment_code;
                $m_trans->save();

                $m_adjustment->commit();



                if($m_adjustment->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Adjusted items successfully updated.';
                    $response['row_updated']=$this->response_rows($adjustment_id);

                    echo json_encode($response);
                }


                break;


            //***************************************************************************************
            case 'delete':
                $m_adjustment=$this->Adjustment_model;
                $adjustment_id=$this->input->post('adjustment_id',TRUE);

                //mark Items as deleted
                $m_adjustment->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_adjustment->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_adjustment->is_deleted=1;//mark as deleted
                $m_adjustment->modify($adjustment_id);

                $adj_info=$m_adjustment->get_list($adjustment_id,'adjustment_code');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=15; // TRANS TYPE
                $m_trans->trans_log='Deleted Adjustment No: '.$adj_info[0]->adjustment_code;
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            //***************************************************************************************

            case 'export-product':
                $excel = $this->excel;

                $m_company_info=$this->Company_model;
                $m_adjustment_item=$this->Adjustment_item_model;

                $from = date('Y-m-d',strtotime($this->input->get('from')));
                $to = date('Y-m-d',strtotime($this->input->get('to')));
                $type = $this->input->get('type');


                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];
                $items=$m_adjustment_item->per_product($type, $from, $to);


                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1:B1')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2:C2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle("Item Adjustment per Product");
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->mergeCells('A1:B1');
                $excel->getActiveSheet()->mergeCells('A2:C2');
                $excel->getActiveSheet()->mergeCells('A3:B3');
                $excel->getActiveSheet()->mergeCells('A4:B4');

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->landline.'/'.$company_info[0]->mobile_no)
                                        ->setCellValue('A4',$company_info[0]->email_address);

                $excel->getActiveSheet()->setCellValue('A6','Item Adjustment per Product')
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Period : '.date('F d, Y', strtotime($from)).' to '.date('F d, Y', strtotime($to)))
                                        ->getStyle('A7')->getFont()->setItalic(TRUE);
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('40');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('25');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('15');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('J')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('K')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('L')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('M')->setWidth('40');
    

                $style_header = array(

                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb'=>'CCFF99'),
                    ),
                    'font' => array(
                        'bold' => true,
                    )
                );


                $excel->getActiveSheet()->getStyle('A9:M9')->applyFromArray( $style_header );

                $excel->getActiveSheet()->setCellValue('A9','Adjustment #')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Department')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Adjustment Type')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Date')
                                        ->getStyle('D9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E9','Product')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Product Type')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Qty')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Unit')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','Exp Date')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('J9','Batch No')
                                        ->getStyle('J9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('K9','Price')
                                        ->getStyle('K9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('L9','Total')
                                        ->getStyle('L9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('M9','Remarks')
                                        ->getStyle('M9')->getFont()->setBold(TRUE);

                $i=10;

                foreach ($items as $item) {
                    $excel->getActiveSheet()
                        ->setCellValue('A'.$i,$item->adjustment_code)
                        ->setCellValue('B'.$i,$item->department_name)
                        ->setCellValue('C'.$i,$item->adjustment_type)
                        ->setCellValue('D'.$i,$item->date_adjusted)
                        ->setCellValue('E'.$i,$item->product_desc)
                        ->setCellValue('F'.$i,$item->product_type)
                        ->setCellValue('G'.$i,$item->adjust_qty)
                        ->setCellValue('H'.$i,$item->unit_name)
                        ->setCellValue('I'.$i,$item->exp_date)
                        ->setCellValue('J'.$i,$item->batch_no)
                        ->setCellValue('K'.$i,$item->adjust_price)
                        ->setCellValue('L'.$i,$item->adjust_line_total_price)
                        ->setCellValue('M'.$i,$item->remarks);
                    $i++;
                }
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="Item Adjustment per Product '.date("F d, Y", strtotime($from)).' to '.date("F d, Y", strtotime($to)).'.xlsx"');
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
        return $this->Adjustment_model->get_list(
            $filter_value,
            array(
                'adjustment_info.*',
                'adjustment_info.adjustment_id',
                'adjustment_info.adjustment_code',
                'adjustment_info.remarks',
                'adjustment_info.adjustment_type',
                'adjustment_info.date_created',
                'adjustment_info.inv_no',
                'adjustment_info.customer_id',
                "IF(adjustment_info.is_returns = 1, 'Sales Return', 'Adjustment') as trans_type",
                'adjustment_info.is_returns as adjustment_is_return',
                'DATE_FORMAT(adjustment_info.date_adjusted,"%m/%d/%Y") as date_adjusted',
                'departments.department_id',
                'departments.department_name',
                'adjustment_info.is_approved'
            ),
            array(
                array('departments','departments.department_id=adjustment_info.department_id','left')
            )
        );
    }


//***************************************************************************************





}
