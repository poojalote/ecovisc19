<?php


require_once './vendor/autoload.php';
use GuzzleHttp\Client;

class SmsModel extends CI_Model
{

    public function sendSMS($number,$templateData,$template,$templateID=1){
        $username="bharatmishra1";
        $password ="bharat@100";
        $sender="GLDBRZ";
        $message="";
        $postData = array(
            'user' => "bharatmishra1",
            'password'=>"bharat@100",
            'mobile' =>$number,
            'sender' => $sender,
            'type' => '3'
        );
		$session_data = $this->session->user_session;
		$branch_id=$session_data->branch_id;
        $getMssageBranch=$this->getMssageBranch($branch_id,$templateData['name'],$templateData['center'],$templateData['bed'],$templateData['room']);
        switch ($templateID){
            case 1:
                $postData["template_id"]=$template;
                $postData['message'] = $getMssageBranch;
                break;
            case 2:
                $postData["template_id"]=$template;
                $postData['message'] = "".$templateData['name']." has been transferred to ".$templateData['center']." in ".$templateData['bed']." in ".$templateData['room']." -Gold Berries";
                break;
            case 3:
                $postData["template_id"]=$template;
                $postData['message'] = "Treatment has been started for ".$templateData['otp']." -Gold Berries";
                $postData['message'] = "OTP for Login Transaction on ".$templateData['company']." is ".$templateData['otp']." and valid till ".$templateData['time'].".Do not share this OTP to anyone for security reasons -Gold Berries";
                break;
        }

        $client = new Client();
        $response = $client->request('GET', 'http://api.bulksmsgateway.in/sendmessage.php', array(
            'query' =>$postData
        ));
     //   var_dump($response);


        return $response->getBody();

    }
    function getMssageBranch($branch_id,$name,$center,$bed,$room){
    	if($branch_id == 2){
			$message="".$name." has been admitted in the ".$center." and has been allotted ".$bed." in ".$room.".Click on https://bit.ly/3oUh7FE to track your details. -Gold Berries";
		}else if($branch_id == 9){
			$message="".$name." has been admitted in the ".$center." and has been allotted ".$bed." in ".$room.".Click on https://bit.ly/3oRFNim to track your details. -Gold Berries";
		}else{
			$message="".$name." has been admitted in the ".$center." and has been allotted ".$bed." in ".$room.". -Gold Berries";
		}

    	return $message;

	}
}
