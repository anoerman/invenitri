<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Locations Controller
*
*	@author 	Noerman Agustiyan
* 					noerman.agustiyan@gmail.com
*						@anoerman
*
*	@link 		https://github.com/anoerman
*		 				https://gitlab.com/anoerman
*
*	Accessible for admin and member user group
*
*/
class Locations extends CI_Controller {

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
	}

	/**
	*	Index Page for this controller.
	*	Showing list of locations and add new form
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function index($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/locations', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list'] = $this->locations_model->get_locations();

			// Set pagination
			$config['base_url']         = base_url('locations/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->locations_model->get_locations("",
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
			$this->load->view('inv_location/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_location/js');
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
			redirect('auth/login/locations', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('code', 'Code', 'alpha_numeric|trim|required|callback__code_check');
			$this->form_validation->set_rules('name', 'Name', 'alpha_numeric_spaces|trim|required|callback__name_check');
			$this->form_validation->set_rules('detail', 'Detail', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'code'    => $this->input->post('code'),
						'name'    => $this->input->post('name'),
						'detail'  => $this->input->post('detail'),
						'deleted' => '0',
					);

					// check to see if we are inserting the data
					if ($this->locations_model->insert_location($data)) {
						// Success message
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Location Saved Successfully!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);

						// upload and change location photo
						$link_foto    = "";
						$link_thumbnail = "";
						if (!empty($_FILES['photo']['name'])) {
							$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('name')));
							$config['upload_path']   = './assets/uploads/images/locations/';
							$config['allowed_types'] = 'gif|jpg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$this->load->library('upload', $config);
							// fail to upload
							if ( ! $this->upload->do_upload('photo')) {
								// Error upload
								$this->session->set_flashdata('message',
									$this->config->item('success_start_delimiter', 'ion_auth')
									."Location Saved Successfully!<br>Failed to upload the photo!".
									$this->config->item('success_end_delimiter', 'ion_auth')
								);
							}
							// upload success, get path and filename
							else {
								$upload_data = $this->upload->data();

								// Proses pembuatan thumbnail
								$config['image_library']  = 'gd2';
								$config['source_image']   = "assets/uploads/images/locations/".$upload_data['file_name'];
								$config['create_thumb']   = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['width']          = 180;
								$this->load->library('image_lib', $config);
								if ($this->image_lib->resize()){
									$link_foto      = $upload_data['file_name'];
									$link_thumbnail = $upload_data['raw_name'] . "_thumb" . $upload_data['file_ext'];
								}

								// save to database
								$datas['photo']     = $link_foto;
								$datas['thumbnail'] = $link_thumbnail;
								$this->locations_model->update_location_by_code($this->input->post('code'), $datas);
							}
						}
					}
					else {
						// Error message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Location Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('locations', 'refresh');
				}
			}
			$this->data['data_list'] = $this->locations_model->get_locations();
			$this->data['open_form'] = "open";

			// Set pagination
			$config['base_url']         = base_url('locations/index');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			$page = 1;
			$this->data['data_list'] = $this->locations_model->get_locations("",
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
			$this->load->view('inv_location/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_location/js');
			$this->load->view('js_script');
		}
	}
	// Add data end

	/**
	*	Callback to check duplicate code
	*
	*	@param 		string 		$code
	*	@return 	bool
	*
	*/
	public function _code_check($code)
	{
		$datas = $this->locations_model->code_check($code);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message(
				'_code_check', 'The {field} already exists.'
			);
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Callback to check duplicate name
	*
	*	@param 		string 		$name
	*	@return 	bool
	*
	*/
	public function _name_check($name)
	{
		$datas = $this->locations_model->name_check($name);
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
			redirect('auth/login/locations', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('name', 'Name', 'alpha_numeric_spaces|trim|required');
			$this->form_validation->set_rules('detail', 'Detail', 'trim');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'name'    => $this->input->post('name'),
						'detail'  => $this->input->post('detail'),
					);

					// check to see if we are updating the data
					if ($this->locations_model->update_location($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Location Updated!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);

						// upload and change location photo
						$link_foto      = "";
						$link_thumbnail = "";
						if (!empty($_FILES['photo']['name'])) {
							$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('name')));
							$config['upload_path']   = './assets/uploads/images/locations/';
							$config['allowed_types'] = 'gif|jpg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$this->load->library('upload', $config);
							// fail to upload
							if ( ! $this->upload->do_upload('photo')) {
								// Error upload
								$this->session->set_flashdata('message',
									$this->config->item('success_start_delimiter', 'ion_auth')
									."Location Saved Successfully!<br>Failed to upload the photo!".
									$this->config->item('success_end_delimiter', 'ion_auth')
								);
							}
							// upload success, get path and filename
							else {
								$upload_data = $this->upload->data();

								// Proses pembuatan thumbnail
								$config['image_library']  = 'gd2';
								$config['source_image']   = "assets/uploads/images/locations/".$upload_data['file_name'];
								$config['create_thumb']   = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['width']          = 180;
								$this->load->library('image_lib', $config);
								if ($this->image_lib->resize()){
									$link_foto      = $upload_data['file_name'];
									$link_thumbnail = $upload_data['raw_name'] . "_thumb" . $upload_data['file_ext'];
								}

								// delete old Photo
								if ($this->input->post('curr_photo')!="") {
									unlink("assets/uploads/images/locations/".$this->input->post('curr_photo'));
									unlink("assets/uploads/images/locations/".$this->input->post('curr_thumbnail'));
								}

								// save to database
								$datas['photo']     = $link_foto;
								$datas['thumbnail'] = $link_thumbnail;
								$this->locations_model->update_location_by_code($this->input->post('code'), $datas);
							}
						}

					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Location Update Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('locations', 'refresh');
				}
			}
			// Get data
			$this->data['data_list'] = $this->locations_model->get_locations($id);
			$this->data['id']        = $id;

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_location/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_location/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to locations
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
			redirect('auth/login/locations', 'refresh');
		}
		// Jika login
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

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
					if ($this->locations_model->update_location($id, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('success_start_delimiter', 'ion_auth')
							."Location Deleted!".
							$this->config->item('success_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Location Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// Always redirect no matter what!
			redirect('locations', 'refresh');
		}
	}
	// Delete data end
}

/* End of locations.php */
