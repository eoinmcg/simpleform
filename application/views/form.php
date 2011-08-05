<h1>Simpleform demo</h1>

<?php echo sf_form_open(); ?>
<?php echo sf_fieldset_open('Contact Details'); ?>
<?php echo sf_input('name', 'Name'); ?>
<?php echo sf_input('email'); ?>
<?php echo sf_input('phone'); ?>
<?php echo sf_textarea('address'); ?>
<?php echo sf_fieldset_close(); ?>

<?php echo sf_fieldset_open('Dates'); ?>
<?php echo sf_date('dob', 'Date of Birth', FALSE, FALSE, TRUE, FALSE); ?>
<?php echo sf_date('today', 'Today', FALSE, FALSE, FALSE, TRUE); ?>
<?php echo sf_fieldset_close(); ?>

<?php echo sf_fieldset_open('Preferences', 'collapsible'); ?>
<?php echo sf_select('fruit', 'Fav Fruit', array('' => 'Please Select', 'apples' => 'Apples', 'oranges' => 'Oranges')); ?>
<?php echo sf_multi_select('beverage', 'Beverage', array('beer' => 'Beer', 'wine' => 'Wine', 'whiskey' => 'Whiskey')); ?>
<?php echo sf_radio('gender', 'Gender', array('male' => 'Male', 'female' => 'Female')); ?>
<?php echo sf_fieldset_close(); ?>

<?php echo sf_checkbox('notify', 'Notify me of future offers'); ?>
<?php echo sf_checkbox('terms', '&nbsp;', FALSE, 'I agree to the <a href="#">terms and conditions</a> of this service'); ?>

<?php echo sf_form_close(); ?>

