<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_detailed_summary extends CORE_Controller {

    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model(array(
            'Sales_invoice_model',
            'Company_model',
            'Customers_model',
            'Salesperson_model'
        ));

    }

    public function index() {
        $data['_def_css_files']=$this->load->view('template/assets/css_files','',TRUE);
        $data['_def_js_files']=$this->load->view('template/assets/js_files','',TRUE);
        $data['_switcher_settings']=$this->load->view('template/elements/switcher','',TRUE);
        $data['_side_bar_navigation']=$this->load->view('template/elements/side_bar_navigation','',TRUE);
        $data['_top_navigation']=$this->load->view('template/elements/top_navigation','',TRUE);

        $data['customers']=$this->Customers_model->get_customer_list_for_sales_report();
        $data['salespersons']=$this->Salesperson_model->get_list(
            'is_deleted=FALSE AND is_active=TRUE',
            'salesperson_id, CONCAT(firstname, " " , lastname, " - ", acr_name) AS salesperson_name, firstname, lastname, acr_name'
        );

        $data['title']='Sales Report';

        (in_array('8-1',$this->session->user_rights)? 
        $this->load->view('sales_detailed_summary_view', $data)
        :redirect(base_url('dashboard')));        
    }


    function transaction($txn=null){
        switch($txn){
            case 'per-customer-sales':
                $m_sales_invoice=$this->Sales_invoice_model;
                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                $customer_id=$this->input->get('cus_id',TRUE);

                $response['data']=$m_sales_invoice->get_customers_sales_summary($start,$end,$customer_id);
                echo(
                json_encode($response)
                );
            break;

            case 'per-salesperson-sales':
                $m_sales_invoice=$this->Sales_invoice_model;
                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                $salesperson_id=$this->input->get('sp_id',TRUE);

                $response['data']=$m_sales_invoice->get_salesperson_sales_summary($start,$end,$salesperson_id);
                
                echo(
                json_encode($response)
                );
            break;

            case 'summary-report':
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $startDate=date('Y-m-d',strtotime($this->input->get('startDate')));
                $endDate=date('Y-m-d',strtotime($this->input->get('endDate')));
                $customer_id=$this->input->get('cus_id',TRUE);

                // $data['customers']=$m_sales_invoice->get_customers_sales_summary($startDate,$endDate,$customer_id);

                $data['sales_summary']=$m_sales_invoice->get_report_summary($startDate,$endDate);

                $this->load->view('template/sales_summary_report',$data);
            break;

            case 'summary-report-vet-rep':
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                $salesperson_id=$this->input->get('sp_id',TRUE);

                $data['salespersons']=$m_sales_invoice->get_salesperson_sales_summary($start,$end,$salesperson_id);

                $data['sales_summary']=$m_sales_invoice->get_salesperson_report_summary($start,$end,$salesperson_id);

                $this->load->view('template/vet_rep_sales_report',$data);
                break;  

            case 'summary-report-vet-rep-summary':
                $m_company_info=$this->Company_model;
                $m_sales_invoice=$this->Sales_invoice_model;

                $company_info=$m_company_info->get_list();
                $data['company_info']=$company_info[0];

                $start=date("Y-m-d",strtotime($this->input->get('startDate',TRUE)));
                $end=date("Y-m-d",strtotime($this->input->get('endDate',TRUE)));
                $salesperson_id=$this->input->get('sp_id',TRUE);

                $data['sales_summary']=$m_sales_invoice->get_salesperson_sales_summary($start,$end,$salesperson_id);

                $this->load->view('template/vet_rep_sales_report_summary',$data);
                break;  
        }
    }



}
