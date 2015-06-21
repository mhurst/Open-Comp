<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once("Competition_Type_Model.php");

/**
 * Competition Model
 * 
 * @package    Open Comp
 * @subpackage Competition
 * @author     Matthew Hurst
 * 
 */

class Competition_Model extends CI_Model {
    private $exclusions = array('limit', 'offset', 'sortby', 'sortdirection');
    private $table      = 'competitions';

    /**
    * Get By Id Method - Get competition data based on id
    *
    * @param $id - int - required
    * @return Object - User data object - or false
    *
    */

    public function get_by_id($id) {
        $this->db->select("
            competitions.id as id,
            competitions.name as comp_name,
            competition_types.id as comp_type_id,
            competition_types.name as comp_type_name,
            comp_type as comp_type,
            competition_types.name as comp_type_name,
            owner as comp_owner,
            users.username as comp_owner_name,
            date_started,
            date_ended,
            rules,
            games.id as game_id,
            games.name as game_name
            ");
        $this->db->where($this->table . '.id', $id);
        $this->db->join('competition_types', 'competition_types.id = competitions.comp_type');
        $this->db->join('games', 'games.id = competitions.game_id');
        $this->db->join('users', 'users.id = competitions.owner');
        if ($query = $this->db->get($this->table)) {
            return $query->row();
        }
        return false;
    }

    /**
    * Get All Method - Gets all competition data
    *
    * @return Object - User data object - or false
    *
    */
 
    public function get_all() {
        $this->db->select("
            competitions.id as id,
            competitions.name as comp_name,
            competition_types.id as comp_type_id,
            competition_types.name as comp_type_name,
            comp_type as comp_type,
            competition_types.name as comp_type_name,
            owner as comp_owner,
            users.username as comp_owner_name,
            date_started,
            date_ended,
            rules,
            games.id as game_id,
            games.name as game_name
            ");
        $this->db->join('competition_types', 'competition_types.id = competitions.comp_type');
        $this->db->join('games', 'games.id = competitions.game_id');
        $this->db->join('users', 'users.id = competitions.owner');
        if ($query = $this->db->get($this->table)) {
            return $query->result();
        }

        return false;
    }

    /**
    * Update Method - Updates competition data
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
    * Add Method - Adds competition data
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
    * Delete Method - Deletes competition data
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