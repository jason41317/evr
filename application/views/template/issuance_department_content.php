<head>  
    <title>Item Transfer</title>
</head>
<body>
    <style type="text/css">
        body {
            font-family: 'Calibri',sans-serif;
            font-size: 12px;
        }

        .border{
            border: 1px solid black!important; 
        }

        .default-color{
            color:#2d419b;
            font-weight: bold; 
            font-size: 9pt;
        }
        .top{
            border-top: 1px solid black;
        }
        .bottom{
            border-bottom: 1px solid black;
        }
        .left{
            border-left: 1px solid black;
        }
        .right{
            border-right: 1px solid black;
        }
        .bold{
            font-weight: bold;
        }
        table{
            border-collapse: collapse;
        }
    </style>
<div>
    <table width="100%">
        <tr class="">
            <td width="20%" valign="top">
                <img src="<?php echo base_url().$company_info->logo_path; ?>" style="height: 100px; width: 150px;"> 
            </td>
            <td width="40%" valign="top">
                <h2><?php echo $company_info->company_name; ?></h2>
                <br/>
                <p><?php echo $company_info->company_address; ?></p>
                <p><?php echo $company_info->company_address_2; ?></p>
                <span>Email : <?php echo $company_info->email_address; ?></span>
                <p>Tel and Fax no.: <?php echo $company_info->landline.' &nbsp;'.$company_info->mobile_no; ?></p>
            </td>
            <td width="50%" style="text-align: right;" valign="top">
                <h1><b>ITEM TRANSFER REPORT</b></h1><br/>
                <table width="100%" class="table table-striped" style="border-collapse: collapse;">
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td width="35%" class="border default-color" align="center">
                            <b>TRANSFER NO</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center"><?php echo $issuance_info->trn_no; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><br/></td>
                    </tr>
                    <tr>
                        <td width="65%">&nbsp;</td>
                        <td width="35%" class="border default-color" align="center">
                            <b>DATE</b>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td class="border" style="padding: 5px 0px 5px 0px;" align="center">
                            <?php echo date('M d,Y',strtotime($issuance_info->date_issued));?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br><br>
    <table width="100%" cellpadding="5" class="table table-striped">
        <tr>
            <td width="35%" class="border" valign="top" style="padding: 10px;">
                <span class="default-color">FROM DEPARTMENT : </span><br/><br/>
                <span style="font-size: 10pt;"><b><?php echo $issuance_info->from_department_name; ?></b></span><br/>
            </td>
            <td width="35%" class="border" valign="top" style="padding: 10px;">
                <span class="default-color">TO DEPARTMENT : </span><br/><br/>
                <span style="font-size: 10pt;"><b><?php echo $issuance_info->to_department_name; ?></b></span><br/>
            </td>
            <td width="30%" class="border" valign="top" style="padding: 10px;">
                <span class="default-color">TERMS : </span><br/><br/>
                <span style="font-size: 10pt;"><b><?php echo $issuance_info->terms; ?></b></span><br/>
            </td>            
        </tr>
    </table>
    <br/><br/>
<table width="100%" cellpadding="6" class="table table-striped">
        <tr>
            <td width="15%" class="default-color border" valign="top" align="right">QTY</td>
            <td width="25%" class="default-color border" valign="top">DESCRIPTION</td>
            <td width="15%" class="default-color border" valign="top">Expiration</td>
            <td width="15%" class="default-color border" valign="top">Batch No</td>
            <td width="15%" class="default-color border" valign="top" align="right">UNIT PRICE</td>
            <td width="15%" class="default-color border" valign="top" align="right">TOTAL</td>
        </tr>
        <?php 
            $grandtotal=0;
            foreach($issue_items as $item){
            $grandtotal+=$item->issue_line_total_price; ?>
        <tr>
            <td class="left right" align="right"><?php echo number_format($item->issue_qty,2); ?></td>
            <td class="left right"><?php echo $item->product_desc; ?></td>
            <td class="left right"><?php echo $item->exp_date; ?></td>
            <td class="left right"><?php echo $item->batch_no; ?></td>
            <td class="left right" align="right"><?php echo number_format($item->issue_price,2); ?></td>
            <td class="left right" align="right"><?php echo number_format($item->issue_line_total_price,2); ?></td>
        </tr>
        <?php }?>
        <tr>
            <td class="border" align="right" colspan="5"><b>TOTAL AMOUNT DUE</b></td>
            <td class="border" align="right">
                <?php echo number_format($grandtotal,2); ?>
            </td>
        </tr>
    </table>
</div>





















