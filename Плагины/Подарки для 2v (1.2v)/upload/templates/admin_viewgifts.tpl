{include file='admin_header.tpl'}
<link rel="stylesheet" href="../templates/styles_gifts.css" title="stylesheet" type="text/css">
<script type="text/javascript" src="../images/highslide/highslide-with-html.js"></script>

<script type="text/javascript">
    hs.graphicsDir = '../images/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    hs.outlineWhileAnimating = true;
</script>

<h2>{$admin_viewgifts1}</h2>
{$admin_viewgifts2}<BR>

<a href="javascript:;" onclick="return hs.htmlExpand(this,{literal} { contentId: 'add-gifts' }{/literal} )" class="highslide">{$admin_viewgifts20}</a>

<BR>
{$result}
<BR>
  {* JAVASCRIPT FOR CHECK ALL *}
  {literal}
  <script language='JavaScript'> 
  <!---
  var checkboxcount = 1;
  function doCheckAll() {
    if(checkboxcount == 0) {
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = false;
      }}
      checkboxcount = checkboxcount + 1;
      }
    } else
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = true;
      }}
      checkboxcount = checkboxcount - 1;
      }
  }
  // -->
  </script>
  {/literal}
{if $total_gifts == 0}

  <table cellpadding='0' cellspacing='0' width='400' align='center'>
  <tr>
  <td align='center'>
    <div class='box' style='width: 300px;'><b>{$admin_viewgifts17}</b></div>
  </td>
  </tr>
  </table>
  <br>

{else}

  <div class='pages'>{$total_gifts} {$admin_viewgifts12} &nbsp;|&nbsp; {$admin_viewgifts13} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_gifts.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>

  <table cellpadding='0' cellspacing='0' class='list'>
  <tr>
  <td class='header' colspan='7' align='center'>{$admin_viewgifts3}</td>
  </tr>
  <tr>
  <td class='header' ><a class='header' href='admin_viewgifts.php?s={$i}&p={$p}'>{$admin_viewgifts6}</a></td>
  <td class='header' align='center'>{$admin_viewgifts5}</td>
  <td class='header' align='center'>{$admin_viewgifts4}</td>
  <td class='header' align='center'>{$admin_viewgifts7}</td>
  <td class='header' align='center'>{$admin_viewgifts8}</td>
  <td class='header' align='center'>{$admin_viewgifts19}</td>
  <td class='header' >{$admin_viewgifts9}</td>
  </tr>
  {section name=gifts_loop loop=$gifts}
    <tr class='{cycle values="background1,background2"}'>
    <td class='item' >{$gifts[gifts_loop].gifts_user_id}</td>
    <td class='item' align='center'>{$gifts[gifts_loop].gifts_category}</td>
    <td class='item' align='center'><a href='admin_viewusers.php?f_user={$gifts[gifts_loop].gifts_from->user_info.user_username}'>{$gifts[gifts_loop].gifts_from->user_info.user_username}</a></td>
    <td class='item' align='center'><a href='admin_viewusers.php?f_user={$gifts[gifts_loop].gifts_to->user_info.user_username}'>{$gifts[gifts_loop].gifts_to->user_info.user_username}</a></td>
    <td class='item' align='center'>{$gifts[gifts_loop].gifts_type}</td>
    <td class='item' align='center'>{$gifts[gifts_loop].gifts_comment}</td>
    <td class='item'>[ <a href='../images/gifts/{$gifts[gifts_loop].gifts_id}.png' class="highslide" onclick="return hs.expand(this)">{$admin_viewgifts10}</a> ] [ <a href='admin_viewgifts.php?task=confirm&gifts_id={$gifts[gifts_loop].gifts_user_id}&s={$s}&p={$p}'>{$admin_viewgifts11}</a> ]</td>
    </tr>
  {/section}
  <tr>
  <td align='center' valign='top' colspan=4>
    <div class='pages2'>{$total_gifts} {$admin_viewgifts12} &nbsp;|&nbsp; {$admin_viewgifts13} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_gifts.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  </td>
  </tr>
  </table>
{/if}

<div class="highslide-html-content" id="add-gifts">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">{$admin_viewgifts24}</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body">
<fotm method=post>
<form action='admin_viewgifts.php' method='post'>
<table>
<tr><td>{$admin_viewgifts26} </td><td><input type='text' name='t_id'></td></tr>
<tr><td>{$admin_viewgifts27}</td><td><input type=text name='f_id'></td></tr>
<tr><td>{$admin_viewgifts28}</td><td><select name='gifts_type'><option value='1'>{$admin_viewgifts29} </option><option value='2'>{$admin_viewgifts30}</option><option value='3'>{$admin_viewgifts31}</option></select></td></tr>
<tr><td>{$admin_viewgifts32}</td><td><textarea name='gifts_comment'></textarea></td></tr>
<tr><td colspan=2>
  {section name=giftss_loop loop=$gifts_s}
  {cycle name="startrow" values="<table cellpadding='0' cellspacing='0'><tr>,,,"}
	<td align='center'><img src='../images/gifts/{$gifts_s[giftss_loop].gifts_id}.png'><BR><input type='radio' name='gifts_id' value='{$gifts_s[giftss_loop].gifts_id}'></td>
  {* END ROW AFTER 3 RESULTS *}
  {if $smarty.section.giftss_loop.last == true}
    </tr></table>
  {else}
    {cycle name="endrow" values=",,,</tr></table>"}
  {/if}
  {/section}
</td></tr>
<tr><td colspan=2 align=center><input type='submit' value='{$admin_viewgifts25}'></td></tr>
</table>
<input type='hidden' name='task' value='add_user_gifts'>
</form>		
	</div>
    <div class="highslide-footer">
        <div>
            <span class="highslide-resize" title="Resize">
                <span></span>
            </span>
        </div>
    </div>
</div>


{include file='admin_footer.tpl'}