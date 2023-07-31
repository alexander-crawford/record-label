<?php


/**
 *
 */
class Facade
{

  public $proxy_db;
  private $login_account;

  public const TRACK_TITLE = 'track_title';
  public const TRACK_NUMBER = 'track_number';
  public const TRACK_FILE = 'track_file';

  public function __construct()
  {
    $this->proxy_db = new ProxyDatabase();
  }

  public function createAccount(string $username,string $password,int $type)
  {
    switch ($type) {
      case '0':
        $factory = new AdminAccountFactory();
        break;
      case '1':
        $factory = new ArtistAccountFactory();
        break;
      case '2':
        $factory = new CustomerAccountFactory();
        break;
    }
    $account = $factory->createAccount($username,$password);
    if ($account->getType()!=-1) {
      return $account;
    } else {
      echo "Username " . $username . " is taken.\n";
    }

  }

  public function createAlbum(string $title,string $art,bool $approval,float $price)
  {
    return $this->proxy_db->createAlbum($title,$art,$approval,$price);
  }

  public function createPurchase(int $customer_id,int $payment_id,int $album_id,string $card_holder_name,string $card_number,string $card_expiration_date,string $card_cvv)
  {
    return $this->proxy_db->createPurchase($customer_id,$payment_id, $album_id,$card_holder_name,$card_number,$card_expiration_date,$card_cvv);
  }

  public function createTrack(string $title,int $number,string $file,int $album_id)
  {
    return $this->proxy_db->createTrack($title,$number,$file,$album_id);
  }

  public function readAccountSingle(string $username)
  {
    $factory = new AdminAccountFactory();
    return $factory->getAccount($username);

  }

  public function readAlbumSingle(string $username,string $title)
  {
    return $this->proxy_db->readAlbumSingle($username,$title);
  }

  public function readAlbumMultiple(string $username)
  {
    return $this->proxy_db->readAlbumMultiple($username);
  }

  public function readPurchaseSingle(string $username,int $album_id)
  {
    return $this->proxy_db->readPurchaseSingle($username,$album_id);
  }

  public function readPurchaseMultiple(string $username)
  {
    return $this->proxy_db->readPurchaseMultiple($username);
  }

  public function readTrackSingle(int $album_id,string $title)
  {
    return $this->proxy_db->readTrackSingle($album_id,$title);
  }

  public function readTrackMultiple(int $album_id)
  {
    return $this->proxy_db->readTrackMultiple($album_id);
  }

  public function logIn(string $username,string $password) : bool
  {
    global $login_account;
    $login_account = $this->readAccountSingle($username);
    return $login_account->authenicate($password);
  }

  public function uploadAlbum(array $tracks,string $album_title) : Album
  {
    global $login_account;
    $type = $login_account->getType();
    if ($type!=1) {
      // account is not artist
      return new Album(-1,"","",false,0.00,array());
    } else {
      $artist_id = $login_account->getID();
      $album_array = $this->proxy_db->uploadAlbum($tracks,$album_title,$artist_id);
      return new Album($album_array['_id'],$album_array['title'],$album_array['art'],$album_array['approval'],$album_array['price'],array());
    }

  }

  public function downloadAlbum(string $artist_username,string $album_title) : string
  {
    $return = "";
    global $login_account;
    $type = $login_account->getType();
    if ($type==2) {

      // get the id of the album requested for download
      $artist_account = $this->readAccountSingle($artist_username);
      $album = $artist_account->getAlbum($album_title);
      $album_id = $album->getID();

      // find a purchase for the requested album
      $purchases = $login_account->getAllPurchases();
      foreach ($purchases as $purchase) {
        if ($album_id==$purchase->getAlbum()->getID()) {
          return "avaliable for download";
        }
      }
    }else {
      return "not avaliable for download";
    }
    return $return;
  }

}


?>
