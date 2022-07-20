<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('gallery'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('gallery'); ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="page-gallery-area">    
    <div class="container">
        
    <?php if(isset($galleries) && !empty($galleries)){ ?>
        
        <div class="gallery-menu">
            <button class="button checked" data-filter="*">All</button>
            <?php foreach($galleries AS $obj){ ?>
                <button class="button" data-filter=".<?php echo $obj->id; ?>Gallery"><?php echo $obj->title; ?></button>                
            <?php } ?>
        </div>
        
        <div class="row no-gutters justify-content-center grid_container" id="container">
             <?php foreach($galleries AS $obj){ ?>
                <?php $images = get_gallery_images($obj->school_id, $obj->id); ?> 
                <?php foreach($images as $img){ ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 gallery-box grid <?php echo $obj->id; ?>Gallery" data-category="post-transition">
                        <div class="single-gallery">
                            <a href="#" class="link" target="_blank"><i class="fas fa-link"></i></a>
                            <a href="<?php echo UPLOAD_PATH; ?>gallery/<?php echo $img->image; ?>" class="fancy" data-fancybox="images">
                                <i class="fas fa-expand-arrows-alt"></i>
                                <img src="<?php echo UPLOAD_PATH; ?>gallery/<?php echo $img->image; ?>" alt="">
                            </a>
                        </div>
                    </div>           
                <?php } ?>
            <?php } ?>
        </div>
        
         <?php }else{ ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>
            </div>
        <?php } ?>
        
    </div>
</div>