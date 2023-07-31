<?php

  /**
   *
   */
  abstract class AccountFactory
  {

    protected $db;

    public function __construct()
    {
      global $facade;
      $this->db = $facade->proxy_db;
    }

    abstract public function createAccount(string $username,string $password) : Account;
    public function getAccount($username) : Account
    {
      $result = $this->db->readAccountSingle($username);
      $return = new AdminAccount(-1,"","",-1);
      switch ($result['type']) {
        case '0':
          echo "admin";
          $return = new AdminAccount($result['_id'],$result['username'],$result['password'],$result['type']);
          break;
        case '1':
          $return = new ArtistAccount($result['_id'],$result['username'],$result['password'],$result['type']);
          break;
        case '2':
          $return = new CustomerAccount($result['_id'],$result['username'],$result['password'],$result['type']);
          break;
      }
      return $return;
    }

  }

  /**
   *
   */
  class AdminAccountFactory extends AccountFactory
  {
    // Account type admin with an id of 0

    public function __construct()
    {
      parent::__construct();
    }

    public function createAccount($username,$password) : Account
    {
      $result = $this->db->createAccount($username,$password,0);
      if (count($result)==0) {
        return new AdminAccount(0,"","",-1);
      }else {
        return new AdminAccount($result['_id'],$result['username'],$result['password'],$result['type']);
      }

    }
  }

  /**
   *
   */
  class ArtistAccountFactory extends AccountFactory
  {
    // Account type artist with an id of 1

    public function __construct()
    {
      parent::__construct();
    }

    public function createAccount($username,$password) : Account
    {
      $result = $this->db->createAccount($username,$password,1);
      if (count($result)==0) {
        return new ArtistAccount(0,"","",-1);
      }else {
        return new ArtistAccount($result['_id'],$result['username'],$result['password'],$result['type']);
      }

    }
  }

  /**
   *
   */
  class CustomerAccountFactory extends AccountFactory
  {
    // Account type customer with an id of 2

    public function __construct()
    {
      parent::__construct();
    }

    public function createAccount($username,$password) : Account
    {
      $result = $this->db->createAccount($username,$password,2);
      if (count($result)==0) {
        return new CustomerAccount(0,"","",-1);
      }else {
        return new CustomerAccount($result['_id'],$result['username'],$result['password'],$result['type']);
      }

    }
  }

?>
