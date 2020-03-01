{if $owner->level_info.level_employment_allow != 0 AND ($total_employments > 0 OR $owner->user_info.user_username == $user->user_info.user_username) }
  <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
  <tr><td class='header'>
   {$header_employment1} ({$total_employments})
  </td></tr>
  <tr>
  <td class='profile'>
  {foreach from=$employments item=employment}
    <table cellpadding='0' cellspacing='0' class="employment">
      <tr><th colspan="2">{$employment.employment_employer}</th></tr>
      {if $employment.employment_position != ""}<tr><td width="130">{$header_employment5}</td><td>{$employment.employment_position}</td></tr>{/if}
      {if $employment.time_period != "" }
        <tr><td width="80">{$header_employment8}</td>
        <td>{$employment.time_period}</td></tr>
      {/if}
      {if $employment.employment_location != ""}<tr><td>{$header_employment7}</td><td>{$employment.employment_location}</td></tr>{/if}
      {if $employment.employment_description != ""}<tr><td>{$header_employment6}</td><td>{$employment.employment_description|nl2br}</td></tr>{/if}
    </table>
  {/foreach}
  {if $owner->user_info.user_username == $user->user_info.user_username}
    <div><img src='./images/icons/employment16.gif' border='0' class='icon'><a href="user_employment.php">{$header_employment2}</a></div>
    {/if}
  </td>
  </tr>
  </table>
{/if}