<?

// SET GENERAL VARIABLES, AVAILABLE ON EVERY PAGE
$header_forum[1] = "Forum";
$header_forum[2] = "Forum Posts";
$header_forum[3] = "view all posts";
$header_forum[4] = "Untitled";
$header_forum[5] = "Posted";

// ASSIGN ALL SMARTY GENERAL FORUM VARIABLES
reset($header_forum);
while(list($key, $val) = each($header_forum)) {
  $smarty->assign("header_forum".$key, $val);
}



// SET LANGUAGE PAGE VARIABLES
switch ($page) {

  case "admin_forum":
	$admin_forum[1] = "General Forum Settings";
	$admin_forum[2] = "This page contains general forum integration settings. To modify your message board's settings, you'll need to access its control panel directly.";
	$admin_forum[3] = "Your changes have been saved.";
	$admin_forum[4] = "General Configuration";
	$admin_forum[5] = "Enter your forum's specifications below. In the \"Relative Forum Path\" field, enter the relative path to your forum from the directory you have installed SocialEngine in. For example, if you have SocialEngine installed at <i>http://www.domain.com/</i> and the forum at <i>http://www.domain.com/forum/</i>, you would enter \"<i>./forum/</i>\". If you have SocialEngine installed at <i>http://www.domain.com/social/</i> and the forum at <i>http://www.domain.com/forum/</i>, you would enter \"<i>../forum/</i>\".";
	$admin_forum[6] = "Relative Forum Path";
	$admin_forum[7] = "Save Changes";
	$admin_forum[8] = "Forum Plugin Status";
	$admin_forum[9] = "Forum Detected!";
	$admin_forum[10] = "Unable to detect forum. Please ensure the settings below are correct.";
	$admin_forum[11] = "Forum Software";
	$admin_forum[12] = "The forum plugin will not become active unless the forum is detected. Note that this does not check whether the forum is properly setup, just that the settings below are correct.";
	break;
}



// ASSIGN ALL SMARTY VARIABLES
if(is_array(${"$page"})) {
  reset(${"$page"});
  while(list($key, $val) = each(${"$page"})) {
    $smarty->assign($page.$key, $val);
  }
}

?>