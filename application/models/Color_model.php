<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Color model
*
*
*/
class Color_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->color_table  = 'master_color';
		$this->users_table  = 'users';
		$this->loggedinuser = $this->ion_auth->user()->row();
	}

	/**
	*	Get Color
	*	from inv color table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_color($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->color_table.".id, ".
			$this->color_table.".name, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->color_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->color_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->color_table.'.deleted', '0');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->color_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->color_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert color
	*	from color form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_color($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->color_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update Color
	*	from color edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_color($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->color_table, $datas)) {
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
		$datas = $this->db->get($this->color_table);

		return $datas;
	}


}


// End of color model
