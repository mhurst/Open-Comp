<?php
require_once('User_Model.php');

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Sessions Model
 * 
 * @package    Open Comp
 * @subpackage User
 * @author     Matthew Hurst
 * @since      Version 0.0.1
 * 
 */

class User_Sessions_Model extends User_Model {
    public function login($username, $password) {

    }

    private function add_session() {

    }

    public function register($options = array()) {
        if (!$this->check_if_user_aready_in($options['email'], $options['username'])) {

        $this->load->library('PasswordHash');

        $options['password'] = $this->passwordhash->HashPassword($options['password']);

        User_Model::add($options);

        }

        return false;
    }

    public function check_if_user_aready_in($email, $username) {
        if (User_Model::get_where(array('email' => $email, 'username' => $username))) {
            return true;
        }

        return false;
    }
}