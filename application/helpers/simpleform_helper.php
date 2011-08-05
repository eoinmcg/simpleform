<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Simpleform
 *
 * Collection of functions that make outputting a wee bit easier
 *
 * @scope			public
 * @package			CodeIgniter
 * @author			Eoin McGrath (eoin.mcg@gmail.com / @eoinmcg)
 * @link			http://github.com/eoinmcg/simpleforms
 * @license			MIT / GPL
 *
 *
 */

// ------------------------------------------------------------------------

/**
 * Wrapper for CI's 'form_open, will also prepend and validation errors
 *
 * @access	public
 * @param	string	$action				uri to where the form is submitted
 * @param	array	$attributes			a key/value pair of attributes for the form
 * @param	bool	$allow_files		puts multipart/form-data in the form tag is true
 * @param	bool	$hide_error_msg		toggles validation error message preprended to form
 * @return	string
 */
function sf_form_open($action = FALSE, $attributes = FALSE, $allow_files=FALSE, $hide_error_msg = FALSE)
{

	$CI =& get_instance();

	$hash = (is_array($attributes) && array_key_exists('id', $attributes))
			? '#'.$attributes['id'] : '';

	$action = ($action)
		? ltrim($action, "\\") // remove opening slash from $action if necessary
		: $CI->uri->uri_string() . $hash; // as no action was specified let's submit to current page & form

	if (!function_exists('form_open'))
	{
		$CI->load->helper('form');
	}


	$form = ($allow_files)
		? form_open_multipart($action, $attributes)
		: form_open($action, $attributes);

	// prepend validation errors if there are any
	$form .= (function_exists('validation_errors') && !$hide_error_msg
		&& $err = validation_errors() )
		? '<div class="error">'.$err.'</div>'
		: '';

	// display a message notifying user which fields are required
	if (isset($CI->form_validation->required)
		&& count($CI->form_validation->required))
	{
		$form .= '<div class="note">Fields marked
					<span class="required">*</span> are required</div>';
	}

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Generate submit button. Wrapped in div.submit
 *
 * @access	public
 * @param	string	$val		Text in the submit button
 * @param	string	$accesskey	optional, set accesskey for accessability
 * @return	string
 */
function sf_form_close($val = 'Send', $accesskey = FALSE)
{

	$accesskey = ($accesskey) ? ' accesskey="'.$accesskey.'"' : '';

	$form = '<div class="submit">';
	$form .= '<input type="submit" value="'.$val.'" '.$accesskey.' />';
	$form .= '</div>';
	$form .= '</form>';

	return $form;

}


// ------------------------------------------------------------------------

/**
 * Open fieldset
 *
 * @param string	$legend
 * @param string	$class
 * @return string
 */
function sf_fieldset_open($legend, $class='')
{

	if (!empty($class))
	{
		$class = ' class="'.$class.'"';
	}

	$form = '<fieldset'.$class.'><legend>'.$legend.'</legend>';

	return $form;
}

// ------------------------------------------------------------------------

/**
 * Close fieldset
 *
 * @return string
 */
function sf_fieldset_close()
{
	return '</fieldset>';
}

// ------------------------------------------------------------------------

/**
 * Creates a text input field wrapped in div served with an optional note
 * Error class will be added if fails validation
 *
 * @access	public
 * @param	string	$name	name attribute for input (this is also id)
 * @param	string	$label	optional. if not specified $name param will be used
 * @param	string	$val	value attribute
 * @param	string	$note	optional note. gives user more information about field
 * @return	string
 */
function sf_input($name, $label = FALSE, $val='', $note=FALSE, $small=FALSE)
{

	$label = _sf_set_label($name, $label);
	$val = _sf_set_value($val, $name); // override $val if a new one has been posted

	// so you can have smaller input field size (controlled by css)
	$class = ($small) ? 'row small' : 'row';

	$form = _sf_open_row($name, $class);
	$form .= '<label for="'.$name.'">'.$label.'</label>';
	$form .= '<input type="text" id="'.$name.'" 
				name="'.$name.'" 
				value="'.form_prep($val, $name).'" />';

	if ($note)
	{
		$form .= '<p class="note">'.$note.'</p>';
	}
	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Password Input Field. Wrapped in div, served with optional note and error
 * if fails validation
 *
 * @access	public
 * @param	string	$name	name attribute for input (this is also id)
 * @param	string	$label	optional. if not specified $name param will be used
 * @param	string	$val	value attribute
 * @param	string	$note	optional note. gives user more information about field
 * @return	string
 */
function sf_password($name, $label = FALSE, $val='', $note=FALSE)
{

	$label = _sf_set_label($name, $label);
	$val = _sf_set_value($val, $name);	// override $val if a new one has been posted

	$form = _sf_open_row($name, 'row');
	$form .= '<label for="'.$name.'">'.$label.'</label>';
	$form .= '<input type="password" id="'.$name.'" 
		name="'.$name.'" 
		value="'.form_prep($val, $name).'" />';

	if ($note)
	{
		$form .= '<p class="note">'.$note.'</p>';
	}
	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Hidden Input Field. Wrapped in div with hidden class
 *
 * @access	public
 * @param	string	$name	name attribute for input (this is also id)
 * @param	string	$val	value attribute. will be overwritten if a new POSTd
 * @return	string
 */
function sf_hidden($name, $val='')
{

	$val = _sf_set_value($val, $name);	// override $val if a new one has been posted

	$form = '<div class="hidden">';
	$form .= '<input type="hidden" name="'.$name.'" 
				value="'.form_prep($val, $name).'" />';
	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Textarea field.
 * With optional note and error class added in case of validation fail
 *
 * @access	public
 * @param	string	$name	name attribute for input (this is also id)
 * @param	string	$label	optional. if not specified $name param will be used
 * @param	string	$val	value attribute
 * @param	string	$note	optional note. gives user more information about field
 * @param	string	$class	optional note. css class
 * @return	string
 */
function sf_textarea($name, $label = FALSE, $val='', $note=FALSE, $class='')
{

	$label = _sf_set_label($name, $label);
	$val = _sf_set_value($val, $name);	// override $val if a new one has been posted

	$form = _sf_open_row($name, $class);
	$form .= '<label for="'.$name.'">'.$label.'</label>';
	$form .= '<textarea id="'.$name.'" name="'.$name.'" class="'.$class.'"
				rows="5" cols="60">'.$val.'</textarea>';

	if ($note)
	{
		$form .= '<p class="note">'.$note.'</p>';
	}
	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Checkbox Field.
 * Wrapped in div, optional note and error class if validation fail
 *
 * @access	public
 * @param	string	$name	name attribute for input (this is also id)
 * @param	string	$label	optional. if not specified $name param will be used
 * @param	string	$val	value attribute
 * @param	string	$note	optional note. gives user more information about field
 * @return	string
 */
function sf_checkbox($name, $label = FALSE, $val='', $note = FALSE)
{

	$label = _sf_set_label($name, $label);
	$val = _sf_set_value($val, $name);	// override $val if a new one has been posted

	$checked = ($val) ? 'checked="checked"' : '';

	$form = _sf_open_row($name, 'checkbox');
	$form .= '<label for="'.$name.'">'.$label.'</label>';
	$form .= '<input type="checkbox" id="'.$name.'" 
				name="'.$name.'" '.$checked.' />';

	if ($note)
	{
		$form .= '<p class="note">'.$note.'</p>';
	}

	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Creates a group of radio buttons from array
 * Wrapped in div, served with optional note and error
 *
 * @access	public
 * @param	string	$name		name attribute for input (this is also id)
 * @param	string	$label		optional. if not specified $name param will be used
 * @param	array	$options	options for radio buttons
 * @param	string	$val		preset value attribute. pass a a comma delimited string
 * @param	string	$note		optional note. gives user more information about field
 * @return	string
 */
function sf_radio($name, $label = FALSE, $options = array(), $val = FALSE, $note = FALSE)
{

	$label = _sf_set_label($name, $label);
	$val = array_key_exists($name, $_POST)
		? $_POST[$name] : explode(',', $val);

	$form = _sf_open_row($name, FALSE, 'array');
	$form .= '<label>'.$label.'</label>';

	foreach ($options as $k => $option)
	{
		$selected = (in_array($option, $val)) ? ' checked' : '';
		$title = str_replace('_', ' ', ucfirst($option));

		$form .= '<div class="row radiocheck">
					<input type="radio" name="'.$name.'[]"
					value="'.$option.'"'.$selected.'>'.$title.'</div>';
	}


	if($note)
	{
		$form .= '<p class="note">'.$note.'</p>';
	}

	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Creates a select dropdown from array
 * Wrapped in div, served with optional note and error
 *
 * @access	public
 * @param	string	$name		name attribute for input (this is also id)
 * @param	string	$label		optional. if not specified $name param will be used
 * @param	array	$options	options for select dropdown
 * @param	string	$val		value attribute
 * @param	string	$note		optional note. gives user more information about field
 * @return	string
 */
function sf_select($name, $label = FALSE, $options = array(), $val=FALSE, $note=FALSE)
{

	$label = ($label) ? $label : ucfirst($name);

	$val = (!$val && array_key_exists($name, $_POST))
		? $_POST[$name]
		: $val;

	$form = _sf_open_row($name, '');
	$form .= '<label for="'.$name.'">'.$label.'</label>';
	$form .= '<select name="'.$name.'" id="'.$name.'">';

	foreach($options as $k => $v)
	{
		$selected = ($val === $k) ? ' selected="selected"' : '';
		$form .= '<option value="'.$k.'"'.$selected.'>'.$v.'</option>';
	}

	$form .= '</select>';

	if($note)
	{
		$form .= '<p class="note">'.$note.'</p>';
	}

	$form .= '</div>';


	return $form;


}

// ------------------------------------------------------------------------

/**
 * Creates a list of checkboxes from array
 * Wrapped in div, served with optional note and error
 *
 * @access	public
 * @param	string	$name		name attribute for input (this is also id)
 * @param	string	$label		optional. if not specified $name param will be used
 * @param	array	$options	options for checkboxes
 * @param	string	$val		preset value attribute. pass a a comma delimited string
 * @param	string	$note		optional note. gives user more information about field
 * @return	string
 */
function sf_multi_select($name, $label = FALSE, $options = array(), $val='', $note=FALSE)
{

	$label = _sf_set_label($name, $label);
	$val = array_key_exists($name, $_POST)
		? $_POST[$name] : explode(',', $val);

	$form = _sf_open_row($name, FALSE, 'array');
	$form .= '<label>'.$label.'</label>';

	foreach ($options as $k => $option)
	{
		$selected = (in_array($option, $val)) ? ' checked' : '';
		$title = str_replace('_', ' ', ucfirst($option));

		$form .= '<div class="row radiocheck">
				<input type="checkbox" name="'.$name.'[]"
				value="'.$option.'"'.$selected.'>'.$title.'</div>';
	}


	if($note)
	{
		$form .= '<p class="note">'.$note.'</p>';
	}

	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Generates a 3 select fields for day month year
 * Wrapped in div, with error message
 *
 * @access	public
 * @param	string	$name
 * @param	string	$label
 * @param	int		$date				this must be a UNIX timestamp
 * @param	array	$year_range			year to start and end
 * @param	bool	$set_blank			whether you can have blank dates in the select options
 * @param	bool	$show_hours_mins	whether to display hours and mins.
 * @return	string
 */
function sf_date($name, $label = FALSE, $date = FALSE, $year_range = FALSE,
					$set_blank = FALSE, $show_hours_mins = FALSE)
{

	$year_range = ($year_range && is_array($year_range))
		? $year_range : array('1920', '2020');

	$label = _sf_set_label($name, $label);
	$date = (array_key_exists($name.'_day', $_POST) && !$set_blank)
		? _sf_mktime($name) : $date;


	// a date has been specified. use it to set the date
	if($date)
	{
		$day =  date('d', $date);
		$month =  date('m', $date);
		$year =  date('Y', $date);
		$hour =  date('H', $date);
		$min =  date('i', $date);
	}
	// we shouldn't set blank dates, so let's use todays date
	elseif (!$set_blank)
	{
		$day =  date('d', time());
		$month =  date('m', time());
		$year =  date('Y', time());
		$hour =  date('H', time());
		$min =  date('i', time());

	}
	// default to a blank date
	else
	{
		$day = '';
		$month = '';
		$year = '';
		$hour = '';
		$min = '';
	}

	// for validation purpose, generate a hidden $name field IF all keys are present
	$keys = array($name.'_day', $name.'_month', $name.'_year');
	$keys_present = 0;
	foreach ($keys as $key)
	{
		if (array_key_exists($key, $_POST) && !empty($_POST[$key]))
		{
			$keys_present++;
		}

	}

	$form = ($keys_present === count($keys))
		? sf_hidden($name, _sf_mktime($name))
		: '';

	$allow_blank = $set_blank;

	$form .= _sf_open_row($name, '', $type='date');
	$form .= '<label> '.$label.' </label>';
	$form .= _sf_date_range($day, $name, 'day', array(1, 31), $allow_blank);

	$form .= '<b> Month: </b>';
	$form .= '<select name="'.$name.'_month" id="'.$name.'_month">';
	$form .= _sf_date_month($month, $name, $allow_blank);
	$form .= '</select>';

	$form .= _sf_date_range($year, $name, 'year', $year_range, $allow_blank);


	if ($show_hours_mins)
	{
		$form .= _sf_date_range($hour, $name, 'hour', array(0, 23), $allow_blank);

		$form .= ' : ';
		$form .= _sf_date_range($min, $name, 'min', array(0, 59), $allow_blank);
	}

	$form .= '</div>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Creates drop down for with a specified numeric range
 *
 * @access	private
 * @param	int		$min
 * @param	string	$name
 * @param	bool	$allow_blank
 * @return	string
 */
function _sf_date_range($val, $name, $key, $range, $allow_blank = FALSE)
{
	$val = (empty($val) && array_key_exists($name . "_$key", $_POST))
		? $_POST[$name . "_$key"] : $val;


	$form = ($key == 'hour' || $key == 'min')
		? ' '
		: '<b>'.ucfirst($key).': </b>';
	$form .= '<select name="'.$name.'_'.$key.'" id="'.$name.'_'.$key.'">';
	$form .= ($allow_blank) ? '<option value=""></option>' : '';


	for ( $i = $range[0]; $i <= $range[1]; $i ++)
	{
		$select = ($val == $i && !empty($val)) ? ' selected' : '';

		$num = ($i <= 9) ? "0$i" : $i;

		$form .= '<option value="'.$i.'"'.$select.'>'.$num.'</option>';
	}

	$form .= '</select>';

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Create drop down for month field
 *
 * @access	private
 * @param	int		$day
 * @param	string	$month
 * @param	bool	$allow_blank
 * @return	string
 */
function _sf_date_month($month, $name, $allow_blank = FALSE)
{

	$month = (empty($month) && array_key_exists($name.'_month', $_POST))
		? $_POST[$name.'_month'] : $month;


	$m = array(''=> '', 1=>'Jan', 2=>'Feb', 3=>'Mar', 4=>'Apr', 5=>'May',
				6=>'Jun', 7=>'Jul', 8=>'Aug', 9=>'Sep', 10=>'Oct', 
				11=>'Nov', 12=>'Dec');

	if (!$allow_blank)
	{
		unset($m['']);
	}

	$form = '';

	foreach ($m as $key => $val)
	{
		$select = ($month == $key) ? ' selected' : '';
		$form .= '<option value="'.$key.'"'.$select.'>'.$val.'</option>';
	}

	return $form;

}


// ------------------------------------------------------------------------

/**
 * Creates a form based on a table (MySQL only)
 *
 * will try to guess which type of form input to generate;
 * int, with a length of 1 = checkbox
 * int, with a length of 11 = date
 * text or varchar >= 512 = textarea
 * varchar = input text (default)
 *
 * @access	public
 * @param	string	$table				name of table
 * @param	array	$data				prepopulates form
 * @param	array	$ignore				fields not too include in the form
 * @param	bool	$show_primary_key	whether to display the primary key in the form
 * @return	string
 */
function sf_db_table($table, $data = array(), $ignore = array(), $show_primary_key = FALSE)
{

	$data = (is_array($data)) ? $data : array();
	$ignore = (is_array($ignore)) ? $ignore : array();

	$CI =& get_instance();

	if (!$CI->db->table_exists($table))
	{
		die('Table does not exist');
	}

	$form = '';
	$fields = $CI->db->query("SHOW COLUMNS FROM $table");
	foreach($fields->result_array() as $field)
	{

		if (strpos($field['Type'], '('))
		{
			list($field['Type'], $field['Length']) = explode('(', $field['Type']);
		}
		else
		{
			$field['Length']  = '';
		}

		$field['Length'] = (int) str_replace(')', '', $field['Length']);
		$value = (array_key_exists($field['Field'], $data)) 
					? $data[$field['Field']] : null;

		if (in_array($field['Field'], $ignore) OR (($field['Key'] === 'PRI'
				&& $show_primary_key === FALSE)))
		{
			$form .= sf_hidden($field['Field'], $value);
		}
		elseif ($field['Type'] === 'int' && $field['Length'] === 11)
		{
			$form .= sf_date($field['Field'], FALSE, $value);
		}
		elseif ($field['Length'] === 1)
		{
			$form .= sf_checkbox($field['Field'], FALSE, $value);
		}
		elseif ($field['Type'] === 'text' OR $field['Length'] >= 512)
		{
			$form .= sf_textarea($field['Field'], FALSE, $value);
		}
		elseif ($field['Field'] === 'password' OR $field['Field'] === 'pass')
		{
			$form .= sf_password($field['Field']);
		}
		else
		{
			$form .= sf_input($field['Field'], FALSE, $value);
		}

	}

	return $form;

}

// ------------------------------------------------------------------------

/**
 * Creates the opening div tag for the input
 * If the $name is passed we check for validation errors
 * and add an error class to the input
 *
 * @access	private
 * @param	string
 * @param	string
 * @return	string
 */
function _sf_open_row($name = FALSE, $class = '', $type = FALSE)
{

	$CI =& get_instance();
	// check if the field is required. we need this to in the case of date fields to
	// work out the when to apply the error class
	// NOTE: this may break in future versions of CI if form_validation->_field_data is indeed made private
	$is_required = (isset($CI->form_validation)
					&& array_key_exists($name, $CI->form_validation->_field_data))
		? TRUE : FALSE;

	$error_msg = '';

	if (count($_POST) && $type === 'date' && $is_required)
	{
		$error_msg = ( empty($_POST[$name.'_day'])
						OR empty($_POST[$name.'_month'])
						OR empty($_POST[$name.'_year']) )
			? ' row_error' : '';

	}
	elseif (count($_POST) && $type === 'array' && $is_required)
	{
		$error_msg = ( !array_key_exists($name, $_POST) 
						OR !is_array($_POST[$name]) )
			? ' row_error' : '';

	}
	else
	{
		$error_msg = ( $name && (strlen(form_error($name))) )
			? ' row_error' : '';
	}


	$class = ' class="'.$class.$error_msg.'"';

	return "\n".'<div'.$class.'>';

}

// ------------------------------------------------------------------------

/**
 * Sets the label for a given field.
 * If label is not specified a cleaned version of $name will be used
 *
 * @access	private
 * @param	string	$name
 * @param	string	$label
 * @return	string
 */
function _sf_set_label($name, $label)
{

	$label = ($label) ? $label : str_replace('_', ' ', ucfirst($name));
	$CI =& get_instance();
	// defensive measure in case Form_validation class has not been extended
	$required = isset($CI->form_validation->required)
					? $CI->form_validation->required
					: array();

	if (in_array($name, $required))
	{
		$label .= ' <span class="required">*</span>';
	}

	return $label;

}

// ------------------------------------------------------------------------

/**
 * Gets value of input. $val is the default which can be overriden by a new
 * value being posted
 *
 * @access	private
 * @param	string	$val	current $val
 * @param	string	$name	name/ id of field. needed to reference the $_POST array
 * @return	string
 */
function _sf_set_value($val, $name)
{

	$val = array_key_exists($name, $_POST) ? $_POST[$name] : $val;
	return $val;

}

// ------------------------------------------------------------------------

/**
 * Converts date fields (d,m,y) into unixtime stamp
 *
 * @access	private
 * @param	name	of date group
 * @return	int
 */
function _sf_mktime($name)
{

	$d = (array_key_exists($name.'_day', $_POST)) 
		? (int) $_POST[$name.'_day'] : 1;
	$m = (array_key_exists($name.'_month', $_POST)) 
		? (int) $_POST[$name.'_month'] : 1;
	$y = (array_key_exists($name.'_year', $_POST)) 
		? (int) $_POST[$name.'_year'] : 1;
	$h = (array_key_exists($name.'_hour', $_POST)) 
		? (int) $_POST[$name.'_hour'] : 0;
	$min = (array_key_exists($name.'_min', $_POST)) 
		? (int) $_POST[$name.'_min'] : 0;

	$unix_time = mktime($h, $min, 0, $m, $d, $y);

	return $unix_time;

}


/* End of file sf_form_helper.php */
/* Location: APPATH . helpers/cms_form_helper.php */
