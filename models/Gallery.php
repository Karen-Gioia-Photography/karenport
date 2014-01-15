<?php
require_once 'ModelBase.php';
require_once 'Photo.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Gallery
 *
 * @author Jesse
 */
class Gallery extends ModelBase {
   
    public $id;
    public $name;
    public $description;
	public $layout;
    public $homepage_position;
    
    
    public function __construct( $name, $description, $layout, $homepage_position ){
        $this->name = $name;
        $this->description = $description;
		$this->layout = $layout;
        $this->homepage_position = $homepage_position;
    }
    
    public function update( $name, $description, $layout, $homepage_position ){
        if( isset($name) ){
            $this->name = $name;
        } 
        if( isset($description) ){
            $this->description = $description;
        }
        if( isset($homepage_position) ){
            $this->homepage_position = $homepage_position;
        }
		if( isset($layout) ){
			$this->layout = $layout;
		}
        $this->save();
    }
    
    protected function save(){
        if( isset($this->id) ){
            parent::query("update galleries set name='".parent::escape($this->name)."', description='".parent::escape($this->description)."', homepage_position=".$this->homepage_position.", layout='".$this->layout."' where id=".$this->id);
        } else {
            parent::query("insert into galleries (name, description, layout, homepage_position) values ('".parent::escape($this->name)."', '".parent::escape($this->description)."', '".$this->layout."', ".$this->homepage_position.")");
        }
    }
    
    public function delete() {
        foreach( $this->getPhotos() as $photo ){
            $photo->delete();
        }
        parent::query("delete from galleries where id=".$this->id);
    }
    
        
    public function getPhotos(){
        $rs = parent::query("select * from photos where gallery_id =".$this->id." order by gallery_position asc");
        $ret = array();
        while( $row = mysql_fetch_assoc($rs) ){
            $newimg = new Photo( $row['name'], $row['path'], $row['gallery_id'], $row['gallery_position'], $row['homepage_position'], $row['description'], $row['link'] );
            $newimg->id = $row['id'];
            array_push($ret, $newimg);
        }
        return $ret;
    }
    
    
    
    
    
    
    #statics
    
    static public function create( $name, $description, $layout, $homepage_position ){
        $ret = new self( $name, $description, $layout, $homepage_position );
        $ret->save();
        $rs = parent::query("select id from galleries where name='".$name."'");
        $row = mysql_fetch_assoc($rs);
        if( $row ){
            $ret->id = intval($row['id']);
        }
        return $ret;
    }
    
    static public function find( $id ){
        $rs = parent::query("select * from galleries where id=".$id);
        $row = mysql_fetch_assoc($rs);
        if( $row ){
            $ret = new self( $row['name'], $row['description'], $row['layout'], $row['homepage_position'] );
            $ret->id = $row['id'];
            return $ret;
        } else {
            return null;
        }
    }
    
    static public function all(){
        $rs = parent::query("select * from galleries order by homepage_position asc");
        $ret = array();
        while( $row = mysql_fetch_assoc($rs) ){
            $newgal = new self( $row['name'], $row['description'], $row['layout'], $row['homepage_position'] );
            $newgal->id = $row['id'];
            array_push($ret, $newgal);
        }
        return $ret;
    }
    
}

?>
