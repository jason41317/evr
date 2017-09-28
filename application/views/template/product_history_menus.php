
<br />
<div class="row" id="div_product_history_menu" style="margin-left: 2px;">


    <div class="col-lg-2">


        <div class="input-group">
            <input type="text" class="date-start form-control date-picker" value="<?php echo date('m'); ?>/1/<?php echo date('Y'); ?>" />
             <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
        </div>
    </div>
    <div class="col-lg-2">
        <div class="input-group">
            <input type="text" class="date-end form-control date-picker" value="<?php echo date('m/d/Y'); ?>"/>
            <span class="input-group-addon">
                                     <i class="fa fa-calendar"></i>
                                </span>
        </div>

    </div>

    <div class="col-lg-3 col-lg-offset-5">
        <div class="title-action pull-right" style="margin-right: 1%;">

            <button class="btn-export btn btn-success" data-product-id="<?php echo $product_id; ?>"><i class="fa fa-file-excel-o"></i> Export Product History to Excel </button>
        </div>
    </div>

</div>

