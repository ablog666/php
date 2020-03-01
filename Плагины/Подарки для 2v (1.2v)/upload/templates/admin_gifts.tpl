{include file='admin_header.tpl'}
<link rel="stylesheet" href="../templates/styles_gifts.css" title="stylesheet" type="text/css">
<script type="text/javascript" src="../images/highslide/highslide-with-html.js"></script>

<script type="text/javascript">
    hs.graphicsDir = '../images/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    hs.outlineWhileAnimating = true;
</script>

<h2>{$admin_gifts1}</h2>
{$admin_gifts2}<BR>

<a href="javascript:;" onclick="return hs.htmlExpand(this,{literal} { contentId: 'add-gifts' }{/literal} )" class="highslide">{$admin_gifts20}</a>
<a href="javascript:;" onclick="return hs.htmlExpand(this,{literal} { contentId: 'add-gifts-cat' } {/literal})" class="highslide">{$admin_gifts21}</a>

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
    <div class='box' style='width: 300px;'><b>{$admin_gifts17}</b></div>
  </td>
  </tr>
  </table>
  <br>

{else}

  <div class='pages'>{$total_gifts} {$admin_gifts12} &nbsp;|&nbsp; {$admin_gifts13} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_gifts.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
<table width=100%><tr><td>
  <table cellpadding='0' cellspacing='0' class='list'>
  <tr>
  <td class='header' colspan='5' align='center'>{$admin_gifts3}</td>
  </tr>
  <tr>
  <td class='header' ><a class='header' href='admin_gifts.php?s={$i}&p={$p}'>{$admin_gifts6}</a></td>
  <td class='header' align='center'>{$admin_gifts5}</td>
  <td class='header' align='center'><a class='header' href='admin_gifts.php?s={$su}&p={$p}'>{$admin_gifts8}</a></td>
  <td class='header' >{$admin_gifts9}</td>
  </tr>
  {section name=gifts_loop loop=$gifts}
    <tr class='{cycle values="background1,background2"}'>
    <td class='item' >{$gifts[gifts_loop].gifts_id}</td>
    <td class='item' align='center'>{$gifts[gifts_loop].gifts_cat_name}</td>
    <td class='item' align='center'>{$gifts[gifts_loop].gifts_price}</td>
    <td class='item'>[ <a href='../images/gifts/{$gifts[gifts_loop].gifts_id}.png' class="highslide" onclick="return hs.expand(this)">{$admin_gifts10}</a> ] [ <a href='javascript:;'  onclick="return hs.htmlExpand(this,{literal}{{/literal}contentId: 'gifts_{$gifts[gifts_loop].gifts_id}' {literal}}{/literal} )" class="highslide">{$admin_gifts7}</a> ] [ <a href='admin_gifts.php?task=confirm&gifts_id={$gifts[gifts_loop].gifts_id}&s={$s}&p={$p}'>{$admin_gifts11}</a> ]
<div class="highslide-html-content" id="gifts_{$gifts[gifts_loop].gifts_id}">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">{$admin_gifts27}</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body">
<fotm method=post>
<form action='admin_gifts.php' method='post'>
<table>
<tr><td>{$admin_gifts22}</td><td><select name='gifts_id_cat'>
{section name=giftsc_loop loop=$giftsc}
{if $giftsc[giftsc_loop].giftsc_id == $gifts[gifts_loop].gifts_category}
<option value='{$giftsc[giftsc_loop].giftsc_id}' selected>{$giftsc[giftsc_loop].giftsc_name}</option>
{else}
<option value='{$giftsc[giftsc_loop].giftsc_id}'>{$giftsc[giftsc_loop].giftsc_name}</option>
{/if}
{/section}
</select></td></tr>
<tr><td>{$admin_gifts8}</td><td><input type='text' name='gifts_price' value='{$gifts[gifts_loop].gifts_price}'></td></tr>
<tr><td colspan=2 align=center><input type='hidden' name='gifts_id' value='{$gifts[gifts_loop].gifts_id}'><input type='submit' name='gifts_edit' value='{$admin_gifts7}'></td></tr>
</table>
<input type='hidden' name='task' value='edit_gifts'>
</form>		
	</div>
</div>

</td>
    </tr>
  {/section}
  <tr>
  <td align='center' valign='top' colspan=4>
    <div class='pages2'>{$total_gifts} {$admin_gifts12} &nbsp;|&nbsp; {$admin_gifts13} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_gifts.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  </td>
  </tr>
  </table>
{/if}
</td><td valign=top>
 <table cellpadding='0' cellspacing='0' class='list'>
  <tr>
  <td class='header' colspan='5' align='center'>{$admin_gifts4}</td>
  </tr>
  <tr>
  <td class='header' >{$admin_gifts6}</td>
  <td class='header' align='center'>{$admin_gifts26}</td>
  <td class='header' >{$admin_gifts9}</td>
  </tr>
  {section name=giftsc_loop loop=$giftsc}
    <tr class='{cycle values="background1,background2"}'>
    <td class='item' >{$giftsc[giftsc_loop].giftsc_id}</td>
    <td class='item' align='center'>{$giftsc[giftsc_loop].giftsc_name}</td>
    <td class='item'>[ <a href='javascript:;' onclick="return hs.htmlExpand(this,{literal}{{/literal}contentId: 'gifts_cat_{$giftsc[giftsc_loop].giftsc_id}' {literal}}{/literal} )" class="highslide">{$admin_gifts7}</a> ] [ <a href='admin_gifts.php?task=confirm&gifts_cat_id={$giftsc[giftsc_loop].giftsc_id}&s={$s}&p={$p}'>{$admin_gifts11}</a> ]
<div class="highslide-html-content" id="gifts_cat_{$giftsc[giftsc_loop].giftsc_id}">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">{$admin_gifts27}</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body">
<fotm method=post>
<form action='admin_gifts.php' method='post'>
<table>
<tr><td>{$admin_gifts26}</td><td><input type='text' name='gifts_cat_name' value='{$giftsc[giftsc_loop].giftsc_name}'></td></tr>
<tr><td colspan=2 align=center><input type='hidden' name='gifts_cat_id' value='{$giftsc[giftsc_loop].giftsc_id}'><input type='submit' name='gifts_cat_edit' value='{$admin_gifts7}'></td></tr>
</table>
<input type='hidden' name='task' value='edit_gifts_cat'>
</form>		
	</div>
</div>
</td>
    </tr>
  {/section}
  </table>
</td></tr></table>

<div class="highslide-html-content" id="add-gifts">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">{$admin_gifts27}</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body">
<fotm method=post>
<form action='admin_gifts.php' method='post' enctype='multipart/form-data'>
<table>
<tr><td>{$admin_gifts22}</td><td><select name='gifts_id_cat'>
{section name=giftsc_loop loop=$giftsc}
<option value='{$giftsc[giftsc_loop].giftsc_id}'>{$giftsc[giftsc_loop].giftsc_name}</option>
{/section}
</select></td></tr>
<tr><td>{$admin_gifts23}</td><td><input type='file' name='gifts_file'></td></tr>
<tr><td>{$admin_gifts24}</td><td><input type='text' name='gifts_price'> points</td></tr>
<tr><td colspan=2 align=center><input type='submit' name='add_gift' value='{$admin_gifts25}'></td></tr>
</table>
<input type='hidden' name='task' value='add_gifts'>
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

<div class="highslide-html-content" id="add-gifts-cat">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">{$admin_gifts27}</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body">
<fotm method=post>
<form action='admin_gifts.php' method='post'>
<table>
<tr><td>{$admin_gifts26}</td><td><input type='text' name='gifts_cat_name'></td></tr>
<tr><td colspan=2 align=center><input type='submit' name='add_gift_cat' value='{$admin_gifts25}'></td></tr>
</table>
<input type='hidden' name='task' value='add_gifts_cat'>
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