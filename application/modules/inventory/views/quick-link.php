 <?php echo $this->lang->line('quick_link'); ?>:
 <?php if(has_permission(VIEW, 'inventory', 'supplier')){ ?>
 <a href="<?php echo site_url('inventory/supplier/index'); ?>"><?php echo $this->lang->line('supplier'); ?></a>
 <?php } ?>

<?php if(has_permission(VIEW, 'inventory', 'warehouse')){ ?>
| <a href="<?php echo site_url('inventory/warehouse/index'); ?>"><?php echo $this->lang->line('warehouse'); ?></a>
 <?php } ?> 

<?php if(has_permission(VIEW, 'inventory', 'category')){ ?>
| <a href="<?php echo site_url('inventory/category/index'); ?>"><?php echo $this->lang->line('category'); ?></a>
 <?php } ?>

 <?php if(has_permission(VIEW, 'inventory', 'product')){ ?>
| <a href="<?php echo site_url('inventory/product/index'); ?>"><?php echo $this->lang->line('product'); ?></a>
 <?php } ?>

<?php if(has_permission(VIEW, 'inventory', 'purchase')){ ?>
 | <a href="<?php echo site_url('inventory/purchase/index'); ?>"><?php echo $this->lang->line('purchase'); ?></a>
 <?php } ?>
 
 <?php if(has_permission(VIEW, 'inventory', 'sale')){ ?>
 | <a href="<?php echo site_url('inventory/sale/index'); ?>"><?php echo $this->lang->line('sale'); ?></a>
 <?php } ?>

<?php if(has_permission(VIEW, 'inventory', 'issue')){ ?>
| <a href="<?php echo site_url('inventory/issue/index'); ?>"> <?php echo $this->lang->line('issue'); ?>  </a>
 <?php } ?> 