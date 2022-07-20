<?php echo $this->lang->line('quick_link'); ?>:
<?php if(has_permission(VIEW, 'onlineexam', 'instruction')){ ?>
 <a href="<?php echo site_url('onlineexam/instruction/index'); ?>"><?php echo $this->lang->line('instruction'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'onlineexam', 'question')){ ?>
| <a href="<?php echo site_url('onlineexam/question/index'); ?>"><?php echo $this->lang->line('question_bank'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'onlineexam', 'onlineexam')){ ?>
| <a href="<?php echo site_url('onlineexam/index'); ?>"><?php echo $this->lang->line('online_exam'); ?></a>
<?php } ?>

<?php if($this->session->userdata('role_id') == STUDENT){ ?>
   <?php if(has_permission(VIEW, 'onlineexam', 'takeexam')){ ?>
   |  <a href="<?php echo site_url('onlineexam/takeexam/index'); ?>"><?php echo $this->lang->line('take_exam'); ?></a>
   <?php } ?>
<?php } ?>

 <?php if(has_permission(VIEW, 'onlineexam', 'takeexam')){ ?>
|  <a href="<?php echo site_url('onlineexam/takeexam/result'); ?>"><?php echo $this->lang->line('exam_result'); ?></a>
<?php } ?>