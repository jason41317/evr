<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sales_invoice extends CORE_Controller
{

  function __construct()
  {
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
    $this->load->model('Invoice_counter_model');
    $this->load->model('Company_model');
    $this->load->model('Salesperson_model');
    $this->load->model('Trans_model');
    $this->load->model('Adjustment_model');
  }

  public function index()
  {

    //default resources of the active view
    $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
    $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
    $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
    $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
    $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
    $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);

    //data required by active view
    $data['departments'] = $this->Departments_model->get_list(
      array('departments.is_active' => TRUE, 'departments.is_deleted' => FALSE),
      'department_id,department_name'
    );

    $data['salespersons'] = $this->Salesperson_model->get_list(
      array('salesperson.is_active' => TRUE, 'salesperson.is_deleted' => FALSE),
      'salesperson_id, acr_name, CONCAT(firstname, " ", middlename, " ", lastname) AS fullname, firstname, middlename, lastname'
    );

    //data required by active view
    $data['customers'] = $this->Customers_model->get_list(
      array('customers.is_active' => TRUE, 'customers.is_deleted' => FALSE),
      'customers.customer_id,
                customers.customer_name,
                customers.term,
                customers.address'
    );

    $data['refproducts'] = $this->Refproduct_model->get_list(
      'is_deleted=FALSE'
    );


    $tax_rate = $this->Company_model->get_list(
      null,
      array(
        'company_info.tax_type_id',
        'tt.tax_rate'
      ),
      array(
        array('tax_types as tt', 'tt.tax_type_id=company_info.tax_type_id', 'left')
      )
    );

    $data['tax_percentage'] = (count($tax_rate) > 0 ? $tax_rate[0]->tax_rate : 0);

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

    // 2020 NOT IN USE
    // $data['products']=$this->Products_model->get_current_item_list();

    $data['invoice_counter'] = $this->Invoice_counter_model->get_list(array('user_id' => $this->session->user_id));
    $data['title'] = 'Sales Invoice';

    (in_array('3-2', $this->session->user_rights) ?
      $this->load->view('sales_invoice_view', $data)
      : redirect(base_url('dashboard')));
  }


  function transaction($txn = null, $id_filter = null, $group = null)
  {
    switch ($txn) {
      case 'current-invoice-no':
        $m_invoice = $this->Sales_invoice_model;
        $user_id = $this->session->user_id;
        $invoice_no = $this->get_current_invoice_no($user_id);
        $response['invoice_no'] = $invoice_no;

        echo json_encode($response);
        break;

      case 'current-items':
        $type = $this->input->get('type');
        $department_id = $this->input->get('depid');
        $description = $this->input->get('description');
        echo json_encode($this->Products_model->get_current_item_list($description, $type, $department_id));
        break;


      case 'current-items-search':
        $type = $this->input->post('type');
        $department_id = $this->input->post('depid');
        $description = trim($this->input->post('description'));
        $response['data'] = $this->Products_model->get_current_item_list($description, $type, $department_id);

        echo json_encode($response);
        break;

      case 'print':
        $m_sales_invoice = $this->Sales_invoice_model;
        $m_sales_invoice_items = $this->Sales_invoice_item_model;

        $info = $m_sales_invoice->get_list(
          $id_filter,
          'sales_invoice.*,departments.department_name,customers.tin_no,customers.customer_name, sales_invoice.address,sales_order.so_no,salesperson.*',
          array(
            array('departments', 'departments.department_id=sales_invoice.issue_to_department', 'left'),
            array('customers', 'customers.customer_id=sales_invoice.customer_id', 'left'),
            array('sales_order', 'sales_order.sales_order_id=sales_invoice.sales_order_id', 'left'),
            array('salesperson', 'salesperson.salesperson_id=sales_invoice.salesperson_id', 'left')
          )
        );

        $company_info = $this->Company_model->get_list();

        $data['company_info'] = $company_info[0];

        $data['sales_info'] = $info[0];
        $invoiceItems = $m_sales_invoice_items->get_list(
          array('sales_invoice_items.sales_invoice_id' => $id_filter),
          'sales_invoice_items.*,products.product_desc,products.size,units.unit_name',
          array(
            array('products', 'products.product_id=sales_invoice_items.product_id', 'left'),
            array('units', 'units.unit_id=sales_invoice_items.unit_id', 'left')
          )
        );
        $data['sales_invoice_items'] = $invoiceItems;

        $discount = 0;
        foreach($invoiceItems as $item) {
            $discount = $discount  + $item->inv_line_total_discount;
        }

       $data['discount'] = $discount + $info[0]->total_overall_discount_amount;

        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);

        if ($group != null) {
          if ($group == 1) {
            $this->load->view('template/sales_invoice_content_html', $data);
          } else if ($group == 2) {
            $this->load->view('template/sales_invoice_content_html_vismin', $data);
          }
        }

        break;

      case 'list':  //this returns JSON of Issuance to be rendered on Datatable
        $m_invoice = $this->Sales_invoice_model;
        $tsd = date('Y-m-d', strtotime($this->input->get('tsd')));
        $ted = date('Y-m-d', strtotime($this->input->get('ted')));
        $response['data'] = $this->response_rows(
          "sales_invoice.is_active=TRUE  AND sales_invoice.sales_invoice_id AND DATE(sales_invoice.date_invoice) BETWEEN '$tsd' AND '$ted' AND sales_invoice.is_deleted=FALSE AND sales_invoice.inv_type=1" . ($id_filter == null ? "" : "AND sales_invoice.sales_invoice_id=" . $id_filter)
        );
        echo json_encode($response);
        break;

        // case 'list-for-returns':  //this returns JSON of Issuance to be rendered on Datatable
        //     $m_invoice=$this->Sales_invoice_model;
        //     $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
        //     $ted = date('Y-m-d',strtotime($this->input->get('ted')));
        //     $response['data']=$this->response_rows(
        //         "sales_invoice.is_active=TRUE  AND sales_invoice.sales_invoice_id AND DATE(sales_invoice.date_invoice) BETWEEN '$tsd' AND '$ted' AND sales_invoice.is_deleted=FALSE ".($id_filter==null?"":"AND sales_invoice.sales_invoice_id=".$id_filter)
        //     );
        //     echo json_encode($response);
        //     break;


      case 'list-for-returns':
        $m_adjustment = $this->Adjustment_model;
        $customer_id = $this->input->get('customer_id');
        $tsd = date('Y-m-d', strtotime($this->input->get('tsd')));
        $ted = date('Y-m-d', strtotime($this->input->get('ted')));
        $response['data'] = $m_adjustment->list_per_customer($customer_id, $tsd, $ted);
        echo json_encode($response);
        break;

        ////****************************************items/products of selected Items***********************************************
      case 'items': //items on the specific PO, loads when edit button is called
        //check if this invoice is already posted
        $m_invoice = $this->Sales_invoice_model;
        $post_info = $m_invoice->get_list(
          array(
            'sales_invoice_id' => $id_filter,
            'is_journal_posted' => 1
          )
        );

        $m_items = $this->Sales_invoice_item_model;
        $response['data'] = $m_items->get_list(
          array('sales_invoice_id' => $id_filter),
          array(
            'sales_invoice_items.*',
            'products.product_code',
            'products.product_desc',
            'units.unit_id',
            'units.unit_name'
          ),
          array(
            array('products', 'products.product_id=sales_invoice_items.product_id', 'left'),
            array('units', 'units.unit_id=sales_invoice_items.unit_id', 'left')
          ),
          'sales_invoice_items.sales_item_id DESC'
        );

        if (count($post_info) > 0) {
          $response['post_status'] = 'posted';
          $response['post_message'] = 'Sorry, you cannot edit this transaction because it was already posted in Sales Journal.';
        }



        echo json_encode($response);
        break;


      case 'items-for-sales-return': //items on the specific INVOICE, loads when Accept Invoice called on Adjustments Module
        //check if this invoice is already posted
        $m_invoice = $this->Sales_invoice_model;
        $m_items = $this->Sales_invoice_item_model;
        $response['data'] = $m_items->get_list(
          array('sales_invoice_id' => $id_filter),
          array(
            'sales_invoice_items.*',
            'products.product_code',
            'products.product_desc',
            'units.unit_id',
            'units.unit_name',
            'DATE_FORMAT(sales_invoice_items.exp_date,"%m/%d/%Y")as expiration'
          ),
          array(
            array('products', 'products.product_id=sales_invoice_items.product_id', 'left'),
            array('units', 'units.unit_id=sales_invoice_items.unit_id', 'left')
          ),
          'sales_invoice_items.sales_item_id DESC'
        );

        echo json_encode($response);
        break;

        //***************************************create new Items************************************************


      case 'create':
        $m_invoice = $this->Sales_invoice_model;
        $m_counter = $this->Invoice_counter_model;


        $user_id = $this->session->user_id;

        //add 1 to the last invoice number
        //$invoice_no=$this->get_current_sales_inv_no() + 1;

        $invoice_no = $this->get_current_invoice_no($user_id);

        //validate if all required fields are supplied, and duplication
        if ($this->validate_record($invoice_no)) {
          //get sales order id base on SO number
          $m_so = $this->Sales_order_model;
          $m_picklist = $this->Picklist_model;
          // $arr_so_info = $m_so->get_list(
          //   array('sales_order.so_no' => $this->input->post('so_no', TRUE)),
          //   'sales_order.sales_order_id'
          // );
          // $sales_order_id = (count($arr_so_info) > 0 ? $arr_so_info[0]->sales_order_id : 0);

          $arr_so_info = $m_picklist->get_list(
            array('picklist.picklist_no' => $this->input->post('picklist_no', TRUE)),
            'picklist.sales_order_id, picklist.picklist_id'
          );

          $sales_order_id = (count($arr_so_info) > 0 ? $arr_so_info[0]->sales_order_id : 0);
          $picklist_id = (count($arr_so_info) > 0 ? $arr_so_info[0]->picklist_id : 0);


          $m_invoice->begin();

          //treat NOW() as function and not string
          $m_invoice->set('date_created', 'NOW()'); //treat NOW() as function and not string
          $m_invoice->sales_inv_no = $invoice_no;
          $m_invoice->department_id = $this->input->post('department', TRUE);
          $m_invoice->customer_id = $this->input->post('customer', TRUE);
          $m_invoice->salesperson_id = $this->input->post('salesperson_id', TRUE);
          $m_invoice->sales_order_id = $sales_order_id;
          $m_invoice->picklist_id = $picklist_id;
          $m_invoice->remarks = $this->input->post('remarks', TRUE);
          $m_invoice->terms = $this->input->post('terms', TRUE);
          $m_invoice->date_due = date('Y-m-d', strtotime($this->input->post('date_due', TRUE)));
          $m_invoice->cod_pdc = $this->input->post('cod_pdc', TRUE);
          $m_invoice->date_invoice = date('Y-m-d', strtotime($this->input->post('date_invoice', TRUE)));

          $date_delivered = $this->input->post('date_delivered', TRUE);

          if ($date_delivered != null || "") {
            $m_invoice->date_delivered = date('Y-m-d', strtotime($date_delivered));
          } else {
            $m_invoice->date_delivered = null;
          }

          $m_invoice->total_overall_discount = $this->get_numeric_value($this->input->post('total_overall_discount', TRUE));
          $m_invoice->total_overall_discount_amount = $this->get_numeric_value($this->input->post('total_overall_discount_amount', TRUE));
          $m_invoice->total_discount = $this->get_numeric_value($this->input->post('summary_discount', TRUE));
          $m_invoice->total_before_tax = $this->get_numeric_value($this->input->post('summary_before_discount', TRUE));
          $m_invoice->total_tax_amount = $this->get_numeric_value($this->input->post('summary_tax_amount', TRUE));
          $m_invoice->total_after_tax = $this->get_numeric_value($this->input->post('summary_after_tax', TRUE));
          $m_invoice->inv_type = 1;
          $m_invoice->address = $this->input->post('address', TRUE);
          $m_invoice->posted_by_user = $this->session->user_id;
          $m_invoice->save();

          $sales_invoice_id = $m_invoice->last_insert_id();

          $m_invoice_items = $this->Sales_invoice_item_model;

          $prod_id = $this->input->post('product_id', TRUE);
          $inv_qty = $this->input->post('inv_qty', TRUE);
          $inv_price = $this->input->post('inv_price', TRUE);
          $inv_discount = $this->input->post('inv_discount', TRUE);
          $inv_line_total_discount = $this->input->post('inv_line_total_discount', TRUE);
          $inv_tax_rate = $this->input->post('inv_tax_rate', TRUE);
          $inv_line_total_price = $this->input->post('inv_line_total_price', TRUE);
          $inv_tax_amount = $this->input->post('inv_tax_amount', TRUE);
          $inv_non_tax_amount = $this->input->post('inv_non_tax_amount', TRUE);
          $batch_no = $this->input->post('batch_no', TRUE);
          $exp_date = $this->input->post('exp_date', TRUE);
          $orig_so_price = $this->input->post('orig_so_price', TRUE);
          $cost_upon_invoice = $this->input->post('cost_upon_invoice', TRUE);

          $m_products = $this->Products_model;

          for ($i = 0; $i < count($prod_id); $i++) {

            $m_invoice_items->sales_invoice_id = $sales_invoice_id;
            $m_invoice_items->product_id = $this->get_numeric_value($prod_id[$i]);
            $m_invoice_items->inv_qty = $this->get_numeric_value($inv_qty[$i]);
            $m_invoice_items->inv_price = $this->get_numeric_value($inv_price[$i]);
            $m_invoice_items->inv_discount = $this->get_numeric_value($inv_discount[$i]);
            $m_invoice_items->inv_line_total_discount = $this->get_numeric_value($inv_line_total_discount[$i]);
            $m_invoice_items->inv_tax_rate = $this->get_numeric_value($inv_tax_rate[$i]);
            $m_invoice_items->inv_line_total_price = $this->get_numeric_value($inv_line_total_price[$i]);
            $m_invoice_items->inv_tax_amount = $this->get_numeric_value($inv_tax_amount[$i]);
            $m_invoice_items->inv_non_tax_amount = $this->get_numeric_value($inv_non_tax_amount[$i]);
            $m_invoice_items->batch_no = $batch_no[$i];
            $m_invoice_items->exp_date = date('Y-m-d', strtotime($exp_date[$i]));
            $m_invoice_items->orig_so_price = $this->get_numeric_value($orig_so_price[$i]);
            $m_invoice_items->cost_upon_invoice = $this->get_numeric_value($cost_upon_invoice[$i]);

            //unit id retrieval is change, because of TRIGGER restriction
            $unit_id = $m_products->get_list(array('product_id' => $this->get_numeric_value($prod_id[$i])));
            $m_invoice_items->unit_id = $unit_id[0]->unit_id;

            //$m_invoice_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');
            $department_id = $this->input->post('department', TRUE);
            $on_hand = $m_products->get_product_current_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])), $department_id);

            if ($this->get_numeric_value($inv_qty[$i]) > $this->get_numeric_value($on_hand)) {
              $prod_description = $unit_id[0]->product_desc;

              $response['title'] = 'Insufficient!';
              $response['stat'] = 'error';
              $response['msg'] = 'The item <b><u>' . $prod_description . '</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>' . number_format($on_hand, 2) . '</u></b>. <br /><br /> Item : <b>' . $prod_description . '</b><br /> Batch # : <b>' . $batch_no[$i] . '</b><br />Expiration : <b>' . $exp_date[$i] . '</b><br />On Hand : <b>' . number_format($on_hand, 2) . '</b><br />';
              $response['current_row_index'] = $i;
              die(json_encode($response));
            }

            $m_invoice_items->save();
          }

          //update invoice number base on formatted last insert id
          /**$m_invoice->sales_inv_no='INV-'.date('Ymd').'-'.$sales_invoice_id;
                            $m_invoice->modify($sales_invoice_id);**/


          //update last invoice use
          $m_counter->last_invoice = $invoice_no;
          $m_counter->modify(array('user_id' => $user_id));


          // //update status of so
          // $m_so->order_status_id = $this->get_so_status($sales_order_id);
          // $m_so->modify($sales_order_id);


           //update status of picklist
           $m_picklist->picklist_status_id = 2;
           $m_picklist->modify($picklist_id);

          //******************************************************************************************
          // IMPORTANT!!!
          //update receivable amount field of customer table
          $m_customers = $this->Customers_model;
          $m_customers->recalculate_customer_receivable($this->input->post('customer', TRUE));
          //******************************************************************************************

          $m_trans = $this->Trans_model;
          $m_trans->user_id = $this->session->user_id;
          $m_trans->set('trans_date', 'NOW()');
          $m_trans->trans_key_id = 1; //CRUD
          $m_trans->trans_type_id = 17; // TRANS TYPE
          $m_trans->trans_log = 'Created Sales Invoice No: SAL-INV-' . date('Ymd') . '-' . $sales_invoice_id;
          $m_trans->save();

          $m_invoice->commit();

          if ($m_invoice->status() === TRUE) {
            $response['title'] = 'Success!';
            $response['stat'] = 'success';
            $response['msg'] = 'Sales invoice successfully created.';
            $response['row_added'] = $this->response_rows($sales_invoice_id);

            echo json_encode($response);
          }
        } //end of validation

        break;


        ////***************************************update Items************************************************
      case 'update':
        $m_invoice = $this->Sales_invoice_model;
        $sales_invoice_id = $this->input->post('sales_invoice_id', TRUE);
        $sales_inv_no = $this->input->post('sales_inv_no', TRUE);

        //if  valid invoice no.
        //if($this->validate_record($sales_inv_no)){

        //get sales order id base on SO number
        $m_so = $this->Sales_order_model;
        $m_picklist = $this->Picklist_model;
        // $arr_so_info = $m_so->get_list(
        //   array('sales_order.so_no' => $this->input->post('so_no', TRUE)),
        //   'sales_order.sales_order_id'
        // );
        $arr_so_info = $m_picklist->get_list(
          array('picklist.picklist_no' => $this->input->post('picklist_no', TRUE)),
          'picklist.sales_order_id, picklist.picklist_id'
        );

        $sales_order_id = (count($arr_so_info) > 0 ? $arr_so_info[0]->sales_order_id : 0);
        $picklist_id = (count($arr_so_info) > 0 ? $arr_so_info[0]->picklist_id : 0);

        $m_invoice->begin();
        $m_invoice->set('date_modified', 'NOW()');
        $m_invoice->sales_inv_no = $sales_inv_no;
        $m_invoice->department_id = $this->input->post('department', TRUE);
        $m_invoice->remarks = $this->input->post('remarks', TRUE);
        $m_invoice->terms = $this->input->post('terms', TRUE);
        $m_invoice->cod_pdc = $this->input->post('cod_pdc', TRUE);
        $m_invoice->customer_id = $this->input->post('customer', TRUE);
        $m_invoice->salesperson_id = $this->input->post('salesperson_id', TRUE);
        $m_invoice->sales_order_id = $sales_order_id;
        $m_invoice->picklist_id = $picklist_id;
        $m_invoice->date_due = date('Y-m-d', strtotime($this->input->post('date_due', TRUE)));
        $m_invoice->date_invoice = date('Y-m-d', strtotime($this->input->post('date_invoice', TRUE)));

        $date_delivered = $this->input->post('date_delivered', TRUE);

        if ($date_delivered != null || "") {
          $m_invoice->date_delivered = date('Y-m-d', strtotime($date_delivered));
        } else {
          $m_invoice->date_delivered = null;
        }

        $m_invoice->total_overall_discount = $this->get_numeric_value($this->input->post('total_overall_discount', TRUE));
        $m_invoice->total_overall_discount_amount = $this->get_numeric_value($this->input->post('total_overall_discount_amount', TRUE));
        $m_invoice->total_discount = $this->get_numeric_value($this->input->post('summary_discount', TRUE));
        $m_invoice->total_before_tax = $this->get_numeric_value($this->input->post('summary_before_discount', TRUE));
        $m_invoice->total_tax_amount = $this->get_numeric_value($this->input->post('summary_tax_amount', TRUE));
        $m_invoice->total_after_tax = $this->get_numeric_value($this->input->post('summary_after_tax', TRUE));
        $m_invoice->address = $this->input->post('address', TRUE);
        $m_invoice->modified_by_user = $this->session->user_id;
        $m_invoice->modify($sales_invoice_id);


        $m_invoice_items = $this->Sales_invoice_item_model;

        $m_invoice_items->delete_via_fk($sales_invoice_id); //delete previous items then insert those new

        $prod_id = $this->input->post('product_id', TRUE);
        $inv_price = $this->input->post('inv_price', TRUE);
        $inv_discount = $this->input->post('inv_discount', TRUE);
        $inv_line_total_discount = $this->input->post('inv_line_total_discount', TRUE);
        $inv_tax_rate = $this->input->post('inv_tax_rate', TRUE);
        $inv_qty = $this->input->post('inv_qty', TRUE);
        $inv_line_total_price = $this->input->post('inv_line_total_price', TRUE);
        $inv_tax_amount = $this->input->post('inv_tax_amount', TRUE);
        $inv_non_tax_amount = $this->input->post('inv_non_tax_amount', TRUE);
        $batch_no = $this->input->post('batch_no', TRUE);
        $exp_date = $this->input->post('exp_date', TRUE);
        $orig_so_price = $this->input->post('orig_so_price', TRUE);
        $cost_upon_invoice = $this->input->post('cost_upon_invoice', TRUE);

        $m_products = $this->Products_model;

        for ($i = 0; $i < count($prod_id); $i++) {

          $m_invoice_items->sales_invoice_id = $sales_invoice_id;
          $m_invoice_items->product_id = $this->get_numeric_value($prod_id[$i]);
          $m_invoice_items->inv_price = $this->get_numeric_value($inv_price[$i]);
          $m_invoice_items->inv_discount = $this->get_numeric_value($inv_discount[$i]);
          $m_invoice_items->inv_line_total_discount = $this->get_numeric_value($inv_line_total_discount[$i]);
          $m_invoice_items->inv_tax_rate = $this->get_numeric_value($inv_tax_rate[$i]);
          $m_invoice_items->inv_qty = $this->get_numeric_value($inv_qty[$i]);
          $m_invoice_items->inv_line_total_price = $this->get_numeric_value($inv_line_total_price[$i]);
          $m_invoice_items->inv_tax_amount = $this->get_numeric_value($inv_tax_amount[$i]);
          $m_invoice_items->inv_non_tax_amount = $this->get_numeric_value($inv_non_tax_amount[$i]);
          $m_invoice_items->batch_no = $batch_no[$i];
          $m_invoice_items->exp_date = date('Y-m-d', strtotime($exp_date[$i]));
          $m_invoice_items->orig_so_price = $this->get_numeric_value($orig_so_price[$i]);
          $m_invoice_items->cost_upon_invoice = $this->get_numeric_value($cost_upon_invoice[$i]);

          //unit id retrieval is change, because of TRIGGER restriction
          $unit_id = $m_products->get_list(array('product_id' => $this->get_numeric_value($prod_id[$i])));
          $m_invoice_items->unit_id = $unit_id[0]->unit_id;

          //$m_invoice_items->set('unit_id','(SELECT unit_id FROM products WHERE product_id='.(int)$prod_id[$i].')');

          $department_id = $this->input->post('department', TRUE);
          $on_hand = $m_products->get_product_current_qty($batch_no[$i], $this->get_numeric_value($prod_id[$i]), date('Y-m-d', strtotime($exp_date[$i])), $department_id);

          if ($this->get_numeric_value($inv_qty[$i]) > $this->get_numeric_value($on_hand)) {
            $prod_description = $unit_id[0]->product_desc;

            $response['title'] = 'Insufficient!';
            $response['stat'] = 'error';
            $response['msg'] = 'The item <b><u>' . $prod_description . '</u></b> is insufficient. Please make sure Quantiy is not greater than <b><u>' . number_format($on_hand, 2) . '</u></b>. <br /><br /> Item : <b>' . $prod_description . '</b><br /> Batch # : <b>' . $batch_no[$i] . '</b><br />Expiration : <b>' . $exp_date[$i] . '</b><br />On Hand : <b>' . number_format($on_hand, 2) . '</b><br />';
            $response['current_row_index'] = $i;
            die(json_encode($response));
          }

          $m_invoice_items->save();
        }



        // //update status of so
        // $m_so->order_status_id = $this->get_so_status($sales_order_id);
        // $m_so->modify($sales_order_id);


        //update status of picklist
        $m_picklist->picklist_status_id = 2;
        $m_picklist->modify($picklist_id);


        //******************************************************************************************
        // IMPORTANT!!!
        //update receivable amount field of customer table
        $m_customers = $this->Customers_model;
        $m_customers->recalculate_customer_receivable($this->input->post('customer', TRUE));
        //******************************************************************************************
        $sal_info = $m_invoice->get_list($sales_invoice_id, 'sales_inv_no');
        $m_trans = $this->Trans_model;
        $m_trans->user_id = $this->session->user_id;
        $m_trans->set('trans_date', 'NOW()');
        $m_trans->trans_key_id = 2; //CRUD
        $m_trans->trans_type_id = 17; // TRANS TYPE
        $m_trans->trans_log = 'Updated Sales Invoice No: ' . $sal_info[0]->sales_inv_no;
        $m_trans->save();

        $m_invoice->commit();



        if ($m_invoice->status() === TRUE) {
          $response['title'] = 'Success!';
          $response['stat'] = 'success';
          $response['msg'] = 'Sales invoice successfully updated.';
          $response['row_updated'] = $this->response_rows($sales_invoice_id);

          echo json_encode($response);
        }




        // }


        break;


        //***************************************************************************************
      case 'delete':
        $m_invoice = $this->Sales_invoice_model;
        $sales_invoice_id = $this->input->post('sales_invoice_id', TRUE);

        //mark Items as deleted
        $m_invoice->set('date_deleted', 'NOW()'); //treat NOW() as function and not string
        $m_invoice->deleted_by_user = $this->session->user_id; //user that deleted the record
        $m_invoice->is_deleted = 1; //mark as deleted
        $m_invoice->modify($sales_invoice_id);

        $sal_info = $m_invoice->get_list($sales_invoice_id, 'sales_inv_no');
        $m_trans = $this->Trans_model;
        $m_trans->user_id = $this->session->user_id;
        $m_trans->set('trans_date', 'NOW()');
        $m_trans->trans_key_id = 3; //CRUD
        $m_trans->trans_type_id = 17; // TRANS TYPE
        $m_trans->trans_log = 'Deleted Sales Invoice No: ' . $sal_info[0]->sales_inv_no;
        $m_trans->save();

        $response['title'] = 'Success!';
        $response['stat'] = 'success';
        $response['msg'] = 'Record successfully deleted.';
        echo json_encode($response);

        break;

        //***************************************************************************************
      case 'sales-for-review':
        $m_sales_invoice = $this->Sales_invoice_model;
        $response['data'] = $m_sales_invoice->get_list(

          array(
            'sales_invoice.is_active' => TRUE,
            'sales_invoice.is_deleted' => FALSE,
            'sales_invoice.is_journal_posted' => FALSE
          ),

          array(
            'sales_invoice.sales_invoice_id',
            'sales_invoice.sales_inv_no',
            'sales_invoice.remarks',
            'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
            'customers.customer_name',
            'customers.tin_no'
          ),

          array(
            array('customers', 'customers.customer_id=sales_invoice.customer_id', 'left')
          )
        );


        echo json_encode($response);
        break;

      case 'per-customer-sales':
        $m_sales_invoice = $this->Sales_invoice_model;
        $response['data'] = $m_sales_invoice->get_customers_sales_summary();
        echo (json_encode($response)
        );
        break;
    }
  }



  //**************************************user defined*************************************************
  function response_rows($filter_value)
  {
    return $this->Sales_invoice_model->get_list(
      $filter_value,
      array(
        'sales_invoice.total_overall_discount',
        'sales_invoice.cod_pdc',
        'sales_invoice.sales_invoice_id',
        'sales_invoice.sales_inv_no',
        'sales_invoice.remarks',
        'sales_invoice.date_created',
        'sales_invoice.terms',
        'sales_invoice.customer_id',
        'sales_invoice.inv_type',
        'DATE_FORMAT(sales_invoice.date_invoice,"%m/%d/%Y") as date_invoice',
        'DATE_FORMAT(sales_invoice.date_due,"%m/%d/%Y") as date_due',
        'departments.department_id',
        'departments.department_name',
        'customers.customer_name',
        'sales_invoice.salesperson_id',
        'sales_invoice.address',
        'sales_order.so_no',
        'picklist.picklist_no',
        'sales_order.order_status_id',
        '(CASE 
                    WHEN isnull(sales_invoice.date_delivered) 
                    THEN ""
                    ELSE DATE_FORMAT(sales_invoice.date_delivered,"%m/%d/%Y")
                END) as date_delivered'

      ),
      array(
        array('departments', 'departments.department_id=sales_invoice.department_id', 'left'),
        array('customers', 'customers.customer_id=sales_invoice.customer_id', 'left'),
        array('sales_order', 'sales_order.sales_order_id=sales_invoice.sales_order_id', 'left'),
        array('picklist', 'picklist.picklist_id=sales_invoice.picklist_id', 'left')
      )
    );
  }

  function get_so_status($id)
  {
    //NOTE : 1 means open, 2 means Closed, 3 means partially invoice
    $m_sales_invoice = $this->Sales_invoice_model;

    if (count($m_sales_invoice->get_list(
      array('sales_invoice.sales_order_id' => $id, 'sales_invoice.is_active' => TRUE, 'sales_invoice.is_deleted' => FALSE),
      'sales_invoice.sales_invoice_id'
    )) == 0) { //means no SO found on sales invoice that means this so is still open

      return 1;
    } else {
      $m_so = $this->Sales_order_model;
      $row = $m_so->get_so_balance_qty($id);
      return ($row[0]->Balance > 0 ? 3 : 2);
    }
  }


  function validate_record($invoice_no)
  {
    $m_invoice = $this->Sales_invoice_model;

    if (count($m_invoice->get_list(array('sales_inv_no' => $invoice_no))) > 0) {
      $response['title'] = 'Invalid!';
      $response['stat'] = 'error';
      $response['msg'] = 'Invoice No. already exists. Please contact System Administrator for assistance.';
      die(json_encode($response));
    }

    return true;
  }

  function get_current_sales_inv_no()
  {
    $current_inv_no = $this->db->select('sales_inv_no')->where('inv_type=1')->order_by('sales_inv_no', 'desc')->limit(1)->get('sales_invoice')->row('sales_inv_no');

    return $current_inv_no;
  }

  //return current invoice number based on the range provided
  function get_current_invoice_no($user_id)
  {
    try {
      $m_counter = $this->Invoice_counter_model;
      $counter = $m_counter->get_list(array('invoice_counter.user_id' => $user_id));


      $last_used = $counter[0]->last_invoice;
      $start_no = $counter[0]->counter_start;
      $end_no = $counter[0]->counter_end;

      if ($start_no == 0 && $end_no == 0) {
        $response['title'] = 'Invalid Invoice Range!';
        $response['stat'] = 'error';
        $response['msg'] = 'Please call system administrator to set new Invoice No. range to your account.';
        die(json_encode($response));
      }

      $next_no = ((float)$last_used) + 1;

      //check if $next_no is between start and end
      if ($next_no >= $start_no && $next_no <= $end_no) {
        return $next_no;
      } else {
        //the choices are start no TO end no
        //but we need to validate first the start no
        $m_invoice = $this->Sales_invoice_model;
        $invoices = $m_invoice->get_list(
          'sales_invoice.sales_inv_no BETWEEN ' . $start_no . ' AND ' . $end_no,
          array(
            'sales_invoice.sales_inv_no'
          ),
          null,
          'CAST(sales_invoice.sales_inv_no AS UNSIGNED) DESC',
          null,
          TRUE,
          1
        );

        if (count($invoices) > 0) {
          $next_no_from_invoice = ((float)$invoices[0]->sales_inv_no) + 1; //this is the incremented value from invoice

          if ($next_no_from_invoice >= $start_no && $next_no_from_invoice <= $end_no) { //if still between the valid range, return the incremented value
            return $next_no_from_invoice;
          } else {

            //if "next no. from invoice" is not yet valid
            //check if "counter start" is valid

            $invoices = $m_invoice->get_list(array('sales_inv_no' => $start_no));
            if (count($invoices) == 0) { //if not found, start no. is valid
              return $start_no;
            } else {
              $response['title'] = 'Invoice No. Consumed!';
              $response['stat'] = 'error';
              $response['msg'] = 'Please call system administrator to set new Invoice No. range to your account.';
              die(json_encode($response));
            }
          }
        } else { //no record found, we could safely use start no
          return $start_no;
        }
      }
    } catch (Exception $e) {
      $response['title'] = 'Error Occurred!';
      $response['stat'] = 'error';
      $response['msg'] = 'Please call system administrator to set new Invoice No. range to your account.';
      die(json_encode($response));
    }
  }


  //***************************************************************************************





}
