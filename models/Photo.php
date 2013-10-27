<?php

require_once 'ModelBase.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Photo
 *
 * @author Jesse
 */
class Photo extends ModelBase {
    
    public $id;
    public $name;
    public $path;
    public $gallery_id;
    public $gallery_position;
    public $homepage_position;
    
    public function __construct( $name, $path, $gallery_id, $gallery_position, $homepage_position ){
        $this->name = $name;
        $this->path = $path;
        $this->gallery_id = $gallery_id;
        $this->gallery_position = $gallery_position;
        $this->homepage_position = $homepage_position;
    }
    

    public function update( $name, $gallery_position ){
        if( isset($name) ){
            $this->name = $name;
        } 
        if( isset($gallery_position) ){
            $this->gallery_position = $gallery_position;
        } 

        $this->save();
    }
    
    public function updateSlideshow( $position ){
        if( isset($position) ){
            $this->homepage_position = $position;
        } else {
            $this->homepage_position = null;
        }
        $this->save();
    }
    
    protected function save(){
        $homepage_position = ($this->homepage_position ? $this->homepage_position : ' null ');
        if( isset($this->id) ){
            parent::query("update photos set name='".parent::escape($this->name)."', path='".$this->path."', gallery_id=".$this->gallery_id.", gallery_position=".$this->gallery_position.", homepage_position=".$homepage_position." where id=".$this->id);
        } else {
            parent::query("insert into photos (name, path, gallery_id, gallery_position, homepage_position) values ('".parent::escape($this->name)."', '".$this->path."', ".$this->gallery_id.", ".$this->gallery_position.", ".$homepage_position.")");
        }
    }
    
    public function delete() {
        $path =  $_SERVER["DOCUMENT_ROOT"].$this->path;
        if( unlink($path) ){
            parent::query("delete from photos where id=".$this->id);
            $this->id = null;
        } else {
           trigger_error('Unable to delete photo file. Photo was not deleted.');
        }
    }
    

    
    
    
        
    #statics
    
    static public function create( $name, $path, $gallery_id, $gallery_position ){
        $ret = new self( $name, $path, $gallery_id, $gallery_position, null );
        $ret->save();
        $rs = parent::query("select id from photos where gallery_id=".$gallery_id." and gallery_position=".$gallery_position);
        if( $row = mysql_fetch_assoc($rs) ){
            $ret->id = $row['id'];
        }
        return $ret;
    }
    
    static public function find( $id ){
        $rs = parent::query("select * from photos where id=".$id);
        $row = mysql_fetch_assoc($rs);
        if( $row ){
            $ret = new self( $row['name'], $row['path'], $row['gallery_id'], $row['gallery_position'], $row['homepage_position'] );
            $ret->id = $row['id'];
            return $ret;
        } else {
            return null;
        }
    }
    
    static public function all(){
        $rs = parent::query("select * from photos order by gallery_position");
        $ret = array();
        while( $row = mysql_fetch_assoc($rs) ){
            $newimg = new self( $row['name'], $row['path'], $row['gallery_id'], $row['gallery_position'], $row['homepage_position'] );
            $newimg->id = $row['id'];
            array_push($ret, $newimg);
        }
        return $ret;
    }
    
    static public function allForHomepage(){
        $rs = parent::query("select * from photos where homepage_position is not null order by homepage_position asc");
        $ret = array();
        while( $row = mysql_fetch_assoc($rs) ){
            $newimg = new self( $row['name'], $row['path'], $row['gallery_id'], $row['gallery_position'], $row['homepage_position'] );
            $newimg->id = $row['id'];
            array_push($ret, $newimg);
        }
        return $ret;
    }
    
    static public function allNotForHomepage(){
        $rs = parent::query("select * from photos where homepage_position is null order by homepage_position asc");
        $ret = array();
        while( $row = mysql_fetch_assoc($rs) ){
            $newimg = new self( $row['name'], $row['path'], $row['gallery_id'], $row['gallery_position'], $row['homepage_position'] );
            $newimg->id = $row['id'];
            array_push($ret, $newimg);
        }
        return $ret;
    }
    
    static public function allForGallery($gallery_id){
        $rs = parent::query("select * from photos where gallery_id =".$gallery_id);
        $row = mysql_fetch_assoc($rs);
        $ret = array();
        while( $row = mysql_fetch_assoc($rs) ){
            $newimg = new self( $row['name'], $row['path'], $row['gallery_id'], $row['gallery_position'], $row['homepage_position'] );
            $newimg->id = $row['id'];
            array_push($ret, $newimg);
        }
        return $ret;
    }
    
}

?>
