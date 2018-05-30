<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Logs model
* Managing all logging system
*
*/
class Logs_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->locations_log_table = 'inv_log_data_location';
		$this->locations_table     = 'inv_locations';
		$this->status_log_table    = 'inv_log_data_status';
		$this->status_table        = 'inv_status';
		$this->users_table         = 'users';
		$this->loggedinuser        = $this->ion_auth->user()->row();
	}

	/**
	*	Insert location log
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_location_log($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

			if ($this->db->insert($this->locations_log_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Get location log based on inventory code
	*
	*	@param 		string 		$code
	*	@return 	bool
	*
	*/
	public function get_location_log_by_code($code)
	{
		$this->db->select(
			$this->locations_log_table.".id, ".
			$this->locations_log_table.".code, ".
			$this->locations_log_table.".location_id, ".
			$this->locations_table.".name AS location_name, ".
			$this->locations_log_table.".created_on, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->locations_log_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->locations_log_table.'.created_by = '.$this->users_table.'.username',
			'left');

		// join location table
		$this->db->join(
			$this->locations_table,
			$this->locations_log_table.'.location_id = '.$this->locations_table.'.id',
			'left');

		// $this->db->where($this->datas_table.'.deleted', '0');

		// if code provided
		if ($code!='') {
			$this->db->where($this->locations_log_table.'.code', $code);
		}

		// Limit & order
		$limit = 10;
		$this->db->limit($limit);
		$this->db->order_by($this->locations_table.'.id', 'desc');

		$datas = $this->db->get();
		return $datas;
	}

	/**
	*	Insert status log
	*
	*	@param 		array 		$datas
	*	@return 	bool
	*
	*/
	public function insert_status_log($datas)
	{
		// user and datetime
		$datas['created_by'] = $this->loggedinuser->username;
		$datas['updated_by'] = $this->loggedinuser->username;
		$this->db->set('created_on', 'NOW()', FALSE);
		$this->db->set('updated_on', 'NOW()', FALSE);

		if ($this->db->insert($this->status_log_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}

	/**
	*	Get status log based on inventory code
	*
	*	@param 		string 		$code
	*	@return 	bool
	*
	*/
	public function get_status_log_by_code($code)
	{
		$this->db->select(
			$this->status_log_table.".id, ".
			$this->status_log_table.".code, ".
			$this->status_log_table.".status_id, ".
			$this->status_table.".name AS status_name, ".
			$this->status_log_table.".created_on, ".
			$this->users_table.".username, ".
			$this->users_table.".first_name, ".
			$this->users_table.".last_name"
		);
		$this->db->from($this->status_log_table);

		// join user table
		$this->db->join(
			$this->users_table,
			$this->status_log_table.'.created_by = '.$this->users_table.'.username',
			'left');

		// join status table
		$this->db->join(
			$this->status_table,
			$this->status_log_table.'.status_id = '.$this->status_table.'.id',
			'left');

		// $this->db->where($this->datas_table.'.deleted', '0');

		// if code provided
		if ($code!='') {
			$this->db->where($this->status_log_table.'.code', $code);
		}

		// Limit & order
		$limit = 10;
		$this->db->limit($limit);
		$this->db->order_by($this->status_log_table.'.id', 'desc');

		$datas = $this->db->get();
		return $datas;
	}



}
// End of logs model
