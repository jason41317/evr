<!-- <link rel="stylesheet" type="text/css" href="assets/css/style-blessed3ef7a.css"> -->
<html>
	<head>
		<style type="text/css">
			body {
				font-family: 'Tahoma';
			}
		</style>
	</head>
	<body>
		<div style="width: 100%; text-align:center; font-family: 'Tahoma'">
			<h1 style="font-weight: 600;">EVR Vet-Options Corporation</h1>
			<span><?php echo $company_info->company_address; ?></span><br>
			<span>Tel nos.: <?php echo $company_info->landline; ?></span><br>
			<span>VAT REG. TIN NO <?php echo $company_info->tin_no; ?></span>
		</div>
		<br><br>
		<div style="width: 100%">
			PURCHASE ORDER
		</div>
		<br>
		<table style="width: 100%; border: 1px solid black; font-size: 10pt; padding-bottom: 7px;">
			<tr>
				<td style="padding: 7px 5px 0 5px; width: 15%;">Ordered By :</td>
				<td style="padding: 7px 0 0 5px; width: 45%;"><?php echo $sales_invoice->customer_name; ?></td>
				<td style="padding: 7px 5px 0 5px; width: 15%;">Order Date :</td>
				<td style="padding: 7px 0 0 5px; width: 25%;"><?php echo date('F d, Y', strtotime($sales_invoice->date_order ? $sales_invoice->date_order : $sales_invoice->date_invoice)); ?></td>
			</tr>
			<tr>
				<td style="padding: 7px 5px 0 5px;">Address :</td>
				<td style="padding: 7px 0 0 5px;"><?php echo $sales_invoice->address; ?></td>
				<td style="padding: 7px 5px 0 5px;">Terms :</td>
				<td style="padding: 7px 0 0 5px;"><?php echo $sales_invoice->terms; ?></td>
			</tr>
		</table>
		<br>
		<table style="width: 100%; border: 1px solid black; font-size: 10pt; border-collapse: collapse;">
			<th>
				<tr style="border: 1px solid black;">
					<td style="text-align: center; width: 15%; padding: 7px 0;">QTY</td>
					<td style="text-align: center; width: 20%; padding: 7px 0;">PACK SIZE</td>
					<td style="text-align: left; width: 65%; padding: 7px 0;">PRODUCT</td>
				</tr>
			</th>
		<?php 
			// var_dump($sales_invoice_items);
			foreach ($sales_invoice_items as $item) {
		?>
			<tr style="border-right: 1px solid black;">
				<td style="text-align: center; padding-top: 5px"><?php echo $item->inv_qty; ?></td>
				<td style="text-align: center; padding-top: 5px"><?php echo $item->unit_name; ?></td>
				<td style="text-align: left; padding-top: 5px"><?php echo $item->product_desc; ?></td>
			</tr>
		<?php
			}
		?>
			
		</table>
		<br>
		<small><i>" This is to acknowledge the above list of products ordered from EVR VET-OPTIONS CORPORATION or its representative are bound together with issued signed Sales Invoices and other relevant delivery documents. The signature that appeared on behalf of the company represents its authorization to receive the ordered items from EVR VET-OPTIONS CORPORATION."</i></small>
		<br><br><br>
		<table style="width: 100%">
			<tr>
				<td style="width: 15%;">Prepared by: </td>
				<td style="text-align: center; width: 35%;"><?php echo $sales_invoice->sales_order_id != 0 ? $sales_invoice->so_prepared_by : $sales_invoice->prepared_by; ?></td>
				<td style="padding-left: 30px; width: 25%;">Conforme:</td>
				<td style="width: 25%"></td>
			</tr>
			<tr>
				<td></td>
				<td style="border-top: 1px solid black; text-align: center">EVR Sales Representative</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>__________________________________</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td style="text-align: center">Signature over Printed Name / Date</td>
			</tr>
		</table>
	</body>
</html>
