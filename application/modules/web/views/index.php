<div class="hero-area">
    <div class="hero-carousel owl-carousel">
        <?php if(isset($sliders) && !empty($sliders)){ ?>    
            <?php foreach($sliders AS $obj ){ ?>
                <div class="single-hero-carousel">
                    <div class="img">
                        <img src="<?php echo UPLOAD_PATH; ?>slider/<?php echo $obj->image; ?>" alt="">
                    </div>
                    <div class="box">
                        <h2 class="title-1"><?php echo $this->lang->line('welcome_to'); ?></h2>
                        <h2 class="title-2">
                            <?php if($obj->title != ''){ ?>
                            <?php echo $obj->title; ?>
                            <?php }elseif(isset($school->school_name)){ ?>
                                <?php echo $school->school_name; ?>
                            <?php }else{ ?>
                                <?php echo SMS; ?>
                            <?php } ?>
                        </h2>
                        <a href="<?php echo site_url($school->school_url.'/admission-online'); ?>" class="button btn-hvr"><?php echo $this->lang->line('admission'); ?></a>
                    </div>
                </div>
            <?php } ?>
        <?php }else{ ?>
                <div class="single-hero-carousel">
                    <div class="img">
                        <img src="<?php echo IMG_URL; ?>default-slider.jpg" alt="">
                    </div>
                    <div class="box">
                        <h2 class="title-1"><?php echo $this->lang->line('welcome_to'); ?></h2>
                        <h2 class="title-2">                            
                           <?php echo SMS; ?>                           
                        </h2>
                        <a href="<?php echo site_url($school->school_url.'/admission-online'); ?>" class="button btn-hvr"><?php echo $this->lang->line('admission'); ?></a>
                    </div>
                </div>
        <?php } ?>
    </div>
</div>


<?php if(isset($school->about_text) && !empty($school->about_text)){ ?>
   <div class="welcome-area">
        <div class="container">
            <div class="row">
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
                            <?php echo nl2br(strip_tags(substr($school->about_text, 0, 550))); ?>...   
                        </p>
                        <div class="button-wrapper">
                            <a href="<?php echo site_url($school->school_url.'/about'); ?>" class="button btn-hvr"><?php echo $this->lang->line('read_more'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

   
<div class="facilities-area">
    <div class="container">
        <div class="section-title white">
            <h2 class="title">
                <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt=""> 
                <?php echo $this->lang->line('our_facilities'); ?>               
            </h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-facilities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/facilities-teacher.png" alt="">                      
                    </div>
                    <div class="content">
                        <h4 class="title"><?php echo $this->lang->line('teacher'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-facilities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/facilities-library.png" alt="">
                    </div>
                    <div class="content">
                        <h4 class="title"><?php echo $this->lang->line('library'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-facilities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/facilities-transport.png" alt="">
                    </div>
                    <div class="content">
                        <h4 class="title"><?php echo $this->lang->line('transport'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-facilities">
                    <div class="icon">
                        <img src="<?php echo IMG_URL; ?>front/facilities-hostel.png" alt="">
                    </div>
                    <div class="content">
                        <h4 class="title"><?php echo $this->lang->line('hostel'); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<?php if(isset($events) && !empty($events)){ ?>
    <div class="event-area">
        <div class="container">
            <div class="section-title">
                <h2 class="title">
                    <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt="">
                    <?php echo $this->lang->line('latest_event'); ?>
                </h2>
            </div>
            <div class="row justify-content-center">
                <?php foreach($events AS $obj){  ?>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-event">
                            <div class="img">
                                <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>event/<?php echo $obj->image; ?>" alt="">
                                <?php }else{ ?>
                                    <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                                <?php } ?>
                            </div>
                            <ul class="meta">
                                <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $obj->event_for ? $obj->event_for : $this->lang->line('all'); ?> (<?php echo $this->lang->line('event_for'); ?>)</li>
                                <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->event_from)); ?> <?php echo $this->lang->line('to'); ?> <?php echo date($this->global_setting->date_format, strtotime($obj->event_to)); ?></li>
                                <li><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $obj->event_place; ?></li>
                            </ul>
                            <div class="content">
                                <a href="<?php echo site_url($school->school_url.'/event-detail/'.$obj->id); ?>">
                                    <h2 class="title"><?php echo strip_tags(substr($obj->title, 0, 20)); ?>...</h2>
                                </a>
                                <p class="text">
                                    <?php echo strip_tags(substr($obj->note, 0, 160)); ?>...  
                                </p>
                                <div class="more-wrapper">
                                    <a href="<?php echo site_url($school->school_url.'/event-detail/'.$obj->id); ?>" class="more"><?php echo $this->lang->line('read_more'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div> 
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>


<div class="achivement-area">
    <div class="container">
        <div class="section-title white">
            <h2 class="title">
                <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt=""> 
                <?php echo $this->lang->line('our_achievement'); ?>
            </h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                          <i class="fa fa-user-md"></i>
                    </div>
                    <div class="content">
                        <h3 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30"><?php echo $teacher; ?></h3>
                        <h4 class="title"><?php echo $this->lang->line('teacher'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="content">
                        <h3 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30"><?php echo $student; ?></h3>
                        <h4 class="title"><?php echo $this->lang->line('student'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                        <i class="fa fa-paw"></i>
                    </div>
                    <div class="content">
                        <h3 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30"><?php echo $staff; ?></h3>
                        <h4 class="title"><?php echo $this->lang->line('staff'); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="single-achivement">
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="content">
                        <h3 class="counter counter-up" data-counterup-time="1500" data-counterup-delay="30"><?php echo $user; ?></h3>
                        <h4 class="title"><?php echo $this->lang->line('user'); ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if(isset($news) && !empty($news)){ ?>
<div class="news-area">
    <div class="container">
        <div class="section-title">
            <h2 class="title">
                <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt=""> 
                <?php echo $this->lang->line('latest_news'); ?>
            </h2>
        </div>
        <div class="row justify-content-center">
            <?php foreach($news AS $obj){ ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-news">
                        <div class="img">
                            <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $obj->image; ?>" alt="">
                            <?php }else{ ?>
                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                            <?php } ?>  
                        </div>
                        <ul class="meta">
                            <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></li>
                            <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></li>
                        </ul>
                        <div class="content">
                            <a href="<?php echo site_url($school->school_url.'/news-detail/'.$obj->id); ?>">
                                <h2 class="title"><?php echo strip_tags(substr($obj->title, 0, 20)); ?> ...</h2>
                            </a>
                            <p class="text">
                               <?php echo strip_tags(substr($obj->news, 0, 160)); ?> ...
                            </p>
                            <div class="more-wrapper">
                                <a href="<?php echo site_url($school->school_url.'/news-detail/'.$obj->id); ?>" class="more"><?php echo $this->lang->line('read_more'); ?></a>
                            </div>
                        </div>
                    </div>
                </div> 
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>

<?php if(isset($feedbacks) && !empty($feedbacks)){ ?>
<div class="testimonial-area">
    <div class="container">
        <div class="section-title white">
            <h2 class="title">
                <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt="">
                <?php echo $this->lang->line('what_guardian_say'); ?>
            </h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="testimonial-carousel owl-carousel">
                    <?php foreach($feedbacks AS $obj){ ?> 
                        <div class="single-testimonial">
                            <div class="author-thumb">
                                <?php if(isset($obj->photo) && !empty($obj->photo)){ ?>
                                    <img src="<?php echo UPLOAD_PATH; ?>guardian-photo/<?php echo $obj->photo; ?>" alt="">
                                <?php }else{ ?>
                                    <img src="<?php echo IMG_URL; ?>default-user.png" alt="">
                                <?php } ?>
                            </div>
                            <h4 class="author-name"><span class="inner"><?php echo $obj->name; ?></span></h4>
                            <p class="text">
                                <?php echo $obj->feedback; ?>
                            </p>
                        </div>  
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>