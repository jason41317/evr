<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open_sales extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Sales_order_model');
        $this->load->model('Sales_order_item_model');
        $this->load->model('Products_model');
        $this->load->model('Company_model');
        $this->load->model('Users_model');
        $this->load->library('excel');
    }

    public function index() {

        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['title'] = 'Open Sales';

        (in_array('8-10',$this->session->user_rights)? 
        $this->load->view('open_sales_view', $data)
        :redirect(base_url('dashboard')));

    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case'list';
                $m_sales=$this->Sales_order_item_model;
                $response['data']=$m_sales->get_list_open_sales();
                echo json_encode($response);
            break;

            case'report';
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];
                $m_sales=$this->Sales_order_item_model;
                $data['sales']=$m_sales->get_list_open_sales();
                $data['item']=$m_sales->get_so_no_of_open_sales();

                $this->load->view('template/open_sales_report',$data);
                break;               

            case'export';
                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $m_sales=$this->Sales_order_item_model;
                $sales=$m_sales->get_list_open_sales();

                $item=$m_sales->get_so_no_of_open_sales();

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->setTitle('Open Sales');

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

                $excel->getActiveSheet()->setCellValue('A1',$company_info->company_name)
                                        ->mergeCells('A1:D1')
                                        ->getStyle('A1:D1')->getFont()->setBold(True)
                                        ->setSize(16);

                $excel->getActiveSheet()->setCellValue('A2',$company_info->company_address)
                                        ->mergeCells('A2:D2')
                                        ->setCellValue('A3',$company_info->landline.' / '.$company_info->mobile_no)
                                        ->mergeCells('A3:D3');

                    $border_bottom= array(
                    'borders' => array(
                        'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                            'color' => array('rgb' => '292929')
                        )
                    ));

                    $excel->getActiveSheet()->setCellValue('A5')
                                            ->mergeCells('A5:H5')
                                            ->getStyle('A5:H5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:H6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A6','OPEN SALES')
                                            ->mergeCells('A6:H6')
                                            ->getStyle('A6:H6')->getFont()->setBold(True)
                                            ->setSize(14);

                $i=8;

                foreach ($item as $batchNo) {

                $excel->getActiveSheet()
                    ->getStyle('A'.$i.':'.'H'.$i)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF9900');

                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'H'.$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'SO #: '.$batchNo->so_no)
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $i++;
                                         
                $excel->getActiveSheet()->setCellValue('A'.$i,'Sales Order No')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Date')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Product Code')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Product Description')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Product Type')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Order Qty')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'Delivered Qty')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('H'.$i,'Balance')
                                        ->getStyle('H'.$i)->getFont()->setBold(TRUE);

                $i++;

                    foreach ($sales as $so) {    
                        if ($batchNo->so_no == $so->so_no) { 
                            $excel->getActiveSheet()->setCellValue('A'.$i,$so->so_no);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$so->last_invoice_date);
                            $excel->getActiveSheet()->setCellValue('C'.$i,$so->product_code);
                            $excel->getActiveSheet()->setCellValue('D'.$i,$so->product_desc);
                            $excel->getActiveSheet()->setCellValue('E'.$i,$so->product_type);
                            $excel->getActiveSheet()->setCellValue('F'.$i,$so->SoQtyTotal);
                            $excel->getActiveSheet()->setCellValue('G'.$i,$so->SoQtyDelivered);
                            $excel->getActiveSheet()->setCellValue('H'.$i,$so->SoQtyBalance);
                            $i++;                                                                                                                                                                                                                                  
                        }
                    }         
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Open Sales Report.xlsx".'');
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

}
