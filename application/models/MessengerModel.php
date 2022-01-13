<?php

require_once 'MasterModel.php';

class MessengerModel extends MasterModel
{

	private $chatGroupTable;
	private $chatGroupMapTable;
	private $chatMessagesTable;
	private $chat_message_notification_all;

	/**
	 * MessengerModel constructor.
	 */
	public function __construct()
	{
		$this->chatGroupTable = 'chat_group_all';
		$this->chatGroupMapTable = 'chat_group_map_all';
		$this->chatMessagesTable = 'chat_messages_all';
		$this->chat_message_notification_all = 'chat_message_notification_all';
	}


	/*
	 * @param $groupData Array of group information such as group_name (user_name for individual user or group name for group of members)
	 * @param $create_by String email id of logged user
	 * if new group create trigger will insert record into mapping table with group id and email id i.e. create_by
	 * @return stdClass object of status and group id and group name
	 */
	public function createGroup($groupData, $create_by, $groupMember)
	{

		$resultObject = new stdClass();
		$resultObject->status = false;
		$group_name = $groupData['group_name'];
		$where = array('group_name' => $group_name, 'status' => 1);
		$groupResult = parent::_select($this->chatGroupTable, $where, array("id", "group_name", "profile_image"));

		if ($groupResult->totalCount > 0) {

			$groupDetails = $groupResult->data;
			$resultObject->status = true;
			$resultObject->groupName = $groupDetails->group_name;
			$resultObject->groupID = $groupDetails->id;
			$resultObject->profile_image = $groupDetails->profile_image;
			$dbGroupMembers = $this->getMember($resultObject->groupID);

			$filterMembers = $this->getUpdatedMembers($dbGroupMembers->data, $groupMember, $resultObject->groupID);
			//print_r($filterMembers);exit;
			try {
				$this->db->trans_start();
				foreach ($filterMembers as $member) {
					//print_r($member);exit;

					$member["group_id"] = $resultObject->groupID;
					$email_id = $member['email_id'];
					$update_mem = $this->db->query("SELECT * FROM chat_group_map_all WHERE group_id='$resultObject->groupID' AND email_id='$email_id'")->num_rows();
					if ($update_mem > 0) {

						$statusDetails1 = array('grp_status' => 1);
						$this->db->set($statusDetails1);
						$this->db->where(array('group_id' => $resultObject->groupID,
							'email_id' => $email_id));
						$this->db->update('chat_group_map_all');
					} else {

						$this->db->insert($this->chatGroupMapTable, $member);
					}
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$resultObject->status = FALSE;
				} else {
					$this->db->trans_commit();
					$resultObject->status = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $ex) {
				$resultObject->status = FALSE;
				$this->db->trans_rollback();
			}
		} else {

			try {
				$this->db->trans_start();
				$result = parent::_insert($this->chatGroupTable, $groupData);
				$resultObject->status = true;
				$resultObject->groupID = $result->inserted_id;
				$resultObject->groupName = $groupData["group_name"];
				$resultObject->profile_image = null;
				$dbGroupMembers = $this->getMember($resultObject->groupID);
				$filterMembers = $this->getUpdatedMembers($dbGroupMembers->data, $groupMember, $resultObject->groupID);
				foreach ($filterMembers as $member) {
					$member["group_id"] = $resultObject->groupID;
					$this->db->insert($this->chatGroupMapTable, $member);
				}
				if ($this->db->trans_status() === FALSE) {
					$this->db->trans_rollback();
					$resultObject->status = FALSE;
				} else {
					$this->db->trans_commit();
					$resultObject->status = TRUE;
				}
				$this->db->trans_complete();
			} catch (Exception $ex) {
				$resultObject->status = FALSE;
				$this->db->trans_rollback();
			}
		}
		return $resultObject;
	}

	public function getUpdatedMembers($dbMembers, $requestedMember, $group_id)
	{
		$members = array();

		if (count($dbMembers) == 0) {
			foreach ($requestedMember as $member) {
				array_push($members, $member);
			}
		} else {
			foreach ($dbMembers as $index => $member) {
				if ($member->group_id == $group_id) {
					foreach ($requestedMember as $r_member) {
						if ($member->email_id == $r_member["email_id"]) {
							continue;
						} else {
							array_push($members, $r_member);
						}
					}
				} else {
					array_push($members, $requestedMember[$index]);
				}
			}
		}

		return $members;
	}


	public function addMembers($memberDetails)
	{
		return parent::_insert($this->chatGroupMapTable, $memberDetails);
	}

	public function updateMember($memberDetails, $mappingID)
	{
		return parent::_update($this->chatGroupMapTable, array('id' => $mappingID), $memberDetails);
	}

	public function removeMember($mappingID)
	{
		return parent::_delete($this->chatGroupMapTable, array('id' => $mappingID));
	}

	public function getMember($groupID)
	{
		return parent::_select($this->chatGroupMapTable, array('group_id' => $groupID), "*", false);
	}

	public function getUserInvolveInGroup($create_by)
	{
		$query = "SELECT m.*,(select group_name from chat_group_all g where g.id=m.group_id and g.type=2 and g.status = 1) as group_name        
                                  FROM chat_group_map_all m  where m.email_id='$create_by' and m.grp_status =1";
		return parent::_rawQuery($query);
	}

	public function getFirmUsers($firmId, $branch_id, $userId="")
	{
		// return parent::_select('user_header_all u',array('firm_id'=>$firmId,'activity_status'=>1,'user_id!='=>$userId),
		// array("u.id","user_name","firm_id","email","(select c.id from chat_group_all c where c.create_by = u.email and type=1) as group_id"),false);
		$query = "select name as user_name,id,user_name as email,user_type as s_type,company_id as firm_id,
		(select id from chat_group_all where users_master.user_name=chat_group_all.create_by AND type=1) as group_id
		from users_master where company_id='$firmId' and branch_id='$branch_id'";
		return parent::_rawQuery($query);
	}
	public function get_group_id($id){
		$query=$this->db->query("select id from chat_group_all where create_by='$id' AND type=1");
		if($this->db->affected_rows() > 0){
			$result=$query->row();
			return $result->id;
		}else{
			return false;	
		}
	}
	public function sendMessage($messageDetails)
	{
		return parent::_insert($this->chatMessagesTable, $messageDetails);
	}

	public function updateNotification($statusDetails, $message_id)
	{
		return parent::_update($this->chat_message_notification_all, $statusDetails, array('message_id' => $message_id));
	}

	/*
	 *  @param Int sender group_id
	 *  @param Int receiver group_id
	 *  @return array of all messages in order of create time with type specify 1 for sender and 0 to receiver
	 */
	public function getMessage($sender_id, $group_id)
	{
		$query = 'select m.id, m.content,m.create_on, case when m.sender_id = ' . $sender_id . ' then 1 else 0 end as type ,m.content_type,m.file_reference,
        (select name from users_master u where user_name = (select create_by from chat_group_all c where c.id=sender_id) group by u.user_name) as sender_name,
(select name from users_master u where user_name = (select create_by from chat_group_all c where c.id=group_id) group by u.user_name) as receiver_name  
from chat_messages_all m where (m.sender_id =' . $sender_id . ' and m.group_id=' . $group_id . ') or (m.sender_id= ' . $group_id . ' and m.group_id=' . $sender_id . ')  order by create_on';

		return parent::_rawQuery($query);
	}

	public function getGroupMessage($group_id, $sender_id)
	{
		$query = 'select m.id, m.content,m.create_on, case when m.sender_id = ' . $sender_id . ' then 0 else case when (SELECT type FROM chat_group_all where id = ' . $group_id . ') =2  then 1 else 0 end end as type ,m.content_type,m.file_reference,
        (select name from users_master u where user_name = (select create_by from chat_group_all c where c.id=sender_id) group by u.user_name) as sender_name,
(select name from users_master u where user_name = (select create_by from chat_group_all c where c.id=group_id) group by u.user_name) as receiver_name  
from chat_messages_all m where m.group_id=' . $group_id . ' order by create_on';
		return parent::_rawQuery($query);
	}

	public function getCountOfUnreadMessages($group_id)
	{
		$query = 'select count(n.id) as count ,m.sender_id as sender from chat_message_notification_all n join chat_messages_all m on n.message_id = m.id where m.group_id = ' . $group_id . ' and n.status =1 group by sender_id';
		//$query = 'select count(n.id) as count ,m.sender_id as sender from chat_message_notification_all n join chat_messages_all m on n.message_id = m.id where m.group_id in (select group_id from chat_group_map_all where email_id ="' . $emailID . '") and n.status =1 group by sender_id';
		return parent::_rawQuery($query);
	}
}
