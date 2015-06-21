<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_Sessions_Model', 'user_sessions');
        $this->output->enable_profiler(TRUE); 
    }

    public function index() {
        $this->get();
    }

    public function get() {
        print_r($this->user_sessions->get_by_id(7));
    }
}