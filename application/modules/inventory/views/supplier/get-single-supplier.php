<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        
        <tr>
            <th width="20%"> <?php echo $this->lang->line('school_name'); ?> </th>
            <td><?php echo $supplier->school_name; ?></td>
        </tr>
        
        <tr>
            <th> <?php echo $this->lang->line('supplier'); ?> </th>
            <td><?php echo $supplier->company; ?></td>
        </tr>
        
        <tr>
            <th> <?php echo $this->lang->line('contact_name'); ?></th>
            <td><?php echo $supplier->contact; ?></td>
        </tr>
     
        <tr>
            <th> <?php echo $this->lang->line('email'); ?></th>
            <td><?php echo $supplier->email; ?></td>
        </tr>
        
        <tr>
            <th> <?php echo $this->lang->line('phone'); ?></th>
            <td><?php echo $supplier->phone; ?></td>
        </tr>
        
        <tr>
            <th> <?php echo $this->lang->line('address'); ?></th>
            <td><?php echo $supplier->address; ?></td>
        </tr>
        
        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $supplier->note; ?></td>
        </tr>         
    </tbody>
</table>