<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        phpinfo();
        $this->get();
    }

    public function get() {
        $this->load->model('User_model', 'user');

        print_r($this->user->get_user(array('id' => 1)));
    }
}