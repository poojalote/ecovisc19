<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
<style>
	.text-danger{
		color: red;
	}
</style>
</head>
<body>
<form id="form1" data-form-valid="thisFunction">
	<input name="username" type="text" data-valid="required|email|max=5"
		   data-msg="Please fill the username"/>
	<input name="password" type="password" data-valid="required" data-msg="Please fill the password"/>
	<button type="submit">login</button>
</form>
<form id="form2">
	<input name="username" type="text" data-valid="required" data-msg="Please fill the username" />
	<input name="password" type="password" data-valid="required" data-msg="Please fill the password"/>
	<button type="button">login</button>
</form>
<script src="<?php echo base_url(); ?>assets/modules/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/modules/jquery-validation/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
<script>
	let forms = document.forms;
	for (let i = 0; i < forms.length; i++) {
		if (forms[i].hasAttribute("data-form-valid")) {
			let formID = forms[i].getAttribute("id");
			let handlerName=forms[i].getAttribute("data-form-valid");
			let elements = forms[i].elements;
			let formRules = {};
			let formMessages = {};
			for (let e = 0; e < elements.length; e++) {
				let elementName = elements[e].getAttribute('name');
				let elementRuleObject = {};
				let elementMessageObject = {};
				if (elements[e].hasAttribute("data-valid")) {
					let rules = elements[e].getAttribute('data-valid');
					let messages = elements[e].getAttribute("data-msg");
					let validationsRules = rules.split("|");
					let validationsMessages = messages.split("|");
					validationsRules.forEach((prop, index) => {
						if (!prop.includes("=")) {
							elementRuleObject[prop] = true;
							if (validationsMessages[index]){
								elementMessageObject[prop] = validationsMessages[index];
							}else{
								console.log($.validator.messages[prop])
								elementMessageObject[prop] = $.validator.messages[prop];
							}

						} else {
							let splitProp = prop.split("=");
							elementRuleObject[splitProp[0]] = splitProp[1];
							if (validationsMessages[index]){
								elementMessageObject[splitProp[0]] = validationsMessages[index];
							}else{
								console.log($.validator.messages[splitProp[0]])
								elementMessageObject[splitProp[0]] = $.validator.messages[splitProp[0]];
							}

						}
					});
					formRules[elementName] = elementRuleObject;
					formMessages[elementName] = elementMessageObject;
				}
			}

			let hasFunction = window[handlerName];
			if (typeof hasFunction === "function"){
				console.log(formRules,formMessages);
				validation(formID,formRules,formMessages,hasFunction)
			}

		}
	}

	function thisFunction(para1) {

	}


</script>
</body>
</html>
