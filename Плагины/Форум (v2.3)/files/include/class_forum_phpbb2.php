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


// DO PHPBB2 THINGS
define('IN_PHPBB', true);
$phpbb_root_path = $setting[setting_forum_path];
$phpEx = "php";
include($setting[setting_forum_path]."config.php");
include($setting[setting_forum_path]."includes/constants.php");
include($setting[setting_forum_path]."includes/template.php");
include($setting[setting_forum_path]."includes/sessions.php");
include($setting[setting_forum_path]."includes/auth.php");
include($setting[setting_forum_path]."includes/functions.php");
include($setting[setting_forum_path]."includes/db.php");
$result = $db->sql_query("SELECT * FROM " . CONFIG_TABLE);
while($row = $db->sql_fetchrow($result)) {
  $board_config[$row['config_name']] = $row['config_value'];
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
	  global $board_config, $db;

	  // CHECK TO SEE IF USER IS ALREADY LOGGED IN BEFORE SETTING COOKIES
	  $is_logged_in = 0;
	  if(isset($_COOKIE[$board_config[cookie_name].'_data']) && isset($_COOKIE[$board_config[cookie_name].'_sid'])) {
	    if($db->sql_numrows($db->sql_query("SELECT * FROM " . SESSIONS_TABLE . " WHERE session_id='".$_COOKIE[$board_config[cookie_name].'_sid']."' AND session_user_id='".$this->forum_user['user_id']."'")) == 1) {
	      $is_logged_in = 1;
	    }
	  }
	  if($is_logged_in == 0 || $override_cookies != 0) {

   
	    // USER LOGIN INFO
	    $user_id            = $this->forum_user['user_id'];
	    $ip_sep 		= explode('.', $_SERVER['REMOTE_ADDR']);
	    $user_ip 		= sprintf('%02x%02x%02x%02x', $ip_sep[0], $ip_sep[1], $ip_sep[2], $ip_sep[3]);
	    $session_id         = md5(substr(md5(rand(1000,9999) . microtime()), 4, 16));
	    $page_id            = 0;
	    $login              = 1;
	    $admin              = 0;
	    $enable_autologin   = 0;
	    $current_time       = time();
	    $last_visit         = $current_time;
	    $auto_login_key     = NULL;
	    $cookie_time        = time()+99999999;
    
    
	    // CREATE SESSION
	    $db->sql_query("INSERT INTO " . SESSIONS_TABLE . "(session_id,
								session_user_id,
								session_start,
								session_time,
								session_ip,
								session_page,
								session_logged_in,
								session_admin
								) VALUES (
								'$session_id',
								$user_id,
								$current_time,
								$current_time,
								'$user_ip',
								$page_id,
								$login,
								$admin)");
    
    
	    // GENERATE SESSION DATA AND SET COOKIES
	    $sessiondata['userid'] = $user_id;
	    $sessiondata['userip'] = $user_ip;
	    $sessiondata['autologinid'] = $auto_login_key;
    
	    setcookie($board_config['cookie_name'].'_data', serialize($sessiondata), $cookie_time, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
	    setcookie($board_config['cookie_name'].'_sid',  $session_id,             $cookie_time, $board_config['cookie_path'], $board_config['cookie_domain'], $board_config['cookie_secure']);
    
	  }

	} // END forum_login() METHOD








	// THIS METHOD CHECKS TO SEE IF THE CURRENT USER EXISTS IN THE FORUM
	// INPUT: 
	// OUTPUT: TRUE/FALSE DEPENDING ON THE OUTCOME OF THE CHECK 
	function forum_user_check() {
	  global $db;

	  // SEARCH PHPBB2 DATABASE FOR LOGGED-IN SE USER
	  $phpbb2_user_query = $db->sql_query("SELECT user_id, username, user_password, user_active, user_level FROM " . USERS_TABLE . " WHERE username='".$this->user_info[user_username]."' LIMIT 1");

	  // RETURN TRUE/FALSE IF PHPBB2 USER EXISTS
	  if($db->sql_numrows($phpbb2_user_query) == 1) {
	    $this->forum_user = $db->sql_fetchrow($phpbb2_user_query);
	    return true;
	  } else {
	    return false;
	  }

	} // END forum_user_check() METHOD








	// THIS METHOD CREATES A FORUM USER WITH THE SAME USERNAME AS THE CURRENT USER
	// INPUT: 
	// OUTPUT: 
	function forum_user_create() {
	  global $db, $board_config;

	  // GET NEXT USER ID
	  $row = $db->sql_fetchrow($db->sql_query("SELECT MAX(user_id) AS max_user_id FROM " . USERS_TABLE));
	  $forum_user_id = $row['max_user_id'] + 1;
    
	  // ENCRYPT PASSWORD
	  $password_md5 = md5(randomcode());
		
	  // SET DEFAULT VALUES FOR SOME VARIABLES
	  $viewemail          = FALSE;
	  $allowviewonline    = TRUE;
	  $notifyreply        = FALSE;
	  $notifypm           = TRUE;
	  $popup_pm           = TRUE;
	  $attachsig          = $board_config['allow_sig'];
	  $allowhtml          = $board_config['allow_html'];
	  $allowbbcode        = $board_config['allow_bbcode'];
	  $allowsmilies       = $board_config['allow_smilies'];
	  $user_style         = $board_config['default_style'];
	  $user_dateformat    = $board_config['default_dateformat'];
	  $user_timezone      = $board_config['board_timezone'];
	  $user_lang          = $board_config['default_lang'];
    
	  // BEGIN PHPBB2 INSERT
	  $db->sql_query("INSERT INTO " . USERS_TABLE . "(user_id,
							username,
							user_regdate,
							user_password,
							user_email,
							user_viewemail,
							user_attachsig,
							user_allowsmile,
							user_allowhtml,
							user_allowbbcode,
							user_allow_viewonline,
							user_notify,
							user_notify_pm,
							user_popup_pm,
							user_timezone,
							user_dateformat,
							user_lang,
							user_style,
							user_level,
							user_allow_pm,
							user_active,
							user_actkey
							) VALUES (
							'$forum_user_id',
							'".$this->user_info[user_username]."',
							'".time()."', 
							'$password_md5',
							'".$this->user_info[user_email]."',
							'$viewemail',
							'$attachsig',
							'$allowsmilies',
							'$allowhtml',
							'$allowbbcode',
							'$allowviewonline',
							'$notifyreply',
							'$notifypm',
							'$popup_pm',
							'$user_timezone',
							'".str_replace("\'", "''", $user_dateformat)."',
							'".str_replace("\'", "''", $user_lang)."',
							'$user_style',
							0,
							1,
							1,
							'')");
    
    
    
	  // DO GROUP INSERT QUERY
	  $db->sql_query("INSERT INTO " . GROUPS_TABLE . "(group_name, group_description, group_single_user, group_moderator) VALUES ('', 'Personal User', 1, 0)");
	  $group_id = $db->sql_nextid();
    
	  // DO USER GROUP TABLE INSERT QUERY
	  $db->sql_query("INSERT INTO " . USER_GROUP_TABLE . "(user_id, group_id, user_pending) VALUES ($forum_user_id, $group_id, 0)");
    
	} // END forum_user_create() METHOD








	// THIS METHOD CHANGES A FORUM USER'S USERNAME
	// INPUT: $new_username CONTAINING THE NEW USERNAME OF THE USER
	// OUTPUT: 
	function forum_user_change($new_username) {
	  global $db;

	  // LOG USER OUT
	  $this->forum_logout();

	  $phpbb_username = $new_username;

	  $db->sql_query("UPDATE " . USERS_TABLE . " SET username='$phpbb_username' WHERE user_id='".$this->forum_user[user_id]."'");

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
	  global $db;

	  // LOG USER OUT
	  $this->forum_logout();

	  $phpbb_password = md5($new_password);

	  $db->sql_query("UPDATE " . USERS_TABLE . " SET user_password='$phpbb_password' WHERE user_id='".$this->forum_user[user_id]."'");

	  // RETRIEVE INFORMATION
	  $this->forum_user_check();

	  // LOG USER BACK IN
	  $this->forum_login(1);

	} // END forum_password_change() METHOD








	// THIS METHOD LOGS A USER OUT OF THE FORUM (CLEARS ALL FORUM COOKIES)
	// INPUT: 
	// OUTPUT: 
	function forum_logout() {
	  global $board_config, $db;

	  $db->sql_query("UPDATE " . SESSIONS_TABLE . " SET session_logged_in=0 WHERE session_id='".$_COOKIE[$board_config['cookie_name'].'_sid']."' LIMIT 1");
   
	  setcookie($board_config['cookie_name'] . '_data', '', $current_time - 3600, '/');
	  setcookie($board_config['cookie_name'] . '_sid',  '', $current_time - 3600, '/');
    

	} // END forum_logout() METHOD

}
?>