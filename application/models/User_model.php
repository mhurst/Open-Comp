<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User Model
 * 
 * @package    Open Comp
 * @subpackage User
 * @author     Matthew Hurst
 * @since      Version 0.0.1
 * 
 */

class User_Model extends CI_Model {

    private $exclusions = array('limit', 'offset', 'sortby', 'sortdirection');
    private $table      = 'users';

    public function get_user($options = array()) {

        $this->filter_incoming_options($options);

        foreach ($options as $key => $value) {
            if (!in_array($key, $this->exclusions)) {
                $this->db->where($key, $value);
            }
        }

        $query = $this->db->get($this->table);

        //If id is passed return single row.
        if (isset($options['id']) || isset($options['username']) || isset($options['email'])) {
            return $query->row();
        } else {
            return $query->result();
        }
    }

    private function filter_incoming_options($options) {

            //Check if is an array being passed
            //and that it is not empty
            if (!is_array($options) || !empty($options)) {
                return false;
            }

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
    }

}