<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->model('User_Sessions_Model', 'user_sessions');
    }

    public function index() {
        $this->get();
    }

    public function get() {
        //print_r($this->user->get(7));
        $this->user_sessions->login('piznac', 'P!z656296');
        $this->output->enable_profiler(TRUE); 

        // if ($this->user_sessions->check_if_user_aready_in('matt@hurstfreelance.com', 'piznac')) {
        //     echo "already in";
        // } else {
        //     echo "not in";
        // }

        // $this->user_sessions->register(
        //     array (
        //         'username' => 'piznac',
        //         'email'    => 'matt@hurstfreelance.com',
        //         'password' => 'P!z656296'
        //         )
        //     );
    }
}