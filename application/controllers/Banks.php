<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Banks_model');
        $this->load->model('Trans_model');
        $this->load->model('Account_title_model');        
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['accounts'] = $this->Account_title_model->get_list(array("is_deleted"=>FALSE));
        $data['title'] = 'Banks Management';

        (in_array('4-6',$this->session->user_rights)? 
        $this->load->view('bank_view', $data)
        :redirect(base_url('dashboard')));        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_banks = $this->Banks_model;
                $response['data'] = $m_banks->get_bank_list();
                echo json_encode($response);
                break;

            case 'create':
                $m_banks = $this->Banks_model;

                $m_banks->bank_code = $this->input->post('bank_code', TRUE);
                $m_banks->bank_name = $this->input->post('bank_name', TRUE);
                $m_banks->account_no = $this->input->post('account_no', TRUE);
                $m_banks->account_id = $this->input->post('account_id', TRUE);
                $m_banks->save();

                $bank_id = $m_banks->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=53; // TRANS TYPE
                $m_trans->trans_log='Created Bank: '.$this->input->post('bank_name', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Bank Information successfully created.';
                $response['row_added'] = $m_banks->get_bank_list($bank_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_banks=$this->Banks_model;
                $bank_id=$this->input->post('bank_id',TRUE);

                $m_banks->is_deleted=1;
                if($m_banks->modify($bank_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Bank Information successfully deleted.';

                    $bank = $m_banks->get_list($bank_id,'bank_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=53; // TRANS TYPE
                    $m_trans->trans_log='Deleted Bank: '.$bank[0]->bank_name;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_banks=$this->Banks_model;

                $bank_id=$this->input->post('bank_id',TRUE);
                $m_banks->bank_code=$this->input->post('bank_code',TRUE);
                $m_banks->bank_name=$this->input->post('bank_name',TRUE);
                $m_banks->account_no = $this->input->post('account_no', TRUE);
                $m_banks->account_id = $this->input->post('account_id', TRUE);
                $m_banks->modify($bank_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=53; // TRANS TYPE
                $m_trans->trans_log='Updated Bank: '.$this->input->post('bank_name',TRUE).' ID('.$bank_id.')';
                $m_trans->save();
                
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Bank Information successfully updated.';
                $response['row_updated']=$m_banks->get_bank_list($bank_id);
                echo json_encode($response);

                break;
        }
    }
}
