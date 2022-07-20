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
        background: #e80000;
    }

    ::-moz-selection,
    ::selection{
        background: #e80000;
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
        color: #e80000;
    }


    .form-box input[type="submit"],
    .single-holiday .more,
    .single-notice .more,
    .form-box,
    .single-teacher .social li a,
    .gallery-menu .button {
        border: 1px solid #e80000;
    }
    .header-bottom {
        border-bottom: 1px solid #e80000;
    }


    .welcome-content .title-2 {
        color: #e80000;
    }

    .welcome-content .button {
        border: 1px solid #e80000;
        color: #e80000;
    }
   

    .single-testimonial .author-name .inner,
    .section-title .title {
        border-bottom: 3px solid #e80000;
    }
    
    footer {
     border-top: 3px solid #e80000;
    }


    .single-achivement {
        border: 4px solid #e80000;
    }

    .single-achivement .icon {
        border-bottom: 2px solid #e80000;
        color:  #e80000;    
    }


    .single-facilities::before {
        background-image: url(<?php echo IMG_URL; ?>front/icon/round-red.png);
    }


    .single-event::before ,
    .single-teacher::before,
    .single-holiday::before,
    .single-notice::before,
    .single-news::before {
        background-image: url(<?php echo IMG_URL; ?>front/icon/border-1-red.png);
    }

    .single-event::after, 
    .single-teacher::after,
    .single-holiday::after,
    .single-notice::after,
    .single-news::after {
        background-image: url(<?php echo IMG_URL; ?>front/icon/border-2-red.png);
    }


    
    .single-event .img img, 
    .single-news .img img {
        border: 2px solid #e80000;
    }


    .single-news .content .more,
    .single-event .content .more,
    .single-hero-carousel .button,
    .pcia-info-box,
    .footer-widget .social li a {
        border: 1px solid #e80000;
    }

    .pcia-info .title,
    .footer-widget .title,
    .page-header-content .title .inner,
    .sidebar-widget .title {
        border-bottom: 2px solid #e80000;
    }

    .sidebar-widget .sw-single-news {
        border-bottom: 1px solid #e80000; 
    }

    header .stellarnav ul li.active > a {
        color: #e80000;
        border-bottom-color: #e80000;
    }

    .welcome-banner::before {
        background-color: #e80000;
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
        border-right: 1px solid #e80000;
    }


    /* Different */

    .header-bottom-inner {
        background: #0559b4;
    }

    .welcome-banner::after {
        background-color: #ff4545;
    }

    .single-hero-carousel .box {
        background: rgb(255 65 65 / 50%); 
    }

   
    
   <?php if(isset($is_home)){ ?>    
        .header-bottom{
            background: rgb(255 138 138 / 50%);   
        }
   <?php }else{ ?>
         .header-bottom{
            background: #ff4545;   
        }
   <?php } ?>   
</style>