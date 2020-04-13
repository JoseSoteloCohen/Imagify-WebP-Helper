<?php

class Imagify_Webp_Picture_Disabler{
    public function __construct(){
        $webp_options = get_option('imagify_settings');
        if ($webp_options['display_webp']){
            add_filter('imagify_allow_picture_tags_for_webp', '__return_false', 10, 3);
        }
    }
}
include_once( 'imagify-webp-disabler.php' );
new Imagify_Webp_Picture_Disabler();