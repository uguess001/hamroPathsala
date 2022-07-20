<style type="text/css">
    .header-top,
    .header-bottom.navbar-fixed-top,
    .single-teacher .meta,
    .single-gallery .fancy > i,
    .gallery-menu .button.checked,
    .single-holiday .more:hover,
    .news-details-content .holiday,
    .single-holiday .holiday,
    .news-search-content,
    .welcome-content .button:hover,
    .single-notice .top-head .for,
    .news-details-content .top-head .for,
    .news-search-content .single button,
    .footer-widget .social li a:hover,
    .footer-widget .links li a::before,
    .single-facilities,
    .single-event .meta,
    .single-news .meta,
    .apply-box,
    .single-teacher .social li a:hover,
    .pcia-info-box .icon .box,
    .single-hero-carousel .button:hover,
    .single-event .content .more:hover,
    .single-news .content .more:hover,
    .footer-widget .hours li:before,
    .single-notice .more:hover,
    .form-box input[type="submit"]:hover,
    .news-search-area,
    #message_div
    {
        background: #007bff;
    }

    ::-moz-selection,
    ::selection{
        background: #007bff;
    }


    .footer-widget .links li a:hover, 
    .footer-widget .contact-info li .icon,
    .footer-widget .contact-info li a:hover,
    .hero-carousel .owl-nav > div,
    .single-teacher .category .inner,
    .page-header-content .title,
    header .stellarnav ul li:hover > a, 
    .single-holiday .meta li .icon,
    .single-notice .meta li .icon,
    .notice-details-area .meta li .icon,
    .news-details-content .meta li .icon,
    .sidebar-widget .sw-single-news .content .meta .info .icon,
    .single-teacher .social li a,
    .pcia-info .title,
    .form-box .icon-box .icon,
    a:hover,
    a:active,
    .single-hero-carousel .button,
    .apply-box .apply a:hover,
    .page-header-content .links li a:hover,
    .apply .icon i,
    .news-details-content .ed-meta li .icon
    {
        color: #007bff;
    }


    .form-box input[type="submit"],
    .single-holiday .more,
    .single-notice .more,
    .form-box,
    .single-teacher .social li a,
    .gallery-menu .button {
        border: 1px solid #007bff;
    }
    .header-bottom {
        border-bottom: 1px solid #007bff;
    }


    .welcome-content .title-2 {
        color: #007bff;
    }

    .welcome-content .button {
        border: 1px solid #007bff;
        color: #007bff;
    }

    .single-testimonial .author-name .inner,
    .section-title .title {
        border-bottom: 3px solid #007bff;
    }
    
    footer {
     border-top: 3px solid #007bff;
    }

    .single-achivement {
        border: 4px solid #007bff;
    }

    .single-achivement .icon {
        border-bottom: 2px solid #007bff;
        color:  #007bff;    
    }


    .single-facilities::before {
        background-image: url(<?php echo IMG_URL; ?>front/icon/round-dodger-blue.png);
    }


    .single-event::before ,
    .single-teacher::before,
    .single-holiday::before,
    .single-notice::before,
    .single-news::before {
        background-image: url(<?php echo IMG_URL; ?>front/icon/border-1-dodger-blue.png);
    }

    .single-event::after, 
    .single-teacher::after,
    .single-holiday::after,
    .single-notice::after,
    .single-news::after {
        background-image: url(<?php echo IMG_URL; ?>front/icon/border-2-dodger-blue.png);
    }


   
    .single-event .img img, 
    .single-news .img img {
        border: 2px solid #007bff;
    }


    .single-news .content .more,
    .single-event .content .more,
    .single-hero-carousel .button,
    .pcia-info-box,
    .footer-widget .social li a {
        border: 1px solid #007bff;
    }

     .pcia-info .title,
    .footer-widget .title,
    .page-header-content .title .inner,
    .sidebar-widget .title {
        border-bottom: 2px solid #007bff;
    }

    .sidebar-widget .sw-single-news {
        border-bottom: 1px solid #007bff; 
    }

    header .stellarnav ul li.active > a {
        color: #007bff;
        border-bottom-color: #007bff;
    }

    .welcome-banner::before {
        background-color: #007bff;
    }


    .single-hero-carousel .button,
    .navbar-fixed-top .stellarnav ul li:hover > a,
    .header-bottom-inner .stellarnav ul li:hover > a,
    .stellarnav.light a, .stellarnav.light li a,
    .single-facilities .content .title,
    header .ht-right .link,
    header .ht-left .link{
        color: #fff;
    }
    
    .form-box .icon-box {
        border-right: 1px solid #78b9ff;
    }

    /* Different */

    .header-bottom-inner {
        background: #0559b4;
    }

    .welcome-banner::after {
        background-color: #7db8f8;
    }

    .single-hero-carousel .box {
        background: rgb(154 200 250 / 50%);
    }
       
   <?php if(isset($is_home)){ ?>    
        .header-bottom{
             background: rgb(133 171 255 / 34%);  
        }
   <?php }else{ ?>
         .header-bottom{
            background: #7db8f8;   
        }
   <?php } ?> 
</style>