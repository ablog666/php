<?

//  THIS CLASS IS USED TO OUTPUT AND UPDATE RECENT ACTIVITY ACTIONS
//  METHODS IN THIS CLASS:
//  class semods_uporder
//  class semods_upearner
//  class semods_upspender





/******************  CLASS semods_uporder  ******************/




class semods_uporder {
    
    var $uporder_exists = 0;
    var $uporder_info;
    
    function semods_uporder( $order_hash ) {
        if(!preg_match('/^[A-Fa-f0-9]{32}$/',$order_hash))
            return;
        $this->uporder_info = semods::db_query_assoc("SELECT * FROM se_semods_uporders WHERE uporder_hash = '$order_hash'");
        if($this->uporder_info) {
            $this->uporder_exists = 1;
        }
        
    }
    
    function is_completed() {
        return $this->uporder_info['uporder_state'] == 0;
    }
    
    function complete() {
        global $database;
        
        $database->database_query("UPDATE se_semods_uporders SET uporder_state = 0 WHERE uporder_id = " . $this->uporder_info['uporder_id'] ).
        $this->uporder_info['uporder_state'] = 0;
    }
}





/******************  CLASS semods_uptransaction  ******************/




class semods_uptransaction {
    
    var $uptransaction_exists = 0;
    var $uptransaction_info;
    
    function semods_uptransaction( $transaction_id ) {
        
        $this->uptransaction_info = semods::db_query_assoc("SELECT * FROM se_semods_uptransactions WHERE uptransaction_id = $transaction_id");
        if($this->uptransaction_info) {
            $this->uptransaction_exists = 1;
        }
        
    }
    
    function is_completed() {
        return $this->uptransaction_info['uptransaction_state'] == 0;
    }
    
    function complete() {
        global $database;
        
        if(($this->uptransaction_exists == 0) || $this->is_completed() )
            return false;
        
        $database->database_query("UPDATE se_semods_uptransactions SET uptransaction_state = 0 WHERE uptransaction_id = {$this->uptransaction_info['uptransaction_id']}");
        
        // FINISH TRANSACTION - REWARD USER IF "EARNER", DO NOTHING IF "SPENDER"
        // TBD: if user was deleted - junk row

        if($this->uptransaction_info['uptransaction_cat'] == 1)  {
            userpoints_add( $this->uptransaction_info['uptransaction_user_id'], $this->uptransaction_info['uptransaction_amount'] );
        }
        
        $this->uptransaction_info['uptransaction_state'] = 0;
        
        return true;
    }
    
    function cancel() {
        global $database;

        if(($this->uptransaction_exists == 0) || $this->is_completed() )
            return false;

        $database->database_query("UPDATE se_semods_uptransactions SET uptransaction_state = 2 WHERE uptransaction_id = {$this->uptransaction_info['uptransaction_id']}");

        // REFUND POINTS IF "SPENDER", DO NOTHING IF "EARNER"
        if($this->uptransaction_info['uptransaction_cat'] == 2)  {
            userpoints_add( $this->uptransaction_info['uptransaction_user_id'],
                            abs($this->uptransaction_info['uptransaction_amount']),
                            false // do not update "total earned"
                            );
        }

        $this->uptransaction_info['uptransaction_state'] = 2;

        return true;
    }
    
}




/******************  CLASS semods_upearner  ******************/




class semods_upearner {

    
    var $upearner_exists = 0;
    var $upearner_info;
    
    var $err_msg;
    
    var $transaction_message;

    function semods_upearner( $upearner_id, $onlyenabled = true ) {

        if($onlyenabled) 
            $this->upearner_info = semods::db_query_assoc("SELECT * FROM se_semods_userpointearner E LEFT JOIN se_semods_userpointearnertypes T ON E.userpointearner_type = T.userpointearnertype_type WHERE E.userpointearner_enabled != 0 AND E.userpointearner_id = $upearner_id");
        else
            $this->upearner_info = semods::db_query_assoc("SELECT * FROM se_semods_userpointearner E LEFT JOIN se_semods_userpointearnertypes T ON E.userpointearner_type = T.userpointearnertype_type WHERE E.userpointearner_id = $upearner_id");
    
        if($this->upearner_info) {
            $this->upearner_exists = 1;

            if(empty($this->upearner_info['userpointearner_photo'])) {
              $this->upearner_info['userpointearner_photo'] = './images/nophoto.gif';
            }
            
        }
    }
    
    function factory($item_id) {
        
    }
    
    
    function delete() {
        global $database;
        
        if($this->upearner_exists == 0)
            return;
        
        $database->database_query("DELETE FROM se_semods_userpointearner WHERE userpointearner_id = " . $this->upearner_info['userpointearner_id'] );
    }
    
    function enable($enabled=true) {
        global $database;
        
        if($this->upearner_exists == 0)
            return;
        
        // bool -> int
        $enabled = intval($enabled);
        
        $database->database_query("UPDATE se_semods_userpointearner SET userpointearner_enabled = $enabled WHERE userpointearner_id = " . $this->upearner_info['userpointearner_id'] );
    }

    function total_items( $onlyenabled = true, $where = '' ) {
        if($onlyenabled)
            return semods::db_query_count( "SELECT COUNT(*) FROM se_semods_userpointearner WHERE userpointearner_type >= 100 AND userpointearner_enabled != 0" );
        else
            return semods::db_query_count( "SELECT COUNT(*) FROM se_semods_userpointearner WHERE userpointearner_type >= 100" );
    }

    

    function transact($user, $transaction_params = array() ) {
        global $database, $functions_userpoints;
        
        if(!file_exists("include/functions_userpoints_{$this->upearner_info['userpointearnertype_name']}.php")) {
            $this->err_msg = $functions_userpoints[21];
            return false;
        }
        
        include_once "include/functions_userpoints_{$this->upearner_info['userpointearnertype_name']}.php";
        
        
        /** BEFORE TRANSACTION **/
        
        
        
        $metadata = !empty( $this->upearner_info['userpointearner_metadata'] ) ? unserialize($this->upearner_info['userpointearner_metadata']) : array();
        $params = array( $this, $user, $metadata, $transaction_params );
        if(is_callable("upearner_{$this->upearner_info['userpointearnertype_name']}_ontransactionstart")) {
            if( !call_user_func_array( "upearner_{$this->upearner_info['userpointearnertype_name']}_ontransactionstart", array( &$params ) ) ) {
                if( isset($params['redirect']) ) {
                    header("Location: " . $params['redirect']);
                    exit;
                }
                
                $this->err_msg = isset($params['err_msg']) ? $params['err_msg'] : $functions_userpoints[20];
                return false;
            }
        }



        /** TRANSACTION **/

        // Instantly completed
        if( $this->upearner_info['userpointearner_transact_state'] == 0) {
            userpoints_add( $user->user_info['user_id'], $this->upearner_info['userpointearner_cost'] );
        }
        


        /** AFTER TRANSACTION SUCCESS **/



        if(is_callable("upearner_{$this->upearner_info['userpointearnertype_name']}_ontransactionsuccess")) {
            if( !call_user_func_array( "upearner_{$this->upearner_info['userpointearnertype_name']}_ontransactionsuccess", array( &$params ) ) ) {

                $this->err_msg = $params['err_msg'];

                // rollback

                return false;
            }
        }

        $this->transaction_message = isset($params['transaction_message']) ? $params['transaction_message'] : '';

        if( semods::g($params, 'transaction_record', 1) != 0) {

        $transaction_text = isset($params['transaction_text']) ? $params['transaction_text'] : '';
        $database->database_query( "INSERT INTO se_semods_uptransactions
                                    (uptransaction_user_id,
                                     uptransaction_type,
                                         uptransaction_cat,
                                     uptransaction_state,
                                     uptransaction_text,
                                     uptransaction_date,
                                     uptransaction_amount)
                                    VALUES( {$user->user_info['user_id']},
                                            {$this->upearner_info['userpointearner_type']},
                                                1,
                                            {$this->upearner_info['userpointearner_transact_state']},
                                            '$transaction_text',
                                            UNIX_TIMESTAMP( NOW() ),
                                            {$this->upearner_info['userpointearner_cost']} )
                                            " );
        
        $transaction_id = $database->database_insert_id();
        $params[3]['transaction_id'] = $transaction_id;

        }


        /** UPDATE ENGAGEMENTS COUNTER **/

        $database->database_query( "UPDATE se_semods_userpointearner SET userpointearner_engagements = userpointearner_engagements + 1 WHERE userpointearner_id = " . $this->upearner_info['userpointearner_id'] );


                                            
//        userpoints_add_transaction( $user_id, $this->upspender_info['userpointspender_cost'], $this->upspender_info['userpointspender_transact_state'])

        if(is_callable("upearner_{$this->upearner_info['userpointearnertype_name']}_ontransactionfinished")) {
            if( !call_user_func_array( "upearner_{$this->upearner_info['userpointearnertype_name']}_ontransactionfinished", array( &$params ) ) ) {
                $this->err_msg = $params['err_msg'];

                // rollback ?

                return false;
            }
        }

        // Redirection after transaction completed
        if( isset($params['redirect']) ) {
            header("Location: " . $params['redirect']);
            exit;
        }

        return array( 'transaction_message'  => $this->transacton_message );
    }



	function dir($item_id = 0) {

        if($item_id == 0 & $this->upearner_exists) {
          $item_id = $this->upearner_info['userpointearner_id'];
        }

	  //$subdir = $item_id+999-(($item_id-1)%1000);
	  //$itemdir = "../uploads_userpoints/$subdir/$item_id/";
      $itemdir = "../uploads_userpoints/";
	  return $itemdir;

	}



	function photo($nophoto_image = "") {

	  $item_photo = $this->dir() . $this->upearner_info['userpointearner_photo'];
	  if(!file_exists($item_photo) | $this->upearner_info['userpointearner_photo'] == "") {
        $item_photo = $nophoto_image;
        }
	  return $item_photo;
	  
	}

	function public_dir($item_id = 0) {

        if(($item_id == 0) && $this->upearner_exists) {
          $item_id = $this->upearner_info['userpointearner_id'];
        }

      $itemdir = "./uploads_userpoints/";
	  return $itemdir;

	}
    
	function public_photo($nophoto_image = "") {

	  $item_photo = $this->public_dir() . $this->upearner_info['userpointearner_photo'];
	  if(!file_exists($item_photo) | $this->upearner_info['userpointearner_photo'] == "") {
        $item_photo = $nophoto_image;
        }
	  return $item_photo;
	  
	}
    


	function photo_delete() {
	  global $database;
	  $item_photo = $this->photo();
	  if($item_photo != "") {
	    unlink($item_photo);
	    $database->database_query("UPDATE se_semods_userpointearner SET userpointearner_photo='' WHERE userpointearner_id='".$this->upearner_info['userpointearner_id']."'");
	    $this->upearner_info['userpointearner_photo'] = "";
	  }
	}


	function photo_upload($photo_name) {
	  global $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = "4194304";
	  $file_exts = explode(",", str_replace(" ", "", strtolower( "jpg,jpeg,gif,png" )));
	  $file_types = explode(",", str_replace(" ", "", strtolower("image/jpeg, image/jpg, image/jpe, image/pjpeg, image/pjpg, image/x-jpeg, x-jpg, image/gif, image/x-gif, image/png, image/x-png")));
	  $file_maxwidth = 200;
	  $file_maxheight = 200;
	  $photo_newname = "0_".rand(1000, 9999).".jpg";
	  $file_dest = $this->dir() . $photo_newname;

	  $new_photo = new se_upload();
	  $new_photo->new_upload($photo_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_photo->is_error == 0) {

	    // DELETE OLD AVATAR IF EXISTS
	    $this->photo_delete();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_photo->is_image == 1) {
	      $new_photo->upload_photo($file_dest);
	    } else {
	      $new_photo->upload_file($file_dest);
	    }

	    // UPDATE INFO WITH IMAGE IF STILL NO ERROR
	    if($new_photo->is_error == 0) {
	      $database->database_query("UPDATE se_semods_userpointearner SET userpointearner_photo='$photo_newname' WHERE userpointearner_id='".$this->upearner_info['userpointearner_id']."'");
	      $this->upearner_info['userpointearner_photo'] = $photo_newname;
	    }
	  }
	
	  $this->is_error = $new_photo->is_error;
	  $this->error_message = $new_photo->error_message;

	}
    

}






/******************  CLASS semods_upspender  ******************/





class semods_upspender {

    
    var $upspender_exists = 0;
    var $upspender_info;
    
    var $err_msg;
    
    var $transaction_message;


    function semods_upspender( $upspender_id, $onlyenabled = true ) {

        if($onlyenabled) 
            $this->upspender_info = semods::db_query_assoc("SELECT * FROM se_semods_userpointspender S LEFT JOIN se_semods_userpointspendertypes T ON S.userpointspender_type = T.userpointspendertype_type WHERE S.userpointspender_enabled != 0 AND S.userpointspender_id = $upspender_id");
        else
            $this->upspender_info = semods::db_query_assoc("SELECT * FROM se_semods_userpointspender S LEFT JOIN se_semods_userpointspendertypes T ON S.userpointspender_type = T.userpointspendertype_type WHERE S.userpointspender_id = $upspender_id");

        if($this->upspender_info) {
            $this->upspender_exists = 1;

            if(empty($this->upspender_info['userpointspender_photo'])) {
              $this->upspender_info['userpointspender_photo'] = './images/nophoto.gif';
            }
            
        }
    }
    
    
    function factory($item_id) {
        
    }


    function delete() {
        global $database;
        
        if($this->upspender_exists == 0)
            return;
        
        $database->database_query("DELETE FROM se_semods_userpointspender WHERE userpointspender_id = " . $this->upspender_info['userpointspender_id'] );
    }
    
    
    function enable($enabled=true) {
        global $database;
        
        if($this->upspender_exists == 0)
            return;
        
        // bool -> int
        $enabled = intval($enabled);
        
        $database->database_query("UPDATE se_semods_userpointspender SET userpointspender_enabled = $enabled WHERE userpointspender_id = " . $this->upspender_info['userpointspender_id'] );
    }
    
    
    function total_items( $onlyenabled = true, $where = '' ) {
        if($onlyenabled)
            return semods::db_query_count( "SELECT COUNT(*) FROM se_semods_userpointspender WHERE userpointspender_type >= 100 AND userpointspender_enabled != 0" );
        else
            return semods::db_query_count( "SELECT COUNT(*) FROM se_semods_userpointspender WHERE userpointspender_type >= 100" );
    }


    function transact($user) {
        global $database, $functions_userpoints;
        
        if(!file_exists("include/functions_userpoints_{$this->upspender_info['userpointspendertype_name']}.php")) {
            $this->err_msg = $functions_userpoints[20];
            return false;
        }
        
        include_once "include/functions_userpoints_{$this->upspender_info['userpointspendertype_name']}.php";
        
        
        
        /** BEFORE TRANSACTION **/
        
        
        
        $metadata = !empty( $this->upspender_info['userpointspender_metadata'] ) ? unserialize($this->upspender_info['userpointspender_metadata']) : array();
        $params = array( $this, $user, $metadata );
        if(is_callable("upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionstart")) {
            if( !call_user_func_array( "upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionstart", array( &$params ) ) ) {

                if( isset($params['redirect']) ) {
                    header("Location: " . $params['redirect']);
                    exit;
                }
                
                $this->err_msg = isset($params['err_msg']) ? $params['err_msg'] : $functions_userpoints[21];
                return false;
            }
        }



        /** TRANSACTION **/
        
        
        
        if( !userpoints_deduct( $user->user_info['user_id'], $this->upspender_info['userpointspender_cost'] ) ) {
            $this->err_msg = $functions_userpoints[22];

            if(is_callable("upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionfail")) {
                call_user_func_array( "upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionstart", array( &$params ) );
            }
            
            return false;
        }
        


        /** AFTER TRANSACTION SUCCESS **/



        if(is_callable("upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionsuccess")) {
            if( !call_user_func_array( "upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionsuccess", array( &$params ) ) ) {
                $this->err_msg = $params['err_msg'];

                // rollback, uses "deduct" with negative amount to also update "spent points"
                userpoints_deduct( $user->user_info['user_id'], -$this->upspender_info['userpointspender_cost'] );
                return false;
            }
        }

        $this->transaction_message = isset($params['transaction_message']) ? $params['transaction_message'] : '';

        if( semods::g($params, 'transaction_record', 1) != 0) {

        $transaction_text = isset($params['transaction_text']) ? $params['transaction_text'] : '';
        $database->database_query( "INSERT INTO se_semods_uptransactions
                                    (uptransaction_user_id,
                                     uptransaction_type,
                                         uptransaction_cat,
                                     uptransaction_state,
                                     uptransaction_text,
                                     uptransaction_date,
                                     uptransaction_amount)
                                    VALUES( {$user->user_info['user_id']},
                                            {$this->upspender_info['userpointspender_type']},
                                                2,
                                            {$this->upspender_info['userpointspender_transact_state']},
                                            '$transaction_text',
                                            UNIX_TIMESTAMP( NOW() ),
                                            -{$this->upspender_info['userpointspender_cost']} )
                                            " );

            $transaction_id = $database->database_insert_id();
            $params[3]['transaction_id'] = $transaction_id;

        }

        /** UPDATE ENGAGEMENTS COUNTER **/

        $database->database_query( "UPDATE se_semods_userpointspender SET userpointspender_engagements = userpointspender_engagements + 1 WHERE userpointspender_id = " . $this->upspender_info['userpointspender_id'] );

        if(is_callable("upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionfinished")) {
            if( !call_user_func_array( "upspender_{$this->upspender_info['userpointspendertype_name']}_ontransactionfinished", array( &$params ) ) ) {
                $this->err_msg = $params['err_msg'];

                // rollback ?

                return false;
            }
        }

        // Redirection after transaction completed
        if( isset($params['redirect']) ) {
            header("Location: " . $params['redirect']);
            exit;
        }

                                            
//        userpoints_add_transaction( $user_id, $this->upspender_info['userpointspender_cost'], $this->upspender_info['userpointspender_transact_state'])

        return array( 'transaction_message'  => $this->transacton_message );
    }
    

	function dir($item_id = 0) {

        if($item_id == 0 & $this->upspender_exists) {
          $item_id = $this->upspender_info['userpointspender_id'];
        }

	  //$subdir = $item_id+999-(($item_id-1)%1000);
	  //$itemdir = "../uploads_userpoints/$subdir/$item_id/";
      $itemdir = "../uploads_userpoints/";
	  return $itemdir;

	}


	function photo($nophoto_image = "") {

	  $item_photo = $this->dir() . $this->upspender_info['userpointspender_photo'];
	  if(!file_exists($item_photo) | $this->upspender_info['userpointspender_photo'] == "") {
        $item_photo = $nophoto_image;
        }
	  return $item_photo;
	  
	}


	function public_dir($item_id = 0) {

        if(($item_id == 0) && $this->upspender_exists) {
          $item_id = $this->upspender_info['userpointspender_id'];
        }

	  //$subdir = $item_id+999-(($item_id-1)%1000);
	  //$itemdir = "../uploads_userpoints/$subdir/$item_id/";
      $itemdir = "./uploads_userpoints/";
	  return $itemdir;

	}
    
    
	function public_photo($nophoto_image = "") {

	  $item_photo = $this->public_dir() . $this->upspender_info['userpointspender_photo'];
	  if(!file_exists($item_photo) | $this->upspender_info['userpointspender_photo'] == "") {
        $item_photo = $nophoto_image;
        }
	  return $item_photo;
	  
	}
    

	function photo_delete() {
	  global $database;
	  $item_photo = $this->photo();
	  if($item_photo != "") {
	    unlink($item_photo);
	    $database->database_query("UPDATE se_semods_userpointspender SET userpointspender_photo='' WHERE userpointspender_id='".$this->upspender_info['userpointspender_id']."'");
	    $this->upspender_info['userpointspender_photo'] = "";
	  }
	}


	function photo_upload($photo_name) {
	  global $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = "4194304";
	  $file_exts = explode(",", str_replace(" ", "", strtolower( "jpg,jpeg,gif,png" )));
	  $file_types = explode(",", str_replace(" ", "", strtolower("image/jpeg, image/jpg, image/jpe, image/pjpeg, image/pjpg, image/x-jpeg, x-jpg, image/gif, image/x-gif, image/png, image/x-png")));
	  $file_maxwidth = 200;
	  $file_maxheight = 200;
	  $photo_newname = "0_".rand(1000, 9999).".jpg";
	  $file_dest = $this->dir() . $photo_newname;

	  $new_photo = new se_upload();
	  $new_photo->new_upload($photo_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_photo->is_error == 0) {

	    // DELETE OLD AVATAR IF EXISTS
	    $this->photo_delete();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_photo->is_image == 1) {
	      $new_photo->upload_photo($file_dest);
	    } else {
	      $new_photo->upload_file($file_dest);
	    }

	    // UPDATE INFO WITH IMAGE IF STILL NO ERROR
	    if($new_photo->is_error == 0) {
	      $database->database_query("UPDATE se_semods_userpointspender SET userpointspender_photo='$photo_newname' WHERE userpointspender_id='".$this->upspender_info['userpointspender_id']."'");
	      $this->upspender_info['userpointspender_photo'] = $photo_newname;
	    }
	  }
	
	  $this->is_error = $new_photo->is_error;
	  $this->error_message = $new_photo->error_message;

	}

}






/****** PAGINATOR CLASS ******/ 


if(!class_exists('semods_paginator')) {
class semods_paginator {
  
  var $items_per_page;
  var $total_items;

  var $maxpage;
  var $page;
  var $p_start;
  var $p_end;
  var $limit_from;
  var $actual_items;
  
  function semods_paginator( $cur_page = 1, $items_per_page = 10, $total_items = null ) {

    $this->page = $cur_page;
    $this->items_per_page = $items_per_page;
    
    if($total_items != null) {
      $this->setTotalItems( $total_items );
      $this->paginate();
    }
    
  }
  
  /*
  function limit_from() {
    return $this->limit_from;
  }
  
  function limit_to() {
    return $this->items_per_page;
  }
  */
 
  function setTotalItems( $total_items ) {
    $this->total_items = $total_items;
  }
  
  function setActualItems( $actual_items ) {
    $this->actual_items = $actual_items;
    $this->p_end = $this->limit_from + $this->actual_items;
  }
  
  function paginate() {
    $page_vars = make_page($this->total_items, $this->items_per_page, $this->page);
    
    $this->limit_from = $page_vars[0];
    $this->p_start = $page_vars[0]+1;
//    $this->p_end = $page_vars[0] + count($this->actual_items);
    $this->maxpage = $page_vars[2];
    $this->page = $page_vars[1];
  }

/*  
  function p_start() {
    return $this->limit_from + 1;
  }
*/

  function assignStdSmartyVars( ) {
    global $smarty;

    $smarty->assign('maxpage', $this->maxpage);
    $smarty->assign('p', $this->page);
    $smarty->assign('p_start', $this->p_start);
    $smarty->assign('p_end', $this->p_end);

    $smarty->assign('items', $this->actual_items);
    $smarty->assign('total_items', $this->total_items);
    
  }
  
}


}






/********* semods_userpoints *********/


/*
class semods_userpoints {
	
	var $userpoints_info = array();
//	var $have_userpoints_info 

	var $points = 0;
	var $total_earned = 0;
	var $total_spent = 0;
	
	function semods_userpoints( $user_id ) {
		$dbr = semods::db_query_assoc( "SELECT userpoints_count FROM se_semods_userpoints WHERE userpoints_user_id = $user_id" );
		if( $dbr ) {
			$this->points_count = $dbr['userpoints_count'];
			$this->points_totalearned = $dbr['userpoints_totalearned'];
			$this->points_totalspent = $dbr['userpoints_totalspent'];
		}
	}
	
	function deduct() {
        
    }
	
	function add() {
        
    }

	function try_deduct() {
        
    }

	function get_balance() {
        
    }
}
*/

?>