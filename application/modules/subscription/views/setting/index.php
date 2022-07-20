<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h3 class="head-title"><i class="fa fa-gears "></i><small> <?php echo $this->lang->line('subscription_setting'); ?></small></h3>
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
                        <li  class="active"><a href="#tab_setting"  role="tab"  data-toggle="tab" aria-expanded="false"><i class="fa fa-gear"></i> <?php echo $this->lang->line('setting'); ?></a> </li> 
                     </ul>
                     <br/>
                     <div class="tab-content">
                         <div class="tab-pane fade in active"id="tab_setting">
                            <div class="x_content"> 
                                <?php $action = isset($setting) ? 'edit' : 'add'; ?>
                                <?php echo form_open_multipart(site_url('subscription/setting/'. $action), array('name' => 'setting', 'id' => 'setting', 'class'=>'form-horizontal form-label-left'), ''); ?>
                                <input type="hidden" value="<?php echo isset($setting) ? $setting->id : ''; ?>" name="id" />                               
                                          
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('basic_information'); ?>:</strong></h5>
                                    </div>
                                </div>                            
                                
                                <div class="row">
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="phone"><?php echo $this->lang->line('phone'); ?></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="phone"  id="phone" value="<?php echo isset($setting) ? $setting->phone : ''; ?>" placeholder="<?php echo $this->lang->line('phone'); ?> "  type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('phone'); ?></div> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="email"><?php echo $this->lang->line('email'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="email"  id="email" value="<?php echo isset($setting) ? $setting->email : ''; ?>" placeholder="<?php echo $this->lang->line('email'); ?>" required="required" type="email" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('email'); ?></div> 
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="address"><?php echo $this->lang->line('address'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="address"  id="address" value="<?php echo isset($setting) ? $setting->address : ''; ?>" placeholder="<?php echo $this->lang->line('address'); ?> " required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('address'); ?></div> 
                                        </div>
                                    </div>   
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="our_location"><?php echo $this->lang->line('google_map'); ?> <span class="required">*</span></label>
                                            <textarea  class="form-control col-md-6 col-xs-12 textarea-4column"  name="our_location"  id="our_location" placeholder="<?php echo $this->lang->line('google_map'); ?>"><?php echo isset($setting) ?  $setting->our_location : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('our_location'); ?></div> 
                                        </div>
                                    </div>                                    
                                    
                                    
                                </div>
                                
                                <div class="row">    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="opening_day"><?php echo $this->lang->line('opening_day'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="opening_day"  id="opening_day" value="<?php echo isset($setting) ? $setting->opening_day : ''; ?>" placeholder="<?php echo $this->lang->line('opening_day'); ?> " required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('opening_day'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="opening_hour"><?php echo $this->lang->line('opening_hour'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="opening_hour"  id="opening_hour" value="<?php echo isset($setting) ? $setting->opening_hour : ''; ?>" placeholder="<?php echo $this->lang->line('opening_hour'); ?> " required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('opening_hour'); ?></div> 
                                        </div>
                                    </div>                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="demo_video"><?php echo $this->lang->line('demo_video'); ?> <span class="required">*</span></label>
                                            <select  class="form-control col-md-7 col-xs-12"  name="demo_video"  id="demo_video" required="required">
                                                <option value="">--<?php echo $this->lang->line('select'); ?>--</option>  
                                                    <option value="youtube" <?php echo isset($setting) && $setting->demo_video == 'youtube' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('youtube'); ?></option>
                                                    <option value="vimeo" <?php echo isset($setting) && $setting->demo_video == 'vimeo' ?  'selected="selected"' : ''; ?>><?php echo $this->lang->line('vimeo'); ?></option>
                                            </select>
                                            <div class="help-block"><?php echo form_error('demo_video'); ?></div> 
                                        </div>
                                    </div> 
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="video_id"><?php echo $this->lang->line('video_id'); ?> <span class="required">*</span></label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="video_id"  id="video_id" value="<?php echo isset($setting) ? $setting->video_id : ''; ?>" placeholder="<?php echo $this->lang->line('video_id'); ?> " required="required" type="text" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('video_id'); ?></div> 
                                        </div>
                                    </div>    
                                                                                      
                                   
                                </div>  
                                
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item form-group">
                                            <label for="footer_note"><?php echo $this->lang->line('footer_note'); ?> <span class="required">*</span></label>
                                            <textarea  class="form-control col-md-6 col-xs-12 textarea-4column"  name="footer_note"  id="footer_note" placeholder="<?php echo $this->lang->line('footer_note'); ?>"><?php echo isset($setting) ?  $setting->footer_note : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('footer_note'); ?></div> 
                                        </div>
                                    </div>                                     
                                    
                                   <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="item form-group">
                                            <label for="about_brand"><?php echo $this->lang->line('about_brand'); ?> <span class="required">*</span></label>
                                            <textarea  class="form-control col-md-6 col-xs-12 textarea-4column"  name="about_brand"  id="our_location" placeholder="<?php echo $this->lang->line('about_brand'); ?>"><?php echo isset($setting) ?  $setting->about_brand : ''; ?></textarea>
                                            <div class="help-block"><?php echo form_error('about_brand'); ?></div> 
                                        </div>
                                    </div>  
                                </div>
                                    
                                                                
                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('social_link'); ?>:</strong></h5>
                                    </div>
                                </div>
                                
                                <div class="row">
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="facebook_url"><?php echo $this->lang->line('facebook_url'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="facebook_url"  id="facebook_url" value="<?php echo isset($setting) ? $setting->facebook_url : ''; ?>" placeholder="<?php echo $this->lang->line('facebook_url'); ?> " type="url"  autocomplete="off">
                                            <div class="help-block"><?php echo form_error('facebook_url'); ?></div> 
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="twitter_url"><?php echo $this->lang->line('twitter_url'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="twitter_url"  id="twitter_url" value="<?php echo isset($setting) ? $setting->twitter_url : ''; ?>" placeholder="<?php echo $this->lang->line('twitter_url'); ?> " type="url" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('twitter_url'); ?></div> 
                                        </div>
                                    </div>
                                     <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="linkedin_url"><?php echo $this->lang->line('linkedin_url'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="linkedin_url"  id="linkedin_url" value="<?php echo isset($setting) ? $setting->linkedin_url : ''; ?>" placeholder="<?php echo $this->lang->line('linkedin_url'); ?> " type="url" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('linkedin_url'); ?></div> 
                                        </div>
                                    </div>                                                                                                           
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="youtube_url"><?php echo $this->lang->line('youtube_url'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="youtube_url"  id="youtube_url" value="<?php echo isset($setting) ? $setting->youtube_url : ''; ?>" placeholder="<?php echo $this->lang->line('youtube_url'); ?> " type="url" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('youtube_url'); ?></div> 
                                        </div>
                                    </div>
                                </div>    
                                    
                                <div class="row">    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="instagram_url"><?php echo $this->lang->line('instagram_url'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="instagram_url"  id="instagram_url" value="<?php echo isset($setting) ? $setting->instagram_url : ''; ?>" placeholder="<?php echo $this->lang->line('instagram_url'); ?> " type="url" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('instagram_url'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="pinterest_url"><?php echo $this->lang->line('pinterest_url'); ?> </label>
                                            <input  class="form-control col-md-7 col-xs-12"  name="pinterest_url"  id="pinterest_url" value="<?php echo isset($setting) ? $setting->pinterest_url : ''; ?>" placeholder="<?php echo $this->lang->line('pinterest_url'); ?> " type="url" autocomplete="off">
                                            <div class="help-block"><?php echo form_error('pinterest_url'); ?></div> 
                                        </div>
                                    </div>                                    
                                </div>

                                <div class="row">                  
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h5  class="column-title"><strong><?php echo $this->lang->line('other_information'); ?>:</strong></h5>
                                    </div>
                                </div>
                                
                                <div class="row">                             
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="logo"><?php echo $this->lang->line('about_image'); ?></label>
                                            <div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="about_image" id="about_image"  type="file">
                                            </div>
                                            <?php if(isset($setting->about_image) && $setting->about_image != ''){ ?>
                                               <img  class="logo-identifier" src="<?php echo UPLOAD_PATH; ?>/about/<?php echo $setting->about_image; ?>" alt="" width="70"/><br/><br/>
                                               <input name="about_image_prev" value="<?php echo isset($setting) ? $setting->about_image : ''; ?>"  type="hidden">
                                           <?php } ?>
                                            <div class="help-block"><?php echo form_error('about_image'); ?></div> 
                                        </div>
                                    </div>     
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="logo"><?php echo $this->lang->line('header_logo'); ?></label>
                                            <div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="brand_logo_header" id="brand_logo_header"  type="file">
                                            </div>
                                            <?php if(isset($setting->brand_logo_header) && $setting->brand_logo_header != ''){ ?>
                                               <img  class="logo-identifier" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->brand_logo_header; ?>" alt="" width="70"/><br/><br/>
                                                <input name="brand_logo_header_prev" value="<?php echo isset($setting) ? $setting->brand_logo_header : ''; ?>"  type="hidden">
                                           <?php } ?>
                                            <div class="help-block"><?php echo form_error('brand_logo_header'); ?></div> 
                                        </div>
                                    </div>                                   
                                    
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="logo"><?php echo $this->lang->line('footer_logo'); ?></label>
                                            <div class="btn btn-default btn-file"><i class="fa fa-paperclip"></i> <?php echo $this->lang->line('upload'); ?>
                                                <input  class="form-control col-md-7 col-xs-12"  name="brand_logo_footer" id="brand_logo_footer"  type="file">
                                            </div>
                                            <?php if(isset($setting->brand_logo_footer) && $setting->brand_logo_footer != ''){ ?>
                                            <img class="logo-identifier" src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->brand_logo_footer; ?>" alt="" width="70"/><br/><br/>
                                                <input name="brand_logo_footer_prev" value="<?php echo isset($setting) ? $setting->brand_logo_footer : ''; ?>"  type="hidden">
                                            <?php } ?>
                                            <div class="help-block"><?php echo form_error('brand_logo_footer'); ?></div> 
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="logo">&nbsp;</label>
                                           
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <div class="item form-group">
                                            <label for="logo">&nbsp;</label>
                                            
                                        </div>
                                    </div>
                                    
                                </div>                                 

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <input type="hidden" value="<?php echo isset($setting) ? $setting->id : '' ?>" name="id" />
                                        <button id="send" type="submit" class="btn btn-success"><?php  echo $this->lang->line('update'); ?></button>
                                    </div>
                                </div>

                                <?php echo form_close(); ?>
                            </div>  
                        </div>  
                     </div>
                </div>
             </div>
        </div>
    </div>
</div>

<link href="<?php echo VENDOR_URL; ?>datepicker/datepicker.css" rel="stylesheet">
<script src="<?php echo VENDOR_URL; ?>datepicker/datepicker.js"></script>
<script type="text/javascript">     
    $("#setting").validate();  
</script>