<?php
// ini_set('memory_limit', '4096M');
// ini_set('max_execution_time', 0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_summary extends CORE_Controller
{
    function __construct()
    {
        parent::__construct('');
        $this->validate_session();

        $this->load->library('excel');

        $this->load->model(
            array
            (
                'Departments_model',
                'Sales_invoice_model'
            )
        );
    }

    public function index() {
        $data['_def_css_files'] = $this->load->view('template/assets/css_files', '', true);
        $data['_def_js_files'] = $this->load->view('template/assets/js_files', '', true);
        $data['_switcher_settings'] = $this->load->view('template/elements/switcher', '', true);
        $data['_side_bar_navigation'] = $this->load->view('template/elements/side_bar_navigation', '', true);
        $data['_top_navigation'] = $this->load->view('template/elements/top_navigation', '', true);
        $data['title'] = 'Inventory Report';

        $data['departments']=$this->Departments_model->get_list(array('is_deleted'=>FALSE,'is_active'=>TRUE));
        $data['title']="Sales Summary";

        (in_array('8-3',$this->session->user_rights)? 
        $this->load->view('sales_summary_view', $data)
        :redirect(base_url('dashboard')));
    }


    public function transaction($txn=null){
            switch($txn){
                case 'test':
                    $invoices=$this->Sales_invoice_model->get_sales_summary();

                    $rows=array();
                    foreach($invoices as $x){
                        $rows[]=array(
                            $x->sales_inv_no,
                            $x->date_invoice,
                            $x->dr_si,
                            $x->vr,
                            $x->customer_name,
                            $x->product_desc,
                            $x->inv_qty,
                            $x->fg,
                            $x->size,
                            $x->supplier_name,
                            $x->srp,
                            $x->sales,
                            $x->purchase_cost,
                            $x->cost_of_sales

                        );
                    }

                    print_r($rows);
                    break;

                case 'export':
                    //activate worksheet number 1

                    $excel=$this->excel;


                    $excel->setActiveSheetIndex(0);
                    //name the worksheet
                    $excel->getActiveSheet()->setTitle('Sales Summary Report');

                    //set cell A1 content with some text
                    $excel->getActiveSheet()->setCellValue('A1', 'DR/SI')
                                            ->setCellValue('B1', 'Date')
                                            ->setCellValue('C1', 'Date Delivered')
                                            ->setCellValue('D1', 'Vet Rep')
                                            ->setCellValue('E1', 'VR')
                                            ->setCellValue('F1', 'Customer')
                                            ->setCellValue('G1', 'Product')
                                            ->setCellValue('H1', 'Type of Product')
                                            ->setCellValue('I1', 'Qty')
                                            ->setCellValue('J1', 'FG')
                                            ->setCellValue('K1', 'Pack Size')
                                            ->setCellValue('L1', 'Supplier')
                                            ->setCellValue('M1', 'SRP')
                                            ->setCellValue('N1', 'Sales')
                                            ->setCellValue('O1', 'Discount')
                                            ->setCellValue('P1', 'Unit Cost')
                                            ->setCellValue('Q1', 'Cost of Sales')
                                            ->setCellValue('R1', 'Net Profit')
                                            ->setCellValue('S1', 'Tax Amount')
                                            ->setCellValue('T1', 'Non Tax Amount')
                                            ->setCellValue('U1', 'With Returns?')
                                            ->setCellValue('V1', 'References');

                    //change the font size

                    $start=date("Y-m-d",strtotime($this->input->get('start',TRUE)));
                    $end=date("Y-m-d",strtotime($this->input->get('end',TRUE)));


                    // $invoices=$this->Sales_invoice_model->get_sales_summary($start,$end); // 05-28-2020 Original
                    $invoices=$this->Sales_invoice_model->get_sales_summary_2020($start,$end); // 05-28-2020 Revised, now with sales return
                    $i = 2;
                    foreach($invoices as $x){
                        $excel->getActiveSheet()->setCellValue('A'.$i,$x->sales_inv_no)
                                                ->setCellValue('B'.$i,$x->inv_date)
                                                ->setCellValue('C'.$i,$x->date_delivered)
                                                ->setCellValue('D'.$i,$x->salesperson_name)
                                                ->setCellValue('E'.$i,$x->vr)
                                                ->setCellValue('F'.$i,$x->customer_name)
                                                ->setCellValue('G'.$i,$x->product_desc)
                                                ->setCellValue('H'.$i,$x->product_type)
                                                ->setCellValue('I'.$i,$x->inv_qty)
                                                ->setCellValue('J'.$i,$x->fg)
                                                ->setCellValue('K'.$i,$x->size)
                                                ->setCellValue('L'.$i,$x->supplier_name)
                                                ->setCellValue('M'.$i,$x->srp)
                                                ->setCellValue('N'.$i,$x->sales)
                                                ->setCellValue('O'.$i,$x->discount_amount)
                                                ->setCellValue('P'.$i,$x->purchase_cost)
                                                ->setCellValue('Q'.$i,$x->cost_of_sales)
                                                ->setCellValue('R'.$i,$x->net_profit)
                                                ->setCellValue('S'.$i,$x->tax_amount)
                                                ->setCellValue('T'.$i,$x->non_tax_amount)
                                                ->setCellValue('U'.$i,$x->with_returns)
                                                ->setCellValue('V'.$i,$x->return_invoices);
                                                $i++;
                    }



                    $excel->getActiveSheet()->getStyle('A1:V1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('4caf50');

                    $styleArray = array(
                        'font'  => array(
                            'bold'  => true,
                            'color' => array('rgb' => 'FFFFF'),
                            'size'  => 10,
                            'name'  => 'Tahoma'
                        ));

                    $excel->getActiveSheet()->getStyle('A1:V1')->applyFromArray($styleArray);

                    //format columns with number data
                    $highestRow = $excel->getActiveSheet()->getHighestRow();
                    for($i=2;$i<=$highestRow;$i++){
                        $excel->getActiveSheet()->getStyle('L'.$i.':V'.$i)->getNumberFormat()->setFormatCode('#,##0.00');
                    }



                    //autofit column
                    foreach(range('A','V') as $columnID)
                    {
                        $excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(TRUE);
                    }

                    //merge cell A1 until D1
                    //$excel->getActiveSheet()->mergeCells('A1:D1');
                    //set aligment to center for that merged cell (A1 to D1)
                    //$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);


                    // Redirect output to a client’s web browser (Excel2007)
                    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                    header('Content-Disposition: attachment;filename="Sales Summary Report.xlsx"');
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
?>