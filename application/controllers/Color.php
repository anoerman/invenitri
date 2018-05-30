<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Color Controller
*
*	@author Noerman Agustiyan
* 				noerman.agustiyan@gmail.com
*					@anoerman
*
*	@link 	https://github.com/anoerman
*		 			https://gitlab.com/anoerman
*
*	Accessible for admin user group
*
*/
class Color extends CI_Controller {

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
				'color_model',
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
	}

	/**
	*	Index Page for this controller.
	*	Showing list of color and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/color', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list'] = $this->color_model->get_color();

			// Set pagination
			$config['base_url']         = base_url('color/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->color_model->get_color("",
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message']   = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('mst_color/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('mst_color/js');
			$this->load->view('js_script');
		}
	}
	// Index end

	/**
	*	Add New Data
	*	If there's data sent, insert
	*	Else, show the form
	*
	*	@return 	void
	*
	*/
	public function add()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/color', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('name', 'Color Name', 'trim|required|callback__name_check');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'name'    => $this->input->post('name'),
						'deleted' => '0',
					);

					// check to see if we are inserting the data
					if ($this->color_model->insert_color($data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Color Saved Successfully!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Color Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('color', 'refresh');
				}
			}
			$this->data['data_list'] = $this->color_model->get_color();
			$this->data['open_form'] = "open";

			// Set pagination
			$config['base_url']         = base_url('color/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			$page = 1;
			$this->data['data_list'] = $this->color_model->get_color("",
				$config['per_page'],
				( $page - 1 ) * $config['per_page']
			);
			// $this->data['last_query'] = $this->db->last_query();
			$this->data['pagination'] = $this->pagination->create_links();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('mst_color/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('mst_color/js');
			$this->load->view('js_script');
		}
	}
	// Add data end

	/**
	*	Callback to check duplicate name
	*
	*	@param 		string 		$name
	*	@return 	bool
	*
	*/
	public function _name_check($name)
	{
		$datas = $this->color_model->name_check($name);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message(
				'_name_check', '{field} with the name "'.$name.'" already exists.'
			);
			return FALSE;
		}
	}
	// End _name_check

	/**
	*	Edit Data
	*	If there's data sent, update
	*	Else, show the form
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function edit($id)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login/color', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('name', 'Name', 'trim|required');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'name' => $this->input->post('name'),
					);

					// check to see if we are updating the data
					if ($this->color_model->update_color($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Color Updated!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Color Update Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('color', 'refresh');
				}
			}

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			// Get data
			$this->data['data_list'] = $this->color_model->get_color($id);
			$this->data['id']          = $id;

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('mst_color/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('mst_color/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to color
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function delete($id)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/color', 'refresh');
		}
		// Jika login
		else
		{
			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {

				// input validation rules
				$this->form_validation->set_rules('id', 'ID', 'trim|numeric|required');

				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'deleted' => '1',
					);

					// check to see if we are updating the data
					if ($this->color_model->update_color($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Color Deleted!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Color Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			// Always redirect no matter what!
			redirect('color', 'refresh');
		}
	}
	// Delete data end
}

/* End of Color.php */
