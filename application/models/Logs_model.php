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

		$this->locations_table = 'inv_log_data_location';
		$this->status_table    = 'inv_log_data_status';
		$this->users_table     = 'users';
		$this->loggedinuser    = $this->ion_auth->user()->row();
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

		if ($this->db->insert($this->locations_table, $datas)) {
			return TRUE;
		}
		return FALSE;
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

		if ($this->db->insert($this->status_table, $datas)) {
			return TRUE;
		}
		return FALSE;
	}


}
// End of logs model
