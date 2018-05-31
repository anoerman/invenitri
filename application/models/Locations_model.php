<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Locations model
*
*
*/
class Locations_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->locations_table = 'inv_locations';
		$this->users_table     = 'users';
		$this->loggedinuser    = $this->ion_auth->user()->row();
	}

	/**
	*	Get locations
	*	from inv locations table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_locations($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->locations_table.".id, ".
			$this->locations_table.".code, ".
			$this->locations_table.".name, ".
			$this->locations_table.".detail, ".
			$this->locations_table.".photo, ".
			$this->locations_table.".thumbnail, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->locations_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->locations_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->locations_table.'.deleted', '0');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->locations_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->locations_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Locations by Code
	*	from inv locations table
	*	sort by id desc
	*
	*	@param 		string 		$code
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_locations_by_code($code='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->locations_table.".id, ".
			$this->locations_table.".code, ".
			$this->locations_table.".name, ".
			$this->locations_table.".detail, ".
			$this->locations_table.".photo, ".
			$this->locations_table.".thumbnail, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->locations_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->locations_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->locations_table.'.deleted', '0');

		// if code provided
		if ($code!='') {
			$this->db->where($this->locations_table.'.code', $code);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->locations_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert location
	*	from location form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_location($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->locations_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update location
	*	from locations edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_location($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->locations_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update location by code
	*	from locations edit form
	*	based on code
	*
	*	@param 		string 		$code
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_location_by_code($code, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('code', $code);
		if($this->db->update($this->locations_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	* Code check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$code
	* @return 	array
	*
	*/
	public function code_check($code)
	{
		$this->db->where('code', trim($code));
		$datas = $this->db->get($this->locations_table);

		return $datas;
	}

	/**
	* Name check
	* If duplicate FALSE
	* Else TRUE
	*
	* @param 		string		$name
	* @return 	array
	*
	*/
	public function name_check($name)
	{
		$this->db->where('name', trim($name));
		$datas = $this->db->get($this->locations_table);

		return $datas;
	}


}
// End of locations model
