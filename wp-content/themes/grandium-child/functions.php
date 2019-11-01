<?php
    /**
    * Theme functions and definitions.
    */
    function grandium_child_enqueue_styles() {
    wp_enqueue_style( 'grandium-child-style',
    get_stylesheet_directory_uri() . '/style.css');
    }
    add_action( 'wp_enqueue_scripts', 'grandium_child_enqueue_styles' );