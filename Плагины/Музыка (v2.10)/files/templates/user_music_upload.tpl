{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_music_edit.php'>Edit Music</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_music_settings.php'>Music Settings</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<table cellpadding='0' cellspacing='0'>
<tr>
<td width='100%'>

  <img src='./images/icons/music48.gif' border='0' class='icon_big'>
  <div class='page_header'>{$user_music_upload1}</div>
  <div>{$user_music_upload2}</div>

  <br><div style='float:left;'><img src='./images/icons/bulb16.gif' border='0' class='icon'></div><div style='float:left;'><b>{$user_music_upload17}<br>{$user_music_upload18}</b></div>

</td>
<td align='right' valign='top'>

  <table cellpadding='0' cellspacing='0' width='120'>
  <tr><td class='button' nowrap='nowrap'><a href='user_music_edit.php'><img src='./images/icons/back16.gif' border='0' class='icon'>{$user_music_upload3}</a></td></tr>
  </table>

</td>
</tr>
</table>

<br>

<div>{$user_music_upload6} {$space_left} {$user_music_upload7}</div>
<div>{$user_music_upload4} {$max_filesize} MB</div>
<div>{$user_music_upload5} {$allowed_exts}</div>

{* SHOW MUSIC UPLOADED MESSAGE *}
{if $file1_result != "" OR $file2_result != "" OR $file3_result != "" OR $file4_result != "" OR $file5_result != ""}
  <br>
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='result'>
    <div class='success' style='text-align: left;'> 
      <div>{$file1_result}</div>
      <div>{$file2_result}</div>
      <div>{$file3_result}</div>
      <div>{$file4_result}</div>
      <div>{$file5_result}</div>
    </div>
  </td>
  </tr>
  </table>
{/if}

<div id='uploadResultsDivMain' style='display: none;'>
  <br>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td class='success' id='uploadResultsDiv'></td>
  </tr>
  </table>
  <br>
  <div>
    <form action='user_music_edit.php' method='get'>
    <input type='submit' class='button' name='submit' value='{$user_music_upload13}'>
    </form>
  </div>
</div>


<br>

<form action='user_music_upload.php' name='uploadform' method='post' onsubmit='doupload()' enctype='multipart/form-data'>
<input type='hidden' name='upload_method' value='java'>
<input type='hidden' name='task' value='doupload'>
<div id="jumpLoaderAppletLoadingDiv" style="visibility: visible;">{$user_music_upload19}</div>
<div id="jumpLoaderAppletDiv" style="visibility: hidden; height: 0px;">
  <applet name="jumpLoaderApplet" code="jmaster.jumploader.app.JumpLoaderApplet.class" archive="include/java/jumploader.jar" mayscript="" height="400" width="800" align="center">
    <param name="uc_imageEditorEnabled" value="true" />
    <param name="uc_uploadUrl" value="user_music_upload.php?task=doupload&user_id={$user->user_info.user_id}&upload_token={$upload_token}" />
    
    <param name="ac_fireAppletInitialized" value="true" />
    <param name="ac_fireUploaderFileAdded" value="true" />
    <param name="ac_fireUploaderFileRemoved" value="true" />
    <param name="ac_fireUploaderFileStatusChanged" value="true" />
    <param name="ac_fireUploaderFilesReset" value="true" />
    <param name="ac_fireUploaderStatusChanged" value="true" />
    <param name="ac_fireUploaderSelectionChanged" value="true" />
    <param name="vc_lookAndFeel" value="system" />
    <param name="vc_uploadListViewName" value="_compact"/>
    <param name="vc_MainViewFileListViewVisible" value="false"/>
    <param name="vc_FileTreeViewShowFiles" value="true"/>
    <param name="vc_FileListViewLocationBarVisible" value="false"/>
    <param name="vc_UploadViewMenuBarVisible" value="false"/>
    <param name="vc_UploadViewAddActionVisible" value="false"/>
    <param name="vc_UploadViewRemoveActionVisible" value="false"/>
    <param name="vc_UploadViewRetryActionVisible" value="false"/>
    <param name="vc_UploadViewFilesSummaryBarVisible" value="false"/>
  </applet>
</div>
</form>

<form action='user_music_upload.php' name='uploadformbasic' method='post' onsubmit='doupload()' enctype='multipart/form-data'>
<div id="basicUploader" style="visibility: hidden; height: 0px;">
    <div id='div1'>
	  <table cellpadding='0' cellspacing='0' class='form'>
	  <tr>
	  <td class='form1' width='65'><img src='./images/icons/music16.gif' border='0' class='icon'>{$user_music_upload8}</td>
	  <td class='form2'><input type='file' name='file1' size='60' class='text' onchange="showdiv('div_submit');"></td>
	  </tr>
	  </table>
	</div>
	
	<div id='div_submit' style='display: none;'>
	  <table cellpadding='0' cellspacing='0'>
	  <tr>
	  <td class='form1' width='65'>&nbsp;</td>
	  <td class='form1'>
	    <input type='submit' class='button' name='submit' value='{$user_music_upload21}' id='submit'>&nbsp;
	    <input type='hidden' name='task' value='douploadbasic'>
	    <input type='hidden' name='upload_method' value='basic'>
	    <input type='hidden' name='MAX_FILE_SIZE' value='{$max_filesize}'>
	  </td>
	  <td class='form2'>&nbsp;</td>
	  </tr>
	  </table>
	<div id='status' style='padding-left:80px;'>
	</div>
</div>
</form>

{literal}
<script lang='javascript'>
<!--
function doupload() {
document.getElementById('submit').disabled = true;
document.getElementById('status').innerHTML = '<img src="images/icons/music_working.gif" style="vertical-align:middle">{/literal}{$user_music_upload20}{literal}';
}
// -->
</script>
{/literal}




{literal}
<script language="javascript">

  var applet_loaded = false;
  var applet_debug = false;
  
  var appletDotCount = 0;
  
  var count_success = 0;
  var count_failure = 0;
  function appletIsLoading()
  {
    // were done here
    if( applet_loaded )
    {
      clearInterval(appletIsLoadingInterval);
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.height = '0px';
      document.getElementById('jumpLoaderAppletDiv').style.height = '600px'; // Maybe auto?
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.visibility = 'hidden';
      document.getElementById('jumpLoaderAppletDiv').style.visibility = 'visible';
    }
  }
    if(navigator.javaEnabled() == false){
      clearInterval(appletIsLoadingInterval);
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.height = '0px';
      document.getElementById('basicUploader').style.height = '600px'; // Maybe auto?
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.visibility = 'hidden';
      document.getElementById('basicUploader').style.visibility = 'visible';   	
    }  
    browser = navigator.userAgent;
    if(browser.indexOf('Safari') != -1){
       clearInterval(appletIsLoadingInterval);
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.height = '0px';
      document.getElementById('basicUploader').style.height = '600px'; // Maybe auto?
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.visibility = 'hidden';
      document.getElementById('basicUploader').style.visibility = 'visible';   	  
    } 
  var appletIsLoadingInterval = setInterval( "appletIsLoading();", 200 );
  
</script>


<script language="javascript">
  function showBasic(){
  	  clearInterval(appletIsLoadingInterval);
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.height = '0px';
      document.getElementById('basicUploader').style.height = '600px'; // Maybe auto?
      
      document.getElementById('jumpLoaderAppletDiv').style.height = '0px';
      document.getElementById('jumpLoaderAppletDiv').style.visibility = 'hidden';
      
      document.getElementById('jumpLoaderAppletLoadingDiv').style.visibility = 'hidden';
      document.getElementById('basicUploader').style.visibility = 'visible';   
  }
	/**
	 * applet initialized notification
	 */
	function appletInitialized( applet )
  {
    applet_loaded = true;
    
    // Original code
    if( applet_debug ) traceEvent( "appletInitialized, " + applet.getAppletInfo() );
	}
  
  
  
	/**
	 * files reset notification
	 */
	function uploaderFilesReset( uploader )
  {
    // Original code
    if( applet_debug ) traceEvent( "uploaderFilesReset, fileCount=" + uploader.getFileCount() );
  }
  
  
  
	/**
	 * file added notification
	 */
	function uploaderFileAdded( uploader, file )
  {
    // Original code
    if( applet_debug ) traceEvent( "uploaderFileAdded, index=" + file.getIndex() );
  }
  
  
  
	/**
	 * file removed notification
	 */
	function uploaderFileRemoved( uploader, file )
  {
    // Original code
    if( applet_debug ) traceEvent( "uploaderFileRemoved, path=" + file.getPath() );
  }
  
  
  
  /**
   * file status changed notification
   */
	function uploaderFileStatusChanged( uploader, file )
  {
    var uploadResultsDiv = document.getElementById('uploadResultsDiv');
    var uploadResultsDivMain = document.getElementById('uploadResultsDivMain');
    var content = file.getResponseContent() + '';
    var content_array;
    var upload_result;
    var upload_message;
    
    if( typeof(content)=="string" )
    {
      content_array = content.split(';');
      upload_result = content_array[0];
      upload_message = content_array[1];
    }
    //alert(typeof(content)+' '+file.getStatus()+' '+upload_result);
    
    // 2 - complete?
    if( file.getStatus()==2 )
    {
      // Success
      if( upload_result=="success" )
      {
        var resultDiv = document.createElement('div');
        resultDiv.innerHTML = "<img src='./images/success.gif' border='0' class='icon'> " + content_array[1];
        uploadResultsDiv.style.display = 'block';
        uploadResultsDiv.appendChild(resultDiv);
        uploadResultsDivMain.style.display = 'block';
        
        count_success++;
      }
      
      // Failure
      if( upload_result=="failure" )
      {
        var resultDiv = document.createElement('div');
        resultDiv.innerHTML = "<img src='./images/error.gif' border='0' class='icon'>" + content_array[1];
        uploadResultsDiv.style.display = 'block';
        uploadResultsDiv.appendChild(resultDiv);
        uploadResultsDivMain.style.display = 'block';
        
        count_failure++;
      }
    }
    
    
    // Original code
    if( applet_debug ) traceEvent( "uploaderFileStatusChanged, index=" + file.getIndex() + ", status=" + file.getStatus() + ", content=" + file.getResponseContent() );
  }
  
  
  
	/**
	 * uploader status changed notification
	 */
	function uploaderStatusChanged( uploader )
  {
    // 0 - Off
   /* if( uploader.getStatus()==0 )
    {
      // Complete with at least one successful upload
      if( count_success>0 )
      {
        var editTitleLinkDiv = document.getElementById('editTitleLinkDiv');
        editTitleLinkDiv.style.display = 'block';
      }
    }*/
    
    // Original code
    if( applet_debug ) traceEvent( "uploaderStatusChanged, status=" + uploader.getStatus() );
  }
  
  
  
	/**
	 * uploader selection changed notification
	 */
	function uploaderSelectionChanged( uploader )
  {
    // Original code
    if( applet_debug ) traceEvent( "uploaderSelectionChanged" );
  }
  
  
  
</script>
{/literal}

{include file='footer.tpl'}