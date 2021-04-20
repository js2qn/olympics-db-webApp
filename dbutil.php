
<?php
class DbUtil{
        public static $loginUser = "jg6sa";
        public static $loginPass = "CS4750group20!";
        public static $host = "usersrv01.cs.virginia.edu"; // DB Host
        public static $schema = "jg6sa_olympics"; // DB Schema

        public static function loginConnection(){
                $db = new mysqli(DbUtil::$host, DbUtil::$loginUser, DbUtil::$loginPass, DbUtil::$schema);

                if($db->connect_errno){
                        echo("Could not connect to db");
                        $db->close();
                        exit();
                }

                return $db;
        }

}
?>
