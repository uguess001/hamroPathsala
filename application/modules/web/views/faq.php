<div class="page-header-area">
    <div class="container">
        <div class="page-header-content">
            <h2 class="title"><span class="inner"><?php echo $this->lang->line('faq'); ?></span></h2>
            <ul class="links">
                <li><a href="<?php echo site_url($school->school_url); ?>"><?php echo $this->lang->line('home'); ?></a></li>
                <li><a href="javascript:void(0);"><?php echo $this->lang->line('faq'); ?></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="welcome-area">
     <div class="container">
         <div class="row">                
         <?php if(isset($faqs) && !empty($faqs)){ ?>
             <div class="col-lg-12 col-md-12 col-12">
                 <div class="welcome-content">                        
                      <?php foreach($faqs AS $obj){ ?>
                       <button class="accordion"><?php echo $obj->title; ?></button>
                         <div class="panel">
                           <p class="text"><?php echo nl2br($obj->description); ?></p>
                         </div>

                 <?php } ?>                      
                 </div>                   
             </div>
         <?php }else{ ?>
             <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                 <p class="text-center"><strong><?php echo $this->lang->line('no_data_found'); ?></strong></p>
             </div>
         <?php } ?>
         </div>
     </div>
 </div>

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}
</script>
