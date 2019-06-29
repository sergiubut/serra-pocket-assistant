<?php
include 'common.php';

$filename = 'Test_File.txt';
$text_received = file_get_contents('php://input');
file_put_contents($filename, $text_received);


$json = (Array)json_decode($text_received);

$message =$json["message"];

$first_name = $message->{'from'}->{'first_name'};

if($first_name !== 'RobotsHandler'){

	$chat_id = $message->{'chat'}->{'id'};
    $text = $message->{'text'};
	

    switch ($text) {
    case "givestar":
		file_put_contents($data_filename, $chat_id.",".$text);
        $response = 'Select coworker';
        $keyboard = array(array("Popeye Ionescu","Robin Lemn","Arnold Svaiter"));
        sendmessage_choises($chat_id,$response,$keyboard);
        break;
        
    case "getdocument":
		file_put_contents($data_filename, $chat_id.",".$text);
        $response = 'Select document';
        $response = "Please type your full name:";
		sendmessage($chat_id,$response);
        break;

   case 'giveraise':
		file_put_contents($data_filename, $chat_id.",".$text);
		handle_raise_request($chat_id);
        break;

        
    case 'Popeye Ionescu':
		file_put_contents($data_filename, "chat_id=".$chat_id.",event=givestar,name=".$text);
        $response = 'Are you sure?';
        $keyboard = array(array("Yes","No"));
        sendmessage_choises($chat_id,$response,$keyboard);
        break;
     
     case 'Robin Lemn':
		file_put_contents($data_filename, "chat_id=".$chat_id.",event=givestar,name=".$text);
        $response = 'Are you sure?';
        $keyboard = array(array("Yes","No"));
        sendmessage_choises($chat_id,$response,$keyboard);
        break;
        
     case 'Arnold Svaiter':
		file_put_contents($data_filename, "chat_id=".$chat_id.",event=givestar,name=".$text);
        $response = 'Are you sure?';
        $keyboard = array(array("Yes","No"));
         sendmessage_choises($chat_id,$response,$keyboard);
        break;
		
	case 'Monalisa Georgescu':
		file_put_contents($data_filename, "chat_id=".$chat_id.",event=giveraise,name=".$text);
        $response = 'Are you sure? You could use that money to go to the Bahamas next year.';
        $keyboard = array(array("Yes","No"));
         sendmessage_choises($chat_id,$response,$keyboard);
        break;
		
	case 'Mary Popescu':
		file_put_contents($data_filename, "chat_id=".$chat_id.",event=giveraise,name=".$text);
        $response = 'Are you sure? You could use that money to go to the Bahamas next year.';
        $keyboard = array(array("Yes","No"));
         sendmessage_choises($chat_id,$response,$keyboard);
        break;
		
	case 'Lurch Adam':
		file_put_contents($data_filename, "chat_id=".$chat_id.",event=giveraise,name=".$text);
        $response = 'Are you sure? You could use that money to go to the Bahamas next year.';
        $keyboard = array(array("Yes","No"));
         sendmessage_choises($chat_id,$response,$keyboard);
        break;
        
     case "/start":
		file_put_contents($data_filename, $chat_id.",".$text);
        $response = 'Hi '.$first_name.'. Select an action bellow:';
		$keyboard = create_actions($first_name);
		//$keyboard = array(array("/givestar","/getdocument"));
         sendmessage_choises($chat_id,$response,$keyboard);
        break;
       
	case "Yes":
			
		$data = check_for_events();		
		
		//$response = "Request sent to HR. You will get notified when it's approved. - ".$data;
		//sendmessage($chat_id,$response);
			
		if (strpos($data, 'giveraise') !== false) {

			handle_raise_confirm($chat_id,$data);
		}
		
		if (strpos($data, 'givestar') !== false) {
			
			handle_givestar_confirm($chat_id,$data);
		}
		//start_robot($data);
		
	
        break;
        
    case "No":
		file_put_contents($data_filename, "chat_id=".$chat_id.",".$text);
        $response = "Request not sent.";
        sendmessage($chat_id,$response);
        break;
		
	case "/chat_id":
		$response = $chat_id;
		sendmessage($chat_id,$response);
        break;
		
    default:
		$data = check_for_events();
		
		if (strpos($data, 'getdocument') !== false) {
			handle_document_request($chat_id,$text);
		}
		
		else{
		handle_unkown_request($chat_id);
				
		}

}
}  

?>
