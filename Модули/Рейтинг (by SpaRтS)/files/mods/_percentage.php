<?

function show_percent($t_uid = 0)
{
        global $database;
        $t_total_rows = 100;
        $t_row_ids = array();

        // Check total profile rows.
        for($i = 1; $i <= $t_total_rows; $i++)
        {
                $result = $database -> database_query("SELECT `profile_$i` FROM `se_profiles`");

                if($result != FALSE)
                {
                        $t_row_ids[] = $i;
                }
        }

        // Check filled rows
        foreach($t_row_ids as $t_row)
        {
                $result = $database -> database_query("SELECT `profile_$t_row` FROM `se_profiles` WHERE `profile_user_id` = '$t_uid'");

                if($result != FALSE)
                {
                        list($t_value) = $database -> database_fetch_array($result);
                }
                else
                {
                        $t_value = '';
                }

                if($t_value != '')
                {
                        if(is_numeric($t_value))
                        {
                                if($t_value > -1)
                                {
                                        $t_filled++;
                                }
                        }
                        else
                        {
                                $t_filled++;
                        }
                }
        }

        // Calculating percentage
        $t_amount = count($t_row_ids) / 75;
        $out = round($t_filled / $t_amount, 1);
        return $out;
}
?>