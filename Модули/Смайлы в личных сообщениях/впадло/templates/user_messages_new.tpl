{include file='header.tpl'}

{literal}
<script type='text/javascript'>

function addsmiley(code)  {
  var pretext = document.forms['message_form'].message.value;
  this.code = code;
  document.forms['message_form'].message.value = pretext + code;
  }

</script>
{/literal}


<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_messages.php'>{$user_messages_new5}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_messages_outbox.php'>{$user_messages_new6}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_messages_settings.php'>{$user_messages_new4}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/sendmessage48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_messages_new7}</div>
<div>{$user_messages_new8}</div>

<br><br>

{* SHOW ERROR MESSAGE *}
{if $is_error != 0}
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='result'>
    <div class='error'><img src='./images/error.gif' border='0' class='icon'> {$error_message}</div>
  </td></tr></table>
{/if}

<table cellpadding='0' cellspacing='0'>
<form id='message_form' action='user_messages_new.php' method='POST'>
<tr>
<td class='form1'>{$user_messages_new9}</td>
<td class='form2' valign='bottom'><b><a href='{$url->url_create('profile',$user->user_info.user_username)}'>{$user->user_info.user_username}</a></b></td>
</tr>
<tr>
<td class='form1'>{$user_messages_new10}</td>
<td class='form2'>
  <input type='text' class='text' name='to' id='to' value='{$to}' tabindex='1' size='30' maxlength='50' onkeyup="suggest('to', 'suggest', '{section name=friends_loop loop=$friends}{$friends[friends_loop]->user_info.user_username}{if $smarty.section.friends_loop.last != true},{/if}{/section}');" autocomplete='off'>
  <br>
  <div id="suggest" class='suggest'></div>
</td>
</tr>
<tr>
<td class='form1'>{$user_messages_new11}</td>
<td class='form2'><input type='text' class='text' name='subject' tabindex='2' value='{$subject}' size='30' maxlength='250' onfocus="hidediv('suggest');"></td>
</tr>
<tr>
<td class='form1'>ׁלאיכû:</td>
<td class='form2'>{$smiles}</td>
</tr>
<tr>
<td class='form1'>{$user_messages_new12}</td>
<td class='form2'><textarea rows='10' cols='70' tabindex='3' name='message'>{$message}</textarea></td>
</tr>
<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><input type='submit' class='button' value='{$user_messages_new13}'>&nbsp;</td>
  <input type='hidden' name='task' value='send'>
  <input type='hidden' name='convo_id' value='{$convo_id}'>
  </form>
  <td><input type='button' class='button' value='{$user_messages_new14}' onClick='history.go(-1)'></td>
  </tr>
  </form>
  </table>
</td>
</tr>
</table>

{include file='footer.tpl'}
