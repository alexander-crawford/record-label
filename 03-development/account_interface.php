<?php
  /**
   * Interface implemented by the three classes of account
   */
  interface Account
  {
    public function getID();
    public function getUsername();
    public function setUsername($username);
    public function authenicate($password);
    public function delete();
    public function getType();
  }
?>
