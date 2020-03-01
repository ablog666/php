<?


// SET GENERAL VARIABLES, AVAILABLE ON EVERY PAGE
$header_userpoints[1] = "Punkte";


// ASSIGN ALL SMARTY GENERAL VARIABLES
reset($header_userpoints);
while(list($key, $val) = each($header_userpoints)) {
  $smarty->assign("header_userpoints".$key, $val);
}


// FUNCTION VARIABLES

$functions_userpoints[1] = "Du hast nicht genug Punkte um eine Anzeige zu schalten.";
$functions_userpoints[2] = "Du hast nicht genug Punkte um ein Event zu erstellen.";
$functions_userpoints[3] = "Du hast nicht genug Punkte um eine Gruppe zu erstellen.";
$functions_userpoints[4] = "Du hast nicht genug Punkte um eine Umfrage zu starten.";

$functions_userpoints[10] = "Danke für Deine Bestellung! Deine Transaktion wird überprüft nachdem wir die Bestätigung vom Zahlungsunternehmen erhalten haben. Das dauert normalerweise nur ein paar Minuten.";
$functions_userpoints[11] = "Deine Bestellung wurde abgebrochen.";

$functions_userpoints[20] = "Fehler. Bitte kontaktiere den Aministrator";
$functions_userpoints[21] = "Dieses Element wird nicht unterstützt.";
$functions_userpoints[22] = "Du hast nicht ausreichend viele Punkte.";

$functions_userpoints[30] = "Partner besuchen";

$functions_userpoints[40] = "Votiere für";
$functions_userpoints[41] = "Diese Umfrage existiert nicht.";
$functions_userpoints[42] = "poll";

$functions_userpoints[50] = "Punkte kaufen";

$functions_userpoints[60] = "Benutzerlevel erhöhen";
$functions_userpoints[61] = "Von diesem Benutzerlevel aus ist kein Upgrade möglich.";
$functions_userpoints[62] = "Dein Benutzerlevel wurde erhöht!";

$functions_userpoints[70] = "Mein Profil promoten";
$functions_userpoints[71] = "Invalides Template. Bitte kontaktiere den Administrator.";
$functions_userpoints[72] = "Invalide Anzeige";
$functions_userpoints[73] = "Promote mein(e)";
$functions_userpoints[74] = "Anzeige";
$functions_userpoints[75] = "Invalides Event";
$functions_userpoints[76] = "Event";
$functions_userpoints[77] = "Invalide Gruppe";
$functions_userpoints[78] = "Gruppe";
$functions_userpoints[79] = "Invalide Umfrage";
$functions_userpoints[80] = "Umfrage";
$functions_userpoints[81] = "Deine Promotion wurde akzeptiert";
$functions_userpoints[82] = " und wird sofort starten.";
$functions_userpoints[83] = " und wird ab morgen aktiv.";
$functions_userpoints[84] = "Du hast keine Kleinanzeigen erstellt.";
$functions_userpoints[85] = "Du hast kein Event erstellt.";
$functions_userpoints[86] = "Du hast keine Gruppe erstellt.";
$functions_userpoints[87] = "You hast keine Umfrage erstellt.";

/*
$functions_userpoints[100 21] = "Du hast nicht ausreichend viele Punkte.";
$functions_userpoints[101 22] = "Bitte gib einen betrag grösser 0 ein.";
$functions_userpoints[102 23] = "Empfänger existiert nicht oder kann keine Punkte akzeptieren.";
$functions_userpoints[103 24] = "Empfänger existiert nicht oder kann keine Punkte akzeptieren.";
$functions_userpoints[104 34] = "Dir ist es nicht erlaubt Punkte zu übertragen.";
*/

$functions_userpoints[100] = "Du hast nicht ausreichend viele Punkte.";
$functions_userpoints[101] = "Bitte gib eine Menge grösser 0 ein.";
$functions_userpoints[102] = "Empfänger existiert nicht oder kann keine Punkte akzeptieren.";
$functions_userpoints[103] = "Empfänger existiert nicht oder kann keine Punkte akzeptieren.";
$functions_userpoints[104] = "Dir ist es nicht erlaubt Punkte zu übertragen.";
$functions_userpoints[105] = "Du kannst maximal %d Punkte übertragen.";
$functions_userpoints[106] = "Du hast Dein Übertragungskontingent aufgebraucht. Versuchs zu einem späteren Zeitpunkt wieder.";

$functions_userpoints[110] = "Generic";



$actions_desc["invite"]	= "Freunde einladen";
$actions_desc["refer"] 	= "Freunde ins Netzwerk bringen";


// SET LANGUAGE PAGE VARIABLES
switch ($page) {

  case "admin_userpoints":
	$admin_userpoints[1] = "Allgemeine Einstellungen Activity Points";
	$admin_userpoints[2] = "Diese Seite enthält die allgemeinen Einstellungen des Activity Points Plugins.";
	$admin_userpoints[3] = "Deine Änderungen wurden gespeichert.";

	$admin_userpoints[4] = "Aktiviere Activity Points?";
	$admin_userpoints[5] = "Möchtest Du Deinen Benutzern erlauben für Aktivität Punkte zu erhalten?";
	$admin_userpoints[6] = "JA, aktiviere Aktivitätspunkte.";
	$admin_userpoints[7] = "NEIN, deaktiviere Aktivitätspunkte.";

	$admin_userpoints[8] = "Aktiviere Top Users Wertung?";
	$admin_userpoints[9] = "This will show a page of top users ranked by total amount of accumulated points (regardless of their current points \"balance\") and also show user's rank on profile and user homepage.";
	$admin_userpoints[10] = "Yes, enable Top Users.";
	$admin_userpoints[11] = "No, disable Top Users.";

	$admin_userpoints[13] = "Save Changes";
    
    break;


  case "admin_userpoints_pointranks":
	$admin_userpoints_pointranks[1] = "Points Rankings";
	$admin_userpoints_pointranks[2] = "This page allows setting rankings based on total earned points count.";
	$admin_userpoints_pointranks[3] = "Your changes have been saved.";

	$admin_userpoints_pointranks[4] = "Enable Points Ranking?";
	$admin_userpoints_pointranks[5] = "Control if you want to show rank calculated from user's total earned points till date based on table below on his profile and user home page.";
	$admin_userpoints_pointranks[6] = "Yes, enable points ranking.";
	$admin_userpoints_pointranks[7] = "No, disable points ranking.";

	$admin_userpoints_pointranks[8] = "Rankings";
	$admin_userpoints_pointranks[9] = "Rankings";
	$admin_userpoints_pointranks[10] = "Points from";
	$admin_userpoints_pointranks[11] = "Rank Title";
	$admin_userpoints_pointranks[12] = "+ Add more";

	$admin_userpoints_pointranks[13] = "Save Changes";
    
    break;


  case "admin_userpoints_charging":
	$admin_userpoints_charging[1] = "Charging for preset actions.";
	$admin_userpoints_charging[2] = "This page allows setting costs for posting / creating new events, classifieds, groups and polls. <br>If you enable charging, DO NOT FORGET to <strong>zero activity points</strong> assigned for same action, e.g. creating group.";
	$admin_userpoints_charging[3] = "Your changes have been saved.";

	$admin_userpoints_charging[4] = "Classifieds";
	$admin_userpoints_charging[5] = "Select whether or not you want to charge for posting a new classified.";
	$admin_userpoints_charging[6] = "Yes, charge for posting a classified";
	$admin_userpoints_charging[7] = "No, do not charge for posting a classified ";
	$admin_userpoints_charging[8] = "If you have selected \"Yes\" above, please specify points cost for posting a classified.";
	$admin_userpoints_charging[9] = "points";

	$admin_userpoints_charging[10] = "Groups";
	$admin_userpoints_charging[11] = "Select whether or not you want to charge for posting a new group.";
	$admin_userpoints_charging[12] = "Yes, charge for posting a group";
	$admin_userpoints_charging[13] = "No, do not charge for posting a group";
	$admin_userpoints_charging[14] = "If you have selected \"Yes\" above, please specify points cost for posting a group.";

	$admin_userpoints_charging[15] = "Polls";
	$admin_userpoints_charging[16] = "Select whether or not you want to charge for posting a new poll.";
	$admin_userpoints_charging[17] = "Yes, charge for posting a poll";
	$admin_userpoints_charging[18] = "No, do not charge for posting a poll";
	$admin_userpoints_charging[19] = "If you have selected \"Yes\" above, please specify points cost for posting a poll.";

	$admin_userpoints_charging[20] = "Events";
	$admin_userpoints_charging[21] = "Select whether or not you want to charge for posting a new event.";
	$admin_userpoints_charging[22] = "Yes, charge for posting an event";
	$admin_userpoints_charging[23] = "No, do not charge for posting a event";
	$admin_userpoints_charging[24] = "If you have selected \"Yes\" above, please specify points cost for posting an event.";


	$admin_userpoints_charging[25] = "Save Changes";
    
    break;


  case "admin_userpoints_paymentgw":
	$admin_userpoints_paymentgw[1] = "Virtual economy";
	$admin_userpoints_paymentgw[2] = "Here you can set exchange rate for real money and setup payment gateways.";
	$admin_userpoints_paymentgw[3] = "Your changes have been saved.";

	$admin_userpoints_paymentgw[4] = "Virtual Economy";
	$admin_userpoints_paymentgw[5] = "Assign points / money exchange rate. This is the the ratio for converting real money into points and vice versa.";
	$admin_userpoints_paymentgw[6] = "points";

	$admin_userpoints_paymentgw[7] = "";
	$admin_userpoints_paymentgw[8] = "";
	$admin_userpoints_paymentgw[9] = "";

	$admin_userpoints_paymentgw[10] = "";
	$admin_userpoints_paymentgw[11] = "";

	$admin_userpoints_paymentgw[13] = "Save Changes";

	$admin_userpoints_paymentgw[20] = "Paypal";
	$admin_userpoints_paymentgw[21] = "Information about your paypal account for purchases. For immediate confirmation don't forget to turn on PDT and Instant Notifications in your paypal account.";
	$admin_userpoints_paymentgw[22] = "Paypal email";
	$admin_userpoints_paymentgw[23] = "Certificate ID";
	$admin_userpoints_paymentgw[24] = "Identity token";
	$admin_userpoints_paymentgw[25] = "My Private Key File";
	$admin_userpoints_paymentgw[26] = "My Public Certificate file";
	$admin_userpoints_paymentgw[27] = "Paypal Public  Certificate file";
	$admin_userpoints_paymentgw[28] = "Encryption allows keeping purchasing data intact and prevent fraudulent changes during paypal transaction.";
	$admin_userpoints_paymentgw[29] = "Enable encryption";

	$admin_userpoints_paymentgw[40] = "Google Checkout";
	$admin_userpoints_paymentgw[41] = "Integration with google checkout";
	$admin_userpoints_paymentgw[42] = "Merchant ID:";
	$admin_userpoints_paymentgw[43] = "Merchant Key:";

	$admin_userpoints_paymentgw[50] = "Authorize.Net";
	$admin_userpoints_paymentgw[51] = "Integration with Authorize.Net payment gateway";
	$admin_userpoints_paymentgw[52] = "Login ID:";
	$admin_userpoints_paymentgw[53] = "Transaction Key:";
	
	$admin_userpoints_paymentgw[60] = "2CheckOut.com";
	$admin_userpoints_paymentgw[61] = "Integration with 2CO payment gateway";
	$admin_userpoints_paymentgw[62] = "Vendor ID:";
	$admin_userpoints_paymentgw[63] = "Secret Word:";
	
    
    break;
  
  
  case "admin_userpoints_offers":
	$admin_userpoints_offers[1] = "View Offers";
	$admin_userpoints_offers[2] = "This page lists all of the offers available for users. For more information about a specific offer, click on the \"edit\" link in its row. Use the filter fields to find specific offer based on your criteria. To view all offers, leave all the filter fields blank. ";
    $admin_userpoints_offers[3] = "Title";
    $admin_userpoints_offers[4] = "Type";
    $admin_userpoints_offers[5] = "Levels";
    $admin_userpoints_offers[6] = "Subnets";

    $admin_userpoints_offers[7] = "Views";
    $admin_userpoints_offers[8] = "Comments";
    
    $admin_userpoints_offers[9] = "Yes";
    $admin_userpoints_offers[10] = "No";
    $admin_userpoints_offers[11] = "edit";
    $admin_userpoints_offers[12] = "disable";

    $admin_userpoints_offers[13] = "Add date";

    $admin_userpoints_offers[14] = "Filter";

    $admin_userpoints_offers[15] = "delete";
    
	$admin_userpoints_offers[16] = "Offers Found";
	$admin_userpoints_offers[17] = "Page:";

	$admin_userpoints_offers[18] = "Delete User";
	$admin_userpoints_offers[19] = "Are you sure you want to delete this offer?";
	$admin_userpoints_offers[20] = "Cancel";
	$admin_userpoints_offers[21] = "No offers were found.";

	$admin_userpoints_offers[22] = "enable";

	$admin_userpoints_offers[23] = "Add New Offer";
	$admin_userpoints_offers[24] = "User Level";
	$admin_userpoints_offers[25] = "Subnetwork";
	$admin_userpoints_offers[26] = "Default";
    $admin_userpoints_offers[27] = "Disable Selected";

    $admin_userpoints_offers[28] = "Enabled";
    $admin_userpoints_offers[29] = "Options";

    $admin_userpoints_offers[30] = "Points Gain";

    $admin_userpoints_offers[31] = "Choose type:";

    $admin_userpoints_offers[32] = "Acts";

    
    break;
  

  case "admin_userpoints_shop":
	$admin_userpoints_shop[1] = "View Shop Items";
	$admin_userpoints_shop[2] = "This page lists all of the items available for users to purchase. For more information about a specific item, click on the \"edit\" link in its row. Use the filter fields to find specific item based on your criteria. To view all items, leave all the filter fields blank. ";
    $admin_userpoints_shop[3] = "Title";
    $admin_userpoints_shop[4] = "Type";
    $admin_userpoints_shop[5] = "Levels";
    $admin_userpoints_shop[6] = "Subnets";

    $admin_userpoints_shop[7] = "Views";
    $admin_userpoints_shop[8] = "Comments";
    


    $admin_userpoints_shop[9] = "Yes";
    $admin_userpoints_shop[10] = "No";
    $admin_userpoints_shop[11] = "edit";
    $admin_userpoints_shop[12] = "disable";

    $admin_userpoints_shop[13] = "Add date";

    $admin_userpoints_shop[14] = "Filter";

    $admin_userpoints_shop[15] = "delete";
    
	$admin_userpoints_shop[16] = "Items Found";
	$admin_userpoints_shop[17] = "Page:";

	$admin_userpoints_shop[18] = "Delete User";
	$admin_userpoints_shop[19] = "Are you sure you want to delete this offer?";
	$admin_userpoints_shop[20] = "Cancel";
	$admin_userpoints_shop[21] = "No offers were found.";

	$admin_userpoints_shop[22] = "enable";

	$admin_userpoints_shop[23] = "Add New Item";
	$admin_userpoints_shop[24] = "User Level";
	$admin_userpoints_shop[25] = "Subnetwork";
	$admin_userpoints_shop[26] = "Default";
    $admin_userpoints_shop[27] = "Disable Selected";

    $admin_userpoints_shop[28] = "Enabled";
    $admin_userpoints_shop[29] = "Options";

    $admin_userpoints_shop[30] = "Cost";
    $admin_userpoints_shop[31] = "Acts";
    
    $admin_userpoints_shop[32] = "Choose type:";
    
    
    break;
  

  case "admin_userpoints_shop_generic":
    $admin_userpoints_shop_generic[1] = "Add Shop Item - Generic";
    $admin_userpoints_shop_generic[2] = "Add Shop Item - Generic";
    $admin_userpoints_shop_generic[3] = "Title:";
    $admin_userpoints_shop_generic[4] = "Description:";
    $admin_userpoints_shop_generic[5] = "Redirect URL:";
    $admin_userpoints_shop_generic[6] = "Show in transactions?";
    $admin_userpoints_shop_generic[7] = "Transaction state:";
    $admin_userpoints_shop_generic[8] = "Cost:";

    $admin_userpoints_shop_generic[9] = "Save offer";
    $admin_userpoints_shop_generic[10] = "Cancel";
    $admin_userpoints_shop_generic[11] = "Enabled?";
    $admin_userpoints_shop_generic[12] = "Enabled";
    $admin_userpoints_shop_generic[13] = "Disabled";

    $admin_userpoints_shop_generic[14] = "User levels";
    $admin_userpoints_shop_generic[15] = "Subnets";

    $admin_userpoints_shop_generic[16] = "Tags:";
    $admin_userpoints_shop_generic[17] = "Allow comments?";
    
    $admin_userpoints_shop_generic[18] = "Completed";
    $admin_userpoints_shop_generic[19] = "Pending";
    
    $admin_userpoints_shop_generic[24] = "Yes";
    $admin_userpoints_shop_generic[25] = "No";
    $admin_userpoints_shop_generic[26] = "Changes saved.";

    $admin_userpoints_shop_generic[27] = "(signup default)";
    $admin_userpoints_shop_generic[28] = "Levels:";
    $admin_userpoints_shop_generic[29] = "Subnets:";
    $admin_userpoints_shop_generic[30] = "Select options";
    $admin_userpoints_shop_generic[31] = "Select all";

    $admin_userpoints_shop_generic[40] = "Edit offer";
    $admin_userpoints_shop_generic[41] = "Edit photo";
    $admin_userpoints_shop_generic[42] = "Edit comments";
    $admin_userpoints_shop_generic[43] = "Back to Listings";
    
    $admin_userpoints_shop_generic[45] = "Please enter title.";
    break;
  
  
  case "admin_userpoints_offers_generic":
    $admin_userpoints_offers_generic[1] = "Add Offer - Generic";
    $admin_userpoints_offers_generic[2] = "Add Offer - Generic";
    $admin_userpoints_offers_generic[3] = "Title:";
    $admin_userpoints_offers_generic[4] = "Description:";
    $admin_userpoints_offers_generic[5] = "Redirect URL:";
    $admin_userpoints_offers_generic[6] = "Show in transactions?";
    $admin_userpoints_offers_generic[7] = "Transaction state:";
    $admin_userpoints_offers_generic[8] = "Points:";

    $admin_userpoints_offers_generic[9] = "Save offer";
    $admin_userpoints_offers_generic[10] = "Cancel";
    $admin_userpoints_offers_generic[11] = "Enabled?"; 
    $admin_userpoints_offers_generic[13] = "Disabled";

    $admin_userpoints_offers_generic[14] = "User levels";
    $admin_userpoints_offers_generic[15] = "Subnets";

    $admin_userpoints_offers_generic[16] = "Tags:";
    $admin_userpoints_offers_generic[17] = "Allow comments?";

    $admin_userpoints_offers_generic[18] = "Completed";
    $admin_userpoints_offers_generic[19] = "Pending";
    
    $admin_userpoints_offers_generic[24] = "Yes";
    $admin_userpoints_offers_generic[25] = "No";
    $admin_userpoints_offers_generic[26] = "Changes saved.";

    $admin_userpoints_offers_generic[27] = "(signup default)";
    $admin_userpoints_offers_generic[28] = "Levels:";
    $admin_userpoints_offers_generic[29] = "Subnets:";
    $admin_userpoints_offers_generic[30] = "Select options";
    $admin_userpoints_offers_generic[31] = "Select all";

    $admin_userpoints_offers_generic[40] = "Edit offer";
    $admin_userpoints_offers_generic[41] = "Edit photo";
    $admin_userpoints_offers_generic[42] = "Edit comments";
    $admin_userpoints_offers_generic[43] = "Back to Listings";
    
    $admin_userpoints_offers_generic[45] = "Please enter title.";
    break;
  
  


  

  case "admin_userpoints_shop_levelupgrade":
    $admin_userpoints_shop_levelupgrade[1] = "Add Offer - Level Upgrade";
    $admin_userpoints_shop_levelupgrade[2] = "Add Offer - Level Upgrade";
    $admin_userpoints_shop_levelupgrade[3] = "Title:";
    $admin_userpoints_shop_levelupgrade[4] = "Description:";
    $admin_userpoints_shop_levelupgrade[5] = "Level from:";
    $admin_userpoints_shop_levelupgrade[6] = "Level to:";
    $admin_userpoints_shop_levelupgrade[7] = "Any";
    $admin_userpoints_shop_levelupgrade[8] = "Cost";

    $admin_userpoints_shop_levelupgrade[9] = "Save offer";
    $admin_userpoints_shop_levelupgrade[10] = "Cancel";
    $admin_userpoints_shop_levelupgrade[11] = "Enabled?";
    $admin_userpoints_shop_levelupgrade[12] = "Enabled";
    $admin_userpoints_shop_levelupgrade[13] = "Disabled";

    $admin_userpoints_shop_levelupgrade[14] = "User levels";
    $admin_userpoints_shop_levelupgrade[15] = "Subnets";

    $admin_userpoints_shop_levelupgrade[16] = "Tags:";
    $admin_userpoints_shop_levelupgrade[17] = "Allow comments?";
    
    $admin_userpoints_shop_levelupgrade[24] = "Yes";
    $admin_userpoints_shop_levelupgrade[25] = "No";
    $admin_userpoints_shop_levelupgrade[26] = "Changes saved.";

    $admin_userpoints_shop_levelupgrade[27] = "(signup default)";
    $admin_userpoints_shop_levelupgrade[28] = "Levels:";
    $admin_userpoints_shop_levelupgrade[29] = "Subnets:";
    $admin_userpoints_shop_levelupgrade[30] = "Select options";
    $admin_userpoints_shop_levelupgrade[31] = "Select all";

    $admin_userpoints_shop_levelupgrade[40] = "Edit offer";
    $admin_userpoints_shop_levelupgrade[41] = "Edit photo";
    $admin_userpoints_shop_levelupgrade[42] = "Edit comments";
    $admin_userpoints_shop_levelupgrade[43] = "Back to Listings";
    
    $admin_userpoints_shop_levelupgrade[45] = "Please enter title.";
    break;


  case "admin_userpoints_shop_promote":
    $admin_userpoints_shop_promote[1] = "Add Offer - Promotion";
    $admin_userpoints_shop_promote[2] = "Promotion allows your users to create ad campaigns on their content - profile, classified, event, group or poll.";
    $admin_userpoints_shop_promote[3] = "Title:";
    $admin_userpoints_shop_promote[4] = "Description:";

    $admin_userpoints_shop_promote[5] = "Level from:";
    $admin_userpoints_shop_promote[6] = "Level to:";
    $admin_userpoints_shop_promote[7] = "Any";

    $admin_userpoints_shop_promote[8] = "Cost";

    $admin_userpoints_shop_promote[9] = "Save offer";
    $admin_userpoints_shop_promote[10] = "Cancel";
    $admin_userpoints_shop_promote[11] = "Enabled?";
    $admin_userpoints_shop_promote[12] = "Enabled";
    $admin_userpoints_shop_promote[13] = "Disabled";

    $admin_userpoints_shop_promote[14] = "User levels";
    $admin_userpoints_shop_promote[15] = "Subnets";

    $admin_userpoints_shop_promote[16] = "Tags:";
    $admin_userpoints_shop_promote[17] = "Allow comments?";

    $admin_userpoints_shop_promote[18] = "(reset html)";

    $admin_userpoints_shop_promote[20] = "Promotion template:";
    $admin_userpoints_shop_promote[21] = "Promotion type:";
    $admin_userpoints_shop_promote[22] = "Ad html";
    $admin_userpoints_shop_promote[23] = "Require approval?";
    $admin_userpoints_shop_promote[24] = "Yes";
    $admin_userpoints_shop_promote[25] = "No";
    $admin_userpoints_shop_promote[26] = "Start";
    $admin_userpoints_shop_promote[27] = "Immediately";
    $admin_userpoints_shop_promote[28] = "Delay for one day";
    $admin_userpoints_shop_promote[29] = "Duration:";
    $admin_userpoints_shop_promote[30] = "day(s)";

    $admin_userpoints_shop_promote[31] = "(signup default)";
    $admin_userpoints_shop_promote[32] = "Levels:";
    $admin_userpoints_shop_promote[33] = "Subnets:";
    $admin_userpoints_shop_promote[34] = "Select options";
    $admin_userpoints_shop_promote[35] = "Select all";
    
    $admin_userpoints_shop_promote[39] = "Changes saved.";
    $admin_userpoints_shop_promote[40] = "Edit offer";
    $admin_userpoints_shop_promote[41] = "Edit photo";
    $admin_userpoints_shop_promote[42] = "Edit comments";
    $admin_userpoints_shop_promote[43] = "Back to Listings";
    
    $admin_userpoints_shop_promote[45] = "Please enter title.";
    $admin_userpoints_shop_promote[46] = "Please choose a promotion type.";
	
    $admin_userpoints_shop_promote[101] = "You don't have Classifieds plugin installed.";
    $admin_userpoints_shop_promote[102] = "You don't have Events plugin installed.";
    $admin_userpoints_shop_promote[103] = "You don't have Groups plugin installed.";
    $admin_userpoints_shop_promote[104] = "You don't have Polls plugin installed.";
    break;







  case "admin_userpoints_offers_votepoll":
    $admin_userpoints_offers_votepoll[1] = "Add Offer - Vote Poll";
    $admin_userpoints_offers_votepoll[2] = "Here you can pitch a specific poll for your users.";
    $admin_userpoints_offers_votepoll[3] = "Title:";
    $admin_userpoints_offers_votepoll[4] = "Description:";

    $admin_userpoints_offers_votepoll[5] = "Poll ID:";

    $admin_userpoints_offers_votepoll[7] = "Any";
    $admin_userpoints_offers_votepoll[8] = "Points:";

    $admin_userpoints_offers_votepoll[9] = "Save offer";
    $admin_userpoints_offers_votepoll[10] = "Cancel";
    $admin_userpoints_offers_votepoll[11] = "Enabled?";
    $admin_userpoints_offers_votepoll[12] = "Enabled";
    $admin_userpoints_offers_votepoll[13] = "Disabled";

    $admin_userpoints_offers_votepoll[14] = "User levels";
    $admin_userpoints_offers_votepoll[15] = "Subnets";

    $admin_userpoints_offers_votepoll[16] = "Tags:";
    $admin_userpoints_offers_votepoll[17] = "Allow comments?";

    $admin_userpoints_offers_votepoll[18] = "Points added:";
    $admin_userpoints_offers_votepoll[19] = "Immediately";
    $admin_userpoints_offers_votepoll[20] = "Require action";

    $admin_userpoints_offers_votepoll[21] = "This poll doesn't exist.";
    
    $admin_userpoints_offers_votepoll[24] = "Yes";
    $admin_userpoints_offers_votepoll[25] = "No";
    $admin_userpoints_offers_votepoll[26] = "Changes saved.";

    $admin_userpoints_offers_votepoll[27] = "(signup default)";
    $admin_userpoints_offers_votepoll[28] = "Levels:";
    $admin_userpoints_offers_votepoll[29] = "Subnets:";
    $admin_userpoints_offers_votepoll[30] = "Select options";
    $admin_userpoints_offers_votepoll[31] = "Select all";

    $admin_userpoints_offers_votepoll[32] = "You don't have polls plugin installed!";

    $admin_userpoints_offers_votepoll[40] = "Edit offer";
    $admin_userpoints_offers_votepoll[41] = "Edit photo";
    $admin_userpoints_offers_votepoll[42] = "Edit comments";
    $admin_userpoints_offers_votepoll[43] = "Back to Listings";

    $admin_userpoints_offers_votepoll[45] = "Please enter title.";

    break;


  case "admin_userpoints_offers_affiliate":
    $admin_userpoints_offers_affiliate[1] = "Add Offer - Affiliate";
    $admin_userpoints_offers_affiliate[2] = "This type of offer allows you to redirect a user to your affiliate, adding customer parameters such as user id, username or transaction id.";
    $admin_userpoints_offers_affiliate[3] = "Title:";
    $admin_userpoints_offers_affiliate[4] = "Description:";

    $admin_userpoints_offers_affiliate[5] = "Affiliate URL:";

    $admin_userpoints_offers_affiliate[7] = "Any";
    $admin_userpoints_offers_affiliate[8] = "Points:";

    $admin_userpoints_offers_affiliate[9] = "Save offer";
    $admin_userpoints_offers_affiliate[10] = "Cancel";
    $admin_userpoints_offers_affiliate[11] = "Enabled?";
    $admin_userpoints_offers_affiliate[12] = "Enabled";
    $admin_userpoints_offers_affiliate[13] = "Disabled";

    $admin_userpoints_offers_affiliate[14] = "User levels";
    $admin_userpoints_offers_affiliate[15] = "Subnets";

    $admin_userpoints_offers_affiliate[16] = "Tags:";
    $admin_userpoints_offers_affiliate[17] = "Allow comments?";

    $admin_userpoints_offers_affiliate[18] = "Points added:";
    $admin_userpoints_offers_affiliate[19] = "Immediately";
    $admin_userpoints_offers_affiliate[20] = "Require action";

    $admin_userpoints_offers_affiliate[21] = "This poll doesn't exist.";
    
    $admin_userpoints_offers_affiliate[24] = "Yes";
    $admin_userpoints_offers_affiliate[25] = "No";

    $admin_userpoints_offers_affiliate[26] = "Changes saved.";

    $admin_userpoints_offers_affiliate[27] = "(signup default)";
    $admin_userpoints_offers_affiliate[28] = "Levels:";
    $admin_userpoints_offers_affiliate[29] = "Subnets:";
    $admin_userpoints_offers_affiliate[30] = "Select options";
    $admin_userpoints_offers_affiliate[31] = "Select all";

    $admin_userpoints_offers_affiliate[32] = "(Available parameters: [userid], [username], [transactionid])";

    $admin_userpoints_offers_affiliate[40] = "Edit offer";
    $admin_userpoints_offers_affiliate[41] = "Edit photo";
    $admin_userpoints_offers_affiliate[42] = "Edit comments";
    $admin_userpoints_offers_affiliate[43] = "Back to Listings";

    $admin_userpoints_offers_affiliate[45] = "Please enter title.";
    
    
    break;


  case "admin_userpoints_offers_purchase":
    $admin_userpoints_offers_purchase[1] = "Add Offer - Direct purchase";
    $admin_userpoints_offers_purchase[2] = "Direct purchasing allows your members to exchange real money for points.";
    $admin_userpoints_offers_purchase[3] = "Title:";
    $admin_userpoints_offers_purchase[4] = "Description:";

    $admin_userpoints_offers_purchase[5] = "Payment Gateways:";

    $admin_userpoints_offers_purchase[7] = "Any";
    $admin_userpoints_offers_purchase[8] = "Points:";

    $admin_userpoints_offers_purchase[9] = "Save offer";
    $admin_userpoints_offers_purchase[10] = "Cancel";
    $admin_userpoints_offers_purchase[11] = "Enabled?";
    $admin_userpoints_offers_purchase[12] = "Enabled";
    $admin_userpoints_offers_purchase[13] = "Disabled";

    $admin_userpoints_offers_purchase[14] = "User levels";
    $admin_userpoints_offers_purchase[15] = "Subnets";

    $admin_userpoints_offers_purchase[16] = "Tags:";
    $admin_userpoints_offers_purchase[17] = "Allow comments?";

    $admin_userpoints_offers_purchase[18] = "Points added:";
    $admin_userpoints_offers_purchase[19] = "Immediately";
    $admin_userpoints_offers_purchase[20] = "Require action";

    $admin_userpoints_offers_purchase[21] = "This poll doesn't exist.";
    
    $admin_userpoints_offers_purchase[24] = "Yes";
    $admin_userpoints_offers_purchase[25] = "No";

    $admin_userpoints_offers_purchase[26] = "Changes saved.";
    $admin_userpoints_offers_purchase[27] = "(signup default)";
    $admin_userpoints_offers_purchase[28] = "Levels:";
    $admin_userpoints_offers_purchase[29] = "Subnets:";
    $admin_userpoints_offers_purchase[30] = "Select options";
    $admin_userpoints_offers_purchase[31] = "Select all";

    $admin_userpoints_offers_purchase[40] = "Edit offer";
    $admin_userpoints_offers_purchase[41] = "Edit photo";
    $admin_userpoints_offers_purchase[42] = "Edit comments";
    $admin_userpoints_offers_purchase[43] = "Back to Listings";

    $admin_userpoints_offers_purchase[45] = "Please enter title.";
    
    break;



  case "admin_userpoints_offerphoto":
    $admin_userpoints_offerphoto[1] = "Edit offer photo";
    $admin_userpoints_offerphoto[2] = "Edit offer photo";

    $admin_userpoints_offerphoto[3] = "Current photo:";
    $admin_userpoints_offerphoto[4] = "Replace photo with:";
    $admin_userpoints_offerphoto[5] = "Upload";
    $admin_userpoints_offerphoto[6] = "Cancel";

    $admin_userpoints_offerphoto[40] = "Edit offer";
    $admin_userpoints_offerphoto[41] = "Edit photo";
    $admin_userpoints_offerphoto[42] = "Edit comments";
    $admin_userpoints_offerphoto[43] = "Back to Listings";


  break;


  case "admin_userpoints_shopphoto":
    $admin_userpoints_shopphoto[1] = "Edit offer photo";
    $admin_userpoints_shopphoto[2] = "Edit offer photo";

    $admin_userpoints_shopphoto[3] = "Current photo:";
    $admin_userpoints_shopphoto[4] = "Replace photo with:";
    $admin_userpoints_shopphoto[5] = "Upload";
    $admin_userpoints_shopphoto[6] = "Cancel";

    $admin_userpoints_shopphoto[40] = "Edit offer";
    $admin_userpoints_shopphoto[41] = "Edit photo";
    $admin_userpoints_shopphoto[42] = "Edit comments";
    $admin_userpoints_shopphoto[43] = "Back to Listings";


  break;


  case "admin_userpoints_offercomments":
    $admin_userpoints_offercomments[1] = "Edit offer comments";
    $admin_userpoints_offercomments[2] = "Edit offer comments";
	$admin_userpoints_offercomments[3] = "\o\\n";  //THESE CHARACTERS ARE BEING ESCAPED BECAUSE THEY ARE BEING USED IN A DATE FUNCTION


	$admin_userpoints_offercomments[8] = "select all comments";
	$admin_userpoints_offercomments[9] = "Last Page";
	$admin_userpoints_offercomments[10] = "showing comment";
	$admin_userpoints_offercomments[11] = "of";
	$admin_userpoints_offercomments[12] = "showing comments";
	$admin_userpoints_offercomments[13] = "Next Page";
	$admin_userpoints_offercomments[14] = "No comments have been posted.";
	$admin_userpoints_offercomments[15] = "Anonymous";
  	$admin_userpoints_offercomments[16] = "Delete Selected";

    $admin_userpoints_offercomments[40] = "Edit offer";
    $admin_userpoints_offercomments[41] = "Edit photo";
    $admin_userpoints_offercomments[42] = "Edit comments";
    $admin_userpoints_offercomments[43] = "Back to Listings";


  break;


  case "admin_userpoints_shopcomments":
    $admin_userpoints_shopcomments[1] = "Edit offer comments";
    $admin_userpoints_shopcomments[2] = "Edit offer comments";
	$admin_userpoints_shopcomments[3] = "\o\\n";  //THESE CHARACTERS ARE BEING ESCAPED BECAUSE THEY ARE BEING USED IN A DATE FUNCTION


	$admin_userpoints_shopcomments[8] = "select all comments";
	$admin_userpoints_shopcomments[9] = "Last Page";
	$admin_userpoints_shopcomments[10] = "showing comment";
	$admin_userpoints_shopcomments[11] = "of";
	$admin_userpoints_shopcomments[12] = "showing comments";
	$admin_userpoints_shopcomments[13] = "Next Page";
	$admin_userpoints_shopcomments[14] = "No comments have been posted.";
	$admin_userpoints_shopcomments[15] = "Anonymous";
  	$admin_userpoints_shopcomments[16] = "Delete Selected";

    $admin_userpoints_shopcomments[40] = "Edit offer";
    $admin_userpoints_shopcomments[41] = "Edit photo";
    $admin_userpoints_shopcomments[42] = "Edit comments";
    $admin_userpoints_shopcomments[43] = "Back to Listings";


  break;






  case "admin_userpoints_assign":
	$admin_userpoints_assign[1] = "Assign Activity Points";
	$admin_userpoints_assign[2] = "This page allows assigning various activity points. You can limit maximum amount of accumulated points for a designated period (\"Rollover period\"). Enter 0 for \"Max\" field to disable limiting. Enter 0 for \"Rollover period\" field to make it an all time cap.";
	$admin_userpoints_assign[3] = "Action Name";
	$admin_userpoints_assign[4] = "Points";
	$admin_userpoints_assign[5] = "Save Changes";
	$admin_userpoints_assign[6] = "You changes have been saved";
	$admin_userpoints_assign[7] = "Requires ";
	$admin_userpoints_assign[8] = "Max";
	$admin_userpoints_assign[9] = "Rollover period";
	$admin_userpoints_assign[10] = "day(s)";

/*
	$admin_userpoints_assign[] = "";
*/
	break;

  case "admin_userpoints_viewusers":
	$admin_userpoints_viewusers[1] = "View Users";
	$admin_userpoints_viewusers[2] = "This page lists all of the users that exist on your social network together with ther points information. For more information about a specific user, click on the \"edit\" link in its row. Use the filter fields to find specific users based on your criteria. To view all users on your system, leave all the filter fields blank. ";
	$admin_userpoints_viewusers[3] = "Username";
	$admin_userpoints_viewusers[4] = "unverified";
	$admin_userpoints_viewusers[5] = "Email";
	$admin_userpoints_viewusers[6] = "Enabled";
	$admin_userpoints_viewusers[7] = "Signup Date";
	$admin_userpoints_viewusers[8] = "Options ";
	$admin_userpoints_viewusers[9] = "Yes";
	$admin_userpoints_viewusers[10] = "No";
    
	$admin_userpoints_viewusers[11] = "edit";
	$admin_userpoints_viewusers[12] = "for him";
	$admin_userpoints_viewusers[13] = "by him";

	$admin_userpoints_viewusers[14] = "Filter";
	$admin_userpoints_viewusers[15] = "ID";
	$admin_userpoints_viewusers[16] = "Users Found";
	$admin_userpoints_viewusers[17] = "Page:";

	$admin_userpoints_viewusers[18] = "Points";
	$admin_userpoints_viewusers[19] = "Cumulative";

	$admin_userpoints_viewusers[20] = "IP Address";
    
	$admin_userpoints_viewusers[21] = "No users were found.";

	$admin_userpoints_viewusers[22] = "Clear all votes";
	$admin_userpoints_viewusers[23] = "Are you sure you want to clear all votes?";

	$admin_userpoints_viewusers[24] = "User Level";
	$admin_userpoints_viewusers[25] = "Subnetwork";
	$admin_userpoints_viewusers[26] = "Default";

	$admin_userpoints_viewusers[27] = "Signup IP Address";


/*
	$admin_userpoints_viewusers[] = "";
*/
	break;

  case "admin_userpoints_transactions":
	$admin_userpoints_transactions[1] = "Transactions";
	$admin_userpoints_transactions[2] = "View users' points transactions.";
	$admin_userpoints_transactions[3] = "Username";
	$admin_userpoints_transactions[4] = "Transaction status:";
	$admin_userpoints_transactions[5] = "No transaction found.";
	$admin_userpoints_transactions[6] = "Description";

	$admin_userpoints_transactions[9] = "Yes";
	$admin_userpoints_transactions[10] = "No";

	$admin_userpoints_transactions[14] = "Filter";
	$admin_userpoints_transactions[15] = "ID";
	$admin_userpoints_transactions[16] = "Transactions Found";
	$admin_userpoints_transactions[17] = "Page:";

	$admin_userpoints_transactions[18] = "User";
	$admin_userpoints_transactions[19] = "Date";
	$admin_userpoints_transactions[20] = "Description";
	$admin_userpoints_transactions[21] = "Status";
	$admin_userpoints_transactions[22] = "Amount";

	$admin_userpoints_transactions[23] = "TID";


	$admin_userpoints_transactions[24] = "User Level";
	$admin_userpoints_transactions[25] = "Subnetwork";
	$admin_userpoints_transactions[26] = "Default";

	$admin_userpoints_transactions[27] = "confirm";
	$admin_userpoints_transactions[28] = "cancel";
	
	break;
	

  case "admin_userpoints_viewusers_edit":
	$admin_userpoints_viewusers_edit[1] = "Edit User:";
	$admin_userpoints_viewusers_edit[2] = "To edit this users's account, make changes to the form below. If you want to temporarily prevent this user from logging in, you can set the user account to \"disabled\" below.";
    $admin_userpoints_viewusers_edit[3] = "Total points accumulated:";
    $admin_userpoints_viewusers_edit[4] = "Total points spent:";
	$admin_userpoints_viewusers_edit[5] = "Points:";

	$admin_userpoints_viewusers_edit[6] = "Save Changes";
	$admin_userpoints_viewusers_edit[7] = "Cancel";

	$admin_userpoints_viewusers_edit[8] = "Username";
	$admin_userpoints_viewusers_edit[9] = "Date";
	$admin_userpoints_viewusers_edit[10] = "IP Address";
	$admin_userpoints_viewusers_edit[11] = "Allow points?";

	$admin_userpoints_viewusers_edit[13] = "Last Page";
	$admin_userpoints_viewusers_edit[14] = "viewing friend";
	$admin_userpoints_viewusers_edit[15] = "viewing friends";
	$admin_userpoints_viewusers_edit[16] = "of";
	$admin_userpoints_viewusers_edit[17] = "Next Page";

	$admin_userpoints_viewusers_edit[18] = "Yes";
	$admin_userpoints_viewusers_edit[19] = "No";

	$admin_userpoints_viewusers_edit[20] = "edit";

    //$admin_userpoints_viewusers_edit[] = "";
	break;


  case "admin_userpoints_give":
	$admin_userpoints_give[1] = "Give Points:";
	$admin_userpoints_give[2] = "Give Points to all users / group / user.";
	$admin_userpoints_give[3] = "Points successfully given!";
	$admin_userpoints_give[4] = "Give Points";
	$admin_userpoints_give[5] = "Give to:";
	$admin_userpoints_give[6] = "Subject";
	$admin_userpoints_give[7] = "Message";
	$admin_userpoints_give[8] = "Give Points";
	$admin_userpoints_give[9] = "Also send message";
	
	$admin_userpoints_give[10] = "More points!";
	$admin_userpoints_give[11] = "Hi,\n\nI decided to give your more points.\n\nEnjoy!";
	$admin_userpoints_give[12] = "That user doesn't exist.";
	$admin_userpoints_give[13] = "(You can also enter negative amount)";
	//$admin_userpoints_give[] = "";

	break;


  case "admin_levels_userpointssettings":
    $admin_levels_userpointssettings[1] = "Activity Points Settings";
    $admin_levels_userpointssettings[2] = "If you have allowed users to have activity points, you can adjust the details from this page.";
    $admin_levels_userpointssettings[3] = "Allow Activity Points?";
    $admin_levels_userpointssettings[4] = "Do you want to let users have gain points for activities? If set to no, all other settings on this page will not apply.";
    $admin_levels_userpointssettings[5] = "Yes, allow Activity Points.";
    $admin_levels_userpointssettings[6] = "No, do not allow Activity Points.";

    $admin_levels_userpointssettings[7] = "Allow Points Transfer?";
    $admin_levels_userpointssettings[8] = "Do you want to allow users transfer points between themselves? Note: This will limit the SENDER, but not the receiver, (if they are on different levels with different limitation settings).";
    $admin_levels_userpointssettings[9] = "Yes, allow Points Transfer.";
    $admin_levels_userpointssettings[10] = "No, do not allow Points Transfer.";
    $admin_levels_userpointssettings[11] = "You can also limit maximum points transferred per day.";
    $admin_levels_userpointssettings[12] = "Maximum points:";
    $admin_levels_userpointssettings[13] = "(enter 0 to allow unlimited transfers)";

	$admin_levels_userpointssettings[14] = "Save Changes";
	$admin_levels_userpointssettings[15] = "Your changes have been saved.";

	$admin_levels_userpointssettings[35] = "Editing User Level:";
	$admin_levels_userpointssettings[36] = "You are currently editing this user level's settings. Remember, these settings only apply to the users that belong to this user level. When you're finished, you can edit the <a href='admin_levels.php'>other levels here</a>.";

	break;






  
  /*** USER PAGES ***/




  case "user_points_shop_item":

	$user_points_shop_item[3] = "Kosten:";
	$user_points_shop_item[4] = "Ansicht(en)";
	$user_points_shop_item[5] = "Kommentar(e)";
	$user_points_shop_item[6] = "Abgegeben am";
	$user_points_shop_item[7] = "Zurück zum Shopverzeichnis";

	$user_points_shop_item[8] = "Kommentare";
	$user_points_shop_item[11] = "Anonym";
	$user_points_shop_item[13] = "Es ist ein Fehler aufgetreten";
	$user_points_shop_item[14] = "Schreib etwas...";
	$user_points_shop_item[15] = "Senden...";
	$user_points_shop_item[16] = "Bitte gib eine Nachricht ein.";
	$user_points_shop_item[17] = "Du hast einen falschen Sicherheitscode eingegeben.";
	$user_points_shop_item[18] = "Kommentar abgeben";
	$user_points_shop_item[19] = "Gib die Zahlen, die Du im Bild rechts siehts bitte in das Feld ein. Das hilft uns die Seite spamfrei zu halten.";
	$user_points_shop_item[20] = "Nachricht";

	$user_points_shop_item[21] = "Punkte.";
    
    break;
  

  case "user_points_offers_item":

	$user_points_offers_item[3] = "Erhaltene Punkte:";
	$user_points_offers_item[4] = "Ansicht(en)";
	$user_points_offers_item[5] = "Kommentar(e)";
	$user_points_offers_item[6] = "Abgegeben am";
	$user_points_offers_item[7] = "Zurück zum Shopverzeichnis";

	$user_points_offers_item[8] = "Kommentare";
	$user_points_offers_item[11] = "Anonym";
	$user_points_offers_item[13] = "Es ist ein Fehler aufgetreten";
	$user_points_offers_item[14] = "Schreib etwas...";
	$user_points_offers_item[15] = "Senden...";
	$user_points_offers_item[16] = "Bitte gib eine Nachricht ein.";
	$user_points_offers_item[17] = "Du hast einen falschen Sicherheitscode eingegeben.";
	$user_points_offers_item[18] = "Kommentar abgeben";
	$user_points_offers_item[19] = "Gib die Zahlen, die Du im Bild rechts siehts bitte in das Feld ein. Das hilft uns die Seite spamfrei zu halten.";
	$user_points_offers_item[20] = "Nachricht";

	$user_points_offers_item[21] = "Punkte.";
	$user_points_offers_item[22] = "Dein Kauf war erfolgreich.";
    
    break;
  

  case "user_points_transactions":
	$user_points_transactions[1] = "Mein Punkteschatule";
	$user_points_transactions[2] = "Transaktionsgeschichte";
	$user_points_transactions[3] = "Punkte verdienen";
	$user_points_transactions[4] = "Punkte einlösen";
	$user_points_transactions[5] = "FAQ";

	$user_points_transactions[10] = "Meine Transaktionen";
	$user_points_transactions[11] = "Diese Transaktionsgeschichte beinhaltet nicht die Punkte, die durch Aktivitäten wie etwa das Abgeben von Kommentaren, Erstellen von Gruppen, usw. generiert werden.";
	$user_points_transactions[12] = "Durchsuche Transaktionen nach:";


	$user_points_transactions[15] = "Vorhergehende Seite";
	$user_points_transactions[16] = "Zeige Transaktion";
	$user_points_transactions[17] = "von";
	$user_points_transactions[18] = "Zeige Transaktionen";
	$user_points_transactions[19] = "Nächste Seite";
	$user_points_transactions[20] = "Es wurden keine Ergebnisse zu Deiner Suchanfrage gefunden.";
	$user_points_transactions[21] = "Du hast keine Transaktionen getätigt.";

	$user_points_transactions[22] = "Datum";
	$user_points_transactions[23] = "Beschreibung";
	$user_points_transactions[24] = "Status";
	$user_points_transactions[25] = "Betrag";
	$user_points_transactions[] = "";

    break;
  
  
  case "user_vault":
	$user_vault[1] = "Meine Punkteschatule";
	$user_vault[2] = "Transaktionsgeschichte";
	$user_vault[3] = "Punkte verdienen";
	$user_vault[4] = "Punkte einlösen";
	$user_vault[5] = "FAQ";
	
	$user_vault[10] = "Meine Transaktionen";
	$user_vault[11] = "Dies ist eine Zusammenfassung Deines Accounts. Sie beinhaltet alle bisher gesammelten Punkte und den aktuellen Punktestand.";
	$user_vault[12] = "Du hast ";
	$user_vault[13] = "Punkte";
	$user_vault[14] = "Sende Punkte an einen Freund";
	$user_vault[15] = "Empfänger:";
	$user_vault[16] = "Betrag:";
	$user_vault[17] = "Beginne den Namen eines Feundes zu tippen...";
	$user_vault[18] = "Keine Freunde gefunden";
	$user_vault[19] = "Gib den Namen Deines Freundes ein";
	$user_vault[20] = "Senden";
/*
	$user_vault[21] = "Du hast nicht ausreichend viele Punkte.";
	$user_vault[22] = "Bitte gib einen betrag grösser 0 ein.";
	$user_vault[23] = "Empfänger existiert nicht oder kann keine Punkte akzeptieren.";
	$user_vault[24] = "Punkte wurden erfolgreich übertragen.";
*/
	$user_vault[25] = "Insgeamt bisher angehäuft:";
	$user_vault[26] = "Du bist damit auf Rang ";
	$user_vault[27] = "von";
	$user_vault[28] = "Sende...";

	$user_vault[29] = "AKTUELLES GUTHABEN";
	$user_vault[30] = "INSGESAMT VERDIENTE PUNKTE";
	$user_vault[31] = "STAR RATING";
	$user_vault[32] = "Platz";
	$user_vault[33] = "Nicht eingestuft";

//	$user_vault[34] = "Du kannst keine Punkte übertragen.";
//	$user_vault[15] = "";

	
    break;
  
  case "profile":
	$profile[600] = "Meine Aktivitätspunkte";
	$profile[601] = "Mein Ranking:";
	$profile[602] = "Ich habe";
	$profile[603] = "Punkte.";
	$profile[604] = "Verdient habe ich bisher insgesamt ";
  	$profile[605] = "Meine Einstufung ist: ";
  	$profile[606] = "Nicht eingestuft";
    break;
  

  case "user_home":
	$user_home[600] = "Meine Aktivitätspunkte";
	$user_home[601] = "Mein Ranking:";
	$user_home[602] = "Ich habe";
	$user_home[603] = "Punkte.";
	$user_home[604] = "Verdient habe ich bisher insgesamt ";
  	$user_home[605] = "Meine Einstufung ist: ";
  	$user_home[606] = "Nicht eingestuft";
  	$user_home[607] = "Mehr verdienen";
  	$user_home[608] = "Einlösen";
    break;
  
  
  case "user_points_faq":
	
	$user_points_faq[1] = "Meine Punkteschatule";
	$user_points_faq[2] = "Transaktionsgeschichte";
	$user_points_faq[3] = "Punkte verdienen";
	$user_points_faq[4] = "Punkte einlösen";
	$user_points_faq[5] = "FAQ";

	
	$user_points_faq[8] = "Punkte - Fragen und Antworten";
	$user_points_faq[9] = "Wenn Du Hilfe zum Thema Punkte brauchst, kannst Du sie wahrscheinlich hier bekommen.";
	
	$user_points_faq[10] = "Punkte verdienen";
	$user_points_faq[11] = "Wie verdiene ich Punkte?";
	$user_points_faq[12] = "Punkte erhälst Du für verschiedenste Aktivitäten auf der Seite, beispielsweise fürs <a href='invite.php'>Werben von Freunden</a>, fürs Hochladen Deines <a href='user_editprofile_photo.php'>Profilfotos</a>, fürs Erstellen von Gruppen, usw. Du kannst Punkte auch durch Teilnahme an unseren <a href='user_points_offers.php'>Angeboten</a> erhalten.";
	$user_points_faq[13] = "Welche Aktivitäten werden mit Punkten honoriert?";
	$user_points_faq[14] = "Die folgende Liste zeigt die Aktivitäten, die mit Punkten belohnt werden. Aktivitäten können mit Limits versehen sein, die nach der \"Reset Periode\" zurückgesetzt werden";
	$user_points_faq[15] = "Altivität";
	$user_points_faq[16] = "Punkte";
	$user_points_faq[17] = "Maximum";
	$user_points_faq[18] = "Reset Periode";
	$user_points_faq[19] = "Tag(e)";
	$user_points_faq[20] = "Unlimitiert";
	$user_points_faq[21] = "Niemals";

	$user_points_faq[50] = "Punkte ausgeben";
	$user_points_faq[51] = "Wie kann ich Punkte einlösen?";
	$user_points_faq[52] = "Im <a href='user_points_shop.php'>Punkte Shop</a> findest Du verschieden Möglichkeiten Deine Punkte einzulösen.";

	break;
	

  case "user_points_offers":
	
	$user_points_offers[1] = "Meine Punkteschatule";
	$user_points_offers[2] = "Transaktionsgeschichte";
	$user_points_offers[3] = "Punkte verdienen";
	$user_points_offers[4] = "Punkte einlösen";
	$user_points_offers[5] = "FAQ";

	$user_points_offers[6] = "Vorhergehende Seite";
	$user_points_offers[7] = "Zeige Angebote";
	$user_points_offers[8] = "von";
	$user_points_offers[9] = "Zeige Angebote";
	$user_points_offers[10] = "Nächste Seite";

	$user_points_offers[11] = "Angebote";
	$user_points_offers[12] = "Hier kannst Du sehen wie Du Punkte verdienen kannst.";
	$user_points_offers[13] = "Durchsuche alle Angebote";
    $user_points_offers[14] = "Gepostet am";
    $user_points_offers[15] = "Ansichten";
    $user_points_offers[16] = "Kommentare";
    $user_points_offers[17] = "Tag Wolke";

	$user_points_offers[20] = "Es wurden keine Ergebnisse für Deinen Suchausdruck gefunden.";
	$user_points_offers[21] = "Es gibt im Moment keine Angebote.";

	break;


  case "user_points_shop":
	
	$user_points_shop[1] = "Meine Punkteschatule";
	$user_points_shop[2] = "Transaktionsgeschichte";
	$user_points_shop[3] = "Punkte verdienen";
	$user_points_shop[4] = "Punkte einlösen";
	$user_points_shop[5] = "FAQ";

	$user_points_shop[6] = "Vorhergehende Seite";
	$user_points_shop[7] = "Zeige Angebote";
	$user_points_shop[8] = "von";
	$user_points_shop[9] = "Zeige Angebote";
	$user_points_shop[10] = "Nächste Seite";
    
	$user_points_shop[11] = "Shop";
	$user_points_shop[12] = "Hier findest Du Möglichkeiten Deine gesammelten Punkte auszugeben.";
	$user_points_shop[13] = "Durchsuche alle Angebote";
	$user_points_shop[14] = "Geposted am";
	$user_points_shop[15] = "Ansichten";
	$user_points_shop[16] = "Kommentare";
	$user_points_shop[17] = "Tag Wolke";

	$user_points_shop[20] = "Es wurden keine Ergebnisse für Deinen Suchausdruck gefunden.";
	$user_points_shop[21] = "Es gibt im Moment keine Angebote.";

	break;
  
  
  case "user_points_shop_item_promote":
    $user_points_shop_item_promote[1] = "Bitte wähle Deine Anzeige:";
    $user_points_shop_item_promote[2] = "Bitte wähle Dein Event:";
    $user_points_shop_item_promote[3] = "Bitte wähle Deine Gruppe:";
    $user_points_shop_item_promote[4] = "Bitte wähle Deine Umfrage:";
    $user_points_shop_item_promote[5] = "Weiter";
    break;


  case "user_points_offers_item_purchase":
    $user_points_offers_item_purchase[10] = "Du kaufst";
    $user_points_offers_item_purchase[11] = "Du erhälst Deine Punkte nachdem die Transaktion abeschlossen und bestätigt ist.";
    $user_points_offers_item_purchase[12] = "Produkt";
    $user_points_offers_item_purchase[13] = "Preis";
    $user_points_offers_item_purchase[14] = "Gesamt";
    $user_points_offers_item_purchase[15] = "Du kannst via folgenden Services bezahlen:";
    $user_points_offers_item_purchase[11] = "Du erhälst Deine Punkte nachdem die Transaktion abeschlossen und bestätigt ist.";
    break;
  
  
  case "topusers":
    $topusers[1] = "Unsere All Time Stars";
    $topusers[2] = "Verdiente Gesamtpunkte:";
    $topusers[3] = "Eine Anleitung zum Ruhm";
    $topusers[4] = "Du kannst Punkte verdienen durch";
    $topusers[5] = "Fotouploads";
    $topusers[6] = "Abgabe von Kommentaren (Spam wird bestraft und führt zu Punktabzug!)";
    $topusers[7] = "Einladen Deiner Freunde ins Netzwerk";
    $topusers[8] = "Erstellen von Gruppen";
    $topusers[9] = "(Spam Kontrolle aktiv)";
    $topusers[10] = "Markieren Deiner Freunde auf Bildern";
    $topusers[11] = "Und viele andere Aktionen (Zeig sie mir)";

    break;
  

  case "home":
    $home[600] = "Top Benutzer";
    $home[601] = "Punkte";
    $home[602] = "Bisher ist noch niemand auf den Thron gestiegen.";
    
    break;
  
  

}


// ASSIGN ALL SMARTY VARIABLES
if(is_array(${"$page"})) {
  reset(${"$page"});
  while(list($key, $val) = each(${"$page"})) {
    $smarty->assign($page.$key, $val);
  }
}

?>
