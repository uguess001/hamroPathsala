<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('teacher'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('teacher'); ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="page-notice-area">
    <div class="container">
        <div class="row justify-content-center">
            <?php if(isset($teachers) && !empty($teachers)){ ?>
                <?php foreach($teachers as $obj){ ?>   
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-teacher">
                            <div class="top">
                                <div class="img">
                                    <?php if(isset($obj->photo) && !empty($obj->photo)){ ?>
                                        <img src="<?php echo UPLOAD_PATH; ?>teacher-photo/<?php echo $obj->photo; ?>" alt="">
                                    <?php }else{ ?>
                                        <img src="<?php echo IMG_URL; ?>default-user.png" alt="">
                                    <?php } ?>
                                </div>
                                <h4 class="title"><?php echo $obj->name; ?></h4>
                                <p class="category"><span class="inner"><?php echo $obj->department; ?></span></p>
                            </div>
                            <ul class="meta">
                                <li><span class="icon"><i class="fas fa-phone-volume"></i></span> <?php echo $obj->phone ? $obj->phone : '&nbsp;'; ?></li>
                                <li style="word-break: break-all;"><span class="icon"><i class="fas fa-envelope"></i></span> <?php echo $obj->email ? $obj->email : '&nbsp;'; ?></li>
                                <li><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $obj->present_address ? $obj->present_address : '&nbsp;'; ?></li>
                                <li><span class="icon"><i class="fas fa-tint"></i></span> <?php echo $obj->blood_group ? $this->lang->line($obj->blood_group) : '&nbsp;'; ?></li>
                            </ul>
                            <div class="bottom">
                                <ul class="social">
                                    <?php if($obj->facebook_url){ ?>
                                        <li><a target="_blank" href="<?php echo $obj->facebook_url; ?>"><i class="fab fa-facebook-f"></i></a></li>
                                    <?php } ?>
                                    <?php if($obj->linkedin_url){ ?>    
                                        <li><a target="_blank" href="<?php echo $obj->linkedin_url; ?>"><i class="fab fa-linkedin-in"></i></a></li>
                                     <?php } ?>
                                    <?php if($obj->twitter_url){ ?>
                                        <li><a target="_blank" href="<?php echo $obj->twitter_url; ?>"><i class="fab fa-twitter"></i></a></li>
                                     <?php } ?>                                    
                                    <?php if($obj->instagram_url){ ?>    
                                        <li><a target="_blank" href="<?php echo $obj->instagram_url; ?>"><i class="fab fa-instagram"></i></a></li>
                                     <?php } ?>
                                    <?php if($obj->pinterest_url){ ?>
                                        <li><a target="_blank" href="<?php echo $obj->pinterest_url; ?>"><i class="fab fa-pinterest"></i></a></li>
                                    <?php } ?>
                                    <?php if($obj->youtube_url){ ?>
                                        <li><a target="_blank" href="<?php echo $obj->youtube_url; ?>"><i class="fab fa-youtube"></i></a></li>
                                    <?php } ?>  
                                </ul>
                            </div>
                        </div>
                    </div> 

                <?php } ?>   
            <?php }else{ ?>
            
                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                    <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>
                </div>
            <?php } ?>
            
        </div>
    </div>
</div>