<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Refinements to the main CI_Form_validation class
 *
 * @scope			public
 * @package			CodeIgniter
 * @author			Eoin McGrath
 * @license			MIT
 *
 *
 */

class MY_Form_validation extends CI_Form_validation {


	// array for keeping track of required fields
	public $required = array();


	/**
	 * Set Rules
	 *
	 * Adds the fieldname into the $required array before calling the parent
	 * method. This allows simpleform_helper to know which fields are required
	 * WITHOUT the form being submitted
	 *
	 * @access	public
	 * @param	mixed
	 * @param	string
	 * @return	void
	 */
	function set_rules($field, $label = '', $rules = '')
	{

		// let's add it to the $required array
		array_push($this->required, $field);

		// and now run the main set_rules method
		parent::set_rules($field, $label, $rules);

	}


	/**
	 * Checks if field is required
	 *
	 * @access public
	 * @param string
	 * @return bool
	 */
	public function is_required($name)
	{

		return array_key_exists($name, $this->_field_data);

	}


}


/* End of file MY_Form_validation.php */
/* Location: APPATH . libraries/MY_Form_validation.php */

