<!--[if lt IE 7]>
<script defer type="text/javascript" src="./include/js/pngfix.js"></script>
<![endif]-->

{* <link rel="stylesheet" href="./templates/styles_userpoints.css" title="stylesheet" type="text/css"> *}

{* ASSIGN MENU VARIABLES *}
{if (($user->level_info.level_userpoints_allow != 0) && ($user->user_info.user_userpoints_allowed != 0))}
  {array var="userpoints_menu" value="user_vault.php"}
  {array var="userpoints_menu" value="userpoints16.png"}
  {array var="userpoints_menu" value=$header_userpoints1}
  {array var="global_plugin_menu" value=$userpoints_menu} 
{/if}