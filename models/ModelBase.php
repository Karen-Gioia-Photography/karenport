<?php
    
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Base
 *
 * @author Jesse
 */
abstract class ModelBase {
    
    static $url = 'localhost';
    static $user = 'unroot';
    static $password = 'unroot';
    static $db = 'karenport';
    static $connection;
    
    
    private static function connect(){
        self::$connection = mysql_connect(self::$url, self::$user, self::$password);
        if (!self::$connection) {
            trigger_error(mysql_error()." in connection");
        }
        $rc2 = mysql_select_db(self::$db, self::$connection);
        if(!$rc2) {
            trigger_error(mysql_error()." in selecting db ".self::$db);
        }
    }
    
    protected function query( $query ){
        if( !isset(self::$connection) ){
            self::connect();
        }
        $rs = mysql_query($query);
        if(!$rs){
            trigger_error(mysql_error()." in query ".$query);
        }
        return $rs;
    }
    
}

?>
