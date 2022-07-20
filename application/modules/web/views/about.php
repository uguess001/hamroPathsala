<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('about_school'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('about_school'); ?></a></li>
            </ul>
        </div>
    </div>
</div>
<?php if(isset($school->about_text) && !empty($school->about_text)){ ?>
   <div class="welcome-area">
        <div class="container">
            <div class="row">
                <?php if(isset($school->about_image) && !empty($school->about_image)){ ?>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="welcome-banner">
                        <?php if(isset($school->about_image) && !empty($school->about_image)){ ?>
                        <img class="wb-banner" src="<?php echo UPLOAD_PATH; ?>about/<?php echo $school->about_image; ?>" alt="">
                        <?php }else{ ?>
                            <img class="wb-banner" src="<?php echo IMG_URL; ?>about-image.jpg" alt="">
                        <?php } ?>  
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1_ col-md-6 col-12">
                    <div class="welcome-content">
                        <h2 class="title"><?php echo $this->lang->line('welcome_to'); ?></h2>
                        <h2 class="title-2">
                            <?php if(isset($school->school_name)){ ?>
                                <?php echo $school->school_name; ?>
                            <?php }else{ ?>
                                  <?php echo SMS; ?>
                            <?php } ?>
                        </h2>
                        <p class="text">
                            <?php echo nl2br($school->about_text); ?>  
                        </p>                        
                    </div>
                </div>
                <?php }else{ ?>
                    <div class="col-lg-10 offset-lg-1 col-md-12 col-12">
                        <div class="welcome-content">
                            <h2 class="title"><?php echo $this->lang->line('welcome_to'); ?></h2>
                            <h2 class="title-2">
                                <?php if(isset($school->school_name)){ ?>
                                    <?php echo $school->school_name; ?>
                                <?php }else{ ?>
                                      <?php echo SMS; ?>
                                <?php } ?>
                            </h2>
                            <p class="text">
                                <?php echo nl2br($school->about_text); ?>  
                            </p>                        
                        </div>
                    </div>
                <?php } ?>
                
            </div>
        </div>
    </div>
<?php } ?>
