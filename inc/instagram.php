<?php
/**
 * Get follower count from Instagram
 */
function likecount_instagram() {

    // Check if transient exists
    if(get_transient( 'likecount_instagram' ) === false) :

        // Get page name from options
        $options = get_option('likecount-instagram-data');
        $page_name =  $options['likecount_ig_page_name'];

        // Get follower
        $api_url = wp_remote_get('https://www.instagram.com/'.$page_name.'/?__a=1', array('timeout' => 5));
        $status_code = wp_remote_retrieve_response_code($api_url);

        // Set transients and update database options table
        if($status_code == 200) {
            $api = json_decode(wp_remote_retrieve_body($api_url));
            $count = $api->user->followed_by->count;

            set_transient('likecount_instagram', $count, 24 * HOUR_IN_SECONDS);
            update_option('likecount_instagram', $count);
        } else {
            $count = get_option('likecount_instagram');
            set_transient('likecount_instagram', $count, 24 * HOUR_IN_SECONDS);
        }

    endif;

    // Return instagram followers
    return get_transient( 'likecount_instagram' );
}
