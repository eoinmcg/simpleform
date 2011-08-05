<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Simpleform extends CI_Controller {

	public $data;


	public function __construct()
	{
		parent::__construct();

		$this->load->helper('url');
		$this->data = array();

	}


	public function index()
	{
		$this->load->helper('simpleform');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->form_validation->set_rules('dob', 'Date of Birth', 'required');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('address', 'Address', 'required');
		$this->form_validation->set_rules('fruit', 'Fav Fruit', 'required');
		$this->form_validation->set_rules('beverage', 'Beverage', 'required');
		$this->form_validation->set_rules('gender', 'Gender', 'required');


		$this->data['form'] = 'form';

		if (count($_POST))
		{
			if ($this->form_validation->run())
			{
				echo '<h1>VALID</h1>';
				var_dump($_POST);
				return;

			}
		}


		$this->load->view('master', $this->data);
	}



	public function db_form($table = 'content')
	{

		$this->load->database();
		$this->load->helper('simpleform');

		$this->data['ignore'] = array('parent', 'cat', 'subcat', 'lang', 'user_id', 'modified', 'snippets', 'keywords', 'rank', 'headline', 'image');

		$query = $this->db->where('id', 1)->get($table);
		$this->data['data'] = $query->row_array();

		$this->data['form'] = 'db_form';
		$this->load->view('master', $this->data);

	}



	public function quick()
	{

		$this->load->helper('simpleform');
		$this->load->helper('form');
		$this->load->library('form_validation');

		$this->data['form'] = 'quick';
		$this->load->view('master', $this->data);

	}

}

/* End of file simpleform.php */
/* Location: ./application/controllers/simpleform.php */

