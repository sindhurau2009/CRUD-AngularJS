<?php
/*
 * DB Class
 * This class is used for database related (connect, get, insert, update, and delete) operations
 * with PHP Data Objects (PDO)
 * @author    CodexWorld.com
 * @url       http://www.codexworld.com
 * @license   http://www.codexworld.com/license
 */
class DB {
    // Database credentials
    private $dbHost     = 'localhost';
    private $dbUsername = 'root';
    private $dbPassword = '';
    private $dbName     = 'evvemi_task';
    public $db;
    
    /*
     * Connect to the database and return db connecction
     */
    public function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            try{
                $conn = new PDO("mysql:host=".$this->dbHost.";dbname=".$this->dbName, $this->dbUsername, $this->dbPassword);
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->db = $conn;
            }catch(PDOException $e){
                die("Failed to connect with MySQL: " . $e->getMessage());
            }
        }
    }
    
    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function getRows($table,$conditions = array()){
		$table1 = 'course';
        $sql = 'SELECT s.id, s.sid, s.sname, s.year, s.gpa, c.cname from student s, course c where s.sid = c.sid';	
		//.$table['id'].' , '.$table['sid'].' , '.$table['name'].' , '.$table['year'].' , '.$table['gpa'].' , '.$table1['course'];
        //$sql .= ' FROM '.$table.' , '.$table1;
		//$sql .= ' WHERE '.$table['sid'].' = '.$table1['sid'];
		
		$query = $this->db->prepare($sql);
        $query->execute();
        
        if($query->rowCount() > 0){
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        return !empty($data)?$data:false;
    }
    
    /*
     * Insert data into the database
     * @param string name of the table
     * @param array the data for inserting into the table
     */
    public function insert($table,$data,$data1,$data2){
		$table1 = 'course';
        if(!empty($data) && is_array($data) && !empty($data1) && is_array($data1)){
            $columns = '';
            $values  = '';
            $i = 0;
           /* if(!array_key_exists('created',$data)){
                $data['created'] = date("Y-m-d H:i:s");
            }
            if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }*/

            $columnString = implode(',', array_keys($data));
            $valueString = ":".implode(',:', array_keys($data));
			
			$colString = implode(',', array_keys($data1));
			$valString = ":".implode(',:',array_keys($data1));
			
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")";
            $sql1 = "INSERT INTO ".$table1." (".$colString.") VALUES (".$valString.")";
			
			$query = $this->db->prepare($sql);
			$query1 = $this->db->prepare($sql1);
			
            foreach($data as $key=>$val){
                $val = htmlspecialchars(strip_tags($val));
                $query->bindValue(':'.$key, $val);
            }
			
			foreach($data1 as $key=>$val){
                $val = htmlspecialchars(strip_tags($val));
                $query1->bindValue(':'.$key, $val);
            }
			
            $insert = $query->execute();
			$ins = $query1->execute();
			
			
			
            if($insert){
                $data2['id'] = $this->db->lastInsertId();
				return $data2;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    /*
     * Update data into the database
     * @param string name of the table
     * @param array the data for updating into the table
     * @param array where condition on updating data
     */
    public function update($table,$data,$data1,$conditions){
		$table1 = 'course';
        if(!empty($data) || is_array($data) || !empty($data1) || is_array($data1)){
            $colvalSet = '';
			$colval = '';
            $whereSql = '';
			$whereSql1 = '';
            $i = 0;
            /*if(!array_key_exists('modified',$data)){
                $data['modified'] = date("Y-m-d H:i:s");
            }*/
            foreach($data as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $val = htmlspecialchars(strip_tags($val));
                $colvalSet .= $pre.$key."='".$val."'";
				//&nnbsp;
				$i++;
            }
			$i = 0;
			foreach($data1 as $key=>$val){
                $pre = ($i > 0)?', ':'';
                $val = htmlspecialchars(strip_tags($val));
                $colval .= $pre.$key."='".$val."'";
				//&nnbsp;
				$i++;
            }
			
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
			
            if(!empty($conditions)&& is_array($conditions)){
                $whereSql1 .= ' WHERE ';
                $i = 0;
                foreach($conditions as $key => $value){
                    $pre = ($i > 0)?' AND ':'';
                    $whereSql1 .= $pre.$key." = '".$value."'";
                    $i++;
                }
            }
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql;
			$sql1 = "UPDATE ".$table1." SET ".$colval.$whereSql1;
            $query = $this->db->prepare($sql);
			$query1 = $this->db->prepare($sql1);
            $update = $query->execute();
			$update1 = $query1->execute();
			if($update)
				return $query->rowCount();
			else if($update1)
				return $query1->rowCount();
			else
				return false;
        }else{
            return false;
        }
    }
    
    /*
     * Delete data from the database
     * @param string name of the table
     * @param array where condition on deleting data
     */
    public function delete($table,$conditions,$conditions1){
        $whereSql = '';
		$table1 = 'course';
        if(!empty($conditions)&& is_array($conditions)){
            $whereSql .= ' WHERE ';
            $i = 0;
            foreach($conditions as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
		$whereSql1 = '';
		if(!empty($conditions1)&& is_array($conditions1)){
            $whereSql1 .= ' WHERE ';
            $i = 0;
            foreach($conditions1 as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $whereSql1 .= $pre.$key." = '".$value."'";
                $i++;
            }
        }
		//$s = "SELECT s.sid from student s, course c where "
        $sql = "DELETE FROM ".$table.$whereSql;
		$sql1 = "DELETE FROM ".$table1.$whereSql1;
        $delete = $this->db->exec($sql);
		$del = $this->db->exec($sql1);
        return $delete?$delete:false;
    }
}