<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $lecture->school_name; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('lecture_type'); ?></th>
            <td><?php echo $this->lang->line($lecture->lecture_type); ?></td>
            <th><?php echo $this->lang->line('title'); ?></th>
            <td><?php echo $lecture->lecture_title; ?></td>        
        </tr>
        <tr>
            <th><?php echo $this->lang->line('class'); ?></th>
            <td><?php echo $lecture->class_name; ?></td>       
            <th><?php echo $this->lang->line('section'); ?></th>
            <td><?php echo $lecture->section; ?></td>
        </tr>  
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $lecture->subject; ?></td>
            <th><?php echo $this->lang->line('teacher'); ?></th>
            <td><?php echo $lecture->teacher; ?></td>       
        </tr>  
        <tr>   
            <th><?php echo $this->lang->line('class_lecture'); ?></th>
            <td colspan="3">
                <?php if($lecture->lecture_type == 'ppt' && $lecture->lecture_ppt != ''){ ?>
                    <a target="_blank" href="<?php echo UPLOAD_PATH; ?>video-lecture/<?php echo $lecture->lecture_ppt; ?>" class="btn btn-success btn-xs"><i class="fa fa-download"></i> <?php echo $this->lang->line('download'); ?></a>
               <?php }else if($lecture->lecture_type == 'youtube' && $lecture->video_id != ''){ ?>
                    <iframe class="youtube-player" type="text/html" style="width:100%; height:350px;" height="350"
                       src="https://www.youtube.com/embed/<?php echo $lecture->video_id; ?>" frameborder="0">
                    </iframe>
               <?php }else if($lecture->lecture_type == 'vimeo' && $lecture->video_id != ''){ ?>
                    
                    <iframe src="https://player.vimeo.com/video/<?php echo $lecture->video_id; ?>" style="width:100%; height:350px;" height="350" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    <script src="https://player.vimeo.com/api/player.js"></script>
                    <script>
                    <!- Your Vimeo SDK player script goes here ->
                    </script>                    
               <?php } ?>                   
                    
            </td>
        </tr> 
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $lecture->note; ?>   </td>       
            <th><?php echo $this->lang->line('created_at'); ?></th>
            <td><?php echo date($this->global_setting->date_format, strtotime($lecture->created_at)); ?></td>
        </tr>
    </tbody>
</table>
