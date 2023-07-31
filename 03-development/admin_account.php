<?php

  /**
   *
   */
  class AdminAccount implements Account
  {

    protected int $_id;
    protected string $username;
    protected string $password;
    protected int $type;

    function __construct(int $_id,string $username,string $password,int $type)
    {
      $this->_id = $_id;
      $this->username = $username;
      $this->password = $password;
      $this->type = $type;
    }

    public function __toString()
    {
      $return = "id ". $this->_id . "\n";
      $return .= "username ". $this->username . "\n";
      $return .= "password ". $this->password . "\n";
      $return .= "type ". $this->type . "\n";
      return $return;
    }

    public function getID(){
      return $this->_id;
    }

    public function getUsername(){
      return $this->username;
    }

    public function setUsername($username){
      global $proxy_db;
      $result = $proxy_db->setUsername($username,$this->username);
      if ($result) {
        $this->username = $username;
        return true;
      }else {
        return false;
      }
    }

    public function authenicate($password)
    {
      if ($this->password==$password) {
        return True;
      }else {
        return False;
      }
    }

    public function delete()
    {
      // TODO: complete function when the sequence diagram for removing
      // accounts has been completed
      return false;
    }

    public function getType()
    {
      return $this->type;
    }

  }

?>
