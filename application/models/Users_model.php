<?php

class Users_model extends CORE_Model{

    protected  $table="user_accounts"; //table name
    protected  $pk_id="user_id"; //primary key id


    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create_default_user(){

        //return;
        $sql="INSERT IGNORE INTO user_accounts
                  (user_id,user_name,user_pword,user_lname,user_fname,user_mname,user_address,user_email,user_mobile,user_group_id)
              VALUES
                  (1,'admin',SHA1('admin'),'Administrator','System','','Balibago, Angeles City','jdevtechsolution@gmail.com','0955-283-3018',1)
        ";
        $this->db->query($sql);

    }

    function authenticate_user($uname,$pword){
        $this->db->select('ua.user_id,ua.user_name,ua.user_group_id,ua.department_id,ua.photo_path,ua.user_email,CONCAT_WS(" ",ua.user_fname,ua.user_mname,ua.user_lname) as user_fullname');
        $this->db->from('user_accounts as ua');
        $this->db->join('user_groups as ug', 'ua.user_group_id = ug.user_group_id','left');
        $this->db->where('ua.is_deleted', FALSE);
        $this->db->where('ua.user_name', $uname);
        $this->db->where('ua.user_pword', sha1($pword));
        return $this->db->get();

    }


    function get_user_invoice_counter(){
        $sql="SELECT ua.user_id,
                CONCAT_WS(' ',ua.user_fname,ua.user_lname) as user_fullname,
                ug.user_group,

                IFNULL(ic.counter_start,0)as counter_start,
                IFNULL(ic.counter_end,0)as counter_end,
                IFNULL(ic.last_invoice,0) as last_invoice

                FROM user_accounts as ua
                LEFT JOIN user_groups as ug ON ua.user_group_id=ug.user_group_id
                LEFT JOIN invoice_counter as ic ON ua.user_id=ic.user_id";

        return $this->db->query($sql)->result();


    }



    function get_user_list($id=null){

        $this->db->select('ua.user_id,ua.user_name,ua.user_lname,ua.user_fname,ua.user_mname,ua.photo_path,ua.department_id');
        $this->db->select('ua.user_address,ua.user_email,ua.user_mobile,ua.user_telephone,d.department_name');
        $this->db->select('DATE_FORMAT(ua.user_bdate,"%m/%d/%Y")as user_bdate,ua.user_group_id');
        $this->db->select('ua.is_active,ug.user_group,CONCAT_WS(" ",ua.user_fname,ua.user_mname,ua.user_lname)as full_name');
        $this->db->from('user_accounts as ua');
        $this->db->join('user_groups as ug', 'ua.user_group_id = ug.user_group_id','left');
        $this->db->join('departments as d', 'd.department_id = ua.department_id','left');
        $this->db->where('ua.is_active=', 1);
        $this->db->where('ua.is_deleted=', 0);

        if($id!=null){ $this->db->where('ua.user_id=', $id); }

        return $this->db->get()->result();
    }

    function get_user_list_audit_trail($id=null){

        $this->db->select('ua.user_id,ua.user_name,ua.user_lname,ua.user_fname,ua.user_mname,ua.photo_path');
        $this->db->select('ua.user_address,ua.user_email,ua.user_mobile,ua.user_telephone');
        $this->db->select('DATE_FORMAT(ua.user_bdate,"%m/%d/%Y")as user_bdate,ua.user_group_id');
        $this->db->select('ua.is_active,ug.user_group,CONCAT_WS(" ",ua.user_fname,ua.user_mname,ua.user_lname)as full_name');
        $this->db->from('user_accounts as ua');
        $this->db->join('user_groups as ug', 'ua.user_group_id = ug.user_group_id','left');
        $this->db->where('ua.user_id!=', 1);
        $this->db->where('ua.user_id!=', 12);
        $this->db->order_by('ua.user_fname', 'asc');

        if($id!=null){ $this->db->where('ua.user_id=', $id); }

        return $this->db->get()->result();
    }    

function get_newsfeed_revised($startDate,$endDate,$trans_type_id=null,$trans_key_id=null,$user_id=null) {
        $sql = "SELECT
                
                IFNULL(CONCAT(ua.user_name,' - ',ua.user_fname,' ', ua.user_lname),'Unidentified User') as username,
                t.*,
                tk.trans_key_desc,tt.trans_type_desc,
                DATE_FORMAT(t.date, '%m/%d/%Y  %r') as date_time
                FROM
                (SELECT
                po.posted_by_user user_id,
                1 as trans_key_id,
                11 as trans_type_id,
                concat('Created Purchase Order # ',po.po_no) message,
                po.date_created date
                FROM
                purchase_order po
                WHERE CAST(po.date_created as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                po.modified_by_user user_id,                
                2 as trans_key_id,
                11 as trans_type_id,
                concat('Modified Purchase Order # ',po.po_no) message,
                po.date_modified date
                FROM
                purchase_order po
                WHERE CAST(po.date_modified as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                po.deleted_by_user user_id,    
                3 as trans_key_id,
                11 as trans_type_id,
                concat('Deleted Purchase Order # ',po.po_no) message,
                po.date_deleted date
                FROM
                purchase_order po
                WHERE CAST(po.date_deleted as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                po.approved_by_user user_id,
                8 as trans_key_id,
                11 as trans_type_id,
                concat('Approved Purchase Order #',po.po_no) message,
                po.date_approved date
                FROM
                purchase_order po
                WHERE CAST(po.date_approved as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                di.posted_by_user user_id,                
                1 as trans_key_id,
                12 as trans_type_id,
                concat('Created Delivery Invoice # ', di.dr_invoice_no) message,
                di.date_created date
                FROM
                delivery_invoice di
                WHERE CAST(di.date_created as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                di.modified_by_user user_id,                
                2 as trans_key_id,
                12 as trans_type_id,
                concat('Modified Delivery Invoice # ', di.dr_invoice_no) message,
                di.date_modified date
                FROM
                delivery_invoice di
                WHERE CAST(di.date_modified as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                di.deleted_by_user user_id,                
                3 as trans_key_id,
                12 as trans_type_id,
                concat('Deleted Delivery Invoice # ', di.dr_invoice_no) message,
                di.date_deleted date
                FROM
                delivery_invoice di
                WHERE CAST(di.date_deleted as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                so.posted_by_user user_id,                
                1 as trans_key_id,
                16 as trans_type_id,
                concat('Created Sales Order # ', so.so_no) message,
                so.date_created date
                FROM
                sales_order so
                WHERE CAST(so.date_created as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                so.modified_by_user user_id,
                3 as trans_key_id,
                16 as trans_type_id,
                concat('Modified Sales Order # ', so.so_no) message,
                so.date_modified date
                FROM
                sales_order so
                WHERE CAST(so.date_modified as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                so.deleted_by_user user_id,
                3 as trans_key_id,
                16 as trans_type_id,                
                concat('Deleted Sales Order # ', so.so_no) message,
                so.date_deleted date
                FROM
                sales_order so
                WHERE CAST(so.date_deleted as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                si.posted_by_user user_id,                
                1 as trans_key_id,
                17 as trans_type_id,
                concat('Created Sales Invoice # ', si.sales_inv_no) message,
                si.date_created date
                FROM
                sales_invoice si
                WHERE CAST(si.date_created as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                si.modified_by_user user_id,                
                2 as trans_key_id,
                17 as trans_type_id,
                concat('Modified Sales Invoice # ', si.sales_inv_no) message,
                si.date_modified date
                FROM
                sales_invoice si
                WHERE CAST(si.date_modified as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                si.deleted_by_user user_id,                
                3 as trans_key_id,
                17 as trans_type_id,
                concat('Deleted Sales Invoice # ', si.sales_inv_no) message,
                si.date_deleted date
                FROM
                sales_invoice si
                WHERE CAST(si.date_deleted as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION

                SELECT
                ai.posted_by_user user_id,
                1 as trans_key_id,
                15 as trans_type_id,
                concat('Created Adjustment # ',ai.adjustment_code) message,
                ai.date_created date
                FROM
                adjustment_info ai
                WHERE CAST(ai.date_created as DATE) BETWEEN '$startDate' AND '$endDate'
                
                UNION
                
                SELECT
                ai.modified_by_user user_id,
                2 as trans_key_id,
                15 as trans_type_id,
                concat('Modified Adjustment # ',ai.adjustment_code) message,
                ai.date_modified date
                FROM
                adjustment_info ai
                WHERE CAST(ai.date_modified as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION 
                
                SELECT
                ai.deleted_by_user user_id,
                3 as trans_key_id,
                15 as trans_type_id,
                concat('Deleted Adjustment # ',ai.adjustment_code) message,
                ai.date_deleted date
                FROM
                adjustment_info ai   
                WHERE CAST(ai.date_deleted as DATE) BETWEEN '$startDate' AND '$endDate'             
                
                UNION

                SELECT
                p.created_by_user user_id,
                1 as trans_key_id,
                50 as trans_type_id,
                concat('Created Product ',p.product_desc) message,
                p.date_created date
                FROM
                products p
                WHERE CAST(p.date_created as DATE) BETWEEN '$startDate' AND '$endDate' 
                
                UNION
                
                SELECT
                p.modified_by_user user_id,
                2 as trans_key_id,
                50 as trans_type_id,
                concat('Modified Product',p.product_desc) message,
                p.date_modified date
                FROM
                products p
                WHERE CAST(p.date_modified as DATE) BETWEEN '$startDate' AND '$endDate' 

                UNION 
                
                SELECT
                p.deleted_by_user user_id,
                3 as trans_key_id,
                50 as trans_type_id,
                concat('Deleted Product ',p.product_desc) message,
                p.date_deleted date
                FROM
                products p
                WHERE CAST(p.date_deleted as DATE) BETWEEN '$startDate' AND '$endDate' 


                UNION

                SELECT
                c.posted_by_user user_id,
                1 as trans_key_id,
                52 as trans_type_id,
                concat('Created Customer ',c.customer_name) message,
                c.date_created date
                FROM
                customers c
                WHERE CAST(c.date_created as DATE) BETWEEN '$startDate' AND '$endDate' 
                
                UNION
                
                SELECT
                c.modified_by_user user_id,
                2 as trans_key_id,
                52 as trans_type_id,
                concat('Modified Customer ',c.customer_name) message,
                c.date_modified date
                FROM
                customers c
                WHERE CAST(c.date_modified as DATE) BETWEEN '$startDate' AND '$endDate' 
                
                UNION 
                
                SELECT
                c.deleted_by_user user_id,
                3 as trans_key_id,
                52 as trans_type_id,
                concat('Deleted Customer ',c.customer_name) message,
                c.date_deleted date 
                
                FROM
                customers c
                WHERE CAST(c.date_deleted  as DATE) BETWEEN '$startDate' AND '$endDate'


                UNION 


                SELECT
                ua.posted_by_user user_id,
                1 as trans_key_id,
                43 as trans_type_id,
                concat('Created User ',ua.user_fname, ' ', ua.user_lname) message,
                ua.date_created date
                FROM
                user_accounts ua
                WHERE CAST(ua.date_created  as DATE) BETWEEN '$startDate' AND '$endDate'
                
                UNION
                
                SELECT
                ua.modified_by_user user_id,
                2 as trans_key_id,
                43 as trans_type_id,
                concat('Modified User ',ua.user_fname, ' ', ua.user_lname) message,
                ua.date_modified date
                FROM
                user_accounts ua
                WHERE CAST(ua.date_modified  as DATE) BETWEEN '$startDate' AND '$endDate'
            
                UNION 
                
                SELECT
                ua.deleted_by_user user_id,
                3 as trans_key_id,
                43 as trans_type_id,
                concat('Deleted User ',ua.user_fname, ' ', ua.user_lname) message,
                ua.date_deleted date
                
                FROM
                user_accounts ua
                WHERE CAST(ua.date_deleted  as DATE) BETWEEN '$startDate' AND '$endDate'

                UNION
                
                SELECT
                trans.user_id,
                trans.trans_key_id,
                trans.trans_type_id,
                trans.trans_log as message,
                trans.trans_date as date
                FROM
                trans
                WHERE CAST(trans.trans_date  as DATE) BETWEEN '$startDate' AND '$endDate'

                ) as t
                LEFT JOIN user_accounts ua ON ua.user_id = t.user_id
                LEFT JOIN trans_key tk ON tk.trans_key_id = t.trans_key_id
                LEFT JOIN trans_type tt ON tt.trans_type_id = t.trans_type_id

                WHERE t.user_id != 0 AND t.user_id != 1
                ".($trans_type_id==null?"":" AND t.trans_type_id = '$trans_type_id' ")."
                ".($trans_key_id==null?"":" AND t.trans_key_id = '$trans_key_id' ")."
                ".($user_id==null?"":" AND t.user_id = '$user_id' ")."
                ORDER BY t.date DESC 
                ";

                return $this->db->query($sql)->result();
    }

function get_newsfeed() {
        $sql = "SELECT
                m.*,
                (
                    CASE
                        WHEN m.DaysPosted>0 THEN CONCAT(m.DaysPosted,' day(s) ago')
                        WHEN m.DaysPosted=0 AND m.HoursPosted>0 THEN CONCAT(m.HoursPosted,' hour(s) ago')
                        WHEN m.DaysPosted=0 AND m.HoursPosted=0 AND m.MinutePosted>0 THEN CONCAT(m.MinutePosted,' min(s) ago')
                        WHEN m.DaysPosted=0 AND m.HoursPosted=0 AND m.MinutePosted=0 AND m.SecondPosted>0 THEN CONCAT(m.SecondPosted,' second(s) ago')
                    ELSE
                        '1 sec ago'
                    END
                ) AS time_description
                FROM
                (SELECT
                IFNULL(ua.photo_path,'assets/img/default-user-image.png') photo_path,
                IFNULL(CONCAT(ua.user_fname,' ', ua.user_lname),'Unidentified User') as username,
                t.*,
                TIME_FORMAT(t.date,'%r') as TimePosted,
                DATEDIFF(NOW(),t.date) AS DaysPosted,
                HOUR(TIMEDIFF(t.date,NOW())) AS HoursPosted,
                MINUTE(TIMEDIFF(t.date,NOW())) AS MinutePosted,
                SECOND(TIMEDIFF(t.date,NOW())) AS SecondPosted
                FROM
                (SELECT
                po.posted_by_user user_id,
                concat('posted PO # ',po.po_no) message,
                po.date_created date
                FROM
                purchase_order po
                WHERE po.is_deleted=FALSE AND po.is_active=TRUE

                UNION

                SELECT
                po.modified_by_user user_id,
                concat('modified PO # ',po.po_no) message,
                po.date_modified date
                FROM
                purchase_order po
                WHERE po.is_deleted=FALSE AND po.is_active=TRUE

                UNION

                SELECT
                po.deleted_by_user user_id,
                concat('deleted PO # ',po.po_no) message,
                po.date_deleted date
                FROM
                purchase_order po
                WHERE po.is_deleted = TRUE

                UNION

                SELECT
                po.approved_by_user user_id,
                concat('approved PO #',po.po_no) message,
                po.date_approved date
                FROM
                purchase_order po
                WHERE po.is_deleted=FALSE AND po.is_active=TRUE

                UNION

                SELECT
                di.posted_by_user user_id,
                concat('posted Delivery inv # ', di.dr_invoice_no) message,
                di.date_created date
                FROM
                delivery_invoice di
                WHERE di.is_deleted=FALSE AND di.is_active=TRUE

                UNION

                SELECT
                di.modified_by_user user_id,
                concat('modified Delivery inv # ', di.dr_invoice_no) message,
                di.date_modified date
                FROM
                delivery_invoice di
                WHERE di.is_deleted=FALSE AND di.is_active=TRUE

                UNION

                SELECT
                di.deleted_by_user user_id,
                concat('deleted Delivery inv # ', di.dr_invoice_no) message,
                di.date_deleted date
                FROM
                delivery_invoice di

                UNION

                SELECT
                so.posted_by_user user_id,
                concat('posted SO # ', so.so_no) message,
                so.date_created date
                FROM
                sales_order so
                WHERE so.is_deleted=FALSE AND so.is_active=TRUE

                UNION

                SELECT
                so.modified_by_user user_id,
                concat('modified SO # ', so.so_no) message,
                so.date_modified date
                FROM
                sales_order so
                WHERE so.is_deleted=FALSE AND so.is_active=TRUE

                UNION

                SELECT
                so.deleted_by_user user_id,
                concat('deleted SO # ', so.so_no) message,
                so.date_deleted date
                FROM
                sales_order so
                WHERE so.is_deleted = TRUE

                UNION

                SELECT
                si.posted_by_user user_id,
                concat('posted Sales inv # ', si.sales_inv_no) message,
                si.date_created date
                FROM
                sales_invoice si
                WHERE si.is_deleted=FALSE AND si.is_active=TRUE

                UNION

                SELECT
                si.modified_by_user user_id,
                concat('modified Sales inv # ', si.sales_inv_no) message,
                si.date_modified date
                FROM
                sales_invoice si
                WHERE si.is_deleted=FALSE AND si.is_active=TRUE

                UNION

                SELECT
                si.deleted_by_user user_id,
                concat('deleted Sales inv # ', si.sales_inv_no) message,
                si.date_deleted date
                FROM
                sales_invoice si
                WHERE si.is_deleted=TRUE

                UNION

                SELECT
                rp.created_by_user user_id,
                concat('posted receipt no. ', rp.receipt_no, ' paid by ', c.customer_name, ' paid on ', rp.date_paid) message,
                rp.date_created date
                FROM
                receivable_payments rp
                INNER JOIN customers c on c.customer_id = rp.customer_id
                WHERE rp.is_deleted=FALSE AND rp.is_active=TRUE

                UNION

                SELECT
                rp.cancelled_by_user user_id,
                concat('cancelled receipt no. ', rp.receipt_no, ' paid by ', c.customer_name, ' paid on ', rp.date_paid) message,
                rp.date_cancelled date
                FROM
                receivable_payments rp
                INNER JOIN customers c on c.customer_id = rp.customer_id
                WHERE rp.is_active=FALSE

                UNION

                SELECT
                pp.created_by_user user_id,
                concat('posted receipt no. ', pp.receipt_no, ' paid by ', s.supplier_name, ' paid on ', pp.date_paid) message,
                pp.date_created date
                FROM
                payable_payments pp
                INNER JOIN suppliers s on s.supplier_id = pp.supplier_id
                WHERE pp.is_deleted=FALSE AND pp.is_active=TRUE

                UNION

                SELECT
                pp.cancelled_by_user user_id,
                concat('cancelled receipt no. ', pp.receipt_no, ' paid by ', s.supplier_name, ' paid on ', pp.date_paid) message,
                pp.date_cancelled date
                FROM
                payable_payments pp
                INNER JOIN suppliers s on s.supplier_id = pp.supplier_id
                WHERE pp.is_active=FALSE

                UNION

                SELECT
                ji.created_by_user user_id,
                ( CASE WHEN book_type = 'CDJ' 
                    THEN CONCAT('posted Txn # ', ji.txn_no, ' on Cash Disbursement Journal')
                  WHEN book_type = 'PCJ'
                    THEN CONCAT('posted Txn # ', ji.txn_no,' on Petty Cash Voucher')
                  WHEN book_type = 'GJE'
                    THEN CONCAT('posted Txn #', ji.txn_no,' on General Journal Entry')
                  WHEN book_type = 'PJE'
                    THEN CONCAT('posted Txn # ', ji.txn_no,' on Purchase Journal Entry')
                  WHEN book_type = 'SJE'
                    THEN CONCAT('posted Txn # ', ji.txn_no,' on Sales Journal Entry')
                  WHEN book_type = 'CRJ'
                    THEN CONCAT('posted Txn # ', ji.txn_no,' on Cash Receipt Journal')
                  END
                ) as message,
                ji.date_created date
                FROM
                journal_info ji
                WHERE ji.is_deleted=FALSE AND ji.is_active=TRUE

                UNION

                SELECT
                ji.created_by_user user_id,
                ( CASE WHEN book_type = 'CDJ' 
                    THEN CONCAT('cancelled Txn # ', ji.txn_no, ' on Cash Disbursement Journal')
                  WHEN book_type = 'PCJ'
                    THEN CONCAT('cancelled Txn # ', ji.txn_no,' on Petty Cash Voucher')
                  WHEN book_type = 'GJE'
                    THEN CONCAT('cancelled Txn #', ji.txn_no,' on General Journal Entry')
                  WHEN book_type = 'PJE'
                    THEN CONCAT('cancelled Txn # ', ji.txn_no,' on Purchase Journal Entry')
                  WHEN book_type = 'SJE'
                    THEN CONCAT('cancelled Txn # ', ji.txn_no,' on Sales Journal Entry')
                  WHEN book_type = 'CRJ'
                    THEN CONCAT('cancelled Txn # ', ji.txn_no,' on Cash Receipt Journal')
                  END
                ) as message,
                ji.date_cancelled date
                FROM
                journal_info ji
                WHERE ji.is_deleted=TRUE OR ji.is_active=FALSE) as t
                LEFT JOIN user_accounts ua ON ua.user_id = t.user_id
                ORDER BY t.date DESC LIMIT 30) AS m
                ";

                return $this->db->query($sql)->result();
    }



}




?>