<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody> 
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $exam_result->school_name; ?></td>  
        </tr>
        <tr>
            <th><?php echo $this->lang->line('student_name'); ?></th>
            <td><?php echo $exam_result->student_name; ?></td>  
            <th><?php echo $this->lang->line('exam_title'); ?></th>
            <td><?php echo $exam_result->exam_title; ?></td> 
        </tr>
        <tr>            
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $exam_result->class_name; ?></td>  
            <th><?php echo $this->lang->line('section'); ?></th>
            <td><?php echo $exam_result->section; ?></td>  
        </tr>
         <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $exam_result->subject; ?></td>  
            <th><?php echo $this->lang->line('academic_year'); ?></th>
            <td><?php echo $exam_result->session_year; ?></td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('start_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($exam_result->start_date)); ?></td>        
            <th><?php echo $this->lang->line('end_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($exam_result->end_date)); ?></td>            
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('mark_type'); ?></th>
            <td><?php echo $this->lang->line($exam_result->mark_type); ?></td>         
            <th><?php echo $this->lang->line('pass_mark'); ?></th>
            <td><?php echo number_format($exam_result->pass_mark); ?> <?php echo ($exam_result->mark_type =='percentage') ? '%' : '' ; ?></td>            
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('total_question'); ?></th>
            <td><?php echo $exam_result->total_question; ?></td>         
            <th><?php echo $this->lang->line('total_answered'); ?></th>
            <td><?php echo $exam_result->total_answer; ?></td>            
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('total_mark'); ?></th>
            <td><?php echo $exam_result->total_mark; ?></td>         
            <th><?php echo $this->lang->line('total_obtain_mark'); ?></th>
            <td><?php echo $exam_result->total_obtain_mark; ?></td>            
        </tr>
        <tr>
            <th><?php echo $this->lang->line('correct_answer'); ?></th>
            <td><?php echo $exam_result->total_correct_answer; ?></td>         
            <th><?php echo $this->lang->line('incorrect_answer'); ?></th>
            <td><?php echo $exam_result->total_incorrect_answer; ?></td>            
        </tr>
        <tr>
            <th><?php echo $this->lang->line('obtain_mark'); ?></th>
            <td><?php echo number_format($exam_result->obtain_mark_percent, 0); ?>%</td> 
            <th><?php echo $this->lang->line('result'); ?></th>
            <td><?php echo $exam_result->result_status ==  'passed' ? $this->lang->line('passed') : $this->lang->line('failed'); ?></td>        
        </tr>
        
    </tbody>
</table>
