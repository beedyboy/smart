<?php
/**
* 
*/
class Auth extends Model
{
	private $_isLoggedIn, $_sessionName, $_cookieName, $_token; 
	public $sid = null;
	public static $currentLoggedInUser = null;
	
	public function __construct($user = '')
	{
		 
		//$table=  Pluralizer::plural($user);
	$table =  'users'; 
		parent::__construct($table);
		$this->_sessionName = CURRENT_USER_SESSION_NAME;
		$this->_cookieName = REMEMBER_ME_COOKIE_NAME;
	$this->_softDelete = true;

 if($user != '')
	{	 

		if(is_int($user))
		{
			$u = $this->_db->findFirst($table, ['conditions'=>'id= ?', 'bind'=>[$user]]);

		}
		else 
		{
 
			$u = $this->_db->findFirst($table, ['conditions'=>'username= ?', 'bind'=>[$user]]);
		}

		if($u)
		{
			foreach ($u as $key => $value) 
			{
				# code...
			$this->$key  = $value;
			}
		}
	}

 

	}

	public function findByEmail($email)
	{ 
 
		 return $this->findFirst(['conditions'=> 'acc_email  = ?', 'bind'=> [$email]]);
	 
	}
	
	/**
	 * authentication
	 * @return [type] [description]
	 */
public static function check()
{  
	if( empty($_SESSION))
	{
		return false;
	}

	else{
		return true;
	}

}
/**
 * is user logged in ?
 * @return a view page [ home | login page]
 */
public static function isLoggedIn()
{
 	if( empty($_SESSION)):
// dnd("Not logged IN");
 		Router::redirect('login');
 	endif;

}
	public static function auth($field)
	{ 

  		  $u = new User('user');
	   $uid = Session::get(CURRENT_USER_SESSION_NAME); 
// dnd($uid);
	   if($u->check()):

	 return $u->findById($uid)->$field;
	 // return $u->findById($uid)->$field;
	else:
		return false;
	endif;
	}
	
public static function currentLoggedInUser()
{
	if(!isset(self::$currentLoggedInUser) && Session::exists(CURRENT_USER_SESSION_NAME))
	{ 
		 $u = new Auth((int)Session::get(CURRENT_USER_SESSION_NAME)); 
 		 self::$currentLoggedInUser = $u;
	 
	}
	 // dnd(self::$currentLoggedInUser);
	return self::$currentLoggedInUser;
}

	public function login($id, $rememberme = false)
	{ 
		Session::set($this->_sessionName, $id); 
		#check if remember me button was checked
		$hash = md5(uniqid() . rand(0, 100));
		//if($rememberme)
		//{
		//	 
		//	$user_agent = Session::uagent_no_version();
		//
		//	Cookie::set($this->_cookieName, $hash, REMEMBER_ME_COOKIE_EXPIRY);
		//	$fields = ['session'=>$hash, 'user_agent'=>$user_agent, 'user_id'=>$id];
		//
		//	$this->_db->query("DELETE FROM usersessions WHERE user_id = ? AND user_agent = ?", [$id, $user_agent]);
		//$qry =	$this->_db->insert('usersessions', $fields);
		//$this->sid = $this->_db->lastID();
		//}
		$this->_token = $hash;
	}
	public function getToken()
	{
		return $this->_token;
	}
//
//
//public static function loginUserFromCookie()
//{
//	$usersession = UserSession::getFromCookie(); 
// 
//	if($usersession->user_id != '')
//	{
//		$user = new self((int)$usersession->user_id);
//	 
//	}
//
//	if($user)
//	{
//		$user->login($usersession->user_id); 
//	}
//	 		   
//   return $user;
//}
// 

public function logout()
{

	$userSession = UserSession::getFromCookie(); 
	 if($userSession) $userSession->_db->query("DELETE FROM usersessions WHERE user_id = ?", [$_SESSION[CURRENT_USER_SESSION_NAME]]); 
	 //if($userSession) $userSession->delete(currentuser()->id);
	Session::delete(CURRENT_USER_SESSION_NAME);
	if(Cookie::exists(REMEMBER_ME_COOKIE_NAME))
	{
		Cookie::delete(REMEMBER_ME_COOKIE_NAME);
	}
	unset($_SESSION);
	return true;
}

 
public function registerNewUser($params)
{

	$this->assign($params);
	$this->password = password_hash($this->password, PASSWORD_DEFAULT);
	$this->save();
}

//check if 
 
}