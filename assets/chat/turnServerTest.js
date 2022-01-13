function checkTURNServer(turnConfig, timeout) {

	return new Promise(function (resolve, reject) {

		setTimeout(function () {
			if (promiseResolved) return;
			resolve(false);
			promiseResolved = true;
		}, timeout || 5000);

		var promiseResolved = false;

		myPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;   //compatibility for firefox and chrome
		pc = new myPeerConnection({iceServers: [turnConfig],iceTransportPolicy: "all"})
		noop = function () {
			console.log("noop call");
		};
		pc.createDataChannel("");    //create a bogus data channel
		pc.createOffer(function (sdp) {
			if (sdp.sdp.indexOf('typ relay') > -1) { // sometimes sdp contains the ice candidates...
				promiseResolved = true;
				resolve(true);
			}
			pc.setLocalDescription(sdp, noop, noop);
		}, noop);    // create offer and set local description
		pc.onicecandidate = function (ice) {  //listen for candidate events
			console.log(ice.candidate.candidate);
			if (promiseResolved || !ice || !ice.candidate || !ice.candidate.candidate || !(ice.candidate.candidate.indexOf('typ relay') > -1)) return;
			promiseResolved = true;
			resolve(true);
		};
	});
}

const USERNAME = "admin";
const PASSWORD = "admin";
const PORT = 433;
const IP = "13.233.154.202"; // you will have to change this
async function load() {
	console.log('TURN server reachable on TCP?', await checkTURNServer(
		{
			urls: `turn:${IP}:${PORT}?transport=tcp`,
			username: USERNAME,
			credential: PASSWORD
		}
	));

	console.log('TURN server reachable on UDP?', await checkTURNServer({
		urls: `turn:${IP}:${PORT}?transport=udp`,
		username: USERNAME,
		credential: PASSWORD
	}));
}

load();
