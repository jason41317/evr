<?php



defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_order extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->library('excel');

        $this->load->model('Sales_order_model');
        $this->load->model('Sales_order_item_model');
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
        $data['title'] = 'Sales Order';
        
        (in_array('3-1',$this->session->user_rights)? 
        $this->load->view('sales_order_view', $data)
        :redirect(base_url('dashboard')));
    }




    function transaction($txn = null,$id_filter=null,$picklist_id=null) {
        switch ($txn){
            case 'list':  //this returns JSON of Issuance to be rendered on Datatable
                $m_sales_order=$this->Sales_order_model;
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $salesperson_id = $this->input->get('salesperson_id');
                $status = $this->input->get('status');
                $status_finalize = $this->input->get('status_finalize');

                $response['data']=$this->response_rows(
                    "sales_order.is_active=TRUE AND sales_order.is_deleted=FALSE
                    AND DATE(sales_order.date_order) BETWEEN '$tsd' AND '$ted'
                    ".($salesperson_id==-1 || $salesperson_id==null?"":" AND sales_order.salesperson_id =".$salesperson_id)."
                    ".($status==0 || $status==null?"":" AND sales_order.order_status_id =".$status)."
                    ".($status_finalize==-1 || $status_finalize==null?"":" AND sales_order.is_finalized =".$status_finalize)."
                    ".($id_filter==null?"" :" AND sales_order.sales_order_id=".$id_filter)
                );
                echo json_encode($response);
                break;


                case 'product-lookup':
                    $m_products=$this->Products_model;
                    $type_id=$this->input->get('type');
                    $description=$this->input->get('description');
                    $department_id=$this->input->get('department_id');

                    echo json_encode($m_products->get_order_list($type_id,$description,$department_id));

                    //not 3 means show all product type
                    // echo json_encode(
                    //     $m_products->get_list(
                    //             "(products.product_code LIKE '".$description."%' OR products.product_desc LIKE '%".$description."%' OR products.product_desc1 LIKE '%".$description."%') AND products.is_deleted=FALSE ".($type_id==1||$type_id==2?" AND products.refproduct_id=".$type_id:""),

                    //         array(
                    //             'products.*',
                    //             'FORMAT(products.dealer_price,4) as dealer_price',
                    //             'FORMAT(products.distributor_price,4) as distributor_price',
                    //             'FORMAT(products.public_price,4) as public_price',
                    //             'FORMAT(products.discounted_price,4) as discounted_price',
                    //             'FORMAT(products.purchase_cost,4) as purchase_cost',
                    //             'FORMAT(products.sale_price,4) as sale_price',
                    //             'IFNULL(tax_types.tax_rate,0) as tax_rate',
                    //             'units.unit_name'
                    //         ),

                    //         array(
                    //             array('tax_types','tax_types.tax_type_id=products.tax_type_id','left'),
                    //             array('units','units.unit_id=products.unit_id','left')
                    //         )
                    //     )
                    // );
                    break;




            //***********************************************************************************************************
            case 'open':  //this returns PO that are already approved
                $m_sales_order=$this->Sales_order_model;
                //$where_filter=null,$select_list=null,$join_array=null,$order_by=null,$group_by=null,$auto_select_escape=TRUE,$custom_where_filter=null
                $response['data']= $m_sales_order->get_list(

                    'sales_order.is_deleted=FALSE AND sales_order.is_active=TRUE AND sales_order.is_finalized=TRUE AND (sales_order.order_status_id=1 OR sales_order.order_status_id=3)',

                    array(
                        'sales_order.*',
                        'DATE_FORMAT(sales_order.date_order,"%m/%d/%Y") as date_order',
                       ' DATE_FORMAT(sales_order.date_created,"%h:%i %p") as time_created',
                        'customers.customer_name',
                        'order_status.order_status',
                        'departments.department_name',
                        'IF(sales_order.address="",customers.address,sales_order.address) as address',
                        'CONCAT_WS(" ",salesperson.firstname,salesperson.middlename,salesperson.lastname) as salesperson'
                
                    ),
                    array(
                        array('customers','customers.customer_id=sales_order.customer_id','left'),
                        array('departments','departments.department_id=sales_order.department_id','left'),
                        array('salesperson','salesperson.salesperson_id=sales_order.salesperson_id','left'),
                        array('order_status','order_status.order_status_id=sales_order.order_status_id','left')
                    )

                );
                echo json_encode($response);
                break;

            case 'open_others':  //this returns PO that are already approved
                $m_sales_order=$this->Sales_order_model;
                //$where_filter=null,$select_list=null,$join_array=null,$order_by=null,$group_by=null,$auto_select_escape=TRUE,$custom_where_filter=null
                $response['data']= $m_sales_order->get_list(

                    'sales_order.is_deleted=FALSE AND sales_order.is_active=TRUE AND (sales_order.order_status_id=1 OR sales_order.order_status_id=3)',

                    array(
                        'sales_order.*',
                        'DATE_FORMAT(sales_order.date_order,"%m/%d/%Y") as date_order',
                       ' DATE_FORMAT(sales_order.date_created,"%h:%i %p") as time_created',
                        'customers.customer_name',
                        'order_status.order_status',
                        'departments.department_name',
                        'departments.delivery_address as address',
                        'CONCAT_WS(" ",salesperson.firstname,salesperson.middlename,salesperson.lastname) as salesperson'
                
                    ),
                    array(
                        array('customers','customers.customer_id=sales_order.customer_id','left'),
                        array('departments','departments.department_id=sales_order.department_id','left'),
                        array('salesperson','salesperson.salesperson_id=sales_order.salesperson_id','left'),
                        array('order_status','order_status.order_status_id=sales_order.order_status_id','left')
                    )

                );
                echo json_encode($response);
                break;

            ////****************************************items/products of selected Items***********************************************
            case 'item-balance':
                $id_filter = $this->input->get('id_filter',TRUE);
                $picklist_id = $this->input->get('picklist_id',TRUE);
                $m_items=$this->Sales_order_item_model;
                $response['data']=$m_items->get_products_with_balance_qty($id_filter,$picklist_id);
                echo json_encode($response);

                break;

            ////****************************************items/products of selected Items***********************************************
            case 'items': //items on the specific PO, loads when edit button is called
                $m_items=$this->Sales_order_item_model;
                $response['data']=$m_items->get_list(
                    array('sales_order_id'=>$id_filter),
                    array(
                        'sales_order_items.*',
                        'products.product_code',
                        'products.product_desc',
                        'products.size',
                        'units.unit_id',
                        'units.unit_name'
                    ),
                    array(
                        array('products','products.product_id=sales_order_items.product_id','left'),
                        array('units','units.unit_id=sales_order_items.unit_id','left')
                    ),
                    'sales_order_items.sales_order_item_id DESC'
                );


                echo json_encode($response);
                break;


            //***************************************create new Items************************************************
            case 'create':
                $m_sales_order=$this->Sales_order_model;

                if(count($m_sales_order->get_list(array('so_no'=>$this->input->post('so_no',TRUE))))>0){
                    $response['title'] = 'Invalid!';
                    $response['stat'] = 'error';
                    $response['msg'] = 'Slip No. already exists.';

                    echo json_encode($response);
                    exit;
                }




                $m_sales_order->begin();


                //treat NOW() as function and not string
                $m_sales_order->set('date_created','NOW()'); //treat NOW() as function and not string

                $m_sales_order->department_id=$this->input->post('department',TRUE);
                $m_sales_order->customer_id=$this->input->post('customer',TRUE);
                $m_sales_order->address=$this->input->post('address',TRUE);
                $m_sales_order->remarks=$this->input->post('remarks',TRUE);
                $m_sales_order->salesperson_id=$this->input->post('salesperson_id',TRUE);
                $m_sales_order->date_order=date('Y-m-d',strtotime($this->input->post('date_order',TRUE)));
                $m_sales_order->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_sales_order->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_sales_order->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_sales_order->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_sales_order->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_sales_order->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_sales_order->posted_by_user=$this->session->user_id;
                $m_sales_order->save();

                $sales_order_id=$m_sales_order->last_insert_id();

                $m_sales_order_items=$this->Sales_order_item_model;

                $prod_id=$this->input->post('product_id',TRUE);
                $so_qty=$this->input->post('so_qty',TRUE);
                $so_price=$this->input->post('so_price',TRUE);
                $so_discount=$this->input->post('so_discount',TRUE);
                $so_line_total_discount=$this->input->post('so_line_total_discount',TRUE);
                $so_tax_rate=$this->input->post('so_tax_rate',TRUE);
                $so_line_total_price=$this->input->post('so_line_total_price',TRUE);
                $so_tax_amount=$this->input->post('so_tax_amount',TRUE);
                $so_non_tax_amount=$this->input->post('so_non_tax_amount',TRUE);

                $batch_no=$this->input->post('batch_no',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);


                for($i=0;$i<count($prod_id);$i++){

                    $m_sales_order_items->sales_order_id=$sales_order_id;
                    $m_sales_order_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_sales_order_items->so_qty=$this->get_numeric_value($so_qty[$i]);
                    $m_sales_order_items->so_price=$this->get_numeric_value($so_price[$i]);
                    $m_sales_order_items->so_discount=$this->get_numeric_value($so_discount[$i]);
                    $m_sales_order_items->so_line_total_discount=$this->get_numeric_value($so_line_total_discount[$i]);
                    $m_sales_order_items->so_tax_rate=$this->get_numeric_value($so_tax_rate[$i]);
                    $m_sales_order_items->so_line_total_price=$this->get_numeric_value($so_line_total_price[$i]);
                    $m_sales_order_items->so_tax_amount=$this->get_numeric_value($so_tax_amount[$i]);
                    $m_sales_order_items->so_non_tax_amount=$this->get_numeric_value($so_non_tax_amount[$i]);

                    // $m_sales_order_items->batch_no=$batch_no[$i];
                    // $m_sales_order_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));

                    $m_sales_order_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                    $m_sales_order_items->save();
                }

                //update so number base on formatted last insert id
                $m_sales_order->so_no='SO-'.date('Ymd').'-'.$sales_order_id;
                $m_sales_order->modify($sales_order_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Created Sales Order No: SO-'.date('Ymd').'-'.$sales_order_id;
                $m_trans->save();


                $m_sales_order->commit();



                if($m_sales_order->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Sales order successfully created.';
                    $response['row_added']=$this->response_rows($sales_order_id);

                    echo json_encode($response);
                }


                break;


            ////***************************************update Items************************************************
            case 'update':
                $m_sales_order=$this->Sales_order_model;
                $sales_order_id=$this->input->post('sales_order_id',TRUE);


                //get sales order id base on SO number
                $m_so=$this->Sales_order_model;
                $arr_so_info=$m_so->get_list(
                    array('sales_order.so_no'=>$this->input->post('so_no',TRUE)),
                    'sales_order.sales_order_id'
                );
                // $sales_order_id=(count($arr_so_info)>0?$arr_so_info[0]->sales_order_id:0);



                $m_sales_order->begin();

                $m_sales_order->department_id=$this->input->post('department',TRUE);
                $m_sales_order->remarks=$this->input->post('remarks',TRUE);
                $m_sales_order->customer_id=$this->input->post('customer',TRUE);
                $m_sales_order->address=$this->input->post('address',TRUE);
                $m_sales_order->salesperson_id=$this->input->post('salesperson_id',TRUE);
                $m_sales_order->date_order=date('Y-m-d',strtotime($this->input->post('date_order',TRUE)));
                $m_sales_order->total_overall_discount=$this->get_numeric_value($this->input->post('total_overall_discount',TRUE));
                $m_sales_order->total_overall_discount_amount=$this->get_numeric_value($this->input->post('total_overall_discount_amount',TRUE));
                $m_sales_order->total_discount=$this->get_numeric_value($this->input->post('summary_discount',TRUE));
                $m_sales_order->total_before_tax=$this->get_numeric_value($this->input->post('summary_before_discount',TRUE));
                $m_sales_order->total_tax_amount=$this->get_numeric_value($this->input->post('summary_tax_amount',TRUE));
                $m_sales_order->total_after_tax=$this->get_numeric_value($this->input->post('summary_after_tax',TRUE));
                $m_sales_order->modified_by_user=$this->session->user_id;
                $m_sales_order->modify($sales_order_id);


                $m_sales_order_items=$this->Sales_order_item_model;

                $m_sales_order_items->delete_via_fk($sales_order_id); //delete previous items then insert those new

                $prod_id=$this->input->post('product_id',TRUE);
                $so_price=$this->input->post('so_price',TRUE);
                $so_discount=$this->input->post('so_discount',TRUE);
                $so_line_total_discount=$this->input->post('so_line_total_discount',TRUE);
                $so_tax_rate=$this->input->post('so_tax_rate',TRUE);
                $so_qty=$this->input->post('so_qty',TRUE);
                $so_line_total_price=$this->input->post('so_line_total_price',TRUE);
                $so_tax_amount=$this->input->post('so_tax_amount',TRUE);
                $so_non_tax_amount=$this->input->post('so_non_tax_amount',TRUE);

                $batch_no=$this->input->post('batch_no',TRUE);
                $exp_date=$this->input->post('exp_date',TRUE);

                for($i=0;$i<count($prod_id);$i++){

                    $m_sales_order_items->sales_order_id=$sales_order_id;
                    $m_sales_order_items->product_id=$this->get_numeric_value($prod_id[$i]);
                    $m_sales_order_items->so_price=$this->get_numeric_value($so_price[$i]);
                    $m_sales_order_items->so_discount=$this->get_numeric_value($so_discount[$i]);
                    $m_sales_order_items->so_line_total_discount=$this->get_numeric_value($so_line_total_discount[$i]);
                    $m_sales_order_items->so_tax_rate=$this->get_numeric_value($so_tax_rate[$i]);
                    $m_sales_order_items->so_qty=$this->get_numeric_value($so_qty[$i]);
                    $m_sales_order_items->so_line_total_price=$this->get_numeric_value($so_line_total_price[$i]);
                    $m_sales_order_items->so_tax_amount=$this->get_numeric_value($so_tax_amount[$i]);
                    $m_sales_order_items->so_non_tax_amount=$this->get_numeric_value($so_non_tax_amount[$i]);

                    // $m_sales_order_items->batch_no=$batch_no[$i];
                    // $m_sales_order_items->exp_date=date('Y-m-d', strtotime($exp_date[$i]));

                    $m_sales_order_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
                    $m_sales_order_items->save();
                }


                $sal_info=$m_sales_order->get_list($sales_order_id,'so_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Updated Sales Order No: '.$sal_info[0]->so_no;
                $m_trans->save();

                $m_sales_order->commit();



                if($m_sales_order->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Sales order successfully updated.';
                    $response['row_updated']=$this->response_rows($sales_order_id);

                    echo json_encode($response);
                }


                break;


            //***************************************************************************************
            case 'finalized':
                $m_sales_order=$this->Sales_order_model;
                $sales_order_id=$this->input->post('sales_order_id',TRUE);


                $m_sales_order->begin();

                $m_sales_order->is_finalized = 1;
                $m_sales_order->finalized_by_user = $this->session->user_id;
                $m_sales_order->set('finalized_datetime','NOW()');
                $m_sales_order->modify($sales_order_id);


                $sal_info=$m_sales_order->get_list($sales_order_id,'so_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Finalized : '.$sal_info[0]->so_no;
                $m_trans->save();

                $m_sales_order->commit();

                if($m_sales_order->status()===TRUE){
                    $response['title'] = 'Success!';
                    $response['stat'] = 'success';
                    $response['msg'] = 'Sales order successfully updated.';
                    //$response['row_updated']=$this->response_rows($sales_order_id);
                    $response['row_finalize']=$this->response_rows($sales_order_id);

                    echo json_encode($response);
                }

                break;

            case 'delete':
                $m_sales_order=$this->Sales_order_model;
                $sales_order_id=$this->input->post('sales_order_id',TRUE);

                //mark Items as deleted
                $m_sales_order->set('date_deleted','NOW()'); //treat NOW() as function and not string
                $m_sales_order->deleted_by_user=$this->session->user_id;//user that deleted the record
                $m_sales_order->is_deleted=1;//mark as deleted
                $m_sales_order->modify($sales_order_id);

                $sal_info=$m_sales_order->get_list($sales_order_id,'so_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=3; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Deleted Sales Order No: '.$sal_info[0]->so_no;
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully deleted.';
                echo json_encode($response);

                break;

            case 'close':
                $m_sales_order=$this->Sales_order_model;
                $sales_order_id=$this->input->post('sales_order_id',TRUE);

                $m_sales_order->set('date_closed','NOW()'); //treat NOW() as function and not string
                $m_sales_order->closed_by_user=$this->session->user_id;//user that closed the record
                $m_sales_order->is_closed=1;//mark as closed
                $m_sales_order->order_status_id=4;//mark as closed
                $m_sales_order->modify($sales_order_id);

                $sal_info=$m_sales_order->get_list($sales_order_id,'so_no');
                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=22; //CRUD
                $m_trans->trans_type_id=16; // TRANS TYPE
                $m_trans->trans_log='Closed Sales Order No: '.$sal_info[0]->so_no;
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Record successfully marked as closed.';
                $response['row_updated']=$this->response_rows($sales_order_id);
                echo json_encode($response);

                break;
            case 'export':
                $m_sales_order=$this->Sales_order_model;
                $as_of_date=date('Y-m-d',strtotime($this->input->get('as_of_date',TRUE)));

                $data = $m_sales_order->so_product_export($as_of_date);

                $excel=$this->excel;
                $excel->getDefaultStyle()->getNumberFormat()
                ->setFormatCode(
                    PHPExcel_Style_NumberFormat::FORMAT_TEXT
                );
                $excel->setActiveSheetIndex(0);
                $sheet = $excel->getActiveSheet();

                //name the worksheet
                // $sheet->setTitle('Inventory Report '.date('M d Y',strtotime($date)));
                $sheet->setTitle('Sales Order - For Picklist');

                $sheet->setCellValue('A1', 'Sales Order - For Picklist (' . $as_of_date . ')');
                $sheet->mergeCells('A1:Z1');

                $sheet
                    ->setCellValue('A2', 'PICKER: ')
                    ->setCellValue('A3', 'PICK START: ')
                    ->setCellValue('A4', 'PICK END: ')
                    ->setCellValue('C2', 'DISPATCHED BY:')
                    ->setCellValue('C3', 'LOADING START:')
                    ->setCellValue('C4', 'FINISHED:');


                //region col width
                $sheet->getColumnDimension('A')->setWidth('25');
                $sheet->getColumnDimension('B')->setWidth('25');
                $sheet->getColumnDimension('C')->setWidth('25');
                $sheet->getColumnDimension('D')->setWidth('25');
                $sheet->getColumnDimension('E')->setWidth('20');

                $sheet->getColumnDimension('F')->setWidth('20');
                $sheet->getColumnDimension('G')->setWidth('20');

                $sheet->getColumnDimension('H')->setWidth('30');

                $sheet->getColumnDimension('I')->setWidth('20');
                $sheet->getColumnDimension('J')->setWidth('20');
                $sheet->getColumnDimension('K')->setWidth('20');

                $sheet->getColumnDimension('L')->setWidth('20');
                $sheet->getColumnDimension('M')->setWidth('20');
                //endregion


                //region list header
                 $sheet->setCellValue('A6', 'LOCATION ID');
                 $sheet->setCellValue('B6', 'SALES ORDER NO.');
                 $sheet->setCellValue('C6', 'CUSTOMER');
 
                 $sheet->setCellValue('D6', 'DELIVERY ADDRESS');
                 $sheet->setCellValue('E6', 'SALES PERSON');
                 $sheet->setCellValue('F6', 'SKU');
 
                 $sheet->setCellValue('G6', 'ITEM CODE');
                 $sheet->setCellValue('H6', 'ITEM DESCRIPTION');
                 $sheet->setCellValue('I6', 'ORDER QTY');
 
                 $sheet->setCellValue('J6', 'PICK QTY');
                 $sheet->setCellValue('K6', 'ACTUAL QTY');
                 $sheet->setCellValue('L6', 'UOM');
                 $sheet->setCellValue('M6', 'EXPIRATION DATE');
                 //endregion

                //region rows
                // $rows=array();
                $i = 7;
                foreach($data as $product) {

                    $sheet
                        ->setCellValue('B'.$i, $product->so_no)
                        ->setCellValue('C'.$i, $product->customer_name)
                        ->setCellValue('D'.$i, $product->address)
                        ->setCellValue('E'.$i, $product->acr_name)
                        ->setCellValue('F'.$i, $product->product_code)
                        ->setCellValue('G'.$i, $product->product_code)
                        ->setCellValue('H'.$i, $product->product_desc)
                        ->setCellValue('I'.$i, $product->so_balance)
                        ->setCellValue('L'.$i, $product->unit_name);
                    $i++;
                }


                $sheet
                ->getStyle('A6:M6')
                ->getFill()
                ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFDBE2F1');


                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename=SalesOrder-'.$as_of_date.'.xlsx');
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

            //***************************************************************************************
        }

    }



//**************************************user defined*************************************************
    function response_rows($filter_value){

        return $this->Sales_order_model->get_list(

            $filter_value,

            array(
                'sales_order.total_overall_discount',
                'sales_order.total_overall_discount_amount',                
                'sales_order.sales_order_id',
                'sales_order.so_no',
                'sales_order.remarks',
                'sales_order.date_created',
                ' DATE_FORMAT(sales_order.date_created,"%h:%i %p") as time_created',
                'sales_order.customer_id',
                'sales_order.salesperson_id',
                'sales_order.address',
                'DATE_FORMAT(sales_order.date_order,"%m/%d/%Y") as date_order',
                'departments.department_id',
                'departments.department_name',
                'customers.customer_name',
                'sales_order.order_status_id',
                'order_status.order_status',
                'CONCAT_WS(" ",salesperson.firstname,salesperson.middlename,salesperson.lastname) as salesperson',
                'sales_order.is_finalized'
            ),

            array(
                array('departments','departments.department_id=sales_order.department_id','left'),
                array('salesperson','salesperson.salesperson_id=sales_order.salesperson_id','left'),
                array('customers','customers.customer_id=sales_order.customer_id','left'),
                array('order_status','order_status.order_status_id=sales_order.order_status_id','left')
            )


        );

    }





//***************************************************************************************





}
