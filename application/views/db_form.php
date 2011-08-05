<h1>Load form from database</h1>

<?php echo sf_form_open(); ?>
<?php echo sf_db_table('content', $data, $ignore); ?>
<?php echo sf_form_close(); ?>

