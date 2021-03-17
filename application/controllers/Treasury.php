<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Treasury extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Suppliers_model',
                'Departments_model',
                'Account_title_model',
                'Payment_method_model',
                'Journal_info_model',
                'Journal_account_model',
                'Tax_types_model',
                'Delivery_invoice_model',
                'Payment_method_model',
                'Check_layout_model',
                'Payable_payment_model',
                'Accounting_period_model',
                'Journal_template_info_model',
                'Journal_template_entry_model',
                'Company_model',
                'Users_model',
                'Banks_model',
                'Trans_model'
            )
        );

    }

    public function index() {
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['banks']=$this->Banks_model->get_list('is_deleted=FALSE');
        $data['suppliers']=$this->Suppliers_model->get_list('is_deleted = FALSE');
        $data['departments']=$this->Departments_model->get_list('is_deleted = FALSE');
        $data['accounts']=$this->Account_title_model->get_list('is_deleted = FALSE');
        $data['methods']=$this->Payment_method_model->get_list();
        $data['tax_types']=$this->Tax_types_model->get_list('is_deleted=0');
        $data['payment_methods']=$this->Payment_method_model->get_list('is_deleted=0');
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');

        $data['title'] = 'Treasury';
        (in_array('10-1',$this->session->user_rights)? 
        $this->load->view('treasury_view', $data)
        :redirect(base_url('dashboard')));
        
    }


    public function transaction($txn=null){
        switch($txn){
            case 'get-check-list':
                $m_journal=$this->Journal_info_model;
                $check_status_id = $this->input->get('check_status_id');
                $response['data']=$m_journal->get_treasury_for_release($check_status_id);
                echo json_encode($response);
                break;

            case 'check-for-release':
                $m_journal=$this->Journal_info_model;
                $response['data']=$m_journal->get_treasury_list(3);
                echo json_encode($response);
                break;

            case 'check-delivered':
                $m_journal=$this->Journal_info_model;
                $response['data']=$m_journal->get_treasury_list(4);
                echo json_encode($response);
                break;

            case 'get-entries':
                $journal_id=$this->input->get('id');
                $m_accounts=$this->Account_title_model;
                $m_journal_accounts=$this->Journal_account_model;

                $data['accounts']=$m_accounts->get_list(array('account_titles.is_active'=>TRUE,'account_titles.is_deleted'=>FALSE));
                $data['entries']=$m_journal_accounts->get_list('journal_accounts.journal_id='.$journal_id);

                $this->load->view('template/journal_entries', $data);
                break;

            case 'mark-delivered':
                $m_journal=$this->Journal_info_model;
                $journal_id=$this->input->post('journal_id');
                $journal=$m_journal->get_list($journal_id);

                $m_journal->begin();

                $m_journal->check_status_id=4;
                $m_journal->modify($journal_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=10; //CRUD
                $m_trans->trans_type_id=54; // TRANS TYPE
                $m_trans->trans_log='Delivered Check # : '.$journal[0]->check_no.' from txn # : '.$journal[0]->txn_no;
                $m_trans->save();

                $m_journal->commit();

                $response['row_updated']=$m_journal->get_treasury_list('all',$journal_id);
                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Check successfully marked as delivered.';
                echo json_encode($response);

            break;

            case 'mark-released':
                $m_journal=$this->Journal_info_model;
                $journal_id=$this->input->post('journal_id');
                $journal=$m_journal->get_list($journal_id);

                $m_journal->begin();

                $m_journal->check_status_id=3;
                $m_journal->modify($journal_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=10; //CRUD
                $m_trans->trans_type_id=54; // TRANS TYPE
                $m_trans->trans_log='Released Check # : '.$journal[0]->check_no.' from txn # : '.$journal[0]->txn_no;
                $m_trans->save();

                $m_journal->commit();

                $response['row_updated']=$m_journal->get_treasury_list('all',$journal_id);
                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Check successfully marked as released.';
                echo json_encode($response);
            break;

            case 'mark-approved':
                $m_journal=$this->Journal_info_model;
                $journal_id=$this->input->post('journal_id');
                $journal=$m_journal->get_list($journal_id);

                $m_journal->begin();

                $m_journal->check_status_id=2;
                $m_journal->modify($journal_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=9; //CRUD
                $m_trans->trans_type_id=54; // TRANS TYPE
                $m_trans->trans_log='Approved Check # : '.$journal[0]->check_no.' from txn # : '.$journal[0]->txn_no;
                $m_trans->save();

                $m_journal->commit();

                $response['row_updated']=$m_journal->get_treasury_list('all',$journal_id);
                $response['stat']='success';
                $response['title']='Success!';
                $response['msg']='Check successfully marked as approved.';
                echo json_encode($response);
            break;            
        };
    }



    public function get_response_rows($criteria=null){
        $m_journal=$this->Journal_info_model;
        return $m_journal->get_list(

            "journal_info.is_deleted=FALSE AND journal_info.book_type='CDJ'".($criteria==null?'':' AND journal_info.journal_id='.$criteria),

            array(
                'journal_info.journal_id',
                'journal_info.txn_no',
                'DATE_FORMAT(journal_info.date_txn,"%m/%d/%Y")as date_txn',
                'journal_info.is_active',
                'journal_info.remarks',
                'journal_info.department_id',
                'journal_info.check_type_id',
                'journal_info.supplier_id',
                'journal_info.customer_id',
                'journal_info.payment_method_id',
                'payment_methods.payment_method',
                'journal_info.check_no',
                'journal_info.check_status',
                'suppliers.supplier_name',
                'DATE_FORMAT(journal_info.check_date,"%m/%d/%Y") as check_date',
                'journal_info.ref_type',
                'journal_info.ref_no',
                'journal_info.amount',

                'CONCAT(IFNULL(customers.customer_name,""),IFNULL(suppliers.supplier_name,""))as particular',
                'CONCAT_WS(" ",user_accounts.user_fname,user_accounts.user_lname)as posted_by'
            ),
            array(
                array('customers','customers.customer_id=journal_info.customer_id','left'),
                array('suppliers','suppliers.supplier_id=journal_info.supplier_id','left'),
                array('departments','departments.department_id=journal_info.department_id','left'),
                array('user_accounts','user_accounts.user_id=journal_info.created_by_user','left'),
                array('payment_methods','payment_methods.payment_method_id=journal_info.payment_method_id','left')
            ),
            'journal_info.journal_id DESC'
        );
    }






}
