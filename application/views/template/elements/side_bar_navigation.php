<div class="static-sidebar-wrapper sidebar-default">
    <div class="static-sidebar">
        <div class="sidebar">
            <div class="widget">
                <div class="widget-body">
                    <div class="userinfo">
                        <div class="avatar">
                            <img src="<?php echo $this->session->user_photo; ?>" class="img-responsive img-circle">
                        </div>
                        <div class="info">
                            <span class="username"><?php echo $this->session->user_fullname; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget stay-on-collapse" id="widget-sidebar">
                <nav role="navigation" class="widget-body">
                    <ul class="acc-menu">
                        <li class="nav-separator"><span>Explore</span></li>

                        <li><a href="Dashboard"><i class="ti ti-home"></i><span>Dashboard</span></a></li>
                        <li class="<?php echo (in_array('1',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-wallet"></i><span>Financing</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('1-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="General_journal">General Journal</a></li>
                                <li class="<?php echo (in_array('1-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="Cash_disbursement">Cash Disbursement</a></li>
                                <li class="<?php echo (in_array('1-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="Account_payables">Purchase Journal</a></li>
                                <li class="<?php echo (in_array('1-4',$this->session->user_rights)?'':'hidden'); ?>"><a href="Accounts_receivable">Sales Journal</a></li>
                                <li class="<?php echo (in_array('1-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="Petty_cash_journal">Petty Cash Journal</a></li>
                                <li class="<?php echo (in_array('1-5',$this->session->user_rights)?'':'hidden'); ?>"><a href="Cash_receipt">Cash Receipt</a></li>
                                <li class="<?php echo (in_array('1-7',$this->session->user_rights)?'':'hidden'); ?>"><a href="Check_summary">Check Summary</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo (in_array('2',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-package"></i><span>Purchasing</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('2-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="Purchases">Purchase Order</a></li>
                                <li class="<?php echo (in_array('2-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="Deliveries">Purchase Invoice (Supplier)</a></li>
                                <li class="<?php echo (in_array('2-7',$this->session->user_rights)?'':'hidden'); ?>"><a href="Purchase_invoice_history">Purchase Invoice History</a></li>
                                <li class="<?php echo (in_array('2-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="Payable_payments">Record Payment</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo (in_array('3',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-shopping-cart"></i><span>Sales</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('3-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="Sales_order">Sales Order</a></li>
                                <li class="<?php echo (in_array('3-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="Picklist">Picklist</a></li>
                                <li class="<?php echo (in_array('3-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="Sales_invoice">Sales Invoice</a></li>
                                <li class="<?php echo (in_array('3-4',$this->session->user_rights)?'':'hidden'); ?>""><a href="Sales_invoice_other">Other Sales Invoice</a></li>
                                <li class="<?php echo (in_array('3-5',$this->session->user_rights)?'':'hidden'); ?>"><a href="Sales_invoice_history">Sales Invoice History</a></li>
                                <li class="<?php echo (in_array('3-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="Receivable_payments">Collection Entry</a></li>
                                <!-- <li><a href="AR_Receivable">AR Receivable Report</a></li> -->
                            </ul>
                        </li>
                        
                        <li class="<?php echo (in_array('11',$this->session->parent_rights)?'':'hidden'); ?>">
                            <a href="#">
                                <i class="fa fa-cube"></i><span>Inventory</span>
                            </a>
                            <ul class="acc-menu">
                                <li  class="<?php echo (in_array('11-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="Issuance_department">Item Transfer</a></li>
                                <li  class="<?php echo (in_array('11-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="Issuances">Item Issuance</a></li>
                                <li  class="<?php echo (in_array('11-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="Adjustments">Item Adjustment (In)</a></li>
                                <li  class="<?php echo (in_array('11-4',$this->session->user_rights)?'':'hidden'); ?>"><a href="Adjustment_out">Item Adjustment (Out)</a></li>
                                <li class="<?php echo (in_array('11-5',$this->session->user_rights)?'':'hidden'); ?>"><a href="Inventory_report">Inventory Report</a></li>
                                <li class="<?php echo (in_array('11-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="Batch_inventory">Batch Inventory</a></li>
                                <li class="<?php echo (in_array('8-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="Stock_card">Stock Card</a></li>

                            </ul>
                        </li>

                        <li class="<?php echo (in_array('4',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-view-list-alt"></i><span>References</span></a>
                            <ul class="acc-menu">
                                <li  class="<?php echo (in_array('4-5',$this->session->user_rights)?'':'hidden'); ?>"><a href="Account_classes">Account Classification</a></li>
                                <li  class="<?php echo (in_array('4-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="categories">Category Management</a></li>
                                <li  class="<?php echo (in_array('4-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="departments">Branch Management</a></li>
                                <li  class="<?php echo (in_array('4-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="banks">Bank Management</a></li>
                                <li  class="<?php echo (in_array('4-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="units">Unit Management</a></li>
                                <li  class="<?php echo (in_array('4-4',$this->session->user_rights)?'':'hidden'); ?>"><a href="Refproducts">Product Types</a></li>
                                <!--<li><a href="brands">Brand Management</a></li>
                                <li><a href="discounts">Discount Management</a></li>
                                <li><a href="cards">Card Management</a></li>
                                <li><a href="generics">Generic Management</a></li>
                                <li><a href="giftcards">Gift Card Management</a></li>
                                <li><a href="locations">Location Management</a></li>-->
                            </ul>
                        </li>

                        <li class="<?php echo (in_array('5',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-harddrive"></i><span>Masterfiles</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('5-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="products">Product Management</a></li>
                                <li class="<?php echo (in_array('5-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="suppliers">Supplier Management</a></li>
                                <li class="<?php echo (in_array('5-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="customers">Customer Management</a></li>
                                <li class="<?php echo (in_array('5-4',$this->session->user_rights)?'':'hidden'); ?>"><a href="Salesperson">Salesperson Management</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo (in_array('10',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#/"><i class="ti ti-view-list-alt"></i><span>Treasury</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('10-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="Treasury">Treasury</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo (in_array('6',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-settings"></i><span>Settings</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('6-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="Tax">Setup Tax</a></li>
                                <li class="<?php echo (in_array('6-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="Account_titles">Setup Chart of Accounts</a></li>
                                <li class="<?php echo (in_array('6-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="Account_integration">General Configuration</a></li>
                                <li class="<?php echo (in_array('6-10',$this->session->user_rights)?'':'hidden'); ?>"><a href="Soa_settings">SOA Settings</a></li>
                                <li class="<?php echo ($this->session->user_group_id != 1 ? 'hidden' : '' ); ?>"><a href="Transaction_lock">Transaction Lock</a></li>
                                <li class="<?php echo ($this->session->user_group_id != 1 ? 'hidden' : '' ); ?>"><a href="Audit_trail">Audit Trail</a></li>
                                <li class="<?php echo (in_array('6-4',$this->session->user_rights)?'':'hidden'); ?>"><a href="User_groups">Setup User Rights</a></li>
                                <li class="<?php echo (in_array('6-5',$this->session->user_rights)?'':'hidden'); ?>"><a href="users">Create User Account</a></li>
                                <li class="<?php echo (in_array('6-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="company">Setup Company Info</a></li>
                                <li class="<?php echo (in_array('6-7',$this->session->user_rights)?'':'hidden'); ?>"><a href="Check_layout">Setup Check Layout</a></li>
                                <li class="<?php echo (in_array('6-8',$this->session->user_rights)?'':'hidden'); ?>"><a href="Recurring_template">Recurring Template</a></li>
                                <li class="<?php echo (in_array('6-9',$this->session->user_rights)?'':'hidden'); ?>"><a href="DBBackup">Backup Database</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo (in_array('9',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-bar-chart"></i><span>Accounting Reports</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('9-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="Balance_sheet">Balance Sheet</a></li>
                                <li class="<?php echo (in_array('9-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="Income_statement">Income Statement</a></li>
                                <li class="<?php echo (in_array('9-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="Trial_balance">Trial Balance</a></li>
                                <li class="<?php echo (in_array('9-4',$this->session->user_rights)?'':'hidden'); ?>"><a href="Account_receivable_schedule">AR Schedule</a></li>
                                <li class="<?php echo (in_array('9-5',$this->session->user_rights)?'':'hidden'); ?>"><a href="Account_payable_schedule">AP Schedule</a></li>
                                <li class="<?php echo (in_array('9-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="Customer_Subsidiary">Customer Subsidiary</a></li>
                                <li class="<?php echo (in_array('9-7',$this->session->user_rights)?'':'hidden'); ?>"><a href="Supplier_Subsidiary">Supplier Subsidiary</a></li>
                                <li class="<?php echo (in_array('9-8',$this->session->user_rights)?'':'hidden'); ?>"><a href="Account_Subsidiary">Account Subsidiary</a></li>
                                <li class="<?php echo (in_array('9-10',$this->session->user_rights)?'':'hidden'); ?>"><a href="Schedule_expense">Schedule of Expense</a></li>
                                <li class="<?php echo (in_array('9-11',$this->session->user_rights)?'':'hidden'); ?>"><a href="TAccount">T-Accounts</a></li>
                                <li class="<?php echo (in_array('9-12',$this->session->user_rights)?'':'hidden'); ?>"><a href="General_ledger">General Ledger</a></li>
                                <li class="<?php echo (in_array('9-13',$this->session->user_rights)?'':'hidden'); ?>"><a href="Replenishment_report">Replenishment Report</a></li>
                                <li class="<?php echo (in_array('9-14',$this->session->user_rights)?'':'hidden'); ?>"><a href="Replenishment_batch">Replenishment Batch</a></li>
                            </ul>
                        </li>

                        <li class="<?php echo (in_array('8',$this->session->parent_rights)?'':'hidden'); ?>"><a href="#"><i class="ti ti-pie-chart"></i><span>Sales &amp; Purchasing</span></a>
                            <ul class="acc-menu">
                                <li class="<?php echo (in_array('8-5',$this->session->user_rights)?'':'hidden'); ?>"><a href="Cogs">Cost of Goods Sold</a></li>
                                <li class="<?php echo (in_array('8-1',$this->session->user_rights)?'':'hidden'); ?>"><a href="Sales_detailed_summary">Sales Report</a></li>
                                <li class="<?php echo (in_array('8-7',$this->session->user_rights)?'':'hidden'); ?>"><a href="Sales_returns_report">Sales Returns</a></li>
                                <li class="<?php echo (in_array('8-8',$this->session->user_rights)?'':'hidden'); ?>"><a href="Product_list">Product Inventory Report</a></li>
                                <li class="<?php echo (in_array('8-2',$this->session->user_rights)?'':'hidden'); ?>"><a href="Inventory">Batch Inventory Report</a></li>
                                <li class="<?php echo (in_array('8-6',$this->session->user_rights)?'':'hidden'); ?>"><a href="Stock_card">Stock Card</a></li>
                                <li class="<?php echo (in_array('8-3',$this->session->user_rights)?'':'hidden'); ?>"><a href="Sales_summary">Sales Summary</a></li>
                                <li class="<?php echo (in_array('8-4',$this->session->user_rights)?'':'hidden'); ?>"><a href="Purchase_Invoice_Report">Purchase Invoice Report</a></li>
                                <li class="<?php echo (in_array('8-9',$this->session->user_rights)?'':'hidden'); ?>"><a href="Open_purchases">Open Purchases Report</a></li>
                                <li class="<?php echo (in_array('8-10',$this->session->user_rights)?'':'hidden'); ?>"><a href="Open_sales">Open Sales Report</a></li>
                            </ul>
                        </li>


                    </ul>
                </nav>
            </div>

         

            <!--<div class="widget" id="widget-progress">
                <div class="widget-heading">
                    Progress
                </div>
                <div class="widget-body">

                    <div class="mini-progressbar">
                        <div class="clearfix mb-sm">
                            <div class="pull-left">Bandwidth</div>
                            <div class="pull-right">50%</div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-lime" style="width: 50%"></div>
                        </div>
                    </div>
                    <div class="mini-progressbar">
                        <div class="clearfix mb-sm">
                            <div class="pull-left">Storage</div>
                            <div class="pull-right">25%</div>
                        </div>

                        <div class="progress">
                            <div class="progress-bar progress-bar-info" style="width: 25%"></div>
                        </div>
                    </div>

                </div>
            </div>-->
        </div>
    </div>
</div>