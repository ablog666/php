<?php
function rating_bar($id, $units = '', $static = '')
{
		require('include/database_config.php');
		$rating_tableName = 'se_ratings';
		$rating_path_db = '';
		$rating_path_rpc = '';
		$rating_unitwidth = 30;
		$rating_conn = mysql_connect($database_host, $database_username, $database_password) or die('Error connecting to mysql');
		$ip = $_SERVER['REMOTE_ADDR'];
		if (!$units)
		{
				$units = 10;
		}
		if (!$static)
		{
				$static = false;
		}
		$query = mysql_query("SELECT total_votes, total_value, used_ips FROM ".$database_name.".".$rating_tableName." WHERE id='".$id."' ") or die(" Error: " . mysql_error());
		if (mysql_num_rows($query) == 0)
		{
				$sql = "INSERT INTO ".$database_name.".".$rating_tableName." (`id`,`total_votes`, `total_value`, `used_ips`) VALUES ('".$id."', '0', '0', '')";
				$result = mysql_query($sql);
		}
		$numbers = mysql_fetch_assoc($query);
		if ($numbers['total_votes'] < 1)
		{
				$count = 0;
		}
		else
		{
				$count = $numbers['total_votes'];
		}
		$current_rating = $numbers['total_value'];
		$tense = ($count == 1) ? "vote" : "votes";
		$voted = mysql_num_rows(mysql_query("SELECT used_ips FROM ".$database_name.".".$rating_tableName." WHERE used_ips LIKE '%" . $ip . "%' AND id='" . $id . "' "));
		$rating_width = @number_format($current_rating / $count, 2) * $rating_unitwidth;
		$rating1 = @number_format($current_rating / $count, 1);
		$rating2 = @number_format($current_rating / $count, 2);
		if ($static == 'static')
		{
				$static_rater = array();
				$static_rater[] .= "\n" . '<div class="ratingblock">';
				$static_rater[] .= '<div id="unit_long' . $id . '">';
				$static_rater[] .= '<ul id="unit_ul' . $id . '" class="unit-rating" style="width:' . $rating_unitwidth * $units . 'px;">';
				$static_rater[] .= '<li class="current-rating" style="width:' . $rating_width . 'px;">Currently ' . $rating2 . '/' . $units . '</li>';
				$static_rater[] .= '</ul>';
				$static_rater[] .= '<p class="static">' . $id . '. Rating: <strong> ' . $rating1 . '</strong>/' . $units . ' (' . $count . ' ' . $tense . ' cast) <em>This is \'static\'.</em></p>';
				$static_rater[] .= '</div>';
				$static_rater[] .= '</div>' . "\n\n";
				return join("\n", $static_rater);
		}
		else
		{
				$rater = '';
				$rater .= '<div class="ratingblock">';
				$rater .= '<div id="unit_long' . $id . '">';
				$rater .= '  <ul id="unit_ul' . $id . '" class="unit-rating" style="width:' . $rating_unitwidth * $units . 'px;">';
				$rater .= '     <li class="current-rating" style="width:' . $rating_width . 'px;">Currently ' . $rating2 . '/' . $units . '</li>';
				for ($ncount = 1; $ncount <= $units; $ncount++)
				{
						if (!$voted)
						{
								$rater .= '<li><a href="db.php?j=' . $ncount . '&amp;q=' . $id . '&amp;t=' . $ip . '&amp;c=' . $units . '" title="' . $ncount . ' out of ' . $units . '" class="r' . $ncount . '-unit rater" rel="nofollow">' . $ncount . '</a></li>';
						}
				}
				$ncount = 0;
				$rater .= '  </ul>';
				$rater .= '  <p';
				if ($voted)
				{
						$rater .= ' class="voted"';
				}
				$rater .= '>' . $id . ' Rating: <strong> ' . $rating1 . '</strong>/' . $units . ' (' . $count . ' ' . $tense . ' cast)';
				$rater .= '  </p>';
				$rater .= '</div>';
				$rater .= '</div>';
				return $rater;
		}
}
?>