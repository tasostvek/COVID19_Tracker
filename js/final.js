var RegState = 0;
$(document).ready (function(){
	//Read $_SESSION["RegState"];
	function readRegState(){
		$.ajax({
			type:"POST",
			url: "http://cis-linux2.temple.edu/~tuf91473/2305/final/php/readRegState.php",
			async:false,
			dataType:"json",
			encode:true //Return data in json form	
		}).always(function(data){
			console.log(data);
			RegState = parseInt(data.value);
		})
	}
	readRegState();
	alert("RegState = "+ RegState);
	
	/* Set views
	if(RegState == 0){
		$("#content").show();
		$("#loginView").hide();
		$("#registerView").hide();
		$("#setPasswordView").hide();
		$("#resetPasswordView").hide();
	}
	else if(RegState < 0){
		$("#content").hide();
		$("#loginView").show();
		$("#registerView").hide();
		$("#setPasswordView").hide();
		$("#resetPasswordView").hide();
	}
	else if(RegState == 7){
		$("#content").hide();
		$("#loginView").hide();
		$("#registerView").hide();
		$("#setPasswordView").show();
		$("#resetPasswordView").hide();
	}
	else if(RegState == 4){
		window.location="index.html"
	}*/
	
	
	$("#loginBtn").click(function() {
		$("#content").hide();
		$("#loginView").show();
		$("#registerView").hide();
		$("#setPasswordView").hide();
		$("#resetPasswordView").hide();
	})

	$("#registerBtn").click(function() {
		$("#content").hide();
		$("#loginView").hide();
		$("#registerView").show();
		$("#setPasswordView").hide();
		$("#resetPasswordView").hide();
	})
	$("#forgetBtn").click(function() {
		$("#content").hide();
		$("#loginView").hide();
		$("#registerView").hide();
		$("#setPasswordView").hide();
		$("#resetPasswordView").show();
	})

	$(".copy-right").click(function() {
		$("#content").hide();
		$("#loginView").show();
		$("#registerView").hide();
		$("#setPasswordView").hide();
		$("#resetPasswordView").hide();
	})

	//Implement register Ajax call here
	$("#register").click(function(event){
		event.preventDefault();
		var formData = {
			'FirstName' : $('input[name=FirstName]').val(),
			'LastName' : $('input[name=LastName]').val(),
			'Email' : $('input[name=registerEmail]').val()
		};
		$.ajax({
			type:"GET",
			url:'http://cis-linux2.temple.edu/~tuf91473/2305/final/php/register.php',
			async:false,
			data:formData,
			dataType: "json", 
			encode: true,
		}).always(function(data){
			console.log(data);
			//$("#loginView").show();
			//$("#registerView").hide();
			//$("#setPasswordView").hide();
			//$("#resetPasswordView").hide();
			$("#registerMessageBox").html(data.Message);
		});
	})
	$("#login").click(function(e){
		event.preventDefault(e);
		var isChecked = $('input[name=rememberMe]').is(':checked')? 1:0;
		var formData = {
			"Email" : $("input[name=Email]").val(),
			"Password": $("input[name=Password]").val(),
			"rememberMe":isChecked
		};
		// alert("login clicked Email=["+formData.Email+"]");
		$.ajax({
			type:"POST",
			url:"http://cis-linux2.temple.edu/~tuf91473/2305/final/php/login.php",
			async:false,
			data:formData,
			dataType:"json", 
			encode:true
		}).always(function(data){
			console.log(data);
			if (parseInt(data.RegState) == 4){
				 window.location="personalHealth.html";
			}
			$("#loginMessageBox").html(data.Message);
		});
	});

	$("#setPassword").click(function(e){
		event.preventDefault(e);
		var formData = {
			"Password": $("input[name=setPassword]").val()
		};
		// alert("login clicked Email=["+formData.Email+"]");
		$.ajax({
			type:"POST",
			url:"http://cis-linux2.temple.edu/~tuf91473/2305/final/php/setPassword.php",
			async:false,
			data:formData,
			dataType:"json", 
			encode:true
		}).always(function(data){
			console.log(data);
			$("#content").hide();
			$("#loginView").show();
			$("#registerView").hide();
			$("#setPasswordView").hide();
			$("#resetPasswordView").hide();
			$("#setMessageBox").html(data.Message);
		});
	});
		
	$("#resetPassword").click(function(e){
		event.preventDefault(e);
		var formData = {
			"Email" : $("input[name=resetEmail").val(),
		};
		// alert("login clicked Email=["+formData.Email+"]");
		$.ajax({
			type:"GET",
			url:"http://cis-linux2.temple.edu/~tuf91473/2305/final/php/resetPassword2.php",
			async:false,
			data:formData,
			dataType:"json", 
			encode:true
		}).always(function(data){
			console.log(data);
			$("#content").hide();
			$("#loginView").show();
			$("#registerView").hide();
			$("#setPasswordView").hide();
			$("#resetPasswordView").hide();
			$("#resetMessageBox").html(data.Message);
		});
	});
})