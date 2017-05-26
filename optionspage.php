<?php
/**
 * LikeCount Options page
 */
class LikeCountOptionsPage
{

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'facebook_page_init' ) );
        add_action( 'admin_init', array( $this, 'twitter_page_init' ) );
        add_action( 'admin_init', array( $this, 'instagram_page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'LikeCount Settings',
            'LikeCount',
            'manage_options',
            'likecount-settings',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        ?>
        <div class="wrap">
            <h1>LikeCount Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'likecount_group' );
                do_settings_sections( 'likecount-settings' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function facebook_page_init()
    {
        /**
         * LikeCount Facebook
         */
        add_settings_section(
            'likecount_facebook_option', // ID
            'Facebook', // Title
            array( $this, 'likecount_facebook_callback' ), // Callback
            'likecount-settings' // Page
        );

        add_settings_field(
            'likecount_fb_client_id', // ID
            'Facebook Client ID', // Title
            array( $this, 'likecount_fb_client_id_callback' ), // Callback
            'likecount-settings', // Page
            'likecount_facebook_option' // Section
        );

        add_settings_field(
            'likecount_fb_client_secret',
            'Facebook Client Secret',
            array( $this, 'likecount_fb_client_secret_callback' ),
            'likecount-settings',
            'likecount_facebook_option'
        );

        add_settings_field(
            'likecount_fb_page_name',
            'Facebook Page Name',
            array( $this, 'likecount_fb_page_name_callback' ),
            'likecount-settings',
            'likecount_facebook_option'
        );

        /**
         * Option Group
         */
        register_setting(
            'likecount_group', // Option group
            'likecount-facebook-data', // Option name
            array( $this, 'sanitize_facebook' ) // Sanitize
        );

    }

    /**
     * Register and add settings
     */
    public function twitter_page_init()
    {
        /**
         * LikeCount Twitter
         */
        add_settings_section(
            'likecount_twitter_option', // ID
            'Twitter', // Title
            array( $this, 'likecount_twitter_callback' ), // Callback
            'likecount-settings' // Page
        );

        add_settings_field(
            'likecount_tw_page_name',
            'Twitter Page Name',
            array( $this, 'likecount_tw_page_name_callback' ),
            'likecount-settings',
            'likecount_twitter_option'
        );

        /**
         * Option Group
         */
        register_setting(
            'likecount_group', // Option group
            'likecount-twitter-data', // Option name
            array( $this, 'sanitize_twitter' ) // Sanitize
        );
    }

    /**
     * Register and add settings
     */
    public function instagram_page_init()
    {
        /**
         * LikeCount Instagram
         */
        add_settings_section(
            'likecount_instagram_option', // ID
            'Instagram', // Title
            array( $this, 'likecount_instagram_callback' ), // Callback
            'likecount-settings' // Page
        );

        add_settings_field(
            'likecount_ig_page_name',
            'Instagram Page Name',
            array( $this, 'likecount_ig_page_name_callback' ),
            'likecount-settings',
            'likecount_instagram_option'
        );

        /**
         * Option Group
         */
        register_setting(
            'likecount_group', // Option group
            'likecount-instagram-data', // Option name
            array( $this, 'sanitize_instagram' ) // Sanitize
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_facebook( $input )
    {
        $new_input = array();

        // Facebook
        if( isset( $input['likecount_fb_client_id'] ) )
            $new_input['likecount_fb_client_id'] = absint( $input['likecount_fb_client_id'] );

        if( isset( $input['likecount_fb_client_secret'] ) )
            $new_input['likecount_fb_client_secret'] = sanitize_text_field( $input['likecount_fb_client_secret'] );

        if( isset( $input['likecount_fb_page_name'] ) )
            $new_input['likecount_fb_page_name'] = sanitize_text_field( $input['likecount_fb_page_name'] );

        return $new_input;
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_twitter( $input )
    {
        $new_input = array();

        // Twitter
        if( isset( $input['likecount_tw_page_name'] ) )
            $new_input['likecount_tw_page_name'] = sanitize_text_field( $input['likecount_tw_page_name'] );

        return $new_input;
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize_instagram( $input )
    {
        $new_input = array();

        // Instagram
        if( isset( $input['likecount_ig_page_name'] ) )
            $new_input['likecount_ig_page_name'] = sanitize_text_field( $input['likecount_ig_page_name'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function likecount_facebook_callback()
    {
        print 'Enter your Facebook credentials:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function likecount_fb_client_id_callback()
    {
        $options = get_option('likecount-facebook-data');
        printf(
            '<input type="text" id="likecount_fb_client_id" name="likecount-facebook-data[likecount_fb_client_id]" value="%s" />',
            isset( $options['likecount_fb_client_id'] ) ? esc_attr( $options['likecount_fb_client_id']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function likecount_fb_client_secret_callback()
    {
        $options = get_option('likecount-facebook-data');
        printf(
            '<input type="text" id="likecount_fb_client_secret" name="likecount-facebook-data[likecount_fb_client_secret]" value="%s" />',
            isset( $options['likecount_fb_client_secret'] ) ? esc_attr( $options['likecount_fb_client_secret']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function likecount_fb_page_name_callback()
    {
        $options = get_option('likecount-facebook-data');
        printf(
            '<input type="text" id="likecount_fb_page_name" name="likecount-facebook-data[likecount_fb_page_name]" value="%s" />',
            isset( $options['likecount_fb_page_name'] ) ? esc_attr( $options['likecount_fb_page_name']) : ''
        );
    }

    /**
     * Print the Section text
     */
    public function likecount_twitter_callback()
    {
        print 'Enter your Twitter credentials:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function likecount_tw_page_name_callback()
    {
        $options = get_option('likecount-twitter-data');
        printf(
            '<input type="text" id="likecount_tw_page_name" name="likecount-twitter-data[likecount_tw_page_name]" value="%s" />',
            isset( $options['likecount_tw_page_name'] ) ? esc_attr( $options['likecount_tw_page_name']) : ''
        );
    }

    /**
     * Print the Section text
     */
    public function likecount_instagram_callback()
    {
        print 'Enter your Instagram credentials:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function likecount_ig_page_name_callback()
    {
        $options = get_option('likecount-instagram-data');
        printf(
            '<input type="text" id="likecount_ig_page_name" name="likecount-instagram-data[likecount_ig_page_name]" value="%s" />',
            isset( $options['likecount_ig_page_name'] ) ? esc_attr( $options['likecount_ig_page_name']) : ''
        );
    }
}
