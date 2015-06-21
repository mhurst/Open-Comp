<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Competition Type Model
 * 
 * @package    Open Comp
 * @subpackage Competition
 * @author     Matthew Hurst
 * 
 */

class Competition_Type_Model extends CI_Model {
    private $exclusions = array('limit', 'offset', 'sortby', 'sortdirection');
    private $table      = 'competition_types';

    /**
    * Get By Id Method - Get comp_type data based on id
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
    * Get All Method - Gets all comp_type data
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
    * Update Method - Updates comp_type data
    *
    * @param $options - Array - required
    *
    * Option: values
    * --------------
    * name  - varchar(128)
    * image - varchar(128)
    * id    - int(11) - required
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
    * Add Method - Adds comp_type data
    *
    * @param $options - Array - required
    *
    * Option: values
    * --------------
    * name  - varchar(128)
    * image - varchar(128)
    *
    * @return int - User Id or false
    *
    */

    public function add($options = array()) {
        if (is_array($options) && !empty($options)) {
            if (!isset($options['name'])) {
                return false;
            }

            $this->db->insert($this->table, $options);

            return $this->db->insert_id();
        }
        return false;
    }

    /**
    * Delete Method - Deletes comp_type data
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