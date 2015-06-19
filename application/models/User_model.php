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

    public function get($id) {
        $this->db->where('id', $id);
        $query = $this->db->get($this->table);

        return $query->row();
    }

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

    public function add($options = array()) {
        if (is_array($options) && !empty($options)) {
            $this->db->insert($this->table, $options);

            return $this->db->insert_id();
        }
        return false;
    }
}