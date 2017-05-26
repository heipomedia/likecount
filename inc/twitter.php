<?php
/**
 * Get follower count from Twitter
 */
function likecount_twitter() {

    // Check if transient exists
    if(get_transient( 'likecount_twitter' ) === false) :

        // Get page name from options
        $options = get_option('likecount-twitter-data');
        $page_name =  $options['likecount_tw_page_name'];

        // Get follower
        $api_url = wp_remote_get('https://cdn.syndication.twimg.com/widgets/followbutton/info.json?screen_names='.$page_name, array('timeout' => 5));
        $status_code = wp_remote_retrieve_response_code($api_url);

        // Set transients and update database options table
        if($status_code == 200) {
            $api = json_decode(wp_remote_retrieve_body($api_url));
            $count = $api[0]->followers_count;

            set_transient('likecount_twitter', $count, 24 * HOUR_IN_SECONDS);
            update_option('likecount_twitter', $count);
        } else {
            $count = get_option('likecount_twitter');
            set_transient('likecount_twitter', $count, 24 * HOUR_IN_SECONDS);
        }

    endif;

    // Return twitter followers
    return get_transient( 'likecount_twitter' );
}
