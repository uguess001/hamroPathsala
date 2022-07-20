<div class="apply-area no-print">
    <div class="container">
        <div class="apply-box">
            <div class="row">
                <div class="col-md-7 col-12">
                    <div class="content">
                        <h2 class="title"><?php echo $this->lang->line('apply_now_for_your_kid'); ?></h2>
                    </div>
                </div>
                <div class="col-md-5 col-12">
                    <div class="apply">
                        <a href="<?php echo site_url($school->school_url.'/admission-online'); ?>">
                            <span class="icon">
                                <i class="fa fa-location-arrow"></i>
                            </span>
                            <?php echo $this->lang->line('apply_now'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="no-print">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-7 col-12">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <?php if(isset($school->frontend_logo)){ ?>                            
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->frontend_logo; ?>" alt=""  />
                            <?php }elseif(isset($school->logo)){ ?> 
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $school->logo; ?>" alt=""  />
                            <?php }else{ ?>
                                 <img src="<?php echo IMG_URL; ?>default-front-logo.png" alt=""  />
                            <?php } ?>
                        </div>
                        <p class="text">
                            <?php if(isset($school->about_text) && !empty($school->about_text)){ ?>
                                <?php echo strip_tags(substr($school->about_text, 0, 350)); ?>
                            <?php } ?>  
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-5 col-12">
                    <div class="footer-widget">
                        <h3 class="title"><?php echo $this->lang->line('quick_link'); ?></h3>
                        <ul class="links">
                            <li><a href="<?php echo site_url($school->school_url.'/admission-online'); ?>"><?php echo $this->lang->line('admission'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/news'); ?>"><?php echo $this->lang->line('news'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/notice'); ?>"><?php echo $this->lang->line('notice'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/holiday'); ?>"><?php echo $this->lang->line('holiday'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/events'); ?>"><?php echo $this->lang->line('event'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/galleries'); ?>"><?php echo $this->lang->line('gallery'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/teachers'); ?>"><?php echo $this->lang->line('teacher'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/staff'); ?>"><?php echo $this->lang->line('staff'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/faq'); ?>"><?php echo $this->lang->line('faq'); ?></a></li>
                            <li><a href="<?php echo site_url($school->school_url.'/contact'); ?>"><?php echo $this->lang->line('contact_us'); ?></a></li>
                            <?php if(isset($footer_pages) && !empty($footer_pages)){ ?>
                               <?php foreach($footer_pages AS $obj ){ ?>
                                    <li><a href="<?php echo site_url($school->school_url.'/page/'.$obj->page_slug); ?>"><?php echo $obj->page_title; ?></a></li>
                                <?php } ?> 
                            <?php } ?>                             
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="footer-widget">
                        <h3 class="title"><?php echo $this->lang->line('opening_hour'); ?></h3>
                        <ul class="hours">
                            
                            <?php if(isset($opening_hour) && !empty($opening_hour->monday)){ ?>
                                <li><?php echo $this->lang->line('monday'); ?> <span class="what-time"><?php echo $opening_hour->monday; ?></span></li>
                            <?php }else{ ?> 
                                <li><?php echo $this->lang->line('monday'); ?> <span class="what-time"><?php echo $this->lang->line('closed'); ?></span></li>
                            <?php } ?>
                                
                            <?php if(isset($opening_hour) && !empty($opening_hour->tuesday)){ ?>
                                <li><?php echo $this->lang->line('tuesday'); ?> <span class="what-time"><?php echo $opening_hour->tuesday; ?></span></li>
                             <?php }else{ ?> 
                                <li><?php echo $this->lang->line('tuesday'); ?> <span class="what-time"><?php echo $this->lang->line('closed'); ?></span></li>
                            <?php } ?> 
                                
                            <?php if(isset($opening_hour) && !empty($opening_hour->wednesday)){ ?>
                                <li><?php echo $this->lang->line('wednesday'); ?>  <span class="what-time"><?php echo $opening_hour->wednesday; ?></span></li>
                             <?php }else{ ?> 
                                <li><?php echo $this->lang->line('wednesday'); ?> <span class="what-time"><?php echo $this->lang->line('closed'); ?></span></li>
                            <?php } ?>  
                                
                            <?php if(isset($opening_hour) && !empty($opening_hour->thursday)){ ?>
                                <li><?php echo $this->lang->line('thursday'); ?> <span class="what-time"><?php echo $opening_hour->wednesday; ?></span></li>
                             <?php }else{ ?> 
                                <li><?php echo $this->lang->line('thursday'); ?> <span class="what-time"><?php echo $this->lang->line('closed'); ?></span></li>
                            <?php } ?>
                                
                            <?php if(isset($opening_hour) && !empty($opening_hour->friday)){ ?>
                                <li><?php echo $this->lang->line('friday'); ?> <span class="what-time"><?php echo $opening_hour->friday; ?></span></li>
                             <?php }else{ ?> 
                                <li><?php echo $this->lang->line('friday'); ?> <span class="what-time"><?php echo $this->lang->line('closed'); ?></span></li>
                            <?php } ?>  
                                
                            <?php if(isset($opening_hour) && !empty($opening_hour->saturday)){ ?>
                                <li><?php echo $this->lang->line('saturday'); ?> <span class="what-time"><?php echo $opening_hour->saturday; ?></span></li>
                             <?php }else{ ?> 
                                <li><?php echo $this->lang->line('saturday'); ?> <span class="what-time"><?php echo $this->lang->line('closed'); ?></span></li>
                            <?php } ?>  
                                
                            <?php if(isset($opening_hour) && !empty($opening_hour->sunday)){ ?>
                                <li><?php echo $this->lang->line('sunday'); ?> <span class="what-time"><?php echo $opening_hour->sunday; ?></span></li>
                             <?php }else{ ?> 
                                <li><?php echo $this->lang->line('sunday'); ?> <span class="what-time"><?php echo $this->lang->line('closed'); ?></span></li>
                            <?php } ?>  
                        </ul>                      
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="footer-widget">
                        <h3 class="title"><?php echo $this->lang->line('get_in_touch'); ?></h3>
                        <ul class="contact-info">                                                          
                            <?php if(isset($school->phone)){ ?>                                
                             <li> <a href="tel:<?php echo $school->phone; ?>"><span class="icon"><i class="fas fa-phone"></i></span> <?php echo $school->phone; ?></a></li>
                            <?php } ?>
                             <?php if(isset($school->email)){ ?>                                
                             <li><a href="mailto:<?php echo $school->email; ?>"><span class="icon"><i class="fas fa-envelope"></i></span> <?php echo $school->email; ?></a></li>
                            <?php } ?>
                            <?php if(isset($school->address)){ ?>                                
                             <li><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $school->address; ?></li>
                            <?php } ?>                            
                        </ul>
                        <ul class="social">
                            <?php if(isset($school->facebook_url) && !empty($school->facebook_url)){ ?>
                                <li><a href="<?php echo $school->facebook_url; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <?php } ?> 
                            <?php if(isset($school->twitter_url)  && !empty($school->twitter_url)){ ?>
                                <li><a href="<?php echo $school->twitter_url; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <?php } ?>                             
                            <?php if(isset($school->linkedin_url)  && !empty($school->linkedin_url)){ ?>
                                <li><a href="<?php echo $school->linkedin_url; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                            <?php } ?>                   
                            <?php if(isset($school->youtube_url)  && !empty($school->youtube_url)){ ?>
                                <li><a href="<?php echo $school->youtube_url; ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                            <?php } ?>                              
                            <?php if(isset($school->instagram_url)  && !empty($school->instagram_url)){ ?>
                                <li><a href="<?php echo $school->instagram_url; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <?php } ?>                              
                            <?php if(isset($school->pinterest_url)  && !empty($school->pinterest_url)){ ?>
                                <li><a href="<?php echo $school->pinterest_url; ?>" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                            <?php } ?>                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="copyright">
                <p class="text">
                    <?php if(isset($school->footer)){ ?>                            
                    <?php echo $school->footer; ?>
                    <?php }else{ ?>
                        <?php echo $this->global_setting->brand_footer; ?>
                    <?php } ?> 
                </p>
            </div>
        </div>
    </div>
</footer>