<?
/////////////////////
// Birthdays v.1.5 //
// AUTHOR: PASSTOR //
// CopyRight 2008  //
/////////////////////


class Birthdays
{
		var $mUid;
		var $mDay;
		var $mMonth;
		var $mYear;
		var $mToday;


		// ����������� �������
		function Birthdays($t_uid = 0)
		{
				$this -> mUid = $t_uid;
				$this -> mDay = date('j');
				$this -> mMonth = date('n');
				$this -> mYear = date('Y');
				$this -> mToday = mktime(0,0,0,$this -> mMonth,$this -> mDay,$this -> mYear);
		}


		// ���������� ���� �� timestamp
		function GetDay($t_stamp)
		{
				$t_arr = array();
				$t_arr = getdate($t_stamp);
				$out = $t_arr['mday'];
				return $out;
		}


		// ���������� uids ������
		function GetFriends()
		{
				global $database;
				$t_uid = $this -> mUid;
				$result = $database -> database_query("SELECT `friend_user_id2` FROM `se_friends` WHERE `friend_user_id1` = '$t_uid' AND `friend_status` = '1'");
				$rows = $database -> database_num_rows($result);

				if($rows != 0)
				{
						$out = array();

						for($i = 0; $i < $rows; $i++)
						{
								list($out[]) = $database -> database_fetch_array($result);
						}
						return $out;
				}
				else
				{
						return 0;
				}
		}


		// ���������� ����� �� timestamp
		function GetMon($t_stamp)
		{
				$t_arr = array();
				$t_arr = getdate($t_stamp);
				$out = $t_arr['mon'];
				return $out;
		}


		// ���������� ��������� ���� ������
		function GetMonDays()
		{
				$t_mon = $this -> mMonth;
				$t_yr = $this -> mYear;
				$t_mon++;
				$t_stamp = mktime(0,0,0,$t_mon,0,$t_yr);
				$out = date('j', $t_stamp);
				return $out;
		}


		// ���������� ������ ���������� �������
		function GetProfile($t_uid = 0)
		{
				global $database;

				if($t_uid != 0)
				{
						$result = $database -> database_query("SELECT `user_username`, `user_photo` FROM `se_users` WHERE `user_id` = '$t_uid'");
						$t_user_info = $database -> database_fetch_assoc($result);
						$result = $database -> database_query("SELECT `profile_9` FROM `se_profiles` WHERE `profile_user_id` = '$t_uid'");
						list($t_stamp) = $database -> database_fetch_array($result);
						$t_day = $this -> GetDay($t_stamp);
						$t_mon = $this -> GetMon($t_stamp);

						switch($t_mon)
						{
								case '1' : $t_mon_name = '������'; break;
								case '2' : $t_mon_name = '�������'; break;
								case '3' : $t_mon_name = '�����'; break;
								case '4' : $t_mon_name = '������'; break;
								case '5' : $t_mon_name = '���'; break;
								case '6' : $t_mon_name = '����'; break;
								case '7' : $t_mon_name = '����'; break;
								case '8' : $t_mon_name = '�������'; break;
								case '9' : $t_mon_name = '��������'; break;
								case '10' : $t_mon_name = '�������'; break;
								case '11' : $t_mon_name = '������'; break;
								default : $t_mon_name = '�������';
						}
						$t_user_info['date'] = $t_day.' '.$t_mon_name;
						return $t_user_info;
				}
				return 0;
		}


		// ���������� timestamp ���� �������� ���� �������������
		function GetUserBrths()
		{
				global $database;
				$result = $database -> database_query('SELECT `profile_user_id`, `profile_9` FROM `se_profiles`');
				$rows = $database -> database_num_rows($result);
				$out = array();

				for($i = 0; $i < $rows; $i++)
				{
						list($t_uid, $t_stamp) = $database -> database_fetch_array($result);

						if($t_stamp > 0)
						{
								$out[$t_uid] = $t_stamp;
						}
				}
				return $out;
		}


		// ���������� ������ ���������� �������
		function GetUserName($t_uid = 0)
		{
				global $database;

				if($t_uid != 0)
				{
						$result = $database -> database_query("SELECT `user_username` FROM `se_users` WHERE `user_id` = '$t_uid'");
						list($out) = $database -> database_fetch_array($result);
						return $out;
				}
				else
				{
						return 0;
				}
		}


		// ���������� ��� � ������
		function GetWeekDays()
		{
				$t_time = $this -> mToday;
				$t_fn_time = $this -> GetWeekEnd();
				$t_arr = array();

				while($t_time <= $t_fn_time)
				{
						$t_arr[] = $t_time;
						$t_time += 86400;
				}
				return $t_arr;
		}


		// ���������� timestamp ���������� ���� ������
		function GetWeekEnd()
		{
				$t_st_day = $this -> mDay;
				$t_fn_day = $t_st_day + 7;
				$t_mon = $this -> mMonth;
				$t_yr = $this -> mYear;
				$t_w_arr = array();

				for($i = $t_st_day; $i < $t_fn_day; $i++)
				{
						$t_stamp = mktime(0,0,0,$t_mon,$i,$t_yr);
						$t_wday = date('w', $t_stamp);
						$t_w_arr[$t_wday] = $t_stamp;
				}
				$out = $t_w_arr[0];
				return $out;
		}


		// ��������� ���� �� � ������ ������������ ������� ���� ��������
		function IsFriendBirthday()
		{
				global $database;
				$t_day = $this -> mDay;
				$t_mon = $this -> mMonth;
				$t_f_uids = $this -> GetFriends();

				if($t_f_uids != 0)
				{
						$out = array();

						foreach($t_f_uids as $t_f_uid)
						{
								$result = $database -> database_query("SELECT `profile_9` FROM `se_profiles` WHERE `profile_user_id` = '$t_f_uid'");
								list($t_stamp) = $database -> database_fetch_array($result);

								if($t_stamp > 0)
								{
										$t_chk_day = $this -> GetDay($t_stamp);
										$t_chk_mon = $this -> GetMon($t_stamp);

										if( ($t_chk_day == $t_day) && ($t_chk_mon == $t_mon) )
										{
												$out[] =  $this -> GetUserName($t_f_uid);
										}
								}
						}

						if(count($out) != 0)
						{
								return $out;
						}
						else
						{
								return 0;
						}
				}
				else
				{
						return 0;
				}
		}


		// ��������� ���� �� � ������������ ������� ���� ��������
		function IsUserBirthday()
		{
				global $database;
				$t_uid = $this -> mUid;
				$t_day = $this -> mDay;
				$t_mon = $this -> mMonth;

				if($t_uid != 0)
				{
						$result = $database -> database_query("SELECT `profile_9` FROM `se_profiles` WHERE `profile_user_id` = '$t_uid'");
						list($t_stamp) = $database -> database_fetch_array($result);

						if($t_stamp > 0)
						{
								$t_chk_day = $this -> GetDay($t_stamp);
								$t_chk_mon = $this -> GetMon($t_stamp);

								if( ($t_chk_day == $t_day) && ($t_chk_mon == $t_mon) )
								{
										return 1;
								}
								else
								{
										return 0;
								}
						}
						else
						{
								return 0;
						}
				}
				else
				{
						return 0;
				}
		}


		// ���������� user_id ������������� � ���� �������� �� ���� ������, ����� ����������� � ����������
		function ShowMonUsers($show_uid = 0)
		{
				$t_day = $this -> mDay;
				$t_mon = $this -> mMonth;
				$t_l_day = $this -> GetMonDays();
				$t_arr = $this -> GetUserBrths();

				for($i = $t_day; $i <= $t_l_day; $i++)
				{
						foreach($t_arr as $t_uid => $t_stamp)
						{
								$t_chk_day = $this -> GetDay($t_stamp);
								$t_chk_mon = $this -> GetMon($t_stamp);

								if( ($t_chk_day == $i) && ($t_chk_mon == $t_mon) )
								{
										$out[] = ($show_uid == 1) ? $t_uid : $this -> GetUserName($t_uid);
								}
						}
				}

				if(count($out) != 0)
				{
						return $out;
				}
				else
				{
						return 0;
				}
		}


		// ���������� user_id ������������� � ����������� ���� ��������
		function ShowTodayUsers($show_uid = 0)
		{
				$t_day = $this -> mDay;
				$t_mon = $this -> mMonth;
				$t_arr = $this -> GetUserBrths();
				$out = array();

				foreach($t_arr as $t_uid => $t_stamp)
				{
						$t_chk_day = $this -> GetDay($t_stamp);
						$t_chk_mon = $this -> GetMon($t_stamp);

						if( ($t_chk_day == $t_day) && ($t_chk_mon == $t_mon) )
						{
								$out[] = ($show_uid == 1) ? $t_uid : $this -> GetUserName($t_uid);
						}
				}

				if(count($out) != 0)
				{
						return $out;
				}
				else
				{
						return 0;
				}
		}


		// ���������� user_names ������������� � ����������� ���� ��������
		function ShowTomorrowUsers($show_uid = 0)
		{
				$t_day = $this -> mDay;
				$t_mon = $this -> mMonth;
				$t_yr = $this -> mYear;
				$t_day++;
				$t_stamp = mktime(0,0,0,$t_mon,$t_day,$t_yr);
				$t_day = date('j', $t_stamp);
				$t_arr = $this -> GetUserBrths();
				$out = array();

				foreach($t_arr as $t_uid => $t_stamp)
				{
						$t_chk_day = $this -> GetDay($t_stamp);
						$t_chk_mon = $this -> GetMon($t_stamp);

						if( ($t_chk_day == $t_day) && ($t_chk_mon == $t_mon) )
						{
								$out[] = ($show_uid == 1) ? $t_uid : $this -> GetUserName($t_uid);
						}
				}

				if(count($out) != 0)
				{
						return $out;
				}
				else
				{
						return 0;
				}
		}


		// ���������� user_id ������������� � ���� �������� �� ���� ������, ����� ����������� � ����������
		function ShowWeekUsers($show_uid = 0)
		{
				$t_arr = $this -> GetUserBrths();
				$t_week = $this -> GetWeekDays();

				foreach($t_week as $t_w_stamp)
				{
						$t_day = $this -> GetDay($t_w_stamp);
						$t_mon = $this -> GetMon($t_w_stamp);

						foreach($t_arr as $t_uid => $t_stamp)
						{
								$t_chk_day = $this -> GetDay($t_stamp);
								$t_chk_mon = $this -> GetMon($t_stamp);

								if( ($t_chk_day == $t_day) && ($t_chk_mon == $t_mon) )
								{
										$out[] = ($show_uid == 1) ? $t_uid : $this -> GetUserName($t_uid);
								}
						}
				}

				if(count($out) != 0)
				{
						return $out;
				}
				else
				{
						return 0;
				}
		}


		// ���������� uid ������������ ��� ����� � user_home.php
		function SmartFeed()
		{
				$t_arr = $this -> ShowTodayUsers(1);
				$t_arr_2 = $this -> ShowTomorrowUsers(1);
				$t_arr_3 = $this -> ShowWeekUsers(1);
				$t_arr_4 = $this -> ShowMonUsers(1);

				if($t_arr != 0)
				{
						$t_feed = $t_arr;
						$t_desc = '�������';
						$t_showdate = 0;
				}
				elseif( ($t_arr == 0) && ($t_arr_2 != 0) )
				{
						$t_feed = $t_arr_2;
						$t_desc = '������';
						$t_showdate = 0;
				}
				elseif( ($t_arr == 0) && ($t_arr_2 == 0) && ($t_arr_3 != 0) )
				{
						$t_feed = $t_arr_3;
						$t_desc = '�� ���� ������';
						$t_showdate = 1;
				}
				else
				{
						$t_feed = $t_arr_4;
						$t_desc = '� ���� ������';
						$t_showdate = 1;
				}
				srand((float)microtime()*1000000);
				shuffle($t_feed);
				$out = array($t_feed, $t_desc, $t_showdate);
				return $out;
		}
}
?>