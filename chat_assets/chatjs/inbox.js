// var username = "Bylancer";
// var Ses_img = "Bylancer.jpg";
// var audioogg = new Audio('audio/chat.ogg');
// var audiomp3 = new Audio('audio/chat.mp3');
let updateTimerInterval = [];

function scrollDown() {
	var wtf = $('.wchat-chat-body');
	var height = wtf[0].scrollHeight;
	wtf.scrollTop(height);
	$(".scroll-down").css({'visibility': 'hidden'});
}

// remote-user-id,remote-username,local-username,remote-group_id,local-group-id
function chatWith(remote_id, remote_name, local_name, remote_group_id, local_group_id, type, profile_image) {
	$("#personName").html('' + remote_name + '');
	$("#userImage").html(`<img class="thumb-lg img-circle" src="${profile_image}" id="PImage" style="width:100%;height:100%;">`);
	$("#UserId").val(remote_id);
	$("#chat_open_user_id").val(remote_group_id);
	let img = 'deven.jpg';
	let status = 'Online';
	if ($("#pane-intro").css('visibility') == 'visible') {
		$("#pane-intro").css({'visibility': 'hidden'});
		$(".chat-right-aside").css({'visibility': 'visible'});
	}
	if ($('#side').is('.open-pnl')) {
		$('#side').removeClass('open-pnl');
	} else {
		$('#side').addClass('open-pnl');
	}
	$($(`#person_status_${remote_group_id}`).children(0)[0]).children('span.count').remove();
	createChatBox(remote_id, remote_name, local_name, remote_group_id, local_group_id, img, status);

	$('.right .top').attr("data-user", remote_name).attr("data-image", img);

	app.showGroupMessages(remote_group_id, local_group_id, type).then(response => {
		let communication = ``;
		removeInterval();
		updateTimerInterval = [];
		communication += response.map((x) => generateCommunication(x, remote_id)).join("");
		$("#" + remote_id).empty();
		$("#" + remote_id).append(communication);
		$(".target-emoji").css({'display': 'none'});
		$('.wchat-filler').css({'height': 0 + 'px'});

		adjustment(100, $(".chatboxtextarea"));
		scrollDown();
	}).catch(error => {
		console.log('error while fetching messages', error);
	});


	//read all message
	app.serverRequest("updateAllUnReadMessageStatus", {
		sender_id: remote_group_id,
		status: 2,
		local_group_id: local_group_id
	}).then(response => {
		console.log(response);
	}).catch(error => console.log(error));

}

function createChatBox(remote_id, remote_name, local_name, remote_group_id, local_group_id, img, status, minimizeChatBox) {
	var chatFormTpl =
		'<div class="block-wchat" id="chatForm_' + remote_id + '">' +
		'<div id="typing_on"></div>' +
		'<button class="icon ti-face-smile font-24 btn-emoji" onclick="javascript:chatemoji()" href="javascript:void(0)" id="toggle-emoji"></button>' +
		'<div tabindex="-1" class="input-container">' +
		'<div tabindex="-1" class="input-emoji">' +
		'<div class="input-placeholder" style="visibility: visible;display:none;">Type a message</div>' +
		`<textarea class="input chatboxtextarea" id="chatboxtextarea" name="chattxt" 
          onkeydown="checkChatBoxInputKey(event,this, '${local_name}' , ${remote_id},${remote_group_id},'${img}',${local_group_id});" contenteditable spellcheck="true" style="resize:none;height:20px" placeholder="Type a message"></textarea>` +
		'</div>' +
		'</div>' +
		`<button onclick="clickTosendMessage('${local_name}', ${remote_id},${remote_group_id},'${img}',${local_group_id});" class="btn-icon  font-24 send-container">
           <i class="fas fa-paper-plane"></i> </button>` +
		'</div>';

	if ($("#" + remote_id).length > 0) {

		$("#chatFrom").html(chatFormTpl);
		$(".chatboxtextarea").focus();
		return;
	}

	$(" <div />").attr("id", remote_id)
		.addClass("tabcontent chat chatboxcontent active-chat")
		.attr("data-chat", "person_" + remote_id)
		.attr("client", remote_name)
		.html('<span class="hidecontent"></span>')
		.appendTo($("#user_messenger_box"));

	if (minimizeChatBox != 1) {
		$("#chatFrom").html(chatFormTpl);
	}


}

// evnet, textarea, local-user,remote-id,img,send,
function checkChatBoxInputKey(event, chatboxtextarea, local_name, remote_id, remote_group_id, img, local_group_id) {

	$(".input-placeholder").css({'visibility': 'hidden'});
	if ((event.keyCode == 13 && event.shiftKey == 0)) {
		filterMessage(chatboxtextarea, remote_id, remote_group_id, local_name, local_group_id);
		return false;
	}
	adjustment(60, chatboxtextarea);
}

function clickTosendMessage(local_name, remote_id, remote_group_id, img, local_group_id) {
	filterMessage($(".chatboxtextarea"), remote_id, remote_group_id, local_name, local_group_id);
	adjustment(40, $(".chatboxtextarea"));
	return false;
}


function filterMessage(chatboxtextarea, remote_id, remote_group_id, local_name, local_id) {
	let message = $(chatboxtextarea).val();
	message = message.replace(/^\s+|\s+$/g, "");

	$(chatboxtextarea).val('');
	$(chatboxtextarea).focus();
	$(".input-placeholder").css({'visibility': 'visible'});
	$(".chatboxtextarea").css('height', '20px');
	let isFile = $('#isFiles').val();
	if (message != '') {
		if (isFile == 1) {
			sendMessage(message, remote_id, remote_group_id, local_name, local_id, 2);
		} else if (isFile == 2) {
			sendMessage(message, remote_id, remote_group_id, local_name, local_id, 3);
		} else {
			sendMessage(message, remote_id, remote_group_id, local_name, local_id, 1);
		}
	} else {
		if (isFile == 1) {

			sendMessage(message, remote_id, remote_group_id, local_name, local_id, 2);
		} else {
			sendMessage(message, remote_id, remote_group_id, local_name, local_id, 3);
		}
	}

}

function sendMessage(message, remote_id, remote_group_id, local_name, local_id, type) {

	message = message.replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/\"/g, "&quot;");
	message = message.replace(/\n/g, "<br />");
	var $con = message;
	var $words = $con.split(' ');
	for (i in $words) {
		if ($words[i].indexOf('http://') == 0 || $words[i].indexOf('https://') == 0) {
			$words[i] = '<a href="' + $words[i] + '">' + $words[i] + '</a>';
		} else if ($words[i].indexOf('www') == 0) {
			$words[i] = '<a href="' + $words[i] + '">' + $words[i] + '</a>';
		}
	}
	message = $words.join(' ');
	message = emojione.shortnameToImage(message);
	let remote_message_number = $("#" + remote_id + " > div").length + 1;
	let file = null;
	let fileMessage = "";
	if (type == 2) {
		file = document.getElementById('uploadImageFile').files[0];
		console.log(file);
		var reader = new FileReader();
		let src = "";
		reader.onload = function (e) {
			$(`#tempFile_${remote_message_number + '_' + remote_id}`)
				.attr('src', e.target.result);
			$(`#anchartempFile_${remote_message_number + '_' + remote_id}`)
				.attr('url', e.target.result);

		};
		reader.readAsDataURL(file);
		fileMessage = `<a url="${base_url}${src}" onclick="trigq(this)" id="anchartempFile_${remote_message_number + '_' + remote_id}" >
                    <img src="${base_url}${src}" alt="${file.name}" id="tempFile_${remote_message_number + '_' + remote_id}" class="userfiles">
                  </a>
                  ${message}
                    `;
	} else if (type == 3) {
		file = document.getElementById('uploadDocFile').files[0];
		console.log(file);
		// var reader = new FileReader();
		let src = "";
		// reader.onload = function (e) {
		// $(`#tempFile_${remote_message_number + '_' + remote_id}`)
		// .attr('src', e.target.result);
		// $(`#anchartempFile_${remote_message_number + '_' + remote_id}`)
		// .attr('href', e.target.result);

		// };
		// reader.readAsDataURL(file);
		fileMessage = `<a href="${base_url}${src}" id="anchartempFile_${remote_message_number + '_' + remote_id}" download>
                    <img src="${base_url + 'chat_assets/storage/user_image/document_image2.png'}" alt="${file.name}" id="tempFile_${remote_message_number + '_' + remote_id}" class="userfiles" style="width:40px;height:40px">
					<span>${file.name}</span></a>
                  ${message}
                    `;
	} else {
		fileMessage = message
	}

	let messageBox = `<div class="col-xs-12 p-b-10 odd">
                                <div class="chat-body">
                                    <div class="chat-text">
                                        <h4>${local_name}</h4>
                                        <p>${fileMessage}</p>                                        
                                            <b id="time_span_${remote_message_number + '_' + remote_id}">Just Now</b>
                                            <span class="msg-status" >
                                                    <i class="far fa-clock" id="check_span_${remote_message_number + '_' + remote_id}"></i>
                                                
                                            </span>
                                    </div>  
                                </div>
                             </div>`;

	$("#" + remote_id).append(messageBox);


	cancelFile();
	app.sendMessage(remote_message_number, remote_group_id, message, file, type).then(response => {
		if (response.status == 200) {
			let filePath = response.imagePath;
			document.getElementById(`time_span_${response.tempId + '_' + remote_id}`).innerText = timeSince(response.time);
			let parent = $(`#check_span_${response.tempId + '_' + remote_id}`)[0].parentNode;
			$(`#check_span_${response.tempId + '_' + remote_id}`).remove();

			parent.innerHTML = `<i class='fas fa-check' id='check_span_${response.tempId + '_' + remote_id}'></i>`;
			$(`#time_span_${response.tempId + '_' + remote_id}`).attr('id', `time_span_m_${response.msg_id}_${remote_id}`);
			$(`#check_span_${response.tempId + '_' + remote_id}`).attr('id', `check_span_m_${response.msg_id}_${remote_id}`);
			$(`#anchartempFile_${response.tempId + '_' + remote_id}`).attr('id', `anchartempFile_${response.msg_id}_${remote_id}`);
			$(`#tempFile_${response.tempId + '_' + remote_id}`).attr('id', `tempFile_${response.msg_id}_${remote_id}`);
			if (filePath) {
				if (response.mtype != 3) {
					$(`#tempFile_${response.msg_id + '_' + remote_id}`)
						.attr('src', base_url + filePath);
				}

				$(`#anchartempFile_${response.msg_id + '_' + remote_id}`)
					.attr('url', base_url + filePath);

			}
			messageDetails = {
				message: message,
				sender_id: local_id,
				time: response.time,
				msg_id: response.msg_id,
				receiver_id: remote_group_id,
				path: filePath,
				type: type
			};
			let remote_userObject = app.findUser(remote_group_id);
			if (remote_userObject != null) {
				if (remote_userObject.online) {
					signalServer.sendToServer({
						type: 'send-message',
						message: {
							connectionId: remote_userObject.connectionId,
							type: 1,
							data: messageDetails,
							group_id: remote_group_id
						}
					})
				}
			} else {
				let remote_GroupObject = app.findGroup(remote_group_id);
				if (remote_GroupObject != null)
					signalServer.sendToServer({
						type: 'send-message',
						message: {type: 2, data: messageDetails, group_id: remote_group_id}
					})
			}


		}
	}).catch(error => console.log(error));

	$(".target-emoji").css({'display': 'none'});
	$('.wchat-filler').css({'height': 0 + 'px'});

	scrollDown();
}

function addRemoteMessages(userName, messageData, receiveTime, remote_group_id, message_id, remote_id, path, type) {
	let message = {
		username: userName,
		data: messageData,
		time: timeSince(receiveTime),
		message_number: message_id,
		remote_id: remote_group_id,
		content_type: type,
		file_reference: path
	};

	let remoteUserMessage = app.remoteMessage(message);
	app.serverRequest("updateMessageStatus", {message_id: message_id, status: 1}).then(response => {
		console.log(response);
	}).catch(error => console.log(error));
	$("#" + remote_id).append(remoteUserMessage);
	$(".target-emoji").css({'display': 'none'});
	$('.wchat-filler').css({'height': 0 + 'px'});

	scrollDown();
	//  adjustment(40, $(".chatboxtextarea")[0]);

}

function adjustment(maxHeight, chatboxtextarea) {
	var adjustedHeight = chatboxtextarea.clientHeight;
	if (maxHeight > adjustedHeight) {
		adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
		if (maxHeight)
			adjustedHeight = Math.min(maxHeight, adjustedHeight);
		if (adjustedHeight > chatboxtextarea.clientHeight)
			$(chatboxtextarea).css('height', adjustedHeight + 8 + 'px');
	} else {
		$(chatboxtextarea).css('overflow', 'auto');
	}
}

function generateCommunication(object, remote_id) {

	if (parseInt(object.type) == 1) {
		// receiver
		let intervalHandler = setInterval(() => {
			updateTime(object.id, remote_id, object.create_on)
		}, 10000);
		updateTimerInterval.push(intervalHandler);
		return app.remoteMessage({
			data: object.content,
			username: object.sender_name,
			remote_id: remote_id,
			time: timeSince(object.create_on),
			message_number: object.id,
			content_type: object.content_type,
			file_reference: object.file_reference
		});
	} else {
		// sender
		let intervalHandler = setInterval(() => {
			updateTime(object.id, remote_id, object.create_on)
		}, 10000);
		updateTimerInterval.push(intervalHandler);
		return app.localMessage({
			data: object.content,
			username: object.sender_name,
			remote_id: remote_id,
			time: timeSince(object.create_on),
			message_number: object.id,
			content_type: object.content_type,
			file_reference: object.file_reference
		});
	}
}

function removeInterval() {
	updateTimerInterval.forEach(e=>{
		clearInterval(e);
	})
}

function updateTime(msgID, remoteID, time) {
	let updateTime = timeSince(time);
	$(`#time_span_${msgID + '_' + remoteID}`).empty();
	$(`#time_span_${msgID + '_' + remoteID}`).append(updateTime);
}


function timeSince(date) {
	date = new Date(date);
	var seconds = Math.floor((new Date() - date) / 1000);

	var interval = seconds / 31536000;

	if (interval > 1) {
		return Math.floor(interval) + " years";
	}
	interval = seconds / 2592000;
	if (interval > 1) {
		return Math.floor(interval) + " months";
	}
	interval = seconds / 86400;
	if (interval > 1) {
		return Math.floor(interval) + " days";
	}
	interval = seconds / 3600;
	if (interval > 1) {
		return Math.floor(interval) + " hours";
	}
	interval = seconds / 60;
	if (interval > 1) {
		return Math.floor(interval) + " minutes";
	}
	return "Just Now";
}
