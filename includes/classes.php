<?php
class Database{
	//method to create DB tables
	public function set_db_tables(){
		global $dbh;
		$query = $dbh->prepare("CREATE TABLE IF NOT EXISTS Member_details (
						  member_id int(11) NOT NULL AUTO_INCREMENT,
						  member_email varchar(250) NOT NULL,
						  member_name varchar(250) NOT NULL,
						  PRIMARY KEY (member_id),
						  UNIQUE KEY member_email (member_email)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
						CREATE TABLE IF NOT EXISTS Member_school (
						  member_id int(11) NOT NULL,
						  school_id int(11) NOT NULL,
						  PRIMARY KEY (member_id,school_id),
						  KEY fk_school_id (school_id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1;
						CREATE TABLE IF NOT EXISTS School (
						  school_id int(11) NOT NULL AUTO_INCREMENT,
						  school_name varchar(250) NOT NULL,
						  PRIMARY KEY (school_id)
						) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
						ALTER TABLE Member_school
						  ADD CONSTRAINT fk_member_id FOREIGN KEY (member_id) REFERENCES Member_details (member_id) ON DELETE CASCADE,
						  ADD CONSTRAINT fk_school_id FOREIGN KEY (school_id) REFERENCES School (school_id) ON DELETE CASCADE;");
		$query->execute();
		}
}
class School{
	//retrieve everything from School table
	public function fetch_all(){
		global $dbh;
		$query = $dbh->prepare("SELECT * FROM School");
		$query->execute();
		return $query->fetchAll();
	}
	//get school name based on Id
	public function get_school_name($school_id){
		global $dbh;
		$query = $dbh->prepare("SELECT school_name FROM School WHERE school_id = ?");
		$query->bindValue(1, $school_id);
		$query->execute();
		return $query->fetch();
	}
	//get member details based on school Id
	public function get_member_details($school_id){
		global $dbh;
		$query = $dbh->prepare("SELECT member_name, member_email
								FROM Member_details,Member_school
								WHERE Member_school.school_id = ?
								AND Member_school.member_id = Member_details.member_id");
		$query->bindValue(1, $school_id);
		$query->execute();
		return $query->fetchAll();
	}
}

class Members{
	//insert member in DB if email does not already exists
	public function update_member($email, $name, $school){
		global $dbh;
		$query = $dbh->prepare("SELECT member_email FROM Member_details WHERE member_email = ?");
		$query->bindValue(1, $email);
		$query->execute();
		$num = $query->rowCount();
		//if email not in table already insert into Member_deails table
		if($num == 0){
			$query = $dbh->prepare("INSERT INTO Member_details (member_email, member_name)
									VALUES (?, ?)");
			$query->bindValue(1,$email);
			$query->bindValue(2,$name);
			$query->execute();
			$query->closeCursor();
		}
		$query = $dbh->prepare("SELECT school_name FROM School WHERE school_name = ?");
		$query->bindValue(1, $school);
		$query->execute();
		$num = $query->rowCount();
		//if school name not already in School table
		if($num == 0){
			$query = $dbh->prepare("INSERT INTO School (school_name) VALUES (?)");
			$query->bindValue(1, $school);
			$query->execute();
			$query->closeCursor();
		}
		$query = $dbh->prepare("INSERT INTO Member_school (member_id, school_id)
								SELECT Member_details.member_id, School.school_id FROM
								       Member_details, School
								       WHERE Member_details.member_email = ?
										AND School.school_name = ?");
		$query->bindValue(1, $email);
		$query->bindValue(2,$school);
		//update Member_school table with primary keys from Member_details ans School tables and send to index page
		if ($query->execute()){
			$query->closeCursor();
			header('Location: index.php');
		}
		else{
			//if combination of primary keys already exist
			return "This email is already associated with the school you have chosen";
		}
	}
}
?>