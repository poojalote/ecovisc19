<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>

<OBJECT classid="clsid:9BE31822-FDAD-461B-AD51-BE1D1C159921"
		codebase="https://downloads.videolan.org/pub/videolan/contrib/win32/axvlc.cab"
		width="640" height="480" id="vlc" events="True">
	<param name="Src" value="rtsp://cameraipaddress" />
	<param name="ShowDisplay" value="True" />
	<param name="AutoLoop" value="False" />
	<param name="AutoPlay" value="True" />
	<embed id="vlcEmb"  type="application/x-google-vlc-plugin" version="VideoLAN.VLCPlugin.2" autoplay="yes" loop="no" width="640" height="480"
		   target="rtsp://admin:ADMIN@12@136.233.89.172:554/Streaming/Channels/201" ></embed>
</OBJECT>


</body>
</html>
