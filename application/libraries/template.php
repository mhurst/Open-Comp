<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template {
    var $ci;

    function __construct() {
        $this->ci =& get_instance();
    }

    function load($tpl_view, $body_view = null, $vars = null, $return = false) {
        if ( ! is_null( $body_view ) ) {
            if ( file_exists( APPPATH."views/{$tpl_view}/{$body_view}" ) ) {
                $body_view_path = "{$tpl_view}/{$body_view}";
            } else if ( file_exists( APPPATH."views/{$tpl_view}/{$body_view}.php" ) ) {
                $body_view_path = "{$tpl_view}/{$body_view}.php";
            } else if ( file_exists( APPPATH."views/{$body_view}" ) ) {
                $body_view_path = $body_view;
            } else if ( file_exists( APPPATH."views/{$body_view}.php" ) ) {
                $body_view_path = "{$body_view}.php";
            } else {
                show_error("Unable to load the requested file: {$tpl_name}/{$view_name}.php");
            }

            $body = $this->ci->load->view($body_view_path, $vars, TRUE);

            if ( is_null($vars) ) {
                $vars = array('body' => $body);
            } else if ( is_array($vars) ) {
                $vars['body'] = $body;
            } else if ( is_object($vars) ) {
                $vars->body = $body;
            }
        }
        return $this->ci->load->view("layouts/{$tpl_view}", $vars, $return);
    }
}