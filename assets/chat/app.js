let firm_user_array = [];
let group_array = [];
let count_array = [];
let local = JSON.parse(localStorage.getItem("count_array"));
console.log(local);
const app = (function () {
	let local_user = null;
	let local_email = null;
	let local_firm_id = null;
	let local_group_id = null;
	let local_user_id = null;

	const setValues = () => {
		local_user = document.getElementById('user_name').value;
		local_email = document.getElementById('user_email').value;
		local_firm_id = document.getElementById('firm_id').value;
		local_group_id = document.getElementById('group_id').value;
		local_user_id = document.getElementById('user_id').value;
		return {
			userName: local_user,
			email: local_email,
			firmId: local_firm_id,
			groupId: local_group_id,
			userId: local_user_id

		}
	};

	let onlineStatusBox = `<span class="personStatus">
                         <span class="time Online">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                         </span>
                     </span>
                    <br>
                 <small class="preview">Online</small>`
	let offlineStatusBox = `<span class="personStatus">
                         <span class="time Offnline">
                            <i class="fa fa-circle" aria-hidden="true"></i>
                         </span>
                     </span>
                    <br>
                 <small class="preview">Offline</small>`

	const serverRequest = (url, data, type = 1) => {

		return new Promise((resolve, reject) => {

			if (type !== 1) {
				$.ajax({
					type: "POST",
					url: url,
					data: data,
					processData: false,
					contentType: false,
					success: (result) => {
						result = JSON.parse(result);
						resolve(result);
					},
					error: (error) => {
						reject(error);
					}
				});
			} else {
				$.ajax({
					type: "POST",
					url: url,
					data: data,
					success: (result) => {
						result = JSON.parse(result);
						resolve(result);
					},
					error: (error) => {
						reject(error);
					}
				});
			}


		});
	};

	const sendMessageToRemote = (tempID, remote_group_id, message, file = null, type = 1) => {
		var formData = new FormData();
		formData.append('userFile[]', file);
		formData.append('mtype', type);
		formData.append('tempID', tempID);
		formData.append('group_id', remote_group_id);
		formData.append('message', message);
		//{tempID: tempID, group_id: remote_group_id, message: message,userFile:file}
		return serverRequest('sendMessage', formData, 2);
	};

	const showGroupMessages = (remote_group_id, local_group_id = -1, type) => {
		return serverRequest('getMessages', {
			remote_group_id: remote_group_id,
			local_group_id: local_group_id,
			type: type
		});
	};


	const getGroups = () => {
		serverRequest('getGroups', {email_id: local_email}).then(response => {
			$("#user_messenger_box").empty();
			$("#group_list_display").empty();
			response.forEach(group => {
				if (group.group_name !== null) {
					let groupObject = {id: group.id, user_name: group.group_name, group_id: group.group_id, type: 3};
					group_array.push({group_name: group.group_name, group_id: group.group_id, id: group.id});

					let template_chat_row = ``;
					template_chat_row += create_firm_user_template(groupObject);
					let template_message_row = ``;
					template_message_row += create_firm_user_chat_template(groupObject);

					$("#group_list_display").append(template_chat_row);

					$("#user_messenger_box").append(template_message_row);
				}
			});
		});
	}

	const firm_users = async (firmID) => {


		var UserId = $('#User_ID').val();
		serverRequest('getFirmUsers', {firm_id: firmID}).then(async response => {
			firm_user_array = response;
			let template_chat_row = ``;
			template_chat_row += response.map((o) => create_firm_user_template(o, 2)).join("");
			let fav_chat_row = ``;
			fav_chat_row += response.map((o) => create_firm_user_template(o, 1)).join("");
			let template_message_row = ``;
			template_message_row += response.map(create_firm_user_chat_template).join("");
			$("#user_list_display").empty();
			$("#user_list_display").append(template_chat_row);
			$("#fav_list_display").empty();
			$("#fav_list_display").append(fav_chat_row);
			$("#user_messenger_box").empty();
			$("#user_messenger_box").append(template_message_row);


			let localObjectCopy = setValues();
			getGroups();
			getUserOptions();
			getUnReadCount();
			signalServer
				.init_signal(localObjectCopy.userId, localObjectCopy.userName, localObjectCopy.firmId, localObjectCopy.email, localObjectCopy.groupId, group_array, 'join')
		}).catch(error => console.log(error));
	};

	const create_firm_user_template = (object, type) => {

		onlineStatus = offlineStatusBox;
		if (object.type == 3)
			onlineStatus = "";
		if (object.id == local_user_id && local_user_id != null)
			return;
		let profileImage = `${base_url}chat_assets/storage/user_image/avatar_default.png`;
		if (object.group_image != null) {
			profileImage = base_url + object.group_image;
		}

		//if (object.s_type == type)
			return `<li class="person tablinks" 
                                    id="chatbox_${object.id}"
                                    data-chat="person_${object.id}"
                                    href="javascript:void(0)" 
                                    onclick="chatWith(${object.id},'${object.user_name}','${local_user}', ${object.group_id},${local_group_id},${type},'${profileImage}'),openCity(event, ${object.id})">
                                    <a href="javascript:void(0)">
                                        <span class="userimage profile-picture min-profile-picture">
                                        <img src="${profileImage}" alt="avatar" class="avatar-image is-loaded bg-theme" width="100%"></span>
                                        <span class="bname personName">${object.user_name}</span>
                                        <span id="person_status_${object.group_id}">                                           
                                           ${onlineStatus}
                                         </span>
                                    </a>
                                </li>`


	};

	const create_firm_user_chat_template = (object) => {
		return `<div id="${object.id}" class="tabcontent chat chatboxcontent chat_tab_${object.id}" data-chat="person_${object.id}" client="${object.user_name}" style="display:none">
                       
                </div>`;
	};


	const localUserMessageBox = (message) => {
		let fileMessage = "";
		if (message.content_type == 2) {
			fileMessage = `<a url="${base_url}${message.file_reference}" onclick="trigq(this)" id="anchartempFile_${message.message_number + '_' + message.remote_id}" >
                    <img src="${base_url}${message.file_reference}" alt="${message.file_reference}" id="tempFile_${message.message_number + '_' + message.remote_id}" class="userfiles">
                  </a>
                  ${message.data}
                    `;
		} else if (message.content_type == 3) {
			let file_name = message.file_reference;
			let fields = file_name.split('/');
			let street = fields[3];
			fileMessage = `<a href="${base_url}${message.file_reference}" id="anchartempFile_${message.message_number + '_' + message.remote_id}" >
                    <div class="col-sm-2"><img src="${base_url + 'chat_assets/storage/user_image/document_image2.png'}" alt="${message.file_reference}" id="tempFile_${message.message_number + '_' + message.remote_id}" class="userfiles" style="width:40px;height:40px"></div>
                  <div class="col-sm-10" style="word-wrap: break-word;"><span>${street}</span></div></a>
                  ${message.data}
                    `;
		} else {
			fileMessage = message.data;
		}
		return `<div class="col-xs-12 p-b-10 odd" data-msg="${message.message_number}">                    
                    <div class="chat-body">
                        <div class="chat-text">
                            <h4>${message.username}</h4>
                            <p>${fileMessage}</p>
                            <b id="time_span_${message.message_number + '_' + message.remote_id}">${message.time}</b>
                            <span class="msg-status msg-mega"><i class="fa fa-check"></i></span>
                        </div>
                    </div>
                </div>`;
	}

	const remoteUserMessageBox = (message) => {

		let fileMessage = "";
		if (message.content_type == 2) {
			fileMessage = `<a url="${base_url}${message.file_reference}" onclick="trigq(this)" id="anchartempFile_${message.message_number + '_' + message.remote_id}" >
                    <img src="${base_url}${message.file_reference}" alt="${message.file_reference}" id="tempFile_${message.message_number + '_' + message.remote_id}" class="userfiles">
                  </a>
                  ${message.data}
                    `;
		} else if (message.content_type == 3) {
			let file_name = message.file_reference;
			let fields = file_name.split('/');
			let street = fields[3];
			fileMessage = `<a href="${base_url}${message.file_reference}" id="anchartempFile_${message.message_number + '_' + message.remote_id}" >
                    <div class="col-sm-3"><img src="${base_url + 'chat_assets/storage/user_image/document_image2.png'}" alt="${message.file_reference}" id="tempFile_${message.message_number + '_' + message.remote_id}" class="userfiles" style="width:40px;height:40px"></div>
                  <div class="col-sm-9" style="word-wrap: break-word;"><span>${street}</span></div></a>
                  ${message.data}
                    `;
		} else {
			fileMessage = message.data;
		}

		return `<div class="col-xs-12 p-b-10" data-msg="${message.message_number}">                    
                    <div class="chat-body">
                        <div class="chat-text">
                            <h4>${message.username}</h4>
                            <p>${fileMessage}</p>
                            <b id="time_span_${message.message_number + '_' + message.remote_id}">${message.time}</b>                       
                            
                        </div>
                    </div>
                </div>`;
	}

	const findUser = (group_id) => {
		return firm_user_array.findIndex((existingUser) => parseInt(existingUser.group_id) === parseInt(group_id));
	}

	const findGroup = (group_id) => {
		return group_array.findIndex((existingGroup) => parseInt(existingGroup.group_id) === parseInt(group_id));
	}

	const findUserByEmail = (email) => {
		return firm_user_array.findIndex((existingUser) => existingUser.email === email);
	}

	let checkStatusCounter = 0;
	const changeStatus = (object, status) => {

		let id = object.group_id;
		let len = $($(`#person_status_${id}`).children(0)[0]).children('span.count').length;
		let count = 0;
		if (len == 0) {
			count = 0;
		} else {
			count = parseInt($($($(`#person_status_${id}`).children(0)[0]).children('span.count')).children().html());
			count_array.push({id: id, count: count});
			localStorage.setItem("count_array", JSON.stringify(count_array));

		}


		let select_person_status = $(`#chatbox_${object.id} a`).length != 0 ? true : false;
		if (select_person_status) {

			let onlineStatus = status ? onlineStatusBox : offlineStatusBox;
			$(`#chatbox_${object.id} a`).find(`[id="person_status_${id}"]`).html(onlineStatus);
			$(`#chatbox_${object.id} a`).find('[id="person_status_null"]').html(onlineStatus);
			let userIndex = findUser(id);
			if (userIndex !== -1) {
				firm_user_array[userIndex].online = status;
				firm_user_array[userIndex].connectionId = status ? object.connectionId : null;
				if (count == "NaN" || count == 0) {


				} else {
					$($(`#person_status_${id}`).children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">' + count + '</span></span>');

				}
			} else {
				userIndex = findUserByEmail(object.email);

				if (userIndex !== -1) {
					firm_user_array[userIndex].group_id = id;
					firm_user_array[userIndex].online = status;
					firm_user_array[userIndex].connectionId = status ? object.connectionId : null;
					if (count == "NaN" || count == 0) {


					} else {
						$($(`#person_status_${id}`).children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">' + count + '</span></span>');

					}
				} else {
					console.log('user not found with email');
				}
			}

		} else {

			if (id !== local_group_id) {
				let index = firm_user_array.findIndex((existingUser) => parseInt(existingUser.email) === parseInt(object.email));
				if (index != -1) {
					let template_chat_row = create_firm_user_template(object);
					$("#user_list_display").append(template_chat_row);
					let template_message_row = create_firm_user_chat_template(object);
					$("#user_messenger_box").append(template_message_row);
					if (checkStatusCounter == 0) {
						changeStatus(object, true);
					}
				}
			}
		}

	}

	const log = (text) => {
		var now = (window.performance.now() / 1000).toFixed(3);
		console.log(now + " : " + text);
	}
	const getUserObject = (group_id) => {
		let userIndex = findUser(group_id);
		let len = $($(`#person_status_${group_id}`).children(0)[0]).children('span.count').length;
		let count = 0;
		if (len == 0) {
			count = 0;
		} else {
			count = parseInt($($($(`#person_status_${group_id}`).children(0)[0]).children('span.count')).children().html());
		}

		if (userIndex !== -1) {
			return firm_user_array[userIndex];
			if (count == "NaN" || count == 0) {


			} else {
				$($(`#person_status_${group_id}`).children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">' + count + '</span></span>');

			}
		}
		return null;
	}

	const getGroupObject = (group_id) => {
		let groupIndex = findGroup(group_id);
		if (groupIndex !== -1) {
			return group_array[groupIndex];
		}
		return null;
	}

	const getUserOptions = () => {
		if (firm_user_array.length > 0) {
			let option;
			option += firm_user_array.map((object) => {
				return `<option value="${object.email}">${object.user_name}</option>`;
			}).join("");
			// document.getElementById('Users').innerHTML = option;
			$('#Users').append(option);
			$('#Users').select2();
		} else {

		}
	}

	const getUnReadCount = () => {
		serverRequest('getUnReadMessageCount', {group_id: local_group_id}).then(response => {
			if (response.status == 200) {
				response.body.map((e)=>{signalServer.updateCounter({sender_id:e.sender},e.count)}).join("");
			}
		}).catch(e => console.log(e));
	}

	return {
		local_user: local_user,
		local_email: local_email,
		local_firm_id: local_firm_id,
		local_group_id: local_group_id,
		local_user_id: local_user_id,
		getUnReadCount: () => getUnReadCount(),
		getUser: async (firm_id) => await firm_users(firm_id),
		updateStatus: (id, status) => changeStatus(id, status),
		localMessage: (message) => localUserMessageBox(message),
		remoteMessage: (message) => remoteUserMessageBox(message),
		getUserOptions: () => getUserOptions(),
		findUser: (group_id) => getUserObject(group_id),
		findGroup: (group_id) => getGroupObject(group_id),
		setValues: () => setValues(),
		showGroupMessages: (remote_id, local_id, type) => showGroupMessages(remote_id, local_id, type),
		sendMessage: (tempID, group_id, message, file, type) => sendMessageToRemote(tempID, group_id, message, file, type),
		serverRequest: (url, data, type) => serverRequest(url, data, type),
		log: (text) => log(text),
		getGroups: () => group_array,

	};


})();


