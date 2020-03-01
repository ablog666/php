{include file='header.tpl'}
{if $page == 1}
<script type="text/javascript" src="./images/highslide/highslide-with-html.js"></script>

<script type="text/javascript">
    hs.graphicsDir = './images/highslide/graphics/';
    hs.outlineType = 'rounded-white';
    hs.outlineWhileAnimating = true;
</script>
<b>{$user_points1} = {$point} {$user_points2}</b><BR>
{$user_points3}
<BR>
<a href="javascript:;" onclick="return hs.htmlExpand(this,{literal} { contentId: 'sms' }{/literal} )" class="highslide">{$user_points4}</a><BR>
<BR>
<a href="javascript:;" onclick="return hs.htmlExpand(this,{literal} { contentId: 'robox' }{/literal} )" class="highslide">{$user_points5}</a><BR>

<div class="highslide-html-content" id="sms">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">{$user_points6}</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body">
{$user_points7} {$sms_num} {$user_points8} <font color=red>{$prefix_sms} {$user->user_info.user_id}</font> {$user_points9}{$sms_mon} {$user_points10} {$sms_mon/$point} {$user_points11}

	</div>
    <div class="highslide-footer">
        <div>
            <span class="highslide-resize" title="Resize">
                <span></span>
            </span>
        </div>
    </div>
</div>

<div class="highslide-html-content" id="robox">
	<div class="highslide-header">
		<ul>
			<li class="highslide-close">
				<a href="#" onclick="return hs.close(this)">{$user_points6}</a>
			</li>
		</ul>
	</div>
	<div class="highslide-body">
<script type="text/javascript" language="JavaScript" src="./include/js/gifts.js"></script>
<form name=sum action='user_points.php' method=POST>
{$user_points18} <input type=text name='sum[sum]' value='1' onkeyup="javascript:js_buy(this.form.name, '{$point}', 1, 1);" onchange="javascript:js_buy(this.form.name, '{$point}', 1, 1);"><BR>
{$user_points19} <input type=text name='sum[buy]' value='3.33' onkeyup="javascript:js_buy(this.form.name, '{$point}', 1, 2);" onchange="javascript:js_buy(this.form.name, '{$point}', 1, 2);"><BR>
<input type=submit name='pay' value='{$user_points20}'>
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
{elseif $page == 2}
<center>{$user_points12}<BR><a href="user_points.php">{$user_points13}</a></center>
{elseif $page == 3}

{elseif $page == 4}
<center>{$user_points14}{$out_summ} {$user_points2}
      <form action='http://merchant.roboxchange.com/Index.aspx' method=POST>
      <input type=hidden name=MrchLogin value={$mrh_login}>
      <input type=hidden name=OutSum value={$out_summ}>
      <input type=hidden name=InvId value={$inv_id}>
      <input type=hidden name=Desc value='{$inv_desc}'>
      <input type=hidden name=Shp_item value='{$shp_item}'>
      <input type=hidden name=SignatureValue value={$crc}>
      <input type=hidden name=IncCurrLabel value={$in_curr}>
      <input type=hidden name=Culture value={$culture}>
      <input type=submit value='{$user_points15}'>
      </form>
</center>
{elseif $page == 5}
<center>{$user_points16}</center>
{elseif $page == 6}
<center>{$user_points17}</center>
{/if}
{include file='footer.tpl'}