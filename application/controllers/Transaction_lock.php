<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction_lock extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Purchases_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Products_model');
        $this->load->model('Purchase_items_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Departments_model');
        $this->load->model('Transaction_module_model');
        $this->load->model('Delivery_invoice_model');
        $this->load->model('Sales_invoice_model');
        $this->load->model('Adjustment_model');
        $this->load->library('email');


    }

    public function index() {

        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['_rights'] = $this->load->view('template/elements/rights', '', TRUE);
        $data['modules']=$this->Transaction_module_model->get_list();

        $data['refproducts']=$this->Refproduct_model->get_list(
            'is_deleted=FALSE'
        );

        //data required by active view
        $data['departments']=$this->Departments_model->get_list(
            array('departments.is_active'=>TRUE,'departments.is_deleted'=>FALSE)
        );

        //data required by active view
        $data['suppliers']=$this->Suppliers_model->get_list(
            array('suppliers.is_active'=>TRUE,'suppliers.is_deleted'=>FALSE),
            'suppliers.*,IFNULL(tax_types.tax_rate,0)as tax_rate',
            array(
                array('tax_types','tax_types.tax_type_id=suppliers.tax_type_id','left')
            )
        );


        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');

        $data['products']=$this->Products_model->get_list(
                null, //no id filter
                array(
                           'products.product_id',
                           'products.product_code',
                           'products.product_desc',
                           'products.product_desc1',
                            'products.is_tax_exempt',
                           'FORMAT(products.sale_price,2)as sale_price',
                            'FORMAT(products.purchase_cost,2)as purchase_cost',
                           'products.unit_id',
                            'products.on_hand',
                           'units.unit_name'
                ),
                array(
                    // parameter (table to join(left) , the reference field)
                    array('units','units.unit_id=products.unit_id','left'),
                    array('categories','categories.category_id=products.category_id','left')

                )

            );

        $data['title'] = 'Transaction Lock';

        ($this->session->user_group_id != 1 ? redirect(base_url('dashboard')) : $this->load->view('transaction_lock_view', $data) );

    }

    function transaction($txn=null,$filter_value=null,$type=null){
        switch ($txn){
            case 'list':  //this returns JSON of Purchase Order to be rendered on Datatable

                $type_id = ($this->input->get('module_id') == "" ? 0 : $this->input->get('module_id'));
                $tsd = date('Y-m-d',strtotime($this->input->get('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->get('ted')));
                $is_locked = $this->input->get('is_locked');

                $m_transactions=$this->Transaction_module_model;
                $response['data']=$m_transactions->get_locked_transactions($type_id,$tsd,$ted,$is_locked);
                echo json_encode($response);
                break;  

            case 'lock':
                $m_purchase_invoice = $this->Delivery_invoice_model;
                $m_sales_invoice = $this->Sales_invoice_model;
                $m_adjustment_invoice = $this->Adjustment_model;

                $module_id = $this->input->post('module_id');
                $tsd = date('Y-m-d',strtotime($this->input->post('tsd')));
                $ted = date('Y-m-d',strtotime($this->input->post('ted')));

                // Purchase Invoice
                if($module_id == 1){
                    $m_purchase_invoice->is_locked=TRUE;
                    $m_purchase_invoice->modify(
                        "is_deleted = FALSE AND is_active = TRUE AND date_delivered BETWEEN '".$tsd."' AND '".$ted."'"
                    );
                    $response['stat12'] = 'Success';
                }
                // Sales Invoice && Other Sales Invoice
                else if($module_id == 2){
                    $m_sales_invoice->is_locked=TRUE;
                    $m_sales_invoice->modify(
                        "is_deleted = FALSE AND is_active = TRUE AND  inv_type = '1' AND date_invoice BETWEEN '".$tsd."' AND '".$ted."'"
                    );
                }
                else if($module_id == 3){
                    $m_sales_invoice->is_locked=TRUE;
                    $m_sales_invoice->modify(
                        "is_deleted = FALSE AND is_active = TRUE AND  inv_type = '2' AND date_invoice BETWEEN '".$tsd."' AND '".$ted."'"
                    );
                }                
                // Adjustment In
                else if($module_id == 4){
                    $m_adjustment_invoice->is_locked=TRUE;
                    $m_adjustment_invoice->modify(
                        "is_deleted = FALSE AND is_active = TRUE AND  adjustment_type = 'IN' AND date_adjusted BETWEEN '".$tsd."' AND '".$ted."'"
                    );
                }
                // Adjustment Out
                else if($module_id == 5){
                    $m_adjustment_invoice->is_locked=TRUE;
                    $m_adjustment_invoice->modify(
                        "is_deleted = FALSE AND is_active = TRUE AND adjustment_type = 'OUT' AND date_adjusted BETWEEN '".$tsd."' AND '".$ted."'"
                    );
                }

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Transactions successfully locked.';

                echo json_encode($response);
                break;


            case 'unlock':

                $module_id = $filter_value;
                $invoice_id = $this->input->post('invoice_id', TRUE);

                $m_purchase_invoice = $this->Delivery_invoice_model;
                $m_sales_invoice = $this->Sales_invoice_model;
                $m_adjustment_invoice = $this->Adjustment_model;

                for ($i=0; $i < count($invoice_id); $i++) { 
                    
                    // Purchase Invoice
                    if($module_id == 1){
                        $m_purchase_invoice->is_locked = FALSE;
                        $m_purchase_invoice->modify($invoice_id[$i]);
                    }
                    // Sales Invoice && Other Sales Invoice
                    else if($module_id == 2 OR $module_id == 3){
                        $m_sales_invoice->is_locked = FALSE;
                        $m_sales_invoice->modify($invoice_id[$i]);
                    }
                    // Adjustment In && Out
                    else if($module_id == 4 OR $module_id == 5){
                        $m_adjustment_invoice->is_locked = FALSE;
                        $m_adjustment_invoice->modify($invoice_id[$i]);
                    }

                }

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Transactions successfully unlocked.';

                echo json_encode($response);

                break;


            case 'verify':

                $module_id = $filter_value;
                $invoice_id = $this->input->post('invoice_id', TRUE);

                $module = $this->Transaction_module_model->get_list($module_id);
                $invoice = $this->Transaction_module_model->checkInvoice($module[0]->table_name,$module[0]->table_invoice_id,$invoice_id);

                $response['is_locked'] = $invoice[0]->is_locked;
                $response['title'] = 'Error!';
                $response['stat'] = 'error';
                $response['msg'] = 'This '.$module[0]->module.' is already locked. Please contact your supervisor for assistance.';
                
                echo json_encode($response);

                break;
        }
    }
}
