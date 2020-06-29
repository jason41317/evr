<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_invoice_history extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Delivery_invoice_model');
        $this->load->model('Suppliers_model');
        $this->load->model('Tax_types_model');
        $this->load->model('Products_model');
        $this->load->model('Delivery_invoice_item_model');
        $this->load->model('Purchases_model');
        $this->load->model('Departments_model');
        $this->load->model('Refproduct_model');
        $this->load->model('Sales_invoice_item_model');


    }

    public function index() {

        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['title'] = 'Purchase Invoice History';

        (in_array('2-7',$this->session->user_rights)? 
        $this->load->view('purchase_invoice_history_view', $data)
        :redirect(base_url('dashboard')));

    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case 'list':  
                $response['data']=$this->response_rows(
                    "delivery_invoice.is_active=TRUE AND delivery_invoice.is_deleted=FALSE".($id_filter==null?"":" AND delivery_invoice.dr_invoice_id=".$id_filter)
                    ,
                    'delivery_invoice.dr_invoice_id'
                );
                echo json_encode($response);
                break;
        }

    }



//**************************************user defined*************************************************
    function response_rows($filter_value,$order_by=null){
        return $this->Delivery_invoice_model->get_list(
            $filter_value,
            array(
                'delivery_invoice.*',
                'DATE_FORMAT(delivery_invoice.date_due,"%m/%d/%Y")as date_due',
                'DATE_FORMAT(delivery_invoice.date_delivered,"%m/%d/%Y")as date_delivered',
                'CONCAT_WS(" ",CAST(delivery_invoice.terms AS CHAR),delivery_invoice.duration)as term_description',
                'suppliers.supplier_name',
                'tax_types.tax_type',
                'purchase_order.po_no'
            ),
            array(
                array('suppliers','suppliers.supplier_id=delivery_invoice.supplier_id','left'),
                array('tax_types','tax_types.tax_type_id=delivery_invoice.tax_type_id','left'),
                array('purchase_order','purchase_order.purchase_order_id=delivery_invoice.purchase_order_id','left')
            ),
            $order_by
        );
    }


}
