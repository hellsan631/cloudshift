var friendcount = getMaxFriends(thisuserid);
var friendoffset = 0;

$(document).ready(function(){
	loadFriends(friendcount);
});

function loadFriends(count){
	if(count > 0){
		setTimeout(function () {
			loadfriend(friendoffset, thisuserid);
			if (--count) loadFriends(count);
		}, 50);
	}
}

function loadfriend(offsets, userid){
	$.ajax({ url: '_listeners/listn.connect.php',
		  type: 'post',
		  async: false,
		  cache: false,
		  data: {submitType: '1', offset: offsets, user_id: userid},
		  success: function(data) {
			  var jdata = $.parseJSON(data);

			  listdatastream(jdata);

			  friendoffset++;
		  }
	});
}


function getMaxFriends(userid){
	var max = 0;

	$.ajax({ url: '_listeners/listn.connect.php',
		  type: 'post',
		  data: {submitType: '0', user_id: userid},
		  async: false,
		  cache: false,
		  success: function(data) {
			  max = data;
		  }
	});

	return max;
}

function listdatastream(jdata){
	var new_item = $("<div class=\"friend\" onclick=\"$(this).click(Profile("+jdata[0]+"));\">"+
		            	"<div class=\"pIcon-con\"><img class=\"pIcon\" src=\""+jdata[1]+"\" /></div>"+
		                "<div class=\"act-content\"><h3>"+jdata[2]+"</h3></div>"+
		                "<div class=\"act-content\"><b>Last Online:</b> "+jdata[3]+"</div></div>").hide();


	  $("#list").append(new_item);
	  new_item.fadeIn(25);
}

function Profile(linkid){
	window.location = "./profile.php?i="+linkid;
}
