<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="20%"> <?php echo $this->lang->line('school_name'); ?> </th>
            <td width="30%"><?php echo $issue->school_name; ?></td>        
            <th width="20%"> <?php echo $this->lang->line('category'); ?> </th>
            <td width="30%"><?php echo $issue->category; ?></td>
        </tr>
        
        <tr>
            <th> <?php echo $this->lang->line('product'); ?></th>
            <td><?php echo $issue->product; ?></td>        
            <th> <?php echo $this->lang->line('quantity'); ?></th>
            <td><?php echo $issue->qty; ?></td>
        </tr>
        
        <tr>
            <th> <?php echo $this->lang->line('user_type'); ?></th>
            <td><?php echo $issue->role_name; ?></td>        
            <th> <?php echo $this->lang->line('issue_to'); ?></th>
             <td>
                <?php
                    $user = get_user_by_role($issue->role_id, $issue->user_id);
                    echo $user->name;
                    if($issue->role_id == STUDENT){
                        echo ' [ '.$this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.','. $this->lang->line('roll_no'). ':'. $user->roll_no . ']';
                    }
                 ?>
            </td>
        </tr> 
        
        <tr>
            <th><?php echo $this->lang->line('issue_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($issue->issue_date)); ?></td> 
            <th><?php echo $this->lang->line('due_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($issue->due_date)); ?></td>      
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('return_date'); ?> </th>
            <td><?php echo $issue->return_date ? date($this->global_setting->date_format, strtotime($issue->return_date)) : '<a style="color:red;" href="javascript:void(0);" onclick="issue_check_out('.$issue->id.');">'.$this->lang->line('return_this').'</a>'; ?></td>          
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $issue->note; ?></td>
        </tr>
         
    </tbody>
</table>