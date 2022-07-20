<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-mouse-pointer"></i><small> <?php echo $this->lang->line('manage_question_bank'); ?> </small></h3>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>                    
                </ul>
                <div class="clearfix"></div>
            </div>
            
            <div class="x_content quick-link">
                <?php $this->load->view('quick-link'); ?>              
            </div>
            
            <div class="x_content">
                <div class="" data-example-id="togglable-tabs">
                    
                    <ul  class="nav nav-tabs  nav-tab-find bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_question_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'onlineexam', 'question')){ ?>
                            <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('onlineexam/question/add'); ?>"  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_question"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?></a> </li>                          
                             <?php } ?>
                        <?php } ?>                
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_question"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>                
                                                    
                            
                        <li class="li-class-list">
                                                          
                            <?php $guardian_class_data = get_guardian_access_data('class'); ?>
                            <?php $teacher_access_data = get_teacher_access_data(); ?>  
                            
                            <?php echo form_open(site_url('onlineexam/question/index'), array('name' => 'filter', 'id' => 'filter', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                              <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>
                                    
                                    <select  class="form-control col-md-7 col-xs-12" style="width:auto;" name="school_id" id="school_id" onchange="get_class_by_school(this.value, '', '');">
                                            <option value="">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                        <?php foreach($schools as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                        <?php } ?>   
                                    </select> 
                                 <?php } ?>
                            
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="class_id" id="class_id" onchange="get_subject_by_class(this.value, '', '');" style="width: auto;">
                                        <?php if($this->session->userdata('role_id') != STUDENT){ ?>
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php } ?>  
                                        <?php foreach($classes as $obj ){ ?>
                                            <?php if($this->session->userdata('role_id') == STUDENT ){ ?>
                                                <?php if ($obj->id != $this->session->userdata('class_id')){ continue; } ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php }elseif($this->session->userdata('role_id') == GUARDIAN){ ?>                                            
                                                     <?php if (!in_array($obj->id, $guardian_class_data)) { continue; } ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php }elseif($this->session->userdata('role_id') == TEACHER){ ?>                                            
                                                     <?php if (!in_array($obj->id, $teacher_access_data)) { continue; } ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php if(isset($filter_class_id) && $filter_class_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                                <?php } ?>                                           
                                        <?php } ?>                                            
                                    </select> 
                                    <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_" name="subject_id" id="subject_id" style="width: auto;">                                
                                        <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                        <?php foreach($subjects as $obj ){ ?>
                                            <?php if($this->session->userdata('role_id') == STUDENT){ ?>                                       
                                                <option value="<?php $obj->id; ?>" <?php if(isset($filter_subject_id) && $filter_subject_id == $obj->id){ echo 'selected="selected"';} ?> ><?php echo $obj->name; ?></option>
                                            <?php } ?>                                                                                     
                                        <?php } ?>                                            
                                    </select> 
                            
                                <input type="submit" name="find" value="<?php echo $this->lang->line('find'); ?>"  class="btn btn-success btn-sm"/>
                            <?php echo form_close(); ?>
                        </li>    
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_question_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th> 
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?> 
                                        <th><?php echo $this->lang->line('class'); ?></th>
                                        <th><?php echo $this->lang->line('subject'); ?></th>
                                        <th><?php echo $this->lang->line('question_type'); ?></th>
                                        <th><?php echo $this->lang->line('question_lebel'); ?></th>
                                        <th><?php echo $this->lang->line('question'); ?></th>
                                        <th><?php echo $this->lang->line('status'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>  
                                    
                                    <?php $count = 1; if(isset($questions) && !empty($questions)){ ?>
                                        <?php foreach($questions as $obj){ ?>
                                        <?php 
                                            if($this->session->userdata('role_id') == GUARDIAN){
                                                if (!in_array($obj->class_id, $guardian_access_data)) { continue; }
                                            }elseif($this->session->userdata('role_id') == STUDENT){
                                                if ($obj->class_id != $this->session->userdata('class_id')){ continue; }                                          
                                            }elseif($this->session->userdata('role_id') == TEACHER){
                                                if (!in_array($obj->class_id, $teacher_access_data)) { continue; }
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>   
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->class_name; ?></td>
                                            <td><?php echo $obj->subject; ?></td>
                                            <td><?php echo get_question_type($obj->question_type);  ?></td>
                                            <td><?php echo $this->lang->line($obj->question_level); ?></td>
                                            <td><?php echo $obj->question; ?></td>
                                            <td><?php echo $obj->status ? $this->lang->line('active') : $this->lang->line('in_active'); ?></td>
                                            <td>
                                                <?php if(has_permission(EDIT, 'onlineexam', 'question')){ ?>
                                                    <a href="<?php echo site_url('onlineexam/question/edit/'.$obj->id); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(VIEW, 'onlineexam', 'question')){ ?>                                                    
                                                    <a  onclick="get_question_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-question-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(DELETE, 'onlineexam', 'question')){ ?>
                                                    <a href="<?php echo site_url('onlineexam/question/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_question">
                            <div class="x_content"> 
                                
                               <?php echo form_open_multipart(site_url('onlineexam/question/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_"  name="class_id"  id="add_class_id" required="required" onchange="get_section_by_class(this.value, '', 'add_');get_subject_by_class(this.value, '', 'add_');" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php foreach($classes as $obj ){ ?>
                                                <?php
                                                if($this->session->userdata('role_id') == TEACHER){
                                                   if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                } 
                                                ?>
                                                <option value="<?php echo $obj->id; ?>" <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ?  'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="section_id"><?php echo $this->lang->line('section'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="section_id"  id="add_section_id">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                      
                                        </select>
                                        <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject_id"><?php echo $this->lang->line('subject'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="subject_id"  id="add_subject_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                      
                                        </select>
                                        <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question_level"><?php echo $this->lang->line('question_lebel'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="question_level"  id="add_question_level" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php $labels = get_question_label(); ?>
                                            <?php foreach($labels as $key=>$value){ ?>
                                                <option value="<?php echo $key; ?>" <?php echo isset($post['question_level']) && $post['question_level'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('question_level'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question"><?php echo $this->lang->line('question'); ?> <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="question"  id="add_question" value="<?php echo isset($post['question']) ?  $post['question'] : ''; ?>" placeholder="<?php echo $this->lang->line('question'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('question'); ?></div>
                                    </div>
                                </div>  
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('image'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                            <input  class="form-control col-md-7 col-xs-12"  name="image"  id="add_image" type="file">
                                        </div>
                                        <div class="text-info"><?php echo $this->lang->line('valid_file_format_doc'); ?></div>
                                        <div class="help-block"><?php echo form_error('image'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mark"><?php echo $this->lang->line('mark'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mark"  id="add_mark" value="<?php echo isset($post['mark']) ?  $post['mark'] : ''; ?>" placeholder="<?php echo $this->lang->line('mark'); ?>" required="required" type="number" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mark'); ?></div>
                                    </div>
                                </div> 
                                                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question_type"><?php echo $this->lang->line('question_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="question_type"  id="add_question_type" required="required" onchange="get_question_type(this.value, 'add_');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php $types = get_question_type(); ?>
                                            <?php foreach($types as $key=>$value){ ?>
                                                <option value="<?php echo $key; ?>" <?php echo isset($post['question_type']) && $post['question_type'] == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('question_type'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group display fn_add_total_option">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_option"><?php echo $this->lang->line('total_option'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="total_option"  id="add_total_option" onchange="get_question_option(this.value, '', 'add_');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php for($i = 1; $i<=6; $i++){ ?>
                                                <option value="<?php echo $i; ?>" <?php echo isset($post['total_option']) && $post['total_option'] == $i ?  'selected="selected"' : ''; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('total_option'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="fn_add_question_option_block">                                                                      
                                </div>
                                
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('onlineexam/question/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>                                
                            </div>
                        </div>  

                        
                        <?php if(isset($edit)){ ?>
                        <div class="tab-pane fade in active" id="tab_edit_question">
                            <div class="x_content"> 
                               <?php echo form_open_multipart(site_url('onlineexam/question/edit/'.$question->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                         
                                <?php $this->load->view('layout/school_list_edit_form'); ?>
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_"  name="class_id"  id="edit_class_id" required="required"  onchange="get_section_by_class(this.value, '', 'edit');get_subject_by_class(this.value, '', 'edit');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php foreach($classes as $obj ){ ?>
                                               <?php
                                                if($this->session->userdata('role_id') == TEACHER){
                                                   if (!in_array($obj->id, $teacher_access_data)) {continue; }
                                                } 
                                                ?> 
                                               <option value="<?php echo $obj->id; ?>" <?php if($question->class_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="section_id"><?php echo $this->lang->line('section'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="section_id"  id="edit_section_id">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                      
                                        </select>
                                        <div class="help-block"><?php echo form_error('section_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subject_id"><?php echo $this->lang->line('subject'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="subject_id"  id="edit_subject_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                      
                                        </select>
                                        <div class="help-block"><?php echo form_error('subject_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question_level"><?php echo $this->lang->line('question_lebel'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="question_level"  id="edit_question_level" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php $labels = get_question_label(); ?>
                                            <?php foreach($labels as $key=>$value){ ?>
                                                <option value="<?php echo $key; ?>" <?php echo isset($question) && $question->question_level == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('question_level'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question"><?php echo $this->lang->line('question'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="question"  id="edit_question" value="<?php echo isset($question) ?  $question->question : ''; ?>" placeholder="<?php echo $this->lang->line('question'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('question'); ?></div>
                                    </div>
                                </div>  
                                 
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo $this->lang->line('image'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="hidden" name="prev_image" id="prev_question" value="<?php echo $question->image; ?>" />
                                        <?php if($question->image){ ?>
                                            <img src="<?php echo UPLOAD_PATH; ?>/question/<?php echo $question->image; ?>" alt="" style="width: auto" /><br/>
                                        <?php } ?>
                                        <div class="btn btn-default btn-file">
                                            <i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                            <input  class="form-control col-md-7 col-xs-12"  name="image"  id="edit_image" type="file">
                                        </div>
                                        <div class="text-info"><?php echo $this->lang->line('valid_file_format_doc'); ?></div>
                                        <div class="help-block"><?php echo form_error('image'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mark"><?php echo $this->lang->line('mark'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="mark"  id="add_mark" value="<?php echo isset($question) ?  $question->mark : ''; ?>" required="required" type="number" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('mark'); ?></div>
                                    </div>
                                </div> 
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="question_type"><?php echo $this->lang->line('question_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12  gsms-nice-select_"  name="question_type"  id="edit_question_type" required="required" onchange="get_question_type(this.value, 'edit_');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php $types = get_question_type(); ?>
                                            <?php foreach($types as $key=>$value){ ?>
                                                <option value="<?php echo $key; ?>" <?php echo isset($question) && $question->question_type == $key ?  'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('question_type'); ?></div>
                                    </div>
                                </div>
                             
                                
                                <div class="item form-group display fn_edit_total_option">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="total_option"><?php echo $this->lang->line('total_option'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12 gsms-nice-select_"  name="total_option"  id="edit_total_option" onchange="get_question_option(this.value, '<?php echo $question->id; ?>', 'edit_');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php for($i = 1; $i<=6; $i++){ ?>
                                                <option value="<?php echo $i; ?>" <?php echo isset($question) && $question->total_option == $i ?  'selected="selected"' : ''; ?>><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('total_option'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="fn_edit_question_option_block">                                                                      
                                </div>
                                
                                <div class="item form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="status"><?php echo $this->lang->line('status'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12 gsms-nice-select_"  name="status"  id="status" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                    
                                            <option value="1" <?php if($question->status == 1){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('active'); ?></option>                                           
                                            <option value="0" <?php if($question->status == 0){ echo 'selected="selected"';} ?>><?php echo $this->lang->line('in_active'); ?></option>                                                                                       
                                        </select>
                                        <div class="help-block"><?php echo form_error('status'); ?></div>
                                    </div>
                                </div> 
                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <input type="hidden" value="<?php echo isset($question) ? $question->id : ''; ?>" name="id" />
                                        <a href="<?php echo site_url('onlineexam/question/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  
                        <?php } ?>
                                                
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade bs-question-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_question_data"></div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_question_modal(question_id){
         
        $('.fn_question_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('onlineexam/question/get_single_question'); ?>",
          data   : {question_id : question_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_question_data').html(response);
             }
          }
        });
    }
</script>


<!-- Super admin js START  -->
 <script type="text/javascript">     
    $("document").ready(function() {
        <?php if(isset($edit) && !empty($edit)){ ?>
           $("#edit_school_id").trigger('change');
        <?php } ?>
    });
     
    $('.fn_school_id').on('change', function(){
      
        var school_id = $(this).val();        
        var class_id = '';
        var form = 'add_';
        
        <?php if(isset($edit) && !empty($edit)){ ?>
            class_id =  '<?php echo $question->class_id; ?>';  
            var form = 'edit_';
         <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }       
        get_class_by_school(school_id, class_id, form);
    }); 

  </script>
<!-- Super admin js end -->


<script type="text/javascript">     
               
    <?php if(isset($post) && $post['school_id'] != ''){ ?>       
        get_class_by_school('<?php echo $post['school_id']; ?>', '<?php echo $post['class_id']; ?>', 'add_');        
    <?php } ?> 

   <?php if(isset($question) && !empty($question)){ ?>
        get_class_by_school('<?php echo $question->school_id; ?>', '<?php echo $question->class_id; ?>', 'edit_');
    <?php } ?>    

   <?php if(isset($filter_school_id) && $filter_school_id != '' && isset($filter_class_id)){ ?>
        get_class_by_school('<?php echo $filter_school_id; ?>', '<?php echo $filter_class_id; ?>', '');
    <?php } ?>    
    
    function get_class_by_school(school_id, class_id, form){
        
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id : school_id, class_id : class_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               { 
                     $('#'+form+'class_id').html(response);                    
               }
            }
        });
    }
    
    
    <?php if(isset($post) && $post['class_id'] != ''){ ?>       
        get_subject_by_class('<?php echo $post['class_id']; ?>', '<?php echo $post['subject_id']; ?>', 'add_');
    <?php } ?>
   <?php if(isset($question) && !empty($question)){  ?>
        get_subject_by_class('<?php echo $question->class_id; ?>', '<?php echo $question->subject_id; ?>', 'edit_');
    <?php } ?> 
    <?php if(isset($filter_class_id) && $filter_class_id != '' && isset($filter_subject_id)){ ?>
        get_subject_by_class('<?php echo $filter_class_id; ?>', '<?php echo $filter_subject_id; ?>', '');
    <?php } ?>
        
    function get_subject_by_class(class_id, subject_id, form){       
           
        var school_id = $('#'+form+'school_id').val();       
        if(!school_id){
            school_id = '<?php echo $school_id; ?>';
        }
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_subject_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id , subject_id : subject_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {                  
                   $('#'+form+'subject_id').html(response);                  
               }
            }
        });
   } 
   
    
    
    
    <?php if(isset($post) && $post['class_id'] != ''){ ?>       
        get_section_by_class('<?php echo $post['class_id']; ?>', '<?php echo $post['section_id']; ?>', 'add_');
    <?php } ?>
   <?php if(isset($question) && !empty($question)){  ?>
        get_section_by_class('<?php echo $question->class_id; ?>', '<?php echo $question->section_id; ?>', 'edit_');
    <?php } ?> 
    
    function get_section_by_class(class_id, section_id, form){       
         
        var school_id = $('#'+form+'school_id').val();       
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_section_by_class'); ?>",
            data   : {school_id:school_id, class_id : class_id, section_id : section_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#'+form+'section_id').html(response);
               }
            }
        }); 
   }

 
    
    <?php if(isset($post) && $post['class_id'] != ''){ ?>       
        get_question_type('<?php echo $post['question_type']; ?>', 'add_');
    <?php } ?>
    <?php if(isset($question) && !empty($question)){  ?>
        get_question_type('<?php echo $question->question_type; ?>', 'edit_');
    <?php } ?>   
    function get_question_type(q_type, form){
    
        $('.fn_'+form+'question_option_block').html('');  
        $('#'+form+'total_option').prop('selectedIndex', 0);
        
        if(q_type == 'single' || q_type == 'multi' || q_type == 'blank'){
            
            $('.fn_'+form+'total_option').show(); 
            
        }else if(q_type == 'boolean'){
            
            $('.fn_'+form+'total_option').hide(); 
            if(form = 'add_'){
                get_question_option(2, '', form);   
            }
            
        }else{
            $('.fn_'+form+'total_option').hide();            
        }
    }
    
    
    
    <?php if(isset($post) && $post['class_id'] != ''){ ?>       
        get_question_option('<?php echo $post['total_option']; ?>','', 'add_');
    <?php } ?>
    <?php if(isset($question) && !empty($question)){  ?>
        get_question_option('<?php echo $question->total_option; ?>', '<?php echo $question->id; ?>', 'edit_');
    <?php } ?>  
    function get_question_option(total_option, question_id, form){
       
       var school_id = $('#'+form+'school_id').val();       
             
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       var question_type = $('#'+form+'question_type').val();
       
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('onlineexam/question/get_question_option'); ?>",
            data   : {school_id:school_id, question_id : question_id, question_type : question_type, total_option : total_option},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#'+form+'total_option').prop('selectedIndex', total_option);
                   $('.fn_'+form+'question_option_block').html(response);                  
               }
            }
        });   
    }
    
    
    function set_single_radio(obj){
        $('.fn_single_hidden').val(0);
        $(obj).siblings('.fn_single_hidden').val(1);
    };
    
    function set_single_checkbox(obj){
        if ($(obj).is(':checked')) {
            $(obj).siblings('.fn_single_hidden').val(1);
        }else{
            $(obj).siblings('.fn_single_hidden').val(0);
        }
    };

 </script>

 
 <!-- datatable with buttons -->
 <script type="text/javascript">
        $(document).ready(function() {
          $('#datatable-responsive').DataTable( {
              dom: 'Bfrtip',
              iDisplayLength: 15,
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5',
                  'pageLength'
              ],
              search: true,              
              responsive: true
          });
        });
    
    $("#add").validate({
        rules:{
            "answer[]": { 
             required: true, 
             minlength: 1 
             },
             messages: {                
                "answer[]" : {
                    required: "You must check at least 1 box"
                }
           }
          }
    });     
    $("#edit").validate();   
</script>
 