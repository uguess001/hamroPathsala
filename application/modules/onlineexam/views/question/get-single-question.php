<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody> 
        <tr>
            <th><?php echo $this->lang->line('school_name'); ?></th>
            <td colspan="3"><?php echo $question->school_name; ?></td>             
        </tr>
        <tr>
            <th width="20%"><?php echo $this->lang->line('class'); ?></th>
            <td width="30%"><?php echo $question->class_name; ?></td>  
            <th width="20%"><?php echo $this->lang->line('section'); ?></th>
            <td width="30%"><?php echo $question->section; ?></td>
        </tr>
        <tr>
            <th><?php echo $this->lang->line('subject'); ?></th>
            <td><?php echo $question->subject; ?></td>         
            <th><?php echo $this->lang->line('question_lebel'); ?></th>
            <td><?php echo $this->lang->line($question->question_level); ?></td>            
        </tr>
        <tr>
            <th><?php echo $this->lang->line('mark'); ?></th>
            <td><?php echo $question->mark; ?></td>        
            <th><?php echo $this->lang->line('total_option'); ?></th>
            <td><?php echo $question->total_option; ?></td>            
        </tr>
        <tr>           
            <td colspan="4"><?php echo $question->question; ?></td>   
        </tr>
        
        <?php if ($question->image) { ?>
            <tr>               
                <td colspan="4">
                    <img src="<?php echo UPLOAD_PATH; ?>/question/<?php echo $question->image; ?>" alt="" style="width: auto;" /><br/>
                </td>
            </tr>        
        <?php } ?> 
            
        <tr>            
            <td colspan="4">
                <?php
                
                $str = '';
                if($question->question_type == 'single'){
                    
                    foreach($options AS $obj){                       
                        
                        $answer = $obj->is_correct ? 'checked="checked"' : '';
                        
                        $str .= '<div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                               <input type="radio" name="ans[]" value="1" '.$answer.' disabled="disabled"> '. $obj->option.' 
                            </div>';   
                    }
                }else if($question->question_type == 'multi'){
                    
                    foreach($options AS $obj){                       
                        
                        $answer = $obj->is_correct ? 'checked="checked"' : '';
                        
                        $str .= '<div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                               <input type="checkbox" name="ans[]" value="1" '.$answer.' disabled="disabled"> '. $obj->option.' 
                            </div>';   
                    }
                    
                }else if($question->question_type == 'boolean'){
                    
                    foreach($options AS $obj){                       
                        
                        $answer = $obj->is_correct ? 'checked="checked"' : '';                        
                        $str .= '<div class="col-md-6 col-sm-6 col-xs-12" style="display:inline-table">
                               <input type="radio" name="ans[]" value="1" '.$answer.' disabled="disabled"> '. $obj->option .' 
                            </div>';   
                    }
                }else if($question->question_type == 'blank'){
                    
                    foreach($options AS $obj){                       
                        
                        $answer = $obj->is_correct ? 'checked="checked"' : '';
                        
                        $str .= '<div class="col-md-12" style="display:inline-table">
                               '. $obj->option.' 
                                </div>';   
                    }
                }
                
                echo $str;
                
                ?>
            </td>
        </tr>         
        <tr>
            <th> <?php echo $this->lang->line('status'); ?></th>
            <td colspan="3"><?php echo $question->status ? $this->lang->line('active') : $this->lang->line('in_active'); ?></td>
        </tr>
    </tbody>
</table>