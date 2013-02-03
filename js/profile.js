$(document).ready(function(){
	$("#makeFriend").click(function(){
		$.ajax({ url: '_listeners/listn.profile.php',
			  type: 'post',
			  cache: false,
			  data: {submitType: '0', user_id: thisid},
			  success: function(data) {
				  alert(data);
			  }
		});
	});

	$("#comment_submit").click(function(){

		var texts = $("#enter_comment").val();

		$.ajax({ url: '_listeners/listn.profile.php',
			  type: 'post',
			  cache: false,
			  data: {submitType: '1', text: texts, user_id: thisid},
			  success: function(data) {
				  var jdata = $.parseJSON(data);
				  if(jdata[0] == 1){
					  var new_item = $("<div class=\"comment\"><h3>"+jdata[2]+"</h3>"+texts+"</div>").hide();
					  $("#comment-area").prepend(new_item);
					  new_item.fadeIn(350);
					  $("#enter_comment").val("");
				  }else if(jdata[0] == 0){
					  alert(jdata[1]);
				  }
			  }
		});
	});

	$("#enter_comment").click(function(){
		$(this).addClass("active");
	});

	$("#enter_comment").blur(function() {
		$(this).removeClass("active");
	});
});