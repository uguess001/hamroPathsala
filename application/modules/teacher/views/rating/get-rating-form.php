<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 10px 20px;">
        <div class="row">
            <div class="item form-group">  
                <label for="rating" style="display: initial;padding-right: 10px;"><?php echo $this->lang->line('rating'); ?> <span class="required">*</span></label>                        
                <span onclick="get_rating('1')" id="rating_1" class="fa fa-star" style="color:gray;"></span>
                <span onclick="get_rating('2')" id="rating_2" class="fa fa-star" style="color:gray;"></span>
                <span onclick="get_rating('3')" id="rating_3" class="fa fa-star" style="color:gray;"></span>
                <span onclick="get_rating('4')" id="rating_4" class="fa fa-star" style="color:gray;"></span>
                <span onclick="get_rating('5')" id="rating_5" class="fa fa-star" style="color:gray;"></span>                        
            </div> 

            <div class="item form-group">
                <label for="comment"> <?php echo $this->lang->line('comment'); ?></label>  
                <input type="hidden" id="rating" name="rating" value="" />
                <input type="hidden" id="teacher_id" name="teacher_id" value="<?php echo $teacher_id; ?>" />
                <textarea  class="form-control col-md-7 col-xs-12"  name="comment"  id="comment" style="height: 60px;"></textarea>
            </div>
        </div>

        <div class="ln_solid"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <a href="<?php echo site_url('teacher/rating/index'); ?>" class="btn btn-primary"><?php echo $this->lang->line('cancel'); ?></a>
                <button id="rating_form" type="button" class="btn btn-success" onclick="save_rating();"><?php echo $this->lang->line('submit'); ?></button>
            </div>
        </div>
    </div>
</div>  