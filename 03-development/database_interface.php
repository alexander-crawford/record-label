<?php

/**
 *  Exposed db functions
 */
interface Database
{
  // CREATE
  public function createAccount(string $username,string $password,int $type) : array;
  public function createAlbum(string $title,string $art,bool $approval,float $price) : array;
  public function createArtistAlbum(int $artist_id,int $album_id) : array;
  public function createPurchase(int $customer_id,int $payment_id,int $album_id,string $card_holder_name,string $card_number,string $card_expiration_date,string $card_cvv) : array;
  public function createTrack(string $title,int $number,string $file,int $album_id) : array;

  // READ
  public function readAccountSingle(string $username) : array;
  public function readAlbumSingle(string $username,string $title) : array;
  public function readAlbumMultiple(string $username) : array;
  public function readPurchaseSingle(string $username,int $album_id) : array;
  public function readPurchaseMultiple(string $username) : array;
  public function readTrackSingle(int $album_id,string $title) : array;
  public function readTrackMultiple(int $album_id) : array;

  // UPDATE
  // public function updateAccount(string $old_username,string $new_username,string $new_password,int $new_type);
  // public function updateAlbum(int $id,string $new_title,string $new_art,bool $new_approval,float $new_price);
  // public function updateTrack(int $id,string $new_title,int $new_number,string $new_file,int $new_album_id);

  // DELETE

}

?>
