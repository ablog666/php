<?

/**
 * radCodes CoreLite Library
 * 
 * This is an extented library developed by radCodes to be used in
 * various plug-ins and customization works for Social Engine.
 * Do NOT modify this file in anyway. This file is not Open-Source.
 * 
 * @category   library
 * @package    socialEngine.library
 * @author     Vincent Van <vctvan@gmail.com>
 * @copyright  2008 radCodes <vctvan@gmail.com>
 * @version    $Id: class_radcodes.php 10748 2008-03-15 07:30:59 $
 */


class rc_model
{
  /**
   * @var se_database
   */
  var $db;  
  
  var $table = null;
  var $pk = null;
  
  function rc_model()
  {
    global $database;
    $this->db =& $database;
  }
  
  function get_records($criteria=null,$key=false)
  {
    $rows = array();
    $index = 0;
    $res = $this->db->database_query("SELECT * FROM $this->table $criteria");
    while($row = $this->db->database_fetch_assoc($res)) {
      if ($key) {
        $rows[$row[$this->pk]] = $row;
      }
      else {
        $rows[$index++] = $row;
      }
    }
    
    return $rows;
  }

  function get_record_by_criteria($criteria)
  {
    $records = $this->get_records("WHERE $criteria LIMIT 1");
    return (count($records)==1) ? array_shift($records) : null;
  }
  
  function get_record($id)
  {
    return $this->get_record_by_criteria("$this->pk = '$id'");
  }
  
  function update_by_criteria($criteria, $data)
  {
    $data_string = rc_toolkit::db_data_packer($data);
    return $this->db->database_query("UPDATE $this->table SET $data_string WHERE $criteria");
  }
  
  function update($id, $data)
  {
    return $this->update_by_criteria("$this->pk = '$id'", $data);
  }
  
  function insert($data)
  {
    $data_string = rc_toolkit::db_data_packer($data);
    $res = $this->db->database_query("INSERT INTO $this->table SET $data_string");
    return $this->db->database_insert_id();
  }
  
  function delete_by_criteria($criteria)
  {
    return $this->db->database_query("DELETE FROM $this->table WHERE $criteria");
  }
  
  function delete($id)
  {
    return $this->delete_by_criteria("$this->pk = '$id'");
  }

  function delete_all()
  {
    return $this->db->database_query("DELETE FROM $this->table");
  }
}

class rc_toolkit
{
  
  function debug($var,$msg=null)
  {
    if (is_array($var) || is_object($var) || is_bool($var)) {
      $var = print_r($var,true);
    }
    
    if ($msg) {
      $msg = "<span style='color: green'>$msg :: \n</span>";
    }
    
    echo "<pre style='text-align:left;'>$msg$var</pre>";
    
  }
  
  function get_request($key, $default = null)
  {
    if (isset($_POST[$key])) {
      $value = $_POST[$key];
    }
    elseif (isset($_GET[$key])) {
      $value = $_GET[$key];
    }
    else {
      $value = $default;
    }
    return $value;
  }
  
  function truncate_text($text, $length = 30, $truncate_string = '...', $truncate_lastspace = false)
  {
    if ($text == '') {
      return '';
    }
  
    if (strlen($text) > $length) {
      $truncate_text = substr($text, 0, $length - strlen($truncate_string));
      if ($truncate_lastspace) {
        $truncate_text = preg_replace('/\s+?(\S+)?$/', '', $truncate_text);
      }
      return $truncate_text.$truncate_string;
    }
    else {
      return $text;
    }
  }
  
  function redirect($url)
  {
    header("Location: $url");
    exit();    
  }
  
  function db_data_packer($data,$escape=true)
  {
    $set = array();
    
    foreach ($data as $field => $value) {
      if ($escape) $value = addslashes($value);
      array_push($set, $field."='$value'");
    }

    return implode(', ', $set);
  }
  
  function write_to_file($filename, $content, $mode='w')
  {
    $handle = fopen($filename, $mode);
    fwrite($handle, $content);
    fclose($handle);    
  }
  
  function parse_rfc3339( $date ) {
    $date = substr( str_replace( 'T' , ' ' , $date ) , 0 , 19 );
    return strtotime( $date );
  }  
  
  function strip_text($text)
  {
    $text = strtolower($text);
 
    // strip all non word chars
    $text = preg_replace('/\W/', ' ', $text);
    // replace all white space sections with a dash
    $text = preg_replace('/\ +/', '-', $text);
    // trim dashes
    $text = preg_replace('/\-$/', '', $text);
    $text = preg_replace('/^\-/', '', $text);
 
    return $text;
  }
  
  function db_to_datetime($timestamp=null)
  {
    return date('Y-m-d H:i:s', ($timestamp===null?time():$timestamp));
  }
  
}


class rc_validator
{
  
  var $errors;
  
  function rc_validator()
  {
    $this->clear_errors();
  }
  
  function clear_errors()
  {
    $this->errors = array();
  }
  
  function has_errors()
  {
    return count($this->errors);
  }
  
  function has_error($key)
  {
    return isset($this->errors[$key]);
  }
  
  function get_errors()
  {
    return $this->errors;
  }
  
  function get_error($key)
  {
    return $this->has_error($key) ? $this->errors[$key] : null;
  }
  
  function set_error($message, $key=null)
  {
    if ($key === null) {
      $this->errors[] = $message;
    }
    else {
      $this->errors[$key] = $message;
    }
  }
  
  function validate($expression, $message, $key=null)
  {
    if ($expression===true) {
      return true;
    }
    else {
      $this->set_error($message, $key);
      return false;
    }
  }
  
  function is_not_blank($value, $message, $key=null)
  {
    return $this->validate(strlen($value) > 0, $message, $key);
  }
  
  function is_not_trimmed_blank($value, $message, $key=null)
  {
    return $this->is_not_blank(trim($value), $message, $key);
  }
  
  function is_email($value, $messsage, $key=null)
  {
    return ($this->validate(preg_match('|^[\w\d][\w\d\,\.\-]*\@([\w\d\-]+\.)+([a-zA-Z]+)$|', $data) > 0, $message, $key));
  }
  
  function is_number($value, $message, $key=null)
  {
    return $this->validate(is_numeric($value), $message, $key);
  }
}

class rc_xml_parser {
  
  function get_children($vals, &$i) { 
    $children = array();
    if (isset($vals[$i]['value'])){
      $children['VALUE'] = $vals[$i]['value'];
    } 
    
    while (++$i < count($vals)){ 
      switch ($vals[$i]['type']){
        
        case 'cdata': 
        if (isset($children['VALUE'])){
          $children['VALUE'] .= $vals[$i]['value'];
        } 
		else {
          $children['VALUE'] = $vals[$i]['value'];
        } 
        break;
        
        case 'complete':
        if (isset($vals[$i]['attributes'])) {
          $children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
          $index = count($children[$vals[$i]['tag']])-1;
      
          if (isset($vals[$i]['value'])){ 
            $children[$vals[$i]['tag']][$index]['VALUE'] = $vals[$i]['value']; 
          }
		  else {
            $children[$vals[$i]['tag']][$index]['VALUE'] = '';
          }
        }
		else {
          if (isset($vals[$i]['value'])){
            $children[$vals[$i]['tag']][]['VALUE'] = $vals[$i]['value']; 
          }
		  else {
            $children[$vals[$i]['tag']][]['VALUE'] = '';
          } 
        }
        break;
        
        case 'open': 
        if (isset($vals[$i]['attributes'])) {
          $children[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes'];
          $index = count($children[$vals[$i]['tag']])-1;
          $children[$vals[$i]['tag']][$index] = array_merge($children[$vals[$i]['tag']][$index],$this->get_children($vals, $i));
        }
		else {
          $children[$vals[$i]['tag']][] = $this->get_children($vals, $i);
        }
        break; 
      
        case 'close': 
        return $children; 
      } 
    }
  }
  
  
  
  function get_xml_tree($data) { 
    if( ! $data )
      return false;
  
    $parser = xml_parser_create('UTF-8');
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    xml_parse_into_struct($parser, $data, $vals, $index); 
    xml_parser_free($parser); 
  
    $tree = array(); 
    $i = 0; 
  
    if (isset($vals[$i]['attributes'])) {
      $tree[$vals[$i]['tag']][]['ATTRIBUTES'] = $vals[$i]['attributes']; 
      $index = count($tree[$vals[$i]['tag']])-1;
      $tree[$vals[$i]['tag']][$index] =  array_merge($tree[$vals[$i]['tag']][$index], $this->get_children($vals, $i));
    }
	else {
      $tree[$vals[$i]['tag']][] = $this->get_children($vals, $i); 
    }
    return $tree; 
  }
}


class rc_tagcloud extends rc_model
{
  var $pk = 'tag_id';  
  var $case_insensitive = true;
  
  function delete_name($name)
  {
    $criteria = rc_toolkit::db_data_packer(array('tag_name'=>$name));
    return $this->delete_by_criteria($criteria);
  }
  
  function log_tag($name)
  {
    // just some safety
    if ($name=='') return false;
    if ($this->case_insensitive) $name = strtolower($name);
    $data = array('tag_name'=>$name);
    $data_string = rc_toolkit::db_data_packer($data);
    
    $tag = $this->get_record_by_criteria($data_string);
    if ($tag) {
      $data['tag_count'] = $tag['tag_count'] + 1;
      $this->update($tag[$this->pk],$data);
      return $tag[$this->pk];
    }
    else {
      $data['tag_count'] = 1;
      return $this->insert($data);
    }
  }
  
  function get_cloud($max_entry, $order_by='count', $sort=null)
  {
    $records = $this->get_records("ORDER BY tag_count desc LIMIT $max_entry");
    $columns = array();
    $i=0;
    foreach ($records as $k=>$v) {
      $records[$k]['rank'] = ++$i;
      $columns[$k] = ($order_by == 'name') ? $records[$k]['tag_name'] : $records[$k]['tag_count'];
    }
    
    if ($sort === null) {
      $sort = ($order_by=='count') ? SORT_DESC : SORT_ASC;
    }
    
    array_multisort($columns, $sort, $records);
    return $records;
  }
  
  
}
