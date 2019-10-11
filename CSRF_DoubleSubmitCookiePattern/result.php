<?php
if(isset($_POST['username'],$_POST['password'])){
	$uname = $_POST['username'];
	$pwd = $_POST['password'];
	if($uname == 'admin' && $pwd == 'pass'){
		echo 'Login successful';
		session_start();
		$_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
		$session_id = session_id();
		setcookie('sessionCookie',$session_id,time()+ 60*60*24*365 ,'/');
		setcookie('csrfTokenCookie',$_SESSION['token'],time()+ 60*60*24*365 ,'/');
		
	}else{
		echo '<h1>Invalid Credentials</h1>';
		exit();
	}
}
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>CSRF - Double Submit Cokkie Pattern</title>
        <link rel="stylesheet" href="CSS/result_style.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <script>
	
	        $(document).ready(function(){
	
	        var cookie_value = "";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';');
	        var csrf = decodedCookie.split(';')[2]
	        // alert(decodedCookie)
	        if(csrf.split('=')[0] = "csrfTokenCookie" ){
		    // alert(csrf.split('csrfTokenCookie=')[1])
		    cookie_value = csrf.split('csrfTokenCookie=')[1];
		    document.getElementById("tokenIn_hidden_field").setAttribute('value', cookie_value) ;
	    }
	    });

        </script>
    </head>

    <body>
        
        <div class="insert-box">
            <form class="form" action="home.php" method="post">
            <h1>Insert Data</h1>
            <div class="textbox">
                <input type="text" name="updatepost" id="username" class="form-control">
            </div>

            <div id="div1">
				<input type="hidden" name="token" value="" id="tokenIn_hidden_field"/>
			</div>

            <input class="btn" type="submit" name="Login" value="Submit">
            </form>
        </div>
    </body>
</html>