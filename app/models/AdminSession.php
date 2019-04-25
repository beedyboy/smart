<?php
/**
* 
*/
class AdminSession extends Model
{
	
	public function __construct()
	{
		# code...
		$table =  'adminsessions'; 
		parent::__construct($table);
	}



public static function getFromCookie()
{
	$adminSession  = new self();

	// dnd(Cookie::get(REMEMBER_ME_COOKIE_NAME));
	if(Cookie::exists(REMEMBER_ME_COOKIE_NAME))
	{
		
	$adminSession = $adminSession->findFirst([
		'conditions' => 'user_agent = ? AND session = ?',
		'bind' => [Session::uagent_no_version(), Cookie::get(REMEMBER_ME_COOKIE_NAME)]
		]);

	} 
	if(!$adminSession) return false;
	return $adminSession;
}











}