<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->library('excel');
        $this->load->model('Products_model');
        $this->load->model('Departments_model');
        $this->load->model('Categories_model');
        $this->load->model('Units_model');
        $this->load->model('Item_type_model');
        $this->load->model('Account_title_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Tax_model');
        $this->load->model('Sales_invoice_model');
        $this->load->model('Sales_invoice_item_model');
        $this->load->model('Trans_model');        
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Product Management';
        $data['tax_types']=$this->Tax_model->get_list();
        $data['suppliers']=$this->Suppliers_model->get_list(
            array('suppliers.is_deleted'=>FALSE,'suppliers.is_active'=>TRUE),
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );
        $data['refproduct'] = $this->Refproduct_model->get_list(array('refproduct.is_deleted'=>FALSE));
        $data['categories'] = $this->Categories_model->get_list(array('categories.is_deleted'=>FALSE));
        $data['units'] = $this->Units_model->get_list(array('units.is_deleted'=>FALSE));
        $data['item_types'] = $this->Item_type_model->get_list(array('item_types.is_deleted'=>FALSE));
        $data['accounts'] = $this->Account_title_model->get_list('is_active=TRUE AND is_deleted=FALSE','account_id,account_title');
        $data['tax_types']=$this->Tax_model->get_list(array('tax_types.is_deleted'=>FALSE));

        (in_array('5-1',$this->session->user_rights)? 
        $this->load->view('products_view', $data)
        :redirect(base_url('dashboard')));        
    }

    function transaction($txn = null) {
        switch ($txn) {

            case 'list-single':
                $product_id=$this->input->get('id');
                $m_products = $this->Products_model;
                $balance_as_of = $m_products->get_product_balance_as_of_date($product_id,date('Y-m-d'))[0]; 
                $response['onhand']=$balance_as_of;
                $response['data']=$this->response_rows($product_id);
                echo json_encode($response);
                break;


            case 'list':
                $m_products = $this->Products_model;
                $response['data']=$this->response_rows(array('products.is_deleted'=>FALSE));
                echo json_encode($response);
                break;

            case 'getproduct':
                $refproduct_id = $this->input->post('refproduct_id', TRUE);
                $is_active = $this->input->post('is_active', TRUE);
                $get = "";
                
                if($refproduct_id == 3){
                    $get = array('products.is_deleted'=>FALSE);
                    if ($is_active != -1) {
                        $get = array('products.is_deleted' => FALSE, 'products.is_active' => $is_active);
                    }
                }else{
                    $get = array('products.refproduct_id'=>$refproduct_id,'products.is_deleted'=>FALSE);
                    if ($is_active != -1) {
                        $get = array('products.refproduct_id'=>$refproduct_id,'products.is_deleted'=>FALSE, 'products.is_active' => $is_active);
                    }
                }
                
                $response['data'] = $this->response_rows($get);
                echo json_encode($response);
                break;

            case 'create':
                $m_products = $this->Products_model;

                $m_products->set('date_created','NOW()');
                $m_products->created_by_user = $this->session->user_id;

                $m_products->product_code = $this->input->post('product_code', TRUE);
                $m_products->product_desc = str_replace("'", "", $this->input->post('product_desc', TRUE));
                $m_products->product_desc1 = str_replace("'", "", $this->input->post('product_desc1', TRUE));
                $m_products->size = $this->input->post('size', TRUE);
                $m_products->supplier_id = $this->input->post('supplier_id', TRUE);
                $m_products->category_id = $this->input->post('category_id', TRUE);
                $m_products->refproduct_id = $this->input->post('refproduct_id', TRUE);
                $m_products->item_type_id = $this->input->post('item_type_id', TRUE);
                $m_products->income_account_id = $this->input->post('income_account_id', TRUE);
                $m_products->expense_account_id = $this->input->post('expense_account_id', TRUE);
                $m_products->cos_account_id = $this->input->post('cos_account_id', TRUE);
                $m_products->sales_return_account_id = $this->input->post('sales_return_account_id', TRUE);
                $m_products->sd_account_id = $this->input->post('sd_account_id', TRUE);
                $m_products->po_return_account_id = $this->input->post('po_return_account_id', TRUE);
                $m_products->pd_account_id = $this->input->post('pd_account_id', TRUE);
                $m_products->unit_id = $this->input->post('unit_id', TRUE);

                $m_products->tax_type_id = $this->input->post('tax_type_id', TRUE);
                //$m_products->is_inventory = $this->input->post('inventory',TRUE);

                 //im not sure, why posted checkbox post value of 0 when checked
                $m_products->is_tax_exempt =($this->input->post('is_tax_exempt',TRUE)==null?0:1);

                $m_products->equivalent_points = $this->get_numeric_value($this->input->post('equivalent_points', TRUE));
                $m_products->product_warn =$this->get_numeric_value( $this->input->post('product_warn', TRUE));
                $m_products->product_ideal =$this->get_numeric_value( $this->input->post('product_ideal', TRUE));
                //$m_products->markup_percent = $this->input->post('markup_percent', TRUE);
                $m_products->sale_price =$this->get_numeric_value($this->input->post('sale_price', TRUE));
                $m_products->purchase_cost =$this->get_numeric_value($this->input->post('purchase_cost', TRUE));
                $m_products->purchase_cost_2 =$this->get_numeric_value($this->input->post('purchase_cost_2', TRUE));
                $m_products->discounted_price =$this->get_numeric_value($this->input->post('discounted_price', TRUE));
                $m_products->dealer_price =$this->get_numeric_value($this->input->post('dealer_price', TRUE));
                $m_products->distributor_price =$this->get_numeric_value($this->input->post('distributor_price', TRUE));
                $m_products->public_price =$this->get_numeric_value($this->input->post('public_price', TRUE));

                $m_products->save();

                $product_id = $m_products->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=50; // TRANS TYPE
                $m_trans->trans_log='Created a new Product: '.$this->input->post('product_desc', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Product Information successfully created.';

                $response['row_added'] = $this->response_rows($product_id);
                echo json_encode($response);

                break;

            case 'update':
                $m_products=$this->Products_model;

                $product_id=$this->input->post('product_id',TRUE);

                $m_products->set('date_modified','NOW()');
                $m_products->modified_by_user = $this->session->user_id;

                $m_products->product_code = $this->input->post('product_code', TRUE);
                $m_products->product_desc = str_replace("'", "", $this->input->post('product_desc', TRUE));
                $m_products->product_desc1 = str_replace("'", "", $this->input->post('product_desc1', TRUE));
                $m_products->size = $this->input->post('size', TRUE);
                $m_products->supplier_id = $this->input->post('supplier_id', TRUE);
                $m_products->category_id = $this->input->post('category_id', TRUE);
                $m_products->refproduct_id = $this->input->post('refproduct_id', TRUE);
                $m_products->item_type_id = $this->input->post('item_type_id', TRUE);
                $m_products->income_account_id = $this->input->post('income_account_id', TRUE);
                $m_products->expense_account_id = $this->input->post('expense_account_id', TRUE);
                $m_products->cos_account_id = $this->input->post('cos_account_id', TRUE);
                $m_products->sales_return_account_id = $this->input->post('sales_return_account_id', TRUE);
                $m_products->sd_account_id = $this->input->post('sd_account_id', TRUE);
                $m_products->po_return_account_id = $this->input->post('po_return_account_id', TRUE);
                $m_products->pd_account_id = $this->input->post('pd_account_id', TRUE);
                $m_products->unit_id = $this->input->post('unit_id', TRUE);
                $m_products->tax_type_id = $this->input->post('tax_type_id', TRUE);
                //$m_products->is_inventory = $this->input->post('inventory',TRUE);

                //im not sure, why posted checkbox post value of 0 when checked
                $m_products->is_tax_exempt =($this->input->post('is_tax_exempt',TRUE)==null?0:1);


                $m_products->equivalent_points = $this->get_numeric_value($this->input->post('equivalent_points', TRUE));
                $m_products->product_warn =$this->get_numeric_value( $this->input->post('product_warn', TRUE));
                $m_products->product_ideal =$this->get_numeric_value( $this->input->post('product_ideal', TRUE));
                //$m_products->markup_percent = $this->input->post('markup_percent', TRUE);
                $m_products->sale_price =$this->get_numeric_value($this->input->post('sale_price', TRUE));
                $m_products->purchase_cost =$this->get_numeric_value($this->input->post('purchase_cost', TRUE));
                $m_products->purchase_cost_2 =$this->get_numeric_value($this->input->post('purchase_cost_2', TRUE));
                $m_products->discounted_price =$this->get_numeric_value($this->input->post('discounted_price', TRUE));
                $m_products->dealer_price =$this->get_numeric_value($this->input->post('dealer_price', TRUE));
                $m_products->distributor_price =$this->get_numeric_value($this->input->post('distributor_price', TRUE));
                $m_products->public_price =$this->get_numeric_value($this->input->post('public_price', TRUE));


                $m_products->modify($product_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=50; // TRANS TYPE
                $m_trans->trans_log='Updated Product : '.$this->input->post('product_desc', TRUE).' ID('.$product_id.')';
                $m_trans->save();

                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Product information successfully updated.';
                $response['row_updated']=$this->response_rows($product_id);
                echo json_encode($response);

                break;


            case 'delete':
                $m_products=$this->Products_model;

                $product_id=$this->input->post('product_id',TRUE);

                $m_products->set('date_deleted','NOW()');
                $m_products->deleted_by_user = $this->session->user_id;
                $m_products->is_deleted=1;
                if($m_products->modify($product_id)){

                    $product_desc= $m_products->get_list($product_id,'product_desc');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=50; // TRANS TYPE
                    $m_trans->trans_log='Deleted Product: '.$product_desc[0]->product_desc;
                    $m_trans->save();
                                        
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Product information successfully deleted.';
                    echo json_encode($response);
                }

                break;

            case 'activate-deactivate':
                $m_products=$this->Products_model;

                $product_id=$this->input->post('product_id',TRUE);

                // $m_products->set('date_deleted','NOW()');
                $m_products->is_active = $this->input->post('is_active',TRUE) ? 1 : 0;
                // $m_products->is_deleted=1;
                if($m_products->modify($product_id)){

                    $product_desc= $m_products->get_list($product_id,'product_desc');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=2; //CRUD
                    $m_trans->trans_type_id=50; // TRANS TYPE
                    $m_trans->trans_log='Updated Set as '.$m_products->is_active ? 'Active' : 'Inactive' .' Product: '.$product_desc[0]->product_desc;
                    $m_trans->save();
                                        
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Product information successfully '.($m_products->is_active ? 'Activated' : 'Deactivated').'.';
                    $response['row_updated']=$this->response_rows($product_id);
                    echo json_encode($response);
                }

                break;

            case 'product-history':
                $product_id=$this->input->get('id');
                $depid=$this->input->get('depid');
                $type=$this->input->get('type');
                $as_of_date = $this->input->get('date');

                $m_products=$this->Products_model;

                $previous_date = date('Y-m-01', strtotime($as_of_date));
                $current_date = date('Y-m-d', strtotime($as_of_date));

                $balance_as_of = $m_products->get_product_balance_as_of_date($product_id,$previous_date,$depid)[0]; 
                $data['balance_as_of'] =$balance_as_of;
                $data['products']=$m_products->get_product_history($product_id,$previous_date,$current_date,$balance_as_of->balance,$depid);
                $data['product_id']=$product_id;
                $data['as_of_date'] = $previous_date;

                if($type <= 0){
                    $this->load->view('template/product_history_menus',$data);
                }else{
                    $this->load->view('template/product_history',$data);
                }
                break;

            case 'get-current-invoice-cost':
                $m_inv=$this->Sales_invoice_model;
                $m_inv_items=$this->Sales_invoice_item_model;

                $inv_no=$this->input->post('refno');
                $expdate=$this->input->post('expdate');
                $bid=$this->input->post('bid');
                $pid=$this->input->post('pid');

                $inv_id=$m_inv->get_list(array('sales_inv_no'=>$inv_no));
                $id=$inv_id[0]->sales_invoice_id;

                $cost=$m_inv_items->get_list(array(
                    'product_id'=>$pid,
                    'batch_no'=>$bid,
                    'exp_date'=>$expdate,
                    'sales_invoice_id'=>$id
                ));

                $response['cost']=$cost[0]->cost_upon_invoice;
                echo json_encode($response);
                break;
            case 'update-cost':
                $m_inv=$this->Sales_invoice_model;
                $m_inv_items=$this->Sales_invoice_item_model;

                $inv_no=$this->input->post('refno');
                $expdate=$this->input->post('expdate');
                $bid=$this->input->post('bid');
                $pid=$this->input->post('pid');
                $cost=$this->get_numeric_value($this->input->post('cost'));

                $inv_id=$m_inv->get_list(array('sales_inv_no'=>$inv_no));
                $id=$inv_id[0]->sales_invoice_id;

                $m_inv_items->cost_upon_invoice=$cost;
                $m_inv_items->modify(array(
                    'product_id'=>$pid,
                    'batch_no'=>$bid,
                    'exp_date'=>$expdate,
                    'sales_invoice_id'=>$id
                ));

                $response['title']='Success!';
                $response['stat']='success';
                $response['id']=$id;
                $response['pid']=$pid;
                $response['exp']=$expdate;
                $response['bid']=$bid;
                $response['cost']=$cost;
                $response['msg']='Product cost on invoice # : '.$inv_no.' successfully updated.';
                echo json_encode($response);

                break;

            case 'export-product-history':
                $excel=$this->excel;
                $product_id=$this->input->get('id');
                $depid=$this->input->get('depid');
                $start=date('Y-m-d',strtotime($this->input->get('start')));
                $end=date('Y-m-d',strtotime($this->input->get('end')));


                if($this->input->get('start')== '0'){
                    $start = date('Y-m-01');
                    $end = date('Y-m-d');
                }

                $m_products=$this->Products_model;
                $m_department=$this->Departments_model;

                $product_info=$m_products->get_list($product_id);
                $dept_info=$m_department->get_list($depid);

                if($depid > 0){
                    $department_name = $dept_info[0]->department_name;
                }else{
                    $department_name = "All Branches";
                }


                $excel->setActiveSheetIndex(0);


                //name the worksheet
                $excel->getActiveSheet()->setTitle("History");

                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A1',$product_info[0]->product_desc."  History")
                    ->setCellValue('A2',"Period ".date('m/d/Y',strtotime($start))." to ".date('m/d/Y',strtotime($end)))
                    ->setCellValue('A3',"Branch : ".$department_name);

                //create headers
                $excel->getActiveSheet()->getStyle('A4:I4')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A4', 'Txn Date')
                                        ->setCellValue('B4', 'Reference')
                                        ->setCellValue('C4', 'Txn Type')
                                        ->setCellValue('D4', 'Description')
                                        ->setCellValue('E4', 'Exp Date')
                                        ->setCellValue('F4', 'Batch #')
                                        ->setCellValue('G4', 'In')
                                        ->setCellValue('H4', 'Out')
                                        ->setCellValue('I4', 'Balance');
                $balance_as_of = $m_products->get_product_balance_as_of_date($product_id,$start)[0]; 
                $excel->getActiveSheet()->setCellValue('A5', date("M d, Y",strtotime($start . "-1 days")) )
                                        ->setCellValue('B5', 'Balance')
                                        ->setCellValue('C5', 'System')
                                        ->setCellValue('D5', 'System Generated Balance')
                                        ->setCellValue('I5', $balance_as_of->balance);

                $transaction=$m_products->get_product_history($product_id,$start,$end,$balance_as_of->balance,$depid);

                $rows=array();
                foreach($transaction as $x){
                    $rows[]=array(
                        date("M d, Y",strtotime($x->txn_date)),
                        $x->ref_no,
                        $x->type,
                        $x->Description,
                        $x->exp_date,
                        $x->batch_no,
                        $x->in_qty,
                        $x->out_qty,
                        $x->balance
                    );
                }


                $excel->getActiveSheet()->getStyle('A4:I4')->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('07700e');

                $styleArray = array(
                    'font'  => array(
                        'bold'  => true,
                        'color' => array('rgb' => 'FFFFF'),
                        'size'  => 10,
                        'name'  => 'Tahoma'
                    ));

                $excel->getActiveSheet()->getStyle('A4:I4')->applyFromArray($styleArray);

                $excel->getActiveSheet()->fromArray($rows,NULL,'A6');
                //autofit column
                foreach(range('A','I') as $columnID)
                {
                    $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
                }





                $excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);



                // Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$product_info[0]->product_code."  History.xlsx".'"');
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
        return $this->Products_model->get_list(
            $filter,

            'products.*,categories.category_name,suppliers.supplier_name,refproduct.product_type,units.unit_name,item_types.item_type,account_titles.account_title',

            array(
                array('suppliers','suppliers.supplier_id=products.supplier_id','left'),
                array('refproduct','refproduct.refproduct_id=products.refproduct_id','left'),
                array('categories','categories.category_id=products.category_id','left'),
                array('units','units.unit_id=products.unit_id','left'),
                array('item_types','item_types.item_type_id=products.item_type_id','left'),
                array('account_titles','account_titles.account_id=products.income_account_id','left')
            )
        );
    }







}
