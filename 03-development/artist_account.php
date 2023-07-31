<?php

  /**
   *
   */
  class ArtistAccount implements Account
  {

    protected $db;

    protected int $_id;
    protected string $username;
    protected string $password;
    protected int $type;

    function __construct(int $_id,string $username,string $password,int $type)
    {
      global $facade;
      $this->db = $facade->proxy_db;

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
      $result = $this->db->setUsername($username,$this->username);
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
      echo "deleting";
    }

    public function getType()
    {
      return $this->type;
    }

    public function getAllAlbums(){
      return $this->db->getAllAlbums($this->username);
    }

    public function getAlbum($album_title)
    {
      $result = $this->db->readAlbumSingle($this->username,$album_title);
      if (count($result)!=0) {
        $id = $result['_id'];
        $title = $result['title'];
        $art = $result['art'];
        $approval = $result['approval'];
        $price = $result['price'];
        return new Album($id,$title,$art,$approval,$price,array());
      }
      return new Album(-1,"","",false,0,array());
    }

  }


?>
