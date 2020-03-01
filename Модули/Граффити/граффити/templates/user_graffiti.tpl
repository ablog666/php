{include file='header.tpl'}

<script src='include/js/swfobject.js'></script>
<div id="flash_player_container" style="text-align: center; width: 100%; margin: auto;">You need flash for this feature: <a href="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash&promoid=BIOW">Flash Player</a>.</div>

<script type="text/javascript">
//<![CDATA[
var so = new SWFObject('include/flash/graffiti.swf','player',"600","385",'9');
        so.addParam("allowfullscreen","false");
        so.addVariable('overstretch','false');
        so.addVariable('postTo','user_graffiti.php?user={$graffitiName}%26graffiti={$graffitiRand}');
        so.addVariable('redirectTo','profile.php?user={$graffitiName}');
        so.write('flash_player_container');
//]]>
</script>

{include file='footer.tpl'}