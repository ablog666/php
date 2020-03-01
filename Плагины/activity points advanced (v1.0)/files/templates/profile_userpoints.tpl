
{* BEGIN USERPOINTS *}

{if $userpoints_enabled && ($owner->level_info.level_userpoints_allow != 0) && ($owner->user_info.user_userpoints_allowed != 0) }

  <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
  <tr><td class='header'> {$profile600}  </td></tr>
  <tr>
  <td class='profile'>

    <table cellpadding='0' cellspacing='0'>

    <tr>
    <td valign='top'>&nbsp;&nbsp;</td>
    <td>
	  {if $userpoints_enable_topusers}
		{$profile601} <a href="topusers.php"> <span style="font-weight:bold">{if $user_points_totalearned != 0 } {$user_rank} {else} {$profile606} {/if}</span> </a> <br><br>
	  {/if}

	  {if $userpoints_enable_pointrank}
		{$profile605} <span style="font-weight:bold">{include file='user_points_staticrank.tpl'}</span> <br><br>
	  {/if}
		{$profile604} <span style="font-weight:bold" id="voter_points_count">{$user_points_totalearned}</span> {$profile603} <br><br>
    </td>
    </tr>
    </table>

  </td>
  </tr>
  </table>

{/if}
