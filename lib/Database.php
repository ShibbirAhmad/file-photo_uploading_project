<?php 
class Database{

	public $db_host=DB_HOST;
	public $bd_user=DB_USER;
	public $db_pass=DB_PASS;
	public $db_name=DB_NAME;

	public $link;
	public $error;

	public function __construct() {
           $this->connectionDB();
	}

	private  function connectionDB(){

         $this->link= new mysqli($this->db_host,$this->bd_user,$this->db_pass,$this->db_name);
         
         if(!$this->link){
              $this->error="connection fail..".$this->link->connect_error();
          }


	}

   //data insert function 
    public function insert($data){
       $inserted_row=$this->link->query($data) or die ($this->link->error.__Line__);

       if($inserted_row){
       	return $inserted_row;
       }else {
       	return false;
       }
    }


      //result operation/ function 
     
       public function result($data){
       $result_row=$this->link->query($data) or die ($this->link->error.__Line__);

       if($result_row){
       	return $result_row;
       }else {
       	return false;
       }
    }


    //Delete operation/ function 
     
       public function deleted($data){
       $deleted_row=$this->link->query($data) or die ($this->link->error.__Line__);

       if($deleted_row){
        return $deleted_row;
       }else {
        return false;
       }
    }











}


?>