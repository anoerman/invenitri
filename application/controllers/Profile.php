<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Profile Controller
*
*	@author		Noerman Agustiyan
* 					noerman.agustiyan@gmail.com
*						@anoerman
*
*	@link 		https://github.com/anoerman
*		 				https://gitlab.com/anoerman
*
*	Controller semua kegiatan yang terjadi pada halaman profile
*	Dapat diakses oleh user group admin dan member
*
*	Melakukan pengaturan terhadap data yang berhubungan dengan
*	profile pengguna aplikasi seperti mengubah data nama, nomor
*	handphone serta foto
*
*/
class Profile extends CI_Controller {

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
	*
	*	@return 	void
	*
	*/
	public function index()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/profile', 'refresh');
		}
		// Jika login
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');


			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('profile/index');
			$this->load->view('partials/_alte_footer');
		}
	}

	/**
	*	Edit Profile
	*
	*	@return 	void
	*
	*/
	public function edit()
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/profile', 'refresh');
		}
		// Jika login
		else
		{
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			// input validation rules
			$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
			$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
			$this->form_validation->set_rules('phone', 'Phone', 'numeric|trim|required');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// update the password if it was posted
				if ($this->input->post('password'))
				{
					$this->form_validation->set_rules('password', 'New Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
					$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required');
				}

				// validation run
				if ($this->form_validation->run() === TRUE) {
					$data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'phone' => $this->input->post('phone'),
					);

					// update the password if it was posted
					if ($this->input->post('password')) {
						$data['password'] = $this->input->post('password');
					}

					// check to see if we are updating the user
					$user = $this->ion_auth->user($this->input->post('id'))->row();
					if ($this->ion_auth->update($user->id, $data)) {
						// upload and change user photo
						$link_foto    = "";
						$link_thumbnail = "";
						if (!empty($_FILES['user_photo']['name'])) {
							$config['file_name']     = str_replace(" ", "", strtolower(trim(addslashes($this->input->post("username")))));
							$config['upload_path']   = './assets/uploads/images/profile/';
							$config['allowed_types'] = 'gif|jpg|png';
							$config['max_size']      = 2048;
							$config['overwrite']     = TRUE;
							$this->load->library('upload', $config);
							// fail to upload
							if ( ! $this->upload->do_upload('user_photo')) {
								// redirect back
								$this->session->set_flashdata('message', array('error' => $this->upload->display_errors()));
								$this->load->view('partials/_alte_header', $this->data);
								$this->load->view('partials/_alte_menu');
								$this->load->view('profile/edit');
								$this->load->view('partials/_alte_footer');
							}
							// upload success, get path and filename
							else {
								$upload_data = $this->upload->data();

								// Proses pembuatan thumbnail
								$config['image_library']  = 'gd2';
								$config['source_image']   = "assets/uploads/images/profile/".$upload_data['file_name'];
								$config['create_thumb']   = TRUE;
								$config['maintain_ratio'] = TRUE;
								$config['width']          = 160;
								$this->load->library('image_lib', $config);
								if ($this->image_lib->resize()){
									$link_foto      = $upload_data['file_name'];
									$link_thumbnail = $upload_data['raw_name'] . "_thumb" . $upload_data['file_ext'];
								}

								// save to database
								$datas['photo']     = $link_foto;
								$datas['thumbnail'] = $link_thumbnail;
								$this->profile_model->update_user_photo($this->input->post('username'), $datas);
							}
						}

						// redirect them back to the admin page if admin, or to the base url if non admin
						$this->session->set_flashdata('message', $this->ion_auth->messages());
					}
					else {
						// redirect them back to the admin page if admin, or to the base url if non admin
						$this->session->set_flashdata('message', $this->ion_auth->errors());
					}
					redirect('profile', 'refresh');
				}
			}

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('profile/edit');
			$this->load->view('partials/_alte_footer');
		}
	}

}
