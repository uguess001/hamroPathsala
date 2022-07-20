    <div class="page-header-area">
        <div class="container">
            <div class="page-header-content">
                <h2 class="title"><span class="inner"><?php echo $this->lang->line('notice_detail'); ?></span></h2>
                <ul class="links">
                    <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                    <li><a href="<?php echo site_url($school->school_url.'/notice'); ?>"><?php echo $this->lang->line('notice'); ?></a></li>
                    <li><a href="javascript:void(0);"><?php echo $this->lang->line('notice_detail'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="notice-details-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <?php if(isset($notice) && !empty($notice)){ ?>
                    <div class="news-details-content notice-details-content">
                        <div class="top-head">
                            <h2 class="for"><?php echo $this->lang->line('notice_for'); ?>: <?php echo $notice->notice_for ? $notice->notice_for : $this->lang->line('all'); ?></h2>
                        </div>
                        <h2 class="title"><?php echo $notice->title; ?></h2>
                        <ul class="meta">
                            <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $notice->name; ?></li>
                            <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($notice->date)); ?></li>
                        </ul>
                        <p class="text">
                            <?php echo nl2br($notice->notice); ?>
                        </p>
                    </div>
                    <?php }else{ ?>                        
                            <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>                       
                    <?php } ?>
                </div>
                
                <div class="col-lg-4 col-12">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            
                            <div class="title-wrapper">
                                <h2 class="title">
                                    <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt="">
                                    <?php echo $this->lang->line('latest_notice'); ?>
                                </h2>
                            </div>
                            <?php if(isset($notices) && !empty($notices)){ ?>
                                <?php foreach($notices AS $obj){ ?>
                                <div class="sw-single-news">
                                    <a href="<?php echo site_url($school->school_url.'/notice-detail/'.$obj->id); ?>">
                                        <span class="content">
                                            <span class="news-title"><?php echo $obj->title; ?></span>
                                            <span class="meta">
                                                <span class="info"><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></span>
                                                <span class="info"><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></span>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                                <?php } ?>
                            <?php } ?>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>