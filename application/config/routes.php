<?php
defined('BASEPATH') or exit('No direct script access allowed');

$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route["index"] = "UserController";

/*
 *  routes
 */

$route["login"]="LoginController/loginUser";
//change password
$route["camera"]="welcome/view_cam";

$route['admin/chnage_password'] = 'change_pass_controller';
$route['admin/chnage_pass'] = 'change_pass_controller/change_pass';
$route['admin/change_access'] = 'change_pass_controller/change_access';
$route['admin/getDefaultAccess'] = 'change_pass_controller/getDefaultAccess';
// Home page for companies users
$route["patient_info"]="UserController/patientInfo";
$route["Reports_query"]="Report/Reports_query";
$route["admin/Reports_query"]="Report/Reports_query";
// $route["staff/patient_info"]="UserController/patientInfo";
// ------------------------------ Company Section ----------------------------------------

$route["admin/view_companies"]="Welcome/view_companies";
// create and update company
$route["admin/uploadCompany"]='CompaniesController/uploadCompany';
// datatable fetch all companies
$route["admin/fetchCompanies"]="CompaniesController/getCompanyTableData";
$route["admin/changeCompanyStatus"]="CompaniesController/ChangeCompanyStatus";
$route["admin/getCompanyDataById"]="CompaniesController/getCompanyDataById";
// unused deleteCompany
$route["admin/deleteCompany"]="CompaniesController/deleteCompany";


// ------------------------------ branch Section -------------------------------------------
$route["admin/view_branch"] = "Welcome/view_branches";
// create and update company
$route["admin/uploadBranch"]='BranchController/uploadCompany';
// datatable fetch all companies
$route["admin/fetchBranch"]="BranchController/getCompanyTableData";
$route["admin/changeBranchStatus"]="BranchController/ChangeCompanyStatus";
$route["admin/getBranchDataById"]="BranchController/getCompanyDataById";
$route["admin/getBranches"]="BranchController/getBranches";
$route["company/getBranches"]="BranchController/getBranches";
// unused deleteCompany
$route["admin/deleteBranch"]="BranchController/deleteCompany";
// -------------------------------- Department Section ---------------------------------------
$route["admin/view_departments"] = "Welcome/view_department";
$route["admin/getDepartments"]="DepartmentController/getDepartmentTableData";
// to get all companies
$route["admin/fetchAllCompanies"]="DepartmentController/selectAllCompanies";
$route["company/fetchAllCompanies"]="DepartmentController/selectAllCompanies";
$route["admin/saveDepartment"]="DepartmentController/uploadDepartment";
$route["admin/ChangeDepartmentStatus"]="DepartmentController/ChangeDepartmentStatus";
$route["admin/getDepartmentDataById"]="DepartmentController/getDepartmentDataById";
$route["admin/companyDepartment"]='DepartmentController/selectCompanyDepartment';
$route["company/companyDepartment"]='DepartmentController/selectCompanyDepartment';
// ------------------------------ Template Section ---------------------------------------
$route["admin/view_template"] = "Welcome/view_template";
$route["admin/save_template"]="TemplateController/saveTemplate";
$route["admin/fetch_template_sections"]="TemplateController/getDepartmentSections";
$route["admin/fetch_section_details"]="TemplateController/getSectionElements";
$route["admin/deleteSection"]="TemplateController/deleteSection";
$route["admin/form_template"] = "Welcome/from_template";
$route["admin/deleteTemplateElement"]="TemplateController/deleteTemplateElement";
// ------------------------- Personal section -------------------------------------
$route["admin/personal_template"]="PersonalTemplateController";
$route["admin/personal/save_template"]="PersonalTemplateController/saveTemplate";
$route["admin/personal/fetch_template_sections"]="PersonalTemplateController/getDepartmentSections";
$route["admin/personal/fetch_section_details"]="PersonalTemplateController/getSectionElements";
$route["admin/personal/deleteSection"]="TemplateController/deleteSection";
$route["admin/personal/form_template"] = "Welcome/from_template";
$route["admin/personal/deleteTemplateElement"]="TemplateController/deleteTemplateElement";

// -------------------------------- User Section --------------------------------
$route["admin/view_user"] = "Welcome/view_users";
$route["company/view_user"] = "Welcome/view_users";

$route["admin/fetchAllUser"]="UserController/getUsersTableData";
$route["company/fetchAllUser"]="UserController/getUsersTableData";
$route["admin/saveUser"]='UserController/uploadUsers';
$route["company/saveUser"]='UserController/uploadUsers';
$route["admin/uploadOtherUsers"]='UserController/uploadOtherUsers';
$route["company/uploadOtherUsers"]='UserController/uploadOtherUsers';
$route["admin/getUserDataById"]="UserController/getUserDataById";
$route["company/getUserDataById"]="UserController/getUserDataById";
$route["admin/deleteUser"]="UserController/deleteUser";
$route["company/deleteUser"]="UserController/deleteUser";
$route["admin/form_user"] = "Welcome/from_user";
// ------------------------------- Patient Section ----------------------------------
$route["admin/patient_info"]="PatientController/index";
$route["admin/view_patients"] = "Welcome/view_patient";
$route["admin/new_patients"] = "Welcome/from_patient";
$route["new_patients"] = "Welcome/from_patient";
$route["new_patients/(:num)"] = "Welcome/from_patient/$1";
$route["admin/getPatientTableData"]="PatientController/getPatientTableData";
$route["admin/getPatientTableDataZone"]="PatientController/getPatientTableDataZone";
$route["admin/getZoneData"]="PatientController/getZoneData";
$route["admin/get_patient_data"]="PatientController/get_patient_data";
$route["new_patients/getPatientData"]="PatientController/getPatientDataById";
$route["getPatientTableData"]="PatientController/getPatientTableData";
$route["getPatientTableDataZone"]="PatientController/getPatientTableDataZone";
$route["getZoneData"]="PatientController/getZoneData";
$route["patient/getZoneData"]="PatientController/getZoneData";
$route["new_patients/getZoneData"]="PatientController/getZoneData";
$route["get_patient_data/(:num)"]="PatientController/get_patient_data/$1";
$route["admin/patientSearch"]="PatientController/search";
$route["patientSearch"]="PatientController/search";
$route["savePatient"]='PatientController/add_patient';
$route["new_patients/savePatient"]='PatientController/add_patient';
$route["deletePatient"]="PatientController/deletePatient";
$route["delete_Patient"]="PatientController/delete_Patient";
$route["patientDischarge"]="PatientController/patientDischarge";
$route["discharge_report"]="DischargeManagementController/discharge_report";

$route["admin/formview"]="FormController";
$route["form_view/sectionSave"]="FormController/add_form_data";
$route["html_navigation/(:any)/(:any)/sectionSave"]="FormController/add_form_data";
$route["form_view/sectionUpdate"]="FormController/update_form_data";
$route["sectionUpdate"]="FormController/update_form_data";

$route["form_view_personal/sectionSave"]="PersonalTemplateController/add_form_data";
$route["sectionSave"]="PersonalTemplateController/add_form_data";
$route["company/form_view/sectionSave"]="FormController/add_form_data";
$route["form_view/(:any)"] = "FormController/index/$1";
$route["section_individual/(:any)"] = "FormController/section_individual/$1";

$route["form_view_personal/(:any)"] = "FormController/index_personal/$1";
$route["company/form_view/(:any)"] = "FormController/index/$1";
$route["getTemplateForm"]="FormController/get_form_fields";
$route["getTemplateFormPersonal"]="PersonalTemplateController/get_form_fields";

$route["getSectionTemplateFormPersonal"]="PersonalTemplateController/getSectionTemplateFormPersonal";

$route["get_history_data"]="FormController/get_history_data";
$route["getHistoryTemplate"]="FormController/getHistoryTemplate";
$route["getPatientHistoryData"]="FormController/getPatientHistoryData";

$route["admin/dashboard"]="DashboardController/dashboard";
$route["patient/dashboard"]="DashboardController/patient_dashboard";
$route["bed_management_report"]="DashboardController/bed_management_report";
$route["get_monthly_Data"]="DashboardController/get_monthly_Data";
$route["get_yearly_Data"]="DashboardController/get_yearly_Data";
$route["get_dashboard_Data"]="DashboardController/get_dashboard_Data";


$route["staff/dashboard"]="DashboardController/staff_dashboard";
$route["logout"]="LoginController/logout";

//$route['barcode/(:any)']="PatientController/generatorBarcode/$1";
$route['barcode'] ="PatientController/barcodeImg";
$route["exportData/(:num)"]="PatientController/downloadPatients/$1";

// ------------------------------- Medicine Section ----------------------------------

$route["medicine"]="MedicineController/medicine";
$route["add_medicine_fun"] = "MedicineController/add_medicine_fun";
$route["company/admin/add_medicine_fun"] = "MedicineController/add_medicine_fun";
$route["getICUDoesDetails"] = "MedicineController/getDoesHistory";
$route["availabWPatient"] = "MedicineController/availabWPatient";
$route["company/admin/getICUDoesDetails"] = "MedicineController/getDoesHistory";
$route["company/admin/availabWPatient"] = "MedicineController/availabWPatient";
$route["doesGivent"] = "MedicineController/updatetDoesHistory";
$route["getmedicine"] = "MedicineController/getMedicine_option";
$route["getMedicineTable"] = "MedicineController/medicine_data";
$route["company/admin/getMedicineTable"] = "MedicineController/medicine_data";
$route["addPatientMedicine"] = "MedicineController/add_patientmedicine_fun";
$route["getEditMedicineData"] = "MedicineController/get_medicine_data_new";
$route["updatePatientMedicine"] = "MedicineController/update_patientmedicine_fun";
$route["deleteScheduleMedicine"] = "MedicineController/delete_schedule_medicine_data";
$route["deleteMedicine"] = "MedicineController/delete_medicine_data";
$route["deleteMedicineHistory"] = "MedicineController/delete_history_fun";
$route["getMedicineGroup"]="MedicineController/getMedicineGroup";
$route["company/admin/getMedicineGroup"]="MedicineController/getMedicineGroup";
$route["activeMedicine"]="MedicineController/updatePatientMedicine";
$route["saveMedicineUpdate"]="MedicineController/update_medicine";

$route["addmedicineCommentForm"]="MedicineController/addmedicineCommentForm";

// ---------------------- Return Meedicine FROM Medication Tab -----------------------

$route["getReturnMedicineTable"]="MedicineReturnController/getReturnMedicineTable";
$route["returnMedicineForm"]="MedicineReturnController/returnMedicineForm";



$route["get-users"]="UserController/getUserByType";
$route["company/admin/get-users"]="UserController/getUserByType";
$route["admin/get_access_data"]="UserController/get_access_data";
$route["company/get_access_data"]="UserController/get_access_data";
$route["admin/save_permission"]="UserController/save_permission";
$route["company/save_permission"]="UserController/save_permission";
$route["admin/get_permission_div"]="UserController/get_permission_div";
$route["admin/save_profile"]="UserController/save_profile";
$route["admin/get_user_types"]="UserController/get_user_types";
$route["company/get_permission_div"]="UserController/get_permission_div";
$route["company/save_profile"]="UserController/save_profile";
$route["company/get_user_types"]="UserController/get_user_types";
$route["company/get_all_profile_data"]="UserController/get_all_profile_data";
$route["admin/get_all_profile_data"]="UserController/get_all_profile_data";
$route["admin/get_profile_edit"]="UserController/get_profile_edit";
$route["company/get_profile_edit"]="UserController/get_profile_edit";
$route["classification"]="FormController/getClassification";
$route["company/admin/classification"]="FormController/getClassification";
$route["sub-classification"]="FormController/getSubClassification";
$route["company/admin/sub-classification"]="FormController/getSubClassification";
$route["unit_of_measure"]="FormController/getUnitOfMeasure";
$route["company/admin/unit_of_measure"]="FormController/getUnitOfMeasure";
$route["get-medicine"]="MedicineController/getMedicineOptions";
$route["company/admin/get-medicine"]="MedicineController/getMedicineOptions";
$route["company/admin/medicine_master"]="MedicineController/view_medicine_master";
$route["company/admin/prescription_master"]="MedicineController/view_prescription_master";
$route["load_patient_medicine_history"]="MedicineController/load_patient_history";
$route["saveRescheduleMedicine"]="MedicineController/saveRescheduleMedicine";
$route["saveExtendScheduleMedicine"]="MedicineController/saveExtendScheduleMedicine";
// ------------------------------- Hospital Management Section ----------------------------------
$route["company/admin/hospital_order_management"]="HospitalOrderController/index";
$route["company/admin/getMaterialGroup"]="HospitalOrderController/getMaterialGroup";
$route["getMaterialGroup"]="HospitalOrderController/getMaterialGroup";
$route["company/admin/GetDataPrintDiv"]="HospitalOrderController/GetDataPrintDiv";
$route["GetDataPrintDiv"]="HospitalOrderController/GetDataPrintDiv";

$route["company/admin/getComapanyUsers"]="HospitalOrderController/getComapanyUsers";
$route["getComapanyUsers"]="HospitalOrderController/getComapanyUsers";
$route["company/admin/add_hospital_order"]="HospitalOrderController/add_hospital_order";
$route["add_hospital_order"]="HospitalOrderController/add_hospital_order";

$route["company/admin/getMaterialDescription"]="HospitalOrderController/getMaterialDescription";
$route["getMaterialDescription"]="HospitalOrderController/getMaterialDescription";
$route["company/admin/get-materialDescription"]="HospitalOrderController/getMaterialDescriptionOptions";
$route["get-materialDescription"]="HospitalOrderController/getMaterialDescriptionOptions";

$route["company/admin/placeHospitalMaterialOrder"]="HospitalOrderController/placeHospitalMaterialOrder";
$route["placeHospitalMaterialOrder"]="HospitalOrderController/placeHospitalMaterialOrder";
$route["company/admin/getReceiveHospitalOrderHistoryTable"]="HospitalOrderController/getReceiveHospitalOrderHistoryTable";
$route["getReceiveHospitalOrderHistoryTable"]="HospitalOrderController/getReceiveHospitalOrderHistoryTable";
$route["company/admin/getTableInventries"]="HospitalOrderController/getTableInventries";
$route["getTableInventries"]="HospitalOrderController/getTableInventries";
$route["company/admin/ConsumeMedicineNew"]="HospitalOrderController/ConsumeMedicineNew";
$route["ConsumeMedicineNew"]="HospitalOrderController/ConsumeMedicineNew";
$route["company/admin/getZoneData"]="PatientController/getZoneData";
$route["getZoneData"]="PatientController/getZoneData";
$route["company/admin/getPatientListData"]="HospitalOrderController/getPatientListData";
$route["getPatientListData"]="HospitalOrderController/getPatientListData";
$route["company/admin/getViewOrderData"]="HospitalOrderController/getViewOrderData";
$route["getViewOrderData"]="HospitalOrderController/getViewOrderData";
$route["company/admin/newMaterialOrderListForm"]="HospitalOrderController/newMaterialOrderListForm";
$route["newMaterialOrderListForm"]="HospitalOrderController/newMaterialOrderListForm";
$route["company/admin/add_consume_details"]="HospitalOrderController/add_consume_details";
$route["add_consume_details"]="HospitalOrderController/add_consume_details";
$route["company/admin/GetSummarisedHistoryData"]="HospitalOrderController/GetSummarisedHistoryData";
$route["GetSummarisedHistoryData"]="HospitalOrderController/GetSummarisedHistoryData";
$route["company/admin/GetDetailHistoryData"]="HospitalOrderController/GetDetailHistoryData";
$route["GetDetailHistoryData"]="HospitalOrderController/GetDetailHistoryData";
$route["company/admin/ReverseOrderConsume"]="HospitalOrderController/ReverseOrderConsume";
$route["ReverseOrderConsume"]="HospitalOrderController/ReverseOrderConsume";
$route["company/admin/GetOrderData"]="HospitalOrderController/GetOrderData";
$route["GetOrderData"]="HospitalOrderController/GetOrderData";
$route["company/admin/returnOrderForm"]="HospitalOrderController/returnOrderForm";
$route["returnOrderForm"]="HospitalOrderController/returnOrderForm";
$route["company/admin/getBalancequantity"]="HospitalOrderController/getBalancequantity";
$route["getBalancequantity"]="HospitalOrderController/getBalancequantity";
$route["company/admin/gethospitalOrderMaterialListTable"]="HospitalOrderController/gethospitalOrderMaterialListTable";
$route["gethospitalOrderMaterialListTable"]="HospitalOrderController/gethospitalOrderMaterialListTable";
$route["company/admin/deleteHospitalOrderMaterialTranscation"]="HospitalOrderController/deleteHospitalOrderMaterialTranscation";
$route["deleteHospitalOrderMaterialTranscation"]="HospitalOrderController/deleteHospitalOrderMaterialTranscation";
$route["company/admin/deleteHospitalOrderTranscation"]="HospitalOrderController/deleteHospitalOrderTranscation";
$route["deleteHospitalOrderTranscation"]="HospitalOrderController/deleteHospitalOrderTranscation";
$route["company/admin/receiveOrderForm"]="HospitalOrderController/receiveOrderForm";
$route["receiveOrderForm"]="HospitalOrderController/receiveOrderForm";
$route["company/admin/SaveIndividualPrice"]="HospitalOrderController/SaveIndividualPrice";
$route["SaveIndividualPrice"]="HospitalOrderController/SaveIndividualPrice";



// ------------------------------- Leftside Bar Hospital Management Section ----------------------------------
$route["hospital_order_management"]="HospitalOrderController/hospital_order_management";
$route["Consumable_Inventory"]="HospitalOrderController/Consumable_Inventory";

// ------------------------------- Bed Management Section ----------------------------------

$route["bedManagement"]="BedManagementController/index";
$route["icubedManagement"]="BedManagementController/icubedManagement";
$route["GetIcuBedData"]="BedManagementController/GetIcuBedData";
$route['add_room_info'] = 'BedManagementController/add_room_info';
$route['get_roomdetails_info'] = 'BedManagementController/get_roomdetails_info';
$route['get_roomdetails_info_icu'] = 'BedManagementController/get_roomdetails_info_icu';
$route['getPatientLabReport']='BedManagementController/getLabReport';
$route['getVitalSignLiveByBed']="BedManagementController/getVitalSignLiveByBed";
$route['get_bedetails_info'] = 'BedManagementController/get_bedetails_info';
$route['add_bedroom_info'] = 'BedManagementController/add_bedroom_info';
$route['delete_bed'] = 'BedManagementController/delete_bed';
$route['delete_room'] = 'BedManagementController/delete_room';
$route['get_bed_type'] = 'BedManagementController/get_bed_type';
$route['updateBedActiveStatus']="AssignBedController/deactivateBed";
$route["assignBed"] = "AssignBedController/assignBed";
$route["add_Patient_number"] = "AssignBedController/add_patient_detials";
$route["deletePaitent"] = "AssignBedController/deletePaitent";
$route['getBedOptions'] = 'AssignBedController/getBedAvilableOption';
$route["get_user_name"] = "AssignBedController/getUserData";
$route["deletePaitent"] = "AssignBedController/deletePaitent";
$route['getRoomOptions'] = 'AssignBedController/getRoomsOptions';
$route["isUniqueUpdate"] = "AssignBedController/isUniqueUpdate";
$route['getPatientBedHistoryTableData']="AssignBedController/getPatientBedHistoryTableData";
$route['room_order']="AssignBedController/room_order";
$route['admin/room_order']="AssignBedController/room_order";


$route['get_icuPtientScheduleMedicine'] = 'BedManagementController/get_icuPtientScheduleMedicine';
$route['getIcuPatientLabTestPara'] = 'BedManagementController/getIcuPatientLabTestPara';
$route['getIcuPatientVitalSignPara'] = 'BedManagementController/getIcuPatientVitalSignPara';
$route['get_icuPatientList'] = 'BedManagementController/get_icuPatientList';

// ------------------------------- Billing Management Section ----------------------------------

$route["billing"]="BillingManagementController/index";
$route["getBillingServices"]="BillingManagementController/getBillingServices";
$route["getBillingServicesDescription"]="BillingManagementController/getBillingServicesDescription";
$route["getBillingServicesDRate"]="BillingManagementController/getBillingServicesDRate";
$route["add_billing_transaction"]="BillingManagementController/add_billing_transaction";
$route["getBillingTable"]="BillingManagementController/getBillingTable";
$route["getBillingTable1"]="BillingManagementController/getBillingTable1";
$route["getBillingHistoryTable1"]="BillingManagementController/getBillingHistoryTable1";
$route["getDeleteBillingTable"]="BillingManagementController/getDeleteBillingTable";
$route["deleteBillingTrascation"]="BillingManagementController/deleteBillingTrascation";
$route["RoomOrderBilling"]="BillingManagementController/RoomOrderBilling";
$route["addOrderRoom"]="BillingManagementController/addOrderRoom";
$route["getBillingserviceOrderBillingInfo"]="BillingManagementController/getBillingserviceOrderBillingInfo";
$route["deleteBillingServiceOrder"]="BillingManagementController/deleteBillingServiceOrder";
$route["ChangeBillingOpen"]="BillingManagementController/ChangeBillingOpen";
$route["check_billing_status"]="BillingManagementController/check_billing_status";
$route["saveDiscount"]="BillingManagementController/saveDiscount";
$route["deleteBillingTrascationAcc"]="BillingManagementController/deleteBillingTrascationAcc";
$route["restoreService"]="BillingManagementController/restoreService";


$route["getOtherServicePatientData"]="BillingManagementController/getOtherServicePatientData";
$route["getOtherServiceCategoryData"]="BillingManagementController/getOtherServiceCategoryData";

$route["getOtherServiceHistoryPatientData"]="BillingManagementController/getOtherServiceHistoryPatientData";
$route["getOtherServiceHistoryCategoryData"]="BillingManagementController/getOtherServiceHistoryCategoryData";

// ------------------------------- Billing Master Management Section ----------------------------------

$route["billingMaster"]="BillingManagementController/billingMaster";
$route["getAccomodationTableBIllingData"]="BillingManagementController/getAccomodationTableBIllingData";
$route["getmedicineAndConsumablesTableBilling"]="BillingManagementController/getmedicineAndConsumablesTableBilling";
$route["getserviceOrderCollectionTableBilling"]="BillingManagementController/getserviceOrderCollectionTableBilling";
$route["getPatientBIllingData"]="BillingManagementController/getPatientBIllingData";



// ------------------------------- Discharge Management Section ----------------------------------
$route["discharge"]="DischargeManagementController/index";
$route["getpatientdatadis"]="DischargeManagementController/getpatientdatadis";

//---------------------------------- Prescription Section ------------------------------

$route["savePrescription"]="PrescriptionController/savePrescription";
$route["company/admin/savePrescription"]="PrescriptionController/savePrescription";
$route["getPrescriptionTableData"]="PrescriptionController/getPrescriptionTableData";
$route["company/admin/getPrescriptionTableData"]="PrescriptionController/getPrescriptionTableData";
$route["deletePrescription"]="PrescriptionController/deletePrescription";
$route["getPrescriptionMedicine"]="PrescriptionController/getPrescriptionMedicine";
$route["schedulePrescription"]="PrescriptionController/schedulePrescription";
$route["company/admin/deletePrescriptionMed"]="PrescriptionController/delete_med";
$route["get_prescribe_data"]="PrescriptionController/get_prescribe_data";
$route["company/admin/get_prescribe_data"]="PrescriptionController/get_prescribe_data";
$route["company/admin/update_prescription"]="PrescriptionController/update_prescription";
$route["company/admin/deletePrescription"]="PrescriptionController/deletePrescription";
$route["company/admin/editPrescriptionDetails"]="PrescriptionController/editPrescription";
//chat
$route['chat'] = 'Chat_Controller';
$route['getFirmUsers'] = 'Chat_Controller/get_firm_users';
$route['sendMessage'] = 'Chat_Controller/send_message';
$route['getMessages'] = 'Chat_Controller/get_messages';
$route['getGroupMessages'] = 'Chat_Controller/getGroupMessages';
$route['getGroups'] = 'Chat_Controller/get_user_involve_groups';
$route['video'] = 'Chat_Controller/video_chat';
$route['video_design'] = 'Chat_Controller/video_design';
$route['test_dashboard'] = 'Chat_Controller_Test/dashboard';
$route['updateAllUnReadMessageStatus'] = "Chat_Controller/updateNotification";
$route['updateMessageStatus'] = "Chat_Controller/updateMessageStatus";
$route['getUnReadMessageCount'] = "Chat_Controller/get_unread_messages_count";
$route['news_scraping'] = "Chat_Controller_Test/news18";
$route['messenger2'] = 'Chat_Controller_Test/chat_backup';

//template by pooja
$route['getdependantdropdown'] = 'FormController/getdependantdropdown';
$route['admin/gettemplatelist'] = 'TemplateController/gettemplatelist';
//--------------------------------- company admin -------------------------------------

$route['company/company_admin'] = 'CompanyAdminController/company_admin';


//--------------------------------- service order -------------------------------------

$route['serviceOrder'] = 'ServiceOrderController/index';
$route['serviceOrder1'] = 'ServiceOrderController/index1';
$route['getOrderServicesName'] = 'ServiceOrderController/getOrderServicesName';
$route['getOrderCommonServicesName'] = 'ServiceOrderController/getOrderCommonServicesName';
$route['placeServiceOrder'] = 'ServiceOrderController/placeServiceOrder';
$route['getOrderPlaceTable'] = 'ServiceOrderController/getOrderPlaceTable';

$route['deleteserviceOrderTranscation'] = 'ServiceOrderController/deleteserviceOrderTranscation';
$route['getServiceOrderPlaceTimeTable'] = 'ServiceOrderController/getServiceOrderPlaceTimeTable';
$route['getStandardLabServicesName'] = 'ServiceOrderController/getStandardLabServicesName';
$route['placeStandardLabServiceOrder'] = 'ServiceOrderController/placeStandardLabServiceOrder';
$route["getServicesOrderDescription"]="ServiceOrderController/getBillingServicesDescription";
$route["getServicesOrderRate"]="ServiceOrderController/getServicesOrderRate";

//--------------------------- SampleCollection --------------------------
$route["radiologySampleCollection"]="ServiceOrderController/radiologySampleCollection";
$route["pathologySampleCollection"]="ServiceOrderController/pathologySampleCollection";
$route["getSampleCollectionTable"]="ServiceOrderController/getSampleCollectionTable";
$route["getRadiologySampleCollectionTable"]="ServiceOrderController/getRadiologySampleCollectionTable";
$route["uploadRadioUplodation"]="ServiceOrderController/uploadRadioUplodation";
$route["uploadRadioUplodation1"]="ServiceOrderController/uploadRadioUplodation1";
$route["getRadiologySampleHistoryTable"]="ServiceOrderController/getRadiologySampleHistoryTable";
$route["getNotConfirmReport"]="ServiceOrderController/getNotConfirmReport";
$route["getRadiologyNotConfirmReport"]="ServiceOrderController/getRadiologyNotConfirmReport";


// $route["pathologyCollection"]="ServiceOrderController/pathologyCollection";


$route["getserviceOrderBillingInfo"]="ServiceOrderController/getserviceOrderBillingInfo";

$route["deleteServiceOrder"]="ServiceOrderController/deleteServiceOrder";
$route["deleteServiceOrder1"]="ServiceOrderController/deleteServiceOrder1";
$route["getSampleAllPatients"]="ServiceOrderController/getSampleAllPatients";
$route["getOtherServiceReport"]="OtherServiceController/getOtherServiceReport";
$route["getOtherServicesHistoryReport"]="OtherServiceController/getOtherServicesHistoryReport";


// ------------------------ Pickup collection ----------------------

$route["view_pickup"]="PickupController";
$route["view_pickup1"]="PickupController/index1";
$route["ExcelDownload"]="PickupController/ExcelDownload";
$route["getSampleCollectedOrder"]="PickupController/getSampleCollectedOrder";
$route["getSampleZones"]="PickupController/getSampleZones";
$route["saveSampleCollection"]="PickupController/saveCollection";
$route["apiSaveSampleCollection"]="HL7Controller/apiHL7String";
$route["apiSendSampleCollection"]="HL7Controller/apiSendRequest";
$route["getLabReportSampleCollection"]="HL7Controller/getResponseText";

$route["getSampleCollectOrder"]="PickupController/getAllOrderSampleCollected";
$route["HistorySampleTableData"]="PickupController/HistorySampleTableData";
$route["HistorySampleItemTableData"]="PickupController/HistorySampleItemTableData";
$route["getServiceOrderPList"]="PickupController/getServiceOrderPList";
$route["downloadSampleOrder/(:any)"]="PickupController/downloadSampleOrderTable/$1";
$route["getDownloadSampleHistory/(:any)"]="PickupController/DownloadSampleHistory/$1";

// ------------------------ Radiology Pickup collection ----------------------

$route["view_radiologypickup"]="ServiceOrderController/radiologySampleCollectionPickup";
$route["getRadiologySampleCollectedOrder"]="RadiologyPickupController/getSampleCollectedOrder";

$route["saveRadiologySampleCollection"]="RadiologyPickupController/saveCollection";

// -------------------------------  Patient Order Medicine -------------------------
$route["pharmeasy1"]="MedicineOrderController/index";
$route["pharmeasy"]="MedicineOrderController/index1";
$route["save-pharmary-order"]="MedicineOrderController/saveOrder";
$route["save-Hospharmary-order"]="MedicineOrderController/saveHospOrder";
$route["get-order-patients"]="MedicineOrderController/getOrderMedicinePatient";
$route["get-patient-order1"]="MedicineOrderController1/getPatientOrderMedicine1";
$route["get-patient-order"]="MedicineOrderController/getPatientOrderMedicine";
$route["get-backorder-patients"]="MedicineOrderController/getBackOrderMedicinePatient";
$route["getBackOrderTable"]="MedicineOrderController/getBackOrderTable";
$route["getDeptOrder"]="MedicineOrderController/getDeptOrder";


$route["save-consume-order"]="MedicineOrderController/save_consume_order";
$route["hospitalMedicine"]="MedicineOrderController/hospitalMedicine";
$route["get-order-approved-patients"]="MedicineOrderController/getApprovedOrderMedicinePatient";
$route["get-patient-approved-order"]="MedicineOrderController/getApprovedPatientOrderMedicine";
$route["delete-order"]="MedicineOrderController/deleteOrder";
$route["getHistoryorderTable"]="MedicineOrderController/getHistoryorderTable";
$route["getItemMedicineHistory"]="MedicineOrderController/getItemMedicineHistory";
$route["getConsumableHistoryorderTable"]="MedicineOrderController/getConsumableHistoryorderTable";

$route["getItemConsumableHistory"]="MedicineOrderController/getItemConsumableHistory";

//return order medicine
$route["get-order-return-patients"]="MedicineOrderController/getOrderReturnMedicinePatient";
$route["get-patient-order-return"]="MedicineOrderController/getPatientOrderReturnMedicine";
$route["save-pharmary-return-order"]="MedicineOrderController/saveOrderReturn";
$route["get-order-return-approved-patients"]="MedicineOrderController/getApprovedReturnOrderMedicinePatient";
$route["get-patient-approved-order-return"]="MedicineOrderController/getApprovedReturnPatientOrderMedicine";
$route["history_patient"]="MedicineOrderController/history_patient";
$route["GetHospitalOrderMedicine"]="MedicineOrderController/GetHospitalOrderMedicine";
$route["getDeptReturnOrder"]="MedicineOrderController/getDeptReturnOrder";
$route["GetHospitalReturnMedicine"]="MedicineOrderController/GetHospitalReturnMedicine";
$route["SaveHospitalReturnOrder"]="MedicineOrderController/SaveHospitalReturnOrder";
$route["getHospHistoryorderTable"]="MedicineOrderController/getHospHistoryorderTable";
$route["getItemHospitalHistory"]="MedicineOrderController/getItemHospitalHistory";



//--------------------------- HL7 --------------------------
$route["createNewMessage"]="HL7Controller/createNewMessage";
$route["readMessage"]="HL7Controller/readMessage";
$route["Hl7View"]="HL7Controller/Hl7View";


//--------------------------- Excel file upload --------------------------
$route["fileUpload"]="ExcelUploadController/index";
$route["add_Excel_file"]="ExcelUploadController/add_Excel_file";

// ---------------------- labReport -----------------------

$route["labReport"]="PathologyOrderController/labReport";
$route["getLabReport"]="PathologyOrderController/loadReports";
$route["getlabreportFrequentlyUsed"]="PathologyOrderController/getlabreportFrequentlyUsed";
$route["getRadiologyData"]="PathologyOrderController/getRadiologyData";
$route["getOtherServiceTableData"]="PathologyOrderController/getOtherServiceTableData";
$route["getLabReportOrderTestData"]="PathologyOrderController/getLabReportOrderTestData";
$route["getLabReportOrderTestParaData"]="PathologyOrderController/getLabReportOrderTestParaData";


$route["getuploadedFiles"]="ExcelUploadController/getuploadedFiles";
$route["getPathologyTableData"]="PathologyOrderController/getPathologyTableData";



// ---------------------- Staff Registration -----------------------

$route["staffRegistration"]="StaffRegistrationController/index";
$route["get_profile_type"]="StaffRegistrationController/get_profile_type";

$route["get_staff_zone"]="StaffRegistrationController/get_staff_zone";
$route["saveStaff"]='StaffRegistrationController/add_staff';


$route["staff/getPatientData"]="StaffRegistrationController/getPatientDataById";
$route["staff/get_profile_type"]="StaffRegistrationController/get_profile_type";

$route["staff/get_staff_zone"]="StaffRegistrationController/get_staff_zone";
$route["staff/saveStaff"]='StaffRegistrationController/add_staff';
$route["viewOtherService"]="OtherServiceController/load_view";
$route["save-consumable-pharmary-order"]="MedicineOrderController/saveConsumableOrder";
// ---------------------- patient report -----------------------
$route["patientReport"]="PatientReportController/index";
$route["get_Hr_chart"]="PatientReportController/get_Hr_chart";
$route["get_Rr_chart"]="PatientReportController/get_Rr_chart";
$route["get_nibp_chart"]="PatientReportController/get_nibp_chart";

$route["get_SBP_MAP_chart"]="PatientReportController/get_SBP_MAP_chart";

$route["get_SPO2_chart"]="PatientReportController/get_SPO2_chart";
$route["get_VitalSigns"]="PatientReportController/get_VitalSigns";

$route["get_excelSigns"]="PatientReportController/get_excelSigns";
$route["get_sofaScore"]="PatientReportController/get_sofaScore";

$route["get_patientReportImage"]="PatientReportController/get_patientReportImage";
$route["get_HEME_data"]="PatientReportController/get_HEME_data";



$route["criticalCare"]="CriticalCareController/index";





// ------------------ api --------------------
$route["api/lab_report"]="HL7Controller/labReportApi";

//---icu nursing care  IcuCareController
$route["getData"]="IcuCareController/getData";
$route["uploadIcuCriticalCareForm"]="IcuCareController/uploadIcuCriticalCareForm";
$route["getIcuCareDataById"]="IcuCareController/getIcuCareDataById";
$route["getDataTimeUnder"]="IcuCareController/getDataTimeUnder";


$route["IcunursingCare"]="IcuCareController";
$route["getGCSData"]="IcuCareController/getGCSData";
$route["uploadGlassglowForm"]="IcuCareController/uploadGlassglowForm";

$route["getGlasGlowDataById"]="IcuCareController/getGlasGlowDataById";


$route["getBradenScaleData"]="IcuCareController/getBradenScaleData";
$route["uploadBradenScaleForm"]="IcuCareController/uploadBradenScaleForm";
$route["getBardenScaleDataById"]="IcuCareController/getBardenScaleDataById";


$route["getFallRiskAsseData"]="IcuCareController/getFallRiskAsseData";
$route["uploadFallRiskForm"]="IcuCareController/uploadFallRiskForm";
$route["getFallRiskDataById"]="IcuCareController/getFallRiskDataById";


$route["uploadSofaScore"]="IcuCareController/uploadSofaScore";
$route["getSofaScroTable"]="IcuCareController/getSofaScroTable";


$route["getDownloadDietReportData"]="IcuCareController/getDownloadDietReportData";
$route["getDownloadDietReport"]="IcuCareController/getDownloadDietReport";


$route["GetBundlesData"]="PatientReportController/GetBundlesData";


// ---------------------- Consumable Order -----------------------

$route["consumableOrder"]="ConsumableOrderController/index";
$route["getConsumableGroup"]="ConsumableOrderController/getConsumableGroup";

$route["getConsumableComapanyUsers"]="ConsumableOrderController/getComapanyUsers";
$route["add_consumable_order"]="ConsumableOrderController/add_consumable_order";

$route["getConsumableDescription"]="ConsumableOrderController/getConsumableDescription";
$route["get-materialConsumableDescription"]="ConsumableOrderController/getmaterialConsumableDescriptionOptions";

$route["placeConsumableMaterialOrder"]="ConsumableOrderController/placeConsumableMaterialOrder";
$route["getReceiveConsumableOrderHistoryTable"]="ConsumableOrderController/getReceiveConsumableOrderHistoryTable";
$route["getViewConsumableOrderData"]="ConsumableOrderController/getViewConsumableOrderData";
$route["newConsumableMaterialOrderListForm"]="ConsumableOrderController/newConsumableMaterialOrderListForm";
$route["getConsumableOrderMaterialListTable"]="ConsumableOrderController/getConsumableOrderMaterialListTable";
$route["deleteConsumableOrderMaterialTranscation"]="ConsumableOrderController/deleteConsumableOrderMaterialTranscation";
$route["deleteConsumableOrderTranscation"]="ConsumableOrderController/deleteConsumableOrderTranscation";
$route["receiveConsumableOrderForm"]="ConsumableOrderController/receiveConsumableOrderForm";


// ---------------------- Dashboard section -----------------------

$route["Dashboard"]="DashboardController/dashboard_view";
$route["getDashboardBillingReport"]="DashboardController/getDashboardBillingReport";

// $route["getDashboardBillingReport/(:any)"]="DashboardController/getDashboardBillingReport/$1";

// $route["getDownloadDashboardBilling/(:any)"]="DashboardController/getDownloadDashboardBilling/$1";

$route["getDownloadDashboardBilling"]="DashboardController/getDownloadDashboardBilling";
$route["getDeathTranferBillingReport"]="DashboardController/getDeathTranferBillingReport";
$route["getDeathTranferBillingExcelReport"]="DashboardController/getDeathTranferBillingExcelReport";

// ---------------------- Risk nodes -----------------------
$route["risknode"]="RiskNodeController/index";
$route["loadTreeNodes"]="RiskNodeController/loadTreeNodes";

$route["getRiskExcelReport"]="RiskNodeController/getRiskExcelReport";

$route["icuPatientView"]="DashboardController/icuPatientView";


//---------------------- Report Maker -----------------------
$route["report_maker"]="ReportMakerController/index";
$route['getAllTablenames'] = 'ReportMakerController/getAllTablenames';
$route['GetAllColumns'] = 'ReportMakerController/GetAllTableColumns';
$route["save_template_sectionsHtml"]="ReportMakerController/save_template_reportHtml";
$route["getReportMakers"]="ReportMakerController/getReportMakers";
$route["fetch_ReportMakerHtml"]="ReportMakerController/fetch_ReportMakerHtml";
$route['getTableQueryData'] = 'ReportMakerController/getTableQueryData';
$route['saveQueryTableData'] = 'ReportMakerController/saveQueryTableData';
$route['getParaghraphConfigurationData'] = 'ReportMakerController/getParaghraphConfigurationData';
$route["deleteReportmaker"]="ReportMakerController/deleteReportmaker";

$route["getQueryStringPara"]="ReportMakerController/getQueryStringPara";

$route["ViewReportMaker/(:any)/(:any)/(:any)"]="ReportMakerController/ViewReportMaker/$1/$2/$3";
$route["GetReportView"]="ReportMakerController/GetReportView";
$route["GetQueryParamDataReport"]="ReportMakerController/GetQueryParamDataReport";
$route["GetPrescriptionReport"]="ReportMakerController/GetPrescriptionReport";

//---------------------- html form view -----------------------

$route["html_navigation/(:any)/(:any)/(:any)"]="HtmlNavigationController/index/$1/$2/$3";
$route["getDepartmentMenus"]="HtmlNavigationController/getDepartmentMenus";
$route["getDepartmentMenus"]="HtmlNavigationController/getDepartmentMenus";
$route["getFormInputValues"]="HtmlNavigationController/getFormInputValues";
$route["GetBillingInfoData"]="HtmlNavigationController/GetBillingInfoData";
$route["AddServiceorderBillFile"]="HtmlNavigationController/AddServiceorderBillFile";


// -------------------------------- Html Section --------------------------------
$route["admin/Html_template"]="HtmlFormTemplateController/Html_template";
$route["admin/Html_template_drag"]="HtmlFormTemplateController/Html_template_drag";

$route['admin/Html_template/getAllTablenames'] = 'HtmlFormTemplateController/getAllTablenames1';
$route['admin/Html_template/GetAllColumns'] = 'HtmlFormTemplateController/GetAllTableColumns';

$route['admin/Html_template/getQueryDropdownData'] = 'HtmlFormTemplateController/getQueryDropdownData';
$route['admin/htmlform/save_dropdown_sectionsHtml'] = 'HtmlFormTemplateController/save_dropdown_sectionsHtml';
$route['admin/htmlform/save_html_querydrop_default'] = 'HtmlFormTemplateController/save_html_querydrop_default';

$route['admin/htmlform/getQueryDropdownAjax'] = 'HtmlFormTemplateController/getQueryDropdownAjax';

$route['admin/Html_template/getExcelPdfData'] = 'HtmlFormTemplateController/getExcelPdfData';
$route['admin/Html_template/saveFormData'] = 'HtmlFormTemplateController/saveFormData';
$route['admin/Html_template/getReportFormData'] = 'HtmlFormTemplateController/getReportFormData';

$route['admin/Html_template/DownloadData'] = 'HtmlFormTemplateController/DownloadData';
$route['admin/Html_template/DownloadNewpdf'] = 'HtmlFormTemplateController/DownloadNewpdf';
$route['admin/Html_template/ExcelHeadersave'] = 'HtmlFormController/ExcelHeadersave';

$route['getHtmlTemplateForm'] = 'HtmlFormTemplateController/getHtmlTemplateForm';
$route['admin/getTableColumnsAndDatatypes'] = 'HtmlFormTemplateController/getTableColumnsAndDatatypes';


// ---------------------- Database table Creation -----------------------
$route["table_creation"]="DatabaseCreationController/table_creation";
$route["createNewtable"]="DatabaseCreationController/createNewtable";
$route["getAllTablesFromDatabase"]="DatabaseCreationController/getAllTablesFromDatabase";
$route["getDatabaseTableCategories"]="DatabaseCreationController/getDatabaseTableCategories";
$route["saveDatabaseTableCreation"]="DatabaseCreationController/saveDatabaseTableCreation";

$route["admin/saveDynamicTableEntry"]="HtmlFormController/saveDynamicTableEntry";

$route["admin/inputFromDataTable"]="DatatableFormInputController/viewFormDataTable";
$route["admin/saveDynamicFormTableEntry"]="DatatableFormInputController/saveDynamicFormTableEntry";
$route["getHeaderConfiguration"]="DatatableFormInputController/getHeaderConfiguration";
$route["updateDynamicFormTransaction"]="DatatableFormInputController/updateDynamicFormTransaction";
$route["admin/getDynamicFormData"]="DatatableFormInputController/getDynamicFormData";
$route["admin/getColumnOptions"]="DatatableFormInputController/getColumnOptions";
$route["admin/GetDataColumnsForConfig"]="DatatableFormInputController/GetDataColumnsForConfig";
$route["GetDataColumnsForConfig"]="DatatableFormInputController/GetDataColumnsForConfig";
$route["admin/InsertFordataUsingButton"]="HtmlFormController/InsertFordataUsingButton";
$route["InsertFordataUsingButton"]="HtmlFormController/InsertFordataUsingButton";

// ------------------------- Html form section -------------------------------------
$route["admin/Html_form"]="HtmlDepartmentController";
$route["admin/getHtmlDepartments"]="HtmlDepartmentController/getDepartmentTableData";

$route["admin/saveHtmlDepartment"]="HtmlDepartmentController/uploadDepartment";
$route["admin/ChangeHtmlDepartmentStatus"]="HtmlDepartmentController/ChangeDepartmentStatus";
$route["admin/getHtmlDepartmentDataById"]="HtmlDepartmentController/getDepartmentDataById";
$route["admin/companyHtmlDepartment"]='HtmlDepartmentController/selectCompanyDepartment';

$route["admin/Htmlform_template"]="HtmlFormTemplateController/Htmlform_template";
$route["admin/htmlform/save_template"]="HtmlFormTemplateController/saveTemplate";
$route["admin/htmlform/fetch_template_sections"]="HtmlFormTemplateController/getDepartmentSections";
$route["admin/htmlform/fetch_section_details"]="HtmlFormTemplateController/getSectionElements";
$route["admin/htmlform/deleteSection"]="HtmlFormTemplateController/deleteSection";
$route["admin/htmlform/deleteTemplateElement"]="HtmlFormTemplateController/deleteTemplateElement";

$route["admin/htmlform/sectionSave"]="HtmlFormTemplateController/add_form_data";
$route["admin/htmlform/get_history_data"]="HtmlFormController/get_history_data";

$route["htmlform/get_history_data"]="HtmlFormController/get_history_data";
$route["admin/SaveQueryDataHTML"]="HtmlFormController/SaveQueryDataHTML";
$route["admin/SaveQueryDataHTMLTable"]="HtmlFormController/SaveQueryDataHTMLTable";
$route["admin/GetQueryDatatoEdit"]="HtmlFormController/GetQueryDatatoEdit";
$route["admin/UpdatequeryTable"]="HtmlFormController/UpdatequeryTable";
$route["admin/InsertFordataUsingButton"]="HtmlFormController/InsertFordataUsingButton";
$route["admin/getButtoQueryTable"]="HtmlFormController/getButtoQueryTable";
$route["admin/GetQueryParamData"]="HtmlFormController/GetQueryParamData";
$route["admin/getQueryStringPara"]="HtmlFormController/getQueryStringPara";
$route["admin/getQueryStringPara2"]="HtmlFormController/getQueryStringPara2";
$route["admin/GetallSections"]="HtmlFormController/GetallSections";
$route["CheckHistoryUnabled"]="HtmlFormController/CheckHistoryUnabled";
$route["htmlform/sectionSave"]="HtmlFormTemplateController/add_form_data";
$route["getDataTableElementId"]="HtmlFormTemplateController/getDataTableElementId";

$route["admin/htmlform/fetch_template_sectionsHtml"]="HtmlFormTemplateController/fetch_template_sectionsHtml";
$route["admin/htmlform/save_template_sectionsHtml"]="HtmlFormTemplateController/save_template_sectionsHtml";

$route['admin/htmlform/getFreeFormtemplatelist'] = 'HtmlFormTemplateController/gettemplatelist';


$route['admin/uploadTrumbowygImage'] = 'HtmlFormTemplateController/uploadTrumbowygImage';

$route["GetQueryParamDataReport/(:any)/(:any)"]="ReportMakerController/GetQueryParamDataReport/$1/$2";

$route["admin/getAllTables"]="DatatableEditorController/getAllTableNames";
$route['admin/fetchTemplateDatatableData'] = 'DatatableEditorController/fetchTemplateDatatableData';
$route["admin/getAllTablenames"]="Report/getAllTablenames";
$route["admin/GetAllColumns"]="Report/GetAllColumns";


// ---------------------- Datatable Editor -----------------------
$route["admin/dataTableEditor"]="DashboardController/dataTableEditor";
$route["admin/getAllTables"]="DatatableEditorController/getAllTableNames";
$route["admin/getAllColumns"]="DatatableEditorController/getAllColumns";
$route["admin/saveDataTableEditor"]="DatatableEditorController/saveDataTableEditor";
$route["admin/getDataTableTemplate"]="DatatableEditorController/getDataTableTemplate";
$route["admin/getDataTableData"]="DatatableEditorController/getDynamicTableData";
$route["admin/getAllSection"]="DatatableEditorController/getAllSection";

$route["api2SaveSampleCollection"]="ApiController/api_HNH_Authenticate";

$route['admin/fetchTemplateDatatableData'] = 'DatatableEditorController/fetchTemplateDatatableData';

$route["getDataTableTemplate"]="DatatableEditorController/getDataTableTemplate";
$route["getDataTableData"]="DatatableEditorController/getDynamicTableData";
$route["executionButton"]="DatatableEditorController/executionButton";


$route["getFormInputValues"]="HtmlNavigationController/getFormInputValues";



// -------------------------------- Html User Section --------------------------------
$route["admin/html_form_view/(:any)/(:any)"] = "HtmlFormTemplateController/html_form_view/$1/$2";
$route["html_form_view/(:any)/(:any)"] = "HtmlFormTemplateController/html_form_view/$1/$2";
$route['Html_template/getReportFormData'] = 'HtmlFormTemplateController/getReportFormData';
$route['Html_template/DownloadData'] = 'HtmlFormTemplateController/DownloadData';
$route['Html_template/DownloadNewpdf'] = 'HtmlFormTemplateController/DownloadNewpdf';
$route['Html_template/getDataTableReport'] = 'HtmlFormTemplateController/getDataTableReport';
$route['Html_template/DownloadNewcsv'] = 'HtmlFormTemplateController/DownloadNewcsv';
$route["InsertFordataUsingButton"]="HtmlFormController/InsertFordataUsingButton";
$route["admin/excel_table_test"]="HtmlFormController/excel_table_test";
$route["admin/getExcelTableConfiguaration"]="HtmlFormController/getExcelTableConfiguaration";

$route["getExcelTabledata"]="HtmlFormController/getExcelTabledata";
$route["ExcelTabledataInsert"]="HtmlFormController/ExcelTabledataInsert";
$route["admin/getAllColumnsListExcel"]="HtmlFormController/getAllColumnsListExcel";
$route["admin/getExcelTableConfiguarationUpdate"]="HtmlFormController/getExcelTableConfiguarationUpdate";
$route["admin/getExcelTableConfiguarationDelete"]="HtmlFormController/getExcelTableConfiguarationDelete";
$route["datatableTabSection"]="DatatableEditorController/datatableTabSection";

$route["opdPanel"]="DatatableEditorController/opdPanel";
$route["searchPatient"]="PatientController/searchPatient";

//---------------------- patient navigation form view -----------------------

$route["patient_navigation/(:any)/(:any)/(:any)"]="HtmlNavigationController/patient_navigation/$1/$2/$3";

//operatonal details
$route["operation_details"]="Operation_details";
$route["load_service_amount"]="HtmlNavigationController/load_service_amount";
$route["patient_report"]="HtmlNavigationController/patient_report";
//--------------------- Lab Patient -----------------------------------------

$route["lab_patient"] = "LabPatientController/lab_patient";
$route["saveLabPatient"]='LabPatientController/add_patient';
$route["searchLabPatient"]="LabPatientController/searchPatient";
$route["lab_patient/(:num)"] = "LabPatientController/lab_patient/$1";

$route["getLabServiceOrders1"]="LabPatientController/getLabServiceOrders1";
$route["lab_patient/getPatientData"]="LabPatientController/getPatientDataById";
$route["lab_patient/getZoneData"]="PatientController/getZoneData";
$route["lab_patient/saveLabPatient"]='LabPatientController/add_patient';
$route["labpatient_info"]="LabPatientController/labpatientInfo";
$route["getLabPatientTableData"]="LabPatientController/getLabPatientTableData";
$route["deleteLabPatient"]="LabPatientController/deleteLabPatient";
$route["get_labpatient_data/(:num)"]="LabPatientController/get_labpatient_data/$1";
$route["labpatient_report/(:any)/(:any)/(:any)"]="LabPatientController/labpatient_report/$1/$2/$3";
$route["master_package/(:any)/(:any)/(:any)"]="LabPatientController/master_package/$1/$2/$3";
$route["getLabDataEntryExcelData"]="LabPatientController/getLabDataEntryExcelData";


$route["getServiceTest"]="LabPatientController/getServiceTest";
$route["getPackageTest"]="LabPatientController/getPackageTest";
$route["getServiceChildTest"]="LabPatientController/getServiceChildTest";
$route["getPackageChildTest"]="LabPatientController/getPackageChildTest";
$route["saveLabServiceOrder"]="LabPatientController/saveLabServiceOrder";
$route["getLabServiceOrders"]="LabPatientController/getLabServiceOrders";
$route["getlabServiceCancelOrder"]="LabPatientController/getlabServiceCancelOrder";
$route["getlabServiceChildOrder"]="LabPatientController/getlabServiceChildOrder";
$route["showLabPatientReport"]="ReportMakerController/labReportGeneration";

$route["getServiceOrderOptions"]="LabPatientController/getAllServiceOrderOptions";
$route["getPatientLabOrders"]="LabPatientController/getAllServiceOrderTest";
$route["patientLabReport/(:any)"]="ReportMakerController/load_view/$1";

//----------------------------- Lab Section -----------------------------

$route["viewLabDashboard"]="LabController";
$route["labMaster/(:any)/(:any)/(:any)"]="LabController/labMaster/$1/$2/$3";

$route["getAnyoneDependantOnQueryDropdown"]="HtmlFormTemplateController/getAnyoneDependantOnQueryDropdown";
$route["loadElementsValue"]="HtmlFormTemplateController/loadElementsValue";

$route['get_occupiedroomdetails_info'] = 'BedManagementController/get_occupiedroomdetails_info';


$route['setup_lab_master/(:any)/(:any)/(:any)'] = 'ReportMakerController/setup_lab_master/$1/$2/$3';
$route['setup_child_lab_master/(:any)/(:any)/(:any)'] = 'ReportMakerController/setup_child_lab_master/$1/$2/$3';


// -------------------------- Payer deatils -------------------------------
$route['payerDetails/(:any)/(:any)/(:any)'] = 'ReportMakerController/payerDetails/$1/$2/$3';

$route["getPatientBIllingPrintData"]="BillingManagementController/getPatientBIllingPrintData";
$route["savePatientBIllingDiscountData"]="BillingManagementController/savePatientBIllingDiscountData";

// ------------------------------lab branch Section -------------------------------------------
$route["admin/view_lab_branch"] = "Welcome/view_lab_branches";
// create and update company
$route["admin/upload_lab_branch"]='LabBranchController/upload_lab_branch';
// datatable fetch all companies
$route["admin/fetch_lab_branch"]="LabBranchController/getlab_branchTableData";
$route["admin/getlabbranchDataById"]="LabBranchController/getlabbranchDataById";
$route["admin/ChangeLabBranchStatus"]="LabBranchController/ChangeLabBranchStatus";
// ---------- inline datatable ----------------------------------
$route["admin/getSectionConfigData"]="HtmlFormTemplateController/getSectionConfigData";
$route["admin/getSectionTableData"]="HtmlFormTemplateController/getSectionTableData";
$route["getDoctorList"]="PatientController/getDoctorList";
$route["patient/getDoctorList"]="PatientController/getDoctorList";
$route["new_patients/getDoctorList"]="PatientController/getDoctorList";
$route["getPatientBIllingPrintDataNew"]="BillingManagementController/getPatientBIllingPrintDataNew";

// ------------------------------Access Management-------------------------------------------
$route["access_management"]="AccessManagementController/index";
$route["getAccessMgmtFormData"]="AccessManagementController/getAccessMgmtFormData";
$route["getAllBranchesList"]="AccessManagementController/getAllBranchesList";
$route["saveAccessMgmtFormData"]="AccessManagementController/saveAccessMgmtFormData";

$route["branch_access_management"]="AccessManagementController/branch_access_management";
$route["getBranchAccessMgmtFormData"]="AccessManagementController/getBranchAccessMgmtFormData";
$route["saveBranchAccessMgmtFormData"]="AccessManagementController/saveBranchAccessMgmtFormData";
// ------------------------------Security User Management-------------------------------------------
$route["security"]="SecurityController/index";
$route["getOtp"]="SecurityController/security";
// -------------------------- User Management ----------------------------------------------

$route["user_management"]="AccessManagementController/user_management";
$route["getAllCompanyList"]="AccessManagementController/getAllCompanyList";
$route["get_user_types"]="AccessManagementController/get_user_types";
$route["saveUsersMgmtFormData"]="AccessManagementController/saveUsersMgmtFormData";
// ------------------------------------------OTP------------------------------------------------//
$route['otp'] = 'LoginController/otp';
$route['OtpValidation'] = 'LoginController/validateOtp';
$route['updateMobile'] = 'LoginController/updateMobile';
$route['ResendOtp'] = 'LoginController/ResendOtp';

// pathology service order
$route["pathologyCollection"]="ServiceOrderController/pathologyCollection";
$route["getLabCollectionTable"]="ServiceOrderController/getCollectionTable";
$route["getserviceOrderBillingInfo2"]="ServiceOrderController/getserviceOrderBillingInfo2";

$route["updateDynamicLabData"]="LabPatientController/updateDynamicLabData";
$route["get_patient_history_data"]="PatientController/get_patient_history_data";

$route["getMasterTestData"]="LabController/getMasterTestData";
$route["getLabMasterChildEntryExcelData"]="LabController/getLabMasterChildEntryExcelData";
$route["saveSubGroupChildData"]="LabController/saveSubGroupChildData";
$route["RemoveChildTestData"]="LabController/RemoveChildTestData";

$route["getLabPathologyTableData"]="PathologyOrderController/getLabPathologyTableData";
