<!DOCTYPE html>
<html>
<head>
	<title>Payment History</title>
	<style type="text/css">
		table.payment{
			border-collapse: collapse;
			width: 100%;
			border: 0px;
			font-size: 8pt;
		}
	</style>
</head>
<body>
	<div style="padding: 10px;">
		<table class="payment" cellpadding="2" cellspacing="2">
			<tr>
				<td>Receipt Type : <strong><?php echo $info[0]->receipt_type; ?></strong></td>
				<td>Payment Method : <strong><?php echo $info[0]->payment_method; ?></strong></td>
				<td align="right">Payment Date : <strong><?php echo $info[0]->date_paid; ?></strong></td>
			</tr>
			<tr>
				<td>Receipt # : <strong><?php echo $info[0]->receipt_no; ?></strong></td>
				<td>Department : <strong><?php echo $info[0]->department_name; ?></strong></td>
				<td align="right">Bank : <strong><?php echo $info[0]->bank_name; ?></strong></td>
			</tr>
			<tr>
				<td>Supplier : <strong><?php echo $info[0]->supplier_name; ?></strong></td>
				<td></td>
				<td align="right">Check # : <strong><?php echo $info[0]->check_no; ?></strong></td>
			</tr>
			<tr>
				<td>Posted By : <strong><?php echo $info[0]->posted_by; ?></strong></td>
				<td></td>
				<td align="right">Check Date : <strong><?php echo $info[0]->check_no; ?></strong></td>
			</tr>
		</table><br/>
		<table width="100%">
			<tr>
				<td><strong>Invoice #</strong></td>
				<td><strong>Due Date</strong></td>
				<td><strong>Terms</strong></td>
				<td><strong>External Ref</strong></td>
				<td><strong>Remarks</strong></td>
				<td><strong>Payment</strong></td>
			</tr>
			<?php foreach($invoices as $invoice){ ?>
				<tr>
					<td><?php echo $invoice->dr_invoice_no; ?></td>
					<td><?php echo $invoice->date_due; ?></td>
					<td><?php echo $invoice->terms; ?></td>
					<td><?php echo $invoice->external_ref_no; ?></td>
					<td><?php echo $invoice->remarks; ?></td>
					<td><?php echo $invoice->payment_amount; ?></td>
				</tr>
			<?php }?>
		</table>
	</div>
</body>
</html>