
<?php
$username = '';
if($_SESSION["usertype"] == 1) {
	$username = 'jg6sa_a';
}
else {
	$username = 'jg6sa_b';
}
class DbUtil{
        public static $loginUser = $username;
        public static $loginPass = "CS4750group20!";
        public static $host = "usersrv01.cs.virginia.edu"; // DB Host
        public static $schema = "jg6sa"; // DB Schema

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
