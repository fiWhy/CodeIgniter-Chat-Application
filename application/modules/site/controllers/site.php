<?php
class Site extends MX_Controller
{
    protected $head_data = [];
    protected $content = [];
    
    /**
     * Prepare styles and scripts
     */
    public function __construct()
    {
        parent::__construct();
        $this->head_data['css'] = [
            'css/font-awesome/styles/font-awesome.min.css',
            'css/bootstrap/bootstrap.min.css',
            'css/lte/AdminLTE.min.css',
            'css/lte/style.css',
            'css/style.css',
            ];
        $this->head_data['js'] = [
            'js/jquery/jQuery-2.1.4.min.js',
            'js/bootstrap/bootstrap.min.js',
            'js/angular/angular.min.js',
            'js/angular/angular-postfix/angular-postfix.js',
            'js/angular/bootstrap-angular-ui/ui-bootstrap-0.13.1.min.js',
            'js/angular/bootstrap-angular-ui/ui-bootstrap-tpls-0.13.1.min.js',
            'js/angular/app.js'
        ];
    }
    
    /**
     * 
     * Redirect all requests to module/action
     * 
     * @param string $module
     * @param string $action
     * @param string $type
     * @param string $num
     */
    public function index($module = 'site', $action = 'index', $type = null, $num = 1)
    {
        $this->usermodel->isLoggedIn($module, $action);
        
        $this->head_data['title'] = 'Главная страница';
        $this->content['box-title'] = 'Привет!';
        if($module == 'site')
            $this->content['body'] = 'Привет';
        else {
            $module_data = modules::run($module.'/'.$action, $type, $num);
            
            $this->head_data['title'] = $module_data[1];
            $this->content['u_session'] = $this->session->userdata();
            $this->content['body'] = $module_data[0];
        }
        
        $this->loadTemplates();
    }
    
    /**
     * Append template base
     */
    protected function loadTemplates()
    { 
        $this->load->view('../views/header', $this->head_data);
        $this->load->view('../views/body', $this->content);
        $this->load->view('../views/footer');
    }
}