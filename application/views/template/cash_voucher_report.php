<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
		html {
			font-family: 'Tahoma',sans-serif;
		}

		span {
			font-size: 10px;
		}

		td {
			font-size: 9px;
		}

		.hidden {
			color: transparent;
		}
	</style>
	<script>
		(function(){
			window.print();
		})();
	</script>
</head>
<body>
	<strong>
	<span style="position: absolute; left: 125px; top: 48px;"><?php echo $journal_info->supplier_name; ?></span>
	<span style="position: absolute; right: 50px; top: 48px;"><?php echo $journal_info->date_txn; ?></span>
	<span style="position: absolute; left: 125px; top: 60px;text-transform: capitalize;"><?php echo $formatted_amount; ?></span>
	<span style="position: absolute; left: 170px; top: 211px;"><?php echo $journal_info->remarks; ?></span>
	<span style="position: absolute; left: 170px; top: 252px;"><?php echo $journal_info->bank; ?></span>
	<span style="position: absolute; left: 170px; top: 265px;"><?php echo $journal_info->check_date; ?></span>
	<span style="position: absolute; left: 170px; top: 277px;"><?php echo $journal_info->check_no; ?></span>
	</strong>

	<table style="position: absolute; left: 30px; top: 83px;" width="100%">
	<?php foreach($journal_accounts as $account){ ?>
        <tr>
            <td width="50%" style="padding: 0; font-size: 13px;"><strong><?php echo $account->account_title; ?></strong></td>
            <td width="20%" style="padding: 0; font-size: 13px;" align="right"><strong><?php echo number_format($account->dr_amount,2); ?></strong></td>
            <td width="20%" style="padding: 0; font-size: 13px;" align="right"><strong><?php echo number_format($account->cr_amount,2); ?></strong></td>
            <td width="10%" style="padding: 0;"></td>
        </tr>
    <?php   } 	?>
    </table>
</body>
</html>