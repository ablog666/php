{include file='admin_header.tpl'}

<h2>{$admin_forum1}</h2>
{$admin_forum2}

<br><br>

{if $result != 0}
  <div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_forum3}</div>
{/if}

<form action='admin_forum.php' method='POST'>

<table cellpadding='0' cellspacing='0' width='600'>
<tr>
<td class='header'>{$admin_forum8}</td>
</tr>
<tr>
<td class='setting1'>
  {$admin_forum12}
</td>
</tr>
<tr>
<td class='setting2'>
  {if $forum_detected == 1}
    <div class="success" style="background:#FFFFFF;padding:10px 13px 10px 13px;border: 1px dashed #BBBBBB;margin:5px;">
    {$admin_forum9}
    </div>
  {else}
    <div class="error" style="background:#FFFFFF;padding:10px 13px 10px 13px;border: 1px dashed #BBBBBB;margin:5px;">
    {$admin_forum10}
    </div>
  {/if}
</td>
</tr>
</table>

<br>

<table cellpadding='0' cellspacing='0' width='600'>
<tr>
<td class='header'>{$admin_forum4}</td>
</tr>
<tr>
<td class='setting1'>
  {$admin_forum5}
</td>
</tr>
<tr>
<td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td>
      <select name='setting_forum_type' class='text'>
        <option value='0'>None</option>
        <option value='phpbb2'{if $setting_forum_type == "phpbb2"} SELECTED{/if}>phpBB2</option>
        <option value='vb'{if $setting_forum_type == "vb"} SELECTED{/if}>vBulletin</option>
      </select>
    </td>
    <td>&nbsp;{$admin_forum11}</td>
    </tr>
    <tr>
    <td><input type='text' name='setting_forum_path' value='{$setting_forum_path}' size='15'></td>
    <td>&nbsp;{$admin_forum6}</td>
    </tr>
    </table>
</td>
</tr>
</table>

<br>

<input type='submit' class='button' value='{$admin_forum7}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='admin_footer.tpl'}