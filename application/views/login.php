<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>ログインページ</title>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}


	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>

<div id="container">
	<h1>ログインページ</h1>
	<?php

		echo form_open("main/login_validation/");	//フォームを開く
		echo validation_errors();
		echo "<p>Email：";
		echo form_input("email", $this->input->post("email"));	//Emailの入力フィールドを出力
		echo "</p>";

		echo "<p>パスワード：";
		echo form_password("password");	//パスワードの入力フィールドを出力
		echo "</p>";

		echo "<p>";
		echo form_submit("login_submit", "Login");	//ユーザー登録ボタンを出力
		echo "</p>";

		echo form_close();	//フォームを閉じる

		?>
		
		<a href="<?php echo base_url() . "main/signup" ?>">会員登録する</a>

</div>

</body>
</html>
