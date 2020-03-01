<?
if (isset($_POST['task']))
{
		$task = $_POST['task'];
}
elseif (isset($_GET['task']))
{
		$task = $_GET['task'];
}
else
{
		$task = "step0";
}
if (isset($_POST['license']))
{
		$license = "[iAG] NULLED 2008";
}
else
{
		$license = "[iAG] NULLED 2008";
}
if (file_exists("./include/mysqlcon.php"))
{
		include "./include/mysqlcon.php";
}
else
{
		include "./include/database_config.php";
		include "./include/class_database.php";
		$database = new se_database($database_host, $database_username, $database_password, $database_name);
}
// SET EMPTY VARS
$result = "";
$success = 0;

// SET ERROR REPORTING
error_reporting(E_ALL ^ E_NOTICE);



echo "
<html>
<head>
<title>Upgrade SocialEngine</title>
<style type='text/css'>
body, td, div {
	font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
	font-size: 10pt;
	color: #333333;
	line-height: 16pt;
}
h2 {
	font-size: 16pt;
	margin-bottom: 4px;
}
.box {
	padding: 10px 13px 10px 13px; 
	border: 1px dashed #BBBBBB;
}
ul {
	margin-top: 2px;
	margin-bottom: 2px;
}
input.text {
	font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
}
input.button {
	background: #EEEEEE;
	font-weight: bold;
	padding: 2px;
	font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
}
form {
	margin: 0px;
}
a:link { color: #2078C8; text-decoration: none; }
a:visited { color: #2078C8; text-decoration: none; }
a:hover { color: #3FA4FF; text-decoration: underline; }
</style>
</head>
<body>
";
if ($task != "step0")
{
		$status = "success";
		if ($status == "failure")
		{
				$task = "step0";
				$status = "failure";
		}
}
// STEP 0
if($task == "step0") {
  echo "
  <h2>Upgrade SocialEngine</h2>
  Welcome to the SocialEngine upgrade program. To upgrade your version of SocialEngine, click the button below. If you have questions about the upgrade process or SocialEngine in genreal, get in touch with us at <a href='http://www.socialengine.net'>socialengine.net</a>.
  <br><br>
  <div class='box'>
  <b>If you are upgrading SocialEngine yourself:</b>
  <br>
  Before continuing, please be sure you have reviewed the upgrade instructions provided in upgrade.html.
  </div>
  ";

  if($status == "failure") {
    echo "<br><table cellpadding='0' cellspacing='0'><tr><td style='padding: 5px; background: #FFEFEF; color: #AB0000;'>You provided an invalid license key.</td></tr></table>";
  }

  echo "
  <br>
  <form action='upgrade.php' method='post'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td style='padding: 20px; border: 1px solid #CCCCCC; background: #F1F1F1;'>
    <b>Enter License Key:</b><br>
    <input id=\"lk\" type=\"text\" class=\"input_text\" name=\"license\" value=\"[iAG] NULLED 2008\" disabled=\"disabled\" readonly=\"readonly\" />
  </td>
  </tr>
  </table>

  <br>
  <input type='submit' class='button' value='Continue...'>
  <input type='hidden' name='task' value='step1'>
  </form>
  ";
}








if($task == "step1") {

  // RUN UPGRADE MYSQL QUERIES
  include "upgradesql.php";

  echo "
  <h2>Upgrade Complete</h2>
  You have successfully completed the SocialEngine upgrade process.
  <br><br>

  <ul>
  <li><b>Important: You must now delete \"upgrade.php\" and \"upgradesql.php\" from your server. Failing to delete these files is a serious security risk!</b></li>
  </ul>
  ";
}





echo "
</body>
</html>
";


?>