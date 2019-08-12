<?php
/**
 * Created by PhpStorm.
 * User: annashrul yusuf
 * Date: 07/08/2019
 * Time: 13:08
 */

class Site extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->control = 'Site';

        $site_data = $this->m_website->site_data();
        $this->site = str_replace(' ', '', strtolower($site_data->title));
        $this->user = $this->session->userdata($this->site . 'user');
        $this->username = $this->session->userdata($this->site . 'username');


        $this->data = array(
            'site' => $site_data,
            'account' => $this->m_website->user_data($this->user),
            'access' => $this->m_website->user_access_data($this->user)
        );
        $this->output->set_header("Cache-Control: no-store, no-cache, max-age=0, post-check=0, pre-check=0");
    }


    public function index(){
        //redirect(strtolower($this->control).'/dashboard');
        $data = $this->data;
        $function = 'login';
        $view = null;
        $data['title'] = 'Login';
        $data['content'] = $view.$function;
        if($this->form_validation->run() == false){ $this->load->view('site/login', $data); }
        else { $this->load->view('site/login', $data); }
    }

    public function dashboard(){
        //$this->access_denied(0);
        $function = 'dashboard';
        $view = null;
        $table = null;
        $data['title'] = 'Dashboard';
        $data['page'] = $function;
        $data['content'] = $view.$function;
        $data['table'] = $table;

        if($this->form_validation->run() == false){ $this->load->view('bo/index', $data); }
        else { $this->load->view('bo/index', $data); }
    }

    public function log_in(){
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));

        $cek = $this->m_website->login($username, $password);
        if($cek <> 0){
            $this->session->set_userdata($this->site . 'isLogin', TRUE);
            $this->session->set_userdata($this->site . 'notif', '1');
            $this->session->set_userdata($this->site . 'user', $cek->user_id);
            $this->session->set_userdata($this->site . 'username', $username);
            $this->session->set_userdata($this->site . 'start', time());
            $this->session->set_userdata($this->site . 'expired', $this->session->userdata($this->site . 'start') + (30 * 60) );

            redirect('site/dashboard');
        }
        else{
            echo '<script>alert("Please check again your username and password");window.location = "'.base_url().'";</script>';
        }
    }

    public function logout(){
        $this->session->unset_userdata($this->site . 'isLogin');
        $this->session->unset_userdata($this->site . 'user');
        $this->session->unset_userdata($this->site . 'lokasi');
        $this->session->unset_userdata($this->site . 'username');
        $this->session->unset_userdata($this->site . 'start');
        $this->session->unset_userdata($this->site . 'expired');
        redirect(base_url());
    }

    public function set_session($session_name_, $value_) {
        $value = base64_decode($value_);
        $session_name = base64_decode($session_name_);
        $this->session->set_userdata($session_name, $value);
    }
    public function unset_session($session) {
        $this->session->unset_userdata($session);
        echo true;
    }
    public function get_session($session_name_) {
        $session_name = base64_decode($session_name_);
        $session = $this->session->$session_name;
        echo $session;
    }

    public function set_session_date($session_name_, $value_) {
        $value = base64_decode($value_);
        $session_name = base64_decode($session_name_);
        $this->session->set_userdata('search', array($session_name=>$value));
    }

    public function get_session_date($type) {
        $field = 'field-date';
        $date = $this->session->search[$field];
        $explode_date = explode(' - ', $date);
        $get_date_1 = explode('/', $explode_date[0]);
        $get_date_2 = explode('/', $explode_date[1]);
        $date1 = $get_date_1[1].'/'.$get_date_1[2].'/'.$get_date_1[0];
        $date2 = $get_date_2[1].'/'.$get_date_2[2].'/'.$get_date_2[0];
        if (isset($date) && $date!=null) {
            if ($type == 'startDate') {
                echo $date1;
            } else {
                echo $date2;
            }
        } else {
            echo date('m/d/Y');
        }
    }
}