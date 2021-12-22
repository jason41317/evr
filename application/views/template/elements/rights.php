<script type="text/javascript">
	var default_department_id = '<?php echo $this->session->default_department_id; ?>';
	// Purchase Order Buttons
	var po_btn_edit = '<button class="btn btn-primary btn-sm <?php echo (in_array('20-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
	var po_btn_trash = '<button class="btn btn-red btn-sm <?php echo (in_array('20-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
    var po_btn_mark_as_closed='<button class="btn btn-warning btn-sm <?php echo (in_array('20-5',$this->session->user_rights)?'':'hidden'); ?>" name="mark_as_closed" title="Mark as Closed"><i class="fa fa-times"></i> </button>';    

	// Purchase Invoice Buttons
	var pi_btn_edit='<button class="btn btn-primary btn-sm <?php echo (in_array('21-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
   	var pi_btn_trash='<button class="btn btn-red btn-sm <?php echo (in_array('21-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

   	// Item Issuance Buttons
    var issuance_btn_edit='<button class="btn btn-primary btn-sm <?php echo (in_array('22-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
    var issuance_btn_trash='<button class="btn btn-red btn-sm <?php echo (in_array('22-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

    // Item Adjustment Buttons
    var adj_btn_edit='<button class="btn btn-primary btn-sm <?php echo (in_array('23-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
    var adj_btn_trash='<button class="btn btn-red btn-sm <?php echo (in_array('23-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

    // Item Adjustment Out Buttons
	var adjout_btn_edit='<button class="btn btn-primary btn-sm <?php echo (in_array('24-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
	var adjout_btn_trash='<button class="btn btn-red btn-sm <?php echo (in_array('24-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

	// Sales Order Buttons
    var so_btn_edit='<button class="btn btn-primary btn-sm <?php echo (in_array('25-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info" title="Edit"><i class="fa fa-pencil"></i> </button>';
    var so_btn_trash='<button class="btn btn-red btn-sm <?php echo (in_array('25-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';
    var so_btn_mark_as_closed='<button class="btn btn-warning btn-sm <?php echo (in_array('25-4',$this->session->user_rights)?'':'hidden'); ?>" name="mark_as_closed" title="Mark as Closed"><i class="fa fa-times"></i> </button>';

    // Sales Invoice Buttons
    var si_btn_edit='<button class="btn btn-primary btn-sm <?php echo (in_array('26-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info"  style="margin-left:0px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
    var si_btn_trash='<button class="btn btn-red btn-sm <?php echo (in_array('26-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

    // Other Sales Invoice
    var osi_btn_edit='<button class="btn btn-primary btn-sm <?php echo (in_array('27-2',$this->session->user_rights)?'':'hidden'); ?>" name="edit_info"  style="margin-left:-15px;" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil"></i> </button>';
    var osi_btn_trash='<button class="btn btn-red btn-sm <?php echo (in_array('27-3',$this->session->user_rights)?'':'hidden'); ?>" name="remove_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Move to trash"><i class="fa fa-trash-o"></i> </button>';

    var btn_lock = '<button class="btn btn-warning btn-sm <?php echo (in_array('20-3',$this->session->user_rights)?'':'hidden'); ?>" name="unlock_info" style="margin-right:0px;" data-toggle="tooltip" data-placement="top" title="Unlock Transaction"><i class="fa fa-unlock"></i> </button>';    
    
</script>