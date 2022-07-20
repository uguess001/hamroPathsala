<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $live_class->school_name; ?></td>       
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $live_class->class_name; ?></td>        
            <th><?php echo $this->lang->line('section'); ?></th>
            <td><?php echo $live_class->section; ?>   </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $live_class->subject; ?></td>        
            <th><?php echo $this->lang->line('teacher'); ?></th>
            <td><?php echo $live_class->teacher; ?>   </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('live_class_type'); ?></th>
            <td><?php echo $live_class->class_type; ?></td>        
            <th><?php echo $this->lang->line('teacher'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($live_class->class_date)); ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('start_time'); ?></th>
            <td><?php echo $live_class->start_time; ?></td>        
            <th><?php echo $this->lang->line('end_time'); ?></th>
            <td><?php echo $live_class->end_time; ?>   </td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('status'); ?></th>
            <td>                
                <?php                     
                    $class_type = '';

                    if($live_class->class_type == 'zoom'){$class_type = 'Zoom Meet';
                    }else if($live_class->class_type == 'jitsi'){ $class_type = 'Jitsi Meet';
                    }else if($live_class->class_type == 'google'){ $class_type = 'Google Meet';}

                    $flag = 1;
                    $status = '<i class="fa fa-spinner"></i> ' . $this->lang->line('waiting');
                    $button = 'btn btn-info btn-xs';

                    if ($live_class->class_status == 'cancelled') {

                        $status = '<i class="fa fa-close"></i> ' . $this->lang->line('cancelled');
                        $button = 'btn btn-danger btn-xs';
                        $flag = 2;

                    }else if (strtotime($live_class->class_date) == strtotime(date('Y-m-d')) && (strtotime(date('Y-m-d') .' '. $live_class->start_time)) <= (strtotime(date('Y-m-d g:i A'))) && (strtotime(date('Y-m-d') .' '. $live_class->end_time)) >= (strtotime(date('Y-m-d g:i A')))) {

                        $status = '<i class="fa fa-video-camera"></i> ' . $this->lang->line('live');
                        $button = 'btn btn-success btn-xs';
                        $flag = 3;

                    }else if ((strtotime($live_class->class_date) < strtotime(date('Y-m-d'))) && ((strtotime($live_class->class_date .' '. $live_class->end_time)) < (strtotime(date('Y-m-d g:i A')))) && $live_class->class_status != 'completed') {

                        $status = '<i class="fa fa-check-square"></i> ' . $this->lang->line('expire');
                        $button = 'btn btn-danger btn-xs';
                        $flag = 4;

                    }else if ((strtotime($live_class->class_date) < strtotime(date('Y-m-d'))) && ((strtotime($live_class->class_date .' '. $live_class->end_time)) < (strtotime(date('Y-m-d g:i A')))) && $live_class->class_status == 'completed') {

                        $status = '<i class="fa fa-check-square"></i> ' . $this->lang->line('completed');
                        $button = 'btn btn-success btn-xs';
                        $flag = 5;
                    }else if ( $live_class->class_status == 'completed') {

                        $status = '<i class="fa fa-check-square"></i> ' . $this->lang->line('completed');
                        $button = 'btn btn-success btn-xs';
                        $flag = 5;
                    }

                    // echo $obj->class_status;

                    echo "<span class=' " . $button . " '>" . $status . "</span>";
                    ?>
                
            </td>        
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $live_class->note; ?>   </td>
        </tr>        
    </tbody>
</table>