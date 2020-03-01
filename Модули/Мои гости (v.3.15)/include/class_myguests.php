<?
/////////////////////
// My Guests v.3.5 //
// AUTHOR: PASSTOR //
// CopyRight 2008  //
/////////////////////


class MyGuests
{
		var $mOid;
		var $mUid;
		var $mMaxEntries = 20;// Макисимальное кол-во записей гостей в бд для 1 пользоваля

		// Удаляет последнюю запись
		function DeleteLastEntry()
		{
				global $database;
				$t_oid = $this -> mOid;
				$t_uid = $this -> mUid;
				$result = $database -> database_query("SELECT `time` FROM `se_myguests` WHERE `oid` = '$t_oid'");
				$rows = $database -> database_num_rows($result);

				if($rows != 0)
				{
						$t_entries = array();

						for($i = 0; $i < $rows; $i++)
						{
								list($t_entries[]) = $database -> database_fetch_array($result);
						}
						sort($t_entries);
						reset($t_entries);
						$t_time = $t_entries[0];
						$database -> database_query("DELETE FROM `se_myguests` WHERE `oid` = '$t_oid' AND `time` = '$t_time'");
				}
				else
				{
						return 0;
				}
		}


		// Проверка на наличии гостя в таблице
		function IsDuplicate()
		{
				global $database;
				$t_oid = $this -> mOid;
				$t_uid = $this -> mUid;
				$result = $database -> database_query("SELECT * FROM `se_myguests` WHERE `oid` = '$t_oid' AND `uid` = '$t_uid'");
				$rows = $database -> database_num_rows($result);

				if($rows != 0)
				{
						return 1;
				}
				else
				{
						return 0;
				}
		}


		// Возвращает названия Mysql рядя
		function GetPlace($t_place)
		{
				switch($t_place)
				{
						case 1 : $out = 'p_views'; break;
						case 2 : $out = 'f_views'; break;
						case 3 : $out = 'b_views';
				}
				return $out;
		}


		// Возвращает массив с данными гостей. Eсли пользователь не найден, то удалаяется все данные с ним.
		function GetResults($t_brief = 0)
		{
				global $database;
				$t_oid = $this -> mOid;

				if($this -> GetUids() != 0)
				{
						$out = array();

						foreach($this -> GetUids() as $t_uid)
						{
								if($t_brief == 1)
								{
										$result = $database -> database_query("SELECT `user_username` FROM `se_users` WHERE `user_id` = '$t_uid'");
								}
								else
								{
										$result = $database -> database_query("SELECT `user_id`, `user_username`, `user_photo` FROM `se_users` WHERE `user_id` = '$t_uid'");
								}
								$rows = $database -> database_num_rows($result);

								if($rows != 0)
								{
										if($t_brief == 1)
										{
												list($out[]) = $database -> database_fetch_array($result);
										}
										else
										{
												$t_user = $database -> database_fetch_assoc($result);
												$result = $database -> database_query("SELECT `date`, `time`, `p_views`, `f_views`, `b_views` FROM `se_myguests` WHERE `oid` = '$t_oid' AND `uid` = '$t_uid'");
												$t_details = $database -> database_fetch_assoc($result);
												$t_data = array_merge($t_user, $t_details);
												$out[] = $t_data;
										}
								}
								else
								{
										$database -> database_query("DELETE FROM `se_myguests` WHERE `oid` = '$t_oid' AND `uid` = '$t_uid'");
								}
						}
						return $out;
				}
				else
				{
						return 0;
				}
		}


		// Кол-во всех записей гостей для пользователя
		function GetTotalEntries()
		{
				global $database;
				$t_oid = $this -> mOid;
				$result = $database -> database_query("SELECT * FROM `se_myguests` WHERE `oid` = '$t_oid'");
				$rows = $database -> database_num_rows($result);

				if($rows != 0)
				{
						return $rows;
				}
				else
				{
						return 0;
				}
		}


		// Возвращает значение выбранного рядя таблицы
		function GetValue($t_place)
		{
				global $database;
				$t_oid = $this -> mOid;
				$t_uid = $this -> mUid;
				$t_col = $this -> GetPlace($t_place);
				$result = $database -> database_query("SELECT `$t_col` FROM `se_myguests` WHERE `oid` = '$t_oid' AND `uid` = '$t_uid'");
				list($out) = $database -> database_fetch_array($result);
				return $out;
		}


		// Возвращает массив с user_id гостей
		function GetUids()
		{
				global $database;
				$t_oid = $this -> mOid;
				$result = $database -> database_query("SELECT `uid` FROM `se_myguests` WHERE `oid` = '$t_oid' ORDER BY `time` DESC");
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


		// Конструктор объекта
		function MyGuests($t_oid = 0, $t_uid = 0)
		{
				$this -> mOid = $t_oid;
				$this -> mUid = $t_uid;
		}


		// Очмстка всех данных для этого пользователя
		function Reset()
		{
				global $database;
				$t_oid = $this -> mOid;
				$database -> database_query("DELETE FROM `se_myguests` WHERE `oid` = '$t_oid'");
		}


		// Запись данных в таблицу
		function SetVisit($t_place)
		{
				global $database;
				$t_oid = $this -> mOid;
				$t_uid = $this -> mUid;
				$t_max = $this -> mMaxEntries;

				if( ($t_oid != $t_uid) && ($t_uid != 0 ) && ($t_uid != 0 ) )
				{
						$t_date = date('H:i, j/m/y');
						$t_time = time();
						$t_col = $this -> GetPlace($t_place);

						if($this -> GetTotalEntries() >= $t_max)
						{
								$this -> DeleteLastEntry();
						}

						if($this -> IsDuplicate() == 0)
						{
								$database -> database_query("INSERT INTO `se_myguests` VALUES('$t_oid', '$t_uid', '$t_date', '$t_time', '0', '0', '0')");
								$database -> database_query("UPDATE `se_myguests` SET `$t_col` = '1' WHERE `oid` = '$t_oid' AND `uid` = '$t_uid'");
						}
						else
						{
								$t_value = $this -> GetValue($t_place) + 1;
								$database -> database_query("UPDATE `se_myguests` SET `$t_col` = '$t_value', `time` = '$t_time', `date` = '$t_date' WHERE `oid` = '$t_oid' AND `uid` = '$t_uid'");
						}
				}
		}
}
?>