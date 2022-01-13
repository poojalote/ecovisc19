const Peer = (function () {

	const selfVideo = document.querySelector("video#selfVideo");
	const remoteVideo = document.querySelector("video#remoteVideo");
	const remoteAudio = document.querySelector("audio#remoteAudio");
	const hangUp = document.querySelector("#hangUp");
	let availbelDevices = [];
	let devicePointer = 0;

	let makingOffer = false;
	let localStream, remoteVideoStream, remoteAudioStream, localScreenShareStream;
	let peerConnection;

	let targetUser = null;
	let senderUser = null;
	let isInitiator = null;
	let isStart = false;
	let messageQueue = [];
	let waitingCallMessageQueue = [];
	let hasRemoteSdp_ = false;

	let isOffer = false;
	let isAnwser = false;
	let isProcessIce = false;
	let isOncall = false;

	const constraints = {
		audio: true,
		video: true,
	};
	//turn:13.127.109.34:3478
	//turn:65.0.87.149:3478
	// 13.233.154.202
	const config = {
		iceServers: [
			 // {urls: "stun:stun1.l.google.com:19302"},
			 //  {urls: "stun:stun2.l.google.com:19302"},
			 //   {urls: "stun:stun3.l.google.com:19302"},
			//{urls: "stun:13.232.72.235:3478"},
		//	{urls: "stun:65.0.87.149:3478"},
			{
				urls: "turn:13.233.154.202:3478?transport=tcp",
				username: "admin",
				credential: "admin",
			},
			{
				urls: "turn:13.233.154.202:3478?transport=udp",
				username: "admin",
				credential: "admin",
			},
			// {
			// 	urls: "turn:65.0.87.149:3478",
			// 	username: "admin",
			// 	credential: "admin",
			// },

		],
		bundlePolicy: "max-bundle",
		iceTransportPolicy: "all",
		rtcpMuxPolicy: "require",
		iceCandidatePoolSize: 20,
	};

	let isAudio = true;

	const muteAudio = () => {
		isAudio = !isAudio;
		localStream.getAudioTracks()[0].enabled = isAudio;

		if (!isAudio) {
			document.getElementById('audio-icon').classList.remove('fa-microphone');
			document.getElementById('audio-icon').classList.add('fa-microphone-slash');
		} else {
			document.getElementById('audio-icon').classList.remove('fa-microphone-slash');
			document.getElementById('audio-icon').classList.add('fa-microphone');
		}
	};

	let isVideo = true;

	const muteVideo = () => {
		isVideo = !isVideo;
		localStream.getVideoTracks()[0].enabled = isVideo;
		if (!isVideo) {
			document.getElementById('video-icon').classList.remove('fa-video');
			document.getElementById('video-icon').classList.add('fa-video-slash');
		} else {
			document.getElementById('video-icon').classList.remove('fa-video-slash');
			document.getElementById('video-icon').classList.add('fa-video');
		}
	}
	// let candidates = {};
	const _init = (_targetUser, _senderUser, type) => {
		hangUp.disabled = false;
		targetUser = _targetUser;
		senderUser = _senderUser;
		// if (type == 1) {
		//     $('#wchat').css("display", "none");
		//     $('#videoBox').css("display", "flex");
		// }


		return new Promise((resolve, reject) => {

			if (peerConnection) {
				app.log("*** Already have peer connection ***")
				reject();
				return;
			}

			peerConnection = new RTCPeerConnection(config);
			peerConnection.ontrack = (event) => {
				app.log("*** Remote Stream is Available");
				$('#videoCall').modal('hide');
				$('#wchat').css("display", "none");
				$('#videoBox').css("display", "flex");

				//remoteVideo.srcObject = event.streams[0];
				if (!remoteVideoStream) {
					remoteVideoStream = new MediaStream();
				}
				if (!remoteAudioStream) {
					remoteAudioStream = new MediaStream();
				}

				//
				if (event.track.kind == "video") {
					remoteVideoStream
						.getVideoTracks()
						.forEach((t) => remoteVideoStream.removeTrack(t));
					remoteVideoStream.addTrack(event.track);
					remoteVideo.srcObject = null;
					remoteVideo.srcObject = remoteVideoStream;
					remoteVideo.load();

				} else if (event.track.kind == "audio") {
					remoteAudioStream
						.getVideoTracks()
						.forEach((t) => remoteAudioStream.removeTrack(t));
					remoteAudioStream.addTrack(event.track);

					remoteAudio.srcObject = null;
					remoteAudio.srcObject = remoteAudioStream;
					remoteAudio.load();

				}
			}

			peerConnection.onicecandidateerror = (event) => {
					console.log(event.url, event.errorText);
			}

			peerConnection.oniceconnectionstatechange = () => {
				app.log("*** ICE connection state changed to " + peerConnection.iceConnectionState);
				switch (peerConnection.iceConnectionState) {
					case "closed":
					case "failed":
					case "disconnected":
						//peerConnection.restartIce();
						restart();
						break;
				}
			};
			peerConnection.onnegotiationneeded = (e) => {
				console.log("*** negotiations event ***", e)
			}
			let myCandidateTimeout = null;
			peerConnection.onicecandidate = (event) => {
				candidate = event.candidate;
				// if (candidate) {
					if (myCandidateTimeout != null)
						clearTimeout(myCandidateTimeout);

					myCandidateTimeout = setTimeout(event.ready, 5000);
					signalServer.sendToServer(
						{
							sender: senderUser,
							target: targetUser,
							type: 'candidate',
							candidate: candidate
						}
					);
					console.log(JSON.stringify(candidate));
					app.log("Send Candidate To Remote User");
				// } else {
					signalServer.sendToServer(
						{
							sender: senderUser,
							target: targetUser,
							type: 'candidate-done',
						}
					);
					app.log("End of candidates.");
				// }
			}

			peerConnection.onicegatheringstatechange = () => {
				app.log("*** ICE gathering state changed to: " + peerConnection.iceGatheringState);
				switch (peerConnection.iceGatheringState) {
					case "disconnected":
					case "failed":
						//peerConnection.restartIce();
						restart();
						break;
				}
			};

			peerConnection.onsignalingstatechange = () => {
				app.log("*** WebRTC signaling state changed to: " + peerConnection.signalingState);

				switch (peerConnection.signalingState) {
					case "disconnect":
					case "failed":
						//peerConnection.restartIce();
						restart();
						break;
				}
			}
			isInitiator = false;
			resolve();
		});
	};

	const restart = async () => {
		isOffer = false;
		isAnwser = false;
		createOffer(2);
	}

	const createOffer = async (type = 1) => {
		try {
			if (!peerConnection) {
				app.log('Error :  peer conncetion not available while offer creation');
				return false;
			}
			const DEFAULT_SDP_OFFER_OPTIONS_ = {
				offerToReceiveAudio: true,
				offerToReceiveVideo: true,
				voiceActivityDetection: false,

			}

			if (type == 1) {
				if (isStart) {
					app.log('Error :  Call already Started');
					return false;
				}

			} else {
				DEFAULT_SDP_OFFER_OPTIONS_.iceRestart = true;
			}


			let offer = await peerConnection.createOffer(DEFAULT_SDP_OFFER_OPTIONS_);
			if (peerConnection.signalingState != "stable") {
				app.log("--> The connection isn't stable yet; postponing...")
				//return;
			}
			console.log('Offer Constraint : ', DEFAULT_SDP_OFFER_OPTIONS_);

			await peerConnection.setLocalDescription(offer);
			isInitiator = true;
			isStart = true;
			signalServer.sendToServer(
				{
					sender: senderUser,
					target: targetUser,
					type: 'offer',
					description: peerConnection.localDescription
				})
			app.log("*** offer  SDP ");
			console.log(offer);
			app.log("*** send to remote user ***");
		} catch (e) {
			app.log("Error : The following error occurred while handling the negotiationneeded event:");
			console.log('Error in negotiation : ', e)
		}
	};

	let rtpVideoSender = null;
	let rtpAudioSender = null;
	const addStream = async () => {
		if (!peerConnection) {
			app.log('*** peer connection not available ***');
			return;
		}

		// video
		if (rtpVideoSender && rtpVideoSender.track) {
			let localVideoTrack = localStream.getVideoTracks()[0];
			if (localVideoTrack)
				rtpVideoSender.replaceTrack(localVideoTrack);
		} else {
			if (!localStream) {
				app.log("localStream No available now call start()");
				await _start();
			}
			let localVideoTrack = localStream.getVideoTracks()[0];
			if (localVideoTrack)
				rtpVideoSender = peerConnection.addTrack(localVideoTrack);
		}
		// audio track
		if (rtpAudioSender && rtpAudioSender.track) {
			localStream.getAudioTracks()[0].enabled = isAudio;
			let localAudioTrack = localStream.getAudioTracks()[0];
			if (localAudioTrack)
				rtpAudioSender.replaceTrack(localAudioTrack);
		} else {
			if (!localStream)
				await _start();
			localStream.getAudioTracks()[0].enabled = isAudio;
			let localAudioTrack = localStream.getAudioTracks()[0];
			if (localAudioTrack)
				rtpAudioSender = peerConnection.addTrack(localAudioTrack);
		}
		app.log('*** add local stream into peer connection ***')

	};

	const _setCallee = async () => {
		if (peerConnection) {
			console.log('Error: peer connection already started')
			return false;
		}

		if (isStart) {
			console.log('Error: video call already started')
			return false;
		}
		$('#remoteModalStatus').empty();
		$('#remoteModalStatus').append('connecting to call');
		isInitiator = false;
		isStart = true;

		console.log('Messeage in Queue : ' + messageQueue.length);
		if (messageQueue.length > 0) {
			console.log('Start Proccessing Queue after accept call');
			for (const data of messageQueue) {
				await _peerMessage(data);
			}
		}
		$('#videoCall').modal('hide');

	}
	const shareScreen = async () => {
		try {
			localStream = await navigator.mediaDevices.getDisplayMedia({
				video: true,
				audio: false
			});
			await addStream();
			console.log('Start Share Screen');
			localStream.oninactive = async e => {
				app.log("inactive screen");
				await _start();
				await addStream();
			};
		} catch (e) {
			console.log('Error While ShareScreen : ', e);
		}
	}


	let isJoin = false;
	const pushIntoQueue = async (message) => {


		if (message.sender != null && message.target != null) {
			if (!isOncall) {
				// new call details
				if (message.description) {
					if ((isInitiator && message.description.type === 'answer') ||
						(!isInitiator && message.description.type === 'offer')) {
						hasRemoteSdp_ = true;
						if (message.description.type === 'offer')
							isOffer = false;
						
						if( message.description.type === 'answer')
							isAnwser = false;
						messageQueue.unshift(message);
						console.log('Recived offer/answer Message From Remote : ', JSON.stringify(message.description));
					}
				} else {
					messageQueue.push(message);
					console.log('Recived Candidate Message From Remote : ', JSON.stringify(message.candidate));
				}
			} else {
				if (message.sender == app.local_group_id) {
					// on going call details
					if (message.description) {
						if ((isInitiator && message.description.type === 'answer') ||
							(!isInitiator && message.description.type === 'offer')) {
							hasRemoteSdp_ = true;
							app.log("*** on going call details new message from remote user type is " + message.description.type);
							messageQueue.unshift(message);
						}
					} else {
						app.log("*** on going call details new message from remote user of type is candidate");
						messageQueue.push(message);
					}
				} else {
					// other call request details
					if (message.description) {
						if ((isInitiator && message.description.type === 'answer') ||
							(!isInitiator && message.description.type === 'offer')) {
							// hasRemoteSdp_ = true;
							waitingCallMessageQueue.unshift(message);
						}
					} else {
						waitingCallMessageQueue.push(message);
					}
					if (message.sender != null && message.target != null) {
						let user = app.findUser(message.sender);
						if (user != null) {
							$('#remoteUserName').empty();
							$('#remoteUserName').append(user.user_name);
						} else {
							$('#remoteUserName').empty();
							$('#remoteUserName').append("unknown");
						}

						$('#videoCall').modal('show');
						isJoin = true;
					}
				}
			}

		}


		if (!peerConnection || !hasRemoteSdp_ || !isStart) {
			return;
		}

		if (messageQueue.length > 0) {

			if (isInitiator && isProcessIce) {
				console.log("*** Process Message Queue")
				await _peerMessage(message);
			} else if (!isInitiator && isStart) {
				for (const data of messageQueue) {
					await _peerMessage(data);
				}
				app.log('message Queue fired...');
			}


		}

	}

	const getCameraDevices = async () => {
		await navigator.mediaDevices.enumerateDevices().then((devices) => {
			availbelDevices = [];
			devices.forEach(device => {
				if (device.kind === 'videoinput') {
					availbelDevices.push(device);
				}
			});
		}).catch(e => {
			app.log("*** Error while getting device info", e);
		});
	};

	const switch_camera = async () => {

		if (availbelDevices.length > devicePointer && availbelDevices.length > 1) {
			devicePointer++;
			if (devicePointer >= availbelDevices.length) {
				devicePointer = 0;
			}
			await _start();
			await addStream();
		} else {
			devicePointer = 0;
			app.log("reset camera");
			await _start();
			await addStream();
		}
	};

	const _start = async () => {
		try {
			await getCameraDevices();
			app.log('*** local stream started ***')
			if (localStream) {
				localStream.getTracks().forEach(track => {
					track.stop();
				});
			}
			if (devicePointer == 0) {
				console.log("Local Stream Constraints : ", constraints);
				localStream = await navigator.mediaDevices.getUserMedia(constraints);
				if(localStream){
					selfVideo.srcObject = localStream;
				}else{
					alert("Check Camera Permission")
				}

			} else {
				app.log("Video Device ID : " + availbelDevices[devicePointer].deviceId);
				constraintValues = {
					audio: true,
					video: {
						deviceId: availbelDevices[devicePointer].deviceId
					}
				};
				localStream = await navigator.mediaDevices.getUserMedia(constraintValues);
				if(localStream){
					selfVideo.srcObject = localStream;
				}else{
					alert("Check Camera Permission")
				}
			}

		} catch (e) {
			app.log('Error in Start Function', e.name);
			if(e.name === 'NotAllowedError'){
				alert("Check Camera Permission");
				hangUpOperation();
			}
			if (e.name !== 'NotFoundError') {
				return;
			}


			var mediaConstraints = {
				"audio": true,
				"video": {"optional": [{"minWidth": "1280"}, {"minHeight": "720"}], "mandatory": {}}
			};
			navigator.mediaDevices.enumerateDevices()
				.then(function (devices) {
					var cam = devices.find(function (device) {
						return device.kind === 'videoinput';
					});
					var mic = devices.find(function (device) {
						return device.kind === 'audioinput';
					});
					var constraints = {
						video: cam && mediaConstraints.video,
						audio: mic && mediaConstraints.audio
					};
					return navigator.mediaDevices.getUserMedia(constraints);
				}).then((stream) => {
				app.log('Got access to local media');
				if(stream){
					localStream = stream;
				}else{
					alert("Check Camera Permission")
				}


			}).catch(error=>{
				alert("Camera Permission Missing")
			});

		}
	}

	const _peerMessage = async (data) => {
		try {
			// app.log("*** on messsage Data from " + data.sender + " to " + data.target + " :  " ,data);
			if (!peerConnection) {
				console.log('Peer Connection not availble required to init process');
				await _init(data.sender, data.target);
			}
			if (data.description) {

				if (data.description.type == "offer" && !isInitiator && !isOffer) {
					console.log("Start Processing of Offer SDP");
					if (peerConnection.signalingState != "stable") {
						app.log('*** connection is not stable wait for promise completion')
						await Promise.all([
							peerConnection.setLocalDescription({type: "rollback"}),
							peerConnection.setRemoteDescription(data.description)
						]);
						return;
					} else {
						console.log('Add SDP in Remote Decription');
						await peerConnection.setRemoteDescription(data.description);
					}
					if (!localStream) {
						console.log('Required for local video stream');
						await _start();
						await addStream();
					}
					console.log("Create New Anser");
					let answer = await peerConnection.createAnswer();
					await peerConnection.setLocalDescription(answer);
					console.log('Set to local Decription');
					isOffer = true;
					signalServer.sendToServer(
						{
							target: data.sender,
							sender: data.target,
							type: 'answer',
							description: peerConnection.localDescription
						})
					messageQueue.splice(data, 1);
					app.log('Remove offer message from queue');
					app.log(JSON.stringify(peerConnection.localDescription));
					app.log("**** send anwser to remote user");
				} else if (data.description.type == "answer" && isInitiator && isAnwser == false) {
					console.log('Proccess the answer SDP')
					if (peerConnection.signalingState !== 'have-local-offer' || peerConnection.signalingState == 'stable') {
						app.log("ERROR: remote answer received in unexpected state:" + peerConnection.signalingState);
						return;
					}
					try {
						console.log('set Answer to Remote Description')
						await peerConnection.setRemoteDescription(data.description);
						app.log("*** Call recipient has accepted our call");
						messageQueue.splice(data, 1);
						app.log('Remove answer message from queue');
						isAnwser = true;
						// if (messageQueue.length > 0) {
						// 	app.log('message Queue fired from answer section ...');
						// 	for (const data1 of messageQueue) {
						// 		await _peerMessage(data1);
						// 	}
						// }
					} catch (e) {
						app.log('error in Answer message', e);
					}
				}
			} else if (data.candidate) {
				try {
					if (peerConnection.signalingState == 'stable') {
						app.log("anwser set status is " + isAnwser);
						await peerConnection.addIceCandidate(data.candidate);
						app.log("*** ICE Candidate is added");
						messageQueue.splice(data, 1);
						app.log('Remove candidate message from queue');
					} else {
						app.log("*** While Adding remote ICE candidate SignalingSate : " + peerConnection.signalingState + " and remote description status" + isAnwser);
					}
				} catch (err) {
					throw err;
				}
			}

		} catch (e) {
			app.log('error in peer message', e);
		}
	}

	const hangUpOperation = async (type = 0) => {
		app.log("End Call...");
		if (peerConnection) {
			if (type !== 0) {
				if (type == app.local_group_id || type == 1) {
					await peerConnection.close();
					hangUp.disabled = true;
					window.location.href = 'https://covidcare.docango.com/chat';
				}
			}
			if (type == 0) {
				await peerConnection.close();
				hangUp.disabled = true;
				signalServer.sendToServer({
					target: targetUser,
					sender: senderUser,
					type: 'hangup'
				});
				window.location.href = 'https://covidcare.docango.com/chat';
			}

		}

	}

	const filterIceCandidate = (candidateObj) => {
		var candidateStr = candidateObj.candidate;

		// Always eat TCP candidates. Not needed in this context.
		if (candidateStr.indexOf('tcp') !== -1) {
			return false;
		}

		// If we're trying to eat non-relay candidates, do that.
		if (iceCandidateType(candidateStr) !== 'relay') {
			return false;
		}

		return true;
	}

	const iceCandidateType = (candidateStr) => {
		return candidateStr.split(' ')[7];
	};

	const proccesIce = async () => {
		if (!isInitiator) {
			if (!isJoin) {
				let message = messageQueue[0];
				let user = app.findUser(message.sender);
				if (user != null) {
					$('#remoteUserName').append(user.user_name);
				} else {
					$('#remoteUserName').append("unknown");
				}

				$('#videoCall').modal('show');
				isJoin = true;
			}
		} else {
			if (isStart) {
				app.log("*** Procces the queue messages from processIce() of lenght " + messageQueue.length);
				for (const data of messageQueue) {
					await _peerMessage(data);
				}
			}
		}

		isProcessIce = true;
	}

	return {
		isProcessIce: isProcessIce,
		init: (targetUser, senderUser, type) => _init(targetUser, senderUser, type),
		startLocalVideo: async () => await _start(),
		createOffer: () => createOffer(),
		addStream: async () => await addStream(),
		onMessage: (response) => _peerMessage(response),
		onMuteAudio: () => muteAudio(),
		onMuteVideo: () => muteVideo(),
		setCallee: async () => await _setCallee(),
		saveMessage: (message) => pushIntoQueue(message),
		hangUp: (type) => hangUpOperation(type),
		switch_camera: () => switch_camera(),
		shareScreen: () => shareScreen(),
		proccesIce: () => proccesIce()
	}


})();
