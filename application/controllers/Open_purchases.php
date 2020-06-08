<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Open_purchases extends CORE_Controller
{

    function __construct() {
        parent::__construct('');
        $this->validate_session();

        $this->load->model('Purchase_items_model');
        $this->load->model('Purchases_model');
        $this->load->model('Company_model');
        $this->load->library('excel');
    }

    public function index() {

        //default resources of the active view
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', TRUE);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', TRUE);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', TRUE);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', TRUE);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', TRUE);

        $data['title'] = 'Open Purchases';
        $this->load->view('open_purchases_view', $data);


    }

    function transaction($txn = null,$id_filter=null) {
        switch ($txn){
            case'list';
                $m_purchases=$this->Purchase_items_model;
                $response['data']=$m_purchases->get_list_open_purchase();
                echo json_encode($response);
            break;

            case'report';
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $data['company_info']=$company_info[0];



                $m_purchases=$this->Purchase_items_model;
                $data['purchase']=$m_purchases->get_list_open_purchase();
                $data['item']=$m_purchases->get_po_no_of_open_purchase();


                $this->load->view('template/open_purchase_report',$data);
                break;

                case'export';
                $excel = $this->excel;
                $m_company=$this->Company_model;
                $company_info=$m_company->get_list();
                $company_info=$company_info[0];

                $m_purchases=$this->Purchase_items_model;
                $purchase=$m_purchases->get_list_open_purchase();
                $item=$m_purchases->get_po_no_of_open_purchase();

                $excel->setActiveSheetIndex(0);

                $excel->getActiveSheet()->setTitle('Open Purchase');

                $excel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('D')->setWidth(50);
                $excel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $excel->getActiveSheet()->getColumnDimension('G')->setWidth(20);

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
                                            ->mergeCells('A5:G5')
                                            ->getStyle('A5:G5')->applyFromArray($border_bottom);

                    $excel->getActiveSheet()
                            ->getStyle('A6:G6')
                            ->getAlignment()
                            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $excel->getActiveSheet()->setCellValue('A6','Open Purchases')
                                            ->mergeCells('A6:G6')
                                            ->getStyle('A6:G6')->getFont()->setBold(True)
                                            ->setSize(14);

                $i=8;

                foreach ($item as $batchNo) {

                $excel->getActiveSheet()
                    ->getStyle('A'.$i.':'.'G'.$i)
                    ->getFill()
                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FF9900');

                $excel->getActiveSheet()->mergeCells('A'.$i.':'.'G'.$i);
                $excel->getActiveSheet()->setCellValue('A'.$i,'PO #: '.$batchNo->po_no)
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $i++;
                                         
                $excel->getActiveSheet()->setCellValue('A'.$i,'Purchase Order No')
                                        ->getStyle('A'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('B'.$i,'Date')
                                        ->getStyle('B'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('C'.$i,'Product Code')
                                        ->getStyle('C'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('D'.$i,'Product Description')
                                        ->getStyle('D'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('E'.$i,'Order Qty')
                                        ->getStyle('E'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('F'.$i,'Delivered Qty')
                                        ->getStyle('F'.$i)->getFont()->setBold(TRUE);
                $excel->getActiveSheet()->setCellValue('G'.$i,'Balance')
                                        ->getStyle('G'.$i)->getFont()->setBold(TRUE);

                $i++;

                    foreach ($purchase as $po) {    
                        if ($batchNo->po_no == $po->po_no) { 
                            $excel->getActiveSheet()->setCellValue('A'.$i,$po->po_no);
                            $excel->getActiveSheet()->setCellValue('B'.$i,$po->last_date_delivered);
                            $excel->getActiveSheet()->setCellValue('C'.$i,$po->product_code);
                            $excel->getActiveSheet()->setCellValue('D'.$i,$po->product_desc);
                            $excel->getActiveSheet()->setCellValue('E'.$i,$po->PoQtyTotal);
                            $excel->getActiveSheet()->setCellValue('F'.$i,$po->PoQtyDelivered);
                            $excel->getActiveSheet()->setCellValue('G'.$i,$po->PoQtyBalance);
                            $i++;                                                                                                                                                                                                                                  
                        }
                    }         
                }


                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename='."Open Purchase Report.xlsx".'');
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
