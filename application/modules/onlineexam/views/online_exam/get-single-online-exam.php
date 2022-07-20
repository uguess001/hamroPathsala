<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody> 
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $online_exam->school_name; ?></td>              
        </tr>
        <tr>
            <th width="20%"><?php echo $this->lang->line('exam_title'); ?></th>
            <td width="30%"><?php echo $online_exam->title; ?></td>  
            <th width="20%"><?php echo $this->lang->line('class'); ?></th>
            <td width="30%"><?php echo $online_exam->class_name; ?></td>  
            
        </tr>
         <tr>
            <th><?php echo $this->lang->line('section'); ?></th>
            <td><?php echo $online_exam->section; ?></td>  
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $online_exam->subject; ?></td>  
            
        </tr>
        <tr>
            <th><?php echo $this->lang->line('instruction'); ?></th>
            <td><?php echo $online_exam->ins_title; ?></td>         
            <th><?php echo $this->lang->line('duration'); ?></th>
            <td><?php echo $online_exam->duration; ?> (Minute)</td>            
        </tr>
        <tr>
            <th><?php echo $this->lang->line('start_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($online_exam->start_date)); ?></td>        
            <th><?php echo $this->lang->line('end_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($online_exam->end_date)); ?></td>            
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('mark_type'); ?></th>
            <td><?php echo $this->lang->line($online_exam->mark_type); ?></td>         
            <th><?php echo $this->lang->line('pass_mark'); ?></th>
            <td><?php echo $online_exam->pass_mark; ?></td>            
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('is_publish'); ?></th>
            <td><?php echo $online_exam->is_publish ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>         
            <th><?php echo $this->lang->line('is_active'); ?></th>
            <td><?php echo $online_exam->status ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>           
        </tr>
        
        <tr>                   
            <th><?php echo $this->lang->line('exam_limit_per_student'); ?></th>
            <td ><?php echo $online_exam->exam_limit; ?></td>            
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $online_exam->note; ?></td>            
        </tr>
       
    </tbody>
</table>
