<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Check_summary extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model(
            array(
                'Journal_info_model',
                'Journal_account_model',
                'Banks_model',
                'Users_model',
                'Company_model',
                'Check_layout_model'
            )
        );

        $this->load->library('excel');
    }

    public function index() {
        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['banks']=$this->Banks_model->get_list(array('is_deleted'=>FALSE));
        $data['layouts']=$this->Check_layout_model->get_list('is_deleted=0');        

        $data['title'] = 'Check Summary';
        (in_array('1-7',$this->session->user_rights)? 
        $this->load->view('check_summary_view', $data)
        :redirect(base_url('dashboard')));
        
    }

    public function transaction($txn=null){
        switch($txn){

            case 'get-check-list':
                $m_journal=$this->Journal_info_model;
                $bank_id = $this->input->get('bank_id', TRUE);
                $tsd = date('Y-m-d',strtotime($this->input->get('start_date', TRUE)));
                $ted = date('Y-m-d',strtotime($this->input->get('end_date', TRUE)));
                $response['data']=$m_journal->get_check_list($bank_id,$tsd,$ted);
                echo json_encode($response);
                break;

            case 'print-check-list':
                $m_journal=$this->Journal_info_model;
                $m_bank=$this->Banks_model;

                $bank_id = $this->input->get('bank', TRUE);
                $tsd = date('Y-m-d',strtotime($this->input->get('start', TRUE)));
                $ted = date('Y-m-d',strtotime($this->input->get('end', TRUE)));

                $data['checks']=$m_journal->get_check_list($bank_id,$tsd,$ted);

                $company_info=$this->Company_model->get_list();
                $params['company_info']=$company_info[0];

                $bank_name = "";

                if($bank_id == 'all'){
                    $bank_name = 'All Banks';
                }else{
                    $bank=$m_bank->get_list($bank_id);
                    if(count($bank)>0){
                        $bank_name = $bank[0]->bank_name;
                    }else{
                        $bank_name = 'None';
                    }
                }

                $data['bank']=$bank_name;
                $data['start']=date('m/d/Y',strtotime($this->input->get('start')));
                $data['end']=date('m/d/Y',strtotime($this->input->get('end')));

                $data['company_header']=$this->load->view('template/company_header',$params,TRUE);
                $this->load->view('template/check_list_report',$data);
                break;

            case 'export-check-list':

                $excel = $this->excel;
                 
                $m_journal=$this->Journal_info_model;
                $m_bank=$this->Banks_model;

                $bank_id = $this->input->get('bank', TRUE);
                $tsd = date('Y-m-d',strtotime($this->input->get('start', TRUE)));
                $ted = date('Y-m-d',strtotime($this->input->get('end', TRUE)));

                $checks=$m_journal->get_check_list($bank_id,$tsd,$ted);
                $company_info=$this->Company_model->get_list();
                $bank_name = "";

                if($bank_id == 'all'){
                    $bank_name = 'All Banks';
                }else{
                    $bank=$m_bank->get_list($bank_id);
                    if(count($bank)>0){
                        $bank_name = $bank[0]->bank_name;
                    }else{
                        $bank_name = 'None';
                    }
                }

                $start=date('m/d/Y',strtotime($this->input->get('start')));
                $end=date('m/d/Y',strtotime($this->input->get('end')));            

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->getColumnDimensionByColumn('A1')->setWidth('5');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A2')->setWidth('50');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A3')->setWidth('30');
                $excel->getActiveSheet()->getColumnDimensionByColumn('A4')->setWidth('40');

                //name the worksheet
                $excel->getActiveSheet()->setTitle('Check Summary');
                $excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);

                $excel->getActiveSheet()->setCellValue('A1',$company_info[0]->company_name)
                                        ->setCellValue('A2',$company_info[0]->company_address)
                                        ->setCellValue('A3',$company_info[0]->email_address)
                                        ->setCellValue('A4',$company_info[0]->landline);                                            
                $excel->getActiveSheet()->mergeCells('A6:I6');                                            
                $excel->getActiveSheet()->mergeCells('A7:I7');

                $excel->getActiveSheet()
                        ->getStyle('A6:I7')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);                


                $excel->getActiveSheet()->setCellValue('A6','Check Summary - '.$bank_name)
                                        ->getStyle('A6')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('A7','Period '.$start.' to '.$end)
                                        ->getStyle('A7')->getFont()->setBold(TRUE);

                $filename = 'Check Summary - '.$start.' to '.$end.'.xlsx';  
                                       
                $excel->getActiveSheet()->setCellValue('A8','')
                                        ->getStyle('A8')->getFont()->setItalic(TRUE);

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth('20');
                $excel->getActiveSheet()->getColumnDimension('I')->setWidth('20');

                 $style_header = array(
                    'font' => array(
                        'bold' => true,
                    )
                );

                $excel->getActiveSheet()->getStyle('A9:I9')->applyFromArray( $style_header );            

                $excel->getActiveSheet()
                        ->getStyle('A9:C9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('D9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

                $excel->getActiveSheet()
                        ->getStyle('E9:I9')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);                                                


                $excel->getActiveSheet()->setCellValue('A9','Bank')
                                        ->getStyle('A9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B9','Check #')
                                        ->getStyle('B9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C9','Check Date')
                                        ->getStyle('C9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D9','Amount')                    
                                        ->getStyle('D9')->getFont()->setBold(TRUE);          
                $excel->getActiveSheet()->setCellValue('E9','Reference')
                                        ->getStyle('E9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F9','Book Type')
                                        ->getStyle('F9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G9','Particular')
                                        ->getStyle('G9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H9','Remarks')
                                        ->getStyle('H9')->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('I9','Issued')
                                        ->getStyle('I9')->getFont()->setBold(TRUE);
                      
                $i=10;

                foreach ($checks as $row) {
                
                $excel->getActiveSheet()->setCellValue('A'.$i,$row->bank)
                                        ->setCellValue('B'.$i,$row->check_no)
                                        ->setCellValue('C'.$i,$row->check_date)
                                        ->setCellValue('D'.$i,number_format($row->amount,2))
                                        ->setCellValue('E'.$i,$row->ref_no)
                                        ->setCellValue('F'.$i,$row->book_type)
                                        ->setCellValue('G'.$i,$row->supplier_name)
                                        ->setCellValue('H'.$i,$row->remarks)
                                        ->setCellValue('I'.$i,$row->status);    

                $excel->getActiveSheet()->getStyle('D'.$i)->getNumberFormat()->setFormatCode('###,##0.00;(###,##0.00)'); 

                $excel->getActiveSheet()
                        ->getStyle('A'.$i.':C'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                $excel->getActiveSheet()
                        ->getStyle('D'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT); 

                $excel->getActiveSheet()
                        ->getStyle('E'.$i.':I'.$i)
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);                                                
                $i++;

                }

                $i++;

                $excel->getActiveSheet()->setCellValue('A'.$i,'Date Printed: '.date('Y-m-d h:i:s'));
                $i++;
                $excel->getActiveSheet()->setCellValue('A'.$i,'Printed by: '.$this->session->user_fullname);

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='.$filename);
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

        };
    }

}
