<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
<style>
    #project-description {
        margin: 0;
        padding: 0;
    }
</style>  
<script>

    //TODO move this in a js file and remove the php code in it
    // Autocomplete stuff
    $(function() {

        $("#project").autocomplete({
            source: "/users/autoCompleteUserBox",
            minLength: 2,
            focus: function(event, ui) {
                $("#project").val(ui.item.email);
                return false;
            },
            select: function(event, ui) {
                $("#project").val(ui.item.desc);
                $("#CouponUserId").val(ui.item.id);
                return false;
            }}).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                    .append("<a>" + item.desc + "</a>")
                    .appendTo(ul);
        };
    });
</script>


<div class="coupons form span8">    
    <?php echo $this->Form->create('Coupon'); ?>
    <fieldset>

        <legend><?php echo __('Admin Add Coupon'); ?></legend>

        <?php
        echo $this->Form->input('code');
        echo $this->Form->input('name_fr');
        echo $this->Form->input('name_en');
        echo $this->Form->input('description_fr');
        echo $this->Form->input('description_en');
        echo $this->Form->input('offered_by', array('options' => array('topmenu' => __('Topmenu'), 'restaurant' => __('Restaurant'))));
        ?>

        <!-- autcomplete box -->
        <div class="control-group">
            <div class="controls text">
                <label for="CouponUserId" style="margin-right:10px;" class="control-label">
                    <?php echo __('User'); ?>
                </label>
                <input type="hidden" id="project-id">   <!-- must not be after input. The next hidden field with be fill with the value for submission -->
                <input id="project" placeholder="<?php echo __('Leave Empty for all users'); ?>">                
                <p id="project-description"></p>
            </div>
        </div>

        <?php
        echo $this->Form->input('user_id', array('type' => 'hidden'));
        echo $this->Form->input('location_id', array('empty' => __('ALL RESTAURANTS')));
        echo $this->Form->input('amount_type', array('options' => array('percent' => __('Percent'), 'cash' => __('Fixe cash amount'))));
        echo $this->Form->input('amount');
        echo $this->Form->input('is_enabled');
        echo $this->Form->input('start_date');
        echo $this->Form->input('end_date');
        echo $this->Form->input('max_usage', array('placeholder' => __('Leave empty for no max')));
        echo $this->Form->input('max_usage_by_user', array('value' => 1, 'placeholder' => __('Leave empty for no max')));
        echo $this->Form->input('max_usage_by_restaurant', array('placeholder' => __('Leave empty for no max')));
        echo $this->Form->hidden('admin_id', array(
            'value' => $this->Session->read('Auth.User.id')));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
