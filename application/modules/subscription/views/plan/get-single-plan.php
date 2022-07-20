<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>        
        <tr>
            <th><?php echo $this->lang->line('plan_name'); ?></th>
            <td><?php echo $this->lang->line($plan->plan_name); ?></td>
            <th><?php echo $this->lang->line('price'); ?></th>
            <td><?php echo $plan->plan_price; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('student_limit'); ?></th>
            <td><?php echo $plan->student_limit; ?></td>
            <th><?php echo $this->lang->line('guardian_limit'); ?></th>
            <td><?php echo $plan->guardian_limit; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('teacher_limit'); ?></th>
            <td><?php echo $plan->teacher_limit; ?></td>
            <th><?php echo $this->lang->line('employee_limit'); ?></th>
            <td><?php echo $plan->employee_limit; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_enable_frontend'); ?></th>
            <td><?php echo $plan->is_enable_frontend ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
            <th><?php echo $this->lang->line('is_enable_theme'); ?></th>
            <td><?php echo $plan->is_enable_theme ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_enable_language'); ?></th>
            <td><?php echo $plan->is_enable_language ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
            <th><?php echo $this->lang->line('is_enable_report'); ?></th>
            <td><?php echo $plan->is_enable_report ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_enable_attendance'); ?></th>
            <td><?php echo $plan->is_enable_attendance ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
            <th><?php echo $this->lang->line('is_enable_lesson_plan'); ?></th>
            <td><?php echo $plan->is_enable_lesson_plan ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_enable_online_exam'); ?></th>
            <td><?php echo $plan->is_enable_online_exam ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
            <th><?php echo $this->lang->line('is_enable_live_class'); ?></th>
            <td><?php echo $plan->is_enable_live_class ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_enable_payment_gateway'); ?></th>
            <td><?php echo $plan->is_enable_payment_gateway ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
            <th><?php echo $this->lang->line('is_enable_sms_gateway'); ?></th>
            <td><?php echo $plan->is_enable_sms_gateway ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>
        <tr>           
            <th><?php echo $this->lang->line('is_enable_exam_mark'); ?></th>
            <td><?php echo $plan->is_enable_exam_mark ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
            <th><?php echo $this->lang->line('is_enable_promotion'); ?></th>
            <td><?php echo $plan->is_enable_promotion ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_enable_accounting'); ?></th>
            <td><?php echo $plan->is_enable_accounting ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
            <th><?php echo $this->lang->line('is_enable_payroll'); ?></th>
            <td><?php echo $plan->is_enable_payroll ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('is_enable_asset_management'); ?></th>
            <td><?php echo $plan->is_enable_asset_management ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
             <th><?php echo $this->lang->line('is_enable_inventory'); ?></th>
            <td><?php echo $plan->is_enable_inventory ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>  
        </tr>
       
          
        <tr>
            <th><?php echo $this->lang->line('created'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($plan->created_at)); ?></td>
            <th><?php echo $this->lang->line('modified'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($plan->modified_at)); ?></td>
        </tr>       
    </tbody>
</table>
