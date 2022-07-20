<?php echo $this->lang->line('quick_link'); ?>:
<?php if(has_permission(VIEW, 'teacher', 'department')){ ?>
 <a href="<?php echo site_url('teacher/department/index'); ?>"><?php echo $this->lang->line('department'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'teacher', 'teacher')){ ?>
| <a href="<?php echo site_url('teacher/teacher/index'); ?>"><?php echo $this->lang->line('teacher'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'teacher', 'lecture')){ ?>
| <a href="<?php echo site_url('teacher/lecture/index'); ?>"><?php echo $this->lang->line('class_lecture'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'teacher', 'rating') && $this->session->userdata('role_id') == STUDENT){ ?>
 | <a href="<?php echo site_url('teacher/rating/index'); ?>"><?php echo $this->lang->line('rating'); ?></a>                         
<?php } ?> 
<?php if(has_permission(VIEW, 'teacher', 'rating') && $this->session->userdata('role_id') != STUDENT){ ?>
  |  <a href="<?php echo site_url('teacher/rating/manage'); ?>"><?php echo $this->lang->line('rating'); ?></a>                         
<?php } ?>




