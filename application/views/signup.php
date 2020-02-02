<div id="container">
	<h1>会員登録ページ</h1>
	<?php
	echo form_open("main/signup_validation");
	echo validation_errors();
	?>
	<p>Email：<br>
	<?php echo form_input("email", $this->input->post("email"));		//Emailの入力フィールド?>
	</p>

	<p>パスワード：<br>
	<?php echo form_password("password");	//パスワードの入力フィールド?>
	</p>

	<p>パスワードの確認：<br>
	<?php echo form_password("cpassword");	//パスワード入力ミス防止用のフィールド?>
	</p>

	<p>
	<?php echo form_submit("signup_submit", "会員登録する");	//会員登録ボタン?>
	</p>
</div>
