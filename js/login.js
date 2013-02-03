var points = 0;
var password;
var passpoints;
var current = "#login-con";

$(document).ready(function(){

	$("#signup-con").hide();
	$("#fp-con").hide();

	$("#username").bind('change keyup input',  function(){

		$("#uimg").removeClass("hidden", 100);

		var length = $(this).val().length;

		if(length == 2){
			$("#uimg").attr("src", "./images/-mark.png"); $("#uimg").attr("alt", "Length Should Be 5 or Greater");
		}else if(length == 5){
			$("#uimg").attr("src", "./images/checkmark.png"); $("#uimg").attr("alt", "Length Requirement Passed");
		}

	});

	$("#semail").bind('change keyup input',  function(){

		$("#eimg").removeClass("hidden", 100);

		var length = $(this).val().length;

		if(length == 4){ $("#eimg").attr("src", "./images/-mark.png"); points = 1;}
		else if(length < 4){points = 0; $("#eimg").attr("src", "./images/xmark.png"); $("#eimg").attr("alt", "Validating...");}

		var value = jQuery.trim($(this).val()).substring(length-1, length);

		if(value == '@'){points = 2;}else if(value == '.' && points == 2){points = 3;}

		if(points >= 3){$("#eimg").attr("src", "./images/checkmark.png"); $("#eimg").attr("alt", "Email Validated");}

	});

	$("#spass").bind('change keyup input',  function(){

		$("#pimg").removeClass("hidden", 100);

		passpoints = $(this).val().length;
		password = $(this).val();

		var has_letter		= new RegExp("[a-z]");
		var has_caps		= new RegExp("[A-Z]");
		var has_numbers		= new RegExp("[0-9]");

		if(has_letter.test(password)) 	{ passpoints += 4; }
		if(has_caps.test(password)) 		{ passpoints += 4; }
		if(has_numbers.test(password)) 	{ passpoints += 4; }

		if(passpoints == 2){
			$("#pimg").attr("src", "./images/-mark.png"); $("#pimg").attr("alt", "Password Strength too Low");
		}else if(passpoints > 10){
			$("#pimg").attr("src", "./images/checkmark.png"); $("#pimg").attr("alt", "Password is OK");
		}

	});

	$("#cpass").bind('change keyup input',  function(){

		$("#cimg").removeClass("hidden", 100);

		if($(this).val() == password){
			$("#cimg").attr("src", "./images/checkmark.png");
		}

	});

	$("#signup-tag").click(function() {
		var ms = 400;
		var effect = "drop";
		var hideme = { direction: "right" };
		var showme = { direction: "left" };

		$(current).hide(effect, hideme, ms);
		current = "#signup-con";
		$(current).show(effect, showme, ms);
		$("#resultlog").html("");

	});

	$("#login-tag").click(function() {
		var ms = 400;
		var effect = "drop";
		var hideme = { direction: "left" };
		var showme = { direction: "right" };

		$(current).hide(effect, hideme, ms);
		current = "#login-con";
		$(current).show(effect, showme, ms);
		$("#results").html("");

	});

	$("#back-tag").click(function() {
		var ms = 400;
		var effect = "drop";
		var hideme = { direction: "down" };
		var showme = { direction: "left" };

		$(current).hide(effect, hideme, ms);
		current = "#login-con";
		$(current).show(effect, showme, ms);
		$("#results").html("");

	});

	$("#fp").click(function() {
		var ms = 400;
		var effect = "drop";
		var hideme = { direction: "left" };
		var showme = { direction: "down" };

		$(current).hide(effect, hideme, ms);
		current = "#fp-con";
		$(current).show(effect, showme, ms);
		$("#fpresults").html("");

	});


	$("#pass").focus(function() {
	      if (this.value === this.defaultValue) {
	          this.value = '';
				this.type = 'password';
				$("#pass").addClass("hovered");
	      }
	}).blur(function() {
	      if (this.value === '') {
	          this.value = this.defaultValue;
				this.type = 'text';
				$("#pass").removeClass("hovered");
	      }
	});

	$("#spass").focus(function() {
		if(this.value === this.defaultValue) {
			this.value = '';
			this.type = 'password';
			$("#spass").addClass("hovered");
		}
	}).blur(function() {
		if (this.value === '') {
			this.value = this.defaultValue;
			this.type = 'text';
			$("#spass").removeClass("hovered");
		}
	});

	$("#cpass").focus(function() {
		if(this.value === this.defaultValue) {
			this.value = '';
			this.type = 'password';
			$("#cpass").addClass("hovered");
		}
	}).blur(function() {
		if(this.value === '') {
			this.value = this.defaultValue;
			this.type = 'text';
			$("#cpass").removeClass("hovered");
		}
	});

	$("#email").focus(function() {
		if (this.value === this.defaultValue) {
		    this.value = '';
		    $("#email").addClass("hovered");
		}
	}).blur(function() {
		if (this.value === '') {
		    this.value = this.defaultValue;
		    $("#email").removeClass("hovered");
		}
	});

	$("#semail")
	.focus(function() {
		if(this.value === this.defaultValue) {
			this.value = '';
			$("#semail").addClass("hovered");
		}
	}).blur(function() {
		if (this.value === '') {
			this.value = this.defaultValue;
			$("#semail").removeClass("hovered");
		}
	});

	$("#username")
	.focus(function() {
		if (this.value === this.defaultValue) {
			this.value = '';
			$("#username").addClass("hovered");
		}
	}).blur(function() {
		if (this.value === '') {
			this.value = this.defaultValue;
			$("#username").removeClass("hovered");
		}
	});
});