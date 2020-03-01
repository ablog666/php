
{* ASSIGN MENU VARIABLES *}
{if $setting.setting_forum_enabled != 0}
  {array var="forum_menu" value=$setting.setting_forum_path}
  {array var="forum_menu" value="forum16.gif"}
  {array var="forum_menu" value=$header_forum1}
  {array var="global_plugin_menu" value=$forum_menu} 
{/if}