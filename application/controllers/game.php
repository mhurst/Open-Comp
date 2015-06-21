<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Game extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Game_Model', 'game');
        $this->output->enable_profiler(TRUE); 
    }

    public function index() {

    }
}