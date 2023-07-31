<?php

  require 'database_interface.php';
  require 'proxy_database.php';
  require 'real_database.php';
  require 'account_interface.php';
  require 'artist_account.php';
  require 'admin_account.php';
  require 'customer_account.php';
  require 'album.php';
  require 'account_factory.php';
  require 'facade.php';
  require 'track.php';
  require 'purchase.php';

  // logIn() -- as in sequence diagram
  $facade = new Facade();
  $facade->createAccount("test_user_customer","test_password_customer",2);
  $facade->logIn("test_user_customer","test_password_customer");

  function downloadAlbum()
  {
    echo $facade->downloadAlbum("test_user_artist","test_album_1");
  }


  function uploadAlbum()
  {
    // logIn() -- as in sequence diagram
    $facade = new Facade();
    $facade->logIn("test_user_artist","test_password_artist");
    // uploadAlbum() -- as in sequence diagram
    $tracks = array();
    $track_one = array(
      $facade::TRACK_TITLE => "new track title one",
      $facade::TRACK_NUMBER => 1,
      $facade::TRACK_FILE => "/folder/folder/file_one.mp3"
    );
    $track_two = array(
      $facade::TRACK_TITLE => "new track title two",
      $facade::TRACK_NUMBER => 2,
      $facade::TRACK_FILE => "/folder/folder/file_two.mp3"
    );
    array_push($tracks,$track_one,$track_two);
    $album = $facade->uploadAlbum($tracks,"new album title");
    echo "index.php\n";
    echo $album;
  }

  // CREATE
  // createAccount
  // echo $facade->createAccount("username001","password",0);
  // echo $facade->createAccount("username002","password",1);
  // echo $facade->createAccount("username003","password",2);

  // createAlbum
  // echo $facade->createAlbum("new album title","/folder/coverart.jpg",false,4.99);

  // createPurchase
  // echo $facade->createPurchase(3,1,2,"card holder name","1234123412341234","27/07/2022","123");

  // createTrack
  // echo $facade->createTrack("new track title",1,"new track file",2);

  // READ
  // readAccountSingle
  // echo $facade->readAccountSingle("test_user_artist");

  // readAlbumSingle
  // echo $facade->readAlbumSingle("test_user_artist","test_album_1");

  // readAlbumMultiple
  // echo $facade->readAlbumMultiple("test_user_artist");

  // readPurchaseSingle
  // echo $facade->readPurchaseSingle("test_user_customer",1);

  // readPurchaseMultiple
  // echo $facade->readPurchaseMultiple("test_user_customer");

  // readTrackSingle
  // echo $facade->readTrackSingle(2,"new track title");

  // readTrackMultiple
  // echo $facade->readTrackMultiple(2);

  // UPDATE
  // updateAccount
  // updateAlbum
  // updateTrack

  // DELETE


?>
