<?

//  THIS CLASS CONTAINS FORUM ENTRY-RELATED METHODS 
//  METHODS IN THIS CLASS:
//    se_forum()
//    forum_connect()
//    forum_login()
//    forum_user_check()
//    forum_user_create()
//    forum_user_change()
//    forum_password_change()
//    forum_logout()


// DO VB THINGS
include $setting[setting_forum_path]."includes/functions.php";
include $setting[setting_forum_path]."includes/class_core.php";
define('CWD', $setting[setting_forum_path]);
define('DIR', $setting[setting_forum_path]);
define('TIMENOW', time());
$user_object_holder =& $user;
$vbulletin =& new vB_Registry();
$user =& $user_object_holder;
$vbulletin->fetch_config();
$db =& new vB_Database($vbulletin);
$db->connect(
	$vbulletin->config['Database']['dbname'],
	$vbulletin->config['MasterServer']['servername'],
	$vbulletin->config['MasterServer']['port'],
	$vbulletin->config['MasterServer']['username'],
	$vbulletin->config['MasterServer']['password'],
	$vbulletin->config['MasterServer']['usepconnect'],
	$vbulletin->config['SlaveServer']['servername'],
	$vbulletin->config['SlaveServer']['port'],
	$vbulletin->config['SlaveServer']['username'],
	$vbulletin->config['SlaveServer']['password'],
	$vbulletin->config['SlaveServer']['usepconnect'],
	$vbulletin->config['Mysqli']['ini_file'],
	$vbulletin->config['Mysqli']['charset']
);
$vbulletin->db =& $db;
class vBulletinHook {
	function fetch_hook() { return false; }
	function fetch_hookusage() { return array(); }
}


class se_forum {

	// INITIALIZE VARIABLES
	var $is_error;			// DETERMINES WHETHER THERE IS AN ERROR OR NOT
	var $error_message;		// CONTAINS RELEVANT ERROR MESSAGE

	var $user_info;			// CONTAINS THE SE USER INFO OF THE CURRENTLY LOGGED-IN USER
	var $forum_user;		// CONTAINS THE INFO FOR THE FORUM USER ACCOUNT

	var $forum_database;		// CONTAINS THE DATABASE OBJECT FOR THE FORUM
	var $forum_prefix;		// CONTAINS THE FORUM TABLE PREFIX








	// THIS METHOD SETS INITIAL VARS
	// INPUT: $user REPRESENTING THE USER OBJECT OF THE CURRENTLY LOGGED-IN USER
	// OUTPUT: 
	function se_forum($user) {

	  // CHECK IF USER LOGGED IN
	  if($user->user_exists != 0) {
	    $this->user_info = $user->user_info;
	    
	    // CHECK IF A FORUM USER EXISTS
	    if($this->forum_user_check() === TRUE) {

	      // LOG FORUM USER IN
	      $this->forum_login();

	    // FORUM USER DOESN'T EXIST
	    } else {

	      // CREATE FORUM USER
	      $this->forum_user_create();

	      // LOG FORUM USER IN
	      $this->forum_login();

	    }


	  // NO USER LOGGED IN
	  } else {
	    // ENSURE USER IS COMPLETELY LOGGED OUT OF FORUM
	    $this->forum_logout();

	  }

	} // END se_forum() METHOD








	// THIS METHOD LOGS A USER INTO THE FORUM (CREATES FORUM COOKIES) IF NOT ALREADY LOGGED IN
	// INPUT: $override_cookies (OPTIONAL) REPRESENTS WHETHER TO OVERWRITE THE CURRENT COOKIES
	// OUTPUT: 
	function forum_login($override_cookies = 0) {
	  global $setting, $vbulletin;

	  // CHECK TO SEE IF USER IS ALREADY LOGGED IN BEFORE SETTING COOKIES
	  $is_logged_in = 0;
	  if(isset($_COOKIE[COOKIE_PREFIX . 'userid']) && isset($_COOKIE[COOKIE_PREFIX . 'password'])) {
	    if($_COOKIE[COOKIE_PREFIX . 'userid'] == $this->forum_user[userid]) {
	      $is_logged_in = 1;
	    }
	  }
	  if($is_logged_in == 0 || $override_cookies != 0) {
	    $this->forum_logout();
	    $vbulletin->userinfo = $this->forum_user;
	    $vbulletin->options['cookiedomain'] = '';
	    $vbulletin->options['cookiepath'] = '/';
	    vbsetcookie('userid', $vbulletin->userinfo['userid'], true, true, true);
	    vbsetcookie('password', md5($vbulletin->userinfo['password'] . COOKIE_SALT), true, true, true);
	  }

	} // END forum_login() METHOD








	// THIS METHOD CHECKS TO SEE IF THE CURRENT USER EXISTS IN THE FORUM
	// INPUT: 
	// OUTPUT: TRUE/FALSE DEPENDING ON THE OUTCOME OF THE CHECK 
	function forum_user_check() {
	  global $vbulletin;

	  // SEARCH VB DATABASE FOR LOGGED-IN SE USER
	  $vb_user_query = $vbulletin->db->query_write("SELECT userid, usergroupid, membergroupids, infractiongroupids, username, password, salt FROM " . TABLE_PREFIX . "user WHERE username='".$this->user_info[user_username]."' LIMIT 1");

	  // RETURN TRUE/FALSE IF VB USER EXISTS
	  if($vbulletin->db->num_rows($vb_user_query) == 1) {
	    $this->forum_user = $vbulletin->db->fetch_array($vb_user_query);
	    return true;
	  } else {
	    return false;
	  }

	} // END forum_user_check() METHOD








	// THIS METHOD CREATES A FORUM USER WITH THE SAME USERNAME AS THE CURRENT USER
	// INPUT: 
	// OUTPUT: 
	function forum_user_create() {
	  global $vbulletin;

	  // SET VALUES FOR NEW VB USER
	  $vb_usergroupid = "2";
	  $vb_username = $this->user_info[user_username];
	  $vb_salt = substr($this->user_info['user_code'], 0, 3);
	  $vb_password = md5(md5(randomcode()) . $vb_salt);
	  $vb_passworddate = date('Y-m-d', time());
	  $vb_email = $this->user_info[user_email];
	  $vb_usertitle = "";
	  $vb_joindate = time();
	  $vb_lastvisit = time();
	  $vb_lastactivity = time();
	  $vb_posts = 0;
	  $vb_options = "3159";

	  $vbulletin->db->query_write("INSERT INTO " . TABLE_PREFIX . "user (usergroupid, 
									username, 
									password, 
									passworddate, 
									email, 
									joindate, 
									lastvisit, 
									lastactivity,
									posts,
									options,
									salt
									) VALUES (
									'$vb_usergroupid',
									'$vb_username',
									'$vb_password',
									'$vb_passworddate',
									'$vb_email',
									'$vb_joindate',
									'$vb_lastvisit',
									'$vb_lastactivity',
									'$vb_posts',
									'$vb_options',
									'$vb_salt'
									)");
	  $forum_user_id = $vbulletin->db->insert_id();
	  $vbulletin->db->query_write("INSERT INTO " . TABLE_PREFIX . "userfield (userid) VALUES ('$forum_user_id')");
	  $vbulletin->db->query_write("INSERT INTO " . TABLE_PREFIX . "usertextfield (userid) VALUES ('$forum_user_id')");

	} // END forum_user_create() METHOD








	// THIS METHOD CHANGES A FORUM USER'S USERNAME
	// INPUT: $new_username CONTAINING THE NEW USERNAME OF THE USER
	// OUTPUT: 
	function forum_user_change($new_username) {
	  global $vbulletin;

	  // LOG USER OUT
	  $this->forum_logout();


	  $vb_username = $new_username;

	  $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET username='$vb_username' WHERE userid='".$this->forum_user[userid]."'");

	  // RESET USER INFO
	  $this->user_info[user_username] = $new_username;

	  // RETRIEVE INFORMATION
	  $this->forum_user_check();

	  // LOG USER BACK IN
	  $this->forum_login(1);

	} // END forum_user_change() METHOD








	// THIS METHOD CHANGES A FORUM USER'S PASSWORD
	// INPUT: $new_password CONTAINING THE NEW PASSWORD OF THE USER
	// OUTPUT: 
	function forum_password_change($new_password) {
	  global $vbulletin;

	  // LOG USER OUT
	  $this->forum_logout();

	  $vb_password = md5(md5($new_password) . $this->forum_user[salt]);
	  $vb_passworddate = date('Y-m-d', time());

	  $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET password='$vb_password', 
									passworddate='$vb_passworddate' WHERE userid='".$this->forum_user[userid]."'");

	  // RETRIEVE INFORMATION
	  $this->forum_user_check();

	  // LOG USER BACK IN
	  $this->forum_login(1);

	} // END forum_password_change() METHOD








	// THIS METHOD LOGS A USER OUT OF THE FORUM (CLEARS ALL FORUM COOKIES)
	// INPUT: 
	// OUTPUT: 
	function forum_logout() {
	  global $setting, $vbulletin;

	  require_once($setting[setting_forum_path]."includes/functions_login.php");

	  $vbulletin->userinfo = NULL;
	  process_logout();
	  setcookie('bbsessionhash', '', 0);
	  setcookie('userid', '', true, true, true);
	  setcookie('password', md5($vbulletin->userinfo['password'] . COOKIE_SALT), true, true, true);

	  if($this->forum_user[userid] != "") {
	    $vb_lastactivity = time();
	    $vb_lastvisit = time();
	    $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "session WHERE userid = '".$this->forum_user[userid]."'");
	    $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "user SET lastactivity='$vb_lastactivity', 
									lastvisit='$vb_lastvisit' WHERE userid='".$this->forum_user[userid]."'");
	  }

	} // END forum_logout() METHOD

}
?>