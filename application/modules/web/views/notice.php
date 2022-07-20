<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('notice'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('notice'); ?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="page-notice-area">
    <div class="container">
        <div class="row justify-content-center">
            <?php if(isset($notices) && !empty($notices)){ ?>
            <?php foreach($notices AS $obj){ ?>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-notice">
                        <div class="top-head">
                            <h2 class="for"><?php echo $this->lang->line('notice_for'); ?>: <?php echo $obj->notice_for ? $obj->notice_for : $this->lang->line('all'); ?></h2>
                        </div>
                        <div class="content">
                            <a href="<?php echo site_url($school->school_url.'/notice-detail/'.$obj->id); ?>">
                                <h2 class="title"><?php echo substr($obj->title, 0, 40); ?>...</h2>
                            </a>
                            <ul class="meta">
                                <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></li>
                                <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->date)); ?></li>
                            </ul>
                            <p class="text" style="min-height: 100px;">
                                <?php echo strip_tags(substr($obj->notice, 0, 150)); ?> ...
                            </p>
                            <div class="more-wrapper">
                                <a href="<?php echo site_url($school->school_url.'/notice-detail/'.$obj->id); ?>" class="more"><?php echo $this->lang->line('read_more'); ?></a>
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