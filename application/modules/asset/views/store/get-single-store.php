<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <th width="30%"> <?php echo $this->lang->line('school_name'); ?></th>
            <td><?php echo $store->school_name; ?></td>
        </tr>
        <tr>
            <th> <?php echo $this->lang->line('name'); ?></th>
            <td><?php echo $store->name; ?></td>
        </tr>
        <tr>
            <th> <?php echo $this->lang->line('store_keeper'); ?></th>
            <td><?php echo $store->keeper; ?></td>
        </tr>

        <tr>
            <th> <?php echo $this->lang->line('phone'); ?></th>
            <td><?php echo $store->phone; ?></td>
        </tr>

        <tr>
            <th> <?php echo $this->lang->line('address'); ?></th>
            <td><?php echo $store->address; ?></td>
        </tr>

        <tr>
            <th><?php echo $this->lang->line('note'); ?></th>
            <td><?php echo $store->note; ?></td>
        </tr>         
    </tbody>
</table>
