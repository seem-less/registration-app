<?php
class Users extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                $this->load->model('User_model');
                $this->load->helper('url_helper');
        }

        public function index()
        {
                $data['users'] = $this->User_model->get_users();
                $data['username'] = 'Users archive';
        
                $this->load->view('templates/header', $data);
                $this->load->view('users/index', $data);
                $this->load->view('templates/footer');
        }

        public function view($slug = NULL)
        {
            $data['user'] = $this->User_model->get_users($slug);

            if (empty($data['user']))
            {
                    show_404();
            }
    
            $data['username'] = $data['user']['username'];
    
            $this->load->view('templates/header', $data);
            $this->load->view('users/view', $data);
            $this->load->view('templates/footer');
        }

        public function create()
        {
            $this->load->helper('form');
            $this->load->library('form_validation');

            $data['username'] = 'Create a new user';

            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('email', 'Email', 'callback_debounce_validation');

            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header', $data);
                $this->load->view('users/create');
                $this->load->view('templates/footer');

            }
            else
            {
                $this->User_model->set_users();
                $this->load->view('users/success');
            }
        }

        public function debounce_validation($email = NULL)
        {
            if(empty($email))
            {
                $this->form_validation->set_message('debounce_validation','Email address is required.');
                return FALSE;
            }

            $apiKey = "5e286d4f9d6c2";
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.debounce.io/v1/?api=".$apiKey."&email=".$email,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $php_response = json_decode($response, true);

            if ($err){
                echo "cURL Error #:" . $err;
                return FALSE;
            } else{
                if($php_response["debounce"]["send_transactional"] === "1"){
                    return TRUE;
                } else{
                    $this->form_validation->set_message('debounce_validation','Email address is not valid. (debounce.io)');
                    return FALSE;
                }
            }
        }
}