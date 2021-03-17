<?php

class Receipt_types_model extends CORE_Model{

    protected  $table="receipt_types"; //table name
    protected  $pk_id="receipt_type_id"; //primary key id

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

}

?>