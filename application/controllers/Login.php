<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Login extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
		require APPPATH.'vendor/PHPMailer/src/Exception.php';
		require APPPATH.'vendor/PHPMailer/src/PHPMailer.php';
		require APPPATH.'vendor/PHPMailer/src/SMTP.php';

		require APPPATH.'vendor/autoload.php';
        $this->load->library('session');
        $this->load->model('Login_model');
        $this->load->model('User_model');
    }
    public function index()
    {
        if($this->Login_model->logged_id())
		{
			redirect('Login/home');
		}else{
		$this->load->view('login');
		}
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $passwordx = md5($password);
        $set = $this->Login_model->login($username, $passwordx);
        if($set)
        { 
            $log = [
                'id_user' => $set->id_user,
                'username' => $set->username,
                'id_user_level' => $set->id_user_level,
                'status' => 'Logged'
            ];
            $this->session->set_userdata($log);            
            redirect('Login/home');
          
        }
        else
        {
            $this->session->set_flashdata('message', 'Username atau Password Salah');
            redirect('login');
        }
        
    }

    public function logout()
    { 
        $this->session->sess_destroy();
        redirect('login');
    }

    public function home()
    { 
        $data['page'] = "Dashboard";
		$this->load->view('admin/index', $data);
    }
    public function daftar(){
        $this->load->view('daftar');
    }
    public function lupa_password(){
        $this->load->view('lupa_password');
    }
    public function reset_password(){
        $email = $this->input->get('b');
        $a["b"] = $email;
        $a["email"] = $email;
        $this->load->view('reset_password', $a);
    }
    public function save_daftar(){
        $this->load->model('User_model');
        $data = [
            'id_user_level' => '2',
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' => md5($this->input->post('password'))
        ];
        
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');			

        if ($this->form_validation->run() != false) {
            $cek = $this->db->get_where('user', array('email' => $this->input->post('email')))->num_rows();
            if($cek > 0){
                $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert">Email sudah digunakan!</div>');
            redirect('login/daftar');
            }else{
                $result = $this->User_model->insert($data);
                if ($result) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Berhasil daftar account silakan login dengan username dan password!</div>');
                    redirect('login/daftar');
                }
            }
           
        } else {
            $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert">Gagal mendaftarkan account!</div>');
            redirect('login/daftar');
        }
    }

    public function kirim_link(){
        $this->load->model('User_model');
        
        $this->form_validation->set_rules('email', 'email', 'required');
        $cek = $this->db->get_where('user', array('email' => $this->input->post('email')))->num_rows();
        $link = "".base_url()."/login/reset_password?b=".$this->input->post('email'); //ip laptop
        if ($this->form_validation->run() != false) {
            if($cek > 0){
                $mail = new PHPMailer(true);
			$isiEmail = "<html><head><style>.uk-button-primary {background-color: #1e87f0;color: #fff;border: 1px solid transparent;}.uk-button {margin: 0;
				border: none;
				overflow: visible;
				font: inherit;
				color: inherit;
				text-transform: none;
				display: inline-block;
				box-sizing: border-box;
				padding: 0 30px;
				vertical-align: middle;
				font-size: .875rem;
				line-height: 38px;
				text-align: center;
				text-decoration: none;
				text-transform: uppercase;
				transition: .1s ease-in-out;
				transition-property: color,background-color,border-color;
				}</style></head><body> Silakan klik link berikut untuk reset password Anda <br/><br/>
                ".$link."
				</body></html> ";

			try {
				// $mail->SMTPDebug =2 ;
				$mail->isSMTP();
				$mail->Host       = 'mail.guciwebsite.com';
				$mail->SMTPAuth   = true;
	            $mail->Username   = 'help@guciwebsite.com'; // ubah dengan alamat email Anda
	            $mail->Password   = 'Guciweb1994'; // ubah dengan password email Anda
	            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
	            $mail->Port       = 587;

	            $mail->setFrom('help@guciwebsite.com', 'Reset Password'); // ubah dengan alamat email Anda
	            $mail->addAddress($this->input->post('email'));
	            $mail->addReplyTo('help@guciwebsite.com', 'Reset Password'); // ubah dengan alamat email Anda

			    //Content
			    $mail->isHTML(true);                                  //Set email format to HTML
			    $mail->Subject = 'Reset Password';
			    $mail->Body    = $isiEmail;
			    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			    $mail->send();
			    // $object = array('otp' => $rand);
				// $this->m_android->ganti_password($object, $email);
			    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Cek inbox atau spam email anda!</div>');
                redirect('login/lupa_password');
			} catch (Exception $e) {
				// $output['error']= true;
                // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert">Message could not be sent. Mailer Error: ".{$mail->ErrorInfo}."</div>');
                redirect('login/lupa_password');
			}
                    
            }else{
                $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert">Email belum terdaftar!</div>');
                redirect('login/lupa_password');
            }
        }else{
            $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert">Gagal Kirim Email!</div>');
            redirect('login/lupa_password');
        }
    }

    public function reset(){
        
        $this->load->model('User_model');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $this->User_model->update2($email, $password);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password Berhasil direset!</div>');
		redirect('login/reset_password');
    }
}

/* End of file Login.php */
?>
