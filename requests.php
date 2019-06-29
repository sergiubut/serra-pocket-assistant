<?php

include 'common.php';

$action = $_REQUEST["action"];
$output = "";

switch ($action) {
		
	Case "any_event":
	
	$output=check_for_events();
	  
    break;
	
	Case "send_file":
	
	send_file($_REQUEST["chat_id"],$_REQUEST["file_id"]);
	  
    break;	
	
}

echo $output; 
   
?>