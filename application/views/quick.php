 <?php
	echo sf_form_open();  
	echo sf_fieldset_open('Your Details');
	echo sf_input('name');
	echo sf_input('email'); 
	echo sf_date('dob', 'Date of Birth', FALSE, FALSE, TRUE, FALSE); 
	echo sf_checkbox('terms', '&nbsp;', FALSE, 
			'I agree to the <a href="#">terms and conditions</a> of this service'); 
	echo sf_fieldset_close();
	echo sf_form_close('Sign me up!');
?>
