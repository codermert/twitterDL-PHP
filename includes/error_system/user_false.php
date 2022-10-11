<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
<style type="text/css">
	body {
	    background: #f5f5f5;
		margin: auto;
	}

	.page_500 {
		background: #fff;
		width: 35%;
		height: fit-content;
		border: 1px solid #d8d8d8;
		margin-top: 16%;
		margin-left: 32%;
	}
	
	.content {
		
	}
	
	.top_magin {
		
	}
	
	.row {
		
	}
	
	.col-md-12 {
		
	}
	
	.text-center {
		text-align: center;
	}
	
	h2 {
		font-size: 22px;
	}
	
	p {
		font-size: 14px;
	}
</style>
<title>500 Internal Server Error</title>
<?php
if (isset($_POST['user_false'])){
	
	session_destroy();

	if (isset($_COOKIE['muser'])) { 
		$s = '-0';
		setcookie("muser", trim(''), time() + $s, '/', null, null, true);
		setcookie("msession", trim(''), time() + $s, '/', null, null, true);
		setcookie("SESSIONS_USER", trim(''), time() + $s, '/', null, null, true);
	} 

	exit('<meta http-equiv="Refresh" content="0;url=login">');
	//-- 
	header("Location: login");
	exit();
}else{
?>
<form method="post">
	<input type="hidden" name="user_false"/>
	<div class="col-md-4 page_500">
		<div class="content">
			<div class="top_magin">
				<div class="row">
					<div class="col-md-12">
						<div class="text-center">
							<img src="./application/img/server.png"></img>
							<h2>500 Internal Server Error</h2>
							<p>something is wrong with the server or with your internet connection</p>
							<input class="register_btn btn_open" type="submit" Value="Retry"></input>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<?php
}
?>