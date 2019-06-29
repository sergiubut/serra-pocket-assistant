<?php

$data_filename = 'Data.txt';

//echo 'started'; 

//$id=  "706909101";

//$text='test';

//sendmessage($id,$text);

//$choises =array(array("Da","Nu"));

//sendmessage_choises($id,$text,$choises);
$bot_token= "bot"."892652379:AAGFL_ZBsvXs9hObTteoGFe153oRNANB5nk";



function check_for_events(){
	
	global $data_filename;
	$data = file_get_contents($data_filename);
	return $data;
	
}

function event_processed(){
	global $data_filename;
	
	$data = file_get_contents($data_filename);
	$data = str_replace("yes,","",$data);
	file_put_contents($data_filename, $data);
}

function start_robot($data){
	global $data_filename;
	
	//$text = check_for_events();
	$text="yes,".$data;
	
	file_put_contents($data_filename,$text);
	
}


function sendAnimation($chat_id, $animation_link){
	global $bot_token;
	
	$url = "https://api.telegram.org/$bot_token/sendAnimation";

      $data = http_build_query( array( "chat_id" => $chat_id,"animation" => $animation_link));
         
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded",
              'method'  => 'POST',
              'content' => $data,
          ),
      );

      $context = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
	  
	
}

function sendDocument($chat_id, $doc_link){
	global $bot_token;
	
	$url = "https://api.telegram.org/".$bot_token."/sendDocument";

      $data = http_build_query( array( "chat_id" => $chat_id,"document" => $doc_link));
         
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded",
              'method'  => 'POST',
              'content' => $data,
          ),
      );

      $context = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
	  
	
}

function sendmessage($chat_id,$message_text){
	global $bot_token;
	
	$url = "https://api.telegram.org/".$bot_token."/sendMessage";
	  $resp = array("remove_keyboard" => true);
      $reply_keyboard = json_encode($resp);

      $data = http_build_query( array( 'chat_id' => $chat_id,'text' => $message_text,'reply_markup'=>$reply_keyboard));
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded",
              'method'  => 'POST',
              'content' => $data,
          ),
      );

      $context = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
	
}

function sendmessage_choises($chat_id,$message_text,$choises){
	global $bot_token;
	$url = "https://api.telegram.org/".$bot_token."/sendMessage";
	
	$keyboard = $choises;
	$resp = array("keyboard" => $keyboard,"resize_keyboard" => true,"one_time_keyboard" => true);
      $reply_keyboard = json_encode($resp);

      $data = http_build_query( array( 'chat_id' => $chat_id,'text' => $message_text,'reply_markup'=>$reply_keyboard));
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded",
              'method'  => 'POST',
              'content' => $data,
          ),
      );

      $context = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
	
}

function sendContact($chat_id){
	global $bot_token;
	$url = "https://api.telegram.org/".$bot_token."/sendContact";

      $data = http_build_query( array( 'chat_id' => $chat_id,'phone_number' => '0040774033117','first_name'=>'Sergiu','last_name'=>'Butnaru' ));
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded",
              'method'  => 'POST',
              'content' => $data,
          ),
      );

      $context = stream_context_create( $options );
      $result = file_get_contents( $url, false, $context );
	
}

function create_actions($first_name){

switch ($first_name) {
	case "Sergiu":	
	$keyboard = array(array("givestar","getdocument","giveraise"));
	break;
	
	default:
	$keyboard = array(array("getdocument"));
	break;
		
}
return $keyboard;
}

function handle_raise_request($chat_id){
	
	$link="http://thetanubis.altervista.org/PHP/Telegram/giphy.gif";	
	sendAnimation($chat_id,$link);
	
	sleep(5);	
	
	$response = 'Select employee:';
    $keyboard = array(array("Monalisa Georgescu","Mary Popescu","Lurch Adam"));
    sendmessage_choises($chat_id,$response,$keyboard);
	
}

function handle_raise_confirm($chat_id,$data){
	$link="http://thetanubis.altervista.org/PHP/Telegram/giphy2.gif";	
	sendAnimation($chat_id,$link);
	sleep(5);
	$response = "Then, if you really want it, please wait...";
	sendmessage($chat_id,$response);
	
	start_robot($data);	
	
}

function handle_givestar_confirm($chat_id,$text){

	$data = $text;
	//file_put_contents($data_filename, "chat_id=".$chat_id.",".$text);
	//$response = "Request sent to Robot. Please wait.- ".$data;
	$response = "Request sent to Robot. Please wait.";
	sendmessage($chat_id,$response);

	start_robot($data);	
		
}



function handle_document_request($chat_id,$text){
		$data = "chat_id=".$chat_id.",event=getdocument,name=".$text;
		//file_put_contents($data_filename, "chat_id=".$chat_id.",".$text);
		//$response = "Request sent to Robot. Please wait.- ".$data;
		$response = "Request sent to Robot. Please wait.";
		sendmessage($chat_id,$response);

		start_robot($data);				
		
}

function handle_unkown_request($chat_id){
	
		$response = "I didn't get that. Please contact my HR colleague:";
		sendmessage($chat_id,$response);
		sendContact($chat_id);
        //$response = "Sergiu Butnaru";	
        //sendmessage($chat_id,$response);
		
}

function send_file($chat_id,$file_id){
	$link ="https://drive.google.com/uc?id=".$file_id."&authuser=0&export=download";
	sendDocument($chat_id,$link);
	event_processed();
}






?>
