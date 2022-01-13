<?php

require_once "./vendor/autoload.php";






class SoapController extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	
	function call_api1($p_id,$p_name){
		$client = new SoapClient("http://covidcare.docango.com/Attune.wsdl");
			$api='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:HL72XML>
         <!--Optional:-->
         <tem:HL7Message>MSH|^~\&amp;|HNQ|555^RFH1|LIMS||20210519104717||ORM^O01|10334164|P|2.5
PID|'.$p_id.'||0010274463||'.$p_name.'||19970418|M|||62 Gaurav Apt 6th Floor,^^MUMBAI^^400025^IN||9920863654|9920863654|||||.5222 1118 0099.
PV1|1|O|1GENLABC^^^1LABMED|RF|||CN00000267^'.$p_name.'||CN00000267^'.$p_name.'||||||N00||||1001043466|||||||||||||||||||||||||20210519104535|00000000000000
ORC|XO|0014187229||02586442^0001523445^255C646A0EBD1EDBAE8C2F1BEC404CD9|IP||^^^20210519104713^^001^^E000300^^000001|00155D191A011EE88DE078CCB0E489BB|20210519104716|1MOLBIOC^Molecular Biology Clinic^^1LABMED||CN00000267^Shah^Arun|1GENLABC^^^1LABMED|+919821095542|20140122160928
OBR||0014187229|02586442|LAB-MB396^COVID-19 PCR1^01|1||20210519104713|||||||||CN00000267^'.$p_name.'|+919821095542|||||||||||||||||||20210519104717</tem:HL7Message>
      </tem:HL72XML>
   </soapenv:Body>
</soapenv:Envelope>
';
		$orders = $client->HL72XML($api);
		var_dump($orders);
	}
	
	function getSoapRequest(){
		$p_id=$this->input->post('id');
		$patient_table = $this->session->user_session->patient_table;
		$query=$this->db->query("select patient_name from ".$patient_table." where id=".$p_id);
		if($this->db->affected_rows() > 0){
			$patient_name=$query->row()->patient_name;
			$this->call_api($p_id,$patient_name);
		}else{
			
		}
	}
	
	function call_api($p_id,$p_name){
		$certFile = "../spicemoney.crt";
		$keyFile = "../spicemoney.key";

		$curl = curl_init();
		$api='<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:HL72XML>
         <!--Optional:-->
         <tem:HL7Message>MSH|^~\&amp;|HNQ|555^RFH1|LIMS||20210519104717||ORM^O01|10334164|P|2.5
PID|'.$p_id.'||0010274463||'.$p_name.'||19970418|M|||62 Gaurav Apt 6th Floor,^^MUMBAI^^400025^IN||9920863654|9920863654|||||.5222 1118 0099.
PV1|1|O|1GENLABC^^^1LABMED|RF|||CN00000267^'.$p_name.'||CN00000267^'.$p_name.'||||||N00||||1001043466|||||||||||||||||||||||||20210519104535|00000000000000
ORC|XO|0014187229||02586442^0001523445^255C646A0EBD1EDBAE8C2F1BEC404CD9|IP||^^^20210519104713^^001^^E000300^^000001|00155D191A011EE88DE078CCB0E489BB|20210519104716|1MOLBIOC^Molecular Biology Clinic^^1LABMED||CN00000267^Shah^Arun|1GENLABC^^^1LABMED|+919821095542|20140122160928
OBR||0014187229|02586442|LAB-MB396^COVID-19 PCR1^01|1||20210519104713|||||||||CN00000267^'.$p_name.'|+919821095542|||||||||||||||||||20210519104717</tem:HL7Message>
      </tem:HL72XML>
   </soapenv:Body>
</soapenv:Envelope>
';
			curl_setopt($curl, CURLOPT_SSLKEY, $keyFile);
		  curl_setopt($curl, CURLOPT_SSLCERT, $certFile);

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api-sit.jio.com/attunes/v1/lims?',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS =>$api,
		  CURLOPT_HTTPHEADER => array(
			'x-api-key: l7xx32f3a5d6c43b4004959cc95801d1ccae',
			'Content-Type: text/xml',
			'Cookie: ASP.NET_SessionId=cyolyi55yax12z55e4ooxgnz'
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}

}
