<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Status model
*
*
*/
class Status_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->status_table = 'inv_status';
		$this->users_table  = 'users';
		$this->loggedinuser = $this->ion_auth->user()->row();
	}

	/**
	*	Get Status
	*	from inv status table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_status($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->status_table.".id, ".
			$this->status_table.".name, ".
			$this->status_table.".description, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->status_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->status_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->status_table.'.deleted', '0');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->status_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->status_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert status
	*	from status form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_status($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->status_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update Status
	*	from status edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_status($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->status_table, $datas)) {
			return TRUE;
		}
		return FALSE;
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
		$datas = $this->db->get($this->status_table);

		return $datas;
	}

}


// End of status model
