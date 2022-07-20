<div class="modal fade bs-sale-modal-lg no-print" tabindex="-1" role="dialog" aria-hidden="true" style="z-index: 999999;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header  no-print">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
          <h4 class="modal-title"><?php echo $this->lang->line('detail_information'); ?></h4>
        </div>
        <div class="modal-body fn_sale_data"></div>       
      </div>
    </div>
</div>
<script type="text/javascript">
         
    function get_sale_modal(sale_id){
         
        $('.fn_sale_data').html('<p style="padding: 20px;"><p style="padding: 20px;text-align:center;"><img src="<?php echo IMG_URL; ?>loading.gif" /></p>');
        $.ajax({       
          type   : "POST",
          url    : "<?php echo site_url('inventory/sale/get_single_sale'); ?>",
          data   : {sale_id:sale_id},  
          success: function(response){                                                   
             if(response)
             {
                $('.fn_sale_data').html(response);
             }
          }
       });
    }
    
</script>
