<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-bell-o"></i><small> <?php echo $this->lang->line('manage_issue'); ?></small></h3>
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
                    <ul  class="nav nav-tabs bordered">
                        <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_issue_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php if(has_permission(ADD, 'inventory', 'issue')){ ?>
                             <?php if(isset($edit)){ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="<?php echo site_url('inventory/issue/add'); ?>"  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php }else{ ?>
                                <li  class="<?php if(isset($add)){ echo 'active'; }?>"><a href="#tab_add_issue"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('add'); ?> </a> </li>                          
                             <?php } ?>
                        <?php } ?> 
                        <?php if(isset($edit)){ ?>
                            <li  class="active"><a href="#tab_edit_issue"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?></a> </li>                          
                        <?php } ?>
                            
                        <li class="li-class-list">
                           <?php if($this->session->userdata('role_id') == SUPER_ADMIN){  ?>                                 
                                <select  class="form-control col-md-7 col-xs-12" onchange="get_issue_by_school(this.value);">
                                        <option value="<?php echo site_url('inventory/issue/index'); ?>">--<?php echo $this->lang->line('select_school'); ?>--</option> 
                                    <?php foreach($schools as $obj ){ ?>
                                        <option value="<?php echo site_url('inventory/issue/index/'.$obj->id); ?>" <?php if(isset($filter_school_id) && $filter_school_id == $obj->id){ echo 'selected="selected"';} ?> > <?php echo $obj->school_name; ?></option>
                                    <?php } ?>   
                                </select>
                            <?php } ?>  
                        </li>    
                                               
                    </ul>
                    <br/>
                    
                    <div class="tab-content">
                        
                        <div  class="tab-pane fade in <?php if(isset($list)){ echo 'active'; }?>" id="tab_issue_list" >
                            <div class="x_content">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('sl_no'); ?></th> 
                                        <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                            <th><?php echo $this->lang->line('school'); ?></th>
                                        <?php } ?>
                                        <th><?php echo $this->lang->line('category'); ?></th>
                                        <th><?php echo $this->lang->line('product'); ?></th>
                                        <th> <?php echo $this->lang->line('quantity'); ?></th>
                                        <th><?php echo $this->lang->line('user_type'); ?> </th>
                                        <th><?php echo $this->lang->line('issue_to'); ?></th>
                                        <th><?php echo $this->lang->line('issue_date'); ?> </th>
                                        <th><?php echo $this->lang->line('return_date'); ?></th>
                                        <th><?php echo $this->lang->line('action'); ?></th>                                            
                                    </tr>
                                </thead>
                                <tbody>   
                                                               
                                    <?php $count = 1; if(isset($issues) && !empty($issues)){ ?>
                                        <?php foreach($issues as $obj){ ?>                                       
                                        <tr>
                                            <td><?php echo $count++; ?></td> 
                                            <?php if($this->session->userdata('role_id') == SUPER_ADMIN){ ?>
                                                <td><?php echo $obj->school_name; ?></td>
                                            <?php } ?>
                                            <td><?php echo $obj->category; ?></td>
                                            <td><?php echo $obj->product; ?></td>
                                            <td><?php echo $obj->qty; ?></td>
                                            <td><?php echo $obj->role_name; ?></td>
                                             <td>
                                                <?php
                                                    $user = get_user_by_role($obj->role_id, $obj->user_id);
                                                    echo $user->name;
                                                    if($obj->role_id == STUDENT){
                                                        echo '<br/> [ '.$this->lang->line('class').': '.$user->class_name.', '. $this->lang->line('section').': '.$user->section.','. $this->lang->line('roll_no'). ':'. $user->roll_no . ']';
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo date($this->global_setting->date_format, strtotime($obj->issue_date)); ?></td>
                                            <td><?php echo $obj->return_date ? date($this->global_setting->date_format, strtotime($obj->return_date)) : '<a style="color:red;" href="javascript:void(0);" onclick="issue_check_out('.$obj->id.');">'.$this->lang->line('return_this').'</a>'; ?></td>                                           
                                            <td>                                                      
                                                <?php if(has_permission(VIEW, 'inventory', 'issue')){ ?>
                                                    <a  onclick="get_issue_modal(<?php echo $obj->id; ?>);"  data-toggle="modal" data-target=".bs-issue-modal-lg"  class="btn btn-success btn-xs"><i class="fa fa-eye"></i> <?php echo $this->lang->line('view'); ?> </a>
                                                <?php } ?>
                                                <?php if(has_permission(EDIT, 'inventory', 'issue')){ ?>
                                                    <?php if(!$obj->return_date){ ?>
                                                        <a href="<?php echo site_url('inventory/issue/edit/'.$obj->id); ?>" title="<?php echo $this->lang->line('edit'); ?>" class="btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> <?php echo $this->lang->line('edit'); ?> </a>
                                                    <?php } ?>
                                                <?php } ?> 
                                                <?php if(has_permission(DELETE, 'inventory', 'issue')){ ?>    
                                                    <a href="<?php echo site_url('inventory/issue/delete/'.$obj->id); ?>" onclick="javascript: return confirm('<?php echo $this->lang->line('confirm_alert'); ?>');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> <?php echo $this->lang->line('delete'); ?> </a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <div  class="tab-pane fade in <?php if(isset($add)){ echo 'active'; }?>" id="tab_add_issue">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('inventory/issue/add'), array('name' => 'add', 'id' => 'add', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                <?php $this->load->view('layout/school_list_form'); ?>
                                
                                <div class="item form-group"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id"> <?php echo $this->lang->line('user_type'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="role_id"  id="add_role_id" required="required" onchange="get_user_by_role(this.value, '');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                            <?php foreach($roles as $obj ){  ?>
                                                <?php if($this->session->userdata('role_id') != SUPER_ADMIN && $obj->id == SUPER_ADMIN ){ continue;} ?>
                                                 <?php if(in_array($obj->id, array(GUARDIAN))){ continue;} ?>
                                                <option value="<?php echo $obj->id; ?>" <?php echo isset($post['role_id']) && $post['role_id'] == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                            <?php } ?>                                            
                                        </select>
                                        <div class="help-block"><?php echo form_error('role_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group display"> 
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="class_id"  id="add_class_id"  onchange="get_user('', this.value,'');">
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                            <?php foreach($classes as $obj ){ ?>
                                            <option value="<?php echo $obj->id; ?>"  <?php echo isset($post['class_id']) && $post['class_id'] == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                            <?php } ?> 
                                        </select>
                                        <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                    </div>
                                </div>
                                    
                                <div class="item form-group">  
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id"><?php echo $this->lang->line('issue_to'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="add_user_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id"><?php echo $this->lang->line('category'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-7 col-xs-12"  name="category_id"  id="add_category_id" required="required" onchange="get_product_by_category(this.value, '', 'add');" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                            <?php if(isset($categories) && !empty($categories)){ ?>
                                                <?php foreach($categories as $obj){ ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($post['category_id']) && $post['category_id'] == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block"><?php echo form_error('category_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_id"><?php echo $this->lang->line('product'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select  class="form-control col-md-12 col-xs-12"  name="product_id"  id="add_product_id" required="required" >
                                            <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                        </select>
                                        <div class="help-block"><?php echo form_error('product_id'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty"><?php echo $this->lang->line('quantity'); ?> <span class="required">*</span> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="qty"  id="qty" value="<?php echo isset($post['qty']) ?  $post['qty'] : ''; ?>" placeholder="<?php echo $this->lang->line('quantity'); ?>" required="required" type="number">
                                        <div class="help-block"><?php echo form_error('qty'); ?></div>
                                    </div>
                                </div> 
                                                               
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="issue_date"><?php echo $this->lang->line('issue_date'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="issue_date"  id="add_issue_date" value="<?php echo isset($post['issue_date']) ?  $post['issue_date'] : ''; ?>" placeholder="<?php echo $this->lang->line('issue_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('issue_date'); ?></div>
                                    </div>
                                </div>
                                
                                <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date"><?php echo $this->lang->line('due_date'); ?> <span class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input  class="form-control col-md-7 col-xs-12"  name="due_date"  id="add_due_date" value="<?php echo isset($post['due_date']) ?  $post['due_date'] : ''; ?>" placeholder="<?php echo $this->lang->line('due_date'); ?>" required="required" type="text" autocomplete="off">
                                        <div class="help-block"><?php echo form_error('due_date'); ?></div>
                                    </div>
                                </div>
                                                                
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"><?php echo $this->lang->line('note'); ?></label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea  class="form-control" name="note" id="add_note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($post['note']) ?  $post['note'] : ''; ?></textarea>
                                        <div class="help-block"><?php echo form_error('note'); ?></div>
                                    </div>
                                </div> 
                                                                                             
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('inventory/issue/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                                        <button id="send" type="submit" class="btn btn-success"><?php echo $this->lang->line('submit'); ?></button>
                                    </div>
                                </div>
                                <?php echo form_close(); ?>
                            </div>
                        </div>  

                        <?php if(isset($edit)){ ?>
                            <div  class="tab-pane fade in <?php if(isset($edit)){ echo 'active'; }?>" id="tab_edit_issue">
                            <div class="x_content"> 
                               <?php echo form_open(site_url('inventory/issue/edit/'.$issue->id), array('name' => 'edit', 'id' => 'edit', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                
                                 <?php $this->load->view('layout/school_list_edit_form'); ?>  
                                
                                    <div class="item form-group"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="role_id"><?php echo $this->lang->line('user_type'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="role_id"  id="edit_role_id" required="required" onchange="get_user_by_role(this.value, '');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?> --</option> 
                                                <?php foreach($roles as $obj ){  ?>
                                                    <?php if($this->session->userdata('role_id') != SUPER_ADMIN && $obj->id == SUPER_ADMIN ){ continue;} ?>
                                                    <?php if(in_array($obj->id, array(GUARDIAN))){ continue;} ?>
                                                    <option value="<?php echo $obj->id; ?>" <?php echo isset($issue) && $issue->role_id == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?>                                            
                                            </select>
                                            <div class="help-block"><?php echo form_error('role_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group display"> 
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="class_id"><?php echo $this->lang->line('class'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="class_id"  id="edit_class_id"  onchange="get_user('', this.value,'');">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                <?php foreach($classes as $obj ){ ?>
                                                <option value="<?php echo $obj->id; ?>" <?php echo isset($issue) && $issue->class_id == $obj->id ? 'selected="selected"' : ''; ?>><?php echo $obj->name; ?></option>
                                                <?php } ?> 
                                            </select>
                                            <div class="help-block"><?php echo form_error('class_id'); ?></div>
                                        </div>
                                    </div>

                                    <div class="item form-group">  
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_id"><?php echo $this->lang->line('issue_to'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="user_id"  id="edit_user_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            </select>
                                            <div class="help-block"><?php echo form_error('user_id'); ?></div>
                                        </div>
                                    </div>
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_id"><?php echo $this->lang->line('category'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-7 col-xs-12"  name="category_id"  id="edit_category_id" required="required" onchange="get_product_by_category(this.value, '', 'edit');" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option> 
                                                <?php if(isset($categories) && !empty($categories)){ ?>
                                                    <?php foreach($categories as $obj){ ?>
                                                        <option value="<?php echo $obj->id; ?>" <?php if($issue->category_id == $obj->id){ echo 'selected="selected"';} ?>><?php echo $obj->name; ?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block"><?php echo form_error('category_id'); ?></div>
                                        </div>
                                    </div>
                                    
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="product_id"><?php echo $this->lang->line('product'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select  class="form-control col-md-12 col-xs-12"  name="product_id"  id="edit_product_id" required="required" >
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>                                                                                         
                                            </select>
                                            <div class="help-block"><?php echo form_error('product_id'); ?></div>
                                        </div>
                                    </div>
                                
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="qty"> <?php echo $this->lang->line('quantity'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                             <input  class="form-control col-md-7 col-xs-12"  name="qty"  id="edit_qty" value="<?php echo isset($issue->qty) ?  $issue->qty : ''; ?>" placeholder=" <?php echo $this->lang->line('quantity'); ?>" required="required" type="number">
                                             <div class="help-block"><?php echo form_error('qty'); ?></div>
                                        </div>
                                    </div>
                                                                                                      
                                    <div class="item form-group">
                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="issue_date"><?php echo $this->lang->line('issue_date'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="issue_date"  id="edit_issue_date" value="<?php echo isset($issue->issue_date) ?  date('d-m-Y', strtotime($issue->issue_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('issue_date'); ?>" required="required" type="text" autocomplete="off">
                                             <div class="help-block"><?php echo form_error('issue_date'); ?></div>
                                       </div>
                                    </div>
                                     
                                    <div class="item form-group">
                                       <label class="control-label col-md-3 col-sm-3 col-xs-12" for="due_date"><?php echo $this->lang->line('due_date'); ?> <span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input  class="form-control col-md-7 col-xs-12"  name="due_date"  id="edit_due_date" value="<?php echo isset($issue->due_date) ?  date('d-m-Y', strtotime($issue->due_date)) : ''; ?>" placeholder="<?php echo $this->lang->line('due_date'); ?>" required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('due_date'); ?></div>
                                       </div>
                                    </div>
                                                                    
                                
                                    <div class="item form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note"> <?php echo $this->lang->line('note'); ?> </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                         <textarea  class="form-control col-md-7 col-xs-12"  name="note"  id="note" placeholder="<?php echo $this->lang->line('note'); ?>"><?php echo isset($issue) ? $issue->note : ''; ?></textarea>
                                         <div class="help-block"><?php echo form_error('note'); ?></div>                                         
                                    </div>
                                    </div>
                                
                                    <div class="ln_solid"></div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-3">
                                            <input type="hidden" value="<?php echo isset($issue) ? $issue->qty : ''; ?>" id="old_qty" name="old_qty" />
                                            <input type="hidden" value="<?php echo isset($issue) ? $issue->product_id : ''; ?>" id="old_product_id" name="old_product_id" />
                                            <input type="hidden" value="<?php echo isset($issue) ? $issue->id : ''; ?>" id="id" name="id" />
                                            <a  href="<?php echo site_url('inventory/issue/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
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

<div class="modal fade bs-issue-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_issue_data">            
        </div>       
      </div>
    </div>
</div>

<script type="text/javascript">
         
    function get_issue_modal(issue_id){
         
        $('.fn_issue_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('inventory/issue/get_single_issue'); ?>",
          data   : {issue_id: issue_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_issue_data').html(response);
             }
          }
       });
    }
</script>

<script type="text/javascript">
      
    var form = 'add';
    $("document").ready(function() {
        <?php if(isset($issue) && !empty($issue)){ ?>
            form = 'edit';
            //$("#edit_school_id").trigger('change');
        <?php } ?>
    });
    
    $('.fn_school_id').on('change', function(){
      
        $('select#'+form+'_role_id').prop('selectedIndex', 0);        
        get_category_by_school(form);
        
        
       
        
        
    });
    
    
        <?php if(isset($issue)){ ?>
        get_category_by_school('edit');
    <?php } ?>
        
    function get_category_by_school(form){
    
        var school_id = $('#'+form+'_school_id').val();
        var category_id = '';
        
        <?php if(isset($issue) && !empty($issue)){ ?>
            category_id =  '<?php echo $issue->category_id; ?>';
        <?php } ?> 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
         $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/issue/get_category_by_school'); ?>",
            data   : { school_id:school_id, category_id:category_id},               
            async  : false,
            success: function(response){                                                   
                if(response)
                {  
                   $('#'+form+'_category_id').html(response);  
                }
            }
        });
    }
    
        
 </script>

<!-- bootstrap-datetimepicker -->
<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
 <script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
  
<script type="text/javascript">
    
    $('#add_issue_date').datepicker();
    $('#add_due_date').datepicker();
    $('#edit_issue_date').datepicker();
    $('#edit_due_date').datepicker();
    
   
    
    <?php if(isset($post)){ ?>
        get_product_by_category('<?php echo $post['category_id']; ?>', '<?php echo $post['product_id']; ?>','add');
    <?php } ?>        
    <?php if(isset($issue)){ ?>
        get_product_by_category('<?php echo $issue->category_id; ?>', '<?php echo $issue->product_id; ?>', 'edit');
    <?php } ?>        
    
    function get_product_by_category(category_id, product_id, form){       
         
        var school_id =  $('#'+form+'_school_id').val(); 
        
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
         
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/issue/get_product_by_category'); ?>",
            data   : { school_id : school_id, category_id : category_id,  product_id : product_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                    $('#'+form+'_product_id').html(response);
               }
            }
        });  
   }
   
</script>
 
 
 <script type="text/javascript">
   
    var form = 'add';   
   <?php if(isset($issue)){ ?> 
      form = 'edit';
   <?php } ?>
       
    <?php if(isset($post['role_id'])){ ?>  
         get_user_by_role('<?php echo $post['role_id']; ?>', '<?php echo $post['user_id']; ?>');
    <?php } ?>
        
    <?php if(isset($issue)){ ?>  
         get_user_by_role('<?php echo $issue->role_id; ?>', '<?php echo $issue->user_id; ?>');
    <?php } ?>
      
    function get_user_by_role(role_id, user_id){       
      
      
       if(role_id == <?php echo STUDENT; ?>){
           $('.display').show();
           $('#'+form+'_class_id').prop('required', true);
           
            <?php if(!isset($issue)){ ?> 
                $('select#'+form+'_class_id').prop('selectedIndex', 0);
             <?php } ?>            
           
           $('#'+form+'_user_id').html('<option value="">--<?php echo $this->lang->line('select'); ?>--</option>'); 
           get_class_by_school();
       }else{
           get_user(role_id, '', user_id);
           $('#'+form+'_class_id').prop('required', false);
           $('.display').hide();
       }
       
   }
   
   
    <?php if(isset($issue)){ ?> 
          get_user('', '<?php echo $issue->class_id; ?>', '<?php echo $issue->user_id; ?>');
    <?php } ?>
   
   function get_user(role_id, class_id, user_id){
       
       var school_id =  $('#'+form+'_school_id').val();
       if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
       
        if(role_id == ''){
            role_id = $('#'+form+'_role_id').val();
        }           
       
       $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_user_by_role'); ?>",
            data   : { school_id : school_id, role_id : role_id , class_id: class_id, user_id : user_id, message:false},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {
                   $('#'+form+'_user_id').html(response); 
               }
            }
        }); 
   }
   
   
   function issue_check_out(issue_id){      
           
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('inventory/issue/issue_check_out'); ?>",
            data   : { issue_id : issue_id},               
            async  : false,
            success: function(response){  
                if(response){
                     toastr.success('<?php echo $this->lang->line('update_success'); ?>');  
                      location.reload();
                }else{
                     toastr.error('<?php echo $this->lang->line('update_failed'); ?>');  
                }                               
            }
        });  
   }
   
      // done
   function get_class_by_school(){
        
        var school_id = $('#'+form+'_school_id').val();
        if(!school_id){
           toastr.error('<?php echo $this->lang->line("select_school"); ?>');
           return false;
        }
        
        $.ajax({       
            type   : "POST",
            url    : "<?php echo site_url('ajax/get_class_by_school'); ?>",
            data   : { school_id:school_id},               
            async  : false,
            success: function(response){                                                   
               if(response)
               {  
                    $('#'+form+'_class_id').html(response);                     
               }
            }
        });
   }
 
  
   
  
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
      
    $("#add").validate();   
    $("#edit").validate();   
    
    function get_issue_by_school(url){          
        if(url){
            window.location.href = url; 
        }
    }

</script> 
