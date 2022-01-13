<?php
if (!isset($this->session->user_session)) {
    redirect('login');
}
$name = $this->session->user_session->user_name;
$email = $this->session->user_session->email;
$user_type = $this->session->user_session->user_type;
$group_id = $this->session->group_id;
$firm_id = $this->session->user_session->firm_id;
$user_id = $this->session->user_session->id;
$user_image=$this->session->group_image;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>chat_assets/assets/images/favicon.png">
    <title>Chat</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?= base_url() ?>chat_assets/assets/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
    <!-- Animation CSS -->
    <link href="<?= base_url() ?>chat_assets/assets/css/animate.css" rel="stylesheet">
    <link href="<?= base_url() ?>chat_assets/assets/css/custom.css" rel="stylesheet" id="style">
    <!-- Theme light dark version CSS -->
    <link href="<?= base_url() ?>chat_assets/assets/css/style.css" rel="stylesheet">
    <link href="<?= base_url() ?>chat_assets/assets/css/style-light.css" id="maintheme" rel="stylesheet">
    <link href="<?= base_url() ?>chat_assets/assets/css/colors/green.css" id="theme" rel="stylesheet">
	
    <!-- Emoji One JS -->
    <link rel="stylesheet" href="<?= base_url() ?>chat_assets/smiley/assets/sprites/emojione.sprites.css"/>
    <script src="<?= base_url() ?>chat_assets/smiley/js/emojione.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet"/>
    <script type="text/javascript">
        // #################################################
        // # Optional

        // default is PNG but you may also use SVG
        emojione.imageType = 'png';
        emojione.sprites = false;

        // default is ignore ASCII smileys like :) but you can easily turn them on
        emojione.ascii = true;

        // if you want to host the images somewhere else
        // you can easily change the default paths
        emojione.imagePathPNG = '<?php base_url() ?>chat_assets/smiley/assets/png/';
        emojione.imagePathSVG = '<?php base_url() ?>chat_assets/smiley/assets/svg/';

        // #################################################
    </script>
    <style>
        .activeTab {
            background-color: whitesmoke;

        }

        .target-preview {
            background-color: #dedede;
        }

        .preview-container {
            display: flex;
            flex-direction: column;
            height: 225px;
            width: 100%;
            align-items: center;
            justify-content: center;
        }

        .center-box {
            width: 70%;
            height: 70%;
            padding: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .center-box img {
            width: 100%;
            height: 100%;
        }

        .cancel-file {
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            width: 100%;
            justify-content: flex-end;
            padding: 0 10px;
        }


    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css">
        .dropbtn {
            background-color: #3498DB;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropup {
            position: relative;
            display: inline-block;
        }

        .dropup-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            bottom: 50px;
            z-index: 1;
        }

        .dropup-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropup-content a:hover {
            background-color: #ccc;
        }

        .dropup:hover .dropup-content {
            display: block;
        }

        .dropup:hover .dropbtn {
            background-color: #2980B9;
        }

        video.remoteview, video.selfview {
            background: lightgray;
            width: 100%;
            height: 50vh;
        }

        .container-flex {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100vh;
        }

        .row-flex {
            display: flex;
            flex-direction: row;
            justify-content: center;
            width: 100%;
            padding: 8px 0;
        }

        .btn-group1 {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-evenly;
            width: 100%;
        }

        .btn-group1 button {
            width: 50px;
            height: 50px;
            border-radius: 25px;
            border: 0;
        }

        .btn-danger {
            background-color: #d9534f;
            border-color: #d43f3a;
        }

        .btn-danger:hover {
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        #hangUp{
            order: 3;
        }

        @media screen and (max-width: 590px) {
            .row-flex {
                flex-direction: column;
            }

            video.remoteview, video.selfview {
                height: 42vh;
            }

            .btn-group1 {
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: space-evenly;
                width: 100%;
            }
            .share-screen{
                display: none;
            }

            #hangUp{
                order: 6;
            }

        }

        .call .modal-content .modal-body {
            padding: 50px 0;
        }

        .call {
            text-align: center;
        }

        figure.avatar.avatar-xl {
            height: 6.1rem;
            width: 6.1rem;
        }

        .call .action-button {
            margin-top: 3rem;
        }

        .text-success {
            color: #0abb87 !important;
        }

        figure.avatar > img {
            width: 100%;
            height: 100%;
            -o-object-fit: cover;
            object-fit: cover;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        img {
            vertical-align: middle;
            border-style: none;
        }

        .action-button button {
            border-radius: 25px;
        }
		.fav{
			margin-left:2%;
		}
		.checked {
  color: orange;
}
/* Style tab links */
.tablink1 {
  background-color: #fff;
  color: black;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 50%;
  
}

.tablink1:hover {
  background-color: #fff;
  color:black;
 
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent1 {
  color: black;
  display: none;
  padding: 20px 20px;
  height: 100%;
  overflow-y: auto;
}
.contact-drawer1 {
    position: absolute;
    width: 100%;
    /* display: -webkit-box; */
    height: calc(100% - 150px);
	 //height: calc(100% - 150px);
  //overflow-y: auto;
    //: ;
    top: 100px;
	
}
.select2-container {
            z-index: 9999;
        }

    </style>
	<style>
.accordion {
  background-color: #eee;
  color: #444;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
  transition: 0.4s;
}

.active1, .accordion:hover {
  background-color: #00c292;
  color:white;
}

.accordion:after {
  content: '\002B';
  color: #777;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active1:after {
  content: "\2212";
  color:white;
}

.panel1 {
  padding: 0 18px;
  background-color: white;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s ease-out;
   height: calc(100% - 150px);
  overflow-y: auto;
}
</style>
<style>
/* plus glyph for showing collapsible panels */
.panel-heading .accordion-plus-toggle:before {
   font-family: FontAwesome;
   content: "\f068";
   float: right;
   color: black;
  
}

.panel-heading .accordion-plus-toggle.collapsed:before {
   content: "\f067";
   color: black;
}

/* arrow glyph for showing collapsible panels */
.panel-heading .accordion-arrow-toggle:before {
   font-family: FontAwesome;
   content: "\f078";
   float: right;
   color: silver;
}

.panel-heading .accordion-arrow-toggle.collapsed:before {
   content: "\f054";
   color: silver;
}

/* sets the link to the width of the entire panel title */
.panel-title > a {
   display: block;
   
}

.panel-body
{
	overflow-y: auto;
    height: calc(85vh - 150px);
}
.panel-heading
{
	 background-color: #eee;
}
.panel-heading:hover {
  background-color: #00c292;
  color:white;
}
.panel-heading a:hover{
	color:white;
}
@media only screen and (min-width: 600px) {
	.panel-body
{
	overflow-y: auto;
    height: calc(80vh - 150px);
}
}

</style>
<style>
  
.span
{
  display:none;
}

#status.main .mainWindow,
#status.child .childWindow
{
  display:table-cell;
}
</style>
</head>
<body>
<div id='status'> 
    <span class='span mainWindow'>
<!--hidden fields-->
<input type="hidden" id="user_name" value="<?= $name ?>"/>
<input type="hidden" id="user_email" value="<?= $email ?>"/>
<input type="hidden" id="firm_id" value="<?= $firm_id ?>"/>
<input type="hidden" id="group_id" value="<?= $group_id ?>"/>
<input type="hidden" id="user_id" value="<?= $user_id ?>"/>
<input type="hidden" id="user_image" value="<?= $user_image ?>"/>

<div id="wchat">
    <div class="wchat-wrapper wchat-wrapper-web wchat-wrapper-main">
        <div tabindex="-1" class="wchat two">
            <div class="drawer-manager">
                <span class="pane wchat-one"></span>
                <span class="pane wchat-two">
                    <div id="get-error">
                    </div>
                    <div id="showErrorModal" data-toggle="modal" data-target=".bs-example-modal-sm"></div>
                    <div class="pane pane-intro" id="pane-intro" style="visibility: visible">
                        <div class="intro-body">
                            <div class="intro-image" style="opacity: 1; transform: scale(1);"></div>
                            <div class="intro-text-container" style="opacity: 1; transform: translateY(0px);">
                                <h1 class="intro-title">Welcome to chat </h1>
                                <div class="intro-text">search users and start chat.
                                </div>
                            </div>
                        </div>
                    </div>


                </span>
                <span class="pane wchat-three" style="transition: all 0.3s ease;">
                    <span class="flow-drawer-container"
                          style="transform: translateX(0px);border: 1px solid rgba(0, 0, 0, .08);display:block;">
                        <div class="drawer drawer-info">
                            <header class="wchat-header">
                                <div class="header-close">
                                    <button><span class="icon icon-x  ti-close"></span></button>
                                </div>
                                <div class="header-body">
                                    <div class="header-main">
                                        <div class="header-title">Profile info</div>
                                    </div>
                                </div>
                            </header>
                            <div class="drawer-body" id="userProfile" data-list-scroll-container="true">
                                <!--Here Profile comes dynamically-->
                            </div>
                        </div>
                    </span>
                </span>
            </div>

            <!-- .chat-left-panel -->
            <div id="side" class="wchat-list wchat-one chat-left-aside left">
                <div class="open-panel"><i class="ti-angle-right"></i></div>
                <div class="chat-left-inner">
                    <div id="my-profile" style="display: none;">
                    </div>
                    <div id="contact-list">
                        <header class="wchat-header wchat-chat-header top">
                            <!--                            avatar of logged user-->
                            <div class="chat-avatar">
                                <div class="avatar icon-user-default" style="height: 40px; width: 40px;">
                                    <div class="avatar-body userimage">
                                        <img src="<?= $this->session->group_image == null ? base_url('chat_assets/storage/user_image/avatar_default.png') : base_url($this->session->group_image) ?>"
                                             class="avatar-image is-loaded" width="100%">
                                    </div>
                                </div>
                            </div>
                            <!--                            logged user name-->
                            <div class="chat-body">
                                <div class="chat-main">
                                    <h2 class="chat-title" dir="auto">
                                        <span class="wchatellips personName"><?= $name; ?></span>
                                    </h2>
                                </div>
                            </div>

                            <div class="wchat-chat-controls">
                                <div class="menu menu-horizontal">
                                    <div class="menu-item active dropdown pull-right">
                                        <button class="icon dropdown-toggle" data-toggle="dropdown" href="#">
                                            <span class="font-19"><i class="icon icon-options-vertical"></i></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-user animated flipInY">
                                            <li><a href="#"  data-toggle="modal" data-target="#exampleModal"><i class="ti-wallet"></i> Edit Profile</a></li>
                                            <li role="separator" class="divider"></li>
											<li><a href="#" onclick="get_fav()"><i class="ti-wallet"></i> favourites</a></li>
                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <a href="<?= base_url('login'); ?>">
                                                    <i class="fa fa-power-off"></i>
                                                    Logout</a>
                                            </li>
											<li><a href="#" id="chatHereId" style="display:none;" data-toggle="modal" data-target="#chatHere"><i class="ti-wallet"></i> Chat here</a></li>
                                        </ul>
                                        <!-- /.dropdown-user -->
                                    </div>
                                    <div class="menu-item right-side-toggle">
                                        <button class="icon ti-user font-20" id="grp" onclick="get_rightPanel()" title="Attach"></button>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </header>

                        <div class="form-material">
                            <input class="form-control p-lr-20 live-search-box search_bg" id="searchbox" type="text"
                                   placeholder="Search By Username or Email" onkeyup="myFunction()">
                        </div>
						
						
								
								
							<div class="contact-drawer1">
							<!--<button class="accordion" id="defaultActive">Favourite</button>
<div class="panel1 ele_active">
  <ul class="chatonline drawer-body contact-list" id="fav_list_display"
									data-list-scroll-container="true" style="display: block;">
								</ul>
</div>

<button class="accordion">All Users</button>
<div class="panel1">
   <ul class="chatonline drawer-body contact-list" id="user_list_display"
                                data-list-scroll-container="true" style="display: block;">
								</ul>
</div>

<button class="accordion">Groups</button>
<div class="panel1">
  <ul class="chatonline drawer-body contact-list" id="group_list_display"
                                data-list-scroll-container="true" style="display: block;">
								</ul>
</div>-->
						
							 
                         <button id="msg_sound" onclick="play1();"> 
            Get notification sound 
       </button> 
        <div id="sound"></div> <br/>
		<button id="call_sound" onclick="play()"> 
            Get notification sound 1
        </button><br/> 
		<button id="play" onclick="stop_play()"> 
            Get notification sound 3
        </button>
							
<div class="panel-group" id="accordion7401210" role="tablist" aria-multiselectable="false">
   <div class="panel panel-default" id="fav_msg_count">
      <div class="panel-heading" role="tab" id="heading8122873">
         <h5 class="panel-title">
            <a role="button" data-toggle="collapse" class="accordion-plus-toggle" data-parent="#accordion7401210" href="#collapse8122873" aria-expanded="true" aria-controls="collapse8122873"><i class="fa fa-star"></i> Favourite</a>
         </h5>
      </div>
      <div id="collapse8122873" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading8122873">
         <div class="panel-body"><ul class="chatonline drawer-body contact-list" id="fav_list_display"
									data-list-scroll-container="true" data-section="favourite" style="display: block;">
								</ul></div>
      </div>
   </div>
   <div class="panel panel-default" id="grp_msg_count">
      <div class="panel-heading" role="tab" id="heading411391">
         <h5 class="panel-title">
            <a role="button" data-toggle="collapse" id="grp_div" class="accordion-plus-toggle collapsed" data-parent="#accordion7401210" href="#collapse411391" aria-expanded="false" aria-controls="collapse411391"><i class="fas fa-users"></i> Groups</a>
         </h5>
      </div>
      <div id="collapse411391" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading411391">
         <div class="panel-body"><ul class="chatonline drawer-body contact-list" id="group_list_display"
                                data-list-scroll-container="true" data-section="groups" style="display: block;">
								</ul></div>
      </div>
   </div>
   <div class="panel panel-default" id="user_msg_count">
      <div class="panel-heading" role="tab" id="heading2183316">
         <h5 class="panel-title">
            <a role="button" data-toggle="collapse" class="accordion-plus-toggle collapsed" data-parent="#accordion7401210" href="#collapse2183316" aria-expanded="false" aria-controls="collapse2183316"><i class="fas fa-user"></i> All Users</a>
         </h5>
      </div>
      <div id="collapse2183316" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2183316">
         <div class="panel-body"><ul class="chatonline drawer-body contact-list" id="user_list_display"
                                data-list-scroll-container="true" data-section="users" style="display: block;">
								</ul></div>
      </div>
   </div>
</div>

                           
                        </div>

                    </div>
                </div>
            </div>
            <!-- .chat-left-panel -->
            <!-- .chat-right-panel -->

            <div tabindex="-1" id="main right" class="pane wchat-chat wchat-two chat-right-aside right"
                 style="visibility: hidden;">


                <div class="wchat-chat-tile"></div>

                <header class="wchat-header wchat-chat-header top" data-user="">
                    <button class="icon m-r-5 hidden-sm hidden-md hidden-lg open-panel" href="#"><span
                                class="font-19"><i class="icon ti-arrow-left"></i></span></button>
                    <div class="chat-avatar" id="launchProfile">
                        <div class="avatar icon-user-default" style="height: 40px; width: 40px;">
                            <div class="avatar-body userimage profile-picture" id="userImage">&nbsp;</div>
                        </div>
                    </div>
                    <div class="chat-body">
                        <div class="chat-main">
                            <h2 class="chat-title" dir="auto">
                                <span class="wchatellips personName" id="personName">&nbsp;</span>
                                <input type="hidden" name="user_id" id="chat_open_user_id">
								<input type="hidden" name="UserId" id="UserId">
                            </h2>
                        </div>
                        <div class="chat-status wchatellips" id="typing_on">
                            <!--last seen today at 8:52 PM-->
                        </div>
                    </div>
                    <div class="wchat-chat-controls">
                        <div class="menu menu-horizontal">
                            <!--                            <div class="menu-item active dropdown pull-right">-->
                            <!--                                <button id="MobileChromeplaysound1" class="hidden"></button>-->
                            <!--                                <button class="icon dropdown-toggle font-19" data-toggle="dropdown" href="#"-->
                            <!--                                        id="mute-sound1"><i class="fa fa-phone"></i></button>-->
                            <!--                            </div>-->
                            <div class="menu-item active dropdown pull-right">
                                <button class="icon dropdown-toggle font-19" data-toggle="dropdown" id="mute-sound3"
                                        onclick="startVideoCall(1)">
                                    <i class="icon icon-camrecorder font-19"></i>
                                </button>
                            </div>
                            <!--<div class="menu-item active dropdown pull-right">
                                <button id="MobileChromeplaysound" class="hidden"></button>
                                <button class="icon dropdown-toggle font-19" data-toggle="dropdown" href="#" id="mute-sound"><i class="icon icon-volume-2"></i></button>
                            </div>-->
                            <div class="mega-dropdown  pull-right">
                                <button class="dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"
                                        aria-expanded="false"><span class="font-19"><i class="icon fa fa-paperclip"></i></span>
                                </button>
                                <ul class="dropdown-menu mega-dropdown-menu animated bounceInDown"
                                    style="width: 100px;right: -13px;box-shadow:0 0 0 rgba(0, 0, 0, 0.05) !important;background: none;">
                                    <li class="col-sm-12 demo-box">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="white-box text-center bg-purple uploadFile" id="uploadFile">
                                                    <a href="#" class="text-white" data-toggle="tooltip" title=""
                                                       data-original-title="Photos"><i
                                                                class="icon ti-gallery font-19"
                                                                onclick="fileUpload(1)"></i>
                                                    </a>
                                                    <input type="file" style="display: none" id="uploadImageFile"
                                                           accept="image/*" onchange="chatPreview(1,this)">
                                                </div>
                                            </div>
                                            <!--                                            <div class="col-sm-12">-->
                                            <!--                                                <div class="white-box text-center bg-success uploadFile"><a href="#"-->
                                            <!--                                                                                                            class="text-white"-->
                                            <!--                                                                                                            data-toggle="tooltip"-->
                                            <!--                                                                                                            title=""-->
                                            <!--                                                                                                            data-original-title="Videos"><i-->
                                            <!--                                                                class="icon icon-camrecorder font-19"></i></a></div>-->
                                            <!--                                            </div>-->
                                            <div class="col-sm-12">
                                                <div class="white-box text-center bg-info uploadFile"><a href="#"
                                                                                                         class="text-white"
                                                                                                         data-toggle="tooltip"
                                                                                                         title=""
                                                                                                         onclick="fileUpload(2)"
                                                                                                         data-original-title="Document"><i
                                                                class="icon icon-doc font-19"></i></a>
                                                    <input type="file" style="display: none" accept="file/*" id="uploadDocFile"
                                                           onchange="chatPreview(2,this)">
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="menu-item active dropdown pull-right">
                                <button class="icon dropdown-toggle" data-toggle="dropdown" href="#"><span
                                            class="font-19"><i class="icon icon-options-vertical"></i></span></button>
                                <ul class="dropdown-menu dropdown-user animated flipInY">
                                    <li><a href="javascript:void(0)" onclick="javascript:ShowProfile();"><i
                                                    class="ti-user"></i> User Profile</a></li>
                                    <li><a onclick="add_to_fav(1)" id="myModal_msg"><i class="ti-star"></i> Favourite</a></li>
                                    <li><a href="javascript:void(0)"><i class="ti-wallet"></i> Email This Chat</a></li>
                                    <li><a href="javascript:void(0)"><i class="icon-doc"></i> Save Chat</a></li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </div>
                            <div class="menu-item right-side-toggle hidden-xs hidden">
                                <button class="icon ti-settings font-20" title="Attach"></button>
                                <span></span></div>
                        </div>
                    </div>
                </header>

                <div class="wchat-body wchat-chat-tile-container" style="background-size: cover;">
                    <div>
                        <span>
                            <div class="scroll-down"
                                 style="transform: scaleX(1) scaleY(1); opacity: 1; visibility:hidden;">
                                <span class="fa fa-angle-down"></span>
                            </div>
                        </span>
                        <div class="wchat-chat-msgs wchat-chat-body lastTabIndex" tabindex="0">
                            <div class="wchat-chat-empty"></div>
                            <div class="message-list">
                                <div class="chat-list" id="user_messenger_box">
                                    <!--Here content comes dynamically-->


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="wchat-filler" style="height: 0px;"></div>
                <footer tabindex="-1" class="wchat-footer wchat-chat-footer">
                    <div id="chatFrom">
                        <!--TextArea Dinamic -->
                    </div>
                    <div class="wchat-box-items-positioning-container">
                        <div class="wchat-box-items-overlay-container">
                            <div style="display: none" class="target-preview">
                                <div class="preview-container">
                                    <div class="cancel-file">
                                        <button class="btn-icon fa fa-close font-24 icon-send send-container"
                                                onclick="cancelFile()">
                                        </button>
                                        <input type="hidden" id="isFiles" value="0"/>

                                    </div>
                                    <div class="center-box">
                                        <img src="<?= base_url('') ?>chat_assets/storage/user_image/avatar_default.png"
                                             id="previewImage"/>
										<img src="<?= base_url('') ?>chat_assets/storage/user_image/document_image.png"
                                             id="previewFile"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wchat-box-items-positioning-container">
                        <div class="wchat-box-items-overlay-container">
                            <div style="display: none" class="target-emoji">
                                <?php $this->load->view('chat_view/smily_panel') ?>
                            </div>
                        </div>
                    </div>
                    <span class="mentions-positioning-container"></span>
                </footer>
                <span></span>
            </div>
            <!-- .chat-right-panel -->
        </div>
    </div>
</div>


<!-- .right-sidebar -->
<div class="right-sidebar" id="right-sidebar">
    <div class="slimscrollright">
        <div class="rpanel-title"> Groups<span><i class="ti-close right-side-toggle" onclick="close_tab()"></i></span></div>
        <div class="r-panel-body">
            <form id="group_form">
                <div><label>Create Group</label><input type="text" name="group_name" id="group_name"
                                                       placeholder="Enter Group name" class="form-control"><br>
													   <input type="hidden" name="select_groupId" id="select_groupId"></div>
                <div><label for="examplePassword11" class="">Select Users</label>
                    <select class="js-example-basic-multiple form-control" style="width: 100%;" multiple="multiple" id="Users" name="Users[]">
	
                    </select>
                </div>
				<br>
                <div>
			
                    <button type="button" class="btn btn-primary form-control" onclick="add_group()">ADD</button>
                </div>
            </form>
        </div>
        <div id="grp_data"></div>
    </div>
    <!--<div class="slimscrollright1">
       <div class="rpanel-title"> favourite<span><i class="ti-close right-side-toggle"></i></span> </div>
       <div class="r-panel-body">
           <ul class="chatonline drawer-body contact-list" id="fav_id" data-list-scroll-container="true" style="display: block;">


           </ul>
       </div>
   </div>-->
</div>
<!-- /.right-sidebar -->
<!-- .left-sidebar -->
<div class="left-sidebar" style="display:none">
    <div class="slimscrollright">
        <div class="rpanel-title"> favourite<span><i class="ti-close right-side-toggle"></i></span></div>
        <div class="r-panel-body">
            <ul class="chatonline drawer-body contact-list" id="fav_id" data-list-scroll-container="true"
                style="display: block;">
                <!--  <li class="person chatboxhead active" id="chatbox1_Deven" data-chat="person_1" href="javascript:void(0)" onclick="javascript:chatWith('Deven','1','deven.jpg','Online')">
                                    <a href="javascript:void(0)">
                                        <span class="userimage profile-picture min-profile-picture"><img src="<?php base_url() ?>chat_assets/storage/user_image/Deven.jpg" alt="Deven" class="avatar-image is-loaded bg-theme" width="100%"></span>
                                        <span>
                                            <span class="bname personName">Deven Patel</span>
                                            <span class="personStatus"><span class="time Online"><i class="fa fa-circle" aria-hidden="true"></i></span></span>
                                            <span class="count"><span class="icon-meta unread-count">2</span></span><br>
                                            <small class="preview"><span class="Online">Online</span></small>
                                        </span>
                                    </a>
                                </li> -->

            </ul>
        </div>
    </div>
</div>
<!-- /.left-sidebar -->
<!-- The Modal -->
<div id="myModal_msg" class="modal_msg">

  <!-- Modal content -->
  <div class="modal-content_msg">
    
   
  </div>

</div>
<!-- Media Uploader -->
	<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form id="uploadName">
      <div class="modal-body">
	  <div class="col-sm-3"><label>Profile Name</label></div>
        <div class="col-sm-7">
		
		<input type="text" name="UName" id="UName" class="form-control">
		</div>
		<div class="col-sm-2"><button type="button" class="btn btn-primary" onclick="upload_name()">Upload</button></div>
      </div>
      
	  </form>
	  <br>
	  <form id="uploadImage">
      <div class="modal-body">
        <div class="col-sm-3">
		<label>Profile Image</label></div>
		<div class="col-sm-7"><input type="file" name="UImage[]" id="UImage" class="form-control">
		</div>
		<div class="col-sm-2"><button type="button" class="btn btn-primary" onclick="upload_image()">Upload</button>
		</div>
      </div>
	  <br><br>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
	  </form>
    </div>
  </div>
</div>
<!--This div for modal light box chat box image-->
<div id="lightbox" style="display: none;flex-direction: column;">
    <p>
        <img src="<?php base_url() ?>chat_assets/plugins/images/close-icon-white.png"
             width="30px" style="cursor: pointer"/>
    </p>
    <div id="content" style="
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
">
        <img src="#"/>
    </div>
</div>

<div class="container-flex" id="videoBox" style="display: none">

    <div class="row-flex">
        <div class="col-sm-12 col-md-6">
            <video class="selfview" id="selfVideo" autoplay></video>
        </div>
        <div class="col-sm-12 col-md-6">
            <video class="remoteview" id="remoteVideo" muted autoplay></video>
        </div>
    </div>
    <div class="row-flex">
        <div class="btn-group1" id="operationBox" style="display: flex">
            <button id="btnAudio" onclick="updateAudioStatus(this)"
                    class="btn btn-primary" style="color: white; background: #007bff;order: 1">
                <i class="fas fa-microphone" id="audio-icon"></i>
            </button>

            <button id="btnVideo" onclick="updateVideoStatus(this)"
                    class="btn btn-primary" style="color: white; background: #007bff;order: 2">
                <i class="fas fa-video" id="video-icon"></i>
            </button>
            <button class="btn btn-danger" id="hangUp" disabled
                    onclick="hangUp()">
                <i class="fa fa-phone" style="transform: rotate(224deg);color: white;"></i>
            </button>
            <button class="btn btn-primary" onclick="switchCamera()"  style="color: white; background: #007bff; order: 4">
                <i class="fas fa-exchange-alt"></i>
            </button>
            <button class="btn btn-primary share-screen" onclick="shareScreen()"  style="color: white; background: #007bff;order: 5">
                <i class="far fa-share-square fa-w-16"></i>
            </button>
        </div>
        <div class="btn-group1" id="joinBox" style="display: none">
            <!--            <button class="btn btn-primary" onclick="joinCall()" style="border-radius:0">-->
            <!--                Join-->
            <!--            </button>-->
        </div>
    </div>
</div>

<div class="modal call" id="videoCall" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content" style="top:200px">
            <div class="modal-body">
                <div class="call">
                    <div class="row">
                        <div class="col-sm-12">
                            <figure class="mb-4 avatar avatar-xl" style="text-align:center;margin-left:45%">
                                <img src="<?php echo base_url(); ?>assets/images/avatar7.png" class="rounded-circle"
                                     alt="image">
                            </figure>
                        </div>
                        <div class="col-sm-12">
                            <h4><span id="remoteUserName"></span> <span class="text-success">video calling...</span>
                            </h4>
                        </div>
                        <div class="col-sm-12">
                            <div class="action-button">
                                <button type="button" class="btn btn-danger btn-floating btn-lg" data-dismiss="modal"
                                        onclick="hangUp()">
                                    <i class="fa fa-times"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-pulse btn-floating btn-lg"
                                        data-dismiss="modal" onclick="joinCall()">
                                    <i class="fa fa-phone"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</span>
<span class='span childWindow'>
<div class="modal call" id="chatHere" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-dialog-zoom" role="document">
        <div class="modal-content" style="top:200px">
            <div class="modal-body">
                <div class="call">
                    <div class="row">
                        <div class="col-sm-12">
                          <p> Chat is open in another window. Click "Use Here" to use Chat in this window.</p>
                        </div>
                      
                        <div class="col-sm-12">
                            <div class="action-button">
                                <button type="button" class="btn btn-success btn-floating btn-lg" data-dismiss="modal"
                                        onclick="hangUp()">
                                    Use Here
                                </button>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</span>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js"
        integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg=="
        crossorigin="anonymous"></script>
<!--This div for modal light box chat box image-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"-->
<!--        integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="-->
<!--        crossorigin="anonymous"></script>-->

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

<script src="https://chat.docango.com/socket.io/socket.io.js"></script>
<script src="<?= base_url('assets/chat/index.js') ?>"></script>
<script src="<?= base_url('assets/chat/app.js') ?>"></script>
<script src="<?= base_url('assets/chat/peer.connection.min.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
    let base_url = "<?= base_url(); ?>";
</script>

<script type="text/javascript">
    let localObject;
    $(document).ready(function () {
		
		
		//get_fav();
		//var ele_active = document.getElementById("defaultActive");
		 //ele_active.isOpen = true;
       // ele_active.classList.add("active1");
		//ele_active.click();
		 $("#play").click(function () { 
                      
                    /* Audio link for notification */ 
                    var audio = new Audio(" "); 
                    audio.play(); 
                }); 
		var file_name = 'chat_assets/storage/user_files/1609910339~March_13_review.pptx';

var fields = file_name.split('~');


var street = fields[1];

//alert(street);
	 var pName=$('.personName').html();
	 $('#UName').val(pName);
        app.getUser();
		app.getUserOptions();
		$('#Users').select2();
		 $('.js-example-basic-multiple1').select2();
        localObject = app.setValues();
        // console.log(app.local_user_id, app.local_user, app.local_firm_id, app.local_email, app.local_group_id, app.getGroups());
        //init_signal: (id, userName, firm_id, email_id, group_id, groups,type)
        signalServer
            .init_signal(localObject.userId, localObject.userName, localObject.firmId, localObject.email, localObject.groupId, app.getGroups(), 'join')

   
	});

    function updateAudioStatus() {
        Peer.onMuteAudio();
    }

    function updateVideoStatus() {
        Peer.onMuteVideo();
    }

    function hangUp() {
        Peer.hangUp();
    }

    function switchCamera() {
        Peer.switch_camera();
    }

    function shareScreen(){
        Peer.shareScreen();
    }

    function joinCall() {
        Peer.setCallee();
        $('#operationBox').css({"display": "flex"});
        $('#joinBox').css({"display": "none"});
        $('#wchat').css("display", "none");
        $('#videoBox').css("display", "flex");
    }

    async function startVideoCall(type) {
        let target = document.getElementById('chat_open_user_id').value;
        console.log(target, localObject.groupId);
        $('#operationBox').css({"display": "flex"});
        $('#joinBox').css({"display": "none"});
        await Peer.startLocalVideo();
        Peer.init(target, localObject.groupId, 1).then(async () => {
            const hangUpbtn = document.querySelector("#hangUp");
            hangUpbtn.disabled = false;
            await Peer.addStream();
            await Peer.createOffer();

        }).catch(e => console.log("*** start video call ***", e));
        ;
    }
	
	//user_list_display
/* 	jQuery("#searchbox").keyup(function () {
    var filter = jQuery("#user_list_display").val();
    jQuery("ul li").each(function () {
        if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
            jQuery(this).hide();
        } else {
            jQuery(this).show()
        }
    });
}); */

function myFunction() {
    var input, filter, ul,ul1, li,li1, a, i, txtValue;
    input = document.getElementById("searchbox");
    filter = input.value.toUpperCase();
    ul = document.getElementById("user_list_display");
	ul1 = document.getElementById("fav_list_display");
    li = ul.getElementsByTagName("li");
	li1 = ul1.getElementsByTagName("li");
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
	for (i = 0; i < li1.length; i++) {
        a = li1[i].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li1[i].style.display = "";
        } else {
            li1[i].style.display = "none";
        }
    }
}
</script>
<script type="text/javascript">

function get_rightPanel()
{
	$('#group_name').val("");
        $('#select_groupId').val("");
		$('#Users').val("");
	document.getElementById('right-sidebar').style.width = "240px";
	document.getElementById('right-sidebar').style.display = "block";
	document.getElementById('right-sidebar').style.right = "0px";
}
function close_tab()
{
	$('#group_name').val("");
        $('#select_groupId').val("");
		$('#Users').val("");
	document.getElementById('right-sidebar').style.display = "none";
}
    function openCity(evt, cityName) {
        //alert(cityName);
        var tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (let i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        $('.person.tablinks.active').children(0).removeClass('activeTab')
        tablinks = document.getElementsByClassName("tablinks");
        for (let i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
        $('.person.tablinks.active').children(0).addClass('activeTab');
    }

    function add_group() {
        var UserId = $('#user_id').val();
        //alert(UserId);
        if ($('#group_name').val() == '') {
            alert("enter group name");
        } else {
            $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/add_group",

                data: $("#group_form").serialize(),
                success: function (result) {
                    //alert(result);
					
                    console.log(result);
                    result1 = JSON.parse(result);
                     if (result1.status == 200) {
                     alert(result1.body);
					app.getUser();
					  $( ".right-sidebar" ).removeClass( "shw-rside" );
						// app.getUser();
						 //$('#group_list_display').load(location.href+ " #group_list_display").fadeIn("slow");
						//$("#group_list_display").load(location.href+" #group_list_display>*","");
						//$("#group_list_display").load(location.href + " #group_list_display");
                    }else {
                     alert(result1.body);
                    }
                },
                error: function (error) {
                    console.log(error);
                    toastr.error("something went to wrong");
                }
            });
        }
    }


    function get_grp_data() {
        var email_id = $('#Email_ID').val();
        $.ajax({
            url: '<?= base_url("Chat_Controller_Test/get_grp_data")?>',
            type: "POST",
            data: {email_id: email_id},
            success: function (sucess) {
                alert(sucess);
                // result = JSON.parse(sucess);
                // if (result.code == 200) {

                // $('#grp_data').html(result.data);
                ////$('#Users').select2();
                ////$('.select2').select2();
                // }else {
                // $('#grp_data').html(result.data);
                // }
            },
            error: function (error) {
                console.log(error);
                toastr.error("something went to wrong");
            }
        });
    }
	
	

</script>
<script type="text/javascript">
function add_to_fav() {
        var UserId = $('#user_id').val();
		var fav_user_id=$('#chat_open_user_id').val();
		var UserId1 = $('#UserId').val();
        //alert(UserId1);
       
            $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/add_to_favourite",

                data: {fav_id:fav_user_id,id:UserId1},
                success: function (result) {
                   // alert(result);
					console.log(result);
                     result1 = JSON.parse(result);
                     if (result1.status == 200) {
                     alert(result1.body);
					refreshDiv();
					app.getUser();
						get_fav();
                     }else {
						 refreshDiv();
                     alert(result1.body);
					 
                     }
                },
                error: function (error) {
                    console.log(error);
                    alert("something went to wrong");
                }
            });
        
    }
	function get_fav() {
        var email_id = $('#email').val();
		var user_name = document.getElementById('user_name').value;
        var user_email = document.getElementById('user_email').value;
        var firm_id = document.getElementById('firm_id').value;
        var group_id = document.getElementById('group_id').value;
		var user_id = document.getElementById('user_id').value;
        $.ajax({
            url: '<?= base_url("Chat_Controller_Test/get_favourite")?>',
            type: "POST",
            data: {email_id: email_id,user_name:user_name,user_email:user_email,firm_id:firm_id,group_id,user_id:user_id},
            success: function (sucess) {
                //alert(sucess);
				console.log(sucess);
                result = JSON.parse(sucess);
				console.log(result.data);
                 if (result.status == 200) {
					//$('#user_list_display').prepend(result.data);
                 $('#fav_list_display').html(result.data);
              
                }else {
                 $('#fav_list_display').html(result.data);
                }
            },
            error: function (error) {
                console.log(error);
                alert("something went to wrong");
            }
        });
    }
	</script>
	<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent1, tablinks1;
  tabcontent1 = document.getElementsByClassName("tabcontent1");
  for (i = 0; i < tabcontent1.length; i++) {
    tabcontent1[i].style.display = "none";
	
  }
  tablinks1 = document.getElementsByClassName("tablink1");
  for (i = 0; i < tablinks1.length; i++) {
    tablinks1[i].style.backgroundColor = "";
	
	
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
  //document.getElementById(pageName).style.color = "green";
  
  
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>
<script>
//
// var acc = document.getElementsByClassName("accordion");

// var i;

// for (i = 0; i < acc.length; i++) {

  // acc[i].addEventListener("click", function() {
	
    // this.classList.toggle("active1");
    // var panel = this.nextElementSibling;
	
    // if (panel.style.maxHeight) {
      // panel.style.maxHeight = null;
    // } else {
      // panel.style.maxHeight = panel.scrollHeight + "px";
    // } 
  // });
// }
//document.getElementById("defaultActive").click();
var acc = document.getElementsByClassName("accordion");

var i;
let panel1=document.getElementsByClassName('ele_active');
panel1[0].style.maxHeight = panel1[0].scrollHeight + "px";
for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
      var acc = document.getElementsByClassName("accordion");


      for (j = 0; j < acc.length; j++) {
          acc[j].classList = 'accordion';
          acc[j].nextElementSibling.style.maxHeight = null;
      }
      this.classList="accordion active";
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}

// var gIndex = 1;
 function refreshDiv(){
    // document.getElementByClassName('contact-drawer1').innerHTML = "Timer " + gIndex++;
    // var refresher = setTimeout("refreshDiv()", 1000);
	
	//var url="https://rmt.docango.com/Chat_Controller_Test";
	//alert(base_url+"assets/chat/app.js");
	
	 app.getUser();
	//$(".contact-drawer1").load(location.href + " .contact-drawer1 > *");
	 
 }
 function add_grp_member(userId)
 {
	 //alert(userId);
	 
	 $('#grp').click();
	 $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/add_group_member",

                data: {id:userId},
                success: function (result) {
                    //alert(result);
                  
					
					
                     result1 = JSON.parse(result);
					  $('#group_name').val("");
					 $('#select_groupId').val("");
                    if (result1.status == 200) {
						
                    var data=result1.data;
					$('#Users').val("");
					var len=data.length;
					for(var i=0;i< len;i++){
						//console.log(data[i]['group_name']);
					 $('#group_name').val(data[i]['group_name']);
					 $('#select_groupId').val(data[i]['group_id']);
						// console.log(data);
						// console.log(data[i]['userId']);
						var a=data[i]['email_id'];
						//$("#Users").val('aayushi.jaithila@ecovisrkca.com','accounts@india-itme.com');
						 $("#Users option[value='" + a + "']").prop("selected", true);
						  
						$('#Users').select2();
						//document.getElementById('Users').getElementsByTagName('option')[a].selected = 'selected';
					//	 document.querySelector('#Users [value="' + a + '"]').selected =  true;
					}

                    }else {
                    
                    }
                },
                error: function (error) {
                    console.log(error);
                    alert("something went to wrong");
                }
            });
 }
 function remove_grp(userId)
 {
	 //alert(userId);
	  $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/remove_group",

                data: {id:userId},
                success: function (result) {
                    console.log(result);
                      result1 = JSON.parse(result);
                     if (result1.status == 200) {
						 alert(result1.body);
						 
						 app.getUser();
                     }else {
						 alert(result1.body);
                     }
                },
                error: function (error) {
                    console.log(error);
                    alert("something went to wrong");
                }
            });
 }
 function edit_grp_name()
 {
	 document.getElementById('group_Image').style.display = "none";
	 document.getElementById('group_input').style.display = "block";
	 
	  
 }
 function update_grpName(UserId)
 {
	 //alert(UserId);
	 var grp_name=$('#grp_name').val();
	  $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/update_group_name",
                data: {group_id:UserId,grp_name:grp_name},
                success: function (result) {
                    //console.log(result);
                       result1 = JSON.parse(result);
                      if (result1.status == 200) {
						  alert(result1.body);
						  app.getUser();
						  document.getElementById('group_input').style.display = "none";
						  $("#launchProfile").click();
						  //$("#grp_div").click();
                      }else {
					  alert(result1.body);
                      }
                },
                error: function (error) {
                    console.log(error);
                    alert("something went to wrong");
                }
            });
 }
 function remove_grp_user(user_id)
 {
	 //alert(user_id);
	 $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/remove_group_user",
                data: {id:user_id},
                success: function (result) {
                    //console.log(result);
                        result1 = JSON.parse(result);
                       if (result1.status == 200) {
						   alert(result1.body);
							$("#launchProfile").click();
						  // document.getElementById('group_input').style.display = "none";
                       }else {
					  alert(result1.body);
                      }
                },
                error: function (error) {
                    console.log(error);
                    alert("something went to wrong");
                }
            });
 }
  function left_grp(group_id)
 {
	 //alert(group_id);
	 $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/left_group",
                data: {id:group_id},
                success: function (result) {
                   // console.log(result);
                        result1 = JSON.parse(result);
                      if (result1.status == 200) {
						   alert(result1.body);
							app.getUser();
						  // document.getElementById('group_input').style.display = "none";
                       }else {
					   alert(result1.body);
                       }
                },
                error: function (error) {
                    console.log(error);
                    alert("something went to wrong");
                }
            });
 }
 function upload_image()
	{
		var form_data=document.getElementById('uploadImage');
		var Form_data=new FormData(form_data);
		//alert(Form_data);
		 $.ajax({
			type: "POST",
			url: "<?= base_url("Chat_Controller_Test/upload_image") ?>",
			dataType: "json",
			data: Form_data,
			contentType:false,
			processData:false,
			success: function (result) {
				//alert(result);
//                                                               
				 if (result.status === 200) {

					// toastr.success(result.body);
					// $(location).attr('href', '<?= base_url("view_employee") ?>')
					 alert('uploaded successfully');                                                                               

					
				 } else {
					// document.getElementById('loaders7').style.display = "none";
					// toastr.error(result.body);
					alert('Not uploaded ');  
				 }
			},
			error: function (error) {
//                                                                $("#loader12").hide();
		alert();
			}
		});
	}
	function upload_name()
	{
		 if ($('#UName').val() == '') {
            alert("enter user name");
        } else {
            $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/update_uName",

                data: $("#uploadName").serialize(),
                success: function (result) {
                    //alert(result);
					
                    //console.log(result);
                    result1 = JSON.parse(result);
                     if (result1.status == 200) {
                     alert(result1.body);
					 $('.personName').html(result1.user_name);
					 $('#UName').val(result1.user_name);
					  }else {
                     alert(result1.body);
                    }
                },
                error: function (error) {
                    console.log(error);
                    toastr.error("something went to wrong");
                }
            });
        }
	}
	function groupImage(group_id)
	{
		document.getElementById('group_input').style.display = "none";
		 document.getElementById('group_Image').style.display = "block";
		 
	}
	function update_grpImage(group_id)
	{
		//alert(group_id);
		var form_data=document.getElementById('grpForm');
		var Form_data=new FormData(form_data);
		//alert(Form_data);
		 $.ajax({
			type: "POST",
			url: base_url + "Chat_Controller_Test/upload_groupImage",
			dataType: "json",
			data: Form_data,
			contentType:false,
			processData:false,
			success: function (result) {
				//alert(result);
                          
			//console.log(result);     
				 if (result.status === 200) {
					  alert('uploaded successfully');                                                                               
			document.getElementById('group_Image').style.display = "none";
					
				 } else {
					 alert('Not uploaded ');  
				 }

				 
			},
			error: function (error) {
                                                           
		alert('something went wrong');
			}
		});
	}
	
	function download_file(input)
	{
		//alert(input);
	
		 $.ajax({
                type: "POST",
                url: base_url + "Chat_Controller_Test/download_file",
                data: {input:input},
                success: function (result) {
                    console.log(result);
                      result1 = JSON.parse(result);
					  console.log(result1);
                       //if (result1.status == 200) {
						//   alert(result1.body);
							//$("#launchProfile").click();
						  // document.getElementById('group_input').style.display = "none";
                      // }else {
					 // alert(result1.body);
                     // }
                },
                error: function (error) {
                    console.log(error);
                    alert("something went to wrong");
                }
            });
	}
</script>
 <script> 
            function play1() { 
                  
                /* Audio link for notification */ 
                var mp3 = '<source src="<?= base_url() ?>chat_assets/sound/notification_tune.mp3" type="audio/mpeg">'; 
                document.getElementById("sound").innerHTML =  
                '<audio autoplay="autoplay">' + mp3 + "</audio>";
					
            } 
			function stop_play()
			{
				document.getElementById("autop").removeAttribute("loop");
			}
			function play() { 
                  var loop_sound=false;
                /* Audio link for notification */ 
				if(loop_sound==false){
                var mp3 = '<source src="<?= base_url() ?>chat_assets/sound/notification_sound.mp3" type="audio/mpeg">'; 
                document.getElementById("sound").innerHTML =  
                '<audio loop id="autop" autoplay="autoplay">' + mp3 + "</audio>";
				}
					
            } 
			function play2() { 
				 /* Audio link for notification */ 
              /*  var mp3 = '<source src="<?= base_url() ?>chat_assets/sound/got-it-done-613.mp3" type="audio/mpeg">'; 
                document.getElementById("sound").innerHTML =  
                '<audio autoplay="autoplay">' + mp3 + "</audio>";*/
				
                /* Audio link for notification */ 
                var audio = new Audio('<source src="<?= base_url() ?>chat_assets/sound/got-it-done-613.mp3" type="audio/mpeg">'); 
                audio.play(); 
				//play_call();
/*var aud=document.createElement('audio');

var att = document.createAttribute("autoplay");  
var attr = document.createAttribute("controls"); 
att.value = "autoplay";                           
	aud.setAttributeNode(att); 
    aud.setAttributeNode(attr); 
    var source=document.createElement("source");
    var att1 = document.createAttribute("src");
    var attr1 = document.createAttribute("type");
    att1.value = 'https://rmt.docango.com/chat_assets/sound/notification_sound.mp3';  
    attr1.value = "audio/mpeg";
    source.setAttributeNode(att1);
    source.setAttributeNode(attr1);
    aud.appendChild(source);*/
    
            }
			
				// console.log(type);
		// if(type!=1){
		// let aud = document.createElement('audio');

		// let att = document.createAttribute("autoplay");  
		// let attr = document.createAttribute("loop"); 
		// att.value = "autoplay";                           
		// aud.setAttributeNode(att); 
		// aud.setAttributeNode(attr); 
		// let source=document.createElement("source");
		// let att1 = document.createAttribute("src");
		// let attr1 = document.createAttribute("type");
		// att1.value = 'https://rmt.docango.com/chat_assets/sound/notification_sound.mp3';  
		// attr1.value = "audio/mpeg";
		// source.setAttributeNode(att1);
		// source.setAttributeNode(attr1);
		// aud.appendChild(source);
		// }
        </script> 
		<script type="text/javascript">
        // Broadcast that you're opening a page.
        localStorage.openpages = Date.now();
        var onLocalStorageEvent = function(e){
            if(e.key == "openpages"){
                // Listen if anybody else is opening the same page!
                localStorage.page_available = Date.now();
            }
            if(e.key == "page_available"){
                //alert("One more page already open");
				//$("#chatHereId").click();
            }
        };
        window.addEventListener('storage', onLocalStorageEvent, false);
</script>
<script>
//generate a random ID, doesn't really matter how    
if(!sessionStorage.tab) {
    var max = 99999999;
    var min = 10000000;
    sessionStorage.tab = Math.floor(Math.random() * (max - min + 1) + min);
}

//set tab_id cookie before leaving page
window.addEventListener('beforeunload', function() {
    document.cookie = 'tab_id=' + sessionStorage.tab;
});
</script>
<script>
// noprotect

var statusWindow = document.getElementById('status');
//alert(statusWindow);
//console.log(statusWindow);
(function (win)
{
    //Private variables
    var _LOCALSTORAGE_KEY = 'WINDOW_VALIDATION';
    var RECHECK_WINDOW_DELAY_MS = 100;
    var _initialized = false;
    var _isMainWindow = false;
	var WindowName = ""; //for example
    var _unloaded = false;
    var _windowArray;
    var _windowId;
    var _isNewWindowPromotedToMain = false;
    var _onWindowUpdated;

    
    function WindowStateManager(isNewWindowPromotedToMain, onWindowUpdated)
    {
        //this.resetWindows();
        _onWindowUpdated = onWindowUpdated;
        _isNewWindowPromotedToMain = isNewWindowPromotedToMain;
        _windowId = Date.now().toString();

        bindUnload();

        determineWindowState.call(this);

        _initialized = true;

        _onWindowUpdated.call(this);
    }

    //Determine the state of the window 
    //If its a main or child window
    function determineWindowState()
    {
        var self = this;
        var _previousState = _isMainWindow;

        _windowArray = localStorage.getItem(_LOCALSTORAGE_KEY);
		

        if (_windowArray === null || _windowArray === "NaN")
        {
            _windowArray = [];
        }
        else
        {
            _windowArray = JSON.parse(_windowArray);
        }

        if (_initialized)
        {
            //Determine if this window should be promoted
            if (_windowArray.length <= 1 ||
               (_isNewWindowPromotedToMain ? _windowArray[_windowArray.length - 1] : _windowArray[0]) === _windowId)
            {
                _isMainWindow = true;
				
            }
            else
            {
                _isMainWindow = false;
				
            }
        }
        else
        {
            if (_windowArray.length === 0)
            {
                _isMainWindow = true;
				
				
                _windowArray[0] = _windowId;
                localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
				
				
            }
            else
            {
                _isMainWindow = false;
				
				
                _windowArray.push(_windowId);
                localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(_windowArray));
				
            }
        }
		//console.log(_isMainWindow);
        //If the window state has been updated invoke callback
        if (_previousState !== _isMainWindow)
        {
            _onWindowUpdated.call(this);
        }

        //Perform a recheck of the window on a delay
        setTimeout(function()
                   {
                     determineWindowState.call(self);
                   }, RECHECK_WINDOW_DELAY_MS);
    }

    //Remove the window from the global count
    function removeWindow()
    {
        var __windowArray = JSON.parse(localStorage.getItem(_LOCALSTORAGE_KEY));
		//console.log(__windowArray);
        for (var i = 0, length = __windowArray.length; i < length; i++)
        {
            if (__windowArray[i] === _windowId)
            {
                __windowArray.splice(i, 1);
                break;
            }
        }
        //Update the local storage with the new array
        localStorage.setItem(_LOCALSTORAGE_KEY, JSON.stringify(__windowArray));
    }

    //Bind unloading events  
    function bindUnload()
    {
        win.addEventListener('beforeunload', function ()
        {
            if (!_unloaded)
            {
                removeWindow();
            }
        });
        win.addEventListener('unload', function ()
        {
            if (!_unloaded)
            {
                removeWindow();
            }
        });
    }

    WindowStateManager.prototype.isMainWindow = function ()
    {
        return _isMainWindow;
    };

    WindowStateManager.prototype.resetWindows = function ()
    {
		//console.log(localStorage.getItem(_LOCALSTORAGE_KEY));
        localStorage.removeItem(_LOCALSTORAGE_KEY);
    };

    win.WindowStateManager = WindowStateManager;
	})(window);

	var WindowStateManager = new WindowStateManager(true, windowUpdated);
	
	function windowUpdated()
	{
		//"this" is a reference to the WindowStateManager
		statusWindow.className = (this.isMainWindow() ? 'main' : 'child');
		var windowName1 = statusWindow.className;
		console.log(windowName1);
		//localStorage.setItem("windowName", statusWindow.className);
	}
//Resets the count in case something goes wrong in code
//WindowStateManager.resetWindows()


</script>
</body>
</html>
