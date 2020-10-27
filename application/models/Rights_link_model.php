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
                                          (9,'2','2-4','Item Issuance'),
                                          (10,'2','2-5','Item Adjustment (In)'),

                                          -- Sales
                                          (11,'3','3-1','Sales Order'),
                                          (12,'3','3-2','Sales Invoice'),
                                          (13,'3','3-3','Collection Entry'),

                                          -- References
                                          (14,'4','4-1','Category Management'),
                                          (15,'4','4-2','Department Management'),
                                          (16,'4','4-3','Unit Management'),

                                          -- Masterfiles
                                          (17,'5','5-1','Product Management'),
                                          (18,'5','5-2','Supplier Management'),
                                          (19,'5','5-3','Customer Management'),

                                          -- Settings
                                          (20,'6','6-1','Setup Tax'),
                                          (21,'6','6-2','Setup Chart of Accounts'),
                                          (22,'6','6-3','Account Integration'),
                                          (23,'6','6-4','Setup User Group'),
                                          (24,'6','6-5','Create User Account'),
                                          (25,'6','6-6','Setup Company Info'),
                                          -- (26,'7','7-1','Purchase Order for Approval'),

                                          -- Accounting Reports
                                          (27,'9','9-1','Balance Sheet Report'),
                                          (28,'9','9-2','Income Statement'),

                                          -- References
                                          (29,'4','4-4','Product Types'),

                                          -- Sales & Purchasing Report
                                          (30,'8','8-1','Sales Report'),
                                          (31,'8','8-2','Batch Inventory Report'),

                                          -- Masterfiles
                                          (32,'5','5-4','Salesperson Management'),

                                          -- Purchasing
                                          (33,'2','2-6','Item Adjustment (Out)'),

                                          -- Sales & Purchasing Report
                                          (34,'8','8-3','Export Sales Summary'),

                                          -- Accounting Reports
                                          (35,'9','9-3','Export Trial Balance'),

                                          -- Settings
                                          (36,'6','6-7','Setup Check Layout'),

                                          -- Accounting Reports 
                                          (37,'9','9-4','AR Schedule'),
                                          (38,'9','9-6','Customer Subsidiary'),
                                          (39,'9','9-8','Account Subsidiary'),
                                          (40,'9','9-7','Supplier Subsidiary'),
                                          (41,'9','9-5','AP Schedule'),

                                          -- Sales & Purchasing Report
                                          (42,'8','8-4','Purchase Invoice Report'),
                                          (43,'8','8-5','Cost of Goods Sold'),

                                          -- Settings
                                          (44,'6','6-8','Create Recurring Journal Template'),

                                          -- Accounting Reports
                                          (45,'9','9-10','Schedule of Expense'),

                                          -- Settings
                                          (46,'6','6-9','Backup Database'),

                                          -- Sales & Purchasing Report
                                          (47,'8','8-6','Stock Card'),
                                          (48,'8','8-7','Sales Return Report'),

                                          -- Sales
                                          (49,'3','3-4','Other Sales Invoice'),

                                          -- Sales & Purchasing Report
                                          (50,'8','8-8','Product Inventory Report'),
                                          (51,'8','8-9','Open Purchases Report'),
                                          (52,'8','8-10','Open Sales Report'),

                                          -- Purchase Order Buttons
                                          (53,'20','20-1','Purchase Order Add'),
                                          (54,'20','20-2','Purchase Order Edit'),
                                          (55,'20','20-3','Purchase Order Delete'),
                                          (56,'20','20-4','Purchase Order Message'),

                                          -- Purchase Invoice Buttons
                                          (57,'21','21-1','Purchase Invoice Add'),
                                          (58,'21','21-2','Purchase Invoice Edit'),
                                          (59,'21','21-3','Purchase Invoice Delete'),

                                          -- Item Issuance Buttons
                                          (60,'22','22-1','Item Issuance Add'),
                                          (61,'22','22-2','Item Issuance Edit'),
                                          (62,'22','22-3','Item Issuance Delete'),

                                          -- Item Adjsutment Buttons
                                          (63,'23','23-1','Item Adjustment Add'),
                                          (64,'23','23-2','Item Adjustment Edit'),
                                          (65,'23','23-3','Item Adjustment Delete'),

                                          -- Item Adjsutment Out Buttons
                                          (66,'24','24-1','Item Adjustment Out Add'),
                                          (67,'24','24-2','Item Adjustment Out Edit'),
                                          (68,'24','24-3','Item Adjustment Out Delete'),

                                          -- Sales Order Buttons
                                          (69,'25','25-1','Sales Order Add'),
                                          (70,'25','25-2','Sales Order Edit'),
                                          (71,'25','25-3','Sales Order Delete'),
                                          (72,'25','25-4','Sales Order Cancel'),

                                          -- Sales Invoice Buttons
                                          (73,'26','26-1','Sales Invoice Add'),
                                          (74,'26','26-2','Sales Invoice Edit'),
                                          (75,'26','26-3','Sales Invoice Delete'),

                                          -- Other Sales Invoice Buttons
                                          (76,'27','27-1','Other Sales Invoice Add'),
                                          (77,'27','27-2','Other Sales Invoice Edit'),
                                          (78,'27','27-3','Other Sales Invoice Delete'),

                                          -- Purchasing
                                          (79,'2','2-7','Purchase Invoice History'),

                                          -- Sales
                                          (80,'3','3-5','Sales Invoice History'),

                                          -- Purchase Cancel
                                          (81,'20','20-5','Purchase Order Cancel'),

                                          (82,'4','4-5','Account Classification')


                                          
                                          ON DUPLICATE KEY UPDATE

                                          rights_links.parent_code=VALUES(rights_links.parent_code),
                                          rights_links.link_code=VALUES(rights_links.link_code),
                                          rights_links.link_name=VALUES(rights_links.link_name)

            ";



        $this->db->query($sql);
    }



}




?>