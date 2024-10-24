<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifications 
{ 
	
    public function send_push_notification_data($device_ids,$jsonData){

        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAAvopqH1c:APA91bGhVUoa-lMUCNQ6atDqICvz5cMLEzlPN4x5LeTCYLr8yuuUIaJoF3cv58mfmb4TOeatB_E6HZQfqD_Kqandoy6NXOT5fxI1DNAzHDcgeLwAD8CTLDuMcA98ixecySJ2LcDh2TNj'; //@TODO PASTE HERE
         
         
    	$fields = array (
            'registration_ids' => $device_ids,
            'data' =>$jsonData
        );
    
        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

    public function send_push_notification_ios($device_ids,$jsonData){

        //API URL of FCM
        $url = 'https://fcm.googleapis.com/fcm/send';
        $api_key = 'AAAAvopqH1c:APA91bGhVUoa-lMUCNQ6atDqICvz5cMLEzlPN4x5LeTCYLr8yuuUIaJoF3cv58mfmb4TOeatB_E6HZQfqD_Kqandoy6NXOT5fxI1DNAzHDcgeLwAD8CTLDuMcA98ixecySJ2LcDh2TNj';// @TODO PASTE HERE
    
    	
    	 $fields = array (
            'registration_ids' => $device_ids,
            'notification' =>$jsonData
        );
    
        //header includes Content type and api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$api_key
        );
                    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
	
} 
