<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
*	Profile model
*	
*	
*/
class Profile_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();

		$this->user_table = 'users';
		$this->user_photo_table = 'users_photo';
	}
	
	/**
	*	Get User Photo
	*	from user photo table
	*	
	*	@param 		string 		$username
	*	@return 	array 		$datas
	*	
	*/
	public function get_user_photo($username)
	{
		$this->db->where('username', $username);
		$datas = $this->db->get($this->user_photo_table);
		return $datas;
	}

	/**
	*	Update User Photo
	*	based on username
	*	
	*	@param 		string 		$username
	*	@param 		array 		$datas
	*	@return 	void
	*	
	*/
	public function update_user_photo($username, $datas)
	{
		$this->db->where('username', $username);
		$this->db->update($this->user_photo_table, $datas);
	}

}


// End of profile model