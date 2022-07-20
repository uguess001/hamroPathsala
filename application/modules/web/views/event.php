<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('event'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href='javascript:void(0);'><?php echo $this->lang->line('event'); ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="inner-all-news-area">
    <div class="container">
        <div class="row justify-content-center">
            <?php if(isset($events) && !empty($events)){ ?>
                <?php foreach($events AS $obj){ ?>
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
                                <h2 class="title"><?php echo substr($obj->title, 0, 40); ?>...</h2>
                            </a>
                            <p class="text">
                                <?php echo strip_tags(substr($obj->note, 0, 100)); ?>...  
                            </p>
                            <div class="more-wrapper">
                                <a href="<?php echo site_url($school->school_url.'/event-detail/'.$obj->id); ?>" class="more"><?php echo $this->lang->line('read_more'); ?></a>
                            </div>
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