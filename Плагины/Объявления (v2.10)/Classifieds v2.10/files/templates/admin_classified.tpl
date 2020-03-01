{include file='admin_header.tpl'}

<h2>{$admin_classified1}</h2>
{$admin_classified2}

<br><br>

{if $result != 0}
  <div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_classified3}</div>
{/if}

  {* JAVASCRIPT FOR ADDING CATEGORIES AND FIELDS *}
  {math assign='cat_count' equation="x-1" x=$cats|@count}
  {literal}
  <script type="text/javascript">
  <!-- 
  var categories = {{/literal}{section name=cat_loop_js loop=$cats}'{$cats[cat_loop_js].cat_id}':'{$cats[cat_loop_js].cat_title}'{if $smarty.section.cat_loop_js.last != TRUE},{/if}{/section}{literal}};

  function noenter(catid, e) { 
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    if(keycode == 13) {
      var catinput = document.getElementById('cat_'+catid+'_input'); 
      catinput.blur();
      return false;
    }
  }
  function addcat() {
    var catarea = document.getElementById('categories');
    var newdiv = document.createElement('div');
    newdiv.id = 'cat_new';
    newdiv.innerHTML = '<table cellpadding="0" cellspacing="0" style="margin-top: 15px;"><tr><td><img src="../images/folder_open_yellow.gif" border="0"></td><td style="padding-top: 4px; padding-left: 3px; font-weight: bold;">&nbsp;<span id="cat_new_span"><input type="text" id="cat_new_input" maxlength="100" onBlur="savecat(\'new\', \'\', \'\')" onkeypress="return noenter(\'new\', event)"></span></td></tr></table>';
    catarea.appendChild(newdiv);
    var catinput = document.getElementById('cat_new_input');
    catinput.focus();
  }
  function addsubcat(catid) {
    var catarea = document.getElementById('subcats_'+catid);
    var newdiv = document.createElement('div');
    newdiv.id = 'cat_new';
    if(catarea.nextSibling) { 
      var thisdiv = catarea.nextSibling;
      while(thisdiv.nodeName != "DIV") { if(thisdiv.nextSibling) { thisdiv = thisdiv.nextSibling; } else { break; } }
      if(thisdiv.nodeName != "DIV") { next_catid = "new"; } else { next_catid = thisdiv.id.substr(4); }
    } else {
      next_catid = 'new';
    }
    divHTML = '<table cellpadding="0" cellspacing="0"><tr><td><img src="../images/space_left_last.gif" border="0"></td><td><img src="../images/space_left_last.gif" border="0"></td><td><img src="../images/folder_closed_green.gif" border="0"></td><td style="padding-top: 4px; padding-left: 3px;">&nbsp;<span id="cat_new_span"><input type="text" id="cat_new_input" maxlength="100" onBlur="savecat(\'new\', \'\', \''+catid+'\')" onkeypress="return noenter(\'new\', event)"></span></td></tr></table>';
    newdiv.innerHTML = divHTML
    catarea.appendChild(newdiv);
    var catinput = document.getElementById('cat_new_input');
    catinput.focus();
  }
  function savecat(catid, oldcat_title, cat_dependency) {
    var catinput = document.getElementById('cat_'+catid+'_input'); 
    if(catinput.value == "" && catid == "new") {
      removecat(catid);
    } else if(catinput.value == "" && catid != "new") {
      if(confirm('{/literal}{$admin_classified15}{literal}')) {
        document.getElementById('catframe').src = 'admin_classified.php?task=savecat&cat_id='+catid+'&cat_dependency='+cat_dependency+'&cat_title='+escape(catinput.value);
      } else {
        savecat_result(catid, catid, oldcat_title);
      }
    } else {
        document.getElementById('catframe').src = 'admin_classified.php?task=savecat&cat_id='+catid+'&cat_dependency='+cat_dependency+'&cat_title='+escape(catinput.value);
    }
  }
  function savecat_result(old_catid, new_catid, cat_title, cat_dependency) {
    if(cat_dependency == 0) { categories[new_catid] = cat_title; }
    var catinput = document.getElementById('cat_'+old_catid+'_input'); 
    var catspan = document.getElementById('cat_'+old_catid+'_span'); 
    var catdiv = document.getElementById('cat_'+old_catid); 
    catdiv.id = 'cat_'+new_catid;
    catspan.id = 'cat_'+new_catid+'_span';
    catspan.innerHTML = '<a href="javascript:editcat(\''+new_catid+'\', \''+cat_dependency+'\');" id="cat_'+new_catid+'_title">'+cat_title+'</a>';
    if(old_catid == 'new' && cat_dependency == 0) {
      var subcatdiv = document.createElement('div');
      subcatdiv.id = 'subcats_'+new_catid;
      subcatdiv.innerHTML = "<table cellpadding='0' cellspacing='0'><tr><td><img src='../images/space_left_last.gif' border='0'></td><td style='padding-top: 4px; padding-left: 3px;'>{/literal}{$admin_classified62}{literal} - <a href='javascript:addsubcat(\""+new_catid+"\");'>[{/literal}{$admin_classified19}{literal}]</a></td></tr></table>";
      catdiv.appendChild(subcatdiv);
      var fielddiv = document.createElement('div');
      fielddiv.id = 'fields_'+new_catid;
      fielddiv.innerHTML = "<table cellpadding='0' cellspacing='0'><tr><td><img src='../images/space_left_last.gif' border='0'></td><td style='padding-top: 4px; padding-left: 3px;'>{/literal}{$admin_classified63}{literal} - <a href='javascript:addfield(\""+new_catid+"\");'>[{/literal}{$admin_classified16}{literal}]</a></td></tr></table>";
      catdiv.appendChild(fielddiv);
    }
  }
  function removecat(catid) {
    var catdiv = document.getElementById('cat_'+catid); 
    var catarea = catdiv.parentNode;
    catarea.removeChild(catdiv);
  }
  function editcat(catid, cat_dependency) {
    var catspan = document.getElementById('cat_'+catid+'_span'); 
    var cattitle = document.getElementById('cat_'+catid+'_title'); 
    catspan.innerHTML = '<input type="text" id="cat_'+catid+'_input" maxlength="100" onBlur="savecat(\''+catid+'\', \''+cattitle.innerHTML.replace(/'/g, "&amp;#039;")+'\', \''+cat_dependency+'\')" onkeypress="return noenter(\''+catid+'\', event)" value="'+cattitle.innerHTML+'">';
    var catinput = document.getElementById('cat_'+catid+'_input'); 
    catinput.focus();
  }
  function addfield(catid) {
    var catSelect = document.getElementById('field_cat_id');
    catSelect.innerHTML = '';
    for(var x in categories) {
      var newOption = document.createElement('option');
      newOption.value = x;
      newOption.text = categories[x];
      if(x == catid) { newOption.selected = true; }
      catSelect.appendChild(newOption);
    }
    catSelect.disabled = false;
    document.getElementById('fielderror').innerHTML = '';
    document.getElementById('field_title').value = '';
    document.getElementById('field_type')[0].selected = true;
    document.getElementById('field_type').disabled = false;
    document.getElementById('field_style').value = '';
    document.getElementById('field_desc').value = '';
    document.getElementById('field_error').value = '';
    document.getElementById('field_html').value = '';
    document.getElementById('field_search').value = '';
    document.getElementById('field_desc_div').style.display = 'block';
    document.getElementById('field_error_div').style.display = 'block';
    document.getElementById('field_html_div').style.display = 'block';
    document.getElementById('field_search_div').style.display = 'block';
    document.getElementById('field_required')[0].selected = true;
    document.getElementById('field_maxlength')[0].selected = true;
    document.getElementById('field_link').value = '';
    document.getElementById('field_regex').value = '';
    document.getElementById('newfields3').innerHTML = '';
    document.getElementById('newfields4').innerHTML = '';
    addOptions('newfields3', '', '0', '', '');
    addOptions('newfields4', '', '0', '', '');
    document.getElementById('field_id').value = '';
    document.getElementById('task').value = 'savefield';
    showmaxlength();

    document.getElementById('submitButtons').innerHTML = '<input type="submit" class="button" value="{/literal}{$admin_classified46}{literal}"><input type="button" class="button" value="{/literal}{$admin_classified48}{literal}" onClick="cancelfield()">';

    var fieldDiv = document.getElementById('addedit_field');
    fieldDiv.style.display = 'block';
    if (navigator.appName == "Microsoft Internet Explorer") { var scrollTop = document.body.scrollTop; } else { var scrollTop = window.pageYOffset; }
    fieldDiv.style.marginLeft = "-" + parseInt(fieldDiv.offsetWidth / 2) + "px";
    fieldDiv.style.top = parseInt(scrollTop+100) + "px";
  }
  function getfield(fieldid) {
    document.getElementById('catframe').src = 'admin_classified.php?task=getfield&field_id='+fieldid;
  }
  function getdepfield(fieldid) {
    document.getElementById('catframe').src = 'admin_classified.php?task=getdepfield&field_id='+fieldid;
  }
  function editfield(fieldid, catid, title, desc, error, type, style, maxlength, link, options, required, regex, html, search) {

    var catSelect = document.getElementById('field_cat_id');
    catSelect.innerHTML = '';
    for(var x in categories) {
      var newOption = document.createElement('option');
      newOption.value = x;
      newOption.text = categories[x];
      if(x == catid) { newOption.selected = true; }
      catSelect.appendChild(newOption);
    }
    catSelect.disabled = false;
    document.getElementById('fielderror').innerHTML = '';
    document.getElementById('field_title').value = title;
    document.getElementById('field_type').value = type;
    document.getElementById('field_type').disabled = false;
    document.getElementById('field_style').value = style;
    document.getElementById('field_desc').value = desc;
    document.getElementById('field_error').value = error;
    document.getElementById('field_html').value = html;
    document.getElementById('field_search').value = search;
    document.getElementById('field_desc_div').style.display = 'block';
    document.getElementById('field_error_div').style.display = 'block';
    document.getElementById('field_html_div').style.display = 'block';
    document.getElementById('field_search_div').style.display = 'block';
    document.getElementById('field_required').value = required;
    document.getElementById('field_maxlength').value = maxlength;
    document.getElementById('field_link').value = link;
    document.getElementById('field_regex').value = regex;
    document.getElementById('newfields3').innerHTML = '';
    document.getElementById('newfields4').innerHTML = '';
    addOptions('newfields3', '', '0', '', '');
    addOptions('newfields4', '', '0', '', '');
    var options = options.split("<~!~>");
    if(options.length > 0 && options[0] != '') {
      document.getElementById('newfields'+type).innerHTML = '';
      for(var a=0;a<options.length;a++) {
        if(options[a].length > 0) {
          option = options[a].split("<!>");
          addOptions('newfields'+type, option[1], option[2], option[3], option[4]);
        }
      }
    }
    document.getElementById('field_id').value = fieldid;
    document.getElementById('task').value = 'savefield';
    showmaxlength();

    document.getElementById('submitButtons').innerHTML = '<input type="submit" class="button" value="{/literal}{$admin_classified47}{literal}"><input type="button" class="button" value="{/literal}{$admin_classified60}{literal}" onClick="removefield('+fieldid+')"><input type="button" class="button" value="{/literal}{$admin_classified48}{literal}" onClick="cancelfield()">';

    var fieldDiv = document.getElementById('addedit_field');
    fieldDiv.style.display = 'block';
    if (navigator.appName == "Microsoft Internet Explorer") { var scrollTop = document.body.scrollTop; } else { var scrollTop = window.pageYOffset; }
    fieldDiv.style.marginLeft = "-" + parseInt(fieldDiv.offsetWidth / 2) + "px";
    fieldDiv.style.top = parseInt(scrollTop+100) + "px";
  }
  function editdepfield(fieldid, catid, title, style, maxlength, link, required, regex) {

    var catSelect = document.getElementById('field_cat_id');
    catSelect.innerHTML = '';
    for(var x in categories) {
      if(x == catid) {
        var newOption = document.createElement('option');
        newOption.value = x;
        newOption.text = categories[x];
        newOption.selected = true;
        catSelect.appendChild(newOption);
      }
    }
    catSelect.disabled = true;
    document.getElementById('fielderror').innerHTML = '';
    document.getElementById('field_title').value = title;
    document.getElementById('field_type').value = 1;
    document.getElementById('field_type').disabled = true;
    document.getElementById('field_style').value = style;
    document.getElementById('field_desc_div').style.display = 'none';
    document.getElementById('field_error_div').style.display = 'none';
    document.getElementById('field_html_div').style.display = 'none';
    document.getElementById('field_search_div').style.display = 'none';
    document.getElementById('field_required').value = required;
    document.getElementById('field_maxlength').value = maxlength;
    document.getElementById('field_link').value = link;
    document.getElementById('field_regex').value = regex;
    document.getElementById('newfields3').innerHTML = '';
    document.getElementById('newfields4').innerHTML = '';
    document.getElementById('field_id').value = fieldid;
    document.getElementById('task').value = 'savedepfield';
    showmaxlength();

    document.getElementById('submitButtons').innerHTML = '<input type="submit" class="button" value="{/literal}{$admin_classified47}{literal}"><input type="button" class="button" value="{/literal}{$admin_classified48}{literal}" onClick="cancelfield()">';

    var fieldDiv = document.getElementById('addedit_field');
    fieldDiv.style.display = 'block';
    if (navigator.appName == "Microsoft Internet Explorer") { var scrollTop = document.body.scrollTop; } else { var scrollTop = window.pageYOffset; }
    fieldDiv.style.marginLeft = "-" + parseInt(fieldDiv.offsetWidth / 2) + "px";
    fieldDiv.style.top = parseInt(scrollTop+100) + "px";
  }
  function removefield(fieldid) {
    if(confirm('{/literal}{$admin_classified61}{literal}')) {
      document.getElementById('catframe').src = 'admin_classified.php?task=removefield&field_id='+fieldid;
    }
  }
  function removefield_result(fieldid) {
    cancelfield();
    var fielddiv = document.getElementById('field_'+fieldid); 
    var fieldarea = fielddiv.parentNode;
    fieldarea.removeChild(fielddiv);
  }
  function cancelfield() {
    var fieldDiv = document.getElementById('addedit_field');
    fieldDiv.style.display = 'none';
  }
  function savefield_result(is_error, error_message, oldfield_id, newfield_id, field_title, field_cat_id, field_options) {
    if(is_error == 1) {
      document.getElementById('fielderror').innerHTML = error_message;
    } else {
      if(oldfield_id == 0) {
        var catfields = document.getElementById('fields_'+field_cat_id);
        var newdiv = document.createElement('div');
        newdiv.id = 'field_'+newfield_id;
        var divHTML = '<table cellpadding="0" cellspacing="0"><tr><td><img src="../images/space_left_last.gif" border="0"></td><td><img src="../images/space_left_last.gif" border="0"></td><td><img src="../images/item.gif" border="0"></td><td style="padding-top: 4px; padding-left: 3px;">&nbsp;<a href="javascript:getfield(\''+newfield_id+'\')">'+field_title+'</a></td></tr></table><div id="dep_fields_'+newfield_id+'"></div>';
        newdiv.innerHTML = divHTML;
        catfields.appendChild(newdiv);
      } else {
        var olddiv = document.getElementById('field_'+newfield_id);
        var divHTML = '<table cellpadding="0" cellspacing="0"><tr><td><img src="../images/space_left_last.gif" border="0"></td><td><img src="../images/space_left_last.gif" border="0"></td><td><img src="../images/item.gif" border="0"></td><td style="padding-top: 4px; padding-left: 3px;">&nbsp;<a href="javascript:getfield(\''+newfield_id+'\')">'+field_title+'</a></td></tr></table><div id="dep_fields_'+newfield_id+'"></div>';
        olddiv.innerHTML = divHTML;
      }
      var options = field_options.split("<~!~>");
      var depfieldDiv = document.getElementById('dep_fields_'+newfield_id);
      depfieldDiv.innerHTML = '';
      if(options.length > 0 && options[0] != '') {
        for(var a=0;a<options.length;a++) {
          option = options[a].split("<!>");
          if(options[a].length > 0 && option[2] == 1) {
            var depDiv = document.createElement('div');
            depDiv.id = 'dep_field_'+option[3];
            divHTML = "<table cellpadding='0' cellspacing='0'><tr><td><img src='../images/space_left_last.gif' border='0'></td><td><img src='../images/space_left_last.gif' border='0'></td><td><img src='../images/space_left_last.gif' border='0'></td><td><img src='../images/space_left_last.gif' border='0'></td><td><img src='../images/item_dep.gif' border='0'></td><td style='padding-top: 4px; padding-left: 3px;'>&nbsp;"+option[1]+" <a href='javascript:getdepfield(\'"+option[3]+"\');'><i>{/literal}{$admin_classified59}{literal}</i></a></td></tr></table>";
	    depDiv.innerHTML = divHTML;
            depfieldDiv.appendChild(depDiv);
          }
        }
      }
      cancelfield();
    }
  }
  function savedepfield_result() {
    cancelfield();
  }
  function showmaxlength() {
    document.getElementById('box1').style.display = "none";
    document.getElementById('box3').style.display = "none";
    document.getElementById('box4').style.display = "none";
    document.getElementById('box6').style.display = "none";

    if(document.getElementById('field_type').value=='1') {
      document.getElementById('box1').style.display = "block";
      document.getElementById('box6').style.display = "block";
    } else if(document.getElementById('field_type').value=='2') {
      document.getElementById('box6').style.display = "block";
    } else if(document.getElementById('field_type').value=='3') {
      document.getElementById('box3').style.display = "block";
    } else if(document.getElementById('field_type').value=='4') {
      document.getElementById('box4').style.display = "block";
    }
  }
  function addOptions(fieldname, label, dependency, dep_label, dep_id) {
    if(fieldname == 'newfields3') {
      var ni = document.getElementById(fieldname);
      var newdiv = document.createElement('div');
      var divHTML = "<input type='text' name='select_label[]' class='text' size='20' maxlength='50' value='"+label+"'><select name='select_dependency[]' class='text'><option value='0'";
      if(dependency == 0) { divHTML += " SELECTED"; }
      divHTML += ">{/literal}{$admin_classified43}{literal}</option><option value='1'";
      if(dependency == 1) { divHTML += " SELECTED"; }
      divHTML += ">{/literal}{$admin_classified44}{literal}</option></select><input type='text' class='text' name='select_dependent_label[]' size='20' maxlength='100' value='"+dep_label+"'><input type='hidden' name='select_dependent_id[]' value='"+dep_id+"'><br>";
      newdiv.innerHTML = divHTML;
      ni.appendChild(newdiv);
    } else if(fieldname == 'newfields4') {
      var ni = document.getElementById(fieldname);
      var newdiv = document.createElement('div');
      divHTML = "<input type='text' name='radio_label[]' class='text' size='20' maxlength='50' value='"+label+"'><select name='radio_dependency[]' class='text'><option value='0'";
      if(dependency == 0) { divHTML += " SELECTED"; }
      divHTML += ">{/literal}{$admin_classified43}{literal}</option><option value='1'";
      if(dependency == 1) { divHTML += " SELECTED"; }
      divHTML += ">{/literal}{$admin_classified44}{literal}</option></select><input type='text' class='text' name='radio_dependent_label[]' size='20' maxlength='100' value='"+dep_label+"'><input type='hidden' name='radio_dependent_id[]' value='"+dep_id+"'><br>";
      newdiv.innerHTML = divHTML;
      ni.appendChild(newdiv);
    }
  }
  function showtip(event, tip) {
    var tipDiv = document.getElementById('tipDiv');
    var ev = event || window.event;
    if (ev.pageX || ev.pageY) {
      posx = ev.pageX;
      posy = ev.pageY;
    } else if (ev.clientX || ev.clientY) {
      posx = ev.clientX + document.body.scrollLeft;
      posy = ev.clientY + document.body.scrollTop;
    }
    tipDiv.style.cssText = 'display:none;position:absolute;background:#FFFFFF;border:1px solid #999999;width:300px;z-index:99;padding:5px;left:'+parseInt(posx+10)+'px;top:'+parseInt(posy+10)+'px;';
    tipDiv.innerHTML = tip;
    tipDiv.style.display = 'block';  
  }
  function hidetip() {
    var tipDiv = document.getElementById('tipDiv');
    tipDiv.style.display = 'none';
  }
  //-->
  </script>
  {/literal}


  {* TIP DIV AND IFRAME *}
  <div id='tipDiv' style='display:none;'></div>
  <iframe id='catframe' name='ajax_frame' style='display:none;' src='about:blank'></iframe> 


  {* ADD/EDIT FIELD DISPLAY *}
  <div id='addedit_field' style='display:none;position:absolute;left:50%;border:5px solid #555555;width:450px;padding:15px;background:#EEEEEE;'>
    <div id='fielderror'></div>

    <form action='admin_classified.php' id='fieldForm' method='POST' target='ajax_frame'>
    <div style='margin-bottom: 3px;' id='field_title_div'>
    {$admin_classified25}<br>
    <input type='text' class='text' name='field_title' id='field_title' size='30' maxlength='100'>
    </div>

    <div style='margin-bottom: 3px;' id='field_cat_id_div'>
    {$admin_classified26}<br>
    <select name='field_cat_id' id='field_cat_id' class='text'>
    </select>
    </div>

    <div style='margin-bottom: 3px;' id='field_type_div'>
    {$admin_classified27}<br>
    <select name='field_type' id='field_type' class='text' onChange='showmaxlength();'>
    <option value=''></option>
    <option value='1'>{$admin_classified49}</option>
    <option value='2'>{$admin_classified50}</option>
    <option value='3'>{$admin_classified51}</option>
    <option value='4'>{$admin_classified52}</option>
    <option value='5'>{$admin_classified53}</option>
    </select>
    </div>

    <div style='margin-bottom: 3px;' id='field_style_div'>
    {$admin_classified28}<br>
    <input type='text' class='text' name='field_style' id='field_style' size='30' maxlength='200'>
    </div>

    <div style='margin-bottom: 3px;' id='field_desc_div'>
    {$admin_classified29}<br>
    <textarea name='field_desc' id='field_desc' rows='4' cols='40' class='text'></textarea>
    </div>

    <div style='margin-bottom: 3px;' id='field_error_div'>
    {$admin_classified30}<br>
    <input type='text' class='text' name='field_error' id='field_error' size='30' maxlength='250'>
    </div>

    <div style='margin-bottom: 3px;' id='field_required_div'>
    {$admin_classified31}<br>
    <select name='field_required' id='field_required' class='text'>
    <option value='0'>{$admin_classified55}</option>
    <option value='1'>{$admin_classified54}</option>
    </select>
    </div>

    <div style='margin-bottom: 3px;' id='field_search_div'>
    {$admin_classified64}<br>
    <select name='field_search' id='field_search' class='text'>
    <option value='0'>{$admin_classified65}</option>
    <option value='1'>{$admin_classified66}</option>
    <option value='2'>{$admin_classified67}</option>
    </select>
    <img src='../images/icons/tip.gif' border='0' class='icon' onMouseOver='showtip(event, "{$admin_classified68|replace:"'":"&amp;#039;"|replace:'"':'&amp;quot;'}")' onMouseOut='hidetip()'>
    </div>

    <div id='box6' style='display: none;'>
      <div style='margin-bottom: 3px;' id='field_html_div'>
      {$admin_classified32}<br>
      <input type='text' name='field_html' id='field_html' maxlength='200' size='30' class='text'>
      <img src='../images/icons/tip.gif' border='0' class='icon' onMouseOver='showtip(event, "{$admin_classified33|replace:"'":"&amp;#039;"|replace:'"':'&amp;quot;'}")' onMouseOut='hidetip()'>
      </div>
    </div>

    <div id='box1' style='display: none;'>
      <div style='margin-bottom: 3px;' id='field_maxlength_div'>
      {$admin_classified34}<br>
      <select name='field_maxlength' id='field_maxlength' class='text'>
      <option>50</option>
      <option>100</option>
      <option>150</option>
      <option>200</option>
      <option>250</option>
      </select>
      </div>

      <div style='margin-bottom: 3px;' id='field_link_div'>
      {$admin_classified35}<br>
      <input type='text' class='text' name='field_link' id='field_link' size='30' maxlength='250'>
      <img src='../images/icons/tip.gif' border='0' class='icon' onMouseOver="showtip(event, '{$admin_classified36|replace:"'":"&amp;#039;"|replace:'"':'&amp;quot;'}')" onMouseOut='hidetip()'>
      </div>

      <div style='margin-bottom: 3px;' id='field_regex_div'>
      {$admin_classified37}<br>
      <input type='text' class='text' name='field_regex' id='field_regex' size='30' maxlength='250'>
      <img src='../images/icons/tip.gif' border='0' class='icon' onMouseOver='showtip(event, "{$admin_classified38|replace:"'":"&amp;#039;"|replace:'"':'&amp;quot;'}")' onMouseOut='hidetip()'>
      </div>
    </div>

    <div id='box3' style='display: none;'>
      <div style='margin-bottom: 3px;' id='select_option_div'>
      {$admin_classified39}<br>
      <table cellpadding='0' cellspacing='0' width='100%'>
      <tr>
      <td width='30%'>{$admin_classified40}</td>
      <td width='36%'>{$admin_classified41}</td>
      <td>{$admin_classified42}</td>
      </tr>
      <tr>
      <td colspan='3'><p id='newfields3'></p></td>
      </tr>
      <tr>
      <td colspan='3'><a href="javascript:addOptions('newfields3', '', '0', '', '')">{$admin_classified45}</a></td>
      </tr>
      </table>
      </div>
    </div>

    <div id='box4' style='display: none;'>
      <div style='margin-bottom: 3px;' id='radio_option_div'>
      {$admin_classified39}<br>
      <table cellpadding='0' cellspacing='0'>
      <tr>
      <td width='30%'>{$admin_classified40}</td>
      <td width='36%'>{$admin_classified41}</td>
      <td>{$admin_classified42}</td>
      </tr>
      <tr>
      <td colspan='3'><p id='newfields4'></p></td>
      </tr>
      <tr>
      <td colspan='3'><a href="javascript:addOptions('newfields4', '', '0', '', '')">{$admin_classified45}</a></td>
      </tr>
      </table>
      </div>
    </div>

    <br>

    <div style='margin-bottom: 3px;' id='submitButtons'>   
    </div>

    <input type='hidden' name='task' id='task' value=''>
    <input type='hidden' name='field_id' id='field_id' value=''>
    </form>
  </div>



<form action='admin_classified.php' method='POST' name='info' name='classifiedForm'>
<table cellpadding='0' cellspacing='0' width='600'>
<td class='header'>{$admin_classified10}</td>
</tr>
<td class='setting1'>
  {$admin_classified11}
</td>
</tr>
<tr>
<td class='setting2'>
  <table cellpadding='2' cellspacing='0'>
  <tr>
  <td><input type='radio' name='setting_permission_classified' id='permission_classified_1' value='1'{if $permission_classified == 1} CHECKED{/if}></td>
  <td><label for='permission_classified_1'>{$admin_classified13}</label></td>
  </tr>
  <tr>
  <td><input type='radio' name='setting_permission_classified' id='permission_classified_0' value='0'{if $permission_classified == 0} CHECKED{/if}></td>
  <td><label for='permission_classified_0'>{$admin_classified14}</label></td>
  </tr>
  </table>
</td>
</tr>
</table>
  
<br>
  
<table cellpadding='0' cellspacing='0' width='600'>
<tr><td class='header'>{$admin_classified21}</td></tr>
<td class='setting1'>
  {$admin_classified22}
</td></tr>
<tr>
<td class='setting2' id='categories'>


  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td style='font-weight: bold;'>&nbsp;{$admin_classified17} 
   - <a href='javascript:addcat();'>[{$admin_classified18}]</a>
  </td></tr>
  </table>

  {* LOOP THROUGH CATEGORIES *}
  {section name=cat_loop loop=$cats}

    <div id='cat_{$cats[cat_loop].cat_id}'>
    <table cellpadding='0' cellspacing='0' style='{if $smarty.section.cat_loop.first != true}margin-top: 15px;{/if}'>
    <tr>
    <td><img src='../images/folder_open_yellow.gif' border='0'></td>
    <td style='padding-top: 4px; padding-left: 3px; font-weight: bold;'>&nbsp;<span id='cat_{$cats[cat_loop].cat_id}_span'><a href='javascript:editcat("{$cats[cat_loop].cat_id}", "0");' id='cat_{$cats[cat_loop].cat_id}_title'>{$cats[cat_loop].cat_title}</a></span></td>
    </tr>
    </table>

    {* LOOP THROUGH SUBCATEGORIES *}
    <div id='subcats_{$cats[cat_loop].cat_id}'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td><img src='../images/space_left_last.gif' border='0'></td>
    <td style='padding-top: 4px; padding-left: 3px;'>{$admin_classified62} - <a href='javascript:addsubcat("{$cats[cat_loop].cat_id}");'>[{$admin_classified19}]</a></td>
    </tr>
    </table>

    {section name=subcat_loop loop=$cats[cat_loop].subcats}
      <div id='cat_{$cats[cat_loop].subcats[subcat_loop].subcat_id}'>
      <table cellpadding='0' cellspacing='0'>
      <tr>
      <td><img src='../images/space_left_last.gif' border='0'></td>
      <td><img src='../images/space_left_last.gif' border='0'></td>
      <td><img src='../images/folder_closed_green.gif' border='0'></td>
      <td style='padding-top: 4px; padding-left: 3px;'>&nbsp;<span id='cat_{$cats[cat_loop].subcats[subcat_loop].subcat_id}_span'><a href='javascript:editcat("{$cats[cat_loop].subcats[subcat_loop].subcat_id}", "{$cats[cat_loop].cat_id}");' id='cat_{$cats[cat_loop].subcats[subcat_loop].subcat_id}_title'>{$cats[cat_loop].subcats[subcat_loop].subcat_title}</a></span></td>
      </tr>
      </table>
      </div>
    {/section}
    </div>

    {* LOOP THROUGH FIELDS *}
    <div id='fields_{$cats[cat_loop].cat_id}'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td><img src='../images/space_left_last.gif' border='0'></td>
    <td style='padding-top: 4px; padding-left: 3px;'>{$admin_classified63} - <a href='javascript:addfield("{$cats[cat_loop].cat_id}");'>[{$admin_classified16}]</a></td>
    </tr>
    </table>

    {section name=field_loop loop=$cats[cat_loop].fields}
      <div id='field_{$cats[cat_loop].fields[field_loop].field_id}'>
      <table cellpadding='0' cellspacing='0'>
      <tr>
      <td><img src='../images/space_left_last.gif' border='0'></td>
      <td><img src='../images/space_left_last.gif' border='0'></td>
      <td><img src='../images/item.gif' border='0'></td>
      <td style='padding-top: 4px; padding-left: 3px;'>&nbsp;<a href='javascript:getfield("{$cats[cat_loop].fields[field_loop].field_id}")'>{$cats[cat_loop].fields[field_loop].field_title}</a></td>
      </tr>
      </table>

      {* LOOP THROUGH DEPENDENT FIELDS *}
      <div id='dep_fields_{$cats[cat_loop].fields[field_loop].field_id}'>
      {section name=dep_field_loop loop=$cats[cat_loop].fields[field_loop].dep_fields}
        <div id='dep_field_{$cats[cat_loop].fields[field_loop].dep_fields[dep_field_loop].field_id}'>
        <table cellpadding='0' cellspacing='0'>
        <tr>
        <td><img src='../images/space_left_last.gif' border='0'></td>
        <td><img src='../images/space_left_last.gif' border='0'></td>
        <td><img src='../images/space_left_last.gif' border='0'></td>
        <td><img src='../images/item_dep.gif' border='0'></td>
        <td style='padding-top: 4px; padding-left: 3px;'>&nbsp;{$cats[cat_loop].fields[field_loop].dep_fields[dep_field_loop].option_label} <a href='javascript:getdepfield("{$cats[cat_loop].fields[field_loop].dep_fields[dep_field_loop].field_id}");'><i>{$admin_classified59}</i></a></td>
        </tr>
        </table>
        </div>
      {/section}
      </div>
      </div>
    {/section}
    </div>
    </div>
  {/section}





</td>
</tr>
</table>
 
<br>

<table cellpadding='0' cellspacing='0' width='600'>
<tr>
<td class='header'>{$admin_classified6}</td>
</tr>
<td class='setting1'>
  {$admin_classified7}
</td>
</tr>
<tr>
<td class='setting2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td width='80'>{$admin_classified4}</td>
  <td><input type='text' class='text' size='30' name='setting_email_classifiedcomment_subject' value='{$setting_email_classifiedcomment_subject}' maxlength='200'></td>
  </tr><tr>
  <td valign='top'>{$admin_classified5}</td>
  <td><textarea rows='6' cols='80' class='text' name='setting_email_classifiedcomment_message'>{$setting_email_classifiedcomment_message}</textarea><br>{$admin_classified8}</td>
  </tr>
  </table>
</td>
</tr>
</table>

<br>

<input type='submit' class='button' value='{$admin_classified9}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='admin_footer.tpl'}