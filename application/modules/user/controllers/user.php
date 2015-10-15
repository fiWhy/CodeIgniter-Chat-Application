<?php
class User extends MX_Controller
{
    protected $title = 'Пользователь';
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 
     * Prepare user page box
     * 
     * @param string $type
     * @param int $num
     * @return obj viewer
     */
    public function index($type, $num)
    {
       $data['user'] = $this->session->userdata();
       $data['dialogues'] = $this->communication_model->getDialogues();
       $data['dialogues']['msg_status'] = $data['dialogues']['um_status'] == '1'?'обычный':'удалено';
       return $this->returnData('../views/user', $data, 'Главная');
    }
    
    /**
     * 
     * Prepare dialogue box
     * 
     * @param string $type
     * @param int $num
     * @return obj viewer
     */
    public function dialogue($type, $num)
    {
       $data['user'] = $this->session->userdata();
       $data['id'] = $num;
       $data['dialogues']['msg_status'] = $data['dialogues']['um_status'] == '1'?'обычный':'удалено';
       return $this->returnData('../views/dialogue', $data, 'Диалог');
    }
    
    /**
     * 
     * Prepare register box
     * 
     * @return obj viewer
     */
    public function register()
    {
        $box_title = 'Регистрация';
        $valid = $this->form_validation;
        $config = array(
               array(
                     'field'   => 'login', 
                     'label'   => 'Логин', 
                     'rules'   => 'trim|required'
                  ),
               array(
                     'field'   => 'password', 
                     'label'   => 'Пароль', 
                     'rules'   => 'trim|required|matches[passValid]|md5'
                  ),
               array(
                     'field'   => 'passValid', 
                     'label'   => 'Подтверждение пароля', 
                     'rules'   => 'trim|required'
                  ),   
               array(
                     'field'   => 'email', 
                     'label'   => 'Email', 
                     'rules'   => 'trim|required|valid_email'
                  )
            );
        
       $valid->set_rules($config);
       if($this->form_validation->run() === FALSE){
            return $this->returnData('../views/register', $data, $box_title);
       }else{
               $response = $this->usermodel->register($this->input->post());
               if($response['answer'] === FALSE)
                   $data['msg'] = $response['body'];
               else
                    redirect('user');
       }
    }
    
    /**
     * 
     * Logging user out
     * 
     */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user/login');
    }
    
    /**
     * 
     * Prepare login box
     * 
     * @return obj viewer
     */
    public function login()
    {
       $box_title = 'Авторизация';
       if($this->usermodel->login($this->input->post()))
          redirect('user');
       else{
          return $this->returnData('../views/login', ['error' => $this->session->flashdata('error')], $box_title);
       }
          
    }
    
    /**
     * 
     * Preparing of view and options to show
     * 
     * @param string $view
     * @param array $data
     * @param string $title
     * @return array
     */
    protected function returnData($view, $data, $title)
    {
        return [$this->load->view($view, $data, true), $this->title.' - '.$title];
    }
}