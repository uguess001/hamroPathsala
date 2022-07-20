<footer class="footer no-print">
    <div class="pull-right">
        <p class="white">
             <?php if(isset($this->school_setting->footer) && $this->school_setting->footer != ''){ ?>
                <?php echo $this->school_setting->footer; ?>
             <?php }else{ ?>
                <?php echo $this->global_setting->brand_footer ? $this->global_setting->brand_footer : 'Copyright © '. date('Y') .' <a target="_blank" href="http://aegistechnologies.net">Aegis Technologies.</a> All rights reserved.'; ?> 
             <?php } ?>
        </p>       
    </div>
    <div class="clearfix"></div>
</footer>