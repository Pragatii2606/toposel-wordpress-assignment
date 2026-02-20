<?php
function toposel_scripts() {
    // enqueue main stylesheet
    wp_enqueue_style( 'toposel-style', get_stylesheet_uri(), [], filemtime( get_stylesheet_directory() . '/style.css' ) );

    // enqueue slider script (depends on jQuery)
    wp_enqueue_script( 'toposel-slider', get_template_directory_uri() . '/js/slider.js', ['jquery'], filemtime( get_stylesheet_directory() . '/js/slider.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'toposel_scripts' );

// enable support for post thumbnails (featured images) so products can use them
add_action( 'after_setup_theme', function() {
    add_theme_support( 'post-thumbnails' );
} );