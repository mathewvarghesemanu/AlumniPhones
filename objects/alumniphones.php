<?php
class alumniphones{

    // database connection and table name
	private $conn;
	private $table_name = "alumniphones";

    // object properties
	public $alumniname;
	public $alumnibatch;
	public $alumniphone;
	public $assignflag;
	public $callcompleteflag;
	public $volunteername;
	public $volunteermailid;
	public $volunteerbatch;
	public $ID;

    // constructor with $db as database connection
	public function __construct($db){
		$this->conn = $db;
	}
// read products
	function read(){

    // select all query
		$query = "SELECT * FROM alumniphones ORDER BY RAND()";

    // prepare query statement
		$stmt = $this->conn->prepare($query);

    // execute query
		$stmt->execute();

		return $stmt;

	}
	function modify(){

    // query to insert record
		$query = "UPDATE
		" . $this->table_name . "
		SET 
		alumniname = :alumniname,
		alumnibatch = :alumnibatch,
		alumniphone = :alumniphone,
		assignflag = :assignflag,
		callcompleteflag = :callcompleteflag,
		volunteername = :volunteername,
		volunteermailid = :volunteermailid,
		volunteerbatch = :volunteerbatch,
		ID = :ID WHERE ID=". $this->ID ."" ;

    // prepare query
		$stmt = $this->conn->prepare($query);

    // sanitize
		$this->alumniname=htmlspecialchars(strip_tags($this->alumniname));
		$this->alumnibatch=htmlspecialchars(strip_tags($this->alumnibatch));
		$this->alumniphone=htmlspecialchars(strip_tags($this->alumniphone));
		$this->assignflag=htmlspecialchars(strip_tags($this->assignflag));
		$this->callcompleteflag=htmlspecialchars(strip_tags($this->callcompleteflag));
		$this->volunteername=htmlspecialchars(strip_tags($this->volunteername));
		$this->volunteermailid=htmlspecialchars(strip_tags($this->volunteermailid));
		$this->volunteerbatch=htmlspecialchars(strip_tags($this->volunteerbatch));
		$this->ID=htmlspecialchars(strip_tags($this->ID));

    // bind values
		$stmt->bindParam(":alumniname", $this->alumniname);
		$stmt->bindParam(":alumnibatch", $this->alumnibatch);
		$stmt->bindParam(":alumniphone", $this->alumniphone);
		$stmt->bindParam(":assignflag", $this->assignflag);
		$stmt->bindParam(":callcompleteflag", $this->callcompleteflag);
		$stmt->bindParam(":volunteername", $this->volunteername);
		$stmt->bindParam(":volunteermailid", $this->volunteermailid);
		$stmt->bindParam(":volunteerbatch", $this->volunteerbatch);
		$stmt->bindParam(":ID", $this->ID);

echo ($this->alumniphone);
    // execute query
		if($stmt->execute()){
			return true;
		}

		return false;

	}
}
?>