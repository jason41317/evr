<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CORE_Controller {
    function __construct() {
        parent::__construct('');
        $this->validate_session();
        $this->load->model('Departments_model');
        $this->load->model('Trans_model');        
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);
        $data['title'] = 'Department Management';

        (in_array('4-2',$this->session->user_rights)? 
        $this->load->view('departments_view', $data)
        :redirect(base_url('dashboard')));        
    }

    function transaction($txn = null) {
        switch ($txn) {
            case 'list':
                $m_departments = $this->Departments_model;
                $filter = array('is_deleted' => FALSE);
                $is_active = $this->input->post('is_active', TRUE);
                if ($is_active != -1) {
                    $filter = array('is_deleted' => FALSE, 'is_active' => $is_active);
                }
                $response['data'] = $m_departments->get_list($filter);
                echo json_encode($response);
                break;

            case 'create':
                $m_departments = $this->Departments_model;

                $m_departments->department_name = $this->input->post('department_name', TRUE);
                $m_departments->department_desc = $this->input->post('department_desc', TRUE);
                $m_departments->delivery_address = $this->input->post('delivery_address', TRUE);
                $m_departments->default_cost = $this->input->post('default_cost', TRUE);
                $m_departments->save();

                $department_id = $m_departments->last_insert_id();

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=1; //CRUD
                $m_trans->trans_type_id=46; // TRANS TYPE
                $m_trans->trans_log='Created Department: '.$this->input->post('department_name', TRUE);
                $m_trans->save();

                $response['title'] = 'Success!';
                $response['stat'] = 'success';
                $response['msg'] = 'Department Information successfully created.';
                $response['row_added'] = $m_departments->get_department_list($department_id);
                echo json_encode($response);

                break;

            case 'delete':
                $m_departments=$this->Departments_model;

                $department_id=$this->input->post('department_id',TRUE);

                $m_departments->is_deleted=1;
                if($m_departments->modify($department_id)){
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Department Information successfully deleted.';

                    $department_name = $m_departments->get_list($department_id,'department_name');
                    $m_trans=$this->Trans_model;
                    $m_trans->user_id=$this->session->user_id;
                    $m_trans->set('trans_date','NOW()');
                    $m_trans->trans_key_id=3; //CRUD
                    $m_trans->trans_type_id=46; // TRANS TYPE
                    $m_trans->trans_log='Deleted Department: '.$department_name[0]->department_name;
                    $m_trans->save();

                    echo json_encode($response);
                }

                break;

            case 'update':
                $m_departments=$this->Departments_model;

                $department_id=$this->input->post('department_id',TRUE);
                $m_departments->department_name=$this->input->post('department_name',TRUE);
                $m_departments->department_desc=$this->input->post('department_desc',TRUE);
                $m_departments->delivery_address = $this->input->post('delivery_address', TRUE);
                $m_departments->default_cost = $this->input->post('default_cost', TRUE);
                $m_departments->modify($department_id);

                $m_trans=$this->Trans_model;
                $m_trans->user_id=$this->session->user_id;
                $m_trans->set('trans_date','NOW()');
                $m_trans->trans_key_id=2; //CRUD
                $m_trans->trans_type_id=46; // TRANS TYPE
                $m_trans->trans_log='Updated Department: '.$this->input->post('department_name',TRUE).' ID('.$department_id.')';
                $m_trans->save();
                
                $response['title']='Success!';
                $response['stat']='success';
                $response['msg']='Department Information successfully updated.';
                $response['row_updated']=$m_departments->get_department_list($department_id);
                echo json_encode($response);

                break;

            case 'activate-deactivate':
                $m_departments=$this->Departments_model;

                $department_id=$this->input->post('department_id',TRUE);

                $m_departments->is_active = $this->input->post('is_active',TRUE) ? 1 : 0;
                if($m_departments->modify($department_id)){         
                    $response['title']='Success!';
                    $response['stat']='success';
                    $response['msg']='Department information successfully '.($m_departments->is_active ? 'Activated' : 'Deactivated').'.';
                    $response['row_updated']=$m_departments->get_department_list($department_id);
                    echo json_encode($response);
                }

                break;
        }
    }
}
