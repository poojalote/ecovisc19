<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="<?= base_url() ?>assets/scripts/toastr/toastr.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url() ?>assets/scripts/toastr/toastr.css" rel="stylesheet" type="text/css"/>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial;
        }

        .toast-top-right {
            top: 50px;
            right: 0;
        }

        .header {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 50px;
            max-height: 60px;
            position: absolute;
            top: 0;
            z-index: 9999;
        }

        .header p {
            margin: 0;
        }

        .row {
            display: flex;
            flex-direction: row;
            width: 100%;
            flex-wrap: wrap;
            padding: 0 4px;
        }

        .footer {
            display: flex;
            flex-direction: column;
            flex-wrap: nowrap;
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 8px;
            align-items: center;
            justify-content: center;
        }

        .main {
            display: flex;
            width: 100%;
            height: calc(100% - 50px);
            background: #4e4e4e;
            position: absolute;
            top: 50px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .action-group {
            display: flex;
            flex-direction: row;
            justify-content: space-evenly;
            width: 100%;
            padding-bottom: 24px;
        }

        .action-group button {
            width: 50px;
            height: 50px;
            border-radius: 25px;
            border: 0;
        }

        .container-box {
            display: flex;
            width: 100%;
            height: calc(100vh - 50px);
            flex-direction: column;
            justify-content: center;
        }

        video#selfVideo, video#remoteVideo {
            width: 100%;
            height: 100%;
        }

        .small-box {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            width: 45vw;
            height: 20vh;
            background: #dcd7d7;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .extra{
            position: absolute;
            top: 50px;
            right: 0;
            margin-right: 16px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
        }
        .extra button{
            margin-top:4px;
            margin-bottom: 4px;
        }

    </style>
</head>
<body>
<!-- Header -->
<div class="header">
    <button class="btn btn-link text-dark" onclick="clipToCopy(this)">
        <span id="clipToCopy" class="text-primary">ABCDEFGHIJKLMNOPQR</span> <i class="far fa-clipboard"></i>
    </button>
</div>

<div class="main">

    <div class="row">
        <div class="container-box">
            <div class="extra">
                <button class="btn btn-primary" onclick="switchCamera()" >
                    <i class="fas fa-exchange-alt"></i>
                </button>
                <button class="btn btn-primary" onclick="shareScreen()" >
                    <i class="far fa-share-square fa-w-16"></i>
                </button>
            </div>
			<video class="selfview" id="selfVideo" muted autoplay></video>
<!--            <video id="selfVideo" autoplay ></video>-->
        </div>
    </div>
</div>
<div class="footer">
    <div class="row" style="justify-content: flex-end;">
        <div class="small-box" onclick="switchView()">
<!--            <video id="remoteVideo" muted autoplay></video>-->
<!--			<audio style="display: none" id="remoteAudio" autoplay></audio>-->
			<video class="remoteview" id="remoteVideo" autoplay></video>
			<audio style="display: none" id="remoteAudio" autoplay></audio>
        </div>
    </div>
    <div class="row">
        <div class="action-group" id="operationBox" style="display: none">
            <button class="btn btn-primary" onclick="videoChange()">
                <i class="fas fa-video" id="video-icon"></i>
            </button>
            <button class="btn btn-danger" id="hangUp" onclick="hangUp()" disabled>
                <i class="fa fa-phone" style="transform: rotate(224deg);color: white;"></i>
            </button>
            <button class="btn btn-primary" onclick="audioChange()">
                <i class="fas fa-microphone" id="audio-icon"></i>
            </button>
            
        </div>
        <div class="action-group" id="joinBox" style="display: none">
            <button class="btn btn-primary" onclick="joinCall()" style="border-radius:0">
                Join
            </button>
        </div>
    </div>
</div>
<!--bootstrap js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
<script src="<?= base_url() ?>assets/scripts/toastr/toastr.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"
        integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg=="
        crossorigin="anonymous"></script>
<!--ChatJs-->
<script src="https://chat.docango.com/socket.io/socket.io.js"></script>
<script src="<?= base_url('assets/chat/index_7_1.js') ?>" defer></script>
<script src="<?= base_url('assets/chat/app.js') ?>" defer></script>
<script src="<?= base_url('assets/chat/peer.connection.js') ?>" defer></script>
<!--<script src="--><?//= base_url('assets/chat/peer.connection.min.js') ?><!--" defer></script>-->
<!--custom js-->

<script>
    let base_url = "<?= base_url(); ?>";
    toastr.options = {
        "positionClass": "toast-top-right",
    }

    function clipToCopy(copyText) {
        console.log(copyText.textContent);
        //var copyText = document.getElementById("pwd_spn");
        let textArea = document.createElement("textarea");
        textArea.value = 'https://rmt.docango.com/video?rid=' + copyText.textContent.trim();
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand("Copy");
        textArea.remove();
        toastr.success("copied")
    }

    function getString(length) {
        let result = '';
        let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let charactersLength = characters.length;
        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }

    function videoChange() {
        Peer.onMuteVideo();
    }

    function audioChange() {
        Peer.onMuteAudio();
    }

    function hangUp() {
        Peer.hangUp();
    }
    function switchCamera(){
        Peer.switch_camera();
    }

    let view = 1;

    function switchView() {
        if (view === 1) {
            view = 2;
            remoteVideo.srcObject = localStream;
            remoteVideo.load();
            selfVideo.srcObject = null;
        } else {
            view = 1;
            selfVideo.srcObject = localStream;
            remoteVideo.srcObject = null;
            selfVideo.load();
        }
    }

    function shareScreen(){
        Peer.shareScreen();
    }

    $(document).ready(async function () {
        const urlParams = new URLSearchParams(window.location.search);

        let meeting_id = urlParams.get('rid');

        let roomName = getString(8);
        let type = 'create-room';
        if (meeting_id != null) {
            roomName = meeting_id;
            type = "join-room";
            $('#operationBox').css({"display": "none"});
            $('#joinBox').css({"display": "flex"});
        } else {
            $('#operationBox').css({"display": "flex"});
        }
        $('#clipToCopy').empty();
        $('#clipToCopy').append(roomName);
        let localObject = {
            userId: 13,
            userName: getString(3),
            firmId: roomName,
            email: getString(15),
            groupId: getString(5),
            groups: []
        };
        app.log(JSON.stringify(localObject)+"type="+type);
        signalServer
            .init_signal(localObject.userId, localObject.userName, localObject.firmId, localObject.email, localObject.groupId, localObject.groups, type);
        await Peer.startLocalVideo();
    });

    function joinCall() {
        Peer.setCallee();
        $('#operationBox').css({"display": "flex"});
        $('#joinBox').css({"display": "none"});
    }

    async function startVideoCall(target, username) {
        app.log(JSON.stringify({target:target,username:username}));
        try{
			await Peer.init(target,username);
			await Peer.addStream();
			await Peer.createOffer();
			app.log("Waiting For answer SDP");
			document.querySelector("#hangUp").disabled = false;
		}catch (e) {
			app.log("Start Video Call Problem "+JSON.stringify(e));
		}
		// await Peer.startLocalVideo();
		// Peer.init(target,username, 2).then(async () => {
		// 	const hangUpbtn = document.querySelector("#hangUp");
		// 	hangUpbtn.disabled = false;
		// 	await Peer.addStream();
		// 	await Peer.createOffer();
		//
		// }).catch(e => console.log("*** start video call ***", e));
    }


    // let selfVideo = document.getElementById('selfVideo');
    // let remoteVideo = document.getElementById('remoteVideo');
    // let localStream;
    // navigator.mediaDevices.getUserMedia({
    //     video: {
    //         height: 1080,
    //         width: 1920,
    //         aspectRatio: 1.777777778
    //     }, audio: false
    // }).then(localStream => {
    //     localStream = localStream;
    //     selfVideo.srcObject = localStream;
    //
    //     let videoTrack = localStream.getVideoTracks();
    //     let constraints = videoTrack[0].getConstraints();
    //     console.log(constraints);
    //     let supported = navigator.mediaDevices.getSupportedConstraints();
    //     console.log(supported)
    // });


</script>
</body>
</html>
