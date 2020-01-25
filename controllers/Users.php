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

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'callback_debounce_validation');
        $this->form_validation->set_rules('g-recaptcha-response', 'g-recaptcha-response', 'callback_googleCaptachStore');

        if(empty($data)){
            $data = [];
        }

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('users/create');
            $this->load->view('templates/footer');

        }
        else
        {
            $this->User_model->set_users();
            $this->index();
        }
    }

    public function debounce_validation($email = NULL)
    {
        if(empty($email))
        {
            $this->form_validation->set_message('debounce_validation','The Email field is required.');
            return FALSE;
        }

        $debounce_apiKey = "INSERT DEBOUNCE API KEY HERE";
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.debounce.io/v1/?api=".$debounce_apiKey."&email=".$email,
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

    public function googleCaptachStore(){

        $secret='INSERT GOOGLE SERVER SIDE API KEY HERE';

        $postdata = http_build_query([
            "secret"=>$secret,
            "response"=>$this->input->post('g-recaptcha-response')
        ]);

        $opts = ['http' =>
            [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => $postdata
            ]
        ];

        $context  = stream_context_create($opts);
        $result = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
        $check = json_decode($result);
        
        if($check->success){
            return TRUE;
        } else{
            $this->form_validation->set_message('googleCaptachStore','Sorry Google Recaptcha Unsuccessful.');
            return FALSE;
        }
    }
}