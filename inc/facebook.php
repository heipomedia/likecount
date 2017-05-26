<?php
/**
 * Get like count from Facebook
 * @return integer Like Count
 */
function likecount_facebook()
{
    // Check if transient exists
    if(get_transient( 'likecount_facebook' ) === false) :

        // Get array of Facebook options
        $options = get_option('likecount-facebook-data');

        // Client id, secret and page name
        $client_id = $options['likecount_fb_client_id'];
        $client_secret = $options['likecount_fb_client_secret'];
        $page_name =  $options['likecount_fb_page_name'];

        // Get token
        $token_url = wp_remote_get('https://graph.facebook.com/oauth/access_token?client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type=client_credentials', array('timeout' => 5));
        $status_code_token = wp_remote_retrieve_response_code($token_url);

        // Connect to API, get token, set transients
        if($status_code_token == 200) {
            $token = json_decode(wp_remote_retrieve_body($token_url));
            $token = $token->access_token;

            // Connect to Facebook API likes
            $api_url = wp_remote_get('https://graph.facebook.com/v2.8/'.$page_name.'/?fields=fan_count&access_token='.$token, array('timeout' => 5));
            $status_code = wp_remote_retrieve_response_code($api_url);

            // Retrieve body and set transient
            if($status_code == 200) {
                $api = json_decode(wp_remote_retrieve_body($api_url));
                $count = $api->fan_count;

                set_transient('likecount_facebook', $count, 24 * HOUR_IN_SECONDS);
                update_option('likecount_facebook', $count);
            } else {
                $count = get_option('likecount_facebook');
                $count = empty($count) ? 0 : $count;
                set_transient('likecount_facebook', $count, 24 * HOUR_IN_SECONDS);
            }

        } else {
            $count = get_option('likecount_facebook');
            $count = empty($count) ? 0 : $count;
            set_transient('likecount_facebook', $count, 24 * HOUR_IN_SECONDS);
        }

    endif;

    // Return facebook likes
    return get_transient( 'likecount_facebook' );
}
