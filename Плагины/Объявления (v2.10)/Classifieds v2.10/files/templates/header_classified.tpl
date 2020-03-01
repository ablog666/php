<link rel="stylesheet" href="./templates/styles_classified.css" title="stylesheet" type="text/css">  
<script type="text/javascript" src="./include/fckeditor/fckeditor.js"></script>

{* ASSIGN MENU VARIABLES *}
{if $user->level_info.level_classified_allow != 0}
  {array var="classified_menu" value="user_classified.php"}
  {array var="classified_menu" value="classified16.gif"}
  {array var="classified_menu" value=$header_classified1}
  {array var="global_plugin_menu" value=$classified_menu} 
{/if}