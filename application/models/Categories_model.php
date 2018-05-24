<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Categories model
*
*
*/
class Categories_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->categories_table = 'inv_categories';
		$this->users_table      = 'users';
		$this->loggedinuser     = $this->ion_auth->user()->row();
	}

	/**
	*	Get Categories
	*	from inv categories table
	*	sort by id desc
	*
	*	@param 		string 		$id
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_categories($id='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->categories_table.".id, ".
			$this->categories_table.".code, ".
			$this->categories_table.".name, ".
			$this->categories_table.".description, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->categories_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->categories_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->categories_table.'.deleted', '0');

		// if ID provided
		if ($id!='') {
			$this->db->where($this->categories_table.'.id', $id);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->categories_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Get Categories by Code
	*	from inv categories table
	*	sort by id desc
	*
	*	@param 		string 		$code
	*	@param 		string 		$limit
	*	@param 		string 		$start
	*	@param 		string 		$order_method
	*	@return 	array 		$datas
	*
	*/
	public function get_categories_by_code($code='',$limit='', $start='', $order_method='desc')
	{
		$this->db->select(
			$this->categories_table.".id, ".
			$this->categories_table.".code, ".
			$this->categories_table.".name, ".
			$this->categories_table.".description, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->categories_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->categories_table.'.created_by = '.$this->users_table.'.username',
			'left');

		$this->db->where($this->categories_table.'.deleted', '0');

		// if code provided
		if ($code!='') {
			$this->db->where($this->categories_table.'.code', $code);
		}

		// if limit and start provided
		if ($limit!="") {
			$this->db->limit($limit, $start);
		}

		// order by
		if ($order_method!="") {
			$this->db->order_by($this->categories_table.'.id', $order_method);
		}

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert category
	*	from category form
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_category($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->categories_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Update Category
	*	from categories edit form
	*	based on id
	*
	*	@param 		string 		$id
	*	@param 		array 		$datas
	*	@return 	void
	*
	*/
	public function update_category($id, $datas)
	{
		// user and datetime
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('updated_on', 'NOW()', FALSE);

		$this->db->where('id', $id);
		if($this->db->update($this->categories_table, $datas)) {
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
		$datas = $this->db->get($this->categories_table);

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
		$datas = $this->db->get($this->categories_table);

		return $datas;
	}


}
// End of categories model
