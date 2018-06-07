<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();

		// set error delimeters
		$this->form_validation->set_error_delimiters(
			$this->config->item('error_start_delimiter', 'ion_auth'),
			$this->config->item('error_end_delimiter', 'ion_auth')
		);

		// model
		$this->load->model(
			array(
				'profile_model',
				'inventory_model',
				'categories_model',
				'locations_model',
			)
		);

		// default datas
		// used in every pages
		if ($this->ion_auth->logged_in()) {
			// user detail
			$loggedinuser = $this->ion_auth->user()->row();
			$this->data['user_full_name'] = $loggedinuser->first_name . " " . $loggedinuser->last_name;
			$this->data['user_photo']     = $this->profile_model->get_user_photo($loggedinuser->username)->row();
		}
		$this->data['dummy'] = "";
	}

	public function index()
	{
		// inventory by category summary
		$this->data['total_inventory'] = count($this->inventory_model->get_inventory()->result());
		$this->data['total_category']  = count($this->categories_model->get_categories()->result());
		$this->data['total_location']  = count($this->locations_model->get_locations()->result());
		$this->data['summary']         = $this->inventory_model->get_inventory_by_category_summary();

		$this->load->view('partials/_alte_header', $this->data);
		$this->load->view('partials/_alte_menu');
		$this->load->view('welcome/welcome_message');
		$this->load->view('partials/_alte_footer');
		$this->load->view('welcome/js');
	}
}
