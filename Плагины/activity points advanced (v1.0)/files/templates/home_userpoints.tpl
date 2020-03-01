  {* ACTIVITY POINTS START 1/1 *}

  {* SHOW TOP USERS IF MORE THAN ZERO *}
  {if $userpoints_enable_topusers != 0}
    <table cellpadding='0' cellspacing='0' class='portal_table' align='center' width='100%'>
    <tr><td class='header'><a href='topusers.php'>{$home600}</a></td></tr>
    <tr>
    <td class='portal_box'>
    {if $up_topusers|@count > 0}
      {section name=up_topusers_loop loop=$up_topusers max=5}
        {* START NEW ROW *}
        {cycle name="startrowUPTU" values="<table cellpadding='0' cellspacing='0' align='center'><tr>,,,,"}
        <td class='portal_member'><a href='{$url->url_create('profile',$up_topusers[up_topusers_loop].user_username)}'>{$up_topusers[up_topusers_loop].user_username|truncate:15}<br><img src='{$up_topusers[up_topusers_loop].user_photo}' class='photo' width='{$misc->photo_size($up_topusers[up_topusers_loop].user_photo,'90','90','w')}' border='0'></a><br>{$up_topusers[up_topusers_loop].userpoints_totalearned} {$home601}</td>
        {* END ROW AFTER 5 RESULTS *}
        {if $smarty.section.up_topusers_loop.last == true}
          </tr></table>
        {else}
          {cycle name="endrowUPTU" values=",,,,</tr></table>"}
        {/if}
      {/section}
    {else}
      {$home602}
    {/if}
    </td>
    </tr>
    </table>
  {/if}

  {* ACTIVITY POINTS END 1/1 *}

