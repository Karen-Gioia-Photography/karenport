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
    

    public function update( $name, $path, $gallery_id, $gallery_position, $homepage_position ){
        if( isset($name) ){
            $this->name = $name;
        } 
        if( isset($path) ){
            $this->path = $path;
        } 
        if( isset($gallery_id) ){
            $this->gallery_id = $gallery_id;
        } 
        if( isset($gallery_position) ){
            $this->gallery_position = $gallery_position;
        } 
        if( isset($homepage_position) ){
            $this->homepage_position = $homepage_position;
        }
        $this.save();
    }
    
    protected function save(){
        if( isset($this->id) ){
            parent::query("update photos set name='".$this->name."', path='".$this->path."', gallery_id=".$this->gallery_id.", gallery_position=".$this->gallery_position.", homepage_position=".$this->homepage_position." where id=".$this->id);
        } else {
            $homepage_position = ($this->homepage_position ? $this->homepage_position : ' null ');
            parent::query("insert into photos (name, path, gallery_id, gallery_position, homepage_position) values ('".$this->name."', '".$this->path."', ".$this->gallery_id.", ".$this->gallery_position.", ".$homepage_position.")");
        }
    }
    
    public function delete() {
        parent::query("delete from photos where id=".$this->id);
    }
    

    
    
    
        
    #statics
    
    static public function create( $name, $path, $gallery_id, $gallery_position ){
        $ret = new self( $name, $path, $gallery_id, $gallery_position, null );
        $ret->save();
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
        $rs = parent::query("select * from photos where homepage_position <> null order by homepage_position asc");
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
