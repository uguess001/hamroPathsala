<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>               
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td ><?php echo $award->school_name; ?></td>
        </tr>
        <tr>               
            <th><?php echo $this->lang->line('session_year'); ?></th>
            <td ><?php echo $award->session_year; ?></td>
        </tr>        
        <tr>
            <th> <?php echo $this->lang->line('user_type'); ?> </th>
            <td><?php echo $award->role_name; ?></td>                  
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('winner'); ?></th>
            <td>
                <?php
                    $user = get_user_by_role($award->role_id, $award->user_id);
                    if(isset($user) && !empty($user)){
                        echo $user->name;
                        if($award->role_id == STUDENT){
                            echo ' [ '.$this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.', '.$this->lang->line('roll_no').': '.$user->roll_no .' ]';
                        }
                    }
                 ?>
            </td>                   
        </tr>           
        <tr>
            <th><?php echo $this->lang->line('title'); ?> </th>
            <td><?php echo $award->title; ?></td>        
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('gift'); ?> </th>
            <td><?php echo $award->gift; ?></td>        
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('price'); ?> </th>
            <td><?php echo $award->price; ?></td>        
        </tr>            
        <tr>
            <th><?php echo $this->lang->line('date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($award->date)); ?></td>      
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('note'); ?> </th>
            <td><?php echo $award->note; ?></td>        
        </tr>         
    </tbody>
</table>