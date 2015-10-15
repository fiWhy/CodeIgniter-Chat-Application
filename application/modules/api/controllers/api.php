<?php
require_once APPPATH.'libraries/REST_Controller.php';

class Api extends REST_Controller
{
    /**
     * Handle get request
     * 
     * @return json
     **/
    public function index_get($module, $model, $function)
    {
        $this->load->model($module.'/'.$model);
        $options = $this->get('sort');
        $this->response($this->$model->$function($this->get('id'), $options));
    }
    
    /**
     * Handle post request
     * 
     * @return json
     **/
    public function index_post($module, $model, $function)
    {
        $this->load->model($module.'/'.$model);
        $this->response($this->$model->$function($this->post()));
    }
    
}