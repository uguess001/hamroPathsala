<?php echo $this->lang->line('quick_link'); ?>:
<?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>   
<a href="<?php echo site_url('subscription/faq/index'); ?>"> <?php echo $this->lang->line('faq'); ?></a>
| <a href="<?php echo site_url('subscription/slider/index'); ?>"><?php echo $this->lang->line('slider'); ?></a>
| <a href="<?php echo site_url('subscription/setting/index'); ?>"><?php echo $this->lang->line('subscription_setting'); ?></a>
| <a href="<?php echo site_url('administrator/setting/index'); ?>"> <?php echo $this->lang->line('general_setting'); ?></a>
| <a href="<?php echo site_url('subscription/plan/index'); ?>"><?php echo $this->lang->line('subscription_plan'); ?></a>
| <a href="<?php echo site_url('subscription/index'); ?>"><?php echo $this->lang->line('subscription'); ?></a>
<?php } ?>