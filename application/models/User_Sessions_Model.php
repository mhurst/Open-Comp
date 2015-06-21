<?php
require_once('User_Model.php');

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Sessions Model
 * 
 * @package    Open Comp
 * @subpackage User
 * @author     Matthew Hurst
 * 
 */

class User_Sessions_Model extends User_Model {

    /**
    * Login Method - Checks user credentials and
    * Add user data to session
    *
    * @param $username - string - required
    * @param $password - string - required
    *
    * @return Boolean true or false    
    *
    */

    public function login($username, $password) {
        $this->load->library('PasswordHash');
        
        //Get user
        $user = $this->get_by_username($username);

        //if user exist and password hash matches add to session data(log user in)
        // The return true
        if ($user &&  $this->passwordhash->CheckPassword($password, $user->password)) {
            if ($this->add_user_session($user)) {
                return true;
            }
        }

        return false;
    }

    /**
    * Logout Method - Removes user session data
    *
    * @return Boolean true or false    
    *
    */

    public function logout() {
        if ($this->session->userdata('current_user')) {
            $this->session->sess_destroy();
            return true;
        }
        return false;
    }

    /**
    * Add User Session Method - Adds user data into the session
    *
    * @param $user - object - required
    *
    * @return Boolean true or false    
    *
    */

    private function add_user_session($user) {
        //remove password from user object
        //so we can store the object in the session
        unset($user->password);
        if ($this->session->set_userdata('current_user', $user)) {
            return true;
        }

        return false;
    }

    /**
    * Register Method - Adds user to the database
    *
    * @param $options - array
    *
    * @return Boolean true or false    
    *
    */

    public function register($options = array()) {
        if (!$this->check_if_user_aready_in($options['email'], $options['username'])) {
            $this->load->library('PasswordHash');

            $options['password'] = $this->passwordhash->HashPassword($options['password']);

            $this->add($options);

            return true;
        }
        return false;
    }

    /**
    * Check If User Already Method - Checks if a user is already in the database
    *
    * @param $email - string - required
    *
    * @return Boolean true or false    
    *
    */

    public function check_if_user_aready_in($email, $username) {
        if ($this->get_or_where($email, $username)) {
            return true;
        }

        return false;
    }
}