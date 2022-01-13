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
    let finishSDPVideoOfferOrAnswer = false;
    let isOffer = false;
    let isAnwser = false;
    let isProcessIce = false;
    let isOncall = false;

    const constraints = {
        audio: true,
        video: true,
    };

    const config = {
        iceServers: [
            //	{urls: "stun:65.0.87.149:3478"},
            //{urls: "stun:13.127.109.34:3478"},
            {
                urls: "turn:65.0.87.149:3478",
                username: "admin",
                credential: "admin",
            },
			{urls: "stun:65.0.87.149:3478"},
            // {
            // 	urls: "turn:13.127.109.34:3478",
            // 	username: "admin",
            // 	credential: "admin",
            // },
        ],
		// bundlePolicy: "max-bundle"
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

        return new Promise((resolve, reject) => {

            if (peerConnection) {
                app.log("*** Already have peer connection ***")
                reject();
                return;
            }

            peerConnection = new RTCPeerConnection(config);

            peerConnection.ontrack = (event) => {
                // if(event.streams[0].length > 0 &&
                // 	event.streams[0].getVideoTracks().length > 0){
                // 	app.log("*** Remote Stream is Available");
                // 	$('#videoCall').modal('hide');
                // 	$('#wchat').css("display", "none");
                // 	$('#videoBox').css("display", "flex");
                // }

                if (!remoteVideoStream) {
                    remoteVideoStream = new MediaStream();
                }
                if (!remoteAudioStream) {
                    remoteAudioStream = new MediaStream();
                }

                if (event.track.kind == "video") {
                    remoteVideoStream
                        .getVideoTracks()
                        .forEach((t) => remoteVideoStream.removeTrack(t));
                    remoteVideoStream.addTrack(event.track);
                    remoteVideo.srcObject = null;
                    remoteVideo.srcObject = remoteVideoStream;
                    remoteVideo.load();
                    if (remoteVideoStream.getVideoTracks().length > 0) {
                        $('#videoCall').modal('hide');
                        $('#wchat').css("display", "none");
                        $('#videoBox').css("display", "flex");
                    } else {
                        app.log("Waiting For Remote Video");
                    }

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


            peerConnection.oniceconnectionstatechange = () => {
                app.log("*** ICE connection state changed to " + peerConnection.iceConnectionState);
                switch (peerConnection.iceConnectionState) {
                    case "closed":
                    case "failed":
                    case "disconnected":
                        peerConnection.restartIce();
                        break;
                }
            };


            peerConnection.onicecandidate = ({candidate}) => {
                if (candidate) {
                    signalServer.sendToServer(
                        {
                            sender: senderUser,
                            target: targetUser,
                            type: 'candidate',
                            candidate: candidate
                        }
                    );
                    app.log("Send Candidate To Remote User");
                    // console.log(candidate);
					// if (candidate.candidate.indexOf('srflx') !== -1) {
					// 	let cand = parseCandidate(candidate.candidate);
					// 	console.log(cand);
					// 	if (!candidates[cand.relatedPort]) candidates[cand.relatedPort] = [];
					// 	candidates[cand.relatedPort].push(cand.port);
					// } else if (!candidate) {
					// 	if (Object.keys(candidates).length === 1) {
					// 		var ports = candidates[Object.keys(candidates)[0]];
					// 		console.log(ports.length === 1 ? 'normal nat' : 'symmetric nat');
					// 	}
					// }
                } else {
                    signalServer.sendToServer(
                        {
                            sender: senderUser,
                            target: targetUser,
                            type: 'candidate-done',
                        }
                    );
                    app.log("End of candidates.");
                }
            }

			peerConnection.onconnectionstatechange = function(event) {
				switch(peerConnection.connectionState) {
					case "connected":
						// The connection has become fully connected
						app.log(" -- >The Connection has become fullyu connected");
						break;
					case "disconnected":
					case "failed":
						// One or more transports has terminated unexpectedly or in an error
						app.log(" -- >One or more transports has terminated unexpectedly or in an error");
						break;
					case "closed":
						// The connection has been closed
						app.log(" -- >The connection has been closed")
						break;
				}
			}

            peerConnection.onicegatheringstatechange = () => {
                app.log("*** ICE gathering state changed to: " + peerConnection.iceGatheringState);
            };

            peerConnection.onsignalingstatechange = () => {
                app.log("*** WebRTC signaling state changed to: " + peerConnection.signalingState);
                switch (peerConnection.signalingState) {
                    case "failed":
                        peerConnection.restartIce();
                        break;
                }
            }
            isInitiator = false;
            resolve();
        });
    };

	const parseCandidate = (line) => {
		var parts;
		// Parse both variants.
		if (line.indexOf('a=candidate:') === 0) {
			parts = line.substring(12).split(' ');
		} else {
			parts = line.substring(10).split(' ');
		}

		var candidate = {
			foundation: parts[0],
			component: parts[1],
			protocol: parts[2].toLowerCase(),
			priority: parseInt(parts[3], 10),
			ip: parts[4],
			port: parseInt(parts[5], 10),
			// skip parts[6] == 'typ'
			type: parts[7]
		};

		for (var i = 8; i < parts.length; i += 2) {
			switch (parts[i]) {
				case 'raddr':
					candidate.relatedAddress = parts[i + 1];
					break;
				case 'rport':
					candidate.relatedPort = parseInt(parts[i + 1], 10);
					break;
				case 'tcptype':
					candidate.tcpType = parts[i + 1];
					break;
				default: // Unknown extensions are silently ignored.
					break;
			}
		}
		return candidate;
	};

    const createOffer = async () => {
        try {
            if (!peerConnection) {
                app.log('*** peer conncetion not available while offer creation');
                return false;
            }
            if (isStart) {
                return false;
            }

            const DEFAULT_SDP_OFFER_OPTIONS_ = {
                offerToReceiveAudio: true,
                offerToReceiveVideo: true,
                voiceActivityDetection: false
            }

            let offer = await peerConnection.createOffer(DEFAULT_SDP_OFFER_OPTIONS_);
            if (peerConnection.signalingState != "stable") {
                app.log("--> The connection isn't stable yet; postponing...")
                return;
            }
            app.log("*** Local Description of offer ***");
            app.log(JSON.stringify(offer));
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
            app.log("*** offer send to remote user ***");
        } catch (e) {
            app.log("*** The following error occurred while handling the negotiationneeded event:");
            app.log('error in negotiation', e)
        }
    };

    let rtpVideoSender = null;
    let rtpAudioSender = null;
    let isStreamAdded = false;
    const addStream = async () => {
        if (!peerConnection) {
            app.log('*** peer connection not available ***');
            return;
        }

        // video track
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
            app.log("Stream added To peer connection");
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
        isStreamAdded = true;
    };

    const _setCallee = async () => {
        if (peerConnection) {
            return false;
        }

        if (isStart) {
            return false;
        }
        $('#remoteModalStatus').empty();
        $('#remoteModalStatus').append('connecting to call');
        isInitiator = false;


        if (messageQueue.length > 0) {
            for (const data of messageQueue) {
                if (data.description && data.description.type === 'offer') {
                    app.log("Process to offer after join");
                    await _peerMessage(data);
                    break;
                }
            }
        }
        isStart = true;
        if (isProcessIce) {
            app.log("Process to candidate after join");
            proccesIce();
        }
        $('#videoCall').modal('hide');

    }
    const shareScreen = async () => {
        localStream = await navigator.mediaDevices.getDisplayMedia({
            video: true,
            audio: false
        });
        await addStream();
        localStream.oninactive = async e => {
            app.log("inactive screen");
            await _start();
            await addStream();
        };
    }


    let isJoin = false;
    const pushIntoQueue = async (message) => {

        if (!isInitiator) {
            if (!isJoin) {
                // $('#operationBox').css({"display": "none"});
                // $('#joinBox').css({"display": "flex"});
                let user = app.findUser(message.sender);
                if (user != null) {
                    $('#remoteUserName').append(user.user_name);
                } else {
                    $('#remoteUserName').append("unknown");
                }

                $('#videoCall').modal('show');
                isJoin = true;
            }
        }

        if (message.sender != null && message.target != null) {
            if (!isOncall) {
                // new call details
                if (message.description) {
                    if ((isInitiator && message.description.type === 'answer') ||
                        (!isInitiator && message.description.type === 'offer')) {
                        hasRemoteSdp_ = true;
                        app.log("*** message from remote user type is " + message.description.type);
                        messageQueue.unshift(message);
                    }
                } else {
                    app.log("*** message from remote user of type is candidate");
                    messageQueue.push(message);
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
        if (!isAnwser && message.description && message.description.type === 'answer') {
            app.log('Process answer message');
            await _peerMessage(message);
        }

        // if (messageQueue.length > 0) {
        // 	if (isInitiator) {
        // 		if (!isAnwser && message.description && message.description.type === 'answer') {
        // 			app.log('Process answer message');
        // 			await _peerMessage(message);
        // 		}
        // 	}
        // }

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
                app.log(constraints);
                localStream = await navigator.mediaDevices.getUserMedia(constraints);
                selfVideo.srcObject = localStream;
            } else {
                app.log(availbelDevices[devicePointer].deviceId);
                constraintValues = {
                    audio: true,
                    video: {
                        deviceId: availbelDevices[devicePointer].deviceId
                    }
                };
                localStream = await navigator.mediaDevices.getUserMedia(constraintValues);
                selfVideo.srcObject = localStream;
            }
            // if (localStream && localStream.getVideoTracks().length > 0) {
            //     let localTrack = localStream.getVideoTracks()[0];
            //     if (localTrack) {
            //         selfVideo.srcObject = localStream;
            //     }
            // }

        } catch (e) {
            app.log('Error in Start Function', e);
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
                localStream = stream;

            });

        }
    }

    const _peerMessage = async (data) => {
        try {
            // app.log("*** on messsage Data from " + data.sender + " to " + data.target + " :  " ,data);
            if (!peerConnection) {
                await _init(data.sender, data.target);
            }
            if (data.description) {

                if (data.description.type == "offer" && !isInitiator && !isOffer) {

                    if (peerConnection.signalingState != "stable") {
                        app.log('*** connection is not stable wait for promise completion')
                        await Promise.all([
                            peerConnection.setLocalDescription({type: "rollback"}),
                            peerConnection.setRemoteDescription(data.description)
                        ]);
                        return;
                    } else {
                        await peerConnection.setRemoteDescription(data.description);
                        finishSDPVideoOfferOrAnswer = true;
                    }
                    if (!localStream) {
                        await _start();
                        await addStream();
                    }
                    if (!isStreamAdded) {
                        await addStream();
                    }
                    let answer = await peerConnection.createAnswer();
                    await peerConnection.setLocalDescription(answer);
                    isOffer = true;
                    signalServer.sendToServer(
                        {
                            target: data.sender,
                            sender: data.target,
                            type: 'answer',
                            description: answer
                        })
                    messageQueue.splice(data, 1);
                    app.log("**** send anwser to remote user");
                    app.log(answer);
                } else if (data.description.type == "answer" && isInitiator && isAnwser == false) {
                    if (peerConnection.signalingState !== 'have-local-offer' || peerConnection.signalingState == 'stable') {
                        app.log("ERROR: remote answer received in unexpected state:" + peerConnection.signalingState);
                        return;
                    }
                    try {
                        app.log("Singal State " + peerConnection.signalingState)
                        await peerConnection.setRemoteDescription(data.description);
                        finishSDPVideoOfferOrAnswer = true;
                        app.log("*** Call recipient has accepted our call");
                        messageQueue.splice(data, 1);
                        isAnwser = true;
                        // if (isProcessIce) {
                        // 	app.log('message Queue fired from answer section ...');
                        // 	for (const data1 of messageQueue) {
                        // 		await _peerMessage(data1);
                        // 	}
                        // }
                    } catch (e) {
                        app.log('error in Answer message ' + JSON.stringify(e));
                    }
                }
            } else if (data.candidate) {

                app.log("Candidate section Singal State " + peerConnection.signalingState)
                if (peerConnection.signalingState == 'stable' && finishSDPVideoOfferOrAnswer) {
                    peerConnection.addIceCandidate(data.candidate).catch(reportError => app.log(JSON.stringify(reportError)));
                    messageQueue.splice(data, 1);
                    app.log("*** ICE Candidate is added");
                    app.log(JSON.stringify(data));
                } else {
                    app.log("*** remote description not set process cnadidate in waiting state");
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
                    window.location.href = 'https://rmt.docango.com/messenger';
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
                window.location.href = 'https://rmt.docango.com/messenger';
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
        if (isStart) {
            app.log("*** Procces the queue messages of lenght " + messageQueue.length);
            for (const data of messageQueue) {
                await _peerMessage(data);
            }
        }
        isProcessIce = true;
    }

    return {
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
