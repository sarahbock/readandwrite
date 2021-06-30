<?php
$dir = $_GET["dir"];
clearstatcache();
if(isset($_FILES['file']['name'])){
   // file name
   $filename = $_FILES['file']['name'];

   // Location
   $location = '../'.$dir.'/img/'.$filename;

   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("jpg","png","jpeg");

   $response = 0;
   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if ($_FILES['file']['size'] < (100*1024)){//less than 100kb
		  if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
			 $response = 1;
		  }
	  }
   }

   echo $response;
   exit;
}
?>
