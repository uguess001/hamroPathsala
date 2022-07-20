<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('news_detail'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="<?php echo site_url($school->school_url.'/news'); ?>"><?php echo $this->lang->line('news'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('news_detail'); ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="news-details-area">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 col-12">
                <div class="news-details-content">
                    <?php if(isset($news) && !empty($news)){ ?>
                        <h2 class="title"><?php echo $news->title; ?></h2>
                        <div class="banner">
                            <?php if(isset($news->image) && !empty($news->image)){ ?>
                                <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $news->image; ?>" alt="">
                            <?php }else{ ?>
                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                            <?php } ?>
                        </div>
                        <ul class="meta">
                            <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $news->name; ?></li>
                            <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($news->date)); ?></li>
                        </ul>
                        <p class="text">
                            <?php echo nl2br($news->news); ?>
                        </p>
                    <?php }else{ ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                            <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
            
            <div class="col-lg-4 col-12">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <div class="title-wrapper">
                            <h2 class="title">
                                <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt="">
                                <?php echo $this->lang->line('latest_news'); ?> 
                            </h2>
                        </div>
                        <?php if(isset($latest_news) && !empty($latest_news)){ ?> 
                            <?php foreach($latest_news AS $obj ){ ?> 
                                <div class="sw-single-news">
                                    <a href="<?php echo site_url($school->school_url.'/news-detail/'.$obj->id); ?>">
                                        <span class="img">
                                            <?php if(isset($obj->image) && !empty($obj->image)){ ?>
                                                <img src="<?php echo UPLOAD_PATH; ?>news/<?php echo $obj->image; ?>" alt="">
                                            <?php }else{ ?>
                                                <img src="<?php echo IMG_URL; ?>news-image.jpg" alt="">
                                            <?php } ?>  
                                        </span>
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
