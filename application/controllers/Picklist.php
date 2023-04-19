<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Picklist extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Picklist_model');
        $this->load->model('Picklist_item_model');
        $this->load->model('Sales_order_model');
        $this->load->model('Salesperson_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Products_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Trans_model');        

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

        $data['salespersons']=$this->Salesperson_model->get_list(
            array('salesperson.is_active'=>TRUE,'salesperson.is_deleted'=>FALSE),
            'salesperson_id, acr_name, CONCAT(firstname, " ", middlename, " ", lastname) AS fullname, firstname, middlename, lastname'
        );

        //data required by active view
        $data['customers']=$this->Customers_model->get_list(
            array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE),
                'customers.customer_id,
                customers.customer_name,
                customers.address'
        );

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE AND refproduct_id < 3'
        );

        // $data['products']=$this->Products_model->get_current_item_list();
        $data['title'] = 'Picklist';
        
        (in_array('3-6',$this->session->user_rights)? 
        $this->load->view('picklist_view', $data)
        :redirect(base_url('dashboard')));
    }




    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'list':  //this returns JSON of Picklist to be rendered on Datatable
                $m_picklist=$this->Picklist_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $salesperson_id = $this->input->get('salesperson_id');
                $status = $this->input->get('status');
                $response['data']=$this->response_rows(
                    "picklist.is_active=TRUE AND picklist.is_deleted=FALSE
                    AND DATE(picklist.date_pick) BETWEEN '$tsd' AND '$ted'
                    ".($salesperson_id==-1 || $salesperson_id==null?"":" AND picklist.salesperson_id =".$salesperson_id)."
                    ".($status==-1 || $status==null?"":" AND picklist.is_finalized =".$status)."
                    ".($id_filter==null?"" :" AND picklist.picklist_id=".$id_filter)
                );
                echo json_encode($response);
                break;


            case 'current-items-search':
              $type = $this->input->post('type');
              $department_id = $this->input->post('depid');
              $description = trim($this->input->post('description'));
              $response['data'] = $this->Products_model->get_current_item_list($description, $type, $department_id);

              echo json_encode($response);
              break;


            case 'items': //items on the specific Picklist, loads when edit button is called
                $m_items=$this->Picklist_item_model;
                $response['data']=$m_items->get_list(
                    array('picklist_id'=>$id_filter),
                    array(
                        'picklist_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'products.size',
                        'units.unit_id',
                        'units.unit_name'
                    ),
                    array(
                        array('products','products.product_id=picklist_items.product_id','left'),
                        array('units','units.unit_id=picklist_items.unit_id','left')
                    ),
                    'picklist_items.picklist_item_id DESC'
                );


                echo json_encode($response);
                break;


            //***************************************create new picklist************************************************
            case 'create':
                $m_picklist=$this->Picklist_model;
                $m_so=$this->Sales_order_model;

                if(count($m_picklist->get_list(array('picklist_no'=>$this->input->post('picklist_no',TRUE))))>0){
                    $response['title'] = 'Invalid!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Slip No. already exists.';

                    echo json_encode($response);
                    exit;
                }


                $picklist_count=$m_picklist->get_list(array('is_active'=>TRUE),array('COUNT(picklist_id) AS pl_count'));
                $picklist_new_id=((float)$picklist_count[0]->pl_count) + 1;


                $m_picklist->begin();


                //treat NOW() as function and not string
                $m_picklist->set('date_created','NOW()'); //treat NOW() as function and not string

                $sales_order_id=$this->input->post('sales_order_id',TRUE);

                $m_picklist->sales_order_id=$sales_order_id;
                $m_picklist->department_id=$this->input->post('department',TRUE);
                $m_picklist->customer_id=$this->input->post('customer',TRUE);
                $m_picklist->address=$this->input->post('address',TRUE);
                $m_picklist->remarks=$this->input->post('remarks',TRUE);
                $m_picklist->salesperson_id=$this->input->post('salesperson_id',TRUE);
                $m_picklist->date_pick=date('Y-m-d',strtotime($this->input->post('date_pick',TRUE)));
                $m_picklist->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_picklist->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_picklist->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_picklist->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_picklist->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_picklist->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_picklist->posted_by_user=$this->session->user_id;
                $m_picklist->save();

                $picklist_id=$m_picklist->last_insert_id();

                $m_picklist_items=$this->Picklist_item_model;

                $prod_id=$this->input->post('product_id',TRUE);
                $so_qty=$this->input->post('so_qty',TRUE);
                $so_price=$this->input->post('so_price',TRUE);
                $so_discount=$this->input->post('so_discount',TRUE);
                $so_line_total_discount=$this->input->post('so_line_total_discount',TRUE);
                $so_tax_rate=$this->input->post('so_tax_rate',TRUE);
                $so_line_total_price=$this->input->post('so_line_total_price',TRUE);
                $so_tax_amount=$this->input->post('so_tax_amount',TRUE);
                $so_non_tax_amount=$this->input->post('so_non_tax_amount',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $srp_cost=$this->input->post('srp_cost',TRUE);


                $m_products = $this->Products_model;


                for($i=0;$i<count($prod_id);$i++){
                    $m_picklist_items->picklist_id=$picklist_id;
                    $m_picklist_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_picklist_items->so_qty=$this->get_numeric_value($so_qty[$i]);
                    $m_picklist_items->so_price=$this->get_numeric_value($so_price[$i]);
                    $m_picklist_items->so_discount=$this->get_numeric_value($so_discount[$i]);
                    $m_picklist_items->so_line_total_discount=$this->get_numeric_value($so_line_total_discount[$i]);
                    $m_picklist_items->so_tax_rate=$this->get_numeric_value($so_tax_rate[$i]);
                    $m_picklist_items->so_line_total_price=$this->get_numeric_value($so_line_total_price[$i]);
                    $m_picklist_items->so_tax_amount=$this->get_numeric_value($so_tax_amount[$i]);
                    $m_picklist_items->so_non_tax_amount=$this->get_numeric_value($so_non_tax_amount[$i]);
                    $m_picklist_items->batch_no=$batch_no[$i];
                    $m_picklist_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_picklist_items->srp_cost=$this->get_numeric_value($srp_cost[$i]);

                    

                    $m_picklist_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                    $product_id = $m_products->get_list(array('product_id' => $this->get_numeric_value($prod_id[$i])));

                    $department_id = $this->input->post('department', TRUE);
                    $projected_on_hand = $m_products->get_product_projected_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])), $department_id);

                    if ($this->get_numeric_value($so_qty[$i]) > $this->get_numeric_value($projected_on_hand)) {
                        $prod_description = $product_id[0]->product_desc;

                        $response['title'] = 'Insufficient!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'The item <b><u>' . $prod_description . '</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>' . number_format($projected_on_hand, 2) . '</u></b>. <br /><br /> Item : <b>' . $prod_description . '</b><br /> Batch # : <b>' . $batch_no[$i] . '</b><br />Expiration : <b>' . $exp_date[$i] . '</b><br />On Hand : <b>' . number_format($projected_on_hand, 2) . '</b><br />';
                        $response['current_row_index'] = $i;
                        die(json_encode($response));
                    }


                    $m_picklist_items->save();
                }

                //update so number base on formatted last insert id
                $m_picklist->picklist_no='PL-'.date('Ymd').'-'.$picklist_new_id; //$picklist_id;
                $m_picklist->modify($picklist_id);


                //update status of so
                $m_so->order_status_id = $this->get_so_status($sales_order_id);
                $m_so->modify($sales_order_id);


                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Created Picklist No: PL-'.date('Ymd').'-'.$picklist_id;
                $m_trans->save();


                $m_picklist->commit();


                if($m_picklist->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Picklist successfully created.';
                    $response['row_added']=$this->response_rows($picklist_id);

                    echo json_encode($response);
                }


                break;


            //***************************************update picklist****************************************************
            case 'update':
                $m_picklist=$this->Picklist_model;
                $m_so=$this->Sales_order_model;
                $picklist_id=$this->input->post('picklist_id',TRUE);


                $m_picklist->begin();

                $sales_order_id=$this->input->post('sales_order_id',TRUE);

                $m_picklist->sales_order_id=$sales_order_id;
                $m_picklist->department_id=$this->input->post('department',TRUE);
                $m_picklist->remarks=$this->input->post('remarks',TRUE);
                $m_picklist->customer_id=$this->input->post('customer',TRUE);
                $m_picklist->address=$this->input->post('address',TRUE);
                $m_picklist->salesperson_id=$this->input->post('salesperson_id',TRUE);
                $m_picklist->date_pick=date('Y-m-d',strtotime($this->input->post('date_pick',TRUE)));
                $m_picklist->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_picklist->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_picklist->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_picklist->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_picklist->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_picklist->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_picklist->modified_by_user=$this->session->user_id;
                $m_picklist->modify($picklist_id);


                $m_picklist_items=$this->Picklist_item_model;

                $m_picklist_items->delete_via_fk($picklist_id); //delete previous items then insert those new

                $prod_id=$this->input->post('product_id',TRUE);
                $so_price=$this->input->post('so_price',TRUE);
                $so_discount=$this->input->post('so_discount',TRUE);
                $so_line_total_discount=$this->input->post('so_line_total_discount',TRUE);
                $so_tax_rate=$this->input->post('so_tax_rate',TRUE);
                $so_qty=$this->input->post('so_qty',TRUE);
                $so_line_total_price=$this->input->post('so_line_total_price',TRUE);
                $so_tax_amount=$this->input->post('so_tax_amount',TRUE);
                $so_non_tax_amount=$this->input->post('so_non_tax_amount',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $srp_cost=$this->input->post('srp_cost',TRUE);


                $m_products = $this->Products_model;


                for($i=0;$i<count($prod_id);$i++){

                    $m_picklist_items->picklist_id=$picklist_id;
                    $m_picklist_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_picklist_items->so_price=$this->get_numeric_value($so_price[$i]);
                    $m_picklist_items->so_discount=$this->get_numeric_value($so_discount[$i]);
                    $m_picklist_items->so_line_total_discount=$this->get_numeric_value($so_line_total_discount[$i]);
                    $m_picklist_items->so_tax_rate=$this->get_numeric_value($so_tax_rate[$i]);
                    $m_picklist_items->so_qty=$this->get_numeric_value($so_qty[$i]);
                    $m_picklist_items->so_line_total_price=$this->get_numeric_value($so_line_total_price[$i]);
                    $m_picklist_items->so_tax_amount=$this->get_numeric_value($so_tax_amount[$i]);
                    $m_picklist_items->so_non_tax_amount=$this->get_numeric_value($so_non_tax_amount[$i]);
                    $m_picklist_items->batch_no=$batch_no[$i];
                    $m_picklist_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_picklist_items->srp_cost=$this->get_numeric_value($srp_cost[$i]);

                    $m_picklist_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                    $product_id = $m_products->get_list(array('product_id' => $this->get_numeric_value($prod_id[$i])));

                    $department_id = $this->input->post('department', TRUE);
                    $projected_on_hand = $m_products->get_product_projected_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])), $department_id);

                    if ($this->get_numeric_value($so_qty[$i]) > $this->get_numeric_value($projected_on_hand)) {
                        $prod_description = $product_id[0]->product_desc;

                        $response['title'] = 'Insufficient!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'The item <b><u>' . $prod_description . '</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>' . number_format($projected_on_hand, 2) . '</u></b>. <br /><br /> Item : <b>' . $prod_description . '</b><br /> Batch # : <b>' . $batch_no[$i] . '</b><br />Expiration : <b>' . $exp_date[$i] . '</b><br />On Hand : <b>' . number_format($projected_on_hand, 2) . '</b><br />';
                        $response['current_row_index'] = $i;
                        die(json_encode($response));
                    }


                    $m_picklist_items->save();
                }


                //update status of so
                $m_so->order_status_id = $this->get_so_status($sales_order_id);
                $m_so->modify($sales_order_id);


                $sal_info=$m_picklist->get_list($picklist_id,'picklist_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Updated Picklist No: '.$sal_info[0]->picklist_no;
                $m_trans->save();

                $m_picklist->commit();



                if($m_picklist->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Picklist successfully updated.';
                    $response['row_updated']=$this->response_rows($picklist_id);

                    echo json_encode($response);
                }


                break;


            //***************************************delete picklist****************************************************
            case 'delete':
                $m_picklist=$this->Picklist_model;
                $m_so=$this->Sales_order_model;
                $picklist_id=$this->input->post('picklist_id',TRUE);

                //mark Items as deleted
                $m_picklist->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_picklist->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_picklist->is_deleted=1;//mark as deleted
                $m_picklist->modify($picklist_id);

                $sal_info=$m_picklist->get_list($picklist_id,'picklist_no, sales_order_id');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Deleted Picklist No: '.$sal_info[0]->picklist_no;
                $m_trans->save();

                //update status of so
                $m_so->order_status_id = 4;
                $m_so->modify($sal_info[0]->sales_order_id);

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            //***************************************finalize picklist**************************************************
            case 'finalize':
                $m_picklist=$this->Picklist_model;
                $picklist_id=$this->input->post('picklist_id',TRUE);

                $sal_info=$m_picklist->get_list($picklist_id,'picklist_id');

                $m_picklist->set('date_finalized','NOW()'); //treat NOW() as function and not string,set deletion date
                $m_picklist->finalized_by_user=$this->session->user_id; //user that delete this record
                $m_picklist->is_finalized=1;
                $m_picklist->modify($picklist_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=12; // TRANS TYPE
                $m_trans->trans_log='Finalized Picklist No: '.$sal_info[0]->picklist_id;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Picklist successfully finalized.';
                $response['row_finalize']=$this->response_rows($picklist_id);
                echo json_encode($response);

                break;

            //***************************************cancel picklist**************************************************
            case 'cancel':
                $m_picklist=$this->Picklist_model;
                $picklist_id=$this->input->post('picklist_id',TRUE);

                $sal_info=$m_picklist->get_list($picklist_id,'picklist_id');

                $m_picklist->set('date_canceled','NOW()'); //treat NOW() as function and not string,set deletion date
                $m_picklist->canceled_by_user=$this->session->user_id; //user that delete this record
                $m_picklist->is_canceled=1;
                $m_picklist->modify($picklist_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=8; //CRUD
                $m_trans->trans_type_id=12; // TRANS TYPE
                $m_trans->trans_log='Canceled Picklist No: '.$sal_info[0]->picklist_id;
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Picklist successfully canceled.';
                $response['row_cancel']=$this->response_rows($picklist_id);
                echo json_encode($response);

                break;

            //**********************************************************************************************************
            case 'open':
                $m_picklist=$this->Picklist_model;
                $response['data']= $m_picklist->get_list(

                    'picklist.is_deleted=FALSE AND picklist.is_active=TRUE AND picklist.is_finalized=TRUE AND picklist.is_canceled=FALSE AND (picklist.picklist_status_id=1 OR picklist.picklist_status_id=3)',

                    array(
                        'picklist.*',
                        'DATE_FORMAT(picklist.date_pick,"%m/%d/%Y") as date_pick',
                       ' DATE_FORMAT(picklist.date_created,"%h:%i %p") as time_created',
                        'customers.customer_name',
                        'order_status.order_status',
                        'departments.department_name',
                        'IF(picklist.address="",customers.address,picklist.address) as address',
                        'CONCAT_WS(" ",salesperson.firstname,salesperson.middlename,salesperson.lastname) as salesperson'
                    ),
                    array(
                        array('customers','customers.customer_id=picklist.customer_id','left'),
                        array('departments','departments.department_id=picklist.department_id','left'),
                        array('salesperson','salesperson.salesperson_id=picklist.salesperson_id','left'),
                        array('order_status','order_status.order_status_id=picklist.picklist_status_id','left')
                    )

                );
                echo json_encode($response);
                break;
        }

    }



//**************************************user defined*************************************************
    function response_rows($filter_value){

        return $this->Picklist_model->get_list(

            $filter_value,

            array(
                'picklist.total_overall_discount',
                'picklist.total_overall_discount_amount',
                'picklist.picklist_id',
                'picklist.picklist_no',
                'picklist.sales_order_id',
                'sales_order.so_no',
                'picklist.remarks',
                'picklist.date_created',
                'DATE_FORMAT(picklist.date_created,"%h:%i %p") as time_created',
                'picklist.customer_id',
                'picklist.salesperson_id',
                'picklist.address',
                'DATE_FORMAT(picklist.date_pick,"%m/%d/%Y") as date_pick',
                'departments.department_id',
                'departments.department_name',
                'customers.customer_name',
                'picklist.picklist_status_id',
                'order_status.order_status',
                'picklist.is_finalized',
                'picklist.is_canceled',
                'CONCAT_WS(" ",salesperson.firstname,salesperson.middlename,salesperson.lastname) as salesperson'
            ),

            array(
                array('sales_order','sales_order.sales_order_id=picklist.sales_order_id','left'),
                array('departments','departments.department_id=sales_order.department_id','left'),
                array('salesperson','salesperson.salesperson_id=sales_order.salesperson_id','left'),
                array('customers','customers.customer_id=sales_order.customer_id','left'),
                array('order_status','order_status.order_status_id=picklist.picklist_status_id','left')
            )


        );

    }

    function get_so_status($id)
    {
      //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
      $m_picklist = $this->Picklist_model;
  
      if (count($m_picklist->get_list(
        array('picklist.sales_order_id' => $id, 'picklist.is_active' => TRUE, 'picklist.is_deleted' => FALSE),
        'picklist.picklist_id'
      )) == 0) { //means no SO found on sales invoice that means this so is still open
  
        return 1;
      } else {
        $m_so = $this->Sales_order_model;
        $row = $m_so->get_so_balance_qty_picklist($id);
        return ($row[0]->Balance > 0 ? 3 : 2);
      }
    }
}
