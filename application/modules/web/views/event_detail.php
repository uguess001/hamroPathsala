<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('event_detail'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="<?php echo site_url('events'); ?>"><?php echo $this->lang->line('event'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('event_detail'); ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="news-details-area">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 col-12">
                <div class="news-details-content">
                    <h2 class="title"><?php echo $event->title; ?></h2>
                    <ul class="ed-meta">
                        <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $event->event_for ? $event->event_for : $this->lang->line('all'); ?> (<?php echo $this->lang->line('event_for'); ?>)</li>
                        <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($event->event_from)); ?> <?php echo $this->lang->line('to'); ?> <?php echo date($this->global_setting->date_format, strtotime($event->event_to)); ?></li>
                        <li><span class="icon"><i class="fas fa-map-marker-alt"></i></span> <?php echo $event->event_place; ?></li>
                    </ul>
                    <div class="banner">
                        <?php if(isset($event->image) && !empty($event->image)){ ?>
                            <img src="<?php echo UPLOAD_PATH; ?>event/<?php echo $event->image; ?>" alt="">
                        <?php }else{ ?>
                            <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                        <?php } ?> 
                    </div>
                    <ul class="meta">
                        <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $event->name; ?></li>
                        <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($event->created_at)); ?></li>
                    </ul>
                    <p class="text">
                       <?php echo nl2br($event->note); ?>
                    </p>
                </div>
            </div>
            
            <div class="col-lg-4 col-12">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <div class="title-wrapper">
                            <h2 class="title">
                                <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt="">
                                <?php echo $this->lang->line('latest_event'); ?>
                            </h2>
                        </div>
                        <?php if(isset($events) && !empty($events)){ ?> 
                            <?php foreach($events AS $obj){ ?>
                                <div class="sw-single-news">
                                    <a href="<?php echo site_url($school->school_url.'/event-detail/'.$obj->id); ?>">
                                        <span class="img">
                                            <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>event/<?php echo $obj->image; ?>" alt="">
                                            <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                                            <?php } ?> 
                                        </span>
                                        <span class="content">
                                            <span class="news-title"><?php echo $obj->title; ?></span>
                                            <span class="meta">
                                                <span class="info"><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></span>
                                                <span class="info"><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->created_at)); ?></span>
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
