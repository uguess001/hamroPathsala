<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
         <tr>
            <th width="20%"><?php echo $this->lang->line('school_name'); ?> </th>
            <td width="30%"><?php echo $purchase->school_name; ?></td> 
            <th width="20%"><?php echo $this->lang->line('vendor'); ?> </th>
            <td width="30%"><?php echo $purchase->vendor_name; ?></td>        
        </tr>
        <tr>
            <th><?php echo $this->lang->line('category'); ?> </th>
            <td> <?php echo $purchase->cat_name; ?></td> 
            <th><?php echo $this->lang->line('item'); ?> </th>
            <td> <?php echo $purchase->item_name; ?></td>  
        </tr>
       
        <tr>            
            <th><?php echo $this->lang->line('unit_type'); ?> </th>
            <td><?php echo $this->lang->line($purchase->unit_type); echo $purchase->unit_type; ?></td>    
             <th><?php echo $this->lang->line('quantity'); ?> </th>
            <td><?php echo $purchase->qty; ?></td> 
        </tr>
        
        <tr>           
            <th><?php echo $this->lang->line('unit_price'); ?> </th>
            <td><?php echo $purchase->unit_price; ?></td> 
            <th><?php echo $this->lang->line('total_price'); ?> </th>
            <td><?php echo $purchase->total_price; ?></td>        
        </tr>

        <tr>
            <th><?php echo $this->lang->line('purchase_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($purchase->purchase_date)); ?></td> 
            <th><?php echo $this->lang->line('expire_date'); ?> </th>
            <td><?php echo date($this->global_setting->date_format, strtotime($purchase->expire_date)); ?></td>      
        </tr>

        <tr>
            <th><?php echo $this->lang->line('purchase_by'); ?> </th>
            <td><?php echo $purchase->employee_name; ?></td> 
            <th><?php echo $this->lang->line('note'); ?> </th>
            <td><?php echo $purchase->note; ?></td>        
        </tr>

    </tbody>
</table>
