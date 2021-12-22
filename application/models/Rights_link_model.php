<?php

class Rights_link_model extends CORE_Model{

    protected  $table="rights_links"; //table name
    protected  $pk_id="link_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }


    function create_default_link_list(){
        $sql="INSERT INTO `rights_links` (`link_id`, `parent_code`, `link_code`, `link_name`) VALUES
                                          -- Financing
                                          (1,'1','1-1','General Journal'),
                                          (2,'1','1-2','Cash Disbursement'),
                                          (3,'1','1-3','Purchase Journal'),
                                          (4,'1','1-4','Sales Journal'),
                                          (5,'1','1-5','Cash Receipt'),

                                          -- Purchasing
                                          (6,'2','2-1','Purchase Order'),
                                          (7,'2','2-2','Purchase Invoice'),
                                          (8,'2','2-3','Record Payment'),

                                          -- Sales
                                          (9,'3','3-1','Sales Order'),
                                          (10,'3','3-2','Sales Invoice'),
                                          (11,'3','3-3','Collection Entry'),

                                          -- References
                                          (12,'4','4-1','Category Management'),
                                          (13,'4','4-2','Department Management'),
                                          (14,'4','4-3','Unit Management'),

                                          -- Masterfiles
                                          (15,'5','5-1','Product Management'),
                                          (16,'5','5-2','Supplier Management'),
                                          (17,'5','5-3','Customer Management'),

                                          -- Settings
                                          (18,'6','6-1','Setup Tax'),
                                          (19,'6','6-2','Setup Chart of Accounts'),
                                          (20,'6','6-3','Account Integration'),
                                          (21,'6','6-4','Setup User Group'),
                                          (22,'6','6-5','Create User Account'),
                                          (23,'6','6-6','Setup Company Info'),
                                          -- (26,'7','7-1','Purchase Order for Approval'),

                                          -- Accounting Reports
                                          (24,'9','9-1','Balance Sheet Report'),
                                          (25,'9','9-2','Income Statement'),

                                          -- References
                                          (26,'4','4-4','Product Types'),

                                          -- Sales & Purchasing Report
                                          (27,'8','8-1','Sales Report'),
                                          (28,'8','8-2','Batch Inventory Report'),

                                          -- Masterfiles
                                          (29,'5','5-4','Salesperson Management'),

                                          -- Sales & Purchasing Report
                                          (30,'8','8-3','Export Sales Summary'),

                                          -- Accounting Reports
                                          (31,'9','9-3','Export Trial Balance'),

                                          -- Settings
                                          (32,'6','6-7','Setup Check Layout'),

                                          -- Accounting Reports 
                                          (33,'9','9-4','AR Schedule'),
                                          (34,'9','9-6','Customer Subsidiary'),
                                          (35,'9','9-8','Account Subsidiary'),
                                          (36,'9','9-7','Supplier Subsidiary'),
                                          (37,'9','9-5','AP Schedule'),

                                          -- Sales & Purchasing Report
                                          (38,'8','8-4','Purchase Invoice Report'),
                                          (39,'8','8-5','Cost of Goods Sold'),

                                          -- Settings
                                          (40,'6','6-8','Create Recurring Journal Template'),

                                          -- Accounting Reports
                                          (41,'9','9-10','Schedule of Expense'),

                                          -- Settings
                                          (42,'6','6-9','Backup Database'),

                                          -- Sales & Purchasing Report
                                          (43,'8','8-6','Stock Card'),
                                          (44,'8','8-7','Sales Return Report'),

                                          -- Sales
                                          (45,'3','3-4','Other Sales Invoice'),

                                          -- Sales & Purchasing Report
                                          (46,'8','8-8','Product Inventory Report'),
                                          (47,'8','8-9','Open Purchases Report'),
                                          (48,'8','8-10','Open Sales Report'),

                                          -- Purchase Order Buttons
                                          (49,'20','20-1','Purchase Order Add'),
                                          (50,'20','20-2','Purchase Order Edit'),
                                          (51,'20','20-3','Purchase Order Delete'),
                                          (52,'20','20-4','Purchase Order Message'),

                                          -- Purchase Invoice Buttons
                                          (53,'21','21-1','Purchase Invoice Add'),
                                          (54,'21','21-2','Purchase Invoice Edit'),
                                          (55,'21','21-3','Purchase Invoice Delete'),

                                          -- Item Issuance Buttons
                                          (56,'22','22-1','Item Issuance Add'),
                                          (57,'22','22-2','Item Issuance Edit'),
                                          (58,'22','22-3','Item Issuance Delete'),

                                          -- Item Adjsutment Buttons
                                          (59,'23','23-1','Item Adjustment Add'),
                                          (60,'23','23-2','Item Adjustment Edit'),
                                          (61,'23','23-3','Item Adjustment Delete'),

                                          -- Item Adjsutment Out Buttons
                                          (62,'24','24-1','Item Adjustment Out Add'),
                                          (63,'24','24-2','Item Adjustment Out Edit'),
                                          (64,'24','24-3','Item Adjustment Out Delete'),

                                          -- Sales Order Buttons
                                          (65,'25','25-1','Sales Order Add'),
                                          (66,'25','25-2','Sales Order Edit'),
                                          (67,'25','25-3','Sales Order Delete'),
                                          (68,'25','25-4','Sales Order Cancel'),

                                          -- Sales Invoice Buttons
                                          (69,'26','26-1','Sales Invoice Add'),
                                          (70,'26','26-2','Sales Invoice Edit'),
                                          (71,'26','26-3','Sales Invoice Delete'),

                                          -- Other Sales Invoice Buttons
                                          (72,'27','27-1','Other Sales Invoice Add'),
                                          (73,'27','27-2','Other Sales Invoice Edit'),
                                          (74,'27','27-3','Other Sales Invoice Delete'),

                                          -- Purchasing
                                          (75,'2','2-7','Purchase Invoice History'),
                                          -- Sales
                                          (76,'3','3-5','Sales Invoice History'),
                                          -- Purchase Cancel
                                          (77,'20','20-5','Purchase Order Cancel'),
                                          (78,'4','4-5','Account Classification'),
                                          (79,'4','4-6','Bank Management'),
                                          (80,'1','1-6','Petty Cash Journal'),
                                          (81,'1','1-7','Check Summary'),
                                          (82,'9','9-11','T-Accounts'),
                                          (83,'9','9-12','General Ledger'),
                                          (84,'9','9-13','Replenishment Report'),
                                          (85,'9','9-14','Replenishment Batch'),
                                          (86,'10','10-1','Treasury'),
                                          (87,'6','6-10','SOA Settings'),

                                          (88,'11','11-1','Item Transfer'),
                                          (89,'11','11-2','Item Issuance'),
                                          (90,'11','11-3','Item Adjustment (In)'),
                                          (91,'11','11-4','Item Adjustment (Out)'),

                                          (92,'11','11-5','Inventory Report'),
                                          (93,'11','11-6','Batch Inventory Report')


                                          ON DUPLICATE KEY UPDATE

                                          rights_links.parent_code=VALUES(rights_links.parent_code),
                                          rights_links.link_code=VALUES(rights_links.link_code),
                                          rights_links.link_name=VALUES(rights_links.link_name)

            ";



        $this->db->query($sql);
    }



}




?>