#!/usr/bin/env php
<?php

require_once('./websockets.php');

class echoServer extends WebSocketServer {
  //protected $maxBufferSize = 1048576; //1MB... overkill for an echo server, but potentially plausible for other applications.
  
  protected function process ($user, $message) {
	var_dump("User message " . $message);

	
	
	if(!isset($user->user_id)){
		$user->user_id = $message;
		$this->ids[$user->user_id] = $user->id;
		
		$output = $this->fetchUnreadMessages($user->user_id);
		$this->changeUserStatus($user->user_id, 'online');

      
		$this->send($user,$output);
	} else {
	
		$json = json_decode($message, false);
		
		$data = ['to_id' => $json->to_id, 'message' => $json->message, "from_id" => $user->user_id, "name" => $json->name, "profile_picture" => $json->profile_picture];
		
		
		if(isset($this->ids[$json->to_id]) && isset($this->users[$this->ids[$json->to_id]])){
			$to = $this->users[$this->ids[$json->to_id]];
			
			$this->send($to, json_encode($data));
			$data['status'] = 'read';
			
		} else {
			$data['status'] = 'unread';
		//	$this->sendPushNotification($json->to_id, $json->from_id);
			
		}
	
		
		$result = $this->saveMessage($data);
		
		//die(var_dump($result));
	
	
	}
   
  }
  
  protected function connected ($user) {
    // Do nothing: This is just an echo server, there's no need to track the user.
    // However, if we did care about the users, we would probably have a cookie to
    // parse at this step, would be looking them up in permanent storage, etc.
	
  }
  
  protected function closed ($user) {
    // Do nothing: This is where cleanup would go, in case the user had any sort of
    // open files or other objects associated with them.  This runs after the socket 
    // has been closed, so there is no need to clean up the socket itself here.
	$this->changeUserStatus($user->user_id, 'offline');
	
  }
  
  protected function changeUserStatus($user_id, $status){
	  
	  $data = ['user_id' => $user_id, 'status' => $status];
	  
	  $data_string = json_encode($data);
	  
	  $ch = curl_init('http://borne.io/topfenders/api/chat/change_user_status');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
	);                                                                                                                   
																												 
	$result = curl_exec($ch);
	
	//var_dump($result);
	  
  } 

  /*protected function sendPushNotification($user_id, $from_id){

  	 	$data = ['user_id' => $user_id, 'from_id' => $from_id];
	  
	  	$data_string = json_encode($data);
	  
	  	$ch = curl_init('http://borne.io/topfenders/api/chat/send_push_notification');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
																												 
		$result = curl_exec($ch);
	
		var_dump($result);

  } */
  
  
  protected function fetchUnreadMessages($user_id){
	    $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "http://borne.io/topfenders/api/chat/unread_messages/" . $user_id); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $output = curl_exec($ch); 
        curl_close($ch);
		
		return $output;
	  
  }
  
  protected function saveMessage($data){
	  // save message
																		
		$data_string = json_encode($data);                                                                                   
																		
		$ch = curl_init('http://borne.io/topfenders/api/chat/save_message');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			'Content-Type: application/json',                                                                                
			'Content-Length: ' . strlen($data_string))                                                                       
		);                                                                                                                   
																															 
		$result = curl_exec($ch);
		return $result;
  }
  
}

$echo = new echoServer("178.62.74.40","9000");

try {
  $echo->run();
}
catch (Exception $e) {
  $echo->stdout($e->getMessage());
}
