{include file='header.tpl'}
<link rel="stylesheet" href="./css/search.css">
<link rel="stylesheet" href="./css/usearch.css">
<div id="pageBody" class="pageBody">
	<div id="wrapH">
		<div id="wrapHI">

			<div id="header">

			<h1>����</h1>
			</div>
		</div>
	</div>
	<div id="wrap2">
		<div id="wrap1">
			<div id="content">

			<form method="post" action="search_advanced.php" id="goSearch" name="goSearch">

 			<input type="hidden" id="s" name="uni" value="1" />

   			 

			<div class="bar clearFix summaryBar">

			 <div class="summary">
			  <strong>10 ��������� ������������� �� 24 000+</strong>
			 </div>
             </div>
			 
			 
			<div id="searchResults" class="searchResults clearFix">
 				<div class="column results">

				<div class="result clearFix">
								     {if $randoms|@count > 0} 
				 {section name=randoms_loop loop=$randoms max=10}
				  <table cellpadding='0' cellspacing='0' border="0">
				  <tr>
				  <td class='browse_friends_result0'>

				  <a href='{$url->url_create('profile',$randoms[randoms_loop]->user_info.user_username)}'><img src='{$randoms[randoms_loop]->user_photo('./images/nophoto.gif')}' class='photo' width='100' border='0'></a>



</a></td>
				  <td class='browse_friends_result1' width='100%' valign='top'>

				    <div class="info">
				    <dl class="clearFix">

				      <dt>���:</dt><dd><a href='{$url->url_create('profile',$randoms[randoms_loop]->user_info.user_username)}'>{$randoms[randoms_loop]->user_info.user_username}</dd>
				  </div>

				  </td>
 <td  valign='top' nowrap='nowrap' align=left>

				    <a href='profile.php?user={$randoms[randoms_loop]->user_info.user_username}'>����� �������</a>
				    <br><a href='user_friends_add.php?user={$randoms[randoms_loop]->user_info.user_username}'>�������� � ������</a>
				    <br><a href='user_messages_new.php?to={$randoms[randoms_loop]->user_info.user_username}'>C��������</a>
				  </td>
				  </tr>

{cycle name="startrow" values="<table cellpadding='0' cellspacing='0' align='center'><tr>,,,,,,,,,,,,,,,,,,,"}
 {if $smarty.section.randoms_loop.last == true} 
 {else}
          {cycle name="endrow" values=",,,,,,,,,,,,,,,,,,,</tr></table>"}
        {/if}
      {/section}
    {else}
      ������ ���
    {/if} 
				  </table>
				</div></div>
				


		     <div class="column" style="width: 155px; padding-top:10px; overflow: hidden; word-wrap: break-word;">
		       <div style = "border-bottom: 1px solid #DDD; padding-bottom:5px">

				<div class="uTitle">�������</div>
				<select class="select" style="width:150px; margin:5px 0px;" id="order" name="order" onchange="ge('goSearch').submit();">
				    <option value="0" selected="selected">�� ���� �����������</option>
				    <option value="1" ">�� ������� ���������</option>
				    <option value="2" ">�� ���������</option>
				   </select>

			</div>
	


			  <!-- Choose sex -->
			  <div style="padding: 4px 0px;" id="sex2" class="uBorders">
			   <div class="bOpen">
			    <div class="clearFix handy" onclick="return collapseBox('sex2', this, 0.45, 0.20)" onfocus="blur()">

			     <div class="uTitle uArrow">���</div>

			    </div>
			   </div>
			   <div class="c">
			    <div class="pPad">
			     <input name="sex" id="sex" value="0" checked="checked" type="radio"> ���
			     <input name="sex" id="sex" value="2"  type="radio"> ���.
			     <input name="sex" id="sex" value="1"  type="radio"> ���.
			    </div>

		   </div>













			   <!-- Choose user -->

			  <div style = "padding: 4px 0px" id="user" class="uBorders">
			   <div class="bOpen">
			    <div class="clearFix handy" onclick="return collapseBox('user', this, 0.45, 0.20)" onfocus="blur()">

			     <div class="uTitle uArrow">�����</div>

			    </div>
			   </div>
			   <div class="c">

			    <div class="pPad">
 			<input class="inputText" id="search" name="search" style="width: 144px;" value="">

			    </div>
		   </div>		   
			 </div>
<div style = "padding: 4px 0px 0px 0px">
<input class="button" value="������ �����" type="submit" style="width: 150px;">
			  </div>
		   </div>

		    
			
		</form>
		</div>
	</div>
</div>








</div><center>

  
</div>

</td>

</div>

