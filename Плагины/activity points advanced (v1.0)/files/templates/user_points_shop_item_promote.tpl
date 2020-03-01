{include file='header.tpl'}

<br>
<br>

{if !empty($error_message)== 1}
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td class='error'>
    <img src='../images/error.gif' border='0' class='icon'> {$error_message}
  </td>
  </tr>
  </table>
  <br><br>
{/if}


{* SHOW ITEM *}

<div>
  <div style='padding: 5px; background: #EEEEEE; font-weight: bold'>
    {$upspender->upspender_info.userpointspender_title}
  </div>
  <div style='padding: 5px; vertical-align: top;'>
    <form action="user_points_shop_item.php" method="POST">

{if $upspender->upspender_info.userpointspender_type == 101 }

    <table cellspacing=0 cellspacing=0>
      <tr><td>{$user_points_shop_item_promote1}</td>
      <td>
        <select name=classified_id>
        {section name=item_loop loop=$classifieds}
        <option value='{$classifieds[item_loop].classified->classified_info.classified_id}'>{$classifieds[item_loop].classified->classified_info.classified_title}</option>
        {/section}
        </select>
      </td>
      </tr>
    </table>
  
{elseif $upspender->upspender_info.userpointspender_type == 102 }

    <table cellspacing=0 cellspacing=0>
      <tr><td>{$user_points_shop_item_promote2}</td>
      <td>
        <select name=event_id>
        {section name=event_loop loop=$events}
        <option value='{$events[event_loop].event->event_info.event_id}'>{$events[event_loop].event->event_info.event_title}</option>
        {/section}
        </select>
      </td>
      </tr>
    </table>

{elseif $upspender->upspender_info.userpointspender_type == 103 }

    <table cellspacing=0 cellspacing=0>
      <tr><td>{$user_points_shop_item_promote3}</td>
      <td>
        <select name=group_id>
        {section name=item_loop loop=$groups}
        <option value='{$groups[item_loop].group->group_info.group_id}'>{$groups[item_loop].group->group_info.group_title}</option>
        {/section}
        </select>
      </td>
      </tr>
    </table>

{elseif $upspender->upspender_info.userpointspender_type == 104 }

    <table cellspacing=0 cellspacing=0>
      <tr><td>{$user_points_shop_item_promote4}</td>
      <td>
        <select name=poll_id>
        {section name=item_loop loop=$polls}
        <option value='{$polls[item_loop].poll_id}'>{$polls[item_loop].poll_title}</option>
        {/section}
        </select>
      </td>
      </tr>
    </table>

{/if}

    <input type="submit" class=button value="{$user_points_shop_item_promote5}"> 
    <input type="hidden" name=shopitem_id value={$upspender->upspender_info.userpointspender_id}> 
    <input type="hidden" name=task value=dobuy> 
    <input type="hidden" name=gotvars value=1> 
    </form>

  </div>

</div>
  
<br><br>
  
  

{include file='footer.tpl'}