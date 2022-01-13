<?php 
$name=$this->session->user_session->user_name;
	$email=$this->session->user_session->email;
	$user_type=$this->session->user_session->user_type;
	?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="http://bylancer.com">
    <meta name="keywords" content="php chat script, php ajax Chat,facebook similar chat, php mysql chat, chat script, facebook style chat script, gmail style chat script. fbchat, gmail chat, facebook style message inbox, facebook similar inbox, facebook like chat">
    <meta name="description" content="Wchat is a popular responsive php ajax inbox messaging (Chat) WebApp for websites, mobile apps and control panels.">

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>chat_assets/assets/images/favicon.png">
    <title>Wchat - Responsive php ajax inbox messaging plugin</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>chat_assets/assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Animation CSS -->
    <link href="<?= base_url() ?>chat_assets/assets/css/animate.css" rel="stylesheet">
    <link href="<?= base_url() ?>chat_assets/assets/css/custom.css" rel="stylesheet" id="style">
    <!-- Theme light dark version CSS -->
    <link href="<?= base_url() ?>chat_assets/assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>chat_assets/assets/css/style-light.css"  id="maintheme" rel="stylesheet">
    <!-- color CSS you can use different color css from css/colors folder -->
    <!-- We have chosen the skin-blue (blue.css) for this starter
         page. However, you can choose any other skin from folder css / colors .
    -->
    <link href="<?= base_url() ?>chat_assets/assets/css/colors/green.css" id="theme"  rel="stylesheet">
    <!-- Emoji One JS -->
    <link rel="stylesheet" href="<?= base_url() ?>chat_assets/smiley/assets/sprites/emojione.sprites.css"/>
    <script src="<?= base_url() ?>chat_assets/smiley/js/emojione.min.js"></script>
<style>
* {box-sizing: border-box}
body {font-family: "Lato", sans-serif;}

/* Style the tab */
.tab {
  float: left;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
  width: 30%;
  height: 300px;
}

/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 100%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  float: left;
  padding: 0px 12px;
  //border: 1px solid #ccc;
  width: 100%;
  border-left: none;
  //height: 300px;
}
</style>
</head>
<body>


<div id="wchat">
    <div class="wchat-wrapper wchat-wrapper-web wchat-wrapper-main">
        <div tabindex="-1" class="wchat two">
<!-- .chat-left-panel -->
            <div id="side" class="wchat-list wchat-one chat-left-aside left">
                <div class="open-panel"><i class="ti-angle-right"></i></div>
                <div class="chat-left-inner">
                    <div id="my-profile" style="display: none;">
                    </div>
                    <div id="contact-list">
                        <header class="wchat-header wchat-chat-header top">
                            <div class="chat-avatar">
                                <div class="avatar icon-user-default" style="height: 40px; width: 40px;">
                                    <div class="avatar-body userimage"><img src="<?= base_url() ?>chat_assets/storage/user_image/avatar_default.png" class="avatar-image is-loaded" width="100%"></div>
                                </div>

                            </div>
                            <div class="chat-body">
                                <div class="chat-main"><h2 class="chat-title" dir="auto"><span class="wchatellips personName"><?php echo $name; ?></span></h2></div>
                            </div>
                            <div class="wchat-chat-controls">
                                <div class="menu menu-horizontal">
                                    <div class="menu-item active dropdown pull-right">
                                        <button class="icon dropdown-toggle" data-toggle="dropdown" href="#"><span class="font-19"><i class="icon icon-options-vertical"></i></span></button>
                                        <ul class="dropdown-menu dropdown-user animated flipInY">
                                            <li><a href="<?= base_url() ?>Chat_Controller/sample_chat"><i class="ti-user"></i> sample</a></li>
                                             <li><a href="#"><i class="ti-envelope"></i> <?php echo $email; ?></a></li>
                                            <li><a href="#"><i class="ti-wallet"></i> Edit Profile</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li><a href="<?= base_url(); ?>Home/logout"><i class="fa fa-power-off"></i> Logout</a></li>
                                        </ul>
                                        <!-- /.dropdown-user -->
                                    </div>
                                    <div class="menu-item right-side-toggle"><button class="icon ti-settings font-20" title="Attach"></button><span></span></div>
                                </div>
                            </div>
                        </header>
                        <div class="form-material">
                            <input class="form-control p-lr-20 live-search-box search_bg" id="searchbox" type="text" placeholder="Search By Username or Email">
                        </div>
						<div class="contact-drawer">
                      
						 <ul class="chatonline drawer-body contact-list" id="display_link" data-list-scroll-container="true" style="display: block;">
						</ul>
						</div>
						  
                      
                    </div>
                </div>
            </div>
            <!-- .chat-left-panel -->
			<!-- .chat-right-panel -->

            <div tabindex="-1" id="main right" class="pane wchat-chat wchat-two chat-right-aside right" style="visibility: block;">


                <div class="wchat-chat-tile"></div>
				<div class="wchat-body wchat-chat-tile-container" style="background-size: cover;">
                    <div>
                        <span>
                            <div class="scroll-down" style="transform: scaleX(1) scaleY(1); opacity: 1; visibility:hidden;">
                                <span class="ti-angle-down"></span>
                            </div>
                        </span>
                        <div class="wchat-chat-msgs wchat-chat-body lastTabIndex" tabindex="0">
                            <div class="wchat-chat-empty"></div>
                            <div class="message-list">
                                <div class="chat-list" id="resultchat">
                                    <!--Here content comes dynamically-->
									<!--<div id="tab_data"></div>-->
                                   <h1>tab panel</h1>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				
			</div>	

			
		</div>
   </div>
</div>		
<!-- <div class="tab" id="tab_btn">-->
  <!--<button class="tablinks" onclick="openCity(event, 'London')" id="defaultOpen">London</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')">Paris</button>
  <button class="tablinks" onclick="openCity(event, 'Tokyo')">Tokyo</button>-->
<!-- </div>-->
<!--<div id="tab_data">-->
<!--<div id="London" class="tabcontent">
  <h3>London</h3>
  <p>London is the capital city of England.</p>
</div>

<div id="Paris" class="tabcontent">
  <h3>Paris</h3>
  <p>Paris is the capital of France.</p> 
</div>

<div id="Tokyo" class="tabcontent">
  <h3>Tokyo</h3>
  <p>Tokyo is the capital of Japan.</p>
</div>-->
<!--</div>-->
<script src="<?= base_url() ?>chat_assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="<?= base_url() ?>chat_assets/assets/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?= base_url() ?>chat_assets/assets/js/custom.js"></script>
<!--Style Switcher -->
<script src="<?= base_url() ?>chat_assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
<!--Style Switcher -->
<!--ChatJs -->
<script type="text/javascript" src="<?= base_url() ?>chat_assets/chatjs/lightbox.js"></script>
<script type="text/javascript" src="<?= base_url() ?>chat_assets/chatjs/inbox.js"></script>
<script type="text/javascript" src="<?= base_url() ?>chat_assets/chatjs/custom.js"></script>
<!--ChatJs-->
<script type="text/javascript">
    var base_url="<?= base_url(); ?>";
</script>

<script type="text/javascript">
    $( document ).ready(function() {
	get_user_data();
    //get_fav_data();
});

	function get_user_data()
	{
		  var arr = ['user1','user2','user3','user4','user5'];
				 $.each(arr, function(index, value){
				// console.log('The value at arr[' + index + '] is: ' + value);
				   $("#tab_btn").append('<button class="tablinks" onclick="openCity(event, \''+value+'\')">'+value+'</button>');
				   $("#display_link").append('<li class="person chatboxhead" id="chatbox1_'+value+'" data-chat="person_' + index + '" href="javascript:void(0)" onclick="openCity(event, \''+value+'\')">\
                                    <a href="javascript:void(0)">\
                                        <span class="userimage profile-picture min-profile-picture"><img src="'+base_url+'chat_assets/storage/user_image/avatar_default.png" alt="Deven" class="avatar-image is-loaded bg-theme" width="100%"></span>\
                                         <span>\
                                          <span class="bname personName">'+value+'</span>\
                                             <span class="personStatus"><span class="time Online"><i class="fa fa-circle" aria-hidden="true"></i></span></span>\
                                            <br>\
                                             <small class="preview"><span class="Online">Online</span></small>\
                                         </span>\
                                     </a>\
                              </li>');
							  
					//$("#tab_data").append('<div id="'+value+'" class="tabcontent" style="display:none;"><h3>'+value+'</h3><p>'+value+' is the capital city of England.</p></div>');
					$("#resultchat").append('<div id="'+value+'" class="tabcontent chat chatboxcontent chat_tab" data-chat="person_'+index+'" client="'+value+'">'+
                                       ' <div class="col-xs-12 p-b-10">'+
                                            '<div class="chat-image  profile-picture max-profile-picture">'+
                                               ' <img alt="'+value+'" src="<?= base_url() ?>chat_assets/storage/user_image/Deven.jpg" class="bg-theme">'+
                                            '</div>'+
                                           ' <div class="chat-body">'+
                                                '<div class="chat-text">'+
                                                  '  <h4>'+value+'</h4>'+
                                                    '<p><a url="<?php base_url() ?>public/storage/user_files/image-chat.jpg" onclick="trigq(this)"><img src="<?= base_url() ?>chat_assets/storage/user_files/image-chat.jpg" class="userfiles"></a></p>'+
                                                   ' <b>23 days ago</b>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                        '<div class="col-xs-12 p-b-10 odd">'+
                                           ' <div class="chat-image  profile-picture max-profile-picture">'+
                                              '  <img alt="Bylancer" src="<?= base_url() ?>chat_assets/storage/user_image/Bylancer.jpg">'+
                                           ' </div>'+
                                           ' <div class="chat-body">'+
                                                '<div class="chat-text">'+
                                                   ' <h4>Bylancer</h4>'+
                                                    '<p>Hi</p>'+
                                                   ' <b>Just Now</b>'+
                                                   ' <span class="msg-status msg-mega"><i class="fa fa-check"></i></span>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>');	
				 });
	}
</script>
 <script type="text/javascript">
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
	  //alert(tabcontent.length);
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
</body>
</html> 