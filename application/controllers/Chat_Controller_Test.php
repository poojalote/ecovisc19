<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chat_Controller_Test extends CI_Controller
{


	/**
	 * Chat_Controller constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->load->model("MessengerModel");


	}

	public function index()
	{
		$this->load->view('chat_view/chat_test');
	}
	public function chat_backup()
	{
		$this->load->view('chat_view/chat_backup');
	}
	
	
	public function dashboard()
	{
		$this->load->view('test/test_new.php');
	}
	
	public function video_chat()
	{
		$this->load->view('chat_view/video_call');
	}

	public function news18()
	{
		$query_fetch = $this->db->query("SELECT * from news_article_websites_table");
		$data['count'] = $query_fetch->num_rows();
		$data['url_data'] = $query_fetch->result_array();
		//print_r($data);exit;
		$this->load->view('test/news18', $data);
	}

	public function test_web()
	{
		$this->load->view('test/hindutan');
	}

	public function test_webScraping()
	{
		$this->load->view('test/times');
	}

	public function video_design()
	{
		$this->load->view('chat_view/video_design');
	}

	public function test_window()
	{
		$this->load->view('test/test_window');
	}

	public function test_news()
	{
		$this->load->view('dashboard/test_news');
	}

	public function test_toggle()
	{
		$this->load->view('test/test_toggle');
	}

	public function test_toggle_mobile()
	{
		$this->load->view('test/test_toggle_mobile');
	}

	public function test_copy()
	{
		$this->load->view('test/test_copy');
	}

	public function rmt_dashboard()
	{
		$this->load->view('test/rmt_dashboard_design');
	}
	public function rmt_dashboard_backup()
	{
		$this->load->view('test/rmt_dashboard_backup');
	}

	/*
     * get user of logged user firm or passing firm id
     * return array if data available otherwise empty array
     */
	public function get_firm_users()
	{
		if (!is_null($this->input->post('firm_id'))) {
			$firm_id = $this->input->post('firm_id');
		} else {
			$firm_id = $this->session->user_session->firm_id;
		}
		$user_id = $this->session->user_session->user_id;
		$resultObject = $this->MessengerModel->getFirmUsers($firm_id, $user_id);
		if ($resultObject->totalCount != 0) {
			echo json_encode($resultObject->data);
		} else {
			echo json_encode(array());
		}
	}

	/*
     * send message to user pass receiver group id and message
     * return send time with tempId which is use for update delivery status and time
     */
	public function send_message()
	{

		if (!is_null($this->input->post('group_id')) && !is_null($this->input->post('message'))) {
			$time = date("Y-m-d H:i:s");
			$this->load->model("Global_model");
			$des_path = "";
			$content_type = 1;
			$imageResult = $this->Global_model->upload_multiple_file_new('chat_assets/storage/user_files', 'userFile', 2);
			$mtype = $this->input->post('mtype');

			if ($imageResult["status"] == 200) {
				if (count($imageResult["body"]) > 0) {
					if ($imageResult["body"][0] === "chat_assets/storage/user_files/") {
						$des_path = "";
						$response['status'] = 201;
						$response['body'] = "Failed To Store Message";
						echo json_encode($response);
						exit();
					} else {
						$des_path = $imageResult["body"][0];
						$content_type = 2;
					}
				}
				$response['imagePath'] = $imageResult["body"][0];
			}
			$messageDetails = array('sender_id' => $this->session->group_id,
				'group_id' => $this->input->post('group_id'),
				'content' => $this->input->post('message'),
				'create_on' => $time,
				'content_type' => $mtype,
				'file_reference' => $des_path
			);

			$resultObject = $this->MessengerModel->sendMessage($messageDetails);

			if ($resultObject->status) {
				$response['status'] = 200;
				$response['body'] = "Send Message";
				$response['tempId'] = $this->input->post('tempID');
				$response['time'] = $time;
				$response['msg_id'] = $resultObject->inserted_id;
			} else {
				$response['status'] = 201;
				$response['body'] = "Failed To Store Message";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Bad Request";
		}
		echo json_encode($response);
	}

	/*
     *  pass group id to fetch all message of remote and local user
     *  return array of message
     */
	public function get_messages()
	{
		if (!empty($this->input->post('remote_group_id'))) {
			if ($this->input->post('local_group_id') == '-1') {
				$local_group_id = $this->session->group_id;
			} else {
				$local_group_id = $this->input->post('local_group_id');
			}

			$remote_group_id = $this->input->post('remote_group_id');
			$resultObject = $this->MessengerModel->getMessage($remote_group_id, $local_group_id);
			//var_dump($resultObject);exit;
			if ($resultObject->totalCount != 0) {
				echo json_encode($resultObject->data);
			} else {
				echo json_encode(array());
			}
		} else {
			echo json_encode(array());
		}
	}

	public function add_to_favourite()
	{
		$fav_id = $this->input->post('fav_id');
		$id = $this->input->post('id');
		//print_r($fav_id);exit();
		$user_id = $this->session->user_session->user_id;
		$create_by = $this->session->user_session->email;
		$status_id = 1;
		$count = $this->db->query("SELECT * from chat_favourite_user WHERE user_id='$user_id' AND fav_id='$id'")->num_rows();
		//print_r($count);exit();
		if ($count == 0) {
			$data = array('user_id' => $user_id,
				'fav_user_id' => $fav_id,
				'fav_id' => $id,
				'create_by' => $create_by,
				'status' => $status_id);
			$result = $this->db->insert("chat_favourite_user", $data);
			$result1 = $this->db->insert_id();
			//print_r($result1);exit();

			$response['status'] = 200;
			$response['body'] = 'Added to Favourite';
		} else {
			$where = array('user_id' => $user_id,
				'fav_id' => $id);
			$this->db->where($where);
			$this->db->delete('chat_favourite_user');

			//$count = $this->db->query("SELECT * from chat_favourite_user WHERE user_id='$user_id' AND fav_id='$id' AND status=0")->num_rows();
			//print_r($count);exit;
			//if($count == 0)
			//{
			//$data1 = array('status' => 0);
			//$this->db->where($where);
			//$this->db->update('chat_favourite_user', $data1);
			$response['status'] = 201;
			$response['body'] = 'Remove From Favourite';
			//}
			//else{
			//$data1 = array('status' => 1);
			//$this->db->where($where);
			//$this->db->update('chat_favourite_user', $data1);
			//$response['status'] = 202;
			//$response['body'] = 'Added to Favourite';
			//}


		}
		echo json_encode($response);
		//print_r($id);exit();
		//$user_data=$this->db->query("SELECT * FROM user_master WHERE id ='$id'");
		//foreach ($user_data->result() as $row)
		//{
		//   $fav_id=$row->id;
		//   $fav_name=
		//}
		//print_r($user_data);exit();
	}

	public function get_favourite()
	{
		//print_r("ok");
		$user_id = $this->session->user_session->user_id;
		$create_by = $this->session->user_session->email;
		$user_name = $this->input->post('user_name');
		$user_email = $this->input->post('user_email');
		$firm_id = $this->input->post('firm_id');
		$group_id = $this->input->post('group_id');
		$Get_Fav_data = $this->db->query("SELECT *,(SELECT user_name FROM user_header_all WHERE user_header_all.id=chat_favourite_user.fav_id) as name,(SELECT id FROM user_header_all WHERE user_header_all.id=chat_favourite_user.fav_id) as g_id FROM chat_favourite_user WHERE create_by ='$create_by'")->result();
		//print_r($Get_Fav_data);exit();
		$data = '';
		if ($Get_Fav_data != null) {

			foreach ($Get_Fav_data as $row) {
				//$id=$row->user_fav_id;
				//$user_data=$this->db->query("SELECT * FROM user_master WHERE id ='$id'")->row();
				// <li class="person chatboxhead active" id="chatbox1_Deven" data-chat="person_1" href="javascript:void(0)" onclick="javascript:chatWith("deven",'.$row->fav_user_id.',"deven.jpg","Online")">
				// <a href="javascript:void(0)">
				// <span class="userimage profile-picture min-profile-picture"><img src="'.base_url().'public/storage/user_image/Deven.jpg" alt="Deven" class="avatar-image is-loaded bg-theme" width="100%"></span>
				// <span>
				// <span class="bname personName">'.$row->name.'</span>
				// <span class="personStatus"><span class="time '.$cls.'"><i class="fa fa-circle" aria-hidden="true"></i></span></span>
				// <br>
				// <small class="preview"><span class="'.$cls.'">'.$status.'</span></small>
				// </span>
				// </a>
				// </li>
				if ($row->status == 1) {
					$cls = "Online";
					$status = '<span class="personStatus">
                         <span class="time Online">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                         </span>
                     </span>
                    <br>
                 <small class="preview">Online</small>';
				} else {
					$cls = "Offline";
					$status = '<span class="personStatus">
                         <span class="time Offnline">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                         </span>
                     </span>
                    <br>
                 <small class="preview">Offline</small>';
				}
				$data .= '
        	 
			  <li class="person tablinks" 
                                    id="chatbox_' . $row->g_id . '"
                                    data-chat="person_' . $row->g_id . '"
                                    href="javascript:void(0)" 
                                    onclick="chatWith(\'' . $row->g_id . '\',\'' . $row->name . '\',\'' . $user_name . '\', \'' . $row->fav_user_id . '\',\'' . $group_id . '\'),openCity(event, \'' . $row->g_id . '\')">
                                    <a href="javascript:void(0)">
                                        <span class="userimage profile-picture min-profile-picture">
                                        <img src="https://rmt.docango.com/chat_assets/storage/user_image/avatar_default.png" alt="avatar" class="avatar-image is-loaded bg-theme" width="100%"></span>
                                        <span class="bname personName">' . $row->name . '</span>
                                        <span id="person_status_' . $row->fav_user_id . '">                                           
                                           ' . $status . '
                                         </span>
                                    </a>
                                </li>
        	';
			}
			//print_r($data);exit();
			$response['data'] = $data;
			$response['status'] = 200;
			$response['body'] = 'Successfully sent';
		} else {
			$response['data'] = $data;
			$response['status'] = 201;
			$response['body'] = 'fail to send mail';
		}
		echo json_encode($response);
		//print_r($user_data);exit();
	}

	public function add_group()
	{

		$create_by = $this->session->user_session->email;
		$form_data = $this->input->post('Users');
		$group_name = $this->input->post('group_name');
		$group_data = array(
			'group_name' => $group_name,
			'create_by' => $create_by,
			'type' => 2);
		$group_member = array();
		foreach ($form_data as $member) {
			$group_member[] = array(
				'email_id' => $member,
				'role' => 2,
				'permission' => 0);
		}
		$groupResult = $this->MessengerModel->createGroup($group_data, $create_by, $group_member);

		if ($groupResult->status) {
			$response["status"] = 200;
			$response["body"] = "New Group Created";

		} else {
			$response["status"] = 201;
			$response["body"] = "Failed To Create New Group";
		}
		echo json_encode($response);
	}

	public function get_users_Id()
	{
		$user_id = $this->session->user_session->user_id;
		$status = 1;
		if (!is_null($this->input->post('firm_id'))) {
			$firm_id = $this->input->post('firm_id');
		} else {
			$firm_id = $this->session->user_session->firm_id;
		}
		$firm_id = $this->input->post('firm_id');
		$Get_User_data = $this->db->query("SELECT * FROM user_header_all WHERE firm_id='$firm_id' AND activity_status='$status'")->result();
		//print_r($Get_User_data);exit();

		$option = "";
		if ($Get_User_data != FALSE) {
			foreach ($Get_User_data as $row) {
				if ($row->user_id == $user_id) {
				} else {
					$option .= '<option value="' . $row->id . '">' . $row->user_name . '</option>';
				}
			}
			$response['code'] = 200;
			$response['data'] = $option;
		} else {
			$response['code'] = 201;
			$response['data'] = $option;
		}
		echo json_encode($response);
	}

	/*
     *  pass email id to find user involve in which group
     * return array of all group details
     */
	public function get_user_involve_groups()
	{
		if (!empty($this->input->post('email_id'))) {
			$email_id = $this->input->post('email_id');
			$resultObject = $this->MessengerModel->getUserInvolveInGroup($email_id);
			echo json_encode($resultObject->data);
		} else {
			echo json_encode(array());
		}
	}

	public function update_member()
	{
		$email = 1;
		$group_id = 1;
		$role = 1;
		$permission = 0;
		$mapping_id = 1;
		$group_member = array('group_id' => $group_id,
			'email_id' => $email,
			'role' => $role,
			'permission' => $permission);
		$this->load->model("MessengerModel");
		$result = $this->MessengerModel->updateMember($group_member, $mapping_id);
		echo json_encode($result);
	}

	public function remove_member()
	{
		$mapping_id = 1;

		$this->load->model("MessengerModel");
		$result = $this->MessengerModel->removeMember($mapping_id);
		echo json_encode($result);
	}

	public function get_member()
	{
		$group_id = $this->input->post('id');
		$emailId = $this->session->user_session->email;

		$this->load->model("MessengerModel");
		$result = $this->MessengerModel->getMember($group_id);
		$get_members = $result->data;
		$type = '';
		$data1 = '';
		$data3 = '';
		$data4 = '';
		$data5 = '';
		$data6 = '';
		//$result = $this->db->query("SELECT * FROM chat_group_map_all,(SELECT user_name FROM user_header_all WHERE user_header_all.email=chat_group_map_all.email_id) as user_name WHERE group_id='$group_id'")->result();
		$result1 = $this->db->query("SELECT type FROM chat_group_all WHERE id='$group_id'")->row();
		//print_r($result1);exit;
		$type = $result1->type;
		$data = '';
		//';$data3 ='//
		if ($result1 != null && $type == 2) {
			$query_data = $this->db->query("SELECT * FROM chat_group_map_all WHERE group_id='$group_id' AND email_id='$emailId' AND permission=1")->num_rows();
			//print_r($query_data);exit;
			if ($query_data != null) {
				if ($query_data > 0) {
					$data4 = '<a onclick="edit_grp_name(' . $group_id . ')" style="color:white;"><i class="fa fa-edit"></i></a>';
					$data3 = '<div class="user-btm-box">
						   
							<div class="row text-center m-t-10">
							<div class="col-md-12 b-r"><strong>Add group member</strong><p><a onclick="add_grp_member(' . $group_id . ')"><i class="fa fa-edit"></i></a></p></div>
						   
							</div>
							<hr>
							<div class="row text-center m-t-10">
							<div class="col-md-12 b-r"><strong>Remove Group</strong><p><a onclick="remove_grp(' . $group_id . ')"><i class="fa fa-trash"></i></a></p></div>
						   
							</div>
							
						   ';
					$data5 = '';
					$data6 = '<button style="color:white;margin-left:-5px;" onclick="groupImage(' . $group_id . ')"><i class="fa fa-edit"></i></button>';
				} else {
					$data4 = '';
					$data3 = '';
					$data5 = '
				<div class="row text-center m-t-10">
				<div class="col-md-12 b-r" style="color:red;"> <button onclick="left_grp(' . $group_id . ')"><strong>Left Group </strong> <i class="fa fa-trash"></i></button></div>
			   
				</div>';
					$data6 = '';

				}
			} else {
				$data4 = '';
				$data3 = '';
				$data5 = '
				<div class="row text-center m-t-10">
				<div class="col-md-12 b-r" style="color:red;"> <button onclick="left_grp(' . $group_id . ')"><strong>Left Group </strong> <i class="fa fa-trash"></i></button></div>
			   
				</div>';
				$data6 = '';

			}

			$data1 = '
				 <div class="row text-center m-t-10">
				<div class="col-md-12"><strong>Group Members</strong></div>
				<div class="col-md-12"><ul class="chatonline drawer-body contact-list" id="group_mem" data-list-scroll-container="true" style="display: block;"></ul></div>
				</div>
				';
			if ($get_members != null) {

				foreach ($get_members as $row) {
					$email = $row->email_id;
					$query_fetch = $this->db->query("SELECT user_name FROM user_header_all WHERE email='$email'");
					if ($query_fetch->num_rows() > 0) {
						$record = $query_fetch->row();
						$user_name = $record->user_name;
						$status = $row->permission;

						//print_r($user_name);exit;
						if ($row->grp_status == 1) {
							if ($query_data > 0) {
								if ($status == 1) {
									$btn = '';
								} else {
									$btn = '<button onclick="remove_grp_user(' . $row->id . ')"><i class="fa fa-trash"></i></button>';
								}
							} else {
								$btn = '';
							}
							$data .= '
				 
									<li class="person tablinks" 
										href="javascript:void(0)" >
										<a href="javascript:void(0)">
											<span class="profile-picture min-profile-picture">
											<img src="https://rmt.docango.com/chat_assets/storage/user_image/avatar_default.png" alt="avatar" class="avatar-image is-loaded bg-theme" width="100%"></span>
											<span class="bname personName">' . $user_name . ' ' . $btn . '</span>
											<span id="person_status_' . $row->id . '">                                           
											
											 </span>
										</a>
									</li>
									';
						} else {
							$data .= '';
						}
					} else {
						$response['data4'] = $data4;
						$response['data3'] = $data3;
						$response['data1'] = $data1;
						$response['data'] = $data;
						$response['data5'] = $data5;
						$response['data6'] = $data6;
						$response['status'] = 201;
						$response['body'] = 'fail to fetch userss';
					}
				}
				//print_r($data);exit();
				$response['data4'] = $data4;
				$response['data3'] = $data3;
				$response['data1'] = $data1;
				$response['data'] = $data;
				$response['data5'] = $data5;
				$response['data6'] = $data6;
				$response['status'] = 200;
				$response['body'] = 'fail to fetch users';
			} else {
				$response['data4'] = $data4;
				$response['data3'] = $data3;
				$response['data1'] = $data1;
				$response['data'] = $data;
				$response['data5'] = $data5;
				$response['data6'] = $data6;
				$response['status'] = 201;
				$response['body'] = 'fail to fetch users';
			}
		} else {
			$response['data4'] = $data4;
			$response['data3'] = $data3;
			$response['data1'] = $data1;

			$response['data'] = $data;
			$response['data5'] = $data5;
			$response['data6'] = $data6;
			$response['status'] = 201;
			$response['body'] = 'fail to fetch users';
		}
		echo json_encode($response);
	}

	public function add_group_member()
	{
		$group_id = $this->input->post('id');
		//print_r($group_id);exit;
		$user_id = $this->session->user_session->user_id;
		$firm_id = $this->input->post('firm_id');
		//print_r($group_id);exit;
		$Get_User_data = $this->db->query(" select cm.*,(select group_name from chat_group_all c where c.id=cm.group_id) as group_name,
 (select create_by from chat_group_all c where c.id=cm.group_id) as creater_by 
 from chat_group_map_all cm where cm.group_id='$group_id' AND cm.grp_status=1 ")->result();
		//echo $this->db->last_query();

		$this->load->model("MessengerModel");
		$result = $this->MessengerModel->getFirmUsers($firm_id, $user_id);
		$get_members = $result->data;
		//print_r($Get_User_data);exit;
		$data = '';
		if ($Get_User_data != null) {

			$response['data'] = $Get_User_data;
			$response['status'] = 200;
			$response['body'] = 'Successfully sent';
		} else {
			$response['data'] = $data;
			$response['status'] = 201;
			$response['body'] = 'fail to send mail';
		}
		echo json_encode($response);
	}

	public function remove_group()
	{
		$group_id = $this->input->post('id');

		$statusDetails = array('status' => 0);
		$this->db->set($statusDetails);
		$this->db->where(array('id' => $group_id));
		$query = $this->db->update('chat_group_all');
		//print_r($query);exit;
		if ($query != null) {
			$response['status'] = 200;
			$response['body'] = 'Remove group';
		} else {
			$response['status'] = 201;
			$response['body'] = 'fail to remove group';
		}
		echo json_encode($response);
	}

	public function remove_group_user()
	{
		$id = $this->input->post('id');

		$statusDetails = array('grp_status' => 0);
		$this->db->set($statusDetails);
		$this->db->where(array('id' => $id));
		$query = $this->db->update('chat_group_map_all');
		//print_r($query);exit;
		if ($query != null) {
			$response['status'] = 200;
			$response['body'] = 'Group member remove Successfully';
		} else {
			$response['status'] = 201;
			$response['body'] = 'fail to remove group member';
		}
		echo json_encode($response);
	}

	public function left_group()
	{
		$group_id = $this->input->post('id');
		$email = $this->session->user_session->email;
		$statusDetails = array('grp_status' => 0);
		$this->db->set($statusDetails);
		$this->db->where(array('group_id' => $group_id,
			'email_id' => $email));
		$query = $this->db->update('chat_group_map_all');
		//print_r($query);exit;
		if ($query != null) {
			$response['status'] = 200;
			$response['body'] = 'left group';
		} else {
			$response['status'] = 201;
			$response['body'] = 'fail to left group';
		}
		echo json_encode($response);
	}

	public function update_group_name()
	{
		$group_id = $this->input->post('group_id');
		$group_name = $this->input->post('grp_name');
		//print_r($group_id);exit;
		$statusDetails = array('group_name' => $group_name);
		$this->db->set($statusDetails);
		$this->db->where(array('id' => $group_id));
		$query = $this->db->update('chat_group_all');
		//print_r($query);exit;
		if ($query != null) {
			$response['status'] = 200;
			$response['body'] = 'Group name updated successfully';
		} else {
			$response['status'] = 201;
			$response['body'] = 'fail to update group name';
		}
		echo json_encode($response);
	}

	public function get_UserInvolveInGroup()
	{
		$user_id = $this->session->user_session->email;

		$this->load->model("MessengerModel");
		$result = $this->MessengerModel->getUserInvolveInGroup($user_id);
		echo json_encode($result);
	}

	public function getDocument()
	{
		$email_id = $this->session->user_session->user_id;

		$Get_User_data = $this->db->query("SELECT * FROM document_management_table WHERE created_by='$email_id'")->result();
		//print_r($Get_User_data);exit();

		$data = "";
		$k = 0;
		if ($Get_User_data != FALSE) {
			foreach ($Get_User_data as $row) {
				$k = $k + 1;
				if ($row->status == 0) {
					$status = "Pending";
				} else if ($row->status == 1) {
					$status = "Accepted";
				} else {
					$status = "Rejected";
				}

				$data .= '<tr><td>' . $k . '</td><td>' . $row->file . '</td>
					<td>' . $row->year . '</td>
					
					<td>' . $row->created_on . '</td>
					<td>' . $status . '</td></tr>';
				$k++;

			}
			$response['code'] = 200;
			$response['data'] = $data;
		} else {
			$response['code'] = 201;
			$response['data'] = $data;
		}
		echo json_encode($response);
	}

	public function upload_image()
	{
		$email = $this->session->user_session->email;
		$uImage = $this->input->post();
		//print_r($uImage);exit();
		$UImage = $_FILES['UImage'];
		//print_r($UImage);exit();
		$upload_path = "uploads/profile_image";
		$inputname = 'UImage';
		$combination = 1;
		//print_r($inputname);exit();
		$this->load->model("Global_model");
		$result = $this->Global_model->upload_multiple_file_new($upload_path, $inputname, $combination);

		$u_path = $result['body'][0];
		//print_r($u_path);exit;
		if ($result != null) {
			$this->db->query("update chat_group_all set profile_image='$u_path' where create_by='$email' AND type=1 ");
			$this->db->query("update user_header_all set user_profile_pic='$u_path' where email='$email'");
			//$data=$this->db->query("select user_profile_pic from user_header_all where email='$email'")->result();

			//print_r($data);exit();
			$response["status"] = 200;
			$response["data"] = "uploaded successfully";
		} else {
			$response["status"] = 201;
			$response["data"] = "Not Found";
		}
		echo json_encode($response);
	}

	public function update_uName()
	{
		$email = $this->session->user_session->email;
		$uName = $this->input->post('UName');
		$user_id = $this->session->user_session->user_id;
		//print_r($user_id);exit();
		$result = $this->db->query("update user_header_all set user_name='$uName' where email='$email'");
		//print_r($result);exit();
		if ($result != null) {
			$query_fetch = $this->db->query("select * from user_header_all where user_id='$user_id'");
			//print_r($query_fetch);exit();
			if ($query_fetch->num_rows() > 0) {
				$record = $query_fetch->row();
				$user_name = $record->user_name;
				//print_r($user_name);exit();
				//$project_name = $record->project_name;
				$response["user_name"] = $user_name;
				$response["status"] = 200;
				$response["body"] = "Updated profile name successfully";
			} else {
				$response["status"] = 201;
				$response["body"] = "Failed To update";

			}
		} else {
			$response["status"] = 201;
			$response["body"] = "failed to update";
		}
		echo json_encode($response);
	}

	public function upload_groupImage()
	{
		//print_r('hiiii');exit;
		$grpID = $this->input->post('grpID');
		//print_r($grpID);exit();
		$UImage = $_FILES['grp_image'];
		//print_r($UImage);exit();
		$upload_path = "uploads/profile_image";
		$inputname = 'grp_image';
		$combination = 1;
		//print_r($upload_path);exit();
		$this->load->model("Global_model");
		$result1 = $this->Global_model->upload_multiple_file_new($upload_path, $inputname, $combination);

		$u_path = $result1['body'][0];
		//print_r($u_path);exit;
		if ($result1 != null) {
			$this->db->query("update chat_group_all set profile_image='$u_path' where id='$grpID'");
			//$data=$this->db->query("select profile_image from chat_group_all where id='$grpID'")->result();
			//print_r($data);exit();
			$response["status"] = 200;
			$response["data"] = "uploaded successfully";
		} else {
			$response["status"] = 201;
			$response["data"] = "Not Found";
		}
		echo json_encode($response);
	}

	public function download_file()
	{
		$filename = $this->input->post('input');
		//print_r($filename);exit;
		$response = "";
		$this->load->helper('download');
		$data = file_get_contents(base_url('chat_assets/storage/user_files/' . $filename));
		print_r($data);
		exit;
		if (force_download($filename, $data)) {
			$response = 1;
		} else {
			$response = 0;
		}
		echo json_encode($response);
	}

	public function add_news_data()
	{
		$title = $this->input->post('title');
		$link = $this->input->post('link');
		$keyword = $this->input->post('keyword');
		$counter = $this->input->post('counter');
		$category = $this->input->post('category');
		$news_site = $this->input->post('news_site');
		$description = $this->input->post('description');

		//print_r($category);exit;
		$data = array(
			'url' => $link,
			'keyword' => $keyword,
			'html' => $title,
			'count' => $counter,
			'category' => $category,
			'news_site' => $news_site,
			'description' => $description,
			'date' => date("Y/m/d H:i:s")
		);

		// $query_fetch=$this->db->query("INSERT INTO news_article_table (url,keyword,html,count) VALUES('$link','$keyword','$title','$counter')");
		//return $query_fetch->insert_id;
		//$query1=$this->db->query("select * from news_article_table where url='$link' AND html='$title' AND news_site='$news_site' AND category='$category' AND date(date)=CURDATE()")->num_rows();

		$data_select = array(
			'url' => $link,
			'html' => $title,
			'news_site' => $news_site,
			'category' => $category,
			'date(date)' => date("Y/m/d")
		);
		$this->db->select('*');
		$this->db->from('news_article_table');
		$this->db->where($data_select);
		$query1 = $this->db->get();

		if ($query1->num_rows() > 0) {
			$response["status"] = 201;
			$response["data"] = "already added";
		} else {
			$data = $this->db->insert('news_article_table', $data);

			//return $this->db->insert_id();
			//print_r($this->db->insert_id());exit;

			if ($this->db->insert_id() != 0 || $this->db->insert_id() == null) {
				$insert_id = $this->db->insert_id();
				$response["status"] = 200;
				$response["insert_id"] = $insert_id;
				$response["data"] = "added successfully";
			} else {
				$response["status"] = 201;
				$response["data"] = "try again";
			}
		}
		echo json_encode($response);

	}

	public function remove_news_data()
	{
		$remove_id = $this->input->post('remove_id');
		//print_r($remove_id);exit;
		$query_fetch = $this->db->query("DELETE FROM news_article_table WHERE id='$remove_id';");


		if ($query_fetch) {
			$response["status"] = 200;
			$response["data"] = "Remove successfully";
		} else {
			$response["status"] = 201;
			$response["data"] = "try again";
		}
		echo json_encode($response);

	}

	public function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return substr($haystack, 0, $length) === $needle;
	}

	public function highlightWords($text, $word)
	{
		$word = explode(",", $word);
		for ($i = 0; $i < count($word); $i++) {
			$text = preg_replace('#' . preg_quote($word[$i]) . '#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
		}
		return $text;
	}

	public function scraping_generic_copy()
	{

		$this->load->library('Simple_html_dom');

		$url = $this->input->post('url');
		$search = $this->input->post('search');
		// print_r($search);exit;
		$query_fetch = $this->db->query("SELECT nt.*,(select category from news_category nc where nc.id=nt.categories) as category,(select id from news_category nc where nc.id=nt.categories) as category_id from news_article_websites_table nt");
		$count = $query_fetch->num_rows();
		$url_data = $query_fetch->result_array();
		$search_array = [];
		//print_r($url_data);exit;
		foreach ($url_data as $key => $value) {
			$url = $value['links'];
			$category = $value['category'];
			$category_id = $value['category_id'];
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, $url);
			$html = curl_exec($curl);
			$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
			$html = $dom->load($html, true, true);
			//$html = file_get_html($url);
			//var_dump ($html);

			$url1 = explode("/", $url);

			if (empty($url1)) {
				$url_link = "";
			} else {
				if (isset($url))
					$url_link = "https";
				else
					$url_link = "http";

				$url_link .= "://";

				$url_link .= $url1[1];

				$url_link .= $url1[2];


			}
			$videos = [];

			$search_key = explode(",", $search);
			//print_r($search_key);exit;

			$finalarr = array_unique($html->find('a'));
			$i = 1;
			foreach ($finalarr as $video) {

				$counter = 0;
				for ($i = 0; $i < count($search_key); $i++) {
					$inner_html = $video->innertext;
					if (!empty($search_key[$i])) {
						if ($video->innerhtml == "") {
							$video1 = $video->plaintext;
						} else {
							$video1 = "";
						}
						preg_match('~\\b' . $search_key[$i] . '\\b~i', $video1, $m);
						$c = count($m);
						//if(strlen(stristr($video1,$search_key[$i]))>1)
						if ($c >= 1) {
							if ($video->find('img', 0) != NULL) {
								$img = $video->find('img', 0);
								if ($img->getAttribute('data-src') != "") {
									$j = $img->getAttribute('data-src');
									$k = $img->getAttribute('src');
									$img->src = $j;
									$inner_html = str_replace($k, $j, $inner_html);
								} else {
									$k = $img->getAttribute('src');
									$j = $img->getAttribute('src');
									if ($this->startsWith($j, $url_link)) {
										$img->src = $j;
										$inner_html = str_replace($k, $j, $inner_html);
									} else {
										$img->src = $url_link . $j;
										$inner_html = str_replace($k, $url_link . $j, $inner_html);
									}
								}

								//$inner_html=str_replace($k,$j,$inner_html);
							}


							$title = $video->plaintext; //inner_html
							$link = $video->href;


							//print_r($link_data);exit;
							//$description=$link_data->content;

							if ($this->startsWith($link, $url_link)) {
								$link = $link;
							} else {
								$link = $url_link . $link;
							}

							$curl = curl_init();
							curl_setopt($curl, CURLOPT_HEADER, 0);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl, CURLOPT_URL, $link);
							$html1 = curl_exec($curl);
							$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
							$html1 = $dom->load($html1, true, true);
							//print_r($html1);exit;
							$link_data = $html1->find('meta');
							$description = "";
							foreach ($link_data as $key => $link_desc) {
								$description = "";
								if ($link_desc->property == "") {
									$property = $link_desc->name;

								} else {
									$property = $link_desc->property;
								}

								if ($property == "description") {
									$description = $link_desc->content;
								} else {
									$description = "";
								}
								if ($description != "") {
									break;
								}
							}

							$counter++;
						} else {
						}
					} else {
					}
				}
				if ($counter > 0) {
					$videoss = ['title' => $title,
						'link' => $link,
						'news_site' => $url,
						'category' => $category,
						'category_id' => $category_id,
						'description' => $description
					];
					$search_array[] = [$videoss, $counter];

				}


			}
//echo $i;
// echo '<pre>';
		}
		//var_dump($search_array);exit;
		$data_arr = $this->get_sorted_data($search_array);
// var_dump($data_arr);
		if (!empty($data_arr)) {

			$html = '<table class="table" >';
			$html .= '<tr>
					
					<td>Title</td>
					<td>Website Link</td>
					<td>category</td>
					<td>Descrption</td>
					<td>Action</td>
					</tr>';
			$key = 0;
			foreach ($data_arr as $data) {
				//var_dump($data);
				//for($i=0;$i<count($data[0]);$i++){

				$title = !empty($search) ? $this->highlightWords($data[0]['title'], $search) : $data[0]['title'];

				$key = $key + 1;
				$html .= '<tr >';

				$html .= '<td style="width:30%" class="first_a">' . $title . ' <a target="_blank" href="' . $data[0]['link'] . '">read more...</a></td>';

				$html .= '<td> <a target="_blank" href="' . $data[0]['news_site'] . '">' . $data[0]['news_site'] . '</a></td>';
				$html .= '<td> ' . $data[0]['category'] . '</td>';
				$html .= '<td> ' . $data[0]['description'] . '</td>';
				$html .= '<td><input type="hidden" name="titile" id="title_' . $key . '" value="' . htmlspecialchars($data[0]['title']) . '"/>
						<input type="hidden" name="link" id="link_' . $key . '" value="' . $data[0]['link'] . '"/>
						<input type="hidden" name="category" id="category_' . $key . '" value="' . $data[0]['category_id'] . '"/>
						<input type="hidden" name="keyword" id="keyword_' . $key . '" value="' . $_POST['search'] . '"/>
						<input type="hidden" name="news_site" id="news_site' . $key . '" value="' . $data[0]['news_site'] . '"/>
						<input type="hidden" name="count_v" id="count_' . $key . '" value="' . $data[1] . '"/>
						<input type="hidden" name="description" id="description_' . $key . '" value="' . $data[0]['description'] . '"/>
						<button class="btn btn-info" id="news_' . $key . '" onclick="add_news(' . $key . ')" >Add<i class="fa fa-arrow-right"></i></button>
						<input type="hidden" name="newsRemovetext" id="newsRemovetext_' . $key . '" />
						<button class="btn btn-info" id="newsRemove_' . $key . '" onclick="remove_news(' . $key . ')" style="display:none;">Remove<i class="fa fa-arrow-left"></i></button>
					</td>';

				$html .= '</tr>';
				//}
			}
			$html .= '</table>';
//echo $html;

			//print_r($this->db->insert_id());exit;
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$response["status"] = 200;

			$response["data"] = $html;

			//echo json_encode($response);
		} else {
			$response["status"] = 201;
			$response["data"] = "";
			//echo json_encode($response);
		}
		if (json_encode($response)) {
			echo json_encode($response);
		} else {
			echo json_last_error_msg();
		}
//echo json_encode($response);
		//return $data_arr;


	}

	public function scraping_generic_copy1()
	{

		$this->load->library('Simple_html_dom');

		$url = $this->input->post('url');
		//$search = $this->input->post('search');
		// print_r($search);exit;
		$query_fetch = $this->db->query("SELECT nt.*,
		  (select category from news_category nc where nc.id=nt.categories) as category,
		  (select id from news_category nc where nc.id=nt.categories) as category_id,
		  (select keywords from news_category nc where nc.id=nt.categories) as keywords
		  from news_article_websites_table nt");
		$count = $query_fetch->num_rows();
		$url_data = $query_fetch->result_array();
		$search_array = [];
		$search1 = "";
		//print_r($url_data);exit;

		foreach ($url_data as $key => $value) {
			$url = $value['links'];
			$category = $value['category'];
			$category_id = $value['category_id'];
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, $url);
			$html = curl_exec($curl);
			$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
			$html = $dom->load($html, true, true);
			//$html = file_get_html($url);

			$url1 = explode("/", $url);

			if (empty($url1)) {
				$url_link = "";
			} else {
				if (isset($url))
					$url_link = "https";
				else
					$url_link = "http";

				$url_link .= "://";

				$url_link .= $url1[1];

				$url_link .= $url1[2];


			}
			$videos = [];
			$search = $value['keywords'];
			$search1 .= $value['keywords'];
			$search_key1 = explode("|", $search);
			//print_r($search_key);exit;

			$finalarr = array_unique($html->find('a'));
			$j = 1;
			foreach ($finalarr as $video) {

				$counter = 0;
				for ($j = 0; $j < count($search_key1); $j++) {
					$search_key = explode(",", $search_key1[$j]);

					$i = 1;
					for ($i = 0; $i < count($search_key); $i++) {
						$inner_html = $video->innertext;
						if (!empty($search_key[$i])) {
							if ($video->innerhtml == "") {
								$video1 = $video->plaintext;
							} else {
								$video1 = "";
							}
							preg_match('~\\b' . $search_key[$i] . '\\b~i', $video1, $m);
							$c = count($m);
							//if(strlen(stristr($video1,$search_key[$i]))>1)
							if ($c >= 1) {
								$title = $video->plaintext; //inner_html
								$link = $video->href;

								//print_r($link_data);exit;
								//$description=$link_data->content;

								if ($this->startsWith($link, $url_link)) {
									$link = $link;
								} else {
									//$link=$url_link.$link;
									if ($this->startsWith($link, '/')) {
										$link = $url_link . $link;
									} else {
										$link = $url_link . '/' . $link;
									}
								}

								$curl = curl_init();
								curl_setopt($curl, CURLOPT_HEADER, 0);
								curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($curl, CURLOPT_URL, $link);
								$html1 = curl_exec($curl);
								$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
								$html1 = $dom->load($html1, true, true);
								//print_r($html1);exit;
								$link_data = $html1->find('meta');
								$description = "";
								foreach ($link_data as $key => $link_desc) {
									$description = "";
									if ($link_desc->property == "") {
										$property = $link_desc->name;

									} else {
										$property = $link_desc->property;
									}

									if ($property == "description") {
										$description = $link_desc->content;
									} else {
										$description = "";
									}
									if ($description != "") {
										break;
									}
								}

								$counter++;
							} else {
								break;
							}
						} else {
						}
					}
				}
				if ($counter > 0) {
					$videoss = ['title' => $title,
						'link' => $link,
						'news_site' => $url,
						'category' => $category,
						'keyword' => $search,
						'category_id' => $category_id,
						'description' => $description
					];
					$search_array[] = [$videoss, $counter];

				}

			}
		}
		//var_dump($search_array);exit;

		$data_arr = $this->get_sorted_data($search_array);
		$InserData = $this->insert_data_news($data_arr);
		// var_dump($data_arr);
		if (!empty($data_arr)) {

			$html = '<table class="table" >';
			$html .= '<tr>
					
					<td>Title</td>
					<td>Website Link</td>
					<td>category</td>
					<td>Descrption</td>
					<td>Keywords</td>
					<td>Action</td>
					</tr>';
			$key = 0;
			foreach ($data_arr as $data) {
				//var_dump($data);
				//for($i=0;$i<count($data[0]);$i++){

				$title = !empty($search) ? $this->highlightWords($data[0]['title'], $search1) : $data[0]['title'];

				$key = $key + 1;
				$html .= '<tr >';

				$html .= '<td style="width:30%" class="first_a">' . $title . ' <a target="_blank" href="' . $data[0]['link'] . '">read more...</a></td>';

				$html .= '<td> <a target="_blank" href="' . $data[0]['news_site'] . '">' . $data[0]['news_site'] . '</a></td>';
				$html .= '<td> ' . $data[0]['category'] . '</td>';
				$html .= '<td> ' . $data[0]['description'] . '</td>';
				$html .= '<td> ' . $data[0]['keyword'] . '</td>';
				$html .= '<td><input type="hidden" name="titile" id="title_' . $key . '" value="' . htmlspecialchars($data[0]['title']) . '"/>
						<input type="hidden" name="link" id="link_' . $key . '" value="' . $data[0]['link'] . '"/>
						<input type="hidden" name="category" id="category_' . $key . '" value="' . $data[0]['category_id'] . '"/>
						<input type="hidden" name="keyword" id="keyword_' . $key . '" value="' . $search1 . '"/>
						<input type="hidden" name="news_site" id="news_site' . $key . '" value="' . $data[0]['news_site'] . '"/>
						<input type="hidden" name="count_v" id="count_' . $key . '" value="' . $data[1] . '"/>
						<input type="hidden" name="description" id="description_' . $key . '" value="' . $data[0]['description'] . '"/>
						<button class="btn btn-info" id="news_' . $key . '" onclick="add_news(' . $key . ')" >Add<i class="fa fa-arrow-right"></i></button>
						<input type="hidden" name="newsRemovetext" id="newsRemovetext_' . $key . '" />
						<button class="btn btn-info" id="newsRemove_' . $key . '" onclick="remove_news(' . $key . ')" style="display:none;">Remove<i class="fa fa-arrow-left"></i></button>
					</td>';

				$html .= '</tr>';
				//}
			}
			$html .= '</table>';
			//echo $html;

			//print_r($this->db->insert_id());exit;
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$response["status"] = 200;

			$response["data"] = $html;

			//echo json_encode($response);
		} else {
			$response["status"] = 201;
			$response["data"] = "";
			//echo json_encode($response);
		}
		if (json_encode($response)) {
			echo json_encode($response);
		} else {
			echo json_last_error_msg();
		}
		//echo json_encode($response);
		//return $data_arr;

	}

	public function scraping_generic_copy2()
	{

		$this->load->library('Simple_html_dom');

		$url = $this->input->post('url');
		//$search = $this->input->post('search');
		// print_r($search);exit;
		$query_fetch = $this->db->query("SELECT nt.*,
		  (select category from news_category nc where nc.id=nt.categories) as category,
		  (select id from news_category nc where nc.id=nt.categories) as category_id,
		  (select keywords from news_category nc where nc.id=nt.categories) as keywords
		  from news_article_websites_table nt");

		$count = $query_fetch->num_rows();
		$url_data = $query_fetch->result_array();
		$search_array = [];
		$search1 = "";
		//print_r($url_data);exit;
		foreach ($url_data as $key => $value) {
			$url = $value['links'];
			$category = $value['category'];
			$category_id = $value['category_id'];
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, $url);
			$html = curl_exec($curl);
			$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
			$html = $dom->load($html, true, true);
			//$html = file_get_html($url);
			//var_dump ($html);

			$url1 = explode("/", $url);

			if (empty($url1)) {
				$url_link = "";
			} else {
				if (isset($url))
					$url_link = "https";
				else
					$url_link = "http";

				$url_link .= "://";

				$url_link .= $url1[1];

				$url_link .= $url1[2];


			}
			$videos = [];
			$search = $value['keywords'];
			$search1 .= $value['keywords'];
			$search_key1 = explode("|", $search);

			//print_r($search_key1);exit;

			$finalarr = array_unique($html->find('a'));
			$j = 1;
			foreach ($finalarr as $video) {

				$counter = 0;
				for ($j = 0; $j < count($search_key1); $j++) {

					$search_key = explode(",", $search_key1[$j]);

					$i = 1;
					for ($i = 0; $i < count($search_key); $i++) {
						$inner_html = $video->innertext;
						if (!empty($search_key[$i])) {
							if ($video->innerhtml == "") {
								$video1 = $video->plaintext;
							} else {
								$video1 = "";
							}
							preg_match('~\\b' . $search_key[$i] . '\\b~i', $video1, $m);
							$c = count($m);
							//if(strlen(stristr($video1,$search_key[$i]))>1)
							if ($c >= 1) {
								$title = $video->plaintext; //inner_html
								$link = $video->href;
								//$description=$link_data->content;

								if ($this->startsWith($link, $url_link)) {
									$link = $link;
								} else {
									if ($this->startsWith($link, '/')) {
										$link = $url_link . $link;
									} else {
										$link = $url_link . '/' . $link;
									}

								}

								$curl = curl_init();
								curl_setopt($curl, CURLOPT_HEADER, 0);
								curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
								curl_setopt($curl, CURLOPT_URL, $link);
								$html1 = curl_exec($curl);
								$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
								$html1 = $dom->load($html1, true, true);

								$link_data = $html1->find('meta');
								$description = "";
								foreach ($link_data as $key => $link_desc) {
									$description = "";
									if ($link_desc->property == "") {
										$property = $link_desc->name;

									} else {
										$property = $link_desc->property;
									}

									if ($property == "description") {
										$description = $link_desc->content;
									} else {
										$description = "";
									}
									if ($description != "") {
										break;
									}
								}

								$counter++;
							} else {
								break;
							}
						} else {
						}
					}
				}
				if ($counter > 0) {
					$videoss = ['title' => $title,
						'link' => $link,
						'news_site' => $url,
						'category' => $category,
						'keyword' => $search,
						'category_id' => $category_id,
						'description' => $description
					];
					$search_array[] = [$videoss, $counter];

				}

			}
			//echo $i;
			// echo '<pre>';
		}
		//var_dump($search_array);exit;

		$data_arr = $this->get_sorted_data($search_array);
		$InserData = $this->insert_data_news1($data_arr);
		// var_dump($data_arr);
		if (!empty($data_arr)) {

			$html = '<table class="table" >';
			$html .= '<tr>
						
						<td>Title</td>
						<td>Website Link</td>
						<td>category</td>
						<td>Descrption</td>
						<td>Keywords</td>
						<td>Action</td>
						</tr>';
			$key = 0;
			foreach ($data_arr as $data) {
				//var_dump($data);
				//for($i=0;$i<count($data[0]);$i++){

				$title = !empty($search) ? $this->highlightWords($data[0]['title'], $search1) : $data[0]['title'];

				$key = $key + 1;
				$html .= '<tr >';

				$html .= '<td style="width:30%" class="first_a">' . $title . ' <a target="_blank" href="' . $data[0]['link'] . '">read more...</a></td>';

				$html .= '<td> <a target="_blank" href="' . $data[0]['news_site'] . '">' . $data[0]['news_site'] . '</a></td>';
				$html .= '<td> ' . $data[0]['category'] . '</td>';
				$html .= '<td> ' . $data[0]['description'] . '</td>';
				$html .= '<td> ' . $data[0]['keyword'] . '</td>';
				$html .= '<td><input type="hidden" name="titile" id="title_' . $key . '" value="' . htmlspecialchars($data[0]['title']) . '"/>
						<input type="hidden" name="link" id="link_' . $key . '" value="' . $data[0]['link'] . '"/>
						<input type="hidden" name="category" id="category_' . $key . '" value="' . $data[0]['category_id'] . '"/>
						<input type="hidden" name="keyword" id="keyword_' . $key . '" value="' . $search1 . '"/>
						<input type="hidden" name="news_site" id="news_site' . $key . '" value="' . $data[0]['news_site'] . '"/>
						<input type="hidden" name="count_v" id="count_' . $key . '" value="' . $data[1] . '"/>
						<input type="hidden" name="description" id="description_' . $key . '" value="' . $data[0]['description'] . '"/>
						<button class="btn btn-info" id="news_' . $key . '" onclick="add_news(' . $key . ')" >Add<i class="fa fa-arrow-right"></i></button>
						<input type="hidden" name="newsRemovetext" id="newsRemovetext_' . $key . '" />
						<button class="btn btn-info" id="newsRemove_' . $key . '" onclick="remove_news(' . $key . ')" style="display:none;">Remove<i class="fa fa-arrow-left"></i></button>
					</td>';

				$html .= '</tr>';
				//}
			}
			$html .= '</table>';
			//echo $html;

			//print_r($this->db->insert_id());exit;
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$response["status"] = 200;

			$response["data"] = $html;

			//echo json_encode($response);
		} else {
			$response["status"] = 201;
			$response["data"] = "";
			//echo json_encode($response);
		}
		if (json_encode($response)) {
			echo json_encode($response);
		} else {
			echo json_last_error_msg();
		}
		//echo json_encode($response);
		//return $data_arr;


	}

	public function get_sorted_data($b1)
	{
//$b1=array(array("pp",2),array("q",8),array("p1",20),array("r",5),array("p1",15));
		$arr = array();
		foreach ($b1 as $key => $row) {

			$arr[$key] = $row[1];
		}
		$b = 0;
		$k = 0;
		$new_array = arsort($arr);
		$arr11 = array();
		foreach ($arr as $k1 => $r1) {

			$arr11[] = $b1[$k1];
		}
		return $arr11;

	}

	public function insert_data_news($data)
	{


		foreach ($data as $key => $row) {
			$link = $row[0]['link'];
			$category = $row[0]['category_id'];
			$keyword = $row[0]['keyword'];
			$title = $row[0]['title'];
			$news_site = $row[0]['news_site'];
			$description = $row[0]['description'];
			$counter = $row[1];
			//get_count
			$cnt = 2;
			$qr = $this->db->query("select news_count from news_article_websites_table where links='$news_site'");
			if ($this->db->affected_rows() > 0) {
				$result = $qr->row();
				$cnt = $result->news_count;
			}
			$query = $this->db->query("select * from news_article_table where news_site='$news_site' AND category='$category' AND date(date)=date(now())");
			if ($this->db->affected_rows() > $cnt) {

			} else {
				$data1 = array(
					'url' => $link,
					'keyword' => $keyword,
					'html' => $title,
					'count' => $counter,
					'category' => $category,
					'news_site' => $news_site,
					'description' => $description,
					'date' => date("Y/m/d H:i:s")
				);
				$data_select = array(
					'url' => $link,
					'html' => $title,
					'news_site' => $news_site,
					'category' => $category,
					'date(date)' => date("Y/m/d")
				);
				$this->db->select('*');
				$this->db->from('news_article_table');
				$this->db->where($data_select);
				$query1 = $this->db->get();

				if ($query1->num_rows() > 0) {
				} else {
					$data1 = $this->db->insert('news_article_table', $data1);
				}
			}

		}
		return;
	}

	public function insert_data_news1($data)
	{


		foreach ($data as $key => $row) {
			$link = $row[0]['link'];
			$category = $row[0]['category_id'];
			$keyword = $row[0]['keyword'];
			$title = $row[0]['title'];
			$news_site = $row[0]['news_site'];
			$description = $row[0]['description'];
			$counter = $row[1];
			//get_count
			$cnt = 5;
			$qr = $this->db->query("select news_count from news_article_websites_table where links='$news_site'");
			if ($this->db->affected_rows() > 0) {
				$result = $qr->row();
				$cnt = $result->news_count;
			}
			$query = $this->db->query("select * from news_article_table where news_site='$news_site' AND category='$category' AND date(date)=date(now())");
			if ($this->db->affected_rows() > $cnt) {

			} else {
				$data1 = array(
					'url' => $link,
					'keyword' => $keyword,
					'html' => $title,
					'count' => $counter,
					'category' => $category,
					'news_site' => $news_site,
					'description' => $description,
					'date' => date("Y/m/d H:i:s")
				);
				$data_select = array(
					'url' => $link,
					'html' => $title,
					'news_site' => $news_site,
					'category' => $category,
					'date(date)' => date("Y/m/d")
				);
				$this->db->select('*');
				$this->db->from('news_article_table');
				$this->db->where($data_select);
				$query1 = $this->db->get();

				if ($query1->num_rows() > 0) {
				} else {
					$data1 = $this->db->insert('news_article_table', $data1);
				}
			}

		}
		return;
	}

	public function scraping_generic_copy3()
	{

		$this->load->library('Simple_html_dom');

		$url = $this->input->post('url');
		//$search = $this->input->post('search');
		// print_r($search);exit;
		$query_fetch = $this->db->query("SELECT nt.*,
		  (select category from news_category nc where nc.id=nt.categories) as category,
		  (select id from news_category nc where nc.id=nt.categories) as category_id,
		  (select keywords from news_category nc where nc.id=nt.categories) as keywords
		  from news_article_websites_table nt");
		$count = $query_fetch->num_rows();
		$url_data = $query_fetch->result_array();
		$search_array = [];
		$search1 = "";
		//print_r($url_data);exit;
		foreach ($url_data as $key => $value) {
			$url = $value['links'];
			$category = $value['category'];
			$category_id = $value['category_id'];
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_URL, $url);
			$html = curl_exec($curl);
			$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
			$html = $dom->load($html, true, true);
			//$html = file_get_html($url);
			//var_dump ($html);

			$url1 = explode("/", $url);

			if (empty($url1)) {
				$url_link = "";
			} else {
				if (isset($url))
					$url_link = "https";
				else
					$url_link = "http";

				$url_link .= "://";

				$url_link .= $url1[1];

				$url_link .= $url1[2];


			}
			$videos = [];
			$search = $value['keywords'];
			$search1 .= $value['keywords'];
			$search_key = explode(",", $search);
			//print_r($search_key);exit;

			$finalarr = array_unique($html->find('a'));
			$i = 1;
			foreach ($finalarr as $video) {

				$counter = 0;
				for ($i = 0; $i < count($search_key); $i++) {
					$inner_html = $video->innertext;
					if (!empty($search_key[$i])) {
						if ($video->innerhtml == "") {
							$video1 = $video->plaintext;
						} else {
							$video1 = "";
						}
						preg_match('~\\b' . $search_key[$i] . '\\b~i', $video1, $m);
						$c = count($m);
						//if(strlen(stristr($video1,$search_key[$i]))>1)
						if ($c >= 1) {
							if ($video->find('img', 0) != NULL) {
								$img = $video->find('img', 0);
								if ($img->getAttribute('data-src') != "") {
									$j = $img->getAttribute('data-src');
									$k = $img->getAttribute('src');
									$img->src = $j;
									$inner_html = str_replace($k, $j, $inner_html);
								} else {
									$k = $img->getAttribute('src');
									$j = $img->getAttribute('src');
									if ($this->startsWith($j, $url_link)) {
										$img->src = $j;
										$inner_html = str_replace($k, $j, $inner_html);
									} else {
										$img->src = $url_link . $j;
										$inner_html = str_replace($k, $url_link . $j, $inner_html);
									}
								}

								//$inner_html=str_replace($k,$j,$inner_html);
							}


							$title = $video->plaintext; //inner_html
							$link = $video->href;


							//print_r($link_data);exit;
							//$description=$link_data->content;

							if ($this->startsWith($link, $url_link)) {
								$link = $link;
							} else {
								//$link=$url_link.$link;
								if ($this->startsWith($link, '/')) {
									$link = $url_link . $link;
								} else {
									$link = $url_link . '/' . $link;
								}
							}

							$curl = curl_init();
							curl_setopt($curl, CURLOPT_HEADER, 0);
							curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($curl, CURLOPT_URL, $link);
							$html1 = curl_exec($curl);
							$dom = new simple_html_dom(null, true, true, DEFAULT_TARGET_CHARSET, true, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
							$html1 = $dom->load($html1, true, true);
							//print_r($html1);exit;
							$link_data = $html1->find('meta');
							$description = "";
							foreach ($link_data as $key => $link_desc) {
								$description = "";
								if ($link_desc->property == "") {
									$property = $link_desc->name;

								} else {
									$property = $link_desc->property;
								}

								if ($property == "description") {
									$description = $link_desc->content;
								} else {
									$description = "";
								}
								if ($description != "") {
									break;
								}
							}

							$counter++;
						} else {
						}
					} else {
					}
				}
				if ($counter > 0) {
					$videoss = ['title' => $title,
						'link' => $link,
						'news_site' => $url,
						'category' => $category,
						'keyword' => $search,
						'category_id' => $category_id,
						'description' => $description
					];
					$search_array[] = [$videoss, $counter];

				}


			}
//echo $i;
// echo '<pre>';
		}
		//var_dump($search_array);exit;

		$data_arr = $this->get_sorted_data($search_array);
		$InserData = $this->insert_data_news($data_arr);
// var_dump($data_arr);
		if (!empty($data_arr)) {

			$html = '<table class="table" >';
			$html .= '<tr>
					
					<td>Title</td>
					<td>Website Link</td>
					<td>category</td>
					<td>Descrption</td>
					<td>Keywords</td>
					<td>Action</td>
					</tr>';
			$key = 0;
			foreach ($data_arr as $data) {
				//var_dump($data);
				//for($i=0;$i<count($data[0]);$i++){

				$title = !empty($search) ? $this->highlightWords($data[0]['title'], $search1) : $data[0]['title'];

				$key = $key + 1;
				$html .= '<tr >';

				$html .= '<td style="width:30%" class="first_a">' . $title . ' <a target="_blank" href="' . $data[0]['link'] . '">read more...</a></td>';

				$html .= '<td> <a target="_blank" href="' . $data[0]['news_site'] . '">' . $data[0]['news_site'] . '</a></td>';
				$html .= '<td> ' . $data[0]['category'] . '</td>';
				$html .= '<td> ' . $data[0]['description'] . '</td>';
				$html .= '<td> ' . $data[0]['keyword'] . '</td>';
				$html .= '<td><input type="hidden" name="titile" id="title_' . $key . '" value="' . htmlspecialchars($data[0]['title']) . '"/>
						<input type="hidden" name="link" id="link_' . $key . '" value="' . $data[0]['link'] . '"/>
						<input type="hidden" name="category" id="category_' . $key . '" value="' . $data[0]['category_id'] . '"/>
						<input type="hidden" name="keyword" id="keyword_' . $key . '" value="' . $search1 . '"/>
						<input type="hidden" name="news_site" id="news_site' . $key . '" value="' . $data[0]['news_site'] . '"/>
						<input type="hidden" name="count_v" id="count_' . $key . '" value="' . $data[1] . '"/>
						<input type="hidden" name="description" id="description_' . $key . '" value="' . $data[0]['description'] . '"/>
						<button class="btn btn-info" id="news_' . $key . '" onclick="add_news(' . $key . ')" >Add<i class="fa fa-arrow-right"></i></button>
						<input type="hidden" name="newsRemovetext" id="newsRemovetext_' . $key . '" />
						<button class="btn btn-info" id="newsRemove_' . $key . '" onclick="remove_news(' . $key . ')" style="display:none;">Remove<i class="fa fa-arrow-left"></i></button>
					</td>';

				$html .= '</tr>';
				//}
			}
			$html .= '</table>';
//echo $html;

			//print_r($this->db->insert_id());exit;
			$html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
			$response["status"] = 200;

			$response["data"] = $html;

			//echo json_encode($response);
		} else {
			$response["status"] = 201;
			$response["data"] = "";
			//echo json_encode($response);
		}
		if (json_encode($response)) {
			echo json_encode($response);
		} else {
			echo json_last_error_msg();
		}
//echo json_encode($response);
		//return $data_arr;


	}

	public function get_today_news()
	{
		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;
		$firm_id = $session_data->firm_id;
		// $this->db->select();
		// $this->db->from('news_article_table');
		// $this->db->limit ('10');
		// $this->db->where ("(date >= now())");
		// $query = $this->db->get();
		$query_fetchcat = $this->db->query('select * from news_category order by priority ASC');
		$data = "";
		$key_c1 = 1;
		if ($this->db->affected_rows() > 0) {
			$resultcat = $query_fetchcat->result();
			$data .= '	<div id="main">
  <div class="container">
<div class="accordion" id="faq">';
			foreach ($resultcat as $r1) {
				$data .= '<div class="card">';
				$data .= ' <div class="card-header" id="' . $r1->category . '">';
				$data .= '  <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#' . $r1->category . '_' . $key_c1 . '"
                            aria-expanded="true" aria-controls="' . $r1->category . '_' . $key_c1 . '">';
				$data .= '' . $r1->category . '</a></div>';
				if ($key_c1 == 1) {
					$data .= ' <div id="' . $r1->category . '_' . $key_c1 . '" class="collapse show" aria-labelledby="' . $r1->category . '" data-parent="#faq">';
				} else {
					$data .= ' <div id="' . $r1->category . '_' . $key_c1 . '" class="collapse" aria-labelledby="' . $r1->category . '" data-parent="#faq">';
				}
				$data .= '<div class="card-body">';
				//$data .='<div class="cat_div" style="float:left"><h3  style="color:black;font-weight:bold">'.$r1->category.'</h3></div>';
				$query_fetch = $this->db->query("select *,(select priorities from news_article_websites_table naw where nat.news_site=naw.links) as rank  from news_article_table nat where nat.category='$r1->id' order by  id DESC,rank ASC  LIMIT 25");
				//echo $this->db->last_query();
				if ($this->db->affected_rows() > 0) {
					$key_c = 1;
					$result_count = $query_fetch->num_rows();
					$result = $query_fetch->result();
					$data1 = "";
					foreach ($result as $key => $row) {
						if ($key > 4) {
							$out = strlen($row->description) > 80 ? substr($row->description, 0, 80) . "..." : $row->description;
							$data1 .= '
				<div class="html_div"> <a class="anchor_tag" href="' . $row->url . '" target="_blank"> ' . $row->html . ' </a><br>
				<div class="row" data-date="" style="font-size:12px;color:grey;padding:8px">' . $out . '</div>
				<div class="row">
				<span style="font-size:12px;color:grey;padding:8px"><a class="anchor_tag1"  href="' . $row->news_site . '" target="_blank">' . $row->news_site . '</a> <i class="fas fa-external-link-alt" style="font-size:10px;" ></i></span>.
				
				<div class="time_div" data-date="' . $row->date . '" style="font-size:12px;color:grey;padding:8px"></div>
				
				</div>
				</div>
				';
						} else {
							$out = strlen($row->description) > 80 ? substr($row->description, 0, 80) . "..." : $row->description;
							$data .= '
				
				
				<div class="html_div"> <a class="anchor_tag" href="' . $row->url . '" target="_blank"> ' . $row->html . ' </a><br>
				<div class="row" data-date="" style="font-size:12px;color:grey;padding:8px">' . $out . '</div>
				<div class="row">
				<span style="font-size:12px;color:grey;padding:8px"><a class="anchor_tag1"  href="' . $row->news_site . '" target="_blank">' . $row->news_site . '</a> <i class="fas fa-external-link-alt" style="font-size:10px;" ></i></span>.
				
				<div class="time_div" data-date="' . $row->date . '" style="font-size:12px;color:grey;padding:8px"></div>
				
				</div>
				</div>
				
				';
						}
						$key_c++;
					}


				} else {
					//$query_fetch=$this->db->query("select *,(select priorities from news_article_websites_table naw where nat.news_site=naw.links) as rank  from news_article_table nat where date(date) = SUBDATE(CURDATE(), 1) AND nat.category='$r1->id' order by  rank ASC limit 10");
					$data .= "<span style='color:black'>No Update Yet...</span>";
				}
				$data .= '<div id="' . $r1->category . '" class="collapse">' . $data1 . '</div>';
				$data .= '<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#' . $r1->category . '">Read More</button>';
				$data .= '</div>';
				$data .= '</div>';
				$data .= '</div>';

				$key_c1++;

			}
			//print_r($query_fetch);exit;

			$data .= '</div></div></div>';
			$response["status"] = 200;
			$response["data"] = $data;
		} else {

			$response["status"] = 201;
			$response["data"] = "";
		}
		echo json_encode($response);
	}

	public function uploadPersonalTask()
	{
		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;
		$firm_id = $session_data->firm_id;
		$uImage = $this->input->post();
		$formdata = $this->input->post();
		//print_r($formdata);exit();
		$data = array(
			'task_name' => $formdata['ptask_name'],
			'task_description' => $formdata['ptask_description'],
			'user_id' => $user_id,

			'priorities' => $formdata['priority'],
			'date' => date("d:m:y"),
			'status' => 1);

		$insert = $this->db->insert("personal_task_all", $data);
		$insert_id = $this->db->insert_id();
		if ($insert == true) {
			foreach ($formdata['assign_to'] as $value) {
				//print_r($value);exit;
				$p_data = array(
					'ptask_id' => $insert_id,
					'puser_id' => $value,
					'status' => 1,
					'date' => date("d:m:y"),
					'forward_by' => $user_id);
				$this->db->insert("personal_task_reference_table", $p_data);
			}
			$response["status"] = 200;
			$response["data"] = "uploaded successfully";
		} else {
			$response["status"] = 201;
			$response["data"] = "Not Found";
		}
		echo json_encode($response);
	}

	public function get_personal_task()
	{
		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;
		$firm_id = $session_data->firm_id;
		//$search_for = $this->input->post('search_for');

		$query = $this->db->query("select personal_task_all.task_name,personal_task_all.node_id,personal_task_all.status
 from personal_task_all 
inner join personal_task_reference_table
on personal_task_all.node_id=personal_task_reference_table.ptask_id
where personal_task_reference_table.puser_id='$user_id' OR personal_task_reference_table.forward_by='$user_id';");
		if ($this->db->affected_rows() > 0) {
			$data = "";
			$result = $query->result();

			$data .= '';
			$key = 1;
			foreach ($result as $row) {
				$query1 = $this->db->query("select * from personal_task_reference_table where ptask_id='$row->node_id' and puser_id='$user_id' and status='1'")->num_rows();
				if ($query1 > 0) {
					$attr = "";
				} else {
					$attr = "disabled";
				}

				if ($row->status == 1) {
					$status = ' <span class="badge badge-warning">Pending</span>';
				} else if ($row->status == 2) {
					$status = '<span class="badge badge-success">Complete</span>';
				} else {
					$status = '<span class="badge badge-danger">Close</span>';
				}
				$get_userspast_data = $this->get_userspast_data($row->node_id);
				$data .= '
				<tr>
				
				<td>' . $row->task_name . '</td>
				<td>' . $get_userspast_data . '</td>
				<td>' . $status . '</td>
				<td>
				<button class="btn btn-link" ' . $attr . ' data-toggle="modal" data-target="#forward_task_modal" onclick="get_forward_data(' . $row->id . ')">
                    <i class="fa fa-share text-black" style="color:#68349a;font-size:16px;"></i>
                </button>
				<button class="btn btn-link"  data-toggle="modal" data-target="#forward_ptm" onclick="get_assignment_view(' . $row->id . ')">
                    <i class="fa fa-eye text-black" style="color:#68349a;font-size:16px;">
					
					</i>
                </button>
				<button type="button" class="btn btn-link" onclick="complete_task(2,' . $row->id . ')"><i class="fa fa-check text-black" style="color:#68349a;font-size:16px;"></i></button>
				<button type="button" class="btn btn-link" onclick="complete_task(3,' . $row->id . ')"><i class="fa fa-times text-black" style="color:#68349a;font-size:16px;"></i></button>
				<button type="button" class="btn btn-link" onclick="complete_task(1,' . $row->id . ')"><i class="fa fa-clock-o" style="color:#68349a;font-size:16px;"></i></button>
				</td>
				
				</tr>
			';
				$key++;
			}
			$response["status"] = 200;
			$response["data"] = $data;
		} else {
			$response["status"] = 201;
			$response["data"] = "";
		}
		echo json_encode($response);

	}

	public function insert_comment()
	{
		//$comment=$this->input->post('comment');
		//$task_id=$this->input->post('task_id');

		$uImage = $this->input->post();
		$comment = $uImage['new_texar_comment'];
		$task_id = $uImage['assign_task_id'];
		$user_id = $this->session->user_session->user_id;
		//print_r($uImage);exit();
		$UImage = $_FILES['userfile']['name'];
		//print_r($UImage);exit();
		if ($UImage[0] == "") {
			$u_path = "";
			$result = 1;
		} else {
			$upload_path = "upload/transaction";
			$inputname = 'userfile';
			$combination = 1;


			$this->load->model("Global_model");
			$result = $this->Global_model->upload_multiple_file_new($upload_path, $inputname, $combination);
			$u_path = $result['body'][0];
		}


		//$insert="";
		if ($result != null) {
			$data = array("task_id" => $task_id, "user_id" => $user_id, "comment" => $comment, "comment_file" => $u_path, "date_added" => date("Y/m/d H:i:s"));
			$insert = $this->db->insert("personal_task_comment", $data);

			$response["status"] = 200;
		} else {
			$response["status"] = 201;
		}
		echo json_encode($response);
	}

	public function upload_files()
	{
		$email = $this->session->user_session->email;
		$uImage = $this->input->post();
		//print_r($uImage);exit();
		$UImage = $_FILES['userfile'];
		//print_r($UImage);exit();
		$upload_path = "uploads/profile_image";
		$inputname = 'UImage';
		$combination = 1;
		//print_r($inputname);exit();
		$this->load->model("Global_model");
		$result = $this->Global_model->upload_multiple_file_new($upload_path, $inputname, $combination);

		$u_path = $result['body'][0];
		//print_r($u_path);exit;
		if ($result != null) {
			$this->db->query("update chat_group_all set profile_image='$u_path' where create_by='$email' AND type=1 ");
			$this->db->query("update user_header_all set user_profile_pic='$u_path' where email='$email'");
			//$data=$this->db->query("select user_profile_pic from user_header_all where email='$email'")->result();
			//print_r($data);exit();
			$response["status"] = 200;
			$response["data"] = "uploaded successfully";
		} else {
			$response["status"] = 201;
			$response["data"] = "Not Found";
		}
		echo json_encode($response);
	}



	public function get_personal_task1($id)
	{
		$data = array();
		$switch_type = $this->input->post('switch_type');
		//print_r($switch_type);
		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;

		$firm_id = $session_data->firm_id;
		$status_value = 'p.current_status !=3';
		$where_status = "r.user_id = '" . $user_id . "' or r.forward_by='" . $user_id . "'";
		$sche_where = "sd.assign_to = '" . $user_id . "'";

		if ($switch_type == 3) {
			$where_status = "r.user_id = '" . $user_id . "'";
			
		} else if ($switch_type == 4) {
			$where_status = "r.forward_by='" . $user_id . "'";
			
		}

		if ($id == 1) {
			$status_value = 'p.current_status !=3 and p.type_of_node=1';

		} else if ($id == 2) {
			$status_value = 'p.current_status =3 and p.type_of_node=1';
		} else if ($id == 5) {
			$status_value = 'p.current_status =1 and p.type_of_node=1';
		} else if ($id == 6) {
			$status_value = 'p.current_status =2 and p.type_of_node=1';
		} else if ($id = 7) {
			$sche_where = "sd.assign_to = '" . $user_id . "'";
		}

		$limit = " limit " . $_POST['start'] . ',' . $_POST['length'];

		$like = '';
		if ($_POST['search']['value']) {
			$like = " and p.task_name LIKE '%" . $_POST['search']['value'] . "%'";
		}

		$sche_query = "  select * ,(select pt.task_name from personal_task_all pt where p.root_node_id=pt.node_id) as customer_name,
           (select group_concat(smd.approval_status,'||',smd.repeatation_of_frequency,'||',smd.repetation_year,'||',smd.planning_id,'||',smd.completion_date,'||',smd.work_status order by smd.repeatation_of_frequency desc)
           from scheduling_master_data smd where smd.id in(select scheduling_node_id From scheduling_map_data sd where sd.assign_to ='$user_id' or sd.created_by='$user_id') and smd.node_id=p.node_id) as a_status
           from personal_task_all p where node_id in ( select node_id from scheduling_master_data m  where m.id in  
		   ( select scheduling_node_id From scheduling_map_data sd where sd.assign_to ='$user_id') and m.approval_status=1) and type_of_node=5;";
		//sd.created_by ='$user_id' is remove from scheduling query
		$scheduling_query = $this->db->query($sche_query);

		if ($this->db->affected_rows() > 0) {
			$sche_result = $scheduling_query->result();

			$s_count = $scheduling_query->num_rows();
		} else {
			$sche_result = array();
			$s_count = 0;
		}

		$sql_query = "select
		p.task_name, p.root_node_id,p.node_id,p.current_status,p.priority,p.created_by,p.date_completion, 
		 ( select count(*)  from personal_task_comment c where find_in_set('$user_id',c.comment_to) and task_id in (SELECT node_id from personal_task_all d where d.root_node_id=p.node_id) and comment_status=1) as comment_count
		from personal_task_all p where " . $status_value . " and p.activity_status!=0 and p.node_id in (
			select distinct root_node_id
			from (select distinct root_node_id as root_node_id from personal_task_all where created_by = '" . $user_id . "') t
			union
			(select distinct (select (case
                                  when( (n.dependency_node_id = 0 or n.dependency_node_id is null) and n.dep_node_current_status = 1) or ( (n.dependency_node_id != 0 or n.dependency_node_id is not null) and n.dep_node_current_status = 2)
                                      then n.root_node_id end)from personal_task_all n where n.node_id = r.node_id) as root_node_id
     from personal_task_reference_table r
			 where " . $where_status . " )
		)" . $like . $limit . "";

		$query = $this->db->query($sql_query);
		//echo $this->db->last_query();

		$sql_query1 = "select
		count(p.node_id) as count
		from personal_task_all p where " . $status_value . " and p.activity_status!=0 and p.node_id in (
			select distinct root_node_id
			from (select distinct root_node_id as root_node_id from personal_task_all where created_by = '" . $user_id . "') t
			union
			(select distinct (select (case
                                  when( (n.dependency_node_id = 0 or n.dependency_node_id is null) and n.dep_node_current_status = 1) or ( (n.dependency_node_id != 0 or n.dependency_node_id is not null) and n.dep_node_current_status = 2)
                                      then n.root_node_id end)from personal_task_all n where n.node_id = r.node_id) as root_node_id
     from personal_task_reference_table r
			 where " . $where_status . " )
		)";

		$query_count = $this->db->query($sql_query1)->row();

		if ($this->db->affected_rows() > 0) {

			if ($id == 7) {
				$key1 = 1;
				$sche_c = 1;

				$customerWiseGrouping=array();
				foreach($sche_result as $row){
					$customerWiseGrouping[$row->customer_name][]=$row;
				}
				$task_d="";
				foreach($customerWiseGrouping as $customer_name =>$records){
					$randomNumber=random_int(1000,5000);
					$task_d='					
					<li class="list-group-item border-0">
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
                                     <div class="widget-heading">'.$customer_name.'</div>                                               
                                </div>
                                <div class="widget-content-right">                                
									<button class="border-0 btn-transition btn btn-outline-danger" id="scheduling_viewId_'.$randomNumber.'" onclick="scheduling_view(`scheduleTabCustomer_'.$customer_name.'`,'.$randomNumber.',3,1)">
                                    	<i class="fa fa-angle-down"></i>
                                    </button>
                                </div>
							</div>
							<div id="scheduleTabCustomer_'.$customer_name.'" class="w3-container w3-hide" style="padding-left:10px;font-size:12px">
								<div class="card main-card no-shadow">
									<div class="scroll-area-lg">
										<ul class="list-group list-group-flush  scrollbar-container todo-list-wrapper ">
									';

					foreach($records as $s_row){
						$s_activeStatus = 0;
						if (!empty($s_row->a_status)) {
							$noOfScheduling= explode(",",$s_row->a_status);
							foreach ($noOfScheduling as $schedulingPeriod){
								$scheduleData = explode('||', $schedulingPeriod);
								if (count($scheduleData) >= 6) {
									$s_activeStatus = $scheduleData[0];
									$s_repetationFrequencey = (int)$scheduleData[1];

									if($s_repetationFrequencey <=12 && $s_repetationFrequencey >=1){

										$freqOptions=$this->getFrequencyOptions(1);
									}else if($s_repetationFrequencey >=13 && $s_repetationFrequencey <=16){

										$freqOptions=$this->getFrequencyOptions(2);

									}elseif($s_repetationFrequencey == 17){

										$freqOptions=$this->getFrequencyOptions(3);
									}else{

										$freqOptions=$this->getFrequencyOptions(0);
									}

									$freqWord=$freqOptions[$s_repetationFrequencey];
									$s_year = $scheduleData[2];
									$s_planning = $scheduleData[3];
									$s_completion_date=trim($scheduleData[4],',1');
									$s_work_status = (int)$scheduleData[5];
									if ($s_activeStatus == 1) {
										if (strtotime($s_completion_date) < strtotime(date("Y-m-d"))) {
											// this is true
											$delay = '<i><span class="badge badge-danger">delay</span> </i>';
										} else {
											$delay = '';
										}

										if ($s_work_status == 3) {
											$status = 'bg-danger';
										} else if ($s_work_status == 2) {
											$status = 'bg-success';
										} else {
											$status = ' bg-warning';

										}
										$get_userspast_data = $this->get_userspast_data($s_row->node_id);
										$get_userspast_forward_data = $this->get_userspast_forward_data($s_row->node_id);
										if ($get_userspast_forward_data != "") {
											$get_userspast_forward_data = $get_userspast_forward_data;
										} else {
											$get_userspast_forward_data = '';
										}
										$get_level_data = $this->get_scheduling_level_data($s_row->root_node_id, $s_row->parent_node_id);
										$project_name = "";
										if ($get_level_data != null || $get_level_data != "") {
											$project_name = "- ". $get_level_data->task_name;
											$p_node_id = $get_level_data->node_id;
											$sche_planning_id = $get_level_data->reference_id;

											$sche_query = $this->db->query("select * from planning_master_data where id='$sche_planning_id'")->row();
											//print_r($sche_query);exit();
											if (!empty($sche_query)) {
												$level_frequency_type = $sche_query->frequancy_type;
												if ($level_frequency_type == 1) {
													$sche_freq = 'Monthly';
												} else if ($level_frequency_type == 2) {
													$sche_freq = 'Quatarly';
												} else if ($level_frequency_type == 3) {
													$sche_freq = 'Yearly';
												} else {
													$sche_freq = 'Onetime';
												}
											}
										}
										$date_completion = date('jS M Y', strtotime($s_completion_date));
										$task_name_d = strlen($s_row->task_name) > 20 ? substr($s_row->task_name, 0, 20) . "..." : $s_row->task_name;
										$task_d.='<li class="list-group-item">
													<div class="todo-indicator ' . $status . '"></div>
													<div class="widget-content p-0">
														<div class="widget-content-wrapper">
															<div class="widget-content-left mr-2">
																<div class="widget-heading"> ' . $task_name_d . '  '.$project_name.'</div>
																<div class="widget-subheading">'. $freqWord.' scheduling</div>
																<div class="widget-subheading">Complete on ' . $date_completion . '</div>
															</div>
															<div class="widget-content-right">      
																<!--<button class="border-0 btn-transition btn btn-outline-success" onclick="schedulingloadTree1(' . $s_row->root_node_id . ',2,' . $s_planning . ',' . $s_repetationFrequencey . ',' . $s_year . ',' . $s_row->node_id . '),setTypeOfLoadTree(2),get_type_view(' . $s_row->node_id . ',' . $s_planning . ')">
																		<i class="fas fa-sitemap"></i>
																</button> -->
																<button class="border-0 btn-transition btn btn-outline-info" onclick="selectNode(' . $s_row->root_node_id . ',' . $s_row->node_id . ',' . $s_planning . ',' . $s_repetationFrequencey . ',' . $s_year . ');get_assignment_view(' . $s_row->node_id . ','.$s_repetationFrequencey.',' . $s_year . ',' . $s_planning . ');viewALLDetail();">
																		<i class="fa fa-eye"></i>
																</button> ';
																if($user_id=='U_795' || $user_id=='U_22')
																{
																	$task_d.='<button class="border-0 btn-transition btn btn-outline-info" onclick="selectNode(' . $s_row->root_node_id . ',' . $s_row->node_id . ',' . $s_planning . ',' . $s_repetationFrequencey . ',' . $s_year . ');get_assignment_view(' . $s_row->node_id . ','.$s_repetationFrequencey.',' . $s_year . ',' . $s_planning . ');viewScheduleRightPanel();">
																		<i class="fa fa-eye"></i>
																		</button> ';
																}
																$task_d.='
															</div>
														</div>
													</div>
												
											</li>';



										$key1++;
										$sche_c++;
									}

								}
							}

						}
					}

					$task_d.='		   </ul>
									</div>
								</div>
							</div>
						</div>					
					</li>';
					$data[] = array('task_name' => $task_d);
				}



				$query_count = (int)$s_count;
			}

			if ($id != 7) {
				$key = 1;
				$result = $query->result();
				foreach ($result as $row) {


					if ($row->comment_count > 0) {
						$comment_count = '<div class="widget-content-right">
                                                                <div class="badge badge-warning mr-2">' . $row->comment_count . '</div>
                                                            </div>';
					} else {
						$comment_count = '';
					}
					if($row->current_status == 1){
						if (strtotime($row->date_completion) < strtotime(date("Y-m-d"))) {
							// this is true
							$delay = '<i><span class="badge badge-danger">delay</span> </i>';
						} else {
							$delay = '';
						}
					}
					else
					{
						$delay = '';
					}

					if ($row->current_status == 1) {
						$status = ' bg-warning';
					} else if ($row->current_status == 2) {
						$status = 'bg-success';
					} else {
						$status = 'bg-danger';
					}
					$get_userspast_data = $this->get_userspast_data($row->node_id);
					$get_userspast_forward_data = $this->get_userspast_forward_data($row->node_id);
					if ($get_userspast_forward_data != "") {
						$get_userspast_forward_data = $get_userspast_forward_data;
					} else {
						$get_userspast_forward_data = '';
					}
					$date_completion = date('jS M Y', strtotime($row->date_completion));
					$task_name_d = strlen($row->task_name) > 20 ? substr($row->task_name, 0, 20) . "..." : $row->task_name;
					$task_d = '<a class="btn btn-link w-100" type="button" onclick="loadTree1(' . $row->root_node_id . ')">
                                                    <div class="todo-indicator ' . $status . '"></div>
                                                    <div class="widget-content py-0">
                                                        <div class="widget-content-wrapper text-left">
                                                            
                                                            <div class="widget-content-left flex2">
                                                                <div class="widget-heading"><i>' . $get_userspast_data . '</i>' . $task_name_d . '<i>' . $get_userspast_forward_data . '</i></div>
														     
															<div class="widget-subheading">Complete on ' . $date_completion . '</div>
                                                            </div>
                                                            ' . $delay . ' ' . $comment_count . '
                                                            
                                                        </div>
                                                    </div></a>
                                               ';

					$data[] = array('task_name' => $task_d);

					$key++;
				}
				$query_count = (int)$query_count->count;
			}

			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => count($data),
				//"recordsFiltered" => (int)$query_count->count,
				//"recordsFiltered" => count($data),
				"recordsFiltered" => $query_count,
				"data" => $data
			);

		} else {
			$results = "";
		}
		echo json_encode($results);


	}

	function get_username($user_id)
	{
		$query = $this->db->query("select user_name from user_header_all where user_id='$user_id'");
		if ($this->db->affected_rows() > 0) {
			$result = $query->row();
			$user_name = $result->user_name;
		} else {
			$user_name = "";
		}
		return $user_name;
	}

	function get_userspast_data1($task_id)
	{
		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;
		//$task_id=12;
		$data = "";
		$query_data = $this->db->query("select node_id,created_by from personal_task_all where node_id='$task_id'");
		if ($this->db->affected_rows() > 0) {
			$result1 = $query_data->result();
			foreach ($result1 as $row) {
				$name_2 = $this->get_username($row->created_by);
				$words1 = explode(' ', $name_2);
				count($words1);
				if (count($words1) > 1) {
					$result12 = $words1[0][0] . $words1[1][0];
				} else {
					$result12 = $words1[0][0] . $words1[0][1];
				}
				$data .= ' <span class="badge badge-info" style="border-radius: 50%;">' . $result12 . "</span>";


			}
			$data = rtrim($data, " <i class='fas fa-angle-double-right'></i> ");

		}


		return $data;
	}

	function get_userspast_data($task_id)
	{
		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;
		//$task_id=12;
		//$task_id=12;
		$query = $this->db->query("select personal_task_reference_table.*,(select priority from personal_task_all where node_id='$task_id') as priority from personal_task_reference_table where node_id in (select node_id from personal_task_all where root_node_id='$task_id') and user_id='$user_id'");

		$data = "";
		if ($this->db->affected_rows() > 0) {
			$row = $query->row();
			$priority = $row->priority;
			if ($priority == 'High') {
				$class_p = 'badge-danger';
			} else if ($priority == 'Medium') {
				$class_p = 'badge-warning';
			} else {
				$class_p = 'badge-success';
			}
			$query1 = $this->db->query("select * from personal_task_reference_table where node_id in (select node_id from personal_task_all where root_node_id='$task_id') and user_id='$user_id'");
			$name_1 = $this->get_username($row->forward_by);
			$words = explode(' ', $name_1);
			$result1 = $words[0][0] . $words[1][0];
			$data .= "<span class='badge " . $class_p . "' >" . $result1 . "</span> ";
			// <i class='fas fa-angle-double-right'></i>
			//$data = rtrim($data, ' <i class="fas fa-angle-double-right"></i> ');

		}
		return $data;
	}

	function get_userspast_forward_data($task_id)
	{
		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;
		//$task_id=12;
		//$task_id=12;
		$query = $this->db->query("select personal_task_reference_table.*,(select priority from personal_task_all where node_id='$task_id') as priority from personal_task_reference_table where node_id in (select node_id from personal_task_all where root_node_id='$task_id') and forward_by='$user_id' and user_id!=forward_by");
		$data = "";
		if ($this->db->affected_rows() > 0) {
			$row = $query->row();
			$priority = $row->priority;
			if ($priority == 'High') {
				$class_p = 'badge-danger';
			} else if ($priority == 'Medium') {
				$class_p = 'badge-warning';
			} else {
				$class_p = 'badge-success';
			}
			$name_1 = $this->get_username($row->user_id);
			$words = explode(' ', $name_1);
			if(count($words)>1){
				$result1 = $words[0][0] . $words[1][0];
			}else{
				$result1 = $words[0][0] . $words[0][1];
			}

			$data .= "<span class='badge " . $class_p . "' style='border-radius: 50%;'>" . $result1 . "</span>  ";
			//<i class='fas fa-angle-double-right'></i>
			$data = rtrim($data, "<i class='fas fa-angle-double-right'></i> ");

		}
		return $data;
	}


	public function fetchDatafromDatabase()
	{
		$resultList = $this->db->query("select * from personal_task_all")->result_array();

		$result = array();
		$i = 1;
		foreach ($resultList as $key => $value) {

			$result['data'][] = array(
				$i++,
				$value['task_name'],
				$value['priority'],
				$value['date'],
			);
		}
		echo json_encode($result);
	}


	public function getFrequencyOptions($type)
	{
		switch ((int)$type) {
			case 0://oneTime;
				return array(0 => "Onetime");
			case 1:// monthly
				return array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
			case 2:// quarterly
				return array(13 => "Quarter - 1", 14 => "Quarter - 2", 15 => "Quarter - 3", 16 => "Quarter - 4");
			case 3 :// yearly
				return array(17 => "Yearly");
		}
	}

	public function getProjectReviewTasks($id)
	{

		$user_id = 'U_22';// $this->session->user_session->user_id;

		$whereStatusCondition = 'smd.work_status !=3';
		$limitCondition = " limit " . $_POST['start'] . ',' . $_POST['length'];

		$likeCondition = '';
//		if ($_POST['search']['value']) {
//			$likeCondition = " and p.task_name LIKE '%" . $_POST['search']['value'] . "%'";
//		}

		switch((int)$id){
			case 1 :
				$whereStatusCondition = ' and smd.work_status !=3';
				break;
			case 2 :
				$whereStatusCondition = ' and smd.work_status =3';
				break;
			case 5 :
				$whereStatusCondition = ' and smd.work_status =1';
				break;
			case 6 :
				$whereStatusCondition = ' and smd.work_status =2';
				break;
		}
		$this->load->model("NodeModel");
		$projectReviewResultObject= $this->NodeModel->getProjectReviewTask($user_id,$whereStatusCondition,$likeCondition,$limitCondition);
		$projectReviewCountResultObject=$this->NodeModel->getProjectReviewTaskTotal($user_id,$whereStatusCondition);
		
		if($projectReviewCountResultObject->totalCount > 0){
			
			$recordsFiltered=$projectReviewCountResultObject->data[0]->records;
		}else{
			$recordsFiltered=0;
		}
		$data=array();
		$templateDesign="";
		if($projectReviewResultObject->totalCount > 0){

			$groupByCustomerWise = array();
			foreach ($projectReviewResultObject->data as $taskRecord){
				if(!is_null($taskRecord->customer_name)){
					if((int)$taskRecord->type_of_node == 4){
						$projectNodeDetails=$this->get_scheduling_level_data($taskRecord->root_node_id, $taskRecord->parent_node_id);
						if(!is_null($projectNodeDetails)){

							$taskRecord->projectNodeId=$projectNodeDetails->node_id;
							$taskRecord->projectParentId=$projectNodeDetails->parent_node_id;
							$taskRecord->projectName=$projectNodeDetails->task_name;
							$taskRecord->projectId=$projectNodeDetails->reference_id;
							$taskRecord->projectFrequenceyType = $taskRecord->frequancy_type;
						}
					}
					$groupByCustomerWise[$taskRecord->customer_name][]=$taskRecord;
				}
			}

			foreach ($groupByCustomerWise as $customer_name => $taskRecords){
				$templateDesign .=' <li class="list-group-item">
                                <div class="widget-content p-0">
                                    <div class="widget-content-wrapper">                                            
                                            <div class="widget-content-left">
                                                <div class="widget-heading">' . $customer_name . '</div>                                               
                                            </div>                                          
                                            <div class="widget-content-right">                                               
                                                <button class="border-0 btn-transition btn btn-outline-danger" id="scheduling_viewId_' . $customer_name . '" >
                                                    <i class="fa fa-angle-down"></i>
                                                </button>
                                            </div>
                                    </div>                                  
                                    <div id="customer_' .$customer_name. '" class="w3-container w3-hide" style="padding-left:10px;font-size:12px">
                                    <div class="card main-card no-shadow">            
                            			<div class="scroll-area-lg">                                                
                            			<ul class="list-group list-group-flush  scrollbar-container todo-list-wrapper ">
                                    ';
				foreach ($taskRecords as $task){
					$projectFrequency ="";
					$frequencyPeriod="";
					if(property_exists($task,"projectFrequenceyType")){
						$frequencyType =(int) $task->projectFrequenceyType;
						if ($frequencyType == 1) {
							$projectFrequency = 'Monthly';
						} else if ($frequencyType == 2) {
							$projectFrequency = 'Quatarly';
						} else if ($frequencyType == 3) {
							$projectFrequency = 'Yearly';
						} else {
							$projectFrequency = 'Onetime';
						}
						$optionsArray=$this->getFrequencyOptions($frequencyType);
						$frequencyPeriod=$optionsArray[$task->repeatation_of_frequency];

					}
					if ($task->comment_count > 0) {
						$commentCount = '<div class="widget-content-right"><div class="badge badge-warning mr-2">' . $task->comment_count . '</div></div>';
					} else {
						$commentCount = '';
					}
					if(!is_null($task->completion_date)) {
						if (strtotime($task->completion_date) < strtotime(date("Y-m-d"))) {
							$delay = '<i><span class="badge badge-danger">delay</span> </i>';
						} else {
							$delay = '';
						}
						$date_completion = date('jS M Y', strtotime($task->completion_date));
					}else{
						$delay = '';
						$date_completion="";
					}

					if ((int)$task->work_status == 1) {
						$status = ' bg-warning';
					} else if ((int)$task->work_status == 2) {
						$status = 'bg-success';
					} else {
						$status = 'bg-danger';
					}
					if(property_exists($task,"projectName")){
						$projectName=$task->projectName;
					}else{
						$projectName="";
					}


					$task_name = strlen($task->task_name) > 20 ? substr($task->task_name, 0, 20) . "..." : $task->task_name;

					$templateDesign .= '<li class="list-group-item">
								<div class="widget-content p-0">
									<div class="widget-content-wrapper">											
											<div class="widget-content-left  mr-3">
												<div class="widget-heading">' . $customer_name . ' - ' . $task_name . ' - ' . $delay . ' </div>
												<div class="widget-subheading" style="font-size: 12px;">' . $projectFrequency . ' Scheduling - '.$frequencyPeriod . $projectName . '</div>
											</div>
											<div class="widget-content-right">
												<div class="badge badge-warning mr-2">' . $commentCount . '</div>
											</div>
										    <div class="widget-content-right">
												<button class="border-0 btn-transition btn btn-outline-success" onclick="projectReviewloadTree2(' . $task->root_node_id . ',2,' . $task->planning_id . ',' . $task->repeatation_of_frequency . ',' . $task->repetation_year . ',' . $task->node_id . '),setTypeOfLoadTree(2),get_type_view(' . $task->type_of_node . ',' . $task->planning_id . ')">
													<i class="fas fa-sitemap"></i>
												</button>
											</div>
									</div>
								</div>
							</li>';



				}
				$templateDesign.="</ul></div></div>";
				array_push($data, array("task_name" => $templateDesign));

			}



			$response = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $projectReviewResultObject->totalCount,
				"recordsFiltered" => $recordsFiltered,
				"query" => $projectReviewResultObject->last_query,
				"data" => $data);

		}else{
			$response = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $projectReviewResultObject->totalCount,
				"recordsFiltered" =>$recordsFiltered,
				"query" => $projectReviewResultObject->last_query,
				"data" => $projectReviewResultObject->data);
		}
		echo json_encode($response);
	}

	public function get_preview_task($id)
	{

		$data = array();
		$switch_type = $this->input->post('switch_type');

		$session_data = $this->session->user_session;
		$user_id = $session_data->user_id;

		$firm_id = $session_data->firm_id;
		$status_value = 'p.current_status !=3';
		$where_status = "r.user_id = '" . $user_id . "' or r.forward_by='" . $user_id . "'";
		//$where_status="r.user_id = '".$user_id."'";


		if ($switch_type == 3) {
			$where_status = "r.forward_by='" . $user_id . "'";
		} else if ($switch_type == 4) {
			$where_status = "r.user_id = '" . $user_id . "'";
		}

		if ($id == 1) {
			$status_value = 'p.current_status !=3 and p.type_of_node=4';

		} else if ($id == 2) {
			$status_value = 'p.current_status =3 and p.type_of_node=4';
		} else if ($id == 5) {
			$status_value = 'p.current_status =1 and p.type_of_node=4';
		} else if ($id == 6) {
			$status_value = 'p.current_status =2 and p.type_of_node=4';
		}


		$limit = " limit " . $_POST['start'] . ',' . $_POST['length'];

		$like = '';
		if ($_POST['search']['value']) {
			$like = " and p.task_name LIKE '%" . $_POST['search']['value'] . "%'";
		}


		$sql_query = "select p.task_name, p.root_node_id,p.type_of_node,p.reference_id,p.parent_node_id,p.node_id,p.current_status,p.priority,p.created_by,p.date_completion,smd.repeatation_of_frequency,smd.repetation_year, 
		( select c.task_name from  personal_task_all c where c.node_id=p.root_node_id and c.type_of_node=6)as customer_name,
		( select count(*) from personal_task_comment c where find_in_set('$user_id',c.comment_to) and task_id in 
		(SELECT node_id from personal_task_all d where d.root_node_id=p.node_id) and comment_status=1) as comment_count 
		from personal_task_reference_table r join personal_task_all p on (r.node_id=p.node_id and " . $status_value . ") join scheduling_master_data smd on (smd.node_id=p.node_id) where " . $where_status . " group by p.node_id " . $like . $limit . "";

		$sql_query="select * ,(select pt.task_name from personal_task_all pt where p.root_node_id=pt.node_id) as customer_name,
           (select group_concat(smd.approval_status,'||',smd.repeatation_of_frequency,'||',smd.repetation_year,'||',smd.planning_id,'||',smd.completion_date,'||',smd.work_status)
           from scheduling_master_data smd where smd.id in(select scheduling_node_id From scheduling_map_data sd where sd.assign_to ='$user_id') and smd.node_id=p.node_id) as a_status,
           ( select count(*) from personal_task_comment c where find_in_set('$user_id',c.comment_to) and task_id in 
		(SELECT node_id from personal_task_all d where d.root_node_id=p.node_id) and comment_status=1) as comment_count 
           from personal_task_all p where node_id in ( select node_id from scheduling_master_data m  where m.id in  
		   ( select scheduling_node_id From scheduling_map_data sd where sd.assign_to ='$user_id') and m.approval_status=1) and type_of_node in (3,4)". $like  ;
		$query = $this->db->query($sql_query);
		$last_query = $this->db->last_query();
		$sql_query1 = "select count(p.node_id) as count
		from personal_task_reference_table r join personal_task_all p on (r.node_id=p.node_id and " . $status_value . ") join scheduling_master_data smd on (smd.node_id=p.node_id) where " . $where_status . " group by p.node_id";
		
		$query_count = $this->db->query($sql_query1)->row();
		//print_r(count($query));exit();
		if ($this->db->affected_rows() > 0) {

			$result = $query->result();
			$p_count = $query->num_rows();

			$key = 1;
			$customerWiseGrouping=array();
			foreach($result as $row){
				$customerWiseGrouping[$row->customer_name][]=$row;
			}
//			var_dump($customerWiseGrouping);
			foreach($customerWiseGrouping as $customer_name =>$records) {
				$randomNumber = random_int(1000, 5000);
				$task_d = '					
					<li class="list-group-item border-0">
						<div class="widget-content p-0">
							<div class="widget-content-wrapper">
								<div class="widget-content-left">
                                     <div class="widget-heading">' . $customer_name . '</div>                                               
                                </div>
                                <div class="widget-content-right">                                
									<button class="border-0 btn-transition btn btn-outline-danger" id="scheduling_viewId_' . $randomNumber . '" onclick="scheduling_view(`projectReviewTabCustomer_' . $customer_name . '`,' . $randomNumber . ',3)">
                                    	<i class="fa fa-angle-down"></i>
                                    </button>
                                </div>
							</div>
							<div id="projectReviewTabCustomer_' . $customer_name . '" class="w3-container w3-hide" style="padding-left:10px;font-size:12px">
								<div class="card main-card no-shadow">
									<div class="scroll-area-lg">
										<ul class="list-group list-group-flush  scrollbar-container todo-list-wrapper ">
									';


				foreach ($result as $s_row) {
					$s_activeStatus = 0;
					if (!empty($s_row->a_status)) {
						$noOfScheduling = explode(",", $s_row->a_status);
						foreach ($noOfScheduling as $schedulingPeriod) {
							$scheduleData = explode('||', $schedulingPeriod);
							if (count($scheduleData) >= 6) {
								$s_activeStatus = $scheduleData[0];
								$s_repetationFrequencey = (int)$scheduleData[1];

								if ($s_repetationFrequencey <= 12 && $s_repetationFrequencey >= 1) {

									$freqOptions = $this->getFrequencyOptions(1);
								} else if ($s_repetationFrequencey >= 13 && $s_repetationFrequencey <= 16) {

									$freqOptions = $this->getFrequencyOptions(2);

								} elseif ($s_repetationFrequencey == 17) {

									$freqOptions = $this->getFrequencyOptions(3);
								} else {

									$freqOptions = $this->getFrequencyOptions(0);
								}

								$freqWord = $freqOptions[$s_repetationFrequencey];
								$s_year = $scheduleData[2];
								$s_planning = $scheduleData[3];
								$s_completion_date = trim($scheduleData[4], ',1');
								$s_work_status = (int)$scheduleData[5];
								if ($s_activeStatus == 1) {
									if (strtotime($s_completion_date) < strtotime(date("Y-m-d"))) {
										// this is true
										$delay = '<i><span class="badge badge-danger">delay</span> </i>';
									} else {
										$delay = '';
									}

									if ($s_work_status == 3) {
										$status = 'bg-danger';
									} else if ($s_work_status == 2) {
										$status = 'bg-success';
									} else {
										$status = ' bg-warning';

									}
									$get_userspast_data = $this->get_userspast_data($s_row->node_id);
									$get_userspast_forward_data = $this->get_userspast_forward_data($s_row->node_id);
									if ($get_userspast_forward_data != "") {
										$get_userspast_forward_data = $get_userspast_forward_data;
									} else {
										$get_userspast_forward_data = '';
									}
									$get_level_data = $this->get_scheduling_level_data($s_row->root_node_id, $s_row->parent_node_id);
									$project_name = "";
									if ($get_level_data != null || $get_level_data != "") {
										$project_name = " - ".$get_level_data->task_name." ";
										$p_node_id = $get_level_data->node_id;
										$sche_planning_id = $get_level_data->reference_id;

										$sche_query = $this->db->query("select * from planning_master_data where id='$sche_planning_id'")->row();
										//print_r($sche_query);exit();
										if (!empty($sche_query)) {
											$level_frequency_type = $sche_query->frequancy_type;
											if ($level_frequency_type == 1) {
												$sche_freq = 'Monthly';
											} else if ($level_frequency_type == 2) {
												$sche_freq = 'Quatarly';
											} else if ($level_frequency_type == 3) {
												$sche_freq = 'Yearly';
											} else {
												$sche_freq = 'Onetime';
											}
										}
									}
									$date_completion = date('jS M Y', strtotime($s_completion_date));
									if((int)$s_row->type_of_node ==  4){
										$task_name_d = strlen($s_row->task_name) > 20 ? substr($s_row->task_name, 0, 20) . "..." : $s_row->task_name;
									}else{
										$task_name = strlen($s_row->task_name) > 20 ? substr($s_row->task_name, 0, 20) . "..." : $s_row->task_name;
										$task_name_d ="Project Manager - ".$task_name;
									}

									$task_d.='<li class="list-group-item">
													<div class="todo-indicator ' . $status . '"></div>
													<div class="widget-content p-0">
														<div class="widget-content-wrapper">
															<div class="widget-content-left mr-2">
																<div class="widget-heading"> ' . $task_name_d . '  '.$project_name.'</div>
																<div class="widget-subheading">'. $freqWord.' scheduling</div>
																<div class="widget-subheading">Complete on ' . $date_completion . '</div>
															</div>
															<div class="widget-content-right">      
																<button class="border-0 btn-transition btn btn-outline-success" onclick="projectReviewloadTree2(' . $s_row->root_node_id . ',2,' . $s_planning . ',' . $s_repetationFrequencey . ',' . $s_year . ',' . $s_row->node_id . '),setTypeOfLoadTree(2),get_type_view(' . $s_row->type_of_node . ',' . $s_planning . ')">
																		<i class="fas fa-sitemap"></i>
																</button>
																<button class="border-0 btn-transition btn btn-outline-info" onclick="selectNode(' . $s_row->root_node_id . ',' . $s_row->node_id . ',' . $s_planning . ',' . $s_repetationFrequencey . ',' . $s_year . ');get_assignment_view(' . $s_row->node_id . ','.$s_repetationFrequencey.',' . $s_year . ',' . $s_planning . ');viewALLDetail()">
																		<i class="fa fa-eye"></i>
																</button> 
															</div>
														</div>
													</div>
												
											</li>';
//									$task_d = '<li class="list-group-item">
//                                                    <div class="todo-indicator ' . $status . '"></div>
//                                                    <div class="widget-content py-0">
//                                                        <div class="widget-content-wrapper">
//                                                            <div class="widget-content-left">
//                                                                <div class="widget-heading">' . $s_row->customer_name . ' - ' . $task_name_d . $delay . '
//                                                                </div>
//																<div class="widget-subheading">' . $project_name . ' - ' . $freqWord . ' scheduling </div>
//																<div class="widget-subheading">Complete on ' . $date_completion . ' </div>
//                                                            </div>
//                                                            <div class="widget-content-right">
//																<button class="border-0 btn-transition btn btn-outline-success" onclick="projectReviewloadTree2(' . $s_row->root_node_id . ',2,' . $s_planning . ',' . $s_repetationFrequencey . ',' . $s_year . ',' . $s_row->node_id . '),setTypeOfLoadTree(2),get_type_view(' . $s_row->type_of_node . ',' . $s_planning . ')">
//																	<i class="fas fa-sitemap"></i>
//																</button>
//														 	</div>
//                                                        </div>
//
//                                                    </div>
//                                                  </li>
//                                               ';



								}

							}
						}

					}

				}
				$task_d.='		   </ul>
									</div>
								</div>
							</div>
						</div>					
					</li>';
				$data[] = array('task_name' => $task_d);
			}
			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => count($data),
				"recordsFiltered" => (int)$query_count->count,
				"query" => $last_query,
				//"recordsFiltered" => (int)$query_count,
				"data" => $data
			);

			//print_r($results);exit();
		} else {

			$results = array(
				"draw" => (int)$_POST['draw'],
				"recordsTotal" => count($data),
				"recordsFiltered" => 0,
				"query" => $last_query,
				//"recordsFiltered" => (int)$query_count,
				"data" => $data);
		}
		echo json_encode($results);


	}

	public function get_scheduling_level_data($root_node_id, $parent_node_id)
	{
		$data = $this->db->query("select * from personal_task_all where root_node_id='$root_node_id' and node_id='$parent_node_id'");
		//print_r($data->result());exit();
		if ($this->db->affected_rows() > 0) {
			$data = $data->result();

			foreach ($data as $level_data) {

				//if($level_data->type_of_node==3 || $level_data->type_of_node==2)
				if ($level_data->type_of_node == 3) {
					//echo 1;
					return $level_data;
					//break;
				} else {
					//echo 0;
					if ($level_data->root_node_id != $level_data->parent_node_id) {

						return $this->get_scheduling_level_data($level_data->root_node_id, $level_data->parent_node_id);
					}
				}
			}
		}else{
			return null;
		}
	}


}


?>
