{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_classified.php'>{$user_classified_new1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_settings.php'>{$user_classified_new2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_browse.php'>{$user_classified_new8}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/classified48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_classified_new3}</div>
<div>{$user_classified_new4}</div>

<br><br>

{* SHOW ERROR *}
{if $is_error == 1}
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td class='error'><img src='./images/error.gif' border='0' class='icon'>{$result}</td>
  </tr>
  </table>
  <br>
{/if}

<form action='user_classified_new.php' method='post' name='info' id="classifiedform">
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='form1' style='width: 90px;'>{$user_classified_new5}</td>
<td class='form2'><input type='text' name='classified_title' class='text' size='50' maxlength='100' value='{$classified_title}'></td>
</tr>

{* SHOW CLASSIFIED CATEGORIES IF ANY EXIST *}
{if $classifiedcats|@count > 0}
  <tr>
  <td class='form1'>{$user_classified_new6}</td>
  <td class='form2'>
    <select name='classified_classifiedcat_id' id='classified_classifiedcat_id' onChange="showSubcats()">
    <option value='0'></option>
    {section name=classifiedcat_loop loop=$classifiedcats}
      <option value='{$classifiedcats[classifiedcat_loop].classifiedcat_id}'{if $classified_classifiedcat_id == $classifiedcats[classifiedcat_loop].classifiedcat_id} selected='selected'{/if}>{$classifiedcats[classifiedcat_loop].classifiedcat_title}</option>
    {/section}
    </select>

   {* JAVASCRIPT FOR SETTING SUBCAT ID IN FORM *}
   {literal}
   <script type='text/javascript'>
   <!--
   function showSubcats() {
     {/literal}
     {section name=classifiedcat_loop3 loop=$classifiedcats}
       hidediv('subcatdiv_{$classifiedcats[classifiedcat_loop3].classifiedcat_id}');
       hidediv('fielddiv_{$classifiedcats[classifiedcat_loop3].classifiedcat_id}');
     {/section}
     {literal}
     var catId = document.getElementById('classified_classifiedcat_id').value;
     showdiv('subcatdiv_'+catId);
     showdiv('fielddiv_'+catId);
   }
   function setCatId(id1) {
     var newValue = document.getElementById(id1).value;
     document.getElementById('classified_classifiedsubcat_id').value = newValue;
   }
   //-->
   </script>
   {/literal}

   {* SHOW SUBCATEGORIES *}
   {section name=classifiedcat_loop2 loop=$classifiedcats}
     <div id='subcatdiv_{$classifiedcats[classifiedcat_loop2].classifiedcat_id}' style='{if $classified_classifiedcat_id != $classifiedcats[classifiedcat_loop2].classifiedcat_id}display: none;{/if}'>
       {if $classifiedcats[classifiedcat_loop2].classifiedcat_subcats|@count > 0}
         <select id='subcats_{$classifiedcats[classifiedcat_loop2].classifiedcat_id}' onChange="setCatId('subcats_{$classifiedcats[classifiedcat_loop2].classifiedcat_id}');">
           <option value='0'></option>
           {section name=classifiedsubcat_loop loop=$classifiedcats[classifiedcat_loop2].classifiedcat_subcats}
             <option value='{$classifiedcats[classifiedcat_loop2].classifiedcat_subcats[classifiedsubcat_loop].classifiedsubcat_id}'{if $classified_classifiedsubcat_id == $classifiedcats[classifiedcat_loop2].classifiedcat_subcats[classifiedsubcat_loop].classifiedsubcat_id} selected='selected'{/if}>{$classifiedcats[classifiedcat_loop2].classifiedcat_subcats[classifiedsubcat_loop].classifiedsubcat_title}</option>
           {/section}
         </select>
       {/if}
     </div>
   {/section}
   <input type='hidden' name='classified_classifiedsubcat_id' id='classified_classifiedsubcat_id' value='{$classified_classifiedsubcat_id}'>

  </td>
  </tr>
  </table>

  {* LOOP THROUGH FIELDS IN CATEGORIES *}
  {section name=cat_loop loop=$cats}
    <div id='fielddiv_{$cats[cat_loop].cat_id}' style='{if $classified_classifiedcat_id != $cats[cat_loop].cat_id}display: none;{/if}'>
    <table cellpadding='0' cellspacing='0'>
    {section name=field_loop loop=$cats[cat_loop].fields}
      <tr>
      <td class='form1' style='width: 90px;'>{$cats[cat_loop].fields[field_loop].field_title}:{if $cats[cat_loop].fields[field_loop].field_required != 0}*{/if}</td>
      <td class='form2'>

      {* TEXT FIELD *}
      {if $cats[cat_loop].fields[field_loop].field_type == 1}
        <div><input type='text' class='text' name='field_{$cats[cat_loop].fields[field_loop].field_id}' value='{$cats[cat_loop].fields[field_loop].field_value}' style='{$cats[cat_loop].fields[field_loop].field_style}' maxlength='{$cats[cat_loop].fields[field_loop].field_maxlength}'></div>
        <div class='form_desc'>{$cats[cat_loop].fields[field_loop].field_desc}</div>

      {* TEXTAREA *}
      {elseif $cats[cat_loop].fields[field_loop].field_type == 2}
        <div><textarea rows='6' cols='50' name='field_{$cats[cat_loop].fields[field_loop].field_id}' style='{$cats[cat_loop].fields[field_loop].field_style}'>{$cats[cat_loop].fields[field_loop].field_value}</textarea></div>
        <div class='form_desc'>{$cats[cat_loop].fields[field_loop].field_desc}</div>

      {* SELECT BOX *}
      {elseif $cats[cat_loop].fields[field_loop].field_type == 3}
        <div><select name='field_{$cats[cat_loop].fields[field_loop].field_id}' id='field_{$cats[cat_loop].fields[field_loop].field_id}' onchange="ShowHideSelectDeps({$cats[cat_loop].fields[field_loop].field_id})" style='{$cats[cat_loop].fields[field_loop].field_style}'>
        <option value='-1'></option>
        {* LOOP THROUGH FIELD OPTIONS *}
        {section name=option_loop loop=$cats[cat_loop].fields[field_loop].field_options}
          <option id='op' value='{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}'{if $cats[cat_loop].fields[field_loop].field_options[option_loop].option_id == $cats[cat_loop].fields[field_loop].field_value} SELECTED{/if}>{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_label}</option>
        {/section}
        </select>
        </div>

        {* LOOP THROUGH DEPENDENT FIELDS *}
        {section name=option_loop loop=$cats[cat_loop].fields[field_loop].field_options}
          {if $cats[cat_loop].fields[field_loop].field_options[option_loop].option_dependency == 1}
            <div id='field_{$cats[cat_loop].fields[field_loop].field_id}_option{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}' style='margin: 5px 5px 10px 5px;{if $cats[cat_loop].fields[field_loop].field_options[option_loop].option_id != $cats[cat_loop].fields[field_loop].field_value} display: none;{/if}'>
            {$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_title}{if $cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
            <input type='text' class='text' name='field_{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_id}' value='{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_value}' style='{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_maxlength}'>
            </div>
	  {else}
            <div id='field_{$cats[cat_loop].fields[field_loop].field_id}_option{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
          {/if}
        {/section}
        <div class='form_desc'>{$cats[cat_loop].fields[field_loop].field_desc}</div>


      {* RADIO BUTTONS *}
      {elseif $cats[cat_loop].fields[field_loop].field_type == 4}
      
        {* LOOP THROUGH FIELD OPTIONS *}
        {section name=option_loop loop=$cats[cat_loop].fields[field_loop].field_options}
  
          <div>
          <input type='radio' class='radio' onclick="ShowHideRadioDeps({$cats[cat_loop].fields[field_loop].field_id}, {$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}, 'field_{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_id}', {$cats[cat_loop].fields[field_loop].field_options|@count})" style='{$cats[cat_loop].fields[field_loop].field_style}' name='field_{$cats[cat_loop].fields[field_loop].field_id}' id='label_{$cats[cat_loop].fields[field_loop].field_id}_{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}' value='{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}'{if $cats[cat_loop].fields[field_loop].field_options[option_loop].option_id == $cats[cat_loop].fields[field_loop].field_value} CHECKED{/if}>
          <label for='label_{$cats[cat_loop].fields[field_loop].field_id}_{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}'>{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_label}</label>
  
          {* DISPLAY DEPENDENT FIELDS *}
          {if $cats[cat_loop].fields[field_loop].field_options[option_loop].option_dependency == 1}
            <div id='field_{$cats[cat_loop].fields[field_loop].field_id}_radio{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}' style='margin: 0px 5px 10px 23px;{if $cats[cat_loop].fields[field_loop].field_options[option_loop].option_id != $cats[cat_loop].fields[field_loop].field_value} display: none;{/if}'>
            {$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_title}
            {if $cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_required != 0}*{/if}
            <input type='text' class='text' name='field_{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_id}' id='field_{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_id}' value='{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_value}' style='{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_style}' maxlength='{$cats[cat_loop].fields[field_loop].field_options[option_loop].dep_field_maxlength}'>
            </div>
  	  {else}
            <div id='field_{$cats[cat_loop].fields[field_loop].field_id}_radio{$cats[cat_loop].fields[field_loop].field_options[option_loop].option_id}' style='display: none;'></div>
          {/if}

          </div>
        {/section}
        <div class='form_desc'>{$cats[cat_loop].fields[field_loop].field_desc}</div>

      {* DATE FIELD *}
      {elseif $cats[cat_loop].fields[field_loop].field_type == 5}
        <div>
        <select name='field_{$cats[cat_loop].fields[field_loop].field_id}_1' style='{$cats[cat_loop].fields[field_loop].field_style}'>
        {section name=date1 loop=$cats[cat_loop].fields[field_loop].date_array1}
          <option value='{$cats[cat_loop].fields[field_loop].date_array1[date1].value}'{$cats[cat_loop].fields[field_loop].date_array1[date1].selected}>{$cats[cat_loop].fields[field_loop].date_array1[date1].name}</option>
        {/section}
        </select>
  
        <select name='field_{$cats[cat_loop].fields[field_loop].field_id}_2' style='{$cats[cat_loop].fields[field_loop].field_style}'>
        {section name=date2 loop=$cats[cat_loop].fields[field_loop].date_array2}
          <option value='{$cats[cat_loop].fields[field_loop].date_array2[date2].value}'{$cats[cat_loop].fields[field_loop].date_array2[date2].selected}>{$cats[cat_loop].fields[field_loop].date_array2[date2].name}</option>
        {/section}
        </select>
  
        <select name='field_{$cats[cat_loop].fields[field_loop].field_id}_3' style='{$cats[cat_loop].fields[field_loop].field_style}'>
        {section name=date3 loop=$cats[cat_loop].fields[field_loop].date_array3}
          <option value='{$cats[cat_loop].fields[field_loop].date_array3[date3].value}'{$cats[cat_loop].fields[field_loop].date_array3[date3].selected}>{$cats[cat_loop].fields[field_loop].date_array3[date3].name}</option>
        {/section}
        </select>
        </div>
        <div class='form_desc'>{$cats[cat_loop].fields[field_loop].field_desc}</div>
      {/if}

      {* SHOW FIELD ERROR MESSAGE *}
      {if $cats[cat_loop].fields[field_loop].field_error != ""}<div class='form_error'><img src='./images/icons/error16.gif' border='0' class='icon'> {$cats[cat_loop].fields[field_loop].field_error}</div>{/if}
      </td>
      </tr>
    {/section}
    </table>
    </div>
  {/section}

{/if}

<table cellspacing='0' cellpadding='0'>
<tr>
<td class='form1' style='width: 90px;'>{$user_classified_new17}</td>
<td class='form2'>
  <textarea name='classified_body' rows='12' cols='80'>{$classified_body}</textarea>

  {* SHOW SETTINGS LINK IF NECESSARY *}
  {if $privacy_options|@count > 1 OR $comment_options|@count > 1}
    <div id='settings_show' class='classified_settings_link'>
      <a href="javascript:showdiv('entry_settings');hidediv('settings_show');">{$user_classified_new7}</a>
    </div>
  {/if}

  <div id='entry_settings' class='classified_settings' style='display: none;'>
    {* SHOW SEARCH PRIVACY OPTIONS IF ALLOWED BY ADMIN *}
    {if $user->level_info.level_classified_search == 1}
      <b>{$user_classified_new9}</b>
      <table cellpadding='0' cellspacing='0'>
        <tr><td><input type='radio' name='classified_search' id='classified_search_1' value='1' {if $classified_search == 1} checked='checked'{/if}></td><td><label for='classified_search_1'>{$user_classified_new10}</label></td></tr>
        <tr><td><input type='radio' name='classified_search' id='classified_search_0' value='0' {if $classified_search == 0} checked='checked'{/if}></td><td><label for='classified_search_0'>{$user_classified_new11}</label></td></tr>
      </table>
    {/if}

    {* ADD SPACE IF BOTH OPTIONS ARE AVAILABLE *}
    {if $user->level_info.level_classified_search == 1 AND ($privacy_options|@count > 1 OR $comment_options|@count > 1)}<br>{/if}

    {* SHOW PRIVACY OPTIONS *}
    {if $privacy_options|@count > 1}
      <b>{$user_classified_new12}</b>
      <table cellpadding='0' cellspacing='0'>
        {section name=privacy_loop loop=$privacy_options}
          <tr><td><input type='radio' name='classified_privacy' id='{$privacy_options[privacy_loop].privacy_id}' value='{$privacy_options[privacy_loop].privacy_value}'{if $classified_privacy == $privacy_options[privacy_loop].privacy_value} checked='checked'{/if}></td><td><label for='{$privacy_options[privacy_loop].privacy_id}'>{$privacy_options[privacy_loop].privacy_option}</label></td></tr>
        {/section}
      </table>
    {/if}

    {* ADD SPACE IF BOTH OPTIONS ARE AVAILABLE *}
    {if $privacy_options|@count > 1 AND $comment_options|@count > 1}<br>{/if}

    {* SHOW COMMENT OPTIONS *}
    {if $comment_options|@count > 1}
      <b>{$user_classified_new13}</b>
      <table cellpadding='0' cellspacing='0'>
        {section name=comment_loop loop=$comment_options}
          <tr><td><input type='radio' name='classified_comments' id='{$comment_options[comment_loop].comment_id}' value='{$comment_options[comment_loop].comment_value}'{if $classified_comments == $comment_options[comment_loop].comment_value} checked='checked'{/if}></td><td><label for='{$comment_options[comment_loop].comment_id}'>{$comment_options[comment_loop].comment_option}</label></td></tr>
        {/section}
      </table>
    {/if}
  </div>

  <br>

  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td>
    <input type='submit' class='button' value='{$user_classified_new14}'>&nbsp;
    <input type='hidden' name='task' value='dosave'>
    </form>
  </td>
  <td>
    <form action='user_classified.php' method='post'>
    <input type='submit' class='button' value='{$user_classified_new16}'>
    </form>
  </td>
  </tr>
  </table>

</td>
</tr>
</table>

{include file='footer.tpl'}