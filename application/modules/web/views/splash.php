<!DOCTYPE html>
<html lang="en">

    <head>
        <!--- Basic Page Needs  -->
        <meta charset="utf-8">       
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Mobile Specific Meta  -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <title><?php echo $title_for_layout; ?></title> 
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keywords" content="">
        <?php if($this->global_setting->favicon_icon){ ?>
            <link rel="icon" href="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->favicon_icon; ?>" type="image/x-icon" />             
        <?php }else{ ?>
            <link rel="icon" href="<?php echo IMG_URL; ?>favicon.ico" type="image/x-icon" />
        <?php } ?>
       
        <!-- CSS -->
         <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/jquery-ui.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/fontawesome-all.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/animate.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/saas-stellarnav.min.css">
        
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/saas-style.css">
        <link rel="stylesheet" href="<?php echo CSS_URL; ?>front/saas-responsive.css">
      
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
        
        <script src="<?php echo JS_URL; ?>front/jquery-3.3.1.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery-ui.js"></script>
        <script src="<?php echo JS_URL; ?>jquery.validate.js"></script>
    </head>

    <body>
        <div id="preloader"></div>
        <header>
            <div class="container container-big">
                <div class="row">
                    <div class="col-xl-2 col-lg-2 col-6">
                        <div class="logo">
                            <a href="<?php echo base_url(); ?>">
                                <?php if(isset($setting->brand_logo_header)){ ?>                             
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->brand_logo_header; ?>" alt=""  />
                                <?php }elseif(isset($this->global_setting->logo)){ ?>  
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->logo; ?>" alt=""  />
                                <?php }else{ ?>
                                    <img src="<?php echo IMG_URL; ?>default-front-logo.png" alt=""  />
                                <?php } ?> 
                            </a>
                        </div>
                    </div>
                    <div class="col-xl-10 col-lg-10 col-6">
                        <div class="stellarnav">
                            <ul>
                                <li><a class="smoothscroll" href="#_about"><?php echo $this->lang->line('about_brand'); ?></a></li>
                                <li><a class="smoothscroll" href="#_video"><?php echo $this->lang->line('demo_video'); ?></a></li>
                                <li><a class="smoothscroll" href="#_faq"><?php echo $this->lang->line('faq'); ?></a></li>
                                <li><a class="smoothscroll" href="#_pricing"><?php echo $this->lang->line('pricing_plan'); ?></a></li>
                                <li><a class="smoothscroll" href="#_subscription"><?php echo $this->lang->line('subscription'); ?></a></li>
                                <li><a class="smoothscroll" href="#_feature"><?php echo $this->lang->line('features'); ?></a></li>
                                <li><a class="smoothscroll" href="#_contact"><?php echo $this->lang->line('contact'); ?></a></li>
                                <?php if(isset($school) && !empty($school)){ ?>
                                    <li><a class="visit-school" href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('visit_school'); ?></a></li>
                                <?php } ?>  
                                <?php if (logged_in_user_id()) { ?>     
                                    <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a></li>
                                <?php }else{ ?> 
                                    <li><a href="<?php echo site_url('auth/login'); ?>" target="_blank"><?php echo $this->lang->line('login'); ?></a></li>
                                <?php } ?> 
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-12">
                        <?php $this->load->view('layout/message'); ?>
                    </div>
                </div>
            </div>
        </header>
        
        <section class="hero-area hero-carousel owl-carousel" id="_hero">
            <?php if(isset($sliders) && !empty($sliders)){ ?>
                <?php foreach($sliders as $obj){ ?>
                    <div class="single-carousel">
                        <div class="img"><img src="<?php echo UPLOAD_PATH; ?>slider/<?php echo $obj->image; ?>" alt=""></div>
                        <div class="content">
                            <h2 class="title"><?php echo $obj->title; ?></h2>
                        </div>
                    </div>  
                <?php } ?>
            <?php }else{ ?>
                <div class="single-carousel">
                    <div class="img"><img src="<?php echo IMG_URL; ?>front/default-saas-hero.jpg" alt=""></div>
                    <div class="content">
                        <h2 class="title"><?php echo $title_for_layout; ?></h2>
                    </div>
                </div> 
            <?php } ?>
            
        </section>
        
        <section class="about-area" id="_about">
            <div class="container container-big">
                <div class="row justify-content-center d-flex flex-lg-row flex-md-column-reverse">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="about-banner mt-lg-0 mt-md-5 mt-5">
                            <img src="<?php echo UPLOAD_PATH; ?>/about/<?php echo $setting->about_image; ?>" alt=""  />
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="about-content">
                            <div class="section-title">
                                <h2><?php echo $this->global_setting->brand_title; ?></h2>
                            </div>
                        </div>
                        <p>
                           <?php echo nl2br($setting->about_brand); ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="video-area" id="_video">
            <div class="container container-big">
                <div class="section-title center">
                    <h2><?php echo $this->lang->line('demo_video'); ?></h2>
                </div>
                
                 <?php  if($setting->demo_video == 'youtube' && $setting->video_id != ''){ ?>
                    <iframe class="youtube-player" type="text/html" style="width:100%; height:550px;" height="550"
                       src="https://www.youtube.com/embed/<?php echo $setting->video_id; ?>" frameborder="0">
                    </iframe>
               <?php }else if($setting->demo_video == 'vimeo' && $setting->video_id != ''){ ?>
                    
                    <iframe src="https://player.vimeo.com/video/<?php echo $setting->video_id; ?>" style="width:100%; height:550px;" height="550" 
                            frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    <script src="https://player.vimeo.com/api/player.js"></script>
               <?php }else{ ?>                      
                    <iframe class="youtube-player" style="width:100%; height:550px;" height="550"
                            src="https://www.youtube.com/embed/zER53gdu74w" frameborder="0">                               
                    </iframe>
               <?php } ?>     
            </div>
        </section>

        <section class="faq-area" id="_faq">
            <div class="container container-big">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-lg-10 col-10">
                        <div class="faq-content">
                            <div class="section-title center mb-2">
                                <h2><?php echo $this->lang->line('faq'); ?></h2>
                            </div>
                            <div class="accordion" id="accordionExample">
                                <?php if(isset($faqs) && !empty($faqs)){ ?>
                                    <?php foreach($faqs as $obj){ ?>
                                
                                        <div class="card">
                                            <div class="card-header" id="heading<?php echo $obj->id; ?>">
                                                <h2 class="mb-0">
                                                    <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse<?php echo $obj->id; ?>" aria-expanded="true" aria-controls="collapseOne"><?php echo $obj->title; ?></button>
                                                </h2>
                                            </div>

                                            <div id="collapse<?php echo $obj->id; ?>" class="collapse" aria-labelledby="heading<?php echo $obj->id; ?>" data-parent="#accordionExample">
                                                <div class="card-body">
                                                    <p>
                                                        <?php echo nl2br($obj->description); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div> 

                                    <?php } ?>
                                <?php } ?>                           
                            </div>
                        </div>
                    </div>                  
                </div>
            </div>
        </section>
        
        <section class="pricing-area" id="_pricing">
            <div class="container container-big">
                <div class="section-title center mb-2">
                    <h2><?php echo $this->lang->line('subscription_plan'); ?></h2>
                </div>
                 <div class="row">                    
                        
                    <?php if(isset($plans) && !empty($plans)){ ?>
                        <?php foreach($plans AS $obj){ ?>
                        <div class="col-xl-4 col-md-4 col-12">
                            <div class="single-pricing">
                                <h3 class="title"><?php echo $this->lang->line($obj->plan_name);  ?></h3>
                               <ul>
                                    <li><?php echo $this->lang->line('price'); ?>: <span><?php echo $this->global_setting->currency_symbol; ?><?php echo $obj->plan_price; ?></span></li>                                    
                                    <li><?php echo $this->lang->line('student_limit'); ?>: <span><?php echo $obj->student_limit; ?></span></li>                                    
                                    <li><?php echo $this->lang->line('guardian_limit'); ?>: <span><?php echo $obj->guardian_limit; ?></span></li>                                    
                                    <li><?php echo $this->lang->line('teacher_limit'); ?>: <span><?php echo $obj->teacher_limit; ?></span></li>                                    
                                    <li><?php echo $this->lang->line('employee_limit'); ?>: <span><?php echo $obj->employee_limit; ?></span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_frontend'); ?> <span><?php echo $obj->is_enable_frontend ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_theme'); ?> <span><?php echo $obj->is_enable_theme ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_language'); ?> <span><?php echo $obj->is_enable_language ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_report'); ?> <span><?php echo $obj->is_enable_report ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </li>                                    
                                    <li><?php echo $this->lang->line('is_enable_inventory'); ?> <span><?php echo $obj->is_enable_inventory ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_lesson_plan'); ?> <span><?php echo $obj->is_enable_lesson_plan ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_online_exam'); ?> <span><?php echo $obj->is_enable_online_exam ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_live_class'); ?> <span><?php echo $obj->is_enable_live_class ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_payment_gateway'); ?> <span><?php echo $obj->is_enable_payment_gateway ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_sms_gateway'); ?> <span><?php echo $obj->is_enable_sms_gateway ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_attendance'); ?> <span><?php echo $obj->is_enable_attendance ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_exam_mark'); ?> <span><?php echo $obj->is_enable_exam_mark ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_accounting'); ?> <span><?php echo $obj->is_enable_accounting ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_payroll'); ?> <span><?php echo $obj->is_enable_payroll ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_asset_management'); ?> <span><?php echo $obj->is_enable_asset_management ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                    <li><?php echo $this->lang->line('is_enable_promotion'); ?> <span><?php echo $obj->is_enable_promotion ? '<i class="fas fa-check"></i>' : '<i class="fa fa-times-circle"></i>'; ?> </span></li>                                    
                                </ul>
                                <a href="#_subscription"><?php echo $this->lang->line('subscribe'); ?></a>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                   
                </div>
            </div>
        </section>
        
        <section class="subscription-area" id="_subscription">
            <div class="container container-big">
                <div class="section-title center mb-2">
                    <h2><?php echo $this->lang->line('subscription'); ?></h2>
                </div>
                <div class="section-title center mb-2">
                    <?php $this->load->view('layout/message'); ?>
                </div>
            </div>           
            <?php echo form_open(site_url(), array('name' => 'subscription', 'id' => 'subscription', 'class'=>'form-horizontal form-label-left'), ''); ?>
                <div class="container container-small">
                    <div class="row">
                        <div class="col-xl-6 col-12">
                            <div class="single-subscription">
                                <select  class="form-control col-md-12 col-xs-12"  name="subscription_plan_id"  id="subscription_plan_id"  required="required">
                                    <option value="">--<?php echo $this->lang->line('select'); ?>*--</option>    
                                    <?php if(isset($plans) && !empty($plans)){ ?>
                                        <?php foreach($plans AS $obj){ ?>
                                            <option value="<?php echo $obj->id; ?>"><?php echo $this->lang->line($obj->plan_name); ?></option>                                           
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="single-subscription">
                                <input name="name" id="name" type="text" required="required" placeholder="<?php echo $this->lang->line('name'); ?>*">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="single-subscription">
                                <input name="email" id="email" type="email" required="required" placeholder="<?php echo $this->lang->line('email'); ?>*">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="single-subscription">
                                <input name="phone" id="phone" type="number" required="required" placeholder="<?php echo $this->lang->line('phone'); ?>*">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="single-subscription">
                                <input name="school_name" id="school_name" type="text" required="required" placeholder="<?php echo $this->lang->line('school_name'); ?>*">
                            </div>
                        </div>
                        <div class="col-xl-6 col-12">
                            <div class="single-subscription">
                                <input name="address" id="address" type="text" required="required" placeholder="<?php echo $this->lang->line('address'); ?>*">
                            </div>
                        </div>
                       
                        <div class="col-12">
                            <div class="single-subscription text-right">
                                <input name="submit" id="submit" type="submit" value="<?php echo $this->lang->line('subscribe'); ?>">
                            </div>
                        </div>
                    </div>
                </div>
             <?php echo form_close(); ?>
        </section>
        
        <section class="feature-area" id="_feature">
            <div class="container container-big">
                <div class="section-title center mb-2">
                    <h2><?php echo $this->lang->line('features'); ?></h2>
                </div>
                <?php
                
                $features = array(
                    'theme'=>'<i class="fa fa-cubes"></i>',
                    'language'=>'<i class="fa fa-language"></i>',
                    'administrator'=>'<i class="fa fa-user"></i>',
                    'subscription'=>'<i class="fa fa-thumbs-up"></i>',
                    'manage_school'=>'<i class="fa fa-home"></i>',
                    'general_setting'=>'<i class="fa fa-edit"></i>',
                    'payment_setting'=>'<i class="fa fa-dollar-sign"></i>',
                    'sms_setting'=>'<i class="fa fa-mobile"></i>',
                    'email_setting'=>'<i class="fa fa-envelope"></i>',
                    'academic_year'=>'<i class="fa fa-calendar"></i>',
                    'role_permission'=>'<i class="fa fa-unlock-alt"></i>', 
                    'front_office'=>'<i class="fa fa-tty"></i>',
                    'human_resource'=>'<i class="fa fa-user-md"></i>',
                    'teacher'=>'<i class="fa fa-users"></i>',
                    'manage_leave'=>'<i class="fa fa-bell"></i>',
                    'academic'=>'<i class="fa fa-address-book"></i>',
                    'live_class'=>'<i class="fa fa-headphones"></i>',
                    'assignment'=>'<i class="fa fa-file-word"></i>',
                    'lesson_plan'=>'<i class="fa fa-bars"></i>',
                    'class_routine'=>'<i class="fa fa-clock"></i>',
                    'guardian'=>'<i class="fa fa-paw"></i>',
                    'student'=>'<i class="fa fa-users"></i>',
                    'online_admission'=>'<i class="fa fa-male"></i>',
                    'attendance'=>'<i class="fa fa-times-circle"></i>',
                    'generate_card'=>'<i class="fa fa-barcode"></i>',
                    'online_exam'=>'<i class="fa fa-mouse-pointer"></i>',
                    'manage_exam'=>'<i class="fa fa-graduation-cap"></i>',
                    'exam_mark'=>'<i class="fa fa-clipboard"></i>',
                    'promotion'=>'<i class="fa fa-forward"></i>',
                    'accounting'=>'<i class="fa fa-calculator"></i>',
                    'fee_collection'=>'<i class="fa fa-dollar-sign"></i>',
                    'report'=>'<i class="fa fa-chart-bar"></i>',
                    'inventory'=>'<i class="fa fa-users"></i>',
                    'asset_management'=>'<i class="fa fa-users"></i>',
                    'certificate'=>'<i class="fa fa-certificate"></i>',
                    'library'=>'<i class="fa fa-book"></i>',
                    'transport'=>'<i class="fa fa-bus"></i>',
                    'hostel'=>'<i class="fa fa-hospital"></i>',
                    'message'=>'<i class="far fa-envelope"></i>',
                    'template'=>'<i class="fa fa-tags"></i>',
                    'complain'=>'<i class="fa fa-comment"></i>',
                    'announcement'=>'<i class="fa fa-bullhorn"></i>',
                    'scholarship'=>'<i class="fa fa-users"></i>',
                    'event'=>'<i class="fa fa fa-calendar"></i>',                   
                    'media_gallery'=>'<i class="fa fa-image"></i>',
                    'manage_frontend'=>'<i class="fa fa-desktop"></i>',
                    'mail_and_sms'=>'<i class="fa fa-envelope"></i>',  
                    'miscellaneous'=>'<i class="fa fa-image"></i>',                    

                );
                
                ?>
                
                <div class="row single-feature-row">
                    
                    <?php $counter = 01; foreach($features as $key=>$value){ ?>
                    <div class="col-xl-2 col-md-2 col-sm-4 col-12 single-feature-col">
                        <div class="single-feature">
                            <div class="box-inner">
                                <div class="icon">
                                    <span class="box"><?php echo $value; ?></span>
                                </div>
                                <h3 class="title"><?php echo $this->lang->line($key); ?></h3>
                                <h3 class="count"><?php echo $counter++; ?></h3>
                            </div>
                        </div>
                    </div>                      
                    <?php } ?>                    
                </div>               
            </div>
        </section>
        
        <section class="contact-area" id="_contact">
            <div class="container container-big">
                <div class="section-title center mb-2">
                    <h2><?php echo $this->lang->line('contact_us'); ?></h2>
                </div>
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <div class="contact-info">
                            <h4 class="title"><?php echo $this->lang->line('get_in_touch'); ?></h4>
                            <ul class="info">
                                <li>
                                    <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                    <?php echo $this->lang->line('address'); ?>:
                                    <?php if(isset($setting->address)  && !empty($setting->address)){ ?>
                                        <?php echo $setting->address; ?>
                                    <?php } ?>
                                </li>
                                <li>
                                    <span class="icon"><i class="far fa-clock"></i></span>
                                    <?php echo $this->lang->line('opening_hour'); ?>: 
                                    <?php if(isset($setting->opening_hour)  && !empty($setting->opening_hour)){ ?>
                                        <?php echo $setting->opening_hour; ?>
                                    <?php } ?>  
                                </li>
                                <li>
                                    <span class="icon"><i class="far fa-calendar-alt"></i></span>
                                    <?php echo $this->lang->line('opening_day'); ?>: 
                                    <?php if(isset($setting->opening_day)  && !empty($setting->opening_day)){ ?>
                                        <?php echo $setting->opening_day; ?>
                                    <?php } ?> 
                                </li>
                                <li>
                                    <span class="icon"><i class="fas fa-phone"></i></span>
                                     <?php echo $this->lang->line('phone'); ?>:
                                    <?php if(isset($setting->phone)  && !empty($setting->phone)){ ?>
                                        <a href="tel:<?php echo $setting->phone; ?>"><?php echo $setting->phone; ?></a>
                                    <?php } ?> 
                                </li>
                                <li>
                                    <span class="icon"><i class="far fa-envelope"></i></span>
                                    <?php echo $this->lang->line('email'); ?>:
                                    <?php if(isset($setting->email)  && !empty($setting->email)){ ?>
                                        <a href="mailto:<?php echo $setting->email; ?>"><?php echo $setting->email; ?></a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-12">
                        <?php if(isset($setting->our_location)  && !empty($setting->our_location)){ ?>
                        <?php echo $setting->our_location; ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="container container-big">
                <div class="row">
                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="footer-widget">
                            <div class="logo">
                                <?php if(isset($setting->brand_logo_footer)){ ?>                             
                                <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $setting->brand_logo_footer; ?>" alt=""  />
                                <?php }elseif(isset($this->global_setting->logo)){ ?>  
                                    <img src="<?php echo UPLOAD_PATH; ?>/logo/<?php echo $this->global_setting->logo; ?>" alt=""  />
                                <?php }else{ ?>
                                    <img src="<?php echo IMG_URL; ?>default-front-logo.png" alt=""  />
                                <?php } ?> 
                            </div>
                            <p>
                                <?php echo nl2br($setting->footer_note); ?>
                            </p>
                        </div>
                        <div class="footer-widget">
                            <h4 class="title"><?php echo $this->lang->line('social_link'); ?></h4>
                            <ul class="social">
                                <?php if(isset($setting->facebook_url) && !empty($setting->facebook_url)){ ?>
                                    <li><a href="<?php echo $setting->facebook_url; ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                <?php } ?> 
                                <?php if(isset($setting->twitter_url)  && !empty($setting->twitter_url)){ ?>
                                    <li><a href="<?php echo $setting->twitter_url; ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                <?php } ?>                             
                                <?php if(isset($setting->linkedin_url)  && !empty($setting->linkedin_url)){ ?>
                                    <li><a href="<?php echo $setting->linkedin_url; ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                <?php } ?>                   
                                <?php if(isset($setting->youtube_url)  && !empty($setting->youtube_url)){ ?>
                                    <li><a href="<?php echo $setting->youtube_url; ?>" target="_blank"><i class="fab fa-youtube"></i></a></li>
                                <?php } ?>                              
                                <?php if(isset($setting->instagram_url)  && !empty($setting->instagram_url)){ ?>
                                    <li><a href="<?php echo $setting->instagram_url; ?>" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                <?php } ?>                              
                                <?php if(isset($setting->pinterest_url)  && !empty($setting->pinterest_url)){ ?>
                                    <li><a href="<?php echo $setting->pinterest_url; ?>" target="_blank"><i class="fab fa-pinterest-p"></i></a></li>
                                <?php } ?>                                 
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="footer-widget">
                            <h4 class="title"><?php echo $this->lang->line('quick_link'); ?></h4>
                            <ul>
                                <li><a class="smoothscroll" href="#_about"><?php echo $this->lang->line('about_brand'); ?></a></li>
                                <li><a class="smoothscroll" href="#_video"><?php echo $this->lang->line('demo_video'); ?></a></li>
                                <li><a class="smoothscroll" href="#_faq"><?php echo $this->lang->line('faq'); ?></a></li>
                                <li><a class="smoothscroll" href="#_pricing"><?php echo $this->lang->line('pricing_plan'); ?></a></li>
                                <li><a class="smoothscroll" href="#_subscription"><?php echo $this->lang->line('subscription'); ?></a></li>
                                <li><a class="smoothscroll" href="#_feature"><?php echo $this->lang->line('features'); ?></a></li>
                                <li><a class="smoothscroll" href="#_contact"><?php echo $this->lang->line('contact_us'); ?></a></li>
                                <?php if(isset($school) && !empty($school)){ ?>
                                    <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('visit_school'); ?></a></li>
                                <?php } ?>
                                <?php if (logged_in_user_id()) { ?>     
                                    <li><a href="<?php echo site_url('auth/logout'); ?>"><?php echo $this->lang->line('logout'); ?></a></li>
                                <?php }else{ ?> 
                                    <li><a href="<?php echo site_url('auth/login'); ?>" target="_blank"><?php echo $this->lang->line('login'); ?></a></li>
                                <?php } ?>     
                            </ul>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12">
                        <div class="footer-widget">
                            <h4 class="title"><?php echo $this->lang->line('contact_us'); ?></h4>
                            <ul class="info">
                                <li>
                                    <span class="icon"><i class="far fa-clock"></i></span>
                                    <?php echo $this->lang->line('opening_hour'); ?>: 
                                    <?php if(isset($setting->opening_hour)  && !empty($setting->opening_hour)){ ?>
                                        <?php echo $setting->opening_hour; ?>
                                    <?php } ?>                                    
                                </li>
                                <li>
                                    <span class="icon"><i class="far fa-calendar-alt"></i></span>
                                    <?php echo $this->lang->line('opening_day'); ?>: 
                                    <?php if(isset($setting->opening_day)  && !empty($setting->opening_day)){ ?>
                                        <?php echo $setting->opening_day; ?>
                                    <?php } ?>  
                                </li>
                                <li>
                                    <span class="icon"><i class="fas fa-phone"></i></span>
                                     <?php echo $this->lang->line('phone'); ?>:
                                    <?php if(isset($setting->phone)  && !empty($setting->phone)){ ?>
                                        <a href="tel:<?php echo $setting->phone; ?>"><?php echo $setting->phone; ?></a>
                                    <?php } ?>  
                                </li>
                                <li>
                                    <span class="icon"><i class="far fa-envelope"></i></span>
                                    <?php echo $this->lang->line('email'); ?>:
                                    <?php if(isset($setting->email)  && !empty($setting->email)){ ?>
                                        <a href="mailto:<?php echo $setting->email; ?>"><?php echo $setting->email; ?></a>
                                    <?php } ?>
                                </li>
                                <li>
                                    <span class="icon"><i class="fas fa-map-marker-alt"></i></span>
                                    <?php echo $this->lang->line('address'); ?>:
                                    <?php if(isset($setting->address)  && !empty($setting->address)){ ?>
                                        <?php echo $setting->address; ?>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>                        
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="copyright">
                            <p>
                                <?php if(isset($this->global_setting->brand_footer)){ ?>
                                    <?php echo $this->global_setting->brand_footer; ?>
                                <?php } ?> 
                            </p>
                        </div>
                    </div>
                </div>
                
            </div>
        </footer>
        
        <!-- Scripts -->        
        <script src="<?php echo JS_URL; ?>front/owl.carousel.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.counterup.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/countdown.js"></script>
        <script src="<?php echo JS_URL; ?>front/stellarnav.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.scrollUp.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.waypoints.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/imagesloaded.pkgd.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/isotope.pkgd.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/jquery.fancybox.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/popper.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/bootstrap.min.js"></script>
        <script src="<?php echo JS_URL; ?>front/saas-theme.js"></script>
        
        <style type="text/css">
            .location-btn-mobile, .call-btn-mobile{display: none !important;}
            .close-menu{ border: 0px !important;}
            .stellarnav.mobile.light li a {
                padding: 15px 10px 22px !important;
            }
        </style>
        
        <script type="text/javascript">
       
            jQuery.extend(jQuery.validator.messages, {
                 required: "<?php echo $this->lang->line('required_field'); ?>",
                 email: "<?php echo $this->lang->line('enter_valid_email'); ?>"
             });
             
            $('#subscription').validate();
            
       </script>
        
    </body>
</html>
