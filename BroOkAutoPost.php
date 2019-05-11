<?php

/*
Plugin Name: OK Poster
Author: elleremo
Version: 1.0.0
*/

class BroOkAutoPost {

    public static $accessToken;
    public static $privateKey;  // Секретный ключ приложения
    public static $publicKey;  // Публичный ключ приложения
    public static $groupID;  // ID нашей группы

    public function __construct() {

        self::$accessToken = get_option( 'ok_app_ACCESS_TOKEN', false );
        self::$privateKey  = get_option( 'ok_app_PRIVATE_KEY', false );
        self::$publicKey   = get_option( 'ok_app_PUBLIC_KEY', false );
        self::$groupID     = get_option( 'ok_app_GROUP_ID', false );

        add_action( 'transition_post_status', [ __CLASS__, 'sendText' ], 10, 3 );

    }

    public static function sendText($new_status, $oldStatus, $post ) {
        if ( 'publish' === $new_status  && 'publish' !== $oldStatus ) {

        }
    }

}

function bro_ok_poster__init() {

    new BroOkAutoPost();
}

add_action( 'plugins_loaded', 'bro_ok_poster__init', 20 );


add_action( 'plugins_loaded', function () {
    require_once( plugin_dir_path( __FILE__ ) . 'include/addSettingsPageOK.php' );
    new addSettingsPageOK();
} );
