<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('holiday'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('holiday'); ?></a></li>
            </ul>
        </div>
    </div>
</div>
<div class="page-notice-area">
    <div class="container">
        <div class="row justify-content-center">
            <?php if(isset($holidays) && !empty($holidays)){ ?>
            <?php foreach($holidays as $obj ){ ?>
            
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-holiday">
                        <div class="content">
                            <a href="<?php echo site_url($school->school_url.'/holiday-detail/'.$obj->id); ?>">
                            <h2 class="title"><?php echo substr($obj->title, 0, 40); ?>...</h2>
                            </a>
                            <ul class="meta">
                                <li><span class="icon"><i class="fas fa-user-circle"></i></span> <?php echo $this->lang->line('by'); ?> / <?php echo $obj->name; ?></li>
                                <li><span class="icon"><i class="fas fa-calendar-alt"></i></span> <?php echo date($this->global_setting->date_format, strtotime($obj->created_at)); ?></li>
                            </ul>
                        </div>
                        <p class="holiday"><span><?php echo $this->lang->line('holiday'); ?> :&nbsp;</span> <?php echo date($this->global_setting->date_format, strtotime($obj->date_from)); ?>   -  <?php echo date($this->global_setting->date_format, strtotime($obj->date_to)); ?></p>
                        <div class="content">
                            <p class="text">
                                <?php echo strip_tags(substr($obj->note, 0, 180)); ?> ...
                            </p>
                            <div class="more-wrapper">
                                <a href="<?php echo site_url($school->school_url.'/holiday-detail/'.$obj->id); ?>" class="more"><?php echo $this->lang->line('read_more'); ?></a>
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