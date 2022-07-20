<?php echo $this->lang->line('quick_link'); ?>:

<?php if(has_permission(VIEW, 'academic', 'classes')){ ?>
    <a href="<?php echo site_url('academic/classes/index'); ?>"><?php echo $this->lang->line('class'); ?></a>
<?php } ?>
<?php if(has_permission(VIEW, 'academic', 'section')){ ?>
| <a href="<?php echo site_url('academic/section/index'); ?>"><?php echo $this->lang->line('section'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'academic', 'subject')){ ?>
| <a href="<?php echo site_url('academic/subject/index'); ?>"><?php echo $this->lang->line('subject'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'academic', 'syllabus')){ ?>
| <a href="<?php echo site_url('academic/syllabus/index'); ?>"><?php echo $this->lang->line('syllabus'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'academic', 'material')){ ?>
| <a href="<?php echo site_url('academic/material/index'); ?>"><?php echo $this->lang->line('material'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'academic', 'liveclass')){ ?>
| <a href="<?php echo site_url('academic/liveclass/index'); ?>"><?php echo $this->lang->line('live_class'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'academic', 'assignment')){ ?>
| <a href="<?php echo site_url('academic/assignment/index'); ?>"><?php echo $this->lang->line('assignment'); ?></a>
<?php } ?>

<?php if(has_permission(VIEW, 'academic', 'submission')){ ?>
| <a href="<?php echo site_url('academic/submission/index'); ?>"><?php echo $this->lang->line('submission'); ?></a>
<?php } ?>
