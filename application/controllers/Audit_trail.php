<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Audit_trail extends CORE_Controller
	{
		
		function __construct()
		{
			parent::__construct('');
			$this->validate_session();
			$this->load->library('excel');
			$this->load->model(
				array(
					'Adjustment_item_model',
					'Company_model',
					'Users_model',
				)
			);
		}

		public function index()
		{
		 	$data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
	        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
	        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
	        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
	        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
	        $data['title'] = 'Audit Trail Report';

	        $data['trans_key']= $this->db->from('trans_key')->get()->result();
	        $data['trans_type']= $this->db->from('trans_type')->get()->result();
	        $data['users']= $this->Users_model->get_user_list_audit_trail();

	        ($this->session->user_group_id != 1 ? redirect(base_url('dashboard')) : $this->load->view('audit_trail_view', $data) );

		}

		function transaction($txn=null){
			switch($txn){
				case 'list':
	                $tsd = date('Y-m-d',strtotime($this->input->get('startDate')));
	                $ted = date('Y-m-d',strtotime($this->input->get('endDate')));
	                $trans_type_id = $this->input->get('trans_type_id');
	                $trans_key_id = $this->input->get('trans_key_id');
	                $user_id = $this->input->get('user_id');
					$response['data'] = $this->Users_model->get_newsfeed_revised($tsd,$ted,$trans_type_id,$trans_key_id,$user_id);
					echo json_encode($response);
				break;
			}
		}
	}
?>