<?php
//////////////////////////////
// Comments v1.2            //
// Author: Passtor          //
// CopyRight 2008           //
// wwww.Passtor.ru          //
// Icq: 279347551           //
// Email: r_galeev@inbox.ru //
//////////////////////////////

class se_comments
{
		// Настройки ///////////////////////////////////////////////////////////////
		var $mCommentsHome = 5; // Кол-во комментариев выводимых на главной странице
		var $mCommentsPerPage = 20; // Кол-во комментариев выводимых на отдельных страницах
		var $mLang = array( '0' => 'Комментарий к профилю',
												'1' => 'Комментарий к событию',
												'2' => 'Комментарий к группе',
												'3' => 'Комментарий к блогу',
												'4' => 'Комментарий к фото/медиа',
												'5' => 'Без названия',
												'6' => 'Комментарий к объявлению',
												'7' => 'Комментарий к опросу',
												'8' => 'Комментарий к видео',
												'9' => 'Комментарий к фото/медиа в группе',
												'10' => 'Комментарий к фото/медиа в событии'
											);
		// Конец настроек //////////////////////////////////////////////////////////
		var $mTables = array('se_profilecomments', 'se_eventcomments', 'se_groupcomments', 'se_blogcomments', 'se_mediacomments', 'se_classifiedcomments', 'se_pollcomments', 'se_video_mediacomments', 'se_groupmediacomments', 'se_eventmediacomments');
		var $mComments = array();
		var $mFinish;
		var $mStart;
		var $mPage;
		var $mTotalComments;
		var $mTotalPages;


		function se_comments()
		{
				$this -> GetComments();
				$this -> Sort();
		}


		function CountComments()
		{
				$t_total = count($this -> mComments);
				$this -> mTotalComments = $t_total;
				return $t_total;
		}


		function CountPages()
		{
				$limit = $this -> mCommentsPerPage;
				$total = $this -> CountComments();
				$pages = floor($total / $limit);
				$this -> mTotalPages = $pages;
				return $pages;
		}


		function GetComments()
		{
				global $database;
				$t_arr = array();

				foreach($this -> mTables as $t_table)
				{
						$result = $database -> database_query("SELECT * FROM `$t_table`");
						while($temp = $database->database_fetch_assoc($result))
						{
								if($temp != '')
								{
										$t_arr[] = $temp;
								}
						}
				}
				$this -> mComments = $t_arr;
		}


		function GetUserInfo($t_uid)
		{
				global $database;
				$result = $database -> database_query("SELECT `user_id`, `user_username`, `user_photo` FROM `se_users` WHERE `user_id` = '$t_uid'");
				return $database -> database_fetch_assoc($result);
		}


		function GetCommentType($t_index)
		{
				switch($t_index)
				{
						case 'profilecomment_id' : $t_type = 0; break;
						case 'eventcomment_id' : $t_type = 1; break;
						case 'groupcomment_id' : $t_type = 2; break;
						case 'blogcomment_id' : $t_type = 3; break;
						case 'mediacomment_id' : $t_type = 4; break;
						case 'classifiedcomment_id' : $t_type = 6; break;
						case 'pollcomment_id' : $t_type = 7; break;
						case 'video_mediacomment_id' : $t_type = 8; break;
						case 'groupmediacomment_id' : $t_type = 9; break;
						case 'eventmediacomment_id' : $t_type = 10;
				}
				return $t_type;
		}


		function MakeLink($t_type, $t_id)
		{
				global $database, $url;

				if($t_type == 0)
				{
						$result = $database -> database_query("SELECT `user_username` FROM `se_users` WHERE `user_id` = '$t_id'");
						list($t_name) = $database -> database_fetch_array($result);
						$t_url = $url->url_create('profile', $t_name);
						$out = "<a href='$t_url'>$t_name</a>";
				}

				elseif($t_type == 1)
				{
						$result = $database -> database_query("SELECT `event_title` FROM `se_events` WHERE `event_id` = '$t_id'");
						list($t_name) = $database -> database_fetch_array($result);
						$out = "<a href='event.php?event_id=$t_id'>$t_name</a>";
				}

				elseif($t_type == 2)
				{
						$result = $database -> database_query("SELECT `group_title` FROM `se_groups` WHERE `group_id` = '$t_id'");
						list($t_name) = $database -> database_fetch_array($result);
						$out = "<a href='group.php?group_id=$t_id'>$t_name</a>";
				}

				elseif($t_type == 3)
				{
						$result = $database -> database_query("SELECT `blogentry_title`, `blogentry_user_id` FROM `se_blogentries` WHERE `blogentry_id` = '$t_id'");
						list($t_name, $t_uid) = $database -> database_fetch_array($result);
						$t_arr = $this -> GetUserInfo($t_uid);
						$t_uname = $t_arr['user_username'];
						$t_url = $url->url_create('blog_entry', $t_uname, $t_id);
						$out = "<a href='$t_url'>$t_name</a>";
				}

				elseif($t_type == 4)
				{
						$result = $database -> database_query("SELECT `media_album_id`, `media_title` FROM `se_media` WHERE `media_id` = '$t_id'");
						list($t_m_album_id, $t_name) = $database -> database_fetch_array($result);
						$t_name = ($t_name == '') ? $this -> mLang[5] : $t_name;
						$result = $database -> database_query("SELECT `album_user_id` FROM `se_albums` WHERE `album_id` = '$t_m_album_id'");
						list($t_uid) = $database -> database_fetch_array($result);
						$t_arr = $this -> GetUserInfo($t_uid);
						$t_uname = $t_arr['user_username'];
						$t_url = $url->url_create('album_file', $t_uname, $t_m_album_id, $t_id);
						$out = "<a href='$t_url'>$t_name</a>";
				}

				elseif($t_type == 6)
				{
						$result = $database -> database_query("SELECT `classified_user_id`, `classified_title` FROM `se_classifieds` WHERE `classified_id` = '$t_id'");
						list($t_uid, $t_name) = $database -> database_fetch_array($result);
						$t_name = ($t_name == '') ? $this -> mLang[5] : $t_name;
						$t_arr = $this -> GetUserInfo($t_uid);
						$t_uname = $t_arr['user_username'];
						$t_url = $url->url_create('classified', $t_uname, $t_id);
						$out = "<a href='$t_url'>$t_name</a>";
				}

				elseif($t_type == 7)
				{
						$result = $database -> database_query("SELECT `poll_user_id`, `poll_title` FROM `se_polls` WHERE `poll_id` = '$t_id'");
						list($t_uid, $t_name) = $database -> database_fetch_array($result);
						$t_name = ($t_name == '') ? $this -> mLang[5] : $t_name;
						$t_arr = $this -> GetUserInfo($t_uid);
						$t_uname = $t_arr['user_username'];
						$t_url = $url->url_create('polls', $t_uname, $t_id);
						$out = "<a href='$t_url'>$t_name</a>";
				}

				elseif($t_type == 8)
				{
						$result = $database -> database_query("SELECT `media_album_id`, `media_title` FROM `se_video_media` WHERE `media_id` = '$t_id'");
						list($t_m_album_id, $t_name) = $database -> database_fetch_array($result);
						$t_name = ($t_name == '') ? $this -> mLang[5] : $t_name;
						$result = $database -> database_query("SELECT `album_user_id` FROM `se_video_albums` WHERE `album_id` = '$t_m_album_id'");
						list($t_uid) = $database -> database_fetch_array($result);
						$t_arr = $this -> GetUserInfo($t_uid);
						$t_uname = $t_arr['user_username'];
						$t_url = $url->url_create('video', $t_uname, $t_m_album_id, $t_id);
						$out = "<a href='$t_url'>$t_name</a>";
				}

				elseif($t_type == 9)
				{
						$result = $database -> database_query("SELECT `group_title` FROM `se_groups` WHERE `group_id` = '$t_id'");
						list($t_name) = $database -> database_fetch_array($result);
						$out = "<a href='group.php?group_id=$t_id'>$t_name</a>";
				}

				elseif($t_type == 10)
				{
						$result = $database -> database_query("SELECT `event_title` FROM `se_events` WHERE `event_id` = '$t_id'");
						list($t_name) = $database -> database_fetch_array($result);
						$out = "<a href='event.php?event_id=$t_id'>$t_name</a>";
				}
				return $out;
		}


		function Pager($page)
		{
				$page--;
				$limit = $this -> mCommentsPerPage;
				$total = $this -> CountComments();
				$pages = $this -> mTotalPages;
				$start = ($page * $limit);

				if($page == $pages)
				{
						$f1 = ($page * $limit);
						$f2 = ( $total - ($page * $limit) );
						$finish = $f1 + $f2;
				}
				else
				{
						$finish = ( ($page + 1) * $limit );
				}
				$out = array($start, $finish);
				return $out;
		}


		function Process($t_limit)
		{
				$count = 1;
				$t_arr = $this -> mComments;
				$t_parsed = array();

				foreach($t_arr as $t_comment)
				{
						$temp = array();
						$t_user = array();
						list($t_index) = array_keys($t_comment);
						$t_type = $this -> GetCommentType($t_index);
						$t_desc = $this -> mLang[$t_type];

						foreach($t_comment as $t_data)
						{
								$temp[] = $t_data;
						}
						list($t_id, $t_plugin_id, $t_author_id, $t_date, $t_body) = $temp;
						$t_body = $this -> SmileReplacer($t_body);
						$t_user = $this -> GetUserInfo($t_author_id);
						$t_link = $t_desc.' '.$this -> MakeLink($t_type, $t_plugin_id);
						$author = new se_user();
						$author -> user_info['user_id'] = $t_user['user_id'];
						$author -> user_info['user_username'] = $t_user['user_username'];
						$author -> user_info['user_photo'] = $t_user['user_photo'];
						$t_parsed[] = array('comment_author' => $author,
																'comment_desc' => $t_link,
																'comment_date' => $t_date,
																'comment_body' => $t_body
																);

						if($count >= $t_limit)
						{
								return $t_parsed;
						}
						else
						{
								$count++;
						}
				}
				return $t_parsed;
		}


		function Process2($t_start, $t_finish)
		{
				$t_arr = $this -> mComments;
				$t_parsed = array();

				for($i = $t_start; $i < $t_finish; $i++)
				{
						$temp = array();
						$t_user = array();
						$t_comment = $t_arr[$i];
						list($t_index) = array_keys($t_comment);
						$t_type = $this -> GetCommentType($t_index);
						$t_desc = $this -> mLang[$t_type];

						foreach($t_comment as $t_data)
						{
								$temp[] = $t_data;
						}
						list($t_id, $t_plugin_id, $t_author_id, $t_date, $t_body) = $temp;
						$t_body = $this -> SmileReplacer($t_body);
						$t_user = $this -> GetUserInfo($t_author_id);
						$t_link = $t_desc.' '.$this -> MakeLink($t_type, $t_plugin_id);
						$author = new se_user();
						$author -> user_info['user_id'] = $t_user['user_id'];
						$author -> user_info['user_username'] = $t_user['user_username'];
						$author -> user_info['user_photo'] = $t_user['user_photo'];
						$t_parsed[] = array('comment_author' => $author,
																'comment_desc' => $t_link,
																'comment_date' => $t_date,
																'comment_body' => $t_body
																);
				}
				return $t_parsed;
		}


		function ShowHome()
		{
				$t_num = $this -> mCommentsHome;
				$total = $this -> CountComments();
				$t_limit = ($t_num > $total) ? $total : $t_num;
				$out = $this -> Process($t_limit);
				return $out;
		}


		function ShowPage($page = 1)
		{
				$pages = $this -> CountPages();
				$page = ( (!is_numeric($page) || ($page > $pages) || ($page < 1) ) ) ? 1 : $page;
				$this -> mPage = $page;
				list($t_start, $t_finish) = $this -> Pager($page);
				$this -> mStart = $t_start;
				$this -> mFinish = $t_finish;
				$out = $this -> Process2($t_start, $t_finish);
				return $out;
		}


		function SmileReplacer($t_feed)
		{
				$temp = 'bad,biggrin,blum,blush,cray,crazy,dance,diablo,dirol,drinks,fool,good,kiss_mini,man_in_love,music,nea,pardon,rofl,rolleyes,sad,scratch_one-s_head,shok,shout,smile,unknw,wacko2,wink,yahoo,angel';
				$smilies_arr = explode(',', $temp);

				foreach($smilies_arr as $t_smile)
				{
						$t_smile = trim($t_smile);
						$t_patt = ':'.$t_smile.':';
						$t_rep = '<img alt="'.$t_smile.'" src="./templates/images/smiles/'.$t_smile.'.gif" border=0>';
						$t_feed = eregi_replace("$t_patt", "$t_rep", $t_feed);
				}
				return $t_feed;
		}


		function Sort()
		{
				$t_arr = $this -> mComments;
				$t_sorted = array();
				$t_order = array();

				foreach($t_arr as $t_comment)
				{
						$temp = array();

						foreach($t_comment as $t_data)
						{
								$temp[] = $t_data;
						}
						$t_order[] = $temp[3];
				}
				arsort($t_order);
				reset($t_order);

				foreach($t_order as $t_id => $void)
				{
						$t_sorted[] = $t_arr[$t_id];
				}
				unset($this -> mComments);
				$this -> mComments = $t_sorted;
		}
}
?>