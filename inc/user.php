<?php

class User {
  public function getUserByID($id){
    global $db;
    $sql ="SELECT * FROM users
    WHERE id = $id";
    $result = $db->query($sql);
    if(!empty($result) && $result->num_rows > 0){
  while ($row = $result->fetch_assoc()) {
    return $row;
  }
    }else{
      return false;
    }
  }
  public function updateUserPassword($id,$password){
    global $db;
    $sql ="UPDATE users SET password = '$password' WHERE id = $id";
    $result = $db->query($sql);
    if($result){
    return $result;
    }else{
      return false;
    }
  }
}
?>
