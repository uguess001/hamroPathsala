<span><?php echo $this->lang->line('quick_link'); ?>:</span>
<?php if(has_permission(VIEW, 'scholarship', 'candidate')){ ?>
    <a href="<?php echo site_url('scholarship/candidate/index'); ?>"><?php echo $this->lang->line('candidate'); ?></a>                   
<?php } ?>              
<?php if(has_permission(VIEW, 'scholarship', 'donar')){ ?>
  | <a href="<?php echo site_url('scholarship/donar/index'); ?>"><?php echo $this->lang->line('donar'); ?></a>                  
<?php } ?> 
<?php if(has_permission(VIEW, 'scholarship', 'scholarship')){ ?>
  | <a href="<?php echo site_url('scholarship/index'); ?>"><?php echo $this->lang->line('scholarship'); ?></a>                  
<?php } ?> 