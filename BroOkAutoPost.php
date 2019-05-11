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
            self::push( $post );
        }
    }


    static function push( $post ) {

        $link       = get_permalink( $post );
        $attachment = '{
                    "media": [
                        {
                            "type": "text",
                            "text": "' . $post->post_title . '"
                        },
                        {
                            "type": "text",
                            "text": "' . $post->post_excerpt . '"
                        },
                        {
                            "type": "link",
                            "url": "' . $link . '"
                        }
                    ]
                }';

        $params = array(
            "application_key" => self::$publicKey,
            "method"          => "mediatopic.post",
            "gid"             => self::$groupID,
            "type"            => "GROUP_THEME",
            "attachment"      => $attachment,
            "format"          => "json",
        );

        $sig = md5( self::arInStr( $params ) . md5( self::$accessToken . self::$privateKey ) );

        $params['access_token'] = self::$accessToken;
        $params['sig']          = $sig;

        return self::http( "https://api.ok.ru/fb.do", $params );
    }

    static function arInStr( $array ) {
        ksort( $array );

        $string = "";

        foreach ( $array as $key => $val ) {
            if ( is_array( $val ) ) {
                $string .= $key . "=" . self::arInStr( $val );
            } else {
                $string .= $key . "=" . $val;
            }
        }

        return $string;
    }

    public static function http( $url, $params = array() ) {
        $response = wp_remote_post( $url, array(
            'method'      => 'POST',
            'timeout'     => 45,
            'redirection' => 5,
            'httpversion' => '1.0',
            'blocking'    => true,
            'headers'     => array(),
            'body'        => $params,
            'cookies'     => array()
        ) );

        return $response;
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
