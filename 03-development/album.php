<?php

  /**
   *
   */
  class Album
  {

    protected int $_id;
    protected string $title;
    protected string $art;
    protected bool $apporval;
    protected float $price;
    protected array $track;

    function __construct(int $_id,string $title,string $art,bool $approval,float $price,array $tracks)
    {

      $this->_id = $_id;
      $this->title = $title;
      $this->art = $art;
      $this->approval = $approval;
      $this->price = $price;
      $this->tracks = $tracks;

    }

    public function __toString()
    {
      $return = "_id : " . $this->_id . "\n";
      $return .= "title : " . $this->title . "\n";
      $return .= "art : " . $this->art . "\n";
      $approval = ($this->approval) ? 'true' : 'false' ;
      $return .= "approval : " . $approval . "\n";
      $return .= "price : " . $this->price . "\n";
      $return .= "tracks : " . count($this->tracks) . "\n";
      return $return;
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

    public function getArt()
    {
      return $this->art;
    }

    public function setArt($art)
    {
      // TODO: missing call to db
      $this->art = $art;
    }

    public function getApproval()
    {
      return $this->approval;
    }

    public function approve()
    {
      $this->approval = true;
      return $this->approval;
    }

    public function disapprove()
    {
      $this->approval = false;
      return $this->approval;
    }

    public function getPrice()
    {
      return $this->price;
    }

    public function setPrice($price)
    {
      // TODO: missing call to db
      $this->price = $price;
    }

    public function getAllTracks()
    {
      return $this->trackss;
    }

    public function getTrack($track_title)
    {
      foreach ($tracks as $key => $value) {
        // TODO: complete getting track object instance from track title
      }
    }

    public function addTrack($track)
    {
      // TODO: complete function here after creating the track class
    }

    public function delete()
    {
      // TODO: complete function here when sequence diagram is up to date
      // with correct order of events for deleting items ie cascade
    }

  }


?>
