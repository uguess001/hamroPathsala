<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>               
            <th width="20%"><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $submit->school_name; ?></td> 
        <tr>               
            <th width="20%"><?php echo $this->lang->line('academic_year'); ?></th>
            <td width="30%"><?php echo $submit->session_year; ?></td>       
            <th width="20%"><?php echo $this->lang->line('assignment'); ?></th>
            <td width="30%"><?php echo $submit->title; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $submit->class_name; ?></td>        
            <th><?php echo $this->lang->line('section'); ?></th>
            <td><?php echo $submit->section; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $submit->subject; ?></td>
            <th><?php echo $this->lang->line('submitted_by'); ?></th>
            <td><?php echo $submit->student_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('assignment_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($submit->assigment_date)); ?></td>
            <th><?php echo $this->lang->line('submission_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($submit->submission_date)); ?></td>            
        </tr>       
        <tr>            
            <th><?php echo $this->lang->line('evaluation_date'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($submit->evaluation_date)); ?></td>
            <th><?php echo $this->lang->line('evaluation_status'); ?></th>
            <td><?php echo $this->lang->line($submit->evaluation_status); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('submitted_at'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($submit->submitted_at)); ?></td>
            <th><?php echo $this->lang->line('submission'); ?></th>
            <td>               
                <?php if($submit->submission){ ?>                
                    <a target="_blank" href="<?php echo UPLOAD_PATH; ?>assignment-submission/<?php echo $submit->submission; ?>"  class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a> <br/><br/>
                <?php } ?>
                   
            </td>
        </tr>        
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td colspan="3"><?php echo $submit->note; ?>   </td>            
        </tr>
    </tbody>
</table>
