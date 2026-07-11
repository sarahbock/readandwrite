<?php
$dir = isset($_GET["instance"]) ? $_GET["instance"] : '';
clearstatcache();

// Only allow known instance names — prevents path traversal via ?instance=
$allowed_instances = array(
   "group1", "group2", "group3", "group4",
   "group5", "group6", "group7", "group8", "group9",
   "banyjima", "dharug", "flinders", "freshhope1", "freshhope2",
   "gathang", "guugu_yimithirr", "hungarian", "injinoo", "mangarrayi",
   "mpakwithi", "umpila", "wik_mungkan", "sandpit"
);
if(!in_array($dir, $allowed_instances, true)){
   echo 0;
   exit;
}

if(isset($_FILES['file']['name'])){
   // file name — strip any directory components an attacker could inject
   $filename = basename($_FILES['file']['name']);

   // Location
   $location = '../'.$dir.'/img/'.$filename;

   // file extension
   $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("jpg","png","jpeg","gif");

   $response = 0;

   //default limit is 200kb for fresh hope it's 1000kb (1MB)
   $sizelimit=200*1024; if ($dir === 'freshhope1' || $dir === 'freshhope2' || $dir === 'gathang' || $dir === 'mangarrayi') { $sizelimit=1000*1024; }

   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if ($_FILES['file']['size'] < $sizelimit){//less than 200kb
		  if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
			 $response = 1;
		  }
	  }
   }

   echo $response;
   exit;
}
?>
