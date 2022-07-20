<?php echo $this->lang->line('quick_link'); ?>:
<?php if(has_permission(VIEW, 'asset', 'vendor')){ ?>
 <a href="<?php echo site_url('asset/vendor/index'); ?>"><?php echo $this->lang->line('vendor'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'asset', 'store')){ ?>
| <a href="<?php echo site_url('asset/store/index'); ?>"><?php echo $this->lang->line('store'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'asset', 'category')){ ?>
| <a href="<?php echo site_url('asset/category/index'); ?>"><?php echo $this->lang->line('category'); ?></a>
<?php } ?>

 <?php if(has_permission(VIEW, 'asset', 'item')){ ?>
|  <a href="<?php echo site_url('asset/item/index'); ?>"><?php echo $this->lang->line('item'); ?></a>
<?php } ?>

 <?php if(has_permission(VIEW, 'asset', 'purchase')){ ?>
| <a href="<?php echo site_url('asset/purchase/index'); ?>"><?php echo $this->lang->line('purchase'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'asset', 'issue')){ ?>
 | <a href="<?php echo site_url('asset/issue/index'); ?>"><?php echo $this->lang->line('issue'); ?></a>
<?php } ?>