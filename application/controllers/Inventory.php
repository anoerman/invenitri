<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Inventory Controller
*
*	@author Noerman Agustiyan
* 				noerman.agustiyan@gmail.com
*					@anoerman
*
*	@link 	https://github.com/anoerman
*		 			https://gitlab.com/anoerman
*
*	Accessible for admin and member user group
*
*/
class Inventory extends CI_Controller {

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
				'status_model',
				'color_model',
				'logs_model',
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
	*	Showing add new data form and links to another locations.
	*
	*	@return 	void
	*
	*/
	public function index()
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// set the flash data error message if there is one
			$this->data['message']    = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->data['cat_list']   = $this->categories_model->get_categories('','','','asc');
			$this->data['stat_list']  = $this->status_model->get_status('','','','asc');
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['col_list']   = $this->color_model->get_color('','','','asc');
			$this->data['brand_list'] = $this->inventory_model->get_brands();

			// $this->data['last_query'] = $this->db->last_query();

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/index');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		}
	}
	// Index end

	/**
	*	All inventory data.
	*	Showing all inventory data without any filtering.
	* But still using pagination.
	*
	*	@param 		string 		$page
	*	@return 	void
	*
	*/
	public function all($page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			$this->data['data_list']  = $this->inventory_model->get_inventory();

			// Set pagination
			$config['base_url']         = base_url('inventory/all');
			$config['use_page_numbers'] = TRUE;
			$config['total_rows']       = count($this->data['data_list']->result());
			$config['per_page']         = 15;
			$this->pagination->initialize($config);

			// Get datas and limit based on pagination settings
			if ($page=="") { $page = 1; }
			$this->data['data_list'] = $this->inventory_model->get_inventory("",
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
			$this->load->view('inv_data/all_data');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			// $this->load->view('js_script');
		}
	}
	// All inventory data end

	/**
	*	Inventory by category.
	*	Showing inventory category name and total inventory per category.
	* Give link to each categorized inventory.
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function by_category($code="", $page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Get category detail
				$category_detail = $this->categories_model->get_categories_by_code($code);
				// If exists, set detailed data. Else redirect back because invalid code
				if (count($category_detail->result())>0) {
					foreach ($category_detail->result() as $cat_data) {
						$this->data['category_name'] = $cat_data->name;
						$this->data['category_desc'] = $cat_data->description;
					}
				}
				else {
					redirect('inventory/by_category', 'refresh');
				}

				// Show all data based on code
				$this->data['data_list']  = $this->inventory_model->get_inventory_by_category_code(
					$code
				);

				// Set pagination
				$config['base_url']         = base_url('inventory/by_category/'.$code);
				$config['use_page_numbers'] = TRUE;
				$config['total_rows']       = count($this->data['data_list']->result());
				$config['per_page']         = 15;
				$this->pagination->initialize($config);

				// Get datas and limit based on pagination settings
				if ($page=="") { $page = 1; }
				$this->data['data_list'] = $this->inventory_model->get_inventory_by_category_code(
					$code,
					$config['per_page'],
					( $page - 1 ) * $config['per_page']
				);
				// $this->data['last_query'] = $this->db->last_query();
				$this->data['pagination'] = $this->pagination->create_links();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_category_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
			// Summary
			else {
				// inventory by category summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_category_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_category_index');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');
			}
		}
	}
	// Inventory by category end

	/**
	*	Inventory by location.
	*	Showing inventory location name and total inventory per location.
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function by_location($code="", $page="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Get location detail
				$location_detail = $this->locations_model->get_locations_by_code($code);
				// If exists, set detailed data. Else redirect back because invalid code
				if (count($location_detail->result())>0) {
					foreach ($location_detail->result() as $loc_data) {
						$this->data['location_name'] = $loc_data->name;
						$this->data['location_desc'] = $loc_data->detail;
					}
				}
				else {
					redirect('inventory/by_location', 'refresh');
				}

				// Show all data based on code
				$this->data['data_list']  = $this->inventory_model->get_inventory_by_location_code(
					$code
				);

				// Set pagination
				$config['base_url']         = base_url('inventory/by_location/'.$code);
				$config['use_page_numbers'] = TRUE;
				$config['total_rows']       = count($this->data['data_list']->result());
				$config['per_page']         = 15;
				$this->pagination->initialize($config);

				// Get datas and limit based on pagination settings
				if ($page=="") { $page = 1; }
				$this->data['data_list'] = $this->inventory_model->get_inventory_by_location_code(
					$code,
					$config['per_page'],
					( $page - 1 ) * $config['per_page']
				);
				// $this->data['last_query'] = $this->db->last_query();
				$this->data['pagination'] = $this->pagination->create_links();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_location_data');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
			// Summary
			else {
				// inventory by location summary
				$this->data['summary'] = $this->inventory_model->get_inventory_by_location_summary();

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/by_location_index');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');
			}
		}
	}
	// Inventory by location end

	/**
	*	Inventory detail.
	*	Showing inventory detailed data
	* If code is provided, show data based on code.
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function detail($code)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			// If code is provided, show data based on code
			if ($code!="") {
				// Show detailed data based on code
				$this->data['data_detail'] = $this->inventory_model->get_inventory_by_code(
					$code
				);
				// Show logs
				$this->data['location_logs'] = $this->logs_model->get_location_log_by_code(
					$code
				);
				$this->data['status_logs'] = $this->logs_model->get_status_log_by_code(
					$code
				);

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors()
				: $this->session->flashdata('message');

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/detail');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				// $this->load->view('js_script');
			}
		}
	}
	// Inventory by category end

	/**
	*	Search
	*	Showing inventory search form.
	*
	* @param 		string
	*	@return 	void
	*
	*/
	public function search($process="")
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else{
			$this->data['cat_list']   = $this->categories_model->get_categories('','','','asc');
			$this->data['stat_list']  = $this->status_model->get_status('','','','asc');
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['col_list']   = $this->color_model->get_color('','','','asc');

			// input validation rules
			$this->form_validation->set_rules(
				'keyword',
				'Keyword',
				'alpha_numeric_spaces|trim|required|min_length[3]'
			);

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// validation run
				if ($this->form_validation->run() === TRUE) {
					// set variables for keyword and filters
					$keyword  = $this->input->post('keyword');
					$category = (!empty($this->input->post('category'))) ?
					implode($this->input->post('category'), ",") : "";
					$location = (!empty($this->input->post('location'))) ?
					implode($this->input->post('location'), ",") : "";
					$status   = (!empty($this->input->post('status'))) ?
					implode($this->input->post('status'), ",") : "";
					$filters  = array(
						'category_id' => $category,
						'location_id' => $location,
						'status'      => $status
					);
					$this->data['results'] = $this->inventory_model->get_inventory_by_keyword(
						$keyword,
						$filters
					);

					$this->session->set_flashdata('message',
						$this->config->item('success_start_delimiter', 'ion_auth')
						."Search results with keyword '$keyword'".
						$this->config->item('success_end_delimiter', 'ion_auth')
					);
				}
			}
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/search_form');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
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
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			$this->form_validation->set_rules('code', 'Code', 'alpha_numeric|trim|required|callback__code_check');
			$this->form_validation->set_rules('brand', 'Brand', 'trim|required|addslashes');
			$this->form_validation->set_rules('model', 'Model', 'trim|addslashes');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim|addslashes|callback__sn_check');
			$this->form_validation->set_rules('color', 'Color', 'trim|addslashes');
			$this->form_validation->set_rules('new_color', 'New Color', 'alpha_numeric_spaces|trim|addslashes');
			$this->form_validation->set_rules('length', 'Length', 'numeric|trim');
			$this->form_validation->set_rules('width', 'Width', 'numeric|trim');
			$this->form_validation->set_rules('height', 'Height', 'numeric|trim');
			$this->form_validation->set_rules('weight', 'Weight', 'numeric|trim');
			$this->form_validation->set_rules('price', 'Price', 'numeric|trim');
			$this->form_validation->set_rules('date_of_purchase', 'Date of Purchase', 'trim');
			$this->form_validation->set_rules('descriptions', 'Descriptions', 'trim|addslashes');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// color
				// if new color is not empty, set color - insert to master table
				$new_color = 0;
				$color     = $this->input->post('color');
				if ($this->input->post('new_color')!="") {
					$new_color = 1;
					$color     = ucwords(strtolower($this->input->post('new_color')));
				}

				// color array
				// insert only if color is not duplicate
				if ($new_color==1 && $this->_color_check($color)) {
					$data_new_color = array('name' => $color, );
					$this->color_model->insert_color($data_new_color);
				}

				// validation run
				if ($this->form_validation->run() === TRUE) {
					// inv data array
					$data = array(
						'code'             => $this->input->post('code'),
						'category_id'      => $this->input->post('category2'),
						'location_id'      => $this->input->post('location'),
						'brand'            => $this->input->post('brand'),
						'model'            => $this->input->post('model'),
						'serial_number'    => $this->input->post('serial_number'),
						'status'           => $this->input->post('status2'),
						'color'            => $color,
						'length'           => $this->input->post('length'),
						'width'            => $this->input->post('width'),
						'height'           => $this->input->post('height'),
						'weight'           => $this->input->post('weight'),
						'price'            => $this->input->post('price'),
						'date_of_purchase' => $this->input->post('date_of_purchase'),
						'description'      => $this->input->post('description'),
						'deleted'          => '0',
					);

					// logging array
					$data_location_log = array(
						'code'        => $this->input->post('code'),
						'location_id' => $this->input->post('location'),
					);
					$data_status_log = array(
						'code'      => $this->input->post('code'),
						'status_id' => $this->input->post('status2'),
					);

					// check to see if we are inserting the data
					if ($this->inventory_model->insert_data($data)) {
						// Insert logs
						$this->logs_model->insert_location_log($data_location_log);
						$this->logs_model->insert_status_log($data_status_log);

						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Data Saved Successfully!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);

						// upload and change inventory photo
						$link_foto      = "";
						$link_thumbnail = "";
						if (!empty($_FILES['photo']['name'])) {
							$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')));
							$config['upload_path']   = './assets/uploads/images/inventory/';
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
								$config['source_image']   = "assets/uploads/images/inventory/".$upload_data['file_name'];
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
								$this->inventory_model->update_inventory_by_code($this->input->post('code'), $datas);
							}
						}
					}
					else {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Data Saving Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('inventory', 'refresh');
				}

				// validation Failed
				else {
					// set the flash data error message if there is one
					$this->data['message']   = (validation_errors()) ? validation_errors() :
					$this->session->flashdata('message');

					$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
					$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
					$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
					$this->data['col_list']  = $this->color_model->get_color('','','','asc');
					$this->data['brand_list'] = $this->inventory_model->get_brands();

					$this->load->view('partials/_alte_header', $this->data);
					$this->load->view('partials/_alte_menu');
					$this->load->view('inv_data/add');
					$this->load->view('partials/_alte_footer');
					$this->load->view('inv_data/js');
					$this->load->view('js_script');
				}
			}

			else {
				// $this->data['data_list'] = $this->categories_model->get_categories();
				// set the flash data error message if there is one
				$this->data['message']   = (validation_errors()) ? validation_errors() :
				$this->session->flashdata('message');

				$this->data['cat_list']  = $this->categories_model->get_categories('','','','asc');
				$this->data['stat_list'] = $this->status_model->get_status('','','','asc');
				$this->data['loc_list']  = $this->locations_model->get_locations('','','','asc');
				$this->data['col_list']  = $this->color_model->get_color('','','','asc');
				$this->data['brand_list'] = $this->inventory_model->get_brands();

				$this->load->view('partials/_alte_header', $this->data);
				$this->load->view('partials/_alte_menu');
				$this->load->view('inv_data/add');
				$this->load->view('partials/_alte_footer');
				$this->load->view('inv_data/js');
				$this->load->view('js_script');
			}
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
		$datas = $this->inventory_model->code_check($code);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_code_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Callback to check duplicate sn
	*
	*	@param 		string 		$sn
	*	@return 	bool
	*
	*/
	public function _sn_check($sn)
	{
		if ($sn=="") {
			return TRUE;
		}

		$datas = $this->inventory_model->sn_check($sn);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_sn_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Callback to check duplicate color name
	*
	*	@param 		string 		$new_color
	*	@return 	bool
	*
	*/
	public function _color_check($new_color)
	{
		$datas = $this->color_model->name_check($new_color);
		$total = count($datas->result());
		if ($total == 0) {
			return TRUE;
		}
		else {
			$this->form_validation->set_message('_color_check', 'The {field} already exists.');
			return FALSE;
		}
	}
	// End _code_check

	/**
	*	Edit Data
	*	If there's data sent, update
	*	Else, show the form
	*
	*	@param 		string 		$code
	*	@return 	void
	*
	*/
	public function edit($code)
	{
		// Not logged in, redirect to home
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login/inventory', 'refresh');
		}
		// Logged in
		else {
			// input validation rules
			// $this->form_validation->set_rules('code', 'Code', 'alpha_numeric|trim|required|callback__code_check');
			$this->form_validation->set_rules('brand', 'Brand', 'trim|required|addslashes');
			$this->form_validation->set_rules('model', 'Model', 'trim|addslashes');
			$this->form_validation->set_rules('serial_number', 'Serial Number', 'trim|addslashes');
			$this->form_validation->set_rules('color', 'Color', 'trim|addslashes');
			$this->form_validation->set_rules('new_color', 'New Color', 'alpha_numeric_spaces|trim|addslashes');
			$this->form_validation->set_rules('length', 'Length', 'numeric|trim');
			$this->form_validation->set_rules('width', 'Width', 'numeric|trim');
			$this->form_validation->set_rules('height', 'Height', 'numeric|trim');
			$this->form_validation->set_rules('weight', 'Weight', 'numeric|trim');
			$this->form_validation->set_rules('price', 'Price', 'numeric|trim');
			$this->form_validation->set_rules('date_of_purchase', 'Date of Purchase', 'trim');
			$this->form_validation->set_rules('descriptions', 'Descriptions', 'trim|addslashes');

			// check if there's valid input
			if (isset($_POST) && !empty($_POST)) {
				// color
				// if new color is not empty, set color - insert to master table
				$new_color = 0;
				$color     = $this->input->post('color');
				if ($this->input->post('new_color')!="") {
					$new_color = 1;
					$color     = ucwords(strtolower($this->input->post('new_color')));
				}

				// color array
				// insert only if color is not duplicate
				if ($new_color==1 && $this->_color_check($color)) {
					$data_new_color = array('name' => $color, );
					$this->color_model->insert_color($data_new_color);
				}

				// validation run
				if ($this->form_validation->run() === TRUE) {
					// inv data array
					$data = array(
						'category_id'      => $this->input->post('category2'),
						'location_id'      => $this->input->post('location'),
						'brand'            => $this->input->post('brand'),
						'model'            => $this->input->post('model'),
						'serial_number'    => $this->input->post('serial_number'),
						'status'           => $this->input->post('status2'),
						'color'            => $color,
						'length'           => $this->input->post('length'),
						'width'            => $this->input->post('width'),
						'height'           => $this->input->post('height'),
						'weight'           => $this->input->post('weight'),
						'price'            => $this->input->post('price'),
						'date_of_purchase' => $this->input->post('date_of_purchase'),
						'description'      => $this->input->post('description')
					);

					// check to see if we are updating the data
					if ($this->inventory_model->update_inventory_by_code($code, $data)) {
						// Set message
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Inventory Updated!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);

						// upload and change inventory photo
						$link_foto      = "";
						$link_thumbnail = "";
						if (!empty($_FILES['photo']['name'])) {
							$config['file_name']     = trim($this->input->post('code').str_replace(" ", "_", $this->input->post('brand')).str_replace(" ", "_", $this->input->post('model')).rand());
							$config['upload_path']   = './assets/uploads/images/inventory/';
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
								$config['source_image']   = "assets/uploads/images/inventory/".$upload_data['file_name'];
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
								$this->inventory_model->update_inventory_by_code($code, $datas);

								// delete old Photo (if needed)
								if ($this->input->post('curr_photo')!="") {
									unlink("assets/uploads/images/inventory/".$this->input->post('curr_photo'));
									unlink("assets/uploads/images/inventory/".$this->input->post('curr_thumbnail'));
								}
							}
						}

					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Inventory Update Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
					redirect('inventory/all', 'refresh');
				}
			}
			// Get data
			$this->data['code']       = $code;
			$this->data['data_list']  = $this->inventory_model->get_inventory_by_code($code);
			$this->data['cat_list']   = $this->categories_model->get_categories('','','','asc');
			$this->data['stat_list']  = $this->status_model->get_status('','','','asc');
			$this->data['loc_list']   = $this->locations_model->get_locations('','','','asc');
			$this->data['col_list']   = $this->color_model->get_color('','','','asc');
			$this->data['brand_list'] = $this->inventory_model->get_brands();

			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() :
			$this->session->flashdata('message');

			$this->load->view('partials/_alte_header', $this->data);
			$this->load->view('partials/_alte_menu');
			$this->load->view('inv_data/edit');
			$this->load->view('partials/_alte_footer');
			$this->load->view('inv_data/js');
			$this->load->view('js_script');
		}
	}
	// Edit data end

	/**
	*	Delete Data
	*	If there's data sent, update deleted
	*	Else, redirect to categories
	*
	*	@param 		string 		$id
	*	@return 	void
	*
	*/
	public function delete($code)
	{
		// Jika tidak login, kembalikan ke halaman utama
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login/inventory', 'refresh');
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
					if ($this->inventory_model->update_inventory_by_code($code, $data)) {
						$this->session->set_flashdata('message',
							$this->config->item('message_start_delimiter', 'ion_auth')
							."Inventory Deleted!".
							$this->config->item('message_end_delimiter', 'ion_auth')
						);
					}
					else {
						$this->session->set_flashdata('message',
							$this->config->item('error_start_delimiter', 'ion_auth')
							."Inventory Delete Failed!".
							$this->config->item('error_end_delimiter', 'ion_auth')
						);
					}
				}
			}
			// Always redirect no matter what!
			redirect('inventory', 'refresh');
		}
	}
	// Delete data end
}

/* End of Inventory.php */
