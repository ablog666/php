{include file='header.tpl'}

{literal}
<style>

.topusers_rank  {
  color:#CCCCCC;
  font-size:32pt;
  font-weight:bold;
  Xpadding:7px 10px 7px 5px;
  text-align:center;
  vertical-align:middle;
  
  width: 100px;
  Xheight: 110px;
  
  Xborder-left: 1px solid #CCC;
  Xyborder-top: 1px solid #CCC;
}

</style>
{/literal}


<!-- TOP USERS -->

<table cellpadding='0' cellspacing='0' width='100%' style="margin-top: 20px">
<tr>
<td style='padding-right: 10px; vertical-align: top;'>

<div style="font-weight: bold; font-size: 20px; width: 200px; margin: 0px auto; padding-bottom: 40px"> {$topusers1} </div>


  <table cellpadding='0' cellspacing='0' width='100%'>

  {* LOOP USERS *}
  {section name=item_loop loop=$items}

    <tr>
    <td class='topusers_rank' style="vertical-align: middle">
      <div class='topusers_rank'>
      {math equation='p+1' p=$smarty.section.item_loop.index}
      </div>
      
    </td>
    <td style="padding:5px; text-align: center"><a href='{$url->url_create('profile',$items[item_loop].user_username)}'><img src='{$items[item_loop].user_photo}' class='photo' width='{$misc->photo_size($items[item_loop].user_photo,'90','90','w')}' border='0' alt="{$items[item_loop].user_username}"></a></td>
    <td style="padding:5px;" width="100%" valign='top'>
      <div style="padding-bottom: 5px">
        <font class='big'><a href='{$url->url_create('profile',$items[item_loop].user_username)}'>
      <!--<img src='./images/icons/user16.gif' border='0' class='icon'></a>--><a href='{$url->url_create('profile',$items[item_loop].user_username)}'>{$items[item_loop].user_username}</a></font>
      </div>
      <table cellpadding='0' cellspacing='0'>
        <tr><td>{$topusers2}</td><td style="padding-left: 5px">{$items[item_loop].userpoints_totalearned}</td></tr>
      </table>
      {if $smarty.section.item_loop.index == 0}
      <div style="padding-top: 5px">
      <img src="./images/MemberQuarter-large.gif">
      </div>
      {/if}
    </td>
    </tr>
	<tr>
	  <td>
	  {* SPACER *}
	  <div style="height: 50px"></div>

	  </td>

	</tr>

  {/section}
  
  </table>

</td>


<td style='width: 300px; padding: 5px; background: #F9F9F9; border: 1px solid #DDDDDD;' valign='top'>

<div style="text-align:center; font-weight: bold"> {$topusers3} </div>
<br>
{$topusers4}
<ol style="list-style: square; padding: 0px;margin-left: 20px">
<li> <a href="user_album_add.php"> {$topusers5} </a>
<li> {$topusers6}
<li> <a href="invite.php"> {$topusers7} </a>
<li> <a href="user_group_add.php">{$topusers8}</a> {$topusers9}
<li> {$topusers9}

</ol>

<a href="user_points_faq.php"> {$topusers11} </a>

</td>

</tr>
</table>

{include file='footer.tpl'}