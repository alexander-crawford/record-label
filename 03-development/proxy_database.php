<?php

  /**
   * Class containing logic to create classes from sql statement results
   */
  // TODO: re implement database interface when real database is complete
  class ProxyDatabase implements Database
  {

  private $RealDatabase;

  function __construct()
  {
    $this->RealDatabase = new RealDatabase();
  }

  public function createAccount(string $username,string $password,int $type) : array
  {
    return $this->RealDatabase->createAccount($username,$password,$type);
  }

  public function createAlbum(string $title,string $art,bool $approval,float $price) : array
  {
    return $this->RealDatabase->createAlbum($title,$art,$approval,$price);
  }

  public function createArtistAlbum(int $artist_id,int $album_id) : array
  {
    return $this->RealDatabase->createArtistAlbum($artist_id,$album_id);
  }

  public function createPurchase(int $customer_id,int $payment_id,int $album_id,string $card_holder_name,string $card_number,string $card_expiration_date,string $card_cvv) : array
  {
    $card_expiration_date_formatted = date("Y-m-d",strtotime($card_expiration_date));
    return $this->RealDatabase->createPurchase($customer_id,$payment_id,$album_id,$card_holder_name,$card_number,$card_expiration_date_formatted,$card_cvv);
  }

  public function createTrack(string $title,int $number,string $file,int $album_id) : array
  {
    return $this->RealDatabase->createTrack($title,$number,$file,$album_id);
  }

  public function readAccountSingle(string $username) : array
  {
    return $this->RealDatabase->readAccountSingle($username);
  }

  public function readAlbumSingle(string $username,string $title) : array
  {
    $result = $this->RealDatabase->readAlbumSingle($username,$title);
    if (count($result)!=0) {
      $result['art'] = strval($result['art']);
    }
    return $result;
  }

  public function readAlbumMultiple(string $username) : array
  {
    return $this->RealDatabase->readAlbumMultiple($username);
  }

  public function readPurchaseSingle(string $username,int $album_id) : array
  {
    return $this->RealDatabase->readPurchaseSingle($username,$album_id);
  }

  public function readPurchaseMultiple(string $username) : array
  {
    $results = $this->RealDatabase->readPurchaseMultiple($username);
    $return = array();
    if (count($results)!=0) {
      foreach ($results as $result) {
        $result['album_art'] = strval($result['album_art']);
        array_push($return,$result);
      }
    }
    return $return;
  }

  public function readTrackSingle(int $album_id,string $title) : array
  {
    return $this->RealDatabase->readTrackSingle($album_id,$title);
  }

  public function readTrackMultiple(int $album_id) : array
  {
    return $this->RealDatabase->readTrackMultiple($album_id);
  }

  public function uploadAlbum(array $tracks,string $album_title,int $artist_id) : array
  {
    $album = $this->createAlbum($album_title,"",false,0);
    $album_id = $album['_id'];
    global $facade;
    foreach ($tracks as $track) {
      $title = $track[$facade::TRACK_TITLE];
      $number = intval($track[$facade::TRACK_NUMBER]);
      $file = $track[$facade::TRACK_FILE];
      $this->createTrack($title,$number,$file,$album_id);
    }
    $this->createArtistAlbum($artist_id,$album_id);
    return $album;
  }

}

?>
