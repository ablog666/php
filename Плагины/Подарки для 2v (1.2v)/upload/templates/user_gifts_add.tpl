{if $result == ""}
<fotm method=post>
<form action='user_gifts_add.php?user={$owner->user_info.user_username}' method='post'>
<table>
<tr><td colspan='2' align='center'>
<a href="user_gifts_add.php?user={$owner->user_info.user_username}&w=0" >{$user_gifts_add12}</a>
{section name=giftsc_loop loop=$giftsc}
<a href="user_gifts_add.php?user={$owner->user_info.user_username}&w={$giftsc[giftsc_loop].giftsc_id}" >{$giftsc[giftsc_loop].giftsc_name}</a>
{/section}
</td></tr>
<tr><td colspan=2>
  {section name=giftss_loop loop=$gifts}
  {cycle name="startrow" values="<table cellpadding='0' cellspacing='0'><tr>,,,"}
	<td align='center'><img src='./images/gifts/{$gifts[giftss_loop].gifts_id}.png'><BR>{$gifts[giftss_loop].gifts_price} points<BR><input type='radio' name='gifts_id' value='{$gifts[giftss_loop].gifts_id}' ></td>
  {* END ROW AFTER 3 RESULTS *}
  {if $smarty.section.giftss_loop.last == true}
    </tr></table>
  {else}
    {cycle name="endrow" values=",,,</tr></table>"}
  {/if}
  {/section}
</td></tr>
<tr><td>{$user_gifts_add5}</td><td align=center><img class='photo' src='{$owner->user_photo("./images/nophoto.gif")}' border='0' width='100'><BR>{$owner->user_info.user_username}</td></tr>
<tr><td>{$user_gifts_add6}</td><td><select name='gifts_type'><option value='1'>{$user_gifts_add7}</option><option value='2'>{$user_gifts_add8}</option><option value='3'>{$user_gifts_add9}</option></select></td></tr>
<tr><td>{$user_gifts_add10}</td><td><textarea name='gifts_comment'></textarea></td></tr>
<tr><td colspan=2 align=center><input type='submit' value='{$user_gifts_add11}'></td></tr>
</table>
<input type='hidden' name='task' value='add_user_gifts'>
</form>		
{else}
{$result}
{/if}