<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $page->page_title; ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $page->page_title; ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="welcome-area">
     <div class="container">
         <div class="row">
         <?php if(isset($page) && !empty($page)){ ?>
            <?php if(isset($page->page_image) && !empty($page->page_image)){ ?>                 
                 <div class="col-lg-5 offset-lg-1 col-md-6 col-12">
                     <div class="welcome-content">                            
                         <p class="text">
                             <?php echo nl2br($page->page_description); ?>  
                         </p>                        
                     </div>
                 </div>
                 <div class="col-lg-6 col-md-6 col-12">
                     <div class="welcome-banner_">
                         <?php if(isset($page->page_image) && !empty($page->page_image)){ ?>
                             <img class="wb-banner"  src="<?php echo UPLOAD_PATH; ?>page/<?php echo $page->page_image; ?>" alt="">
                         <?php } ?>  
                     </div>
                 </div>

             <?php }else{ ?>

                 <div class="col-lg-12 col-md-12 col-12">
                     <div class="welcome-content">                            
                         <p class="text">
                             <?php echo nl2br($page->page_description); ?>  
                         </p>                        
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
