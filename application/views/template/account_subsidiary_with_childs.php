<!DOCTYPE html>
<html>
<head>
    <title>Account Subsidiary Report</title>
    <style type="text/css">
        body {
            font-family: 'Tahoma',sans-serif;
            font-size: 10px;
        }
        @media print{@page {size: landscape}}


    </style>
</head>
<body>

    <div id="company_header">
        <h2 style="display: table;margin: 0 auto;!important;"><?php echo $company_info->company_name; ?></h2>
        <p style="display: table;margin: 0 auto;!important;"><?php echo $company_info->company_address; ?></p>
        <p style="display: table;margin: 0 auto;!important;"><?php echo $company_info->landline.'/'.$company_info->mobile_no; ?></p>
    </div>

    <br /><br />
    <div class="report_title">
        <h3 style="font-weight:bold;display: table;margin: 0 auto;!important;">Account Subsidiary</h3>
        <span style="display: table;margin: 0 auto;!important;">From <?php echo date('M d, Y',strtotime($this->input->get('startDate',TRUE))); ?> to <?php echo date('M d, Y',strtotime($this->input->get('endDate',TRUE))); ?></span>
    </div>

    <?php

    $over_all_debit=0.00;$over_all_credit=0.00;
    foreach($accounts as $account){ ?>

    <br /><br />
        <span style="font-weight: 600;">Account Subsidiary :  <?php echo $account->account_title; ?></span>
    <br />
        Account Reference :  <?php echo $account->account_no; ?>
    <br />    <br />

    <table width="100%" border="1" style="border-collapse: collapse;">
            <thead>
            <tr>
                <th style="padding: 2px;">Txn Date</th>
                <th style="padding: 2px;">Txn #</th>
                <th style="padding: 2px;">Particular</th>
                <th style="padding: 2px;">Memo</th>
                <th style="padding: 2px;">Remarks</th>
                <th style="padding: 2px;" align="right">Debit</th>
                <th style="padding: 2px;" align="right">Credit</th>
                <th style="padding: 2px;" align="right">Balance</th>
            </tr>
            </thead>
            <tbody>
                <?php

                $total_debit=0.00; $total_credit=0.00; $running_balance=0.00;

                foreach($transactions as $transaction){ ?>
                    <?php



                        if($transaction->account_id==$account->account_id){

                            $total_debit+=$transaction->dr_amount;
                            $total_credit+=$transaction->cr_amount;
                            $running_balance=($account->account_type_id==1||$account->account_type_id==5?($total_debit-$total_credit)+$running_balance:($total_credit-$total_debit)+$running_balance);

                            $over_all_debit+=$total_debit;
                            $over_all_credit+=$total_credit;
                        ?>
                    <tr>
                        <td style="padding: 1px;"><?php echo $transaction->date_txn; ?></td>
                        <td style="padding: 1px;"><?php echo $transaction->txn_no; ?></td>
                        <td style="padding: 1px;"><?php echo $transaction->particular; ?></td>
                        <td style="padding: 1px;"><?php echo $transaction->memo; ?></td>
                        <td style="padding: 1px;"><?php echo $transaction->remarks; ?></td>
                        <td style="padding: 1px;text-align: right;"><?php echo number_format($transaction->dr_amount,2); ?></td>
                        <td style="padding: 1px;text-align: right;"><?php echo number_format($transaction->cr_amount,2); ?></td>
                        <td style="padding: 1px;text-align: right;"><?php echo number_format($running_balance,2); ?></td>
                    </tr>
                    <?php } ?>
                <?php } ?>
                <tr>
                    <td colspan="5" style="padding: 2px;text-align: right;"><b> Total <?php echo $account->account_title; ?></b></td>
                    <td style="text-align: right;"><?php echo number_format($total_debit,2); ?></td>
                    <td style="text-align: right;"><?php echo number_format($total_credit,2); ?></td>
                    <td style="text-align: right;"><?php echo number_format(($account->account_type_id==1||$account->account_type_id==5?$total_debit-$total_credit:$total_credit-$total_debit),2); ?></td>

                </tr>
            </tbody>



    </table>
    <?php } ?>

    <br />

    <table width="100%" border="1" style="border-collapse: collapse;">
        <tbody>
        <tr>
            <td width="55"><b style="text-transform: capitalize;">Total <?php echo $grand_parent_title; ?></b></td>
            <td width="15" style="text-align: right;"><?php echo number_format($over_all_debit,2); ?></td>
            <td width="15" style="text-align: right;"><?php echo number_format($over_all_credit,2); ?></td>
            <td width="15" style="text-align: right;"><?php echo number_format(($account->account_type_id==1||$account->account_type_id==5?$over_all_debit-$over_all_credit:$over_all_credit-$over_all_debit),2); ?></td>
        </tr>
        </tbody>
    </table>



    <script>
        window.print();
    </script>

</html>