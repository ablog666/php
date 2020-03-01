<?

$plugin_name = "Blog Plugin";
$plugin_version = 2.50;
$plugin_type = "blog";
$plugin_desc = "This plugin gives each of your users their own personal blog. This is a great way to encourage content generation and personal expression. Blogs are also an excellent way to improve the search engine visibility of your social network.";
$plugin_icon = "blog16.gif";
$plugin_pages_main = "View Blog Entries<!>admin_viewblogs.php<~!~>Global Blog Settings<!>admin_blog.php<~!~>";
$plugin_pages_level = "Blog Settings<!>admin_levels_blogsettings.php<~!~>";
$plugin_url_htaccess = "RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/blog/([0-9]+)/?\$ \$server_info/blog_entry.php?user=\$1&blogentry_id=\$2 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/blog/([^/]+)?\$ \$server_info/blog.php?user=\$1\$2 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/blog/?\$ \$server_info/blog.php?user=\$1 [L]";

if($install == "blog") {

  //######### INSERT ROW INTO se_plugins
  if($database->database_num_rows($database->database_query("SELECT plugin_id FROM se_plugins WHERE plugin_type='$plugin_type'")) == 0) {
    $database->database_query("INSERT INTO se_plugins (plugin_name,
					plugin_version,
					plugin_type,
					plugin_desc,
					plugin_icon,
					plugin_pages_main,
					plugin_pages_level,
					plugin_url_htaccess
					) VALUES (
					'$plugin_name',
					'$plugin_version',
					'$plugin_type',
					'$plugin_desc',
					'$plugin_icon',
					'$plugin_pages_main',
					'$plugin_pages_level',
					'$plugin_url_htaccess')");


  //######### UPDATE PLUGIN VERSION IN se_plugins
  } else {
    $database->database_query("UPDATE se_plugins SET plugin_name='$plugin_name',
					plugin_version='$plugin_version',
					plugin_desc='$plugin_desc',
					plugin_icon='$plugin_icon',
					plugin_pages_main='$plugin_pages_main',
					plugin_pages_level='$plugin_pages_level',
					plugin_url_htaccess='$plugin_url_htaccess' WHERE plugin_type='$plugin_type'");

  }

  //######### CREATE se_blogcomments
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_blogcomments'")) == 0) {
    $database->database_query("CREATE TABLE `se_blogcomments` (
    `blogcomment_id` int(9) NOT NULL auto_increment,
    `blogcomment_blogentry_id` int(9) NOT NULL default '0',
    `blogcomment_authoruser_id` int(9) NOT NULL default '0',
    `blogcomment_date` int(14) NOT NULL default '0',
    `blogcomment_body` text NULL,
    PRIMARY KEY  (`blogcomment_id`),
    KEY `INDEX` (`blogcomment_blogentry_id`,`blogcomment_authoruser_id`)
    )");
  }




  //######### CREATE se_blogentries
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_blogentries'")) == 0) {
    $database->database_query("CREATE TABLE `se_blogentries` (
    `blogentry_id` int(9) NOT NULL auto_increment,
    `blogentry_user_id` int(9) NOT NULL default '0',
    `blogentry_blogentrycat_id` int(9) NOT NULL default '0',
    `blogentry_date` int(14) NOT NULL default '0',
    `blogentry_views` int(9) NOT NULL default '0',
    `blogentry_title` varchar(100) NOT NULL default '',
    `blogentry_body` text NULL,
    `blogentry_search` int(1) NOT NULL default '0',
    `blogentry_privacy` int(1) NOT NULL default '0',
    `blogentry_comments` int(1) NOT NULL default '0',
    PRIMARY KEY  (`blogentry_id`),
    KEY `INDEX` (`blogentry_user_id`)
    )");
  }



  //######### CREATE se_blogentrycats
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_blogentrycats'")) == 0) {
    $database->database_query("CREATE TABLE `se_blogentrycats` (
    `blogentrycat_id` int(9) NOT NULL auto_increment,
    `blogentrycat_title` varchar(100) NOT NULL default '',
    PRIMARY KEY  (`blogentrycat_id`)
    )");
  }



  //######### CREATE se_blogstyles
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_blogstyles'")) == 0) {
    $database->database_query("CREATE TABLE `se_blogstyles` (
    `blogstyle_id` int(9) NOT NULL auto_increment,
    `blogstyle_user_id` int(9) NOT NULL default '0',
    `blogstyle_css` text NULL,
    PRIMARY KEY  (`blogstyle_id`),
    KEY `INDEX` (`blogstyle_user_id`)
    )");
  }



  //######### INSERT se_urls
  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='blog'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Blog URL', 'blog', 'blog.php?user=\$user', '\$user/blog/')");
  }
  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='blog_entry'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Blog Entry URL', 'blog_entry', 'blog_entry.php?user=\$user&blogentry_id=\$id1', '\$user/blog/\$id1/')");
  }


  //######### INSERT se_actiontypes
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='postblog'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('postblog', 'action_postblog.gif', 'When I write a blog entry.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; wrote a blog entry: &lt;a href=&#039;blog_entry.php?user=[username]&amp;blogentry_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='blogcomment'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('blogcomment', 'action_postcomment.gif', 'When I post a comment about a blog entry.', 1, '&lt;a href=&#039;profile.php?user=[username1]&#039;&gt;[username1]&lt;/a&gt; posted a comment on &lt;a href=&#039;profile.php?user=[username2]&#039;&gt;[username2]&lt;/a&gt;&#039;s &lt;a href=&#039;blog_entry.php?user=[username2]&amp;blogentry_id=[id]&#039;&gt;blog entry&lt;/a&gt;:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;')");
  }


  //######### ADD COLUMNS/VALUES TO LEVELS TABLE IF BLOGS HAVE NEVER BEEN INSTALLED
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_blog_allow'")) == 0 AND $database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'type_blog_allow'")) == 0) {
    $database->database_query("ALTER TABLE se_levels 
					ADD COLUMN `level_blog_allow` int(1) NOT NULL default '0',
					ADD COLUMN `level_blog_entries` int(3) NOT NULL default '0',
					ADD COLUMN `level_blog_style` int(1) NOT NULL default '0',
					ADD COLUMN `level_blog_search` int(1) NOT NULL default '0',
					ADD COLUMN `level_blog_privacy` varchar(10) NOT NULL default '',
					ADD COLUMN `level_blog_comments` varchar(10) NOT NULL default ''");
    $database->database_query("UPDATE se_levels SET level_blog_allow='1', level_blog_entries='50', level_blog_style='1', level_blog_search='1', level_blog_privacy='012345', level_blog_comments='0123456'");

  //######### CHANGE COLUMNS TO LEVELS TABLE IF BLOGS HAVE BEEN INSTALLED
  } elseif($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'type_blog_allow'")) != 0) {
    $database->database_query("ALTER TABLE se_levels 
					CHANGE type_blog_allow level_blog_allow int(1) NOT NULL default '0',
					CHANGE type_blog_entries level_blog_entries int(3) NOT NULL default '0',
					CHANGE type_blog_style level_blog_style int(1) NOT NULL default '0',
					CHANGE type_blog_search level_blog_search int(1) NOT NULL default '0',
					CHANGE type_blog_privacy level_blog_privacy varchar(10) NOT NULL default '',
					CHANGE type_blog_comments level_blog_comments varchar(10) NOT NULL default ''");
  }


  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_permission_blog'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_permission_blog` int(1) NOT NULL default '0',
					ADD COLUMN `setting_email_blogcomment_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_blogcomment_message` text NULL");
    $database->database_query("UPDATE se_settings SET setting_permission_blog='1', setting_email_blogcomment_subject='New Blog Entry Comment', setting_email_blogcomment_message='Hello [username],\n\nA new comment has been posted on one of your blog entries by [commenter]. Please click the following link to view it:\n\n[link]\n\nBest Regards,\nSocial Network Administration'");
  }

  //######### ADD COLUMNS/VALUES TO USER SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_usersettings LIKE 'usersetting_notify_blogcomment'")) == 0) {
    $database->database_query("ALTER TABLE se_usersettings 
					ADD COLUMN `usersetting_notify_blogcomment` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_usersettings SET usersetting_notify_blogcomment='1'");
  }

}  

?>