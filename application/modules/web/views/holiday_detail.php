  
<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('holiday_detail'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="<?php echo site_url($school->school_url.'/holiday'); ?>"><?php echo $this->lang->line('all_holiday'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('holiday_detail'); ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="notice-details-area">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-8 col-12">
                <div class="news-details-content">
                    <?php if(isset($holiday) && !empty($holiday)){ ?> 
                    <h2 class="title"><?php echo $holiday->title; ?></h2>
                    <ul class="meta">
                        <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $holiday->name; ?></li>
                        <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($holiday->created_at)); ?></li>
                    </ul>
                    <p class="holiday"><span><?php echo $this->lang->line('holiday'); ?> :&nbsp;</span> <?php echo date($this->global_setting->date_format, strtotime($holiday->date_from)); ?> - <?php echo date($this->global_setting->date_format, strtotime($holiday->date_to)); ?></p>
                    <p class="text">
                        <?php echo nl2br($holiday->note); ?>
                    </p>
                    <?php }else{ ?>
                         <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>
                    <?php } ?>
                </div>
            </div>
            
            <div class="col-lg-4 col-12">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <div class="title-wrapper">
                            <h2 class="title">
                                <img src="<?php echo IMG_URL; ?>front/icon/heading-<?php echo $school->theme_name; ?>.png" alt="">
                                <?php echo $this->lang->line('latest_holiday'); ?>
                            </h2>
                        </div>
                        <?php if(isset($holidays) && !empty($holidays)){ ?>  
                            <?php foreach($holidays as $obj){ ?> 
                            <div class="sw-single-news">
                                <a href="<?php echo site_url($school->school_url.'/holiday-detail/'.$obj->id); ?>">
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
