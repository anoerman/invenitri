<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Status Controller
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
class Status extends CI_Controller {

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
				'status_model',
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
	*	Showing list of status and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/status', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list'] = $this->status_model->get_status();

			// Set pagination
			$config['base_url']         = base_url('status/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->status_model->get_status("",
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
			$this->load->view('inv_status/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_status/js');
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
			redirect('auth/login/status', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('name', 'Status Name',
				'alpha_numeric_spaces|trim|required|callback__name_check'
			);
			$this->form_validation->set_rules('description', 'Descriptions', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'name'        => $this->input->post('name'),
						'description' => $this->input->post('description'),
						'deleted'     => '0',
					);

					// check to see if we are inserting the data
					if ($this->status_model->insert_status($data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Status Saved Successfully!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Status Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('status', 'refresh');
				}
			}
			$this->data['data_list'] = $this->status_model->get_status();
			$this->data['open_form'] = "open";

			// Set pagination
			$config['base_url']         = base_url('status/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);
			// Get datas and limit based on pagination settings
			$page = 1;
			$this->data['data_list'] = $this->status_model->get_status("",
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
			$this->load->view('inv_status/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_status/js');
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
		$datas = $this->status_model->name_check($name);
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
			redirect('auth/login/status', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('name', 'Status Name', 'trim|required');
			$this->form_validation->set_rules('description', 'Descriptions', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'name'         => $this->input->post('name'),
						'description' => $this->input->post('description'),
					);

					// check to see if we are updating the data
					if ($this->status_model->update_status($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Status Updated!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Status Update Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('status', 'refresh');
				}
			}
			// Get data
			$this->data['data_list'] = $this->status_model->get_status($id);
			$this->data['id']        = $id;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_status/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_status/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to status
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
			redirect('auth/login/status', 'refresh');
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
					if ($this->status_model->update_status($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Status Deleted!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Status Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			// Always redirect no matter what!
			redirect('status', 'refresh');
		}
	}
	// Delete data end
}

/* End of Status.php */
