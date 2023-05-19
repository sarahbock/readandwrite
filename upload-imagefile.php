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
   $valid_ext = array("jpg","png","jpeg","gif");

   $response = 0;

   //default limit is 100kb for fresh hope it's 1000kb (1MB)
   $sizelimit=100*1024; if ($dir === 'freshhope1' || $dir === 'freshhope2' || $dir === 'gathang' || $dir === 'mangarrayi') { $sizelimit=1000*1024; }

   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if ($_FILES['file']['size'] < $sizelimit){//less than 100kb
		  if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
			 $response = 1;
		  }
	  }
   }

   echo $response;
   exit;
}
?>
