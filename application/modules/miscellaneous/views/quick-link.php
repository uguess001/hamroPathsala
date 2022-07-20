<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'miscellaneous', 'award')){ ?>
    <a href="<?php echo site_url('miscellaneous/award/index'); ?>"><?php echo $this->lang->line('award'); ?></a>                   
<?php } ?>              
<?php if(has_permission(VIEW, 'miscellaneous', 'todo')){ ?>
  | <a href="<?php echo site_url('miscellaneous/todo/index'); ?>"><?php echo $this->lang->line('todo'); ?></a>                  
<?php } ?> 
<?php if(has_permission(VIEW, 'miscellaneous', 'faq')){ ?>
  | <a href="<?php echo site_url('miscellaneous/faq/index'); ?>"><?php echo $this->lang->line('faq'); ?></a>                  
<?php } ?> 