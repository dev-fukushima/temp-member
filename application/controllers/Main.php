<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->login();
	}
	public function test()
	{
		echo 'test';
	}
	public function login(){
		$this->load->view('login');
	}
	public function login_validation(){
		$this->load->helper('security');
		$this->load->library("form_validation");	//フォームバリデーションライブラリを読み込む。
		//利用頻度の高いライブラリ（HTMLヘルパー、URLヘルパーなど）はオートロード設定をしますが、
		//フォームバリデーションライブラリはログインバリデーションライブラリ内のみで読み込みます。

		$this->form_validation->set_rules("email", "メール", "required|trim|xss_clean|callback_validate_credentials");	//Email入力欄のバリデーション設定
		//$this->form_validation->set_rules("email", "メール", "required|trim|xss_clean");	//Email入力欄のバリデーション設定
		//$this->form_validation->set_rules("email", "メール", "required|trim");	//Email入力欄のバリデーション設定
		$this->form_validation->set_rules("password", "パスワード", "required|md5|trim");	//パスワード入力欄のバリデーション設定



		if($this->form_validation->run()){	//バリデーションエラーがなかった場合の処理
			$data = array(
				"email" => $this->input->post("email"),
				"is_logged_in" => 1
			);
			$this->session->set_userdata($data);
			redirect("main/members");
		}else{							//バリデーションエラーがあった場合の処理
			$this->load->view("login");
		}


	}
	public function members(){
		if($this->session->userdata("is_logged_in")){
			$this->load->view("members");
		}else{
			redirect ("main/restricted");
		}
	}
	public function restricted(){
		$this->load->view("restricted");
	}
	//ログアウト
	public function logout(){
		$this->session->sess_destroy();		//セッションデータの削除
		redirect ("main/login");		//ログインページにリダイレクトする
	}
	//会員登録
	public function signup(){
		$this->load->view("signup");
	}
	//会員登録時のバリデーション
	public function signup_validation(){
		$this->load->library("form_validation");
		$this->form_validation->set_rules("email", "Email", "required|trim|valid_email|is_unique[users.email]");
		$this->form_validation->set_rules("password", "パスワード", "required|trim");
		$this->form_validation->set_rules("cpassword", "パスワードの確認", "required|trim|matches[password]");

		$this->form_validation->set_message("is_unique", "入力したメールアドレスはすでに登録されています");

		if($this->form_validation->run()){
			//echo "Success!!";
			//ランダムキーを生成する
			$key=md5(uniqid());

			//Emailライブラリを読み込む。メールタイプをHTMLに設定（デフォルトはテキストです）
			$this->load->library("email", array("mailtype"=>"html"));
			$this->load->model("model_users");

			//送信元の情報
			$this->email->from("example@gmail.com", "送信元");
			//送信先の設定
			$this->email->to($this->input->post("email"));
			//タイトルの設定
			$this->email->subject("仮の会員登録が完了しました。");
			//メッセージの本文
			$message = "会員登録ありがとうございます。";
			// 各ユーザーにランダムキーをパーマリンクに含むURLを送信する
			$message .= '<a href="'. base_url() .'main/resister_user/' . $key . '">こちらをクリック</a>して、会員登録を完了してください。';

			$this->email->message($message);

			//ユーザーに確認メールを送信する
			if($this->model_users->add_temp_users($key)){
				if($this->email->send()){
					echo "メッセージが送信されました。";
				}else echo "メッセージは送信されませんでした。";

			//ユーザーに確認メールを送信できた場合、ユーザーを temp_users DBに追加する

		}else echo "データベースに問題が発生しました。ご迷惑をおかけします。";

		}else{
			echo "問題が発生したため表示できません。";
			$this->load->view("signup");
		}
	}

	public function resister_user($key){
		$this->load->model("model_users");

		if($this->model_users->is_valid_key($key)){	//キーが正しい場合は、以下を実行
			if($newemail = $this->model_users->add_user($key)){	//add_usersがTrueを返したら以下を実行
				//echo "success";
				$data = array(
					"email" => $newemail,
					"is_logged_in" => 1
				);
				$this->session->set_userdata($data);
				redirect ("main/members");

			}else echo "fail to add user. please try again";

		}else echo "invalid key";

	}

	public function validate_credentials(){		//Email情報がPOSTされたときに呼び出されるコールバック機能
		$this->load->model("model_users");

		if($this->model_users->can_log_in()){	//ユーザーがログインできたあとに実行する処理
			return true;
		}else{					//ユーザーがログインできなかったときに実行する処理
			$this->form_validation->set_message("validate_credentials", "ユーザー名かパスワードが異なります。");
			return false;
		}
	}
}
