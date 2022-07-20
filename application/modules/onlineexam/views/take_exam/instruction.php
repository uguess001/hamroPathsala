<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-mouse-pointer"></i><small> <?php echo $this->lang->line('manage_take_exam'); ?> </small></h3>
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
                        
                        <?php if(isset($instruction)){ ?>
                            <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="<?php echo site_url('onlineexam/takeexam/index'); ?>"  aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php }else{ ?>
                            <li class="<?php if(isset($list)){ echo 'active'; }?>"><a href="#tab_exam_list"   role="tab" data-toggle="tab" aria-expanded="true"><i class="bi bi-view-list"></i> <?php echo $this->lang->line('list'); ?></a> </li>
                        <?php } ?>
                        
                        <?php if(has_permission(VIEW, 'onlineexam', 'takeexam')){ ?>
                            <?php if(isset($instruction)){ ?>
                                <li  class="<?php if(isset($instruction)){ echo 'active'; }?>"><a href=""  aria-expanded="false"><i class="bi bi-patch-plus-fill"></i> <?php echo $this->lang->line('instruction'); ?></a> </li>                          
                             <?php } ?>                               
                        <?php } ?>
                    </ul>
                    <br/>
                    
                    <div class="tab-content">                        

                        <div  class="tab-pane fade in <?php if(isset($instruction)){ echo 'active'; }?>" id="tab_exam_instruction">
                            
                            <div class="x_content"> 
                                
                                <div class="row instructions">
                                    <div class="col-md-12 col-sm-12 col-xs-12 theme-color"><i class="fa fa-check"></i> <?php echo $this->lang->line('warning'); ?></div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 theme-color"><i class="fa fa-check"></i> <?php echo $this->lang->line('do_not_press_back'); ?></div>
                                </div>
                                
                                <div class="row instructions">
                                    <div class="col-md-12 col-sm-12 col-xs-12 theme-color"><h3><i class="fa fa-check"></i> <?php echo $this->lang->line('exam_title'); ?>: <?php echo $online_exam->title; ?></h3></div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 theme-color"><h3><i class="fa fa-check"></i> <?php echo $this->lang->line('instruction'); ?>:</h3> <?php echo $online_exam->instruction; ?></div>
                                </div>                                                        
                                                              
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-3">
                                        <a href="<?php echo site_url('onlineexam/takeexam/start/'. $online_exam->id); ?>" class="btn btn-success btn-md"><?php echo $this->lang->line('start_exam'); ?></a>
                                    </div>
                                </div>                                                             
                            </div>
                            
                        </div>                                                 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>