<?php

include_once "class_radcodes.php";

class rc_employment extends rc_model 
{
  var $table = 'se_employments';
  var $pk = 'employment_id';
  var $user_id;
  
  function rc_employment($uid=null)
  {
    rc_model::rc_model();
    $this->user_id = $uid;
  }
  
  function insert($data)
  {
    if ($this->user_id) $data['employment_user_id'] = $this->user_id;
    return rc_model::insert($data);
  }
  
  function get_user_criteria()
  {
    return ($this->user_id) ? "employment_user_id = '$this->user_id'" : null;
  }
  
  function join_user_criteria($criteria)
  {
    $uc = $this->get_user_criteria();
    return ($uc) ? "$criteria AND $uc" : $criteria;
  }
  
  function get_employments($condition,$key=true)
  {
    if ($condition) $condition = " AND ".$condition;
    $criteria = "WHERE ".$this->get_user_criteria()." $condition ORDER BY employment_employer ASC";
    return $this->get_records($criteria, $key);
  }
  
  function get_record_by_criteria($criteria)
  {
    return rc_model::get_record_by_criteria($this->join_user_criteria($criteria));
  }  
  
  function update_by_criteria($criteria, $data)
  {
    return rc_model::update_by_criteria($this->join_user_criteria($criteria),$data);
  }  
  
  function delete_by_criteria($criteria)
  {
    return rc_model::delete_by_criteria($this->join_user_criteria($criteria));
  }
}
