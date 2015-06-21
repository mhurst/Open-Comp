<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model
 * 
 * @package    Open Comp
 * @subpackage User
 * @author     Matthew Hurst
 * 
 */

class User_Model extends CI_Model {

    private $exclusions = array('limit', 'offset', 'sortby', 'sortdirection');
    private $table      = 'users';

    /**
    * Get By Id Method - Get user data based on user id
    *
    * @param $id - int - required
    * @return Object - User data object - or false
    *
    */

    public function get_by_id($id) {
        $this->db->where('id', $id);
        if ($query = $this->db->get($this->table)) {
            return $query->row();
        }
        return false;
    }

    /**
    * Get By Username Method - Get user data based on username
    *
    * @param $username - varchar(128) - required
    * @return Object - User data object - or false
    *
    */

    public function get_by_username($username) {
        $this->db->where('username', $username);
        if ($query = $this->db->get($this->table)) {
            return $query->row();           
        }
        return false;        
    }

    /**
    * Get Where Method - Get user data based on any field
    * Also can pass limit, offset, sortby, sortdirection
    * for sorting or pagaination
    *
    * @param $options - Array - required
    *
    * Option: values
    * --------------
    * username - varchar(128)
    * email    - varchar(128)
    * password - varchar(256)
    * id       - int(11)
    * status   - int(1)
    *
    * @return Object - User data object - or false
    *
    */

    public function get_where($options = array()) {
        //Check if is an array being passed
        //and that it is not empty
        if (is_array($options) && !empty($options)) {
            // limits / offsets
            if (isset($options['limit']) && isset($options['offset'])) {
                $this->db->limit($options['limit'], $options['offset']);
            } else if (isset($options['limit'])) {
                $this->db->limit($options['limit']);
            }
            //sort
            if (isset($options['sortby']) && isset($options['sortdirection'])) {
                $this->db->order_by($options['sortby'], $options['sortdirection']);
            }

            foreach ($options as $key => $value) {
                if (!in_array($key, $this->exclusions)) {
                    $this->db->where($key, $value);
                }
            }

            $query = $this->db->get($this->table);

            return $query->result();
        }

        return false;
    }

    /**
    * Get Or Where Method - Get user data based on
    * either username or email
    *
    * @param  $username - varchar(128) - required
    * @param  $email    - varchar(128) - required
    * @return Object - User data object - or false
    *
    */

    public function get_or_where($email, $username) {
        $this->db->or_where(
                array(
                    'username' => $username,
                    'email'    => $email
                )
            );

        if ($query = $this->db->get($this->table)) {
            return $query->result();
        }

        return false;
    }

    /**
    * Get All Method - Gets all user data
    *
    * @return Object - User data object - or false
    *
    */
 
    public function get_all() {
        if ($query = $this->db->get($this->table)) {
            return $query->result();
        }

        return false;
    }

    /**
    * Update Method - Updates user data
    *
    * @param $options - Array - required
    *
    * Option: values
    * --------------
    * username - varchar(128)
    * email    - varchar(128)
    * password - varchar(256)
    * id       - int(11) - required
    * status   - int(1)
    *
    * @return Boolean - true or false
    *
    */
    public function update($options = array()) {
        if (is_array($options) && isset($options['id'])) {
            foreach ($options as $key => $value) {
                if ($key != 'id') {
                    $this->db->set($key, $value);
                }
            }

            $this->db->where('id', $options['id']);
            $this->db->update($this->table);

            return true;
        }

        return false;
    }

    /**
    * Add Method - Adds user data
    *
    * @param $options - Array - required
    *
    * Option: values
    * --------------
    * username - varchar(128) - required
    * email    - varchar(128) - required
    * password - varchar(256) - required
    * status   - int(1)
    *
    * @return int - User Id or false
    *
    */

    public function add($options = array()) {
        if (is_array($options) && !empty($options)) {
            if (
                !isset($options['username']) ||
                !isset($options['email']) ||
                !isset($options['password'])
                ) {
                return false;
            }

            $this->db->insert($this->table, $options);

            return $this->db->insert_id();
        }
        return false;
    }

    /**
    * Delete Method - Deletes user data
    *
    * @param $id - Int - required
    *
    * @return Boolean - true or false
    *
    */

    public function delete($id) {
        if ($this->db->delete($this->table, array('id' => $id))) {
            return true;
        }

        return false;
    }
}