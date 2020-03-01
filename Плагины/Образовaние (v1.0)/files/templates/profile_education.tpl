{if $owner->level_info.level_education_allow != 0 AND ($total_educations > 0 OR $owner->user_info.user_username == $user->user_info.user_username) }
  <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
  <tr><td class='header'>
    {$header_education1} ({$total_educations})
  </td></tr>
  <tr>
  <td class='profile'>
  {foreach from=$educations item=education}
    <table cellpadding='0' cellspacing='0' class="education">
      <tr><th colspan="2">{$education.education_name} {$education.education_year}</th></tr>
      {if $education.education_for != ""}<tr><td width="80">{$header_education4}</td><td>{$education.education_for}</td></tr>{/if}
      {if $education.education_degree != ""}<tr><td>{$header_education5}</td><td>{$education.education_degree}</td></tr>{/if}
      {if $education.education_concentration1 != "" || $education.education_concentration2 != "" || $education.education_concentration3 != ""}<tr><td>{$header_education6}</td><td>{$education.education_concentration1}
{if $education.education_concentration2 != ""}, {$education.education_concentration2}{/if}
{if $education.education_concentration3 != ""}, {$education.education_concentration3}{/if}
      </td></tr>{/if}
    </table>
  {/foreach}
  {if $owner->user_info.user_username == $user->user_info.user_username}
    <div><img src='./images/icons/education16.gif' border='0' class='icon'><a href="user_education.php">{$header_education2}</a></div>
    {/if}
  </td>
  </tr>
  </table>
{/if}  