<?php 
    include "inc/header.php";
    include "lib/Config.php";
    include "lib/Database.php";

    $db=new Database();

?>


    <div class="mainsection">
   
    
    <?php 
       if($_SERVER['REQUEST_METHOD'] == "POST") 
       {

       	$permited=array('jpg','png','jpeg');
       	$file_name=$_FILES['image']['name'];
       	$file_size=$_FILES['image']['size'];
       	$file_tmp=$_FILES['image']['tmp_name'];
       
        
        $div=explode('.',$file_name);
        $file_extn=strtolower(end($div));
        $uniqe_image=substr(md5(time()),0,10).'.'.$file_extn;
        $uploaded_image="uploads/".$uniqe_image;
       
       if(empty($file_name)) {
            echo "<span class='warning'> please select an image </span>";
       }elseif($file_size>1048576)
       {
       	echo "<span class='warning'> the image should be 1MB or less than 1MB </span>";
       }elseif(in_array($file_extn, $permited) == false){
           echo "<span class='warning'> image format should be 'jpg','png','jpeng' </span>";       
       }else { 

       	move_uploaded_file($file_tmp, $uploaded_image);
       	$query="insert into tbl_photo(photo) values('$uploaded_image')";
       	$inserted=$db->insert($query);
       	if($inserted){
       		echo "<span class='primary'> photo uploaded successfully..</span>";
       	}else 
       	{
       		echo  "<span class='warning'> photo isn't uploaded</span>";
       	}



       	}

       }
    ?>

	 <form action="" method="post" enctype="multipart/form-data">
	 <table class="table" class="table_one"> 
	    <tr>
	    	<td>
			    <input type="file" name="image" />
			</td>
	    </tr>
		
		<tr>
			
			<td> 
			<input type="submit" name="submit" value="upload" />
			</td>
		</tr>
	 </table>
	
	</form>

   
  <table width="100%">
    <tr>
    <th width="30%">Serial No </th>
    <th width="30%">image</th>
    <th width="30%">Action</th>
    </tr>

   <?php 
     
     if(isset($_GET['del'])) {
      $id=$_GET['del'];
        
            $querying="select * from tbl_photo where id=$id ";
            $queryed=$db->result($querying);
          if($queryed) {
     
       while($delimg= $queryed->fetch_assoc()){
         $delete_image=$delimg['image'];
         unlink($delete_image);
       }
      }

      $query="delete from tbl_photo where id='$id' ";
      $del=$db->deleted($query);
      if($del){
          echo "<span class='primary'> photo Deleted successfully..</span>";
      }else {
        echo "<span class='warning'> photo isn't Deleted..</span>";
      }
     }

     $query="SELECT * FROM tbl_photo ";
     $getimage=$db->result($query);
     if($getimage){
         $i=0;
     while($result = $getimage->fetch_assoc()){
           $i++;
       ?>         
   

   <tr>
    <td>  <?php echo $i;  ?>   </td>
    <td>    <img src="<?php echo $result['image']; ?>" height="70px" width="100px" />
  </td>
    <td> <a href="?del=<?php echo $result['id']; ?>"> Delete </a>  </td>  
   </tr>
          
  <?php  }   } ?>
  </table>	
           
 
	</div>
 <?php 
   include "inc/footer.php";
?> 

	