<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_invoice_other extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Sales_invoice_model');
        $this->load->model('Sales_invoice_item_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Sales_order_model');
        $this->load->model('Picklist_model');
        $this->load->model('Departments_model');
        $this->load->model('Customers_model');
        $this->load->model('Products_model');
        $this->load->model('Company_model');
        $this->load->model('Salesperson_model');
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
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE),
            'department_id,department_name,delivery_address'
        );

        //data required by active view
        // $data['customers']=$this->Customers_model->get_list(
        //     array('customers.is_active'=>TRUE,'customers.is_deleted'=>FALSE)
        // );

        $data['salespersons']=$this->Salesperson_model->get_list(
            array('salesperson.is_active'=>TRUE,'salesperson.is_deleted'=>FALSE),
            'salesperson_id, acr_name, CONCAT(firstname, " ", middlename, " ", lastname) AS fullname, firstname, middlename, lastname'
        );

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE'
        );

        $tax_rate=$this->Company_model->get_list(
            null,
            array(
                'company_info.tax_type_id',
                'tt.tax_rate'
            ),
            array(
                array('tax_types as tt','tt.tax_type_id=company_info.tax_type_id','left')
            )
        );

        $data['tax_percentage']=(count($tax_rate)>0?$tax_rate[0]->tax_rate:0);

        /*$data['products']=$this->Products_model->get_list(

            'products.is_deleted=FALSE AND products.is_active=TRUE',

            array(
                'products.product_id',
                'products.product_code',
                'products.product_desc' ,
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

        );*/


        // $data['products']=$this->Products_model->get_current_item_list();


        $data['title'] = 'Other Sales Invoice';
        
        (in_array('3-4',$this->session->user_rights)? 
        $this->load->view('sales_invoice_other_view', $data)
        :redirect(base_url('dashboard')));        
    }


    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'current-items':
                $type=$this->input->get('type');
                echo json_encode($this->Products_model->get_current_item_list($id_filter,$type));
                break;

            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $m_invoice=$this->Sales_invoice_model;
                $response['data']=$this->response_rows(
                    "sales_invoice.inv_type=2 AND sales_invoice.sales_invoice_id AND sales_invoice.is_active=TRUE AND sales_invoice.is_deleted=FALSE
                    AND DATE(sales_invoice.date_invoice) BETWEEN '$tsd' AND '$ted'
                    ".($id_filter==null?"":" AND sales_invoice.sales_invoice_id=".$id_filter)
                );
                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                
				$m_invoice=$this->Sales_invoice_model;
                $post_info = $m_invoice->get_list(
                    array(
                        'sales_invoice_id'=>$id_filter,
                        'is_journal_posted'=>1
                    )
                );
				$m_items=$this->Sales_invoice_item_model;
                $response['data']=$m_items->get_list(
                    array('sales_invoice_id'=>$id_filter),
                    array(
                        'sales_invoice_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'units.unit_id',
                        'units.unit_name'
                    ),
                    array(
                        array('products','products.product_id=sales_invoice_items.product_id','left'),
                        array('units','units.unit_id=sales_invoice_items.unit_id','left')
                    ),
                    'sales_invoice_items.sales_item_id DESC'
                );

                if(count($post_info)>0){
                    $response['post_status'] = 'posted';
                    $response['post_message'] = 'Sorry, you cannot edit this transaction because it was already posted in Sales Journal.';
                }

                echo json_encode($response);
                break;


            //***************************************create new Items************************************************
            case 'create':
                $m_invoice=$this->Sales_invoice_model;
                $m_customers=$this->Customers_model;

                if(count($m_invoice->get_list(array('sales_inv_no'=>$this->input->post('sales_inv_no',TRUE))))>0){
                    $response['title'] = 'Invalid!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Slip No. already exists.';

                    echo json_encode($response);
                    exit;
                }



                //get sales order id base on SO number
                $m_so=$this->Sales_order_model;
                $m_picklist=$this->Picklist_model;
                // $arr_so_info=$m_so->get_list(
                //     array('sales_order.so_no'=>$this->input->post('so_no',TRUE)),
                //     'sales_order.sales_order_id'
                // );
                $arr_so_info=$m_picklist->get_list(
                    array('picklist.picklist_no'=>$this->input->post('picklist_no',TRUE)),
                    'picklist.sales_order_id, picklist.picklist_id'
                );

                $sales_order_id=(count($arr_so_info)>0?$arr_so_info[0]->sales_order_id:0);
                $picklist_id=(count($arr_so_info)>0?$arr_so_info[0]->picklist_id:0);


                $m_invoice->begin();


                //check if department is already created as CUSTOMER
                $issue_department=$this->input->post('issue_to_department',TRUE);
                $link_customers=$m_customers->get_list(array('link_department_id'=>$issue_department));

                if(count($link_customers)>0){ //if exist
                    $m_departments=$this->Departments_model;
                    $link_department=$m_departments->get_list(array('department_id'=>$issue_department));

                    $m_customers->is_active=1;
                    $m_customers->is_deleted=0;
                    $m_customers->link_department_id=$link_department[0]->department_id;
                    $m_customers->customer_name=$link_department[0]->department_name;
                    $m_customers->modify(array('link_department_id'=>$issue_department));

                    $customer_id=$link_customers[0]->customer_id;

                }else{
                    $m_departments=$this->Departments_model;
                    $link_department=$m_departments->get_list(array('department_id'=>$issue_department));

                    $m_customers->link_department_id=$link_department[0]->department_id;
                    $m_customers->customer_name=$link_department[0]->department_name;
                    $m_customers->save();

                    $customer_id=$m_customers->last_insert_id();

                }

                //treat NOW() as function and not string
                $m_invoice->set('date_created','NOW()'); //treat NOW() as function and not string

                $m_invoice->customer_id=$customer_id;
                $m_invoice->department_id=$this->input->post('department_id',TRUE);
                $m_invoice->issue_to_department=$this->input->post('issue_to_department',TRUE);
                $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->sales_order_id=$sales_order_id;
                $m_invoice->picklist_id=$picklist_id;
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));                
                $m_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_invoice->inv_type=2;
                $m_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_invoice->posted_by_user=$this->session->user_id;
                $m_invoice->save();

                $sales_invoice_id=$m_invoice->last_insert_id();

                $m_invoice_items=$this->Sales_invoice_item_model;

                $prod_id=$this->input->post('product_id',TRUE);
                $inv_qty=$this->input->post('inv_qty',TRUE);
                $inv_price=$this->input->post('inv_price',TRUE);
                $inv_discount=$this->input->post('inv_discount',TRUE);
                $inv_line_total_discount=$this->input->post('inv_line_total_discount',TRUE);
                $inv_tax_rate=$this->input->post('inv_tax_rate',TRUE);
                $inv_line_total_price=$this->input->post('inv_line_total_price',TRUE);
                $inv_tax_amount=$this->input->post('inv_tax_amount',TRUE);
                $inv_non_tax_amount=$this->input->post('inv_non_tax_amount',TRUE);
                $dr_invoice_id=$this->input->post('dr_invoice_id',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $orig_so_price=$this->input->post('orig_so_price',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_items->sales_invoice_id=$sales_invoice_id;
                    $m_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_items->inv_qty=$this->get_numeric_value($inv_qty[$i]);
                    $m_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);
                    //$m_invoice_items->dr_invoice_id=$dr_invoice_id[$i];
                    $m_invoice_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_invoice_items->batch_no=$batch_no[$i];
                    $m_invoice_items->orig_so_price=$this->get_numeric_value($orig_so_price[$i]);
                    $m_invoice_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                    $m_invoice_items->unit_id=$unit_id[0]->unit_id;

                    $department_id = $this->input->post('department_id',TRUE);
                    $on_hand=$m_products->get_product_current_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])), $department_id);

                    if ($this->get_numeric_value($inv_qty[$i]) > $this->get_numeric_value($on_hand)) {
                        $prod_description=$unit_id[0]->product_desc;

                        $response['title'] = 'Insufficient!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'The item <b><u>'.$prod_description.'</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>'.number_format($on_hand,2).'</u></b>. <br /><br /> Item : <b>'.$prod_description.'</b><br /> Batch # : <b>'.$batch_no[$i].'</b><br />Expiration : <b>'.$exp_date[$i].'</b><br />On Hand : <b>'.number_format($on_hand,2).'</b><br />';
                        $response['current_row_index'] = $i;
                        die(json_encode($response));
                    }


                    $m_invoice_items->save();
                }

                //update invoice number base on formatted last insert id
                $m_invoice->sales_inv_no='INV-'.date('Ymd').'-'.$sales_invoice_id;
                $m_invoice->modify($sales_invoice_id);


                //update status of so
                $m_so->order_status_id=$this->get_so_status($sales_order_id);
                $m_so->modify($sales_order_id);

                //update status of picklist
                $m_picklist->picklist_status_id = 2;
                $m_picklist->modify($picklist_id);

                //******************************************************************************************
                // IMPORTANT!!!
                //update receivable amount field of customer table
                //$m_customers=$this->Customers_model;
                //$m_customers->recalculate_customer_receivable($this->input->post('customer',TRUE));
                //******************************************************************************************
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=101; // TRANS TYPE
                $m_trans->trans_log='Created Other Sales Invoice No: SAL-INV-'.date('Ymd').'-'.$sales_invoice_id;
                $m_trans->save();

                $m_invoice->commit();



                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Sales invoice successfully created.';
                    $response['row_added']=$this->response_rows($sales_invoice_id);

                    echo json_encode($response);
                }


                break;


            ////***************************************update Items************************************************
            case 'update':
                $m_invoice=$this->Sales_invoice_model;
                $m_customers=$this->Customers_model;
                $sales_invoice_id=$this->input->post('sales_invoice_id',TRUE);

                //get sales order id base on SO number
                $m_so=$this->Sales_order_model;
                $m_picklist=$this->Picklist_model;
                // $arr_so_info=$m_so->get_list(
                //     array('sales_order.so_no'=>$this->input->post('so_no',TRUE)),
                //     'sales_order.sales_order_id'
                // );
                $arr_so_info=$m_picklist->get_list(
                    array('picklist.picklist_no'=>$this->input->post('picklist_no',TRUE)),
                    'picklist.sales_order_id, picklist.picklist_id'
                );

                $sales_order_id=(count($arr_so_info)>0?$arr_so_info[0]->sales_order_id:0);
                $picklist_id=(count($arr_so_info)>0?$arr_so_info[0]->picklist_id:0);


                $m_invoice->begin();


                //check if department is already created as CUSTOMER
                $issue_department=$this->input->post('issue_to_department',TRUE);
                $link_customers=$m_customers->get_list(array('link_department_id'=>$issue_department));
                if(count($link_customers)>0){ //if exist
                    $m_departments=$this->Departments_model;
                    $link_department=$m_departments->get_list(array('department_id'=>$issue_department));

                    $m_customers->is_active=1;
                    $m_customers->is_deleted=0;
                    $m_customers->customer_name=$link_department[0]->department_name;
                    $m_customers->modify(array('link_department_id'=>$issue_department));

                    $customer_id=$link_customers[0]->customer_id;

                }else{
                    $m_departments=$this->Departments_model;
                    $link_department=$m_departments->get_list(array('department_id'=>$issue_department));

                    $m_customers->customer_name=$link_department[0]->department_name;
                    $m_customers->save();

                    $customer_id=$m_customers->last_insert_id();

                }

                $m_invoice->customer_id=$customer_id;
                $m_invoice->department_id=$this->input->post('department_id',TRUE);
                $m_invoice->remarks=$this->input->post('remarks',TRUE);
                $m_invoice->issue_to_department=$this->input->post('issue_to_department',TRUE);
                $m_invoice->address=$this->input->post('address',TRUE);
                $m_invoice->sales_order_id=$sales_order_id;
                $m_invoice->picklist_id=$picklist_id;
                $m_invoice->date_due=date('Y-m-d',strtotime($this->input->post('date_due',TRUE)));
                $m_invoice->date_invoice=date('Y-m-d',strtotime($this->input->post('date_invoice',TRUE)));
                $m_invoice->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_invoice->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));                
                $m_invoice->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_invoice->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_invoice->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_invoice->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_invoice->modified_by_user=$this->session->user_id;
                $m_invoice->modify($sales_invoice_id);


                $m_invoice_items=$this->Sales_invoice_item_model;

                $m_invoice_items->delete_via_fk($sales_invoice_id); //delete previous items then insert those new

                $prod_id=$this->input->post('product_id',TRUE);
                $inv_price=$this->input->post('inv_price',TRUE);
                $inv_discount=$this->input->post('inv_discount',TRUE);
                $inv_line_total_discount=$this->input->post('inv_line_total_discount',TRUE);
                $inv_tax_rate=$this->input->post('inv_tax_rate',TRUE);
                $inv_qty=$this->input->post('inv_qty',TRUE);
                $inv_line_total_price=$this->input->post('inv_line_total_price',TRUE);
                $inv_tax_amount=$this->input->post('inv_tax_amount',TRUE);
                $inv_non_tax_amount=$this->input->post('inv_non_tax_amount',TRUE);
                $dr_invoice_id=$this->input->post('dr_invoice_id',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);
                $batch_no=$this->input->post('batch_no',TRUE);
                $orig_so_price=$this->input->post('orig_so_price',TRUE);
                $cost_upon_invoice=$this->input->post('cost_upon_invoice',TRUE);

                $m_products=$this->Products_model;

                for($i=0;$i<count($prod_id);$i++){

                    $m_invoice_items->sales_invoice_id=$sales_invoice_id;
                    $m_invoice_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_invoice_items->inv_price=$this->get_numeric_value($inv_price[$i]);
                    $m_invoice_items->inv_discount=$this->get_numeric_value($inv_discount[$i]);
                    $m_invoice_items->inv_line_total_discount=$this->get_numeric_value($inv_line_total_discount[$i]);
                    $m_invoice_items->inv_tax_rate=$this->get_numeric_value($inv_tax_rate[$i]);
                    $m_invoice_items->inv_qty=$this->get_numeric_value($inv_qty[$i]);
                    $m_invoice_items->inv_line_total_price=$this->get_numeric_value($inv_line_total_price[$i]);
                    $m_invoice_items->inv_tax_amount=$this->get_numeric_value($inv_tax_amount[$i]);
                    $m_invoice_items->inv_non_tax_amount=$this->get_numeric_value($inv_non_tax_amount[$i]);
                    //$m_invoice_items->dr_invoice_id=$dr_invoice_id[$i];
                    $m_invoice_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));
                    $m_invoice_items->batch_no=$batch_no[$i];
                    $m_invoice_items->orig_so_price=$this->get_numeric_value($orig_so_price[$i]);
                    $m_invoice_items->cost_upon_invoice=$this->get_numeric_value($cost_upon_invoice[$i]);

                    //unit id retrieval is change, because of TRIGGER restriction
                    $unit_id=$m_products->get_list(array('product_id'=>$this->get_numeric_value($prod_id[$i])));
                    $m_invoice_items->unit_id=$unit_id[0]->unit_id;

                    $department_id = $this->input->post('department_id',TRUE);
                    $on_hand=$m_products->get_product_current_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])), $department_id);

                    if ($this->get_numeric_value($inv_qty[$i]) > $this->get_numeric_value($on_hand)) {
                        $prod_description=$unit_id[0]->product_desc;

                        $response['title'] = 'Insufficient!';
                        $response['stat'] = 'error';
                        $response['msg'] = 'The item <b><u>'.$prod_description.'</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>'.number_format($on_hand,2).'</u></b>. <br /><br /> Item : <b>'.$prod_description.'</b><br /> Batch # : <b>'.$batch_no[$i].'</b><br />Expiration : <b>'.$exp_date[$i].'</b><br />On Hand : <b>'.number_format($on_hand,2).'</b><br />';
                        $response['current_row_index'] = $i;
                        die(json_encode($response));
                    }



                    $m_invoice_items->save();
                }



                //update status of so
                $m_so->order_status_id=$this->get_so_status($sales_order_id);
                $m_so->modify($sales_order_id);

                //update status of picklist
                $m_picklist->picklist_status_id = 2;
                $m_picklist->modify($picklist_id);


                //******************************************************************************************
                // IMPORTANT!!!
                //update receivable amount field of customer table
                //$m_customers=$this->Customers_model;
                //$m_customers->recalculate_customer_receivable($this->input->post('customer',TRUE));
                //******************************************************************************************
                $sal_info=$m_invoice->get_list($sales_invoice_id,'sales_inv_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=101; // TRANS TYPE
                $m_trans->trans_log='Updated Other Sales Invoice No: '.$sal_info[0]->sales_inv_no;
                $m_trans->save();

                $m_invoice->commit();



                if($m_invoice->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Sales invoice successfully updated.';
                    $response['row_updated']=$this->response_rows($sales_invoice_id);

                    echo json_encode($response);
                }


                break;


            //***************************************************************************************
            case 'delete':
                $m_invoice=$this->Sales_invoice_model;
                $sales_invoice_id=$this->input->post('sales_invoice_id',TRUE);

                //mark Items as deleted
                $m_invoice->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_invoice->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_invoice->is_deleted=1;//mark as deleted
                $m_invoice->modify($sales_invoice_id);

                $sal_info=$m_invoice->get_list($sales_invoice_id,'sales_inv_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=101; // TRANS TYPE
                $m_trans->trans_log='Deleted Other Sales Invoice No: '.$sal_info[0]->sales_inv_no;
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            //***************************************************************************************
            case 'sales-for-review':
                $m_sales_invoice=$this->Sales_invoice_model;
                $response['data']=$m_sales_invoice->get_list(

                    array(
                        'sales_invoice.is_active'=>TRUE,
                        'sales_invoice.is_deleted'=>FALSE,
                        'sales_invoice.is_journal_posted'=>FALSE
                    ),

                    array(
                        'sales_invoice.sales_invoice_id',
                        'sales_invoice.sales_inv_no',
                        'sales_invoice.remarks',
                        'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                        'customers.customer_name'
                    ),

                    array(
                        array('customers','customers.customer_id=sales_invoice.customer_id','left')
                    )



                );
                echo json_encode($response);
                break;


        }

    }



//**************************************user defined*************************************************
    function response_rows($filter_value){
        return $this->Sales_invoice_model->get_list(
            $filter_value,
            array(
                'sales_invoice.total_overall_discount',
                'sales_invoice.sales_invoice_id',
                'sales_invoice.sales_inv_no',
                'sales_invoice.issue_to_department',
                'sales_invoice.remarks',
                'sales_invoice.address',
                'sales_invoice.date_created',
                'sales_invoice.customer_id',
                'sales_invoice.inv_type',
				'sales_invoice.is_journal_posted',
                'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
                'DATE_FORMAT(sales_invoice.date_due,"%m/%d/%Y") as date_due',
                'departments.department_id',
                'departments.department_name',
                'customers.customer_name',
                'sales_order.so_no',
                'picklist.picklist_no',
                'dd.department_name as issued_department'
            ),
            array(
                array('departments','departments.department_id=sales_invoice.department_id','left'),
                array('customers','customers.customer_id=sales_invoice.customer_id','left'),
                array('sales_order','sales_order.sales_order_id=sales_invoice.sales_order_id','left'),
                array('picklist', 'picklist.picklist_id=sales_invoice.picklist_id', 'left'),
                array('departments as dd','dd.department_id=sales_invoice.issue_to_department','left')
            ),null,'sales_invoice.sales_invoice_id'
        );
    }


    function get_so_status($id){
        //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
        $m_sales_invoice=$this->Sales_invoice_model;

        if(count($m_sales_invoice->get_list(
                array('sales_invoice.sales_order_id'=>$id,'sales_invoice.is_active'=>TRUE,'sales_invoice.is_deleted'=>FALSE),
                'sales_invoice.sales_invoice_id'))==0 ){ //means no SO found on sales invoice that means this so is still open

            return 1;

        }else{
            $m_so=$this->Sales_order_model;
            $row=$m_so->get_so_balance_qty($id);
            return ($row[0]->Balance>0?3:2);
        }

    }


//***************************************************************************************





}
