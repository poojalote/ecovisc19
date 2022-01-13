<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><style type="text/css">
	@media (max-width: 575.98px) {
		.main-footer1
		{
			text-align: center;
			margin-bottom: 20px;
		}
	}
</style>
<footer class="main-footer main-footer1">
	<div class="footer-left">
		Copyright &copy; <?= date('Y') ?>
		<div class="bullet"></div>
		Design By <a href="#"></a>
	</div>
	<div class="footer-right">

	</div>
</footer>
</div>
<!-- wrapper end -->
</div>
<!-- app end -->
<style>
	.rightside {
		padding-top: 1%;
		padding-bottom: 1%;
		color: #68349a;

	}
	.chat_head {
		display: flex;
		flex-direction: row;
		flex: 1;
		text-align: center;
		margin-bottom: 2%;
	}

</style>
<div class="bg-white chat-button" style="position: fixed;right: 22px;bottom: 10%;margin-bottom: 37px;z-index: 99999;box-shadow: 1px 1px 4px 2px rgb(32 33 36 / 41%);" >
	<div class="bg-white  rightside d-none" id="chatFrame" style="padding:10px;z-index: 99999">
		<div class=" right12">
			<div class="chat_head">
				<div class="col-sm-10"><h4> Chat </h4></div>
				<div class="col-sm-2">
					<button class="btn btn-link"  style="padding-top: 10px;float:right;"><i
								class="fas fa-external-link-alt" style="font-size:16px;color:#68349a"></i></button>
				</div>
				<br>
			</div>
<!--			<iframe src="http://localhost:8080/new_covid/chat" id="iframe_id1" title="Iframe Example" style="border: none;
    height: 70vh;
"></iframe>-->
		</div>
	</div>
</div>
<button class="btn btn-rounded btn-primary" onclick="go_chat()" style=" position: fixed; right: 0;bottom: 10%;z-index: 99999">
	<i class="fa fa-comment"></i>
</button>


<script>
	let chatWindow;
	let windowCount=0;
	function go_chat() {
		if(windowCount === 0){
			chatWindow =window.open("https://covidcare.docango.com/chat",'Popup','width=300, height=900');
			chatWindow.setUpFrame = function(e){
				console.log("setUpFrame ",e);
			}
			setTimeout(function(){
				chatWindow.postMessage('hello',"*")
				console.log("postmessage");
			},1000);
		}else{
			chatWindow.focus();
		}
	}


</script>
<?php $this->load->view('_partials/js'); ?>
