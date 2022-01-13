<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property  MessengerModel MessengerModel
 */
class Chat_Controller extends CI_Controller
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
		$this->load->view('chat_view/chat');
	}

	public function video_chat()
	{
		$this->load->view('chat_view/video_call');
	}

	public function video_design()
	{
		$this->load->view('chat_view/video_design');
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
			$firm_id = $this->session->user_session->company_id;
		}
		
		$branch_id = $this->session->user_session->branch_id;
		$user_id="";
		$resultObject = $this->MessengerModel->getFirmUsers($firm_id=1,$branch_id ,$user_id);
		
		if ($resultObject->totalCount != 0) {
			//var_dump($resultObject->data);
			
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
		$user_name = $this->session->user_session->user_name;
		$get_group_id=$this->MessengerModel->get_group_id($user_name);
		if($get_group_id != false){
			$sender_group_id=$get_group_id;
		}else{
			$sender_group_id="";
		}
		if (!is_null($this->input->post('group_id')) && !is_null($this->input->post('message'))) {
			$time = date("Y-m-d H:i:s");
			$this->load->model("Global_model");
			$des_path = "";
			$content_type = 1;
			$imageResult = $this->Global_model->upload_multiple_file_new('chat_assets/storage/user_files', 'userFile', 2);
			$mtype = $this->input->post('mtype');
			$response['mtype'] = $mtype;

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
			$messageDetails = array('sender_id' => $sender_group_id,
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
				$user_name = $this->session->user_session->user_name;
				$get_group_id=$this->MessengerModel->get_group_id($user_name);
				if($get_group_id != false){
					$local_group_id=$get_group_id;
				}else{
					$local_group_id="";
				}
			
			} else {
				$local_group_id = $this->input->post('local_group_id');
			}
			$type = $this->input->post('type');

			$remote_group_id = $this->input->post('remote_group_id');
		
			if ((int)$type == 1 || (int)$type == 2) {
				$resultObject = $this->MessengerModel->getMessage($remote_group_id, $local_group_id);
			} else {
				$resultObject = $this->MessengerModel->getGroupMessage($remote_group_id, $local_group_id);
			}


			if ($resultObject->totalCount != 0) {
				echo json_encode($resultObject->data);
			} else {
				echo json_encode(array());
			}
		} else {
			echo json_encode(array());
		}
	}

	public function get_unread_messages_count()
	{
		if (!is_null($this->input->post('group_id'))) {
			$emailID = $this->input->post('group_id');
			$resultObject = $this->MessengerModel->getCountOfUnreadMessages($emailID);
			if ($resultObject->totalCount > 0) {
				$response['status'] = 200;
				$response['body'] = $resultObject->data;
			} else {
				$response['status'] = 201;
				$response['body'] = $resultObject->data;
			}
		} else {
			$response['status'] = 201;
		}
		echo json_encode($response);
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
			//$response['status'] = 201;
			//$response['body'] = 'Remove From Favourite';
			//}
			//else{
			//$data1 = array('status' => 1);
			//$this->db->where($where);
			//$this->db->update('chat_favourite_user', $data1);
			//$response['status'] = 202;
			//$response['body'] = 'Added to Favourite';
			//}
			$response['status'] = 201;
			$response['body'] = 'Remove From Favourite';
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
					$query_fetch = $this->db->query("SELECT uha.user_name,(SELECT c.profile_image FROM chat_group_all c WHERE c.create_by = uha.email and type=1) as group_image FROM user_header_all uha WHERE email='$email'");
					if ($query_fetch->num_rows() > 0) {
						$record = $query_fetch->row();
						$user_name = $record->user_name;
						$status = $row->permission;
						$Image = $record->group_image;
						
						if($Image!=null)
						{
							$profile_image=base_url().$Image;
						}
						else{
							$profile_image=base_url().'chat_assets/storage/user_image/avatar_default.png';
						}

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
											<img src="'.$profile_image.'" alt="avatar" class="avatar-image is-loaded bg-theme" width="100%"></span>
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

	public function get_UserInvolveInGroup()
	{
		$user_id = $this->session->user_session->email;

		$this->load->model("MessengerModel");
		$result = $this->MessengerModel->getUserInvolveInGroup($user_id);

		echo json_encode($result);
	}

	public function updateNotification()
	{
		$sender_id = $this->input->post('sender_id');
		$local_group_id = $this->input->post('local_group_id');
		$status = $this->input->post('status');
		$get_message_id = $this->db->query("select id from chat_messages_all where sender_id='$sender_id' AND group_id='$local_group_id'");
		$messageData = array();
		if ($this->db->affected_rows() > 0) {
			$result = $get_message_id->result();
			foreach ($result as $row) {
				$message_id = $row->id;
				$statusDetails = array("status" => $status);
				if ($this->MessengerModel->updateNotification($statusDetails, $message_id)->status) {
					array_push($messageData, $message_id);
				}
			}
		}
		echo json_encode($messageData);
	}

	public function updateMessageStatus()
	{
		if (!is_null($this->input->post("message_id")) && !is_null($this->input->post("status"))) {
			$message_id = $this->input->post("message_id");
			$status = $this->input->post("status");
			if ($this->MessengerModel->updateNotification(array("status" => $status), $message_id)->status) {
				$response['status'] = 200;
				$response['body'] = "done";
			} else {
				$response['status'] = 201;
				$response['body'] = "failed to update";
			}
		} else {
			$response['status'] = 201;
			$response['body'] = "Missing Parameter";
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


}


?>
