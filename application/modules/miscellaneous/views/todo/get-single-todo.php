<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>               
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $todo->school_name; ?></td>
        </tr>        
        <tr>               
            <th><?php echo $this->lang->line('session_year'); ?></th>
            <td><?php echo $todo->session_year; ?></td>
        </tr>        
        <tr>
            <th> <?php echo $this->lang->line('user_type'); ?> </th>
            <td><?php echo $todo->role_name; ?></td>                  
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('assign_to'); ?></th>
            <td>
                <?php
                    $user = get_user_by_role($todo->role_id, $todo->user_id);
                    echo $user->name;
                    if($todo->role_id == STUDENT){
                        echo ' [ '.$this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.', '.$this->lang->line('roll_no').': '.$user->roll_no .' ]';
                    }
                 ?>
            </td> 
        </tr>           
        <tr>
            <th><?php echo $this->lang->line('title'); ?> </th>
            <td><?php echo $todo->title; ?></td>        
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($todo->date)); ?></td>      
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('work_status'); ?> </th>
            <td><?php echo $this->lang->line($todo->work); ?></td>        
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('description'); ?> </th>
            <td><?php echo $todo->description; ?></td>        
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('comment'); ?> </th>
            <td><?php echo $todo->comment; ?></td>        
        </tr>
    </tbody>
</table>
