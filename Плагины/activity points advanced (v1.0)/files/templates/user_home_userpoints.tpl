  {* SHOW USER POINTS START 1/1 *}

{if $userpoints_enabled && ($user->level_info.level_userpoints_allow != 0) && ($user->user_info.user_userpoints_allowed != 0) }

  <table cellpadding='0' cellspacing='0' width='100%' style='margin-top: 10px;'>
  <tr><td class='home_header'>{$user_home600}</td></tr>
  <tr>
  <td class='home_box'>
    <table cellpadding='0' cellspacing='0'>

    <tr>
    <td valign='top'>&nbsp;&nbsp;</td>
    <td>
	  {if $userpoints_enable_topusers}
		{$user_home601} <a href="topusers.php"> <span style="font-weight:bold">{if $user_points_totalearned != 0 } {$user_rank} {else} {$user_home606} {/if}</span> </a> <br><br>
      {/if}

	  {if $userpoints_enable_pointrank}
		{$user_home605} <span style="font-weight:bold">{include file='user_points_staticrank.tpl'}</span> <br><br>
	  {/if}

      {$user_home602} <a href="user_vault.php"> <span style="font-weight:bold" id="voter_points_count">{$user_points}</span> {$user_home603}</a> <br><br>
      {$user_home604} <a href="user_vault.php"> <span style="font-weight:bold" id="voter_points_count">{$user_points_totalearned}</span> {$user_home603}</a> <br><br>

      <a href="user_points_offers.php">{$user_home607}</a>
      <span style="pading-left: 4px; padding-right: 4px; color: #CCC"> | </span>
      <a href="user_points_shop.php">{$user_home608}</a>
	
    </td>
    </tr>

    </table>
  </td>
  </tr>
  </table>

{/if}
  
  {* SHOW USER POINTS END 1/1 *}
