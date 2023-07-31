<?php

  /**
   *
   */
  class CustomerAccount implements Account
  {

    protected $db;

    protected int $_id;
    protected string $username;
    protected string $password;
    protected int $type;
    protected array $orders;

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

    public function getOrders()
    {
      return $this->orders;
    }

    public function getAllPurchases()
    {
      $results = $this->db->readPurchaseMultiple($this->username);
      $purchases = array();
      if (count($results)!=0) {
        foreach ($results as $result) {
          $album_id = $result['album_id'];
          $album_title = $result['album_title'];
          $album_art = $result['album_art'];
          $album_approval = $result['album_approval'];
          $album_price = $result['album_price'];
          $album = new Album($album_id,$album_title,$album_art,$album_approval,$album_price,array());
          $purchase_payment_id = $result['purchase_payment_id'];
          $purchase_date = $result['purchase_date'];
          $purchase_price = $result['purchase_price'];
          $purchase_card_holder_name = $result['purchase_card_holder_name'];
          $purchase_card_number = $result['purchase_card_number'];
          $purchase_card_expiration_date = $result['purchase_card_expiration_date'];
          $purchase_card_cvv = $result['purchase_card_cvv'];
          $purchase = new Purchase($purchase_payment_id,$album,$purchase_date,$purchase_price,$purchase_card_holder_name,$purchase_card_holder_name,$purchase_card_number,$purchase_card_expiration_date,$purchase_card_cvv);
          array_push($purchases,$purchase);
      }
      }
      return $purchases;
    }

    public function addOrder($order)
    {
      array_push($this->orders,$order);
    }

  }

?>
