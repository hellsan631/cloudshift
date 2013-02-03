<div id="<?php echo "id".$mail['id'];?>" class="small mail-con <?php echo $mail['state']; ?>">
	<div class="mail-avatar inbox-item"><img src="<?php echo $mail['avatar']; ?>&w=25" /></div>
	<div class="inbox-item text-item from"><?php echo $mail['from']; ?></div>
	<div class="inbox-item text-item subject"><?php echo $mail['subject']; ?></div>
	<div class="actions"><a href="#" id="reply"><img src="./images/reply-icon.png" class="reply-icon"/></a> <a href="#" id="delete<?php echo $mail['id']; ?>">X</a></div><div class="time"><?php echo $mail['time']; ?></div>
	<div class="text"><?php echo $mail['text']; ?></div>
</div>

<script>

    $("#<?php echo "id".$mail['id'];?>").toggle(function() {
		$(this).removeClass("small", 500);
		$.ajax({ url: 'functions/mailrock.php',
	         data: {submitType: '0', idstate: '<?php echo $mail['idstate']; ?>', id: '<?php echo $mail['id']; ?>'},
	         type: 'post'
		});
		$(this).addClass("current-item");
		$(this).removeClass("unread", 500);
    }, function() {
    	$(this).removeClass("current-item");
		$(this).addClass("small", 500);
    });

    $("#delete<?php echo $mail['id']; ?>").click(function(){
        var r = confirm("Are you sure you want to delete?");
    	if (r == true){
    		$.ajax({ url: 'functions/mailrock.php',
      	        data: {submitType: '1', id: '<?php echo $mail['id']; ?>'},
      	        type: 'post',
      	        success: function(data) {
       	        	$("#<?php echo "id".$mail['id'];?>").hide(200);
	    		}
      		});
    	}else{

    	}

    });

</script>
