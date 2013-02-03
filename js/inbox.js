var storyoffset = 0;
var storycount = 25;
var displayed = 0;
var maxstory = getArticleCount(thisuserid);
var maxsend = getSendCount(thisuserid);

$(document).ready(function(){

	if(sendinit){
		loadSend(maxsend);
	}else{
		loadBeginning(maxstory);
	}

	//popup button events
	$("#submit").click(function(){
		$("#submit").attr("disabled", true);
	});

	$("#swap").click(function(){
		if(sendinit){
			window.location = "./inbox.php";
		}else{
			window.location = "./inbox.php?type=send";
		}
	});

	//Click out event!
	$("#backgroundPopup").click(function(){
		disablePopup();
	});

	//Press Escape event!
	$(document).keypress(function(e){
		if(e.keyCode==27 && popupStatus==1){
			disablePopup();
		}
	});



});

function loadSend(story){
	if(story > 0){
		setTimeout(function () {
			loadoutgoing(storyoffset, thisuserid);
			if (--story) loadSend(story);
		}, 50);
	}
}

function loadBeginning(story){
	if(story > 0){
		setTimeout(function () {
			loadstory(storyoffset, thisuserid);
			if (--story) loadBeginning(story);
		}, 50);
	}
}

function inboxstream(jdata){
	var new_item = $("<div class=\"small mail-con "+jdata[1]+"\">" +
	  		"<div onClick=\"$(this).click(Picture("+jdata[7]+"));\"  class=\"mail-avatar inbox-item\"><img src=\""+jdata[2]+"&w=24\" /></div>" +
	  		"<div onClick=\"$(this).click(Picture("+jdata[7]+"));\" class=\"inbox-item text-item from\">"+jdata[8]+"</div>" +
	  		"<div onClick=\"$(this).click(Inbox(this,"+jdata[0]+"));\" class=\"inbox-item text-item subject\">"+jdata[4]+"</div>" +
	  		"<div class=\"actions\">" +
	  			"<a onClick=\"$(this).click(Reply("+jdata[0]+",this,'"+jdata[3]+"','"+jdata[4]+"')); \"><img src=\"./images/reply-icon.png\" class=\"reply-icon\" /></a>" +
	  			"<a href=\"#\" onClick=\"$(this).click(Delete("+jdata[0]+",this));\">X</a></div>" +
	  		"<div onClick=\"$(this).click(Inbox(this,"+jdata[0]+"));\" class=\"time\">"+jdata[5]+"</div>" +
	  		"<div onClick=\"$(this).click(Inbox(this,"+jdata[0]+"));\" class=\"text\">"+jdata[6]+"</div>" +
	  		"</div>").hide();

	  $("#mailcon").append(new_item);
	  new_item.fadeIn(25);
}

function loadstory(offsets, userid){
	$.ajax({ url: '_listeners/listn.inbox.php',
		  type: 'post',
		  async: false,
		  cache: false,
		  data: {submitType: '0', offset: offsets, user_id: userid},
		  success: function(data) {
			  var jdata = $.parseJSON(data);

			  inboxstream(jdata);

			  displayed++;
			  storyoffset++;
		  }
	});
}

function loadoutgoing(offsets, userid){
	$.ajax({ url: '_listeners/listn.inbox.php',
		  type: 'post',
		  async: false,
		  cache: false,
		  data: {submitType: '5', offset: offsets, user_id: userid},
		  success: function(data) {
			  console.log(data);
			  var jdata = $.parseJSON(data);

			  inboxstream(jdata);

			  displayed++;
			  storyoffset++;
		  }
	});
}

function Inbox(clicked,thisid) {
	clicked = $(clicked).parent();
	if($(clicked).hasClass("small")){
		$(clicked).removeClass("small", 300);
		$(clicked).addClass("current-item");
		$(clicked).removeClass("unread", 300);
	}else{
		$(clicked).removeClass("current-item");
		$(clicked).addClass("small", 300);
	}

	if($(clicked).hasClass("unread")){
		$.ajax({ url: '_listeners/listn.inbox.php',
  	        data: {submitType: '2', id: thisid},
  	        type: 'post',
  	        success: function(data) {

    		}
  		});
	}
}

function Picture(linkid){
	window.location = "./profile.php?i="+linkid;
}

function Reply(thisid,clicked,touser,subj){
	$("#to_id").val(thisid);
	$("#to").html("<b>To:</b> "+touser);
	$("#msg_subject").val("Re: "+subj);
	//centering with css
	selectedPopup = "#newMsg";
	centerPopup();
	//load popup
	loadPopupSize("500", "545");
}

function Delete(thisid,clicked){
	if(!sendinit){
		var r = confirm("Are you sure you want to delete?");

		if (r == true){
			$.ajax({ url: '_listeners/listn.inbox.php',
	  	        data: {submitType: '1', id: thisid},
	  	        type: 'post',
	  	        success: function(data) {
	  	        	alert(data);
	  	        	$(clicked).parent().parent().hide(100);
	    		}
	  		});
		}
	}else{
		$(clicked).parent().parent().hide(100);
	}
}

function getArticleCount(userid){
	var max = 0;

	$.ajax({ url: '_listeners/listn.inbox.php',
		  type: 'post',
		  data: {submitType: '3', user_id: userid},
		  async: false,
		  cache: false,
		  success: function(data) {
			  max = data;
			  console.log(data);
		  }
	});

	return max;
}

function getSendCount(userid){
	var max = 0;

	$.ajax({ url: '_listeners/listn.inbox.php',
		  type: 'post',
		  data: {submitType: '4', user_id: userid},
		  async: false,
		  cache: false,
		  success: function(data) {
			  max = data;
			  console.log(data);
		  }
	});

	return max;
}