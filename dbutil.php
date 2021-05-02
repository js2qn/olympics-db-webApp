
<?php
class DbUtil{
        public static $loginUser = '';
        public static $loginPass = "CS4750group20!";
        public static $host = "usersrv01.cs.virginia.edu"; // DB Host
        public static $schema = "jg6sa"; // DB Schema

        public static function loginConnection(){
                if($_SESSION["usertype"] == 1) {
                        DbUtil::$loginUser = 'jg6sa_a';
                }
                else {
                        DbUtil::$loginUser = 'jg6sa_b';
                }
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
