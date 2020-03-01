<?

//  THIS CLASS IS USED TO OUTPUT AND UPDATE RECENT ACTIVITY ACTIONS
//  METHODS IN THIS CLASS:
//  class se_actionsex




/******************  CLASS se_actionsex  ******************/


class se_actionsex extends se_actions {

    // actions_add hook
    function actions_add($user, $actiontype_name, $search = "", $replace = "", $timeframe = 0) {

    /* ASSIGN ACTIVITY POINTS */

        if(semods::get_setting('userpoints_enable_activitypoints') && $user->level_info['level_userpoints_allow'] && $user->user_info['user_userpoints_allowed']) {
    

        // TBD - special treatments,
        // "newmedia" - updated in footer, because need to count amount of uploaded files
         $excluded_actions = array( "newmedia" );

         if(!in_array($actiontype_name, $excluded_actions))
            userpoints_update_points( $user->user_info['user_id'], $actiontype_name );




    /* CHARGING FOR ACTIONS */

    // this is hacky. TBD: generic mechanism?

    $chargeable_actiontypes = array( 'postclassified'   =>  1,
                                     'newevent'         =>  2,
                                     'newgroup'         =>  3,
                                     'newpoll'          =>  4 );

    if(array_key_exists($actiontype_name, $chargeable_actiontypes)) {
        if(semods::get_setting('userpoints_charge_' . $actiontype_name)) {
            $upspender = new semods_upspender( $chargeable_actiontypes[$actiontype_name] );
            $upspender->transact( $user );
        }
    }




    /* CUSTOM REWARDABLE ACTIONS */

    if( $actiontype_name == "votepoll") {
        // poll id is #1 in array
        // owner_username is #3 in array
        userpoints_reward_votepoll( $replace[1] );
    }



        }   // IF ALLOWED USER POINTS
        

     /* CALL PARENTS */

     return parent::actions_add( $user, $actiontype_name, $search, $replace, $timeframe );


    } // END actions_add() METHOD


}

?>