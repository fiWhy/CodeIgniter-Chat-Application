<?php

class UserModel extends CI_Model {

    /**
     * 
     * Check if user is logged ing
     * 
     * @param string $module
     * @param string $action
     */
    public function isLoggedIn($module, $action) {
        $login = $this->session->userdata('login');
        if (empty($login) && $action != 'register' && $action != 'login') {
            redirect('user/login');
        }elseif(!empty($login) && $module == 'user' && ($action == 'register' || $action == 'login')){
            redirect('user');
        }
    }
    
    /**
     * 
     * Login user
     * 
     * @param array $data
     * @return boolean
     */
    public function login($data)
    {
        if(!empty($data)){
            $user = $this->db->get_where('user', ['login'=>  addslashes($data['login']), 'password' => md5($data['password'])]);
            
            if(!empty($user->row())){
                $this->makeSession($user->result_array()[0]);
                return true; 
            }else{
                $this->session->set_flashdata('error', 'Не правильный логин или пароль!');
                return false;
            }
        }
    }

    /**
     * 
     * Register an user
     * 
     * @param array $data
     * @return array
     */
    public function register($data) {
        $answer = FALSE;

        unset($data['passValid']);
        array_filter($data);
        if ($this->upload_avatar($data['login'])) {
            $file_data = $this->upload->data();
            $data['avatar'] = '/modules/user/img/' . $file_data['file_name'];
            if ($this->db->insert('user', $data) && $this->makeSession($data)) {
                $answer = TRUE;
            } else {
                $message = 'Не удалось добавить пользователя... Ошибка: '.$this->db->error_message();
                unlink($file_data['full_path']);
            }
        } else {
            $message = $this->upload->display_errors();
        }
            
        
        return [
            'answer' => $answer,
            'body' =>
            [
                'title' => 'Ошибка!',
                'message' => $message,
            ]
        ];
    }
    
    /**
     * 
     * Push data to session
     * 
     * @param array $data
     */
    public function makeSession($data)
    {
        $this->session->set_userdata($data);
    }

    /**
     * 
     * Upload avatar during register
     * 
     * @param string $login
     * @return boolean
     */
    public function upload_avatar($login) {
        $config['upload_path'] = APPPATH . '/modules/user/img/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['file_name'] = $login;
        $config['max_size'] = '100';
        $config['max_width'] = '50';
        $config['max_height'] = '50';
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file'))
            return true;
        else
            return false;
    }

}
