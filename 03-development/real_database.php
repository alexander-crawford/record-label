<?php

  /**
   * Class containing sql statements
   */
  class RealDatabase implements Database
  {

    // TODO: possible singleton

    private $myqli;

    function __construct()
    {
      $this->mysqli = new mysqli("127.0.0.1", "root", "123456", "record_label");
    }

    public function createAccount(string $username,string $password,int $type) : array
    {
      $sql = "insert into account (username,password,type) values (?,?,?)";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("ssi",$username,$password,$type);
      $status = $stmt->execute();
      $id = $this->mysqli->insert_id;
      if ($id==0) {
        return array();
      }else {
        return array(
          '_id' => $id,
          'username' => $username,
          'password' => $password,
          'type' => $type
        );
      }
    }

    public function createAlbum(string $title,string $art,bool $approval,float $price) : array
    {
      // TODO: move this to ProxyDatabase
      if (strlen($art)==0) {
        $art_parsed = null;
      }else {
        $art_parsed = $art;
      }
      $sql = "insert into album (title,art,approval,price) values (?,?,?,?)";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("ssid",$title,$art_parsed,intval($approval),$price);
      $status = $stmt->execute();
      $id = $this->mysqli->insert_id;
      if ($id==0) {
        return array();
      }else {
        return array(
          '_id' => $id,
          'title' => $title,
          'art' => $art,
          'approval' => $approval,
          'price' => $price
        );
      }
    }

    public function createArtistAlbum(int $artist_id,int $album_id) : array
    {
      $sql = "insert into artist_album (artist_id,album_id) values (?,?)";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("ii",$artist_id,$album_id);
      $status = $stmt->execute();
      $rows = $this->mysqli->affected_rows;
      if ($rows!=1) {
        return array();
      }else {
        return array(
          'artist_id' => $artist_id,
          'album_id' => $album_id
        );
      }
    }

    public function createPurchase(int $customer_id,int $payment_id,int $album_id,string $card_holder_name,string $card_number,string $card_expiration_date,string $card_cvv) : array
    {
      $sql = "insert into purchase (customer_id,payment_id,album_id,card_holder_name,card_number,card_expiration_date,card_cvv) values (?,?,?,?,?,?,?)";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("iiissss",$customer_id,$payment_id,$album_id,$card_holder_name,$card_number,$card_expiration_date,$card_cvv);
      $status = $stmt->execute();
      $id = $this->mysqli->insert_id;
      if ($id==0) {
        return array();
      }else {
        return array(
          '_id' => $id,
          'customer_id' => $customer_id,
          'payment_id' => $payment_id,
          'album_id' => $album_id,
          'card_holder_name' => $card_holder_name,
          'card_number' => $card_number,
          'card_expiration_date' => $card_expiration_date,
          'card_cvv' => $card_cvv
        );
      }
    }

    public function createTrack(string $title,int $number,string $file,int $album_id) : array
    {
      $sql = "insert into track (title,number,file,album_id) values (?,?,?,?)";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("sisi",$title,$number,$file,$album_id);
      $status = $stmt->execute();
      $id = $this->mysqli->insert_id;
      if ($id==0) {
        return array();
      }else {
        return array(
          '_id' => $id,
          'title' => $title,
          'number' => $number,
          'file' => $file,
          'album_id' => $album_id
        );
      }
    }

    public function readAccountSingle(string $username) : array
    {
      $sql = "select * from account where username = ?";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("s",$username);
      $stmt->execute();
      $result = $stmt->get_result();
      $result_array = $result->fetch_assoc();
      if ($result_array==null) {
        return array();
      } else {
        return $result_array;
      }
    }

    public function readAlbumSingle(string $username,string $title) : array
    {
      $sql = "select album.* from artist_album inner join album on artist_album.album_id = album._id where artist_album.artist_id = (select _id from account where username = ? and type = 1) and album.title = ?";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("ss",$username,$title);
      $stmt->execute();
      $result = $stmt->get_result();
      $result_array = $result->fetch_assoc();
      if ($result_array==null) {
        return array();
      } else {
        return $result_array;
      }
    }

    public function readAlbumMultiple(string $username) : array
    {
      $sql = "select album.* from artist_album inner join album on artist_album.album_id = album._id where artist_album.artist_id = (select _id from account where username = ? and type = 1)";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("s",$username);
      $stmt->execute();
      $result = $stmt->get_result();
      $result_array = $result->fetch_all();
      if ($result_array==null) {
        return array();
      } else {
        return $result_array;
      }
    }

    public function readPurchaseSingle(string $username,int $album_id) : array
    {
      $sql = "select * from purchase where customer_id = (select _id from account where type = 2 and username = ?) and album_id = ?";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("si",$username,$album_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $result_array = $result->fetch_assoc();
      if ($result_array==null) {
        return array();
      } else {
        return $result_array;
      }
    }

    public function readPurchaseMultiple(string $username) : array
    {
      $sql = "select album._id as album_id,album.title as album_title,album.art as album_art,album.approval as album_approval,album.price as album_price,purchase.payment_id as purchase_payment_id,purchase.date as purchase_date,purchase.price as purchase_price,purchase.card_holder_name as purchase_card_holder_name,purchase.card_number as purchase_card_number,purchase.card_expiration_date as purchase_card_expiration_date,purchase.card_cvv as purchase_card_cvv from purchase inner join account on purchase.customer_id = account._id inner join album on purchase.album_id = album._id where customer_id = (select _id from account where type = 2 and username = ?)";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("s",$username);
      $stmt->execute();
      $result = $stmt->get_result();
      $result_array = $result->fetch_all(MYSQLI_ASSOC);
      if ($result_array==null) {
        return array();
      } else {
        return $result_array;
      }
    }

    public function readTrackSingle(int $album_id,string $title) : array
    {
      $sql = "select * from track where album_id = ? and title = ?";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("is",$album_id,$title);
      $stmt->execute();
      $result = $stmt->get_result();
      $result_array = $result->fetch_assoc();
      if ($result_array==null) {
        return array();
      } else {
        return $result_array;
      }
    }

    public function readTrackMultiple(int $album_id) : array
    {
      $sql = "select * from track where album_id = ?";
      $stmt = $this->mysqli->prepare($sql);
      $stmt->bind_param("i",$album_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $result_array = $result->fetch_all();
      if ($result_array==null) {
        return array();
      } else {
        return $result_array;
      }
    }
  }


?>
