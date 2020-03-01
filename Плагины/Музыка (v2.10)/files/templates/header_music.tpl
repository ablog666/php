<link rel="stylesheet" href="./templates/styles_music.css" title="stylesheet" type="text/css">  

{* ASSIGN MENU VARIABLES *}
{if $user->level_info.level_music_allow != 0}
  {array var="music_menu" value="user_music_edit.php"}
  {array var="music_menu" value="music16.gif"}
  {array var="music_menu" value=$header_music1}
  {array var="global_plugin_menu" value=$music_menu} 
{/if}