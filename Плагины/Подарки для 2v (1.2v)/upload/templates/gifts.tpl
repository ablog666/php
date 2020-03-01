      <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
      <tr><td class='header'>Подарки ({$total_gifts})
        &nbsp;[ <a href='profile_gifts.php?user={$owner->user_info.user_username}'>{$profile25} подарки</a> ]
      </td></tr>
      <tr>
      <td class='profile' align='center'>
        {* LOOP THROUGH GIFTS *}
  {section name=gifts_loop loop=$gifts}
  {cycle name="startrow" values="<table cellpadding='0' cellspacing='0'><tr>,,,,"}
<td align='center'>
<img src='./images/gifts/{$gifts[gifts_loop].gifts_id}.png' title='{$gifts[gifts_loop].gifts_comment}'><BR>
{if $gifts[gifts_loop].gifts_type == 1}
<a href='{$url->url_create('profile',$gifts[gifts_loop].gifts_from->user_info.user_username)}'>{$gifts[gifts_loop].gifts_from->user_info.user_username}</a>
{elseif $gifts[gifts_loop].gifts_type == 2}
{if $owner->user_info.user_id == $user->user_info.user_id}
<a href='{$url->url_create('profile',$gifts[gifts_loop].gifts_from->user_info.user_username)}'>{$gifts[gifts_loop].gifts_from->user_info.user_username}</a>
{else}
Аноним
{/if}
{elseif $gifts[gifts_loop].gifts_type == 3}
Аноним
{/if}
</td>
  {if $smarty.section.gifts_loop.last == true}
    </tr></table>
  {else}
    {cycle name="endrow" values=",,,,</tr></table>"}
  {/if}
  {/section}
      </td>
      </tr>
      </table>