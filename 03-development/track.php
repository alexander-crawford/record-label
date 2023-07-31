<?php

/**
 *
 */
class Track
{

  protected int $_id;
  protected string $title;
  protected int $number;
  protected string $file;

  function __construct(int $_id,string $title,int $number,string $file)
  {
    $this->_id = $_id;
    $this->title = $title;
    $this->number = $number;
    $this->file = $file;
  }

  public function getID()
  {
    return $this->_id;
  }

  public function getTitle()
  {
    return $this->title;
  }

  public function setTitle($title)
  {
    // TODO: missing call to db
    $this->title = $title;
  }

  public function getNumber()
  {
    return $this->number;
  }

  public function setNumber($number)
  {
    // TODO: missing call to db
    // Two tracks cannot have the same track number
    $this->number = $number;
  }

  public function getFile()
  {
    return $this->file;
  }

  public function setFile($file)
  {
    // TODO: missing call to db
    $this->file = $file;
  }

  public function delete()
  {
    // TODO: complete function here when sequence diagram is up to date
    // with correct order of events for deleting items ie cascade
  }

}


?>
