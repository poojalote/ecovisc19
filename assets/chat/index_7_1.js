const signalServer = (function () {
	let socket = null;
	let userObject = {isOnline: false};
	let roomUsers = [];
	let localconnectionName = null;
	const socket_url = 'https://chat.docango.com/';
	let permission = Notification.permission;

	navigator.serviceWorker.register('sw.js');
	const showNotification = (title, body) => {
		let icon = "https://rmt.docango.com/assets/images/ecovis.png";
		if (permission === "granted") {
			if (document.visibilityState === "visible") {
				return;
			}
			Notification.requestPermission(function (result) {
				if (result === 'granted') {
					navigator.serviceWorker.ready.then(function (registration) {
						registration.showNotification(title, {body, icon})
						console.log(registration);
						registration.getNotifications().then(function (notifications) {
							notifications.forEach(n => {
								console.log(n);
								n.onclick = (event) => {
									event.preventDefault(); // prevent the browser from focusing the Notification's tab
									// console.log(event);
									// console.log(event);
									// event.notification.close();
									// console.log('notification click evnet');
									// n.close();
									// window.parent.focus();
								}
							})

						})

					});
				}
			});
		} else if (permission === "default") {
			requestAndShowPermission();
		}
	};

	const requestAndShowPermission = () => {
		Notification.requestPermission(function (notificationPermission) {
			permission = notificationPermission;
		});

	}

	const init_signal_server = (id, userName, firm_id, email_id, group_id, groups, type) => {

		socket = io(socket_url);
		localconnectionName = group_id;
		socket.on("connect", function () {
			console.log('*** Connected To Chat Server ***');
			userObject.connectionId = socket.id;
			userObject.isOnline = true;
			initUserObject(id, userName, firm_id, email_id, group_id, groups, type)
		});

		socket.on('receiveFromServer', async function (response) {
			response = JSON.parse(response);
			switch (response.type) {
				case 'new-user':
					console.log(response.data.user_name + " is online");
					connectUser(response.data)
					break;
				case 'remove-user':
					disconnectUser(response.data);
					await Peer.hangUp(response.data.group_id);
					break;
				case "new-message":
					console.log('new-message', response.data);
					remoteUserMessage(response.data, response.category);
					break;
				case 'online-user':
					console.log('online-user', response.data);
					updateAllUserStatus(response.data)
					break;
				case 'peer':
					await Peer.saveMessage(response);
					break;
				case 'new-room-user':
					console.log("*** new user connecte to room ***");
					if (userObject.firmId == response.data.firmId)
						await startVideoCall(response.data.group_id, localconnectionName);

					break;
				case 'hangup':
					await Peer.hangUp(1);
					break;
				case 'candidate-done':
					app.log("All candidate Reciever from remote user");
					await Peer.proccesIce();
					break;
				case 'inactive-tab':
					console.log('inactive-tab');
					break;
			}
		});
		return 1;
	};

	/*
		add remote user into ui
	 */
	const remoteUserMessage = (message, category) => {
		//userName, messageData, receiveTime, remote_id, message_id
		//{message:message,sender_id:local_id,time:response.time,msg_id:response.msg_id,receiver_id:remote_group_id};
		if (category == 1) {
			let user = app.findUser(message.sender_id);
			if (user) {
				console.log(user, message);
				showNotification(user.user_name, message.message);
				addRemoteMessages(user.user_name, message.message, message.time, message.sender_id, message.msg_id, user.id, message.path, message.type);
				if (!$(`#${user.id}`).is(":visible"))
					if ($($(`#person_status_${message.sender_id}`).children(0)[0]).children('span.count').length == 0) {
						$($(`#person_status_${message.sender_id}`).children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">1</span></span>');
						let item = $($(`#person_status_${message.sender_id}`)[0].parentNode)[0].parentNode;
						let ul_item = $($($(`#person_status_${message.sender_id}`)[0].parentNode)[0].parentNode)[0].parentNode;
						let attr_ul=$($($($(`#person_status_${message.sender_id}`)[0].parentNode)[0].parentNode)[0].parentNode).attr('data-section');
						let item_position = $(item).index();
						
						$("#user_list_display li:eq(0)").before($("#user_list_display li:eq(" + item_position + ")"));
						
						
						if(attr_ul == 'favourite')
						{
							
							if($($("#fav_msg_count").children(0)[0]).children('span.count').length == 0){
							$($("#fav_msg_count").children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">1</span></span>');
							}
							else{
								let count = parseInt($($($("#fav_msg_count").children(0)[0]).children('span.count')).children().html());
								count++;
								$($($("#fav_msg_count").children(0)[0]).children('span.count')).children().html(count);
							}
						}
						else if(attr_ul == 'groups')
						{
							if($($("#grp_msg_count").children(0)[0]).children('span.count').length == 0){
							$($("#grp_msg_count").children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">1</span></span>');
							}
							else{
								let count = parseInt($($($("#grp_msg_count").children(0)[0]).children('span.count')).children().html());
								count++;
								$($($("#grp_msg_count").children(0)[0]).children('span.count')).children().html(count);
							}
						}
						else {
							if($($("#user_msg_count").children(0)[0]).children('span.count').length == 0){
							$($("#user_msg_count").children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">1</span></span>');
							}
							else{
								let count = parseInt($($($("#user_msg_count").children(0)[0]).children('span.count')).children().html());
								count++;
								$($($("#user_msg_count").children(0)[0]).children('span.count')).children().html(count);
							}
						}
						
					} else {
						let count = parseInt($($($(`#person_status_${message.sender_id}`).children(0)[0]).children('span.count')).children().html());
						count++;
						$($($(`#person_status_${message.sender_id}`).children(0)[0]).children('span.count')).children().html(count);
						let item = $($(`#person_status_${message.sender_id}`)[0].parentNode)[0].parentNode;
						let ul_item = $($($(`#person_status_${message.sender_id}`)[0].parentNode)[0].parentNode)[0].parentNode;
						let attr_ul=$($($($(`#person_status_${message.sender_id}`)[0].parentNode)[0].parentNode)[0].parentNode).attr('data-section');
						let item_position = $(item).index();
						$("#user_list_display li:eq(0)").before($("#user_list_display li:eq(" + item_position + ")"));
						//$("#msg_count").append('<span class="count"><span class="icon-meta unread-count">' + count + '</span></span>');
						
					}
					
					

			} else {
				console.log('user not found');
			}
		} else {
			let group = app.findGroup(message.receiver_id);
			if (group) {
				let user = app.findUser(message.sender_id);
				console.log(group, user, message);
				showNotification(group.group_name + " by " + user.user_name, message.message);
				addRemoteMessages(user.user_name, message.message, message.time, message.receiver_id, message.msg_id, group.id, message.path, message.type);
				// if (!$(`#${user.id}`).is(":visible"))
				//     if ($($(`#person_status_${message.receiver_id}`).children(0)[0]).children('span.count').length == 0) {
				//         $($(`#person_status_${message.receiver_id}`).children(0)[0]).append('<span class="count"><span class="icon-meta unread-count">1</span></span>');
				//         let item = $($(`#person_status_${message.receiver_id}`)[0].parentNode)[0].parentNode;
				//         let item_position=$(item).index();
				//         $("#user_list_display li:eq(0)").before($("#user_list_display li:eq("+item_position+")"));
				//     } else {
				//         let count = parseInt($($($(`#person_status_${message.receiver_id}`).children(0)[0]).children('span.count')).children().html());
				//         count++;
				//         $($($(`#person_status_${message.receiver_id}`).children(0)[0]).children('span.count')).children().html(count);
				//         let item = $($(`#person_status_${message.receiver_id}`)[0].parentNode)[0].parentNode;
				//         let item_position=$(item).index();
				//         $("#user_list_display li:eq(0)").before($("#user_list_display li:eq("+item_position+")"));
				//     }
			}
		}


	}

	/*
		update all online user status
	 */
	const updateAllUserStatus = (userList) => {
		userList.forEach(user => {
			connectUser(user);
		});
	};

	/*
		request to get all online user
	 */
	const getOnlineUser = (firmId, email_id) => {
		console.log('**** Request For Online User list with Firm id :' + firmId + ' and email id : ' + email_id);
		socket.emit('sendToServer', JSON.stringify({
			type: 'online-user',
			userObject: {connectionId: userObject.connectionId, firmID: userObject.firmId, email: email_id}
		}));
	}

	/*
	   new user add into local array and update its status on ui
	 */
	const connectUser = (remoteUser) => {
		let isUserExists = roomUsers.findIndex((existingUser) => remoteUser.connectionId === existingUser.connectionId);
		if (isUserExists === -1) {
			roomUsers.push(remoteUser);
		}
		app.updateStatus(remoteUser, true);
		if (remoteUser.group_id != null || remoteUser.group_id != undefined) {
			if ($(`#person_status_${remoteUser.group_id}`)[0]) {
				let item = $($(`#person_status_${remoteUser.group_id}`)[0].parentNode)[0].parentNode;
				let item_position = $(item).index();
				$("#user_list_display li:eq(0)").before($("#user_list_display li:eq(" + item_position + ")"));
				
				
			}
		}
	};

	/*
		discconnect user remove from array and update its ui status as offline
	 */
	const disconnectUser = (remoteUser) => {
		console.log('disconnection Id', remoteUser);
		let isUserExists = roomUsers.findIndex((existingUser) => remoteUser.connectionId === existingUser.connectionId);
		if (isUserExists !== -1) {
			app.updateStatus(remoteUser, false);
			const object = roomUsers[isUserExists];
			console.log(object);
			roomUsers.splice(object, 1);
			console.log(remoteUser.user_name + " is leave ");
			getOnlineUser(app.local_firm_id, app.local_email);
		}
	};

	const emitServerEvent = (responseObject) => {
		responseObject.userObject = userObject;
		socket.emit("sendToServer", JSON.stringify(responseObject));
	}

	/*
		set user details and send to server.
	 */
	const initUserObject = (id, userName, firm_id, email_id, group_id, groups, type) => {
		userObject.firmId = firm_id;
		userObject.user_name = userName;
		userObject.email = email_id;
		userObject.group_id = group_id;
		userObject.id = id;
		userObject.groups = groups;
		socket.emit('sendToServer', JSON.stringify({type: type, userObject: userObject}));
		console.log('*** Send Local User Data To Server ***', userObject);
		if (type == "join")
			getOnlineUser(firm_id, email_id);
	}

	return {
		local_user: userObject,
		init_signal: (id, userName, firm_id, email_id, group_id, groups, type) => init_signal_server(id, userName, firm_id, email_id, group_id, groups, type),
		getOnlineUser: (f, excludeUserId) => getOnlineUser(f, excludeUserId),
		sendToServer: (object) => emitServerEvent(object),
		remoteUserMessage: (message) => remoteUserMessage(message),

	}
})();
// let userName = document.getElementById('user_name').value;
// let firmID = document.getElementById('firm_id').value;
// let groupID = document.getElementById('group_id').value;
// let emailID = document.getElementById('email_id').value;


// signalServer.init_signal();
// signalServer.set_user(userName,firmID,groupID,emailID);

