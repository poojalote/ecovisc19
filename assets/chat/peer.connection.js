const Peer = (function () {

    const selfVideo = document.querySelector("video#remoteVideo");
    const remoteVideo = document.querySelector("video#selfVideo");
    const hangUp = document.querySelector("#hangUp");
    let availbelDevices = [];
    let devicePointer = 0;

    let makingOffer = false;
    let localStream, remoteStream, localScreenShareStream;
    let peerConnection;

    let targetUser = null;
    let senderUser = null;
    let isInitiator = null;
    let isStart = false;
    let messageQueue = [];
    let localCandidate = [];

    let hasRemoteSdp_ = false;

    let isOffer = false;
    let isAnwser = false;
    const constraints = {
        audio: true,
        video: true,
    };

    const config = {
        iceServers: [
            {urls: "stun:65.0.87.149:3478"},
            {
                urls: "turn:65.0.87.149:3478",
                username: "admin",
                credential: "admin",
            },
        ]
    };

    let isAudio = true;

    const muteAudio = () => {
        isAudio = !isAudio;
        localStream.getAudioTracks()[0].enabled = isAudio;

        if (!isAudio) {
            $('#audio-icon').removeClass('fas fa-microphone');
            $('#audio-icon').addClass('fas fa-microphone-slash');
        } else {
            $('#audio-icon').addClass('fas fa-microphone');
            $('#audio-icon').removeClass('fas fa-microphone-slash');
        }

    };

    let isVideo = true;

    const muteVideo = () => {
        isVideo = !isVideo;
        localStream.getVideoTracks()[0].enabled = isVideo;
        if (!isVideo) {
            $('#video-icon').removeClass('fas fa-video');
            $('#video-icon').addClass('fas fa-video-slash');
        } else {
            $('#video-icon').addClass('fas fa-video');
            $('#video-icon').removeClass('fas fa-video-slash');
        }
    }

    const _init = (_targetUser, _senderUser) => {
        hangUp.disabled = false;
        targetUser = _targetUser;
        senderUser = _senderUser;
        //
        // $('#wchat').css("display", "none");
        // $('#videoBox').css("display", "flex");

        return new Promise((resolve, reject) => {

            if (peerConnection) {
                console.log("*** Already have peer connection ***")
                reject();
                return;
            }

            peerConnection = new RTCPeerConnection(config);
            peerConnection.ontrack = (event) => {
                console.log("*** Track event");

                if (!remoteStream) {
                    remoteStream = new MediaStream();
                }

                if (event.track.kind == "video") {
                    remoteStream
                        .getVideoTracks()
                        .forEach((t) => remoteStream.removeTrack(t));
                    remoteStream.addTrack(event.track);
                    remoteVideo.srcObject = remoteStream;
                    remoteVideo.load();
                }
            }

            peerConnection.onicecandidateerror = (event) => {
                console.log('*** ice candidate error *** ', event)
            }

            peerConnection.oniceconnectionstatechange = () => {
                console.log("*** ICE connection state changed to " + peerConnection.iceConnectionState);
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
                    console.log("*** ICE candidate : ", candidate);
                    localCandidate.push(candidate);
                } else {
                    signalServer.sendToServer(
                        {
                            sender: senderUser,
                            target: targetUser,
                            type: 'candidate',
                            candidate: JSON.stringify(localCandidate)
                        }
                    );
                    app.log(`${localCandidate.length} candidate are send`);
                    app.log("End of candidates.");
                }
            }

            peerConnection.onicegatheringstatechange = () => {
                console.log("*** ICE gathering state changed to: " + peerConnection.iceGatheringState);
            };

            peerConnection.onsignalingstatechange = () => {
                console.log("*** WebRTC signaling state changed to: " + peerConnection.signalingState);
                switch (peerConnection.signalingState) {
                    case "closed":
                        peerConnection.restartIce();
                        break;
                }
            }
            isInitiator = false;
            resolve();
        });
    };

    const createOffer = async () => {
        try {
            if (!peerConnection) {
                console.log('*** peer conncetion not available while offer creation');
                return false;
            }
            if (isStart) {
                return false;
            }


            if (peerConnection.signalingState != "stable") {
                log("--> The connection isn't stable yet; postponing...")
                return;
            }

            const DEFAULT_SDP_OFFER_OPTIONS_ = {
                offerToReceiveAudio: 1,
                offerToReceiveVideo: 1,
                voiceActivityDetection: false,
                iceRestart:true
            }
            let offer = await peerConnection.createOffer(DEFAULT_SDP_OFFER_OPTIONS_);
            await peerConnection.setLocalDescription(offer);
            console.log("**** New Video Call Creating offer ****");
            isInitiator = true;
            isStart = true;
            signalServer.sendToServer(
                {
                    sender: senderUser,
                    target: targetUser,
                    type: 'offer',
                    description: peerConnection.localDescription
                })
            console.log("*** offer details ***", offer);
        } catch (e) {
            console.log("*** The following error occurred while handling the negotiationneeded event:");
            console.log('error in negotiation', e)
        }
    };

    let rtpSender = null;
    const addStream = async () => {
        if (!peerConnection) {
            console.log('*** peer connection not available ***');
            return;
        }

        if (rtpSender && rtpSender.track) {
            let localTrack = localStream.getVideoTracks()[0];
            rtpSender.replaceTrack(localTrack);
        } else {
            await _start();
            let localTrack = localStream.getVideoTracks()[0];
            rtpSender = peerConnection.addTrack(localTrack);
        }
        console.log('*** add local stream into peer connection ***')

    };

    const _setCallee = () => {
        if (!peerConnection) {
            return false;
        }
        if (isStart) {
            return false;
        }
        isInitiator = false;
        isStart = true;
        if (messageQueue.length > 0) {
            messageQueue.forEach(async data => {
                await _peerMessage(data);
            });

        }

    }

    const pushIntoQueue = async (message) => {
        if (message.description) {
            if ((isInitiator && message.description.type === 'answer') ||
                (!isInitiator && message.description.type === 'offer')) {
                hasRemoteSdp_ = true;
                messageQueue.unshift(message);
            }
        } else {

            let remoteCandidates = JSON.parse(message.candidate);
            console.log(remoteCandidates);
            for (let candidate in remoteCandidates) {
                messageQueue.push(candidate);
            }
        }

        if (!peerConnection) {
            if (message.sender != null && message.target != null)
                _init(message.sender, message.target).then(() => {
                    addStream();
                }).catch(e => console.log('*** error push into queue message ***', e));
        }

        if (!peerConnection || !hasRemoteSdp_ || !isStart) {
            return;
        }

        console.log("Messeage Queue Length "+messageQueue.length);
        console.log(messageQueue);
        console.log('message Queue in processing mode ...');
        for (let msg in messageQueue) {
            await _peerMessage(msg);
        }
        console.log('message Queue End');


    }

    const getCameraDevices = async () => {
        await navigator.mediaDevices.enumerateDevices().then((devices) => {
            devices.forEach(device => {
                if (device.kind === 'videoinput') {
                    availbelDevices.push(device);
                }
            });
        }).catch(e => {
            console.log("*** Error while getting device info", e);
        });
    };

    const switch_camera = async () => {

        if (availbelDevices.length > devicePointer) {
            devicePointer++;
            await _start();
            await addStream();
        } else {
            devicePointer = 0;
            console.log("reset camera");
            await _start();
            await addStream();
        }
    };

    const shareScreen = async () => {
        localStream = await navigator.mediaDevices.getDisplayMedia({
            video: true,
            audio: false
        });
        await addStream();
        localStream.oninactive = async e => {
            console.log("inactive screen");
            await _start();
            await addStream();
        };
    }

    const _start = async () => {
        try {
            await getCameraDevices();
            console.log('*** local stream started ***')
            if (localStream) {
                localStream.getTracks().forEach(track => {
                    track.stop();
                });
            }
            if (devicePointer == 0) {
                console.log(constraints);
                localStream = await navigator.mediaDevices.getUserMedia(constraints);
            } else {
                console.log(availbelDevices[devicePointer].deviceId);
                constraintValues = {
                    audio: true,
                    video: {
                        deviceId: availbelDevices[devicePointer].deviceId
                    }
                };
                localStream = await navigator.mediaDevices.getUserMedia(constraintValues);
                //selfVideo.srcObject = localStream;
            }

            if (localStream && localStream.getVideoTracks().length > 0) {
                let localTrack = localStream.getVideoTracks()[0];
                if (localTrack) {
                    selfVideo.srcObject = localStream;
                }
            }


        } catch (e) {
            console.log('Error in Start Function', e);
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
                console.log('Got access to local media');
                localStream = stream;

            });

        }
    }

    const _peerMessage = async (data) => {
        try {
            // console.log("*** on messsage Data from " + data.sender + " to " + data.target + " :  " ,data);
            if (!peerConnection) {
                _init(data.sender, data.target);
            }
            if (data.description) {

                if (data.description.type == "offer" && !isInitiator && !isOffer) {

                    if (peerConnection.signalingState != "stable") {
                        console.log('*** connection is not stable wait for promise completion')
                        await Promise.all([
                            peerConnection.setLocalDescription({type: "rollback"}),
                            peerConnection.setRemoteDescription(data.description)
                        ]);
                        return;
                    } else {
                        await peerConnection.setRemoteDescription(data.description);
                    }

                    console.log("---> Creating and sending answer to " + data.sender + " from " + data.target);

                    await peerConnection.setLocalDescription(await peerConnection.createAnswer());
                    isOffer = true;
                    if (!localStream) {
                        app.log('Wait for local stream');
                        await _start();
                    }
                    signalServer.sendToServer(
                        {
                            target: data.sender,
                            sender: data.target,
                            type: 'answer',
                            description: peerConnection.localDescription
                        })
                } else if (data.description.type == "answer" && isInitiator && isAnwser == false) {
                    if (peerConnection.signalingState !== 'have-local-offer') {
                        console.log("ERROR: remote answer received in unexpected state:" + peerConnection.signalingState);
                        return;
                    }
                    console.log("*** Call recipient has accepted our call");
                    try {
                        await peerConnection.setRemoteDescription(data.description);
                        isAnwser = true;
                    } catch (e) {
                        console.log('error in Answer message', e);
                    }
                }
            } else if (data.candidate) {
                try {
                    console.log("*** Adding received ICE candidate: " + JSON.stringify(data.candidate));
                    if (data.candidate){
                        await peerConnection.addIceCandidate(data.candidate);
                        console.log("Candidate Added");
                    }
                } catch (err) {
                    console.log("Error: "+JSON.parse(err));
                }
            }

        } catch (e) {
            console.log('error in peer message', e);
        }
    }

    const hangUpOperation = (type = 0) => {
        console.log("End Call...");
        if (peerConnection) {
            if (type !== 0) {
                if (type == app.local_firm_id || type == 1) {
                    peerConnection.close();
                    hangUp.disabled = true;
                    window.location.href = 'https://covidcare.docango.com/chat';
                }
            }
            if (type == 0) {
                peerConnection.close();
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

    return {
        init: (targetUser, senderUser) => _init(targetUser, senderUser),
        startLocalVideo: async () => await _start(),
        createOffer: () => createOffer(),
        addStream: async () => await addStream(),
        onMessage: (response) => _peerMessage(response),
        onMuteAudio: () => muteAudio(),
        onMuteVideo: () => muteVideo(),
        setCallee: () => _setCallee(),
        saveMessage: (message) => pushIntoQueue(message),
        hangUp: (type) => hangUpOperation(type),
        switch_camera: () => switch_camera(),
        shareScreen: () => shareScreen(),
    }


})();
