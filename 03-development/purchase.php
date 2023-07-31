<?php

  /**
   *
   */
  class Purchase
  {

    protected int $payment_id;
    protected Album $album;
    protected string $date;
    protected float $price;
    protected string $card_holder_name;
    protected string $card_number;
    protected string $card_expiration_date;
    protected string $card_cvv;

    function __construct(int $payment_id,Album $album,string $date,float $price,string $card_holder_name,string $card_number,string $card_expiration_date,string $card_cvv)
    {

      $this->payment_id = $payment_id;
      $this->album = $album;
      $this->date = $date;
      $this->price = $price;
      $this->card_holder_name = $card_holder_name;
      $this->card_number = $card_number;
      $this->card_expiration_date = $card_expiration_date;
      $this->card_cvv = $card_cvv;

    }

    public function getPaymentId()
    {
      return $this->payment_id;
    }

    public function getAlbum()
    {
      return $this->album;
    }

    public function getDate()
    {
      return $this->date;
    }

    public function getPrice()
    {
      return $this->price;
    }

    public function getCardHolderName()
    {
      return $this->card_holder_name;
    }

    public function getCardExpirationDate()
    {
      return $this->card_expiration_date;
    }

    public function getCardNumber()
    {
      return $this->card_number;
    }

    public function getCardCvv()
    {
      return $this->card_cvv;
    }

  }

?>
