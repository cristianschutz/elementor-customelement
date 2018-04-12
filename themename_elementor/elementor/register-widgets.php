<?php 
  
  /**
   * Plugin Name: Elementor Custom Elements
   * Description: Custom element added to Elementor
   * Version: 1.0
   */

  if ( ! defined( 'ABSPATH' ) ) exit;

  // This file is pretty much a boilerplate WordPress plugin.
  // It does very little except including wp-widget.php

  class ElementorCustomElement {

     private static $instance = null;

     public static function get_instance() {
        if ( ! self::$instance )
           self::$instance = new self;
        return self::$instance;
     }

     public function init(){
        add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
     }

     public function widgets_registered() {

        if(defined('ELEMENTOR_PATH') && class_exists('Elementor\Widget_Base')){

            $widget_file = 'elementor/header.php';
            $template_file = locate_template($widget_file);
            if ( $template_file && is_readable( $template_file ) ) {
                require_once $template_file;
            }

        }
     }
  }

  ElementorCustomElement::get_instance()->init();

?>