<?php

class Banks_model extends CORE_Model {
    protected  $table="banks";
    protected  $pk_id="bank_id";

    function __construct() {
        parent::__construct();
    }

    function get_bank_list($bank_id=null) {
        $sql="SELECT
              banks.*,
              account.account_title
            FROM banks
            LEFT JOIN account_titles account ON account.account_id = banks.account_id
            WHERE
                banks.is_deleted=FALSE AND banks.is_active=TRUE
            	".($bank_id==null?"":" AND banks.bank_id=$bank_id")."";
        return $this->db->query($sql)->result();
    }
}
?>