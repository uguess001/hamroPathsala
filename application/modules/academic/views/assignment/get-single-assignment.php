<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="20%"><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $assignment->school_name; ?></td> 
        </tr>
        <tr>
            <th width="20%"><?php echo $this->lang->line('academic_year'); ?></th>
            <td width="30%"><?php echo $assignment->session_year; ?></td>        
            <th width="20%"><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $assignment->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $assignment->class_name; ?></td>        
            <th><?php echo $this->lang->line('section'); ?></th>
            <td><?php echo $assignment->section; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $assignment->subject; ?></td>
            <th><?php echo $this->lang->line('assignment'); ?></th>
            <td>
                <?php if($assignment->assignment){ ?>
                <a target="_blank" href="<?php echo UPLOAD_PATH; ?>/assignment/<?php echo $assignment->assignment; ?>"  class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/><br/>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('assignment_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($assignment->assigment_date)); ?></td>       
            <th><?php echo $this->lang->line('submission_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($assignment->submission_date)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('sms_notification'); ?></th>
            <td ><?php echo $assignment->sms_notification ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>        
            <th><?php echo $this->lang->line('email_notification'); ?></th>
            <td ><?php echo $assignment->email_notification ? $this->lang->line('yes') : $this->lang->line('no'); ?></td>
        </tr>       
        <tr>
            <th><?php echo $this->lang->line('total_student'); ?></th>
            <td>
                <?php 
                    $total_student = get_total_student_by_section($assignment->class_id, $assignment->section_id, $assignment->academic_year_id); 
                    echo $total_student;
                ?>
            </td>        
            <th><?php echo $this->lang->line('total_submitted'); ?></th>
            <td>
                <?php 
                   $total_submission = get_total_submission_by_asignment($assignment->id);
                   echo $total_submission;
                ?>
            </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('total_completed'); ?></th>
            <td>
                <?php 
                   $total_complete = get_total_submission_by_asignment($assignment->id, 'completed');
                   echo $total_complete;
                ?>
            </td>        
            <th><?php echo $this->lang->line('total_incomplete'); ?></th>
            <td><?php echo $total_submission - $total_complete; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td ><?php echo strip_tags($assignment->note); ?>   </td>
            <th><?php echo $this->lang->line('status'); ?></th>
            <td><?php echo $assignment->status ? $this->lang->line('active') : $this->lang->line('in_active'); ?></td>  
        </tr>
    </tbody>
</table>
