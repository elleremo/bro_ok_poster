<?php

/*
Plugin Name: OK Poster
Author: elleremo
Version: 1.0.0
*/

class BroOkAutoPost {

}

function bro_ok_poster__init() {

    new BroOkAutoPost();
}

add_action( 'plugins_loaded', 'bro_ok_poster__init', 20 );


add_action( 'plugins_loaded', function () {
    require_once( plugin_dir_path( __FILE__ ) . 'include/addSettingsPageOK.php' );
    new addSettingsPageOK();
} );
