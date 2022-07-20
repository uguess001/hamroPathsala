<?php $unique_id = time();  ?>
<tr class="fn_add_product_item">
    <td class="fn_add_item_count">1</td>
    <td>
        <select  class="form-control col-md-7 col-xs-12"  name="category_id[]"  id="add_category_id_<?php echo $unique_id; ?>" onchange="get_product_by_category(this, this.value, '', 'add'); reset_total_price(this, 'add');">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
            <?php if(isset($categories) && !empty($categories)){ ?>
                <?php foreach($categories as $obj){ ?>
                    <option value="<?php echo $obj->id; ?>"><?php echo $obj->name; ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </td>
    <td>
        <select  class="form-control col-md-12 col-xs-12 fn_add_product_count"  name="product_id[]"  id="add_product_id_<?php echo $unique_id; ?>" onchange="reset_total_price(this, 'add');">
            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
        </select>
    </td>
    <td>
        <input  class="form-control col-md-7 col-xs-12 fn_add_qty_count"  name="qty[]"  id="add_qty_<?php echo $unique_id; ?>" onkeyup="check_quantity(this, 'add');" value="0" type="number">
    </td>
    <td>
        <input  class="form-control col-md-7 col-xs-12"  name="unit_price[]"  id="add_unit_price_<?php echo $unique_id; ?>" onkeyup="claculate_total_price(this, '', 'add');" value="0" type="number">
    </td>
    <td>
        <input  class="form-control col-md-7 col-xs-12 fn_add_total_price_count"  name="total_price[]"  id="add_total_price_<?php echo $unique_id; ?>" value="0"  type="number" readonly="readonly">
    </td>
    <td>
        <input type="hidden" name="unique_id" id="add_unique_id_<?php echo $unique_id; ?>" class="fn_unique_id" value="<?php echo $unique_id; ?>" />
        <a href="javascript:void();" onclick="remove_product_item(this, 'add');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
    </td>
</tr>