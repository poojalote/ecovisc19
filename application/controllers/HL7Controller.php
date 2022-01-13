<?php

require_once "./vendor/autoload.php";

use Aranyasen\HL7\Message;

use Aranyasen\HL7\Segment;
use Aranyasen\HL7\Segments\MSH;
use Aranyasen\HL7\Segments\ORC;
use Aranyasen\HL7\Segments\PV1;
use Aranyasen\HL7\Segments\OBR;

// If MSH is used
use Aranyasen\HL7\Segments\PID;
use Aranyasen\HL7\Messages\ACK;


require_once 'HexaController.php';
header("Access-Control-Allow-Origin: http://localhost:8080/new_covid/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


/**
 * @property  MasterModel MasterModel
 */
class HL7Controller extends HexaController
{

	private $sampleToken = "3238cd41307062a8256c427ac9723baa";
	private $patientDetails =
		array("Set ID – Patient ID", "Patient ID (External ID)", "Patient ID (Internal ID)", "Alternate Patient ID – PID",
			"Alternate Patient ID – PID", "Patient Name", "Mother’s Maiden Name", "Date/Time of Birth", "Sex", "Patient Alias", "Patient Alias", "Race", "Patient Address", "Country Code"
		, "Phone Number – Home", "Phone Number – Business", "Primary Language", "Marital Status", "Religion", "Patient Account Number", "SSN Number – Patient", "Driver’s License Number – Patient",
			"Mother’s Identifier", "Ethnic Group", "Birth Place", "Multiple Birth Indicator", "Birth Order", "Citizenship", "Veterans Military Status", "Nationality", "Patient Death Date and Time",
			"Patient Death Indicator");
	private $OBR = array(
		"Segment Type ID", "Sequence No", "Placer Order Number", "Filler Order Number", "Observation Battery Identifier", "LOINC Code (Order)", "LOINC Description", "Name of Coding System",
		"Name of Coding System", "Alternate Identifier", "Alternate Description", "Name of Alternate Coding System", "Priority",
		"Requested Date/Time", "Observation /Specimen Collection Date/Time ", "Observation End Date/Time", "Collection Volume", "Collector Identifier", "Specimen Action Code",
		"Danger Code", "Relevant Clinical Information", "Specimen Received Date/Time", "Ordering Provider", "Alternate Specimen ID", "Result Date/Time",
		"Result Status", "Parent Result", "(Required if OBR.11 is G)", "Parent Observation Identifier", "Identifier", "Coding System Name", "Alternate Identifier",
		"Alternate Text", "Alternate Coding System Name", "Parent Observation Sub Identifier", "Courtesy Copies To", "Link to Parent Order", "Parent Universal Service Identifier",
		"(Required if OBR.11 is G)"
	);
	private $OBX = array(
		"Segment Type ID", "Sequence Number", "Type Value", "Observation Identifier", "Observation Sub-ID", "Observation Value", "Units", "References Range",
		"Abnormal Flags", "Observation Result Status", "Date Last Observation Normal Values", "User Defined Access Checks", "Date/Time of the Observation",
		"Producer’s ID", "Performing Organization Name", "Performing Organization Address", "Performing Organization Medical Director");

	private $MSH = array(
		"Segment Type ID", "Encoding Characters", "Sending Application", "Sending Facility", "Receiving Application", "Receiving Facility",
		"Message Date & Time", "Security", "Message Type", "Message Control ID", "Processing ID", "Version ID", "Accept Acknowledgement", "Application Acknowledgement",
		"Message Profile", "Identifier");

	private $ORC = array(
		"Segment Type ID", "Order Control", "Place Order Number", "Filler Order Number", "Placer Group Number", "Order Status", "Response Flag", "Quantity/Timing",
		"Parent", "Date/Time of Transaction", "Entered By", "Verified By", "Ordering Provider");

	private $PV1 = array(
		"Segment Type ID", "Sequence Number", "Patient Class", "Assigned Patient Location", "Admission Type", "Pre-admit Number", "Prior Patient Location", "Attending Doctor",
		"Referring Provider", "Visit ID");

	/**
	 * HL7Controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("MasterModel");
	}

	public function apiHL7String()
	{
		$validObject = $this->is_parameter(array("patient_id", "order_number"));

		if ($validObject->status) {
			$patient_id = $validObject->param->patient_id;
			$order_number = $validObject->param->order_number;

			$branch_id = $this->session->user_session->branch_id;
			$company_id = $this->session->user_session->company_id;

			$where = array(
				'branch_id' => $branch_id,
				'company_id' => $company_id,
				'confirm_service_given' => 1,
				'service_category' => "PATHOLOGY",
				'sample_pickup' => 0,
				'patient_id' => $patient_id
			);

			$patientResultObject = $this->MasterModel->_select("com_1_patient", array("id" => $patient_id),
				array("patient_name", "gender", "adhar_no", "birth_date", "address", "district", "pin_code", "admission_date", "id", "contact", "roomid",
					"(select bed_name from com_1_bed b where b.id=bed_id) as bed_name", "(select CONCAT(r.room_no,r.ward_no) from com_1_room r where r.id=roomid) as room_name"));

			$staticValues = array();
			if ($patientResultObject->totalCount > 0) {
				try {
					//$msg = new Message(null, array('SEGMENT_SEPARATOR' => '\r\n', 'HL7_VERSION' => '2.3'), false, false, false, null);
					$msg = new Message();
					$this->load->model('Global_model');
					$samplePickupNumber = $this->Global_model->generate_order("select sample_pickup_no from service_order where sample_pickup_no='#id'");
					$orderNumber = explode("_", $samplePickupNumber);
					$msh = new MSH();
					$msh->setMessageControlId("99001" . $orderNumber[1]);
					$msh->setMessageType(array("ORM", "O01"));
					$msh->setSendingFacility(array("355", "NSCI"));
					$msh->setSendingApplication("HNQ");
					$msh->setReceivingApplication("LIMS");
					$msh->setProcessingId("P");
					$msh->clearField(13);
					$msh->clearField(14);
					$msh->clearField(15);
					$msh->clearField(16);
					$msh->clearField(17);
					$msh->clearField(18);
					$msh->clearField(19);
					$msh->clearField(20);
					array_push($staticValues, "HNQ", "LIMS", "355", "RFH1", "ORM", "O01", "ORM_O01");
					$msg->addSegment($msh);

					$patient = $patientResultObject->data;
					$name = explode(" ", trim($patient->patient_name));
					$firstname = array_key_exists(0, $name) ? $name[0] : '';
					$middlename = array_key_exists(1, $name) && count($name) >=2 ? $name[1] : '';
					$lastname = array_key_exists(2, $name) ? $name[2] : '';
					$sex = (int)$patient->gender == 1 ? 'M' : 'F';
					$response["patientName"] = trim($patient->patient_name);
					$pid = new PID();

					$pid->setPatientIdentifierList(str_pad($patient->id, 10, "0", STR_PAD_LEFT));
					$pid->setPatientName(array($lastname, $firstname, $middlename, "", "", "", "")); // Use a setter method to add patient's name at standard position (PID.5)

					$pid->setDateTimeOfBirth(date('Ymd', strtotime($patient->birth_date)));
					$pid->setSex($sex);
					$address = $patient->address;
					$pid->setPatientAddress(array($address, "", trim($patient->district), "", trim($patient->pin_code), "IN"));
					$pid->setPatientAlias("");
					array_push($staticValues, "IN");
					$pid->setPhoneNumberHome(trim($patient->contact));
					$pid->setPhoneNumberBusiness(trim($patient->contact));
					$pid->clearField(15);
					$pid->clearField(16);
					$pid->clearField(17);
					$pid->clearField(18);
					$pid->clearField(19);
					$pid->clearField(20);
					$pid->clearField(21);
					$pid->clearField(22);
					$pid->clearField(23);
					$pid->clearField(24);
					$pid->clearField(25);
					$pid->clearField(26);
					$pid->clearField(27);
					$pid->clearField(28);
					$pid->clearField(29);
					$pid->clearField(30);
					$pid->clearField(31);
					$pid->clearField(32);
					$pid->clearField(33);
					$pid->clearField(34);
					$pid->clearField(35);
					$pid->clearField(36);
					$pid->clearField(37);
					$pid->clearField(38);

					$msg->addSegment($pid);
					$room_id = $patient->roomid;
					$bed_name = $patient->bed_name;
					$pv1 = new PV1();
					$pv1->setPatientClass("I");
					$pv1->setAssignedPatientLocation(array("NSCI",$room_id , $bed_name, ""));
					$pv1->setAdmissionType("ER");
					$pv1->setAttendingDoctor(array("NSCI000001", "Vivek", "Kumar", "", "", "", ""));
					$pv1->setConsultingDoctor(array("NSCI000001", "Vivek", "Kumar", "", "", "", ""));
					array_push($staticValues, array("NSCI000001", "Vivek", "Kumar"));
					$pv1->setAdmitDateTime(date('Ymdhi', strtotime($patient->admission_date)));
					$pv1->setAmbulatoryStatus("N00");

					$visitorNo = str_pad(trim($patient->adhar_no), 10, "0", STR_PAD_LEFT);
					$pv1->setVisitNumber($visitorNo);
					$pv1->setDischargeDateTime("00000000000000");
					$pv1->setCurrentPatientBalance(null);
					$pv1->clearField(46);
					$pv1->clearField(47);
					$pv1->clearField(48);
					$pv1->clearField(49);
					$pv1->clearField(50);
					$pv1->clearField(51);

					$msg->addSegment($pv1);

					$ordersResultObject = $this->MasterModel->_select("service_order o ",
						$where, array("o.*", "(select service_name from service_master where service_no=o.service_no group by service_no) as service_name"), false);
					if ($ordersResultObject->totalCount > 0) {
						$serviceOrders = array();
						$serviceCode = array();
						$serviceName = array();
						foreach ($ordersResultObject->data as $service) {

							$orc = new ORC();
							$orc->setOrderControl("NW");
							array_push($staticValues, "NW");

							$service_id = str_pad($service->id, 6, "0");
							$id = 1000000010 + (int)$service->id;
							array_push($serviceOrders, "AA" . str_pad($service->id, 8, "0"));
							$orc->setPlacerOrderNumber($id);
							$orc->setPlacerGroupNumber(array("", "", ""));
							$orc->setOrderStatus("IP");
							$orc->setQuantityTiming(array("", "", "", date('Ymdhis'), "", "001", "", "", "", ""));
							$orc->setParentOrder("");
							$orc->setOrderingProvider(array("NSCI000001", "Kumar", "Vivek", "", "", "", ""));
							$orc->setEnterersLocation(array("NSCI", $room_id,$bed_name, ""));
							$orc->setDateTimeofTransaction(date('Ymdhis'));
							//$orc->setEnteredBy(array(trim($service->service_no), str_replace(' ', '', trim($service->service_name)), "", trim($service->service_no)));
							$orc->setEnteredBy(array("","","",""));
							$orc->setCallBackPhoneNumber(null);
							$orc->setOrderEffectiveDateTime(date('Ymdhis'));
							$orc->clearField(14);
//							$orc->clearField(15);
							$orc->clearField(16);
							$orc->clearField(17);
							$orc->clearField(18);
							$orc->clearField(19);
							$orc->clearField(20);
							$orc->clearField(21);
							$orc->clearField(22);
							$orc->clearField(23);
							$orc->clearField(24);
							$orc->clearField(25);
							$orc->clearField(26);
							$orc->clearField(27);
							$orc->clearField(28);
							$orc->clearField(29);
							$orc->clearField(30);
							array_push($serviceCode, $service->service_id);
							array_push($serviceName, $service->service_detail);
							array_push($staticValues, "NSCI");
							array_push($staticValues, "NSCI000001", "Kumar", "Vivek");
							$msg->addSegment($orc);

							$obr = new OBR();
							$obr->clearField(1);
							$obr->setPlacerOrderNumber($id);
							//$obr->setUniversalServiceID(array(trim("LAB-BC092"), str_replace(' ', '', trim("Sodium")), "01"));
							$obr->setUniversalServiceID(array(trim($service->service_id), str_replace(' ', '', trim($service->service_detail)), "01"));
							$obr->setObservationDateTime(date('Ymdhis'));
							$obr->setOrderingProvider(array("NSCI000001", "Kumar", "Vivek", "", "", "", ""));
							$obr->setScheduledDateTime(date('Ymdhis'));
							$obr->setPriority("1");
							$obr->clearField(17);
							$obr->clearField(18);
							$obr->clearField(19);
							$obr->clearField(20);
							$obr->clearField(21);
							$obr->clearField(22);
							$obr->clearField(23);
							$obr->clearField(24);
							$obr->clearField(25);
							$obr->clearField(26);
							$obr->clearField(27);
							$obr->clearField(28);
							$obr->clearField(29);
							$obr->clearField(30);
							$obr->clearField(31);
							$obr->clearField(32);
							$obr->clearField(33);
							$obr->clearField(34);
							$obr->clearField(35);
//							$obr->clearField(36);
							$obr->clearField(37);
							$obr->clearField(38);
							$obr->clearField(39);
							$obr->clearField(40);
							$obr->clearField(41);
							$obr->clearField(42);
							$obr->clearField(43);
							$obr->clearField(44);
							$obr->clearField(45);
							$obr->clearField(46);
							$obr->clearField(47);
							$obr->clearField(48);
							$obr->clearField(49);
							array_push($staticValues, "EN37500390", "Kumar", "Vivek");

							$msg->addSegment($obr);
							break;
						}
						$response["status"] = 200;
						$response["serviceOrders"] = $serviceOrders;
						$response["serviceCode"] = $serviceCode;
						$response["serviceName"] = $serviceName;
						$response["staticValues"] = $staticValues;
						$hl7 = $this->str_replace_first('&', '&amp;', $msg->toString(true));

						//$hl7 = $msg->toString(true);
						$hl7String = '
					<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
					   <soapenv:Header/>
					   <soapenv:Body>
						  <tem:HL72XML>
							 <tem:HL7Message>' .trim(str_replace(' ', '', $hl7)). '</tem:HL7Message>
						  </tem:HL72XML>
					   </soapenv:Body>
					</soapenv:Envelope>';
						$response["raw"] = str_replace(' ', '', $hl7);
						$response["body"] = trim($hl7String);

					} else {
						$response["status"] = 201;
						$response["body"] = "Service Not Found";
					}
				} catch (\Aranyasen\Exceptions\HL7Exception $e) {
				} catch (ReflectionException $e) {
				}
			} else {
				$response["status"] = 201;
				$response["body"] = "Patient Not Found";
			}

		} else {
			$response["status"] = 201;
			$response["body"] = "Required Parameter Missing";
		}
		echo json_encode($response);
	}

	public function apiSendRequest()
	{
		if (!is_null($this->input->post("hl7string"))) {
			$hl7string = $this->input->post("hl7string");
			$this->apiSitJio($hl7string);
		} else {
			$outputResponse["status"] = 203;
			$outputResponse["body"] = "Missing Parameter";
			echo json_encode($outputResponse);
		}

	}

	public function getResponseText()
	{
		$resultObject = $this->MasterModel->_rawQuery("select * from hl_response order by create_on desc");
		$data = array();
		if ($resultObject->totalCount > 0) {

			foreach ($resultObject->data as $responseText) {
				$data[] = array(
					$responseText->response_text,
					$responseText->create_on,
				);
			}
			$results = array(
				"draw" => (int)isset($_POST['draw']),
				"recordsTotal" => $resultObject->totalCount,
				"recordsFiltered" => $resultObject->totalCount,
				"data" => $data
			);
		} else {
			$results = array(
				"draw" => (int)isset($_POST['draw']),
				"recordsTotal" => $resultObject->totalCount,
				"recordsFiltered" => $resultObject->totalCount,
				"data" => $data
			);
		}
		echo json_encode($results);
	}

	public function createNewMessage()
	{


		$msg = new Message();
		$msh = new MSH();
		$randomNo = mt_rand(100000, 999999);
		$msh->setMessageControlId($randomNo);
		$msh->setMessageType(array("ORM", "O01", "ORM_O01"));

		$msh->setSendingFacility(array("355", "RFH1"));
		$msh->setSendingApplication("HNQ");
		$msh->setReceivingApplication("LIMS");
		$msh->setProcessingId("P");
		$msg->addSegment($msh);
		$id = $this->input->post("id");
		$codes = $this->input->post("codes");

		$resultObject = $this->MasterModel->_select("com_1_patient", array("id" => $id),
			array("patient_name", "gender", "birth_date", "address", "district", "pin_code", "admission_date", "id", "contact",
				"(select bed_name from com_1_bed b where b.id=bed_id) as bed_name", "(select CONCAT(r.room_no,r.ward_no) from com_1_room r where r.id=roomid) as room_name"));

		if ($resultObject->totalCount > 0) {

			$patient = $resultObject->data;
			$pid = new PID(); // Automatically creates PID segment, and adds segment index at PID.1
			$name = explode(" ", $patient->patient_name);
			$firstname = array_key_exists(0, $name) ? $name[0] : '';
			$middlename = array_key_exists(1, $name) ? $name[1] : '';
			$lastname = array_key_exists(2, $name) ? $name[2] : '';
			$sex = (int)$patient->gender == 1 ? 'M' : 'F';
			$suffix = (int)$patient->gender == 1 ? 'Mr' : 'Mrs';
			$pid->setPatientID(str_pad($patient->id, 10, "0", STR_PAD_LEFT));
			$pid->setPatientName(array($lastname, $firstname, $middlename)); // Use a setter method to add patient's name at standard position (PID.5)
			$pid->setSex($sex);
			$pid->setPatientClass("I");
			$pid->setDateTimeOfBirth(date('Ymd', strtotime($patient->birth_date)));
			$pid->setPatientAddress(array($patient->address, "", $patient->district, "MAHARASHTRA", $patient->pin_code, "IN"));
			$pid->setPhoneNumberHome($patient->contact);
			$msg->addSegment($pid);

			$pv1 = new PV1();
			$pv1->setPatientClass("I");
			$pv1->setAssignedPatientLocation(array("1T06S", $patient->room_name, $patient->bed_name));
			$pv1->setConsultingDoctor(array("EN15002960", "Vivek", "Kumar"));
			$pv1->setAdmitDateTime(date('Ymdhi', strtotime($patient->admission_date)));
			//$pv1->setAmbulatoryStatus("A0");
			$visitorNo = mt_rand(100000, 999999);
			$pv1->setCaseNumber($visitorNo);

			$msg->addSegment($pv1);
			$serviceIds = implode(",", $codes);
			$serviceOrderResult = $this->MasterModel->_rawQuery("select * from service_master where id in (" . $serviceIds . ")");
			if ($serviceOrderResult->totalCount > 0) {
				foreach ($serviceOrderResult->data as $service) {
					$orc = new ORC();
					$orc->setOrderControl("NW");
					$service_id = str_pad($service->id, 8, "0");
					$orc->setPlacerOrderNumber($service_id);
					$orc->setOrderStatus("IP");
					$orc->setQuantityTiming(array("", "", "", "20210609113216", "", "1"));
					$orc->setDateTimeofTransaction(date('Ymdhi'));
					$orc->setEnteredBy(array("2506", $service->service_name, "", $service->service_no));
					$msg->addSegment($orc);

					$obr = new OBR();
					$obr->setPlacerOrderNumber($service_id);
					$obr->setUniversalServiceID(array($service->service_no, $service->service_description));
					$obr->setPriority("1");
					//$obr->setObservationDateTime(date('Ymd', strtotime($patient->admission_date)));
					$obr->setScheduledDateTime(date('Ymdhi'));
					$msg->addSegment($obr);
				}
			}
		}

		$hl = $this->str_replace_first('&', '&amp;', $msg->toString(true));
		echo $hl;
//		$this->apiSitJio($hl);
	}

	function str_replace_first($from, $to, $content)
	{
		$from = '/' . preg_quote($from, '/') . '/';

		return preg_replace($from, $to, $content, 1);
	}

	public function apiSitJio($HL7string)
	{
		try {
			$curl = curl_init();
			//$certFile = "D:\\HexaClanPhpProject\\htdocs\\new_covid\\healthstart\\spicemoney.crt";
			$certFile = "/var/www/html/healthstart/spicemoney.crt";
			//$keyFile = "D:\\HexaClanPhpProject\\htdocs\\new_covid\\healthstart\\spicemoney.key";
			$keyFile = "/var/www/html/healthstart/spicemoney.key";
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://api-sit.jio.com/attunes/v1/lims',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_POST => False,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSLCERT => $certFile,
				CURLOPT_SSLKEY => $keyFile,
				CURLOPT_POSTFIELDS => $HL7string,
//				CURLOPT_POSTFIELDS => '
//				<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
//				   <soapenv:Header/>
//				   <soapenv:Body>
//					  <tem:HL72XML>
//						 <tem:HL7Message>' . $HL7string . '</tem:HL7Message>
//					  </tem:HL72XML>
//				   </soapenv:Body>
//				</soapenv:Envelope>',
				CURLOPT_HTTPHEADER => array(
					'x-api-key: l7xx32f3a5d6c43b4004959cc95801d1ccae',
					'Content-Type: text/xml',
				),
			));
			$response = curl_exec($curl);
			if ($response === false) {
				throw new Exception(curl_error($curl), curl_errno($curl));
			}
			$outputResponse["raw"] = $response;

			$soap = simplexml_load_string($response);
			$soapResponse = $soap->children('http://schemas.xmlsoap.org/soap/envelope/')->Body->children()->HL72XMLResponse->HL72XMLResult;
			if ((int)$soapResponse == 1) {
				$outputResponse["status"] = 200;
				$outputResponse["body"] = "done";
			} else {
				$outputResponse["status"] = 201;
				$outputResponse["error"] = $soapResponse;
			}
			curl_close($curl);

		} catch (Exception $exception) {
			$outputResponse["status"] = 202;
			$outputResponse["error"] = $exception;

		}
		echo json_encode($outputResponse);
	}

	public function readMessage()
	{
		$hl7string = $this->input->raw_input_stream;
		$msg = new Message($hl7string);
		$pid = $msg->getFirstSegmentInstance("PID");

		$patientData = array();
		foreach ($this->patientDetails as $index => $header) {
			array_push($patientData, array(
				"header" => $header,
				"value" => $pid->getField($index)
			));
		}

		$this->db->insert_batch("hl_data", $patientData);

		$msg = new Message($hl7string, null, true);
		$ackResponse = new ACK($msg);

	}

	public function soapCall()
	{
		$wsdl = 'https://covidcare.docango.com/Attune.wsdl';
		$endpoint = 'https://api-sit.jio.com/attunes/v1/lims';

		$options = array(
			'location' => $endpoint,
			'keep_alive' => true,
			'trace' => true,

			'x-api-key' => 'l7xx32f3a5d6c43b4004959cc95801d1ccae'
		);
		try {

			$soapClient = new SoapClient($wsdl, $options);
			$ver = array(
				"HL7Message" => "MSH|^~\&amp;|HNQ|555^RFH1|LIMS||20210519104717||ORM^O01|10334164|P|2.5
PID|1||0010274463||Shah^Arjun||19970418|M|||62 Gaurav Apt 6th Floor,^^MUMBAI^^400025^IN||9920863654|9920863654|||||.5222 1118 0099.
PV1|1|O|1GENLABC^^^1LABMED|RF|||CN00000267^Shah^Arun||CN00000267^Shah^Arun||||||N00||||1001043466|||||||||||||||||||||||||20210519104535|00000000000000
ORC|XO|0014187229||02586442^0001523445^255C646A0EBD1EDBAE8C2F1BEC404CD9|IP||^^^20210519104713^^001^^E000300^^000001|00155D191A011EE88DE078CCB0E489BB|20210519104716|1MOLBIOC^Molecular Biology Clinic^^1LABMED||CN00000267^Shah^Arun|1GENLABC^^^1LABMED|+919821095542|20140122160928
OBR||0014187229|02586442|LAB-MB396^COVID-19 PCR1^01|1||20210519104713|||||||||CN00000267^Shah^Arun|+919821095542|||||||||||||||||||20210519104717
");
			$quates = $soapClient->__soapCall('HL72XML', $ver);
			var_dump($quates);

		} catch (SoapFault $e) {
//			var_dump($e);
			echo $e->getMessage();
		}
	}

	public function labReportApi()
	{
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			// get posted data
			$header = apache_request_headers();

			//$authorization = $header["authorization"];
			$authorization = $this->sampleToken;
			if ($authorization == $this->sampleToken) {
				// authorized request
				$inputXMLData = file_get_contents("php://input");

				$responseResultObject = $this->MasterModel->_insert("hl_response", array("response_text" => $inputXMLData, "create_on" => date("Y-m-d H:i:s")));
				if ($responseResultObject->status) {
					try {
						$xml = simplexml_load_string($inputXMLData);
						if ($xml === false) {
							$response["status"] = 201;
							log_message("error","XML Parse Error");
							foreach (libxml_get_errors() as $error) {
								$response["error"][] = $error->message;
							}
							$response["body"] = "Invalid XML Data";
							echo json_encode($response);
							exit();
						} else {
							$array_data = json_decode(json_encode(simplexml_load_string($inputXMLData)), true);

							if (array_key_exists('Message', $array_data)) {

								$hl7string = preg_replace('/&(?!#?[a-z0-9]+;)/', '&', trim($array_data["Message"]));
								$hl7string = $this->str_replace_first('&amp;', '&', trim($array_data["Message"]));


								$msg = new Message($hl7string);
								$PID = $msg->getFirstSegmentInstance("PID");
								if (!is_null($PID)) {
									$patientDetails = $this->getPatientDetails($PID);
								} else {
									$patientDetails = null;
								}
								$MSHValues = $msg->getFirstSegmentInstance("MSH");
								if (!is_null($MSHValues)) {
									$mshDetails = $this->getMSH($MSHValues);
								} else {
									$mshDetails = null;
								}

								$OBRValues = $msg->getSegmentsByName("OBR");
								if (!is_null($OBRValues)) {
									$OBRDetails = $this->getOBRValues($OBRValues);
								} else {
									$OBRDetails = null;
								}

								$OBXValues = $msg->getSegmentsByName("OBX");
								if (!is_null($OBXValues)) {
									$OBXDetails = $this->getOBXValues($OBXValues);
								} else {
									$OBXDetails = null;
								}

								$ORCValues = $msg->getSegmentsByName("ORC");
								if (!is_null($ORCValues)) {
									$ORCDetails = $this->getORCValues($ORCValues);
								} else {
									$ORCDetails = null;
								}

								$PV1Values = $msg->getSegmentsByName("PV1");
								if (!is_null($PV1Values)) {
									$PV1Details = $this->getPV1($PV1Values);
								} else {
									$PV1Details = null;
								}

								$HL7Object = new stdClass();
								$HL7Object->pid = $patientDetails;
								$HL7Object->MSH = $mshDetails;
								$HL7Object->OBR = $OBRDetails;
								$HL7Object->OBX = $OBXDetails;
								$HL7Object->ORC = $ORCDetails;
								$HL7Object->PV1 = $PV1Details;
								$resultObject = $this->saveOperation($HL7Object);
								if ($resultObject->status) {
									$response["code"] = 200;
									$response["message"] = "Done";
								} else {
									$response["code"] = 201;
									$response["message"] = $resultObject->error;
								}

							} else {
								$response["code"] = 201;
								$response["message"] = "Invalid XML";
							}
						}
					} catch (\Aranyasen\Exceptions\HL7Exception $e) {
						$response["code"] = 201;
						$response["message"] = "Invalid HL7 String";
					} catch (ReflectionException $e) {
						$response["code"] = 201;
						$response["message"] = "Invalid HL7 String";
					} catch (Exception $exception) {
						$response["code"] = 201;
						$response["message"] = $exception->getMessage();
					}
				} else {
					$response["code"] = 201;
					$response["message"] = "Failed";
				}
			} else {
				$response["code"] = 201;
				$response["message"] = "Invalid Request";
			}

		} else {
			$response["code"] = 403;
			$response["message"] = "Invalid Request";
		}
		echo json_encode($response);

	}

	function saveOperation($object)
	{

		$resultObject = new stdClass();
		try {
			$this->db->trans_start();
			$patientID = null;
			if (!is_null($object->pid)) {
				foreach ($object->pid as $segment) {
					if ($segment["header"] == $this->patientDetails[2]) {
						$patientID = $segment['value'];
						break;
					}
				}
				if (!is_null($patientID)) {
					$patientData = array();
					foreach ($object->pid as $segment) {
						$segment["patient_id"] = $patientID;
						array_push($patientData, $segment);
					}
					$this->db->insert_batch("hl_data", $patientData);
				} else {
					$this->db->trans_rollback();
					$this->db->trans_complete();
					$resultObject->status = FALSE;
					$resultObject->error = "Patient ID Not Found";
					return $resultObject;
				}
			}
			if (!is_null($patientID)) {
				if (count($object->MSH) > 0) {
					$mhsData = array();
					foreach ($object->MSH as $segment) {
						$segment["patient_id"] = $patientID;
						array_push($mhsData, $segment);
					}
					$this->db->insert_batch("hl_data", $mhsData);
				}
				if (count($object->PV1) > 0) {
					$pv1Data = array();
					foreach ($object->PV1 as $segment) {
						foreach ($segment as $parameter) {
							$parameter["patient_id"] = $patientID;
							array_push($pv1Data, $parameter);
						}
					}
					$this->db->insert_batch("hl_data", $pv1Data);
				}

				if (count($object->OBR) > 0) {
					$obrData = array();
					foreach ($object->OBR as $segment) {
						foreach ($segment as $parameter) {
							$parameter["patient_id"] = $patientID;
							array_push($obrData, $parameter);
						}
					}
					$this->db->insert_batch("hl_data", $obrData);
				}
				if (count($object->OBX) > 0) {
					$obxData = array();
					foreach ($object->OBX as $segment) {
						foreach ($segment as $parameter) {
							$parameter["patient_id"] = $patientID;
							array_push($obxData, $parameter);
						}
					}
					$this->db->insert_batch("hl_data", $obxData);
				}
				if (count($object->ORC) > 0) {
					$orcData = array();
					foreach ($object->ORC as $segment) {
						foreach ($segment as $parameter) {
							$parameter["patient_id"] = $patientID;
							array_push($orcData, $parameter);
						}
					}
					$this->db->insert_batch("hl_data", $orcData);
				}
			} else {
				$this->db->trans_rollback();
				$this->db->trans_complete();
				$resultObject->status = FALSE;
				$resultObject->error = "Patient ID Not Found";
				return $resultObject;
			}
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$resultObject->status = FALSE;
				$resultObject->error = "Failed";
			} else {
				$this->db->trans_commit();
				$resultObject->status = TRUE;
			}
			$this->db->trans_complete();
			$resultObject->last_query = $this->db->last_query();
		} catch (Exception $exception) {
			$resultObject->status = FALSE;
			$resultObject->error = "Failed";
			$this->db->trans_rollback();
			$this->db->trans_complete();
		}
		return $resultObject;
	}

	function getPatientDetails($PID)
	{

		$patientData = array();
		foreach ($this->patientDetails as $index => $header) {
			if (!is_null($PID->getField($index))) {
				array_push($patientData, array(
					"header" => $header,
					"value" => is_array($PID->getField($index)) ? implode("||", $PID->getField($index)) : $PID->getField($index)
				));
			}
		}
		return $patientData;
	}

	function getPV1($PV1Value)
	{

		$visitData = array();
		foreach ($PV1Value as $pv1) {
			$visitValue = array();
			foreach ($this->PV1 as $index => $header) {
				if (!is_null($pv1->getField($index))) {
					array_push($visitValue, array(
						"header" => $header,
						"value" => is_array($pv1->getField($index)) ? implode(" ", $pv1->getField($index)) : $pv1->getField($index)
					));
				}
			}
			if (count($visitValue) > 0) {
				array_push($visitData, $visitValue);
			}

		}
		return $visitData;
	}

	function getMSH($MSHValue)
	{

		$patientData = array();
		foreach ($this->MSH as $index => $header) {
			if (!is_null($MSHValue->getField($index))) {
				if (is_array($MSHValue->getField($index))) {
					array_push($patientData, array(
						"header" => $header,
						"value" => implode('||', $MSHValue->getField($index))
					));
				} else {
					if (!empty($MSHValue->getField($index)))
						array_push($patientData, array(
							"header" => $header,
							"value" => $MSHValue->getField($index)
						));
				}
			}
		}
		return $patientData;
	}

	function getOBRValues($OBRValues)
	{
		$OBRData = array();
		foreach ($OBRValues as $OBR) {
			$OBRValue = array();
			foreach ($this->OBR as $index => $header) {
				if (!is_null($OBR->getField($index))) {
					if (is_array($OBR->getField($index))) {
						array_push($OBRValue, array(
							"header" => $header,
							"value" => implode('||', $OBR->getField($index))
						));
					} else {
						if (!empty($OBR->getField($index)))
							array_push($OBRValue, array(
								"header" => $header,
								"value" => $OBR->getField($index)
							));
					}

				}
			}
			if (count($OBRValue) > 0) {
				array_push($OBRData, $OBRValue);
			}
		}
		return $OBRData;
	}

	function getOBXValues($OBXValues)
	{
		$OBXData = array();
		foreach ($OBXValues as $OBR) {
			$OBXValue = array();
			foreach ($this->OBX as $index => $header) {
				if (!is_null($OBR->getField($index))) {
					if (is_array($OBR->getField($index))) {
						array_push($OBXValue, array(
							"header" => $header,
							"value" => implode('||', $OBR->getField($index))
						));
					} else {
						if (!empty($OBR->getField($index)))
							array_push($OBXValue, array(
								"header" => $header,
								"value" => $OBR->getField($index)
							));
					}
				}
			}
			if (count($OBXValue) > 0) {
				array_push($OBXData, $OBXValue);
			}
		}
		return $OBXData;
	}

	function getORCValues($ORCValues)
	{
		$ORCData = array();
		foreach ($ORCValues as $OBR) {
			$ORCValue = array();
			foreach ($this->ORC as $index => $header) {
				if (!is_null($OBR->getField($index))) {
					if (is_array($OBR->getField($index))) {
						array_push($ORCValue, array(
							"header" => $header,
							"value" => implode('||', $OBR->getField($index))
						));
					} else {
						if (!empty($OBR->getField($index)))
							array_push($ORCValue, array(
								"header" => $header,
								"value" => $OBR->getField($index)
							));
					}
				}
			}
			if (count($ORCValue) > 0) {
				array_push($ORCData, $ORCValue);
			}
		}
		return $ORCData;
	}

	function API_payload()
	{
		$p_id = 1;
		$api = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:HL72XML>
         <!--Optional:-->
         <tem:HL7Message>MSH|^~\&amp;|HNQ|555^RFH1|LIMS||20210519104717||ORM^O01|10334164|P|2.5
PID|1||0010274463||Shah^Arjun||19970418|M|||62 Gaurav Apt 6th Floor,^^MUMBAI^^400025^IN||9920863654|9920863654|||||.5222 1118 0099.
PV1|1|O|1GENLABC^^^1LABMED|RF|||CN00000267^Shah^Arun||CN00000267^Shah^Arun||||||N00||||1001043466|||||||||||||||||||||||||20210519104535|00000000000000
ORC|XO|0014187229||02586442^0001523445^255C646A0EBD1EDBAE8C2F1BEC404CD9|IP||^^^20210519104713^^001^^E000300^^000001|00155D191A011EE88DE078CCB0E489BB|20210519104716|1MOLBIOC^Molecular Biology Clinic^^1LABMED||CN00000267^Shah^Arun|1GENLABC^^^1LABMED|+919821095542|20140122160928
OBR||0014187229|02586442|LAB-MB396^COVID-19 PCR1^01|1||20210519104713|||||||||CN00000267^Shah^Arun|+919821095542|||||||||||||||||||20210519104717</tem:HL7Message>
      </tem:HL72XML>
   </soapenv:Body>
</soapenv:Envelope>
';
	}

}
