<div id="container">
	<h1>ログインページ</h1>
	<?php
		echo form_open("main/login_validation/");	//フォームを開く
	?>
	<div class="error">
		<?php echo validation_errors(); ?>
	</div>
		<p>Email：<br>
		<?php echo form_input("email", $this->input->post("email"));	//Emailの入力フィールドを出力 ?>
		</p>
		<p>パスワード：<br>
		<?php echo form_password("password");	//パスワードの入力フィールドを出力 ?>
		</p>
		<p>
		<?php echo form_submit("login_submit", "Login");	//ユーザー登録ボタンを出力 ?>
		</p>
		<?php echo form_close();	//フォームを閉じる ?>
		<div class="btn-wrap">
		<a class="btn" href="<?php echo base_url() . "main/signup" ?>">会員登録する</a>
		</div>
</div>
