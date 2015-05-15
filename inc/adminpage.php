<?php
class CXSettingsPageServices
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page_cx_services' ) );
        add_action( 'admin_init', array( $this, 'page_init_cx_services' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page_cx_services()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'Able Services', 
            'manage_options', 
            'cx-services-admin', 
            array( $this, 'create_admin_page_cx_services' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page_cx_services()
    {
        // Set class property
        $this->options = get_option( 'cx_services' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>Contact details</h2>           
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'cx_option_group_services' );   
                do_settings_sections( 'cx-services-admin' );
                submit_button();
            ?>
            </form>
                                                
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init_cx_services()
    {        
        register_setting(
            'cx_option_group_services', // Option group
            'cx_services', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'cx_section_header_code', // ID
            '', // Title
            array( $this, 'print_section_info_header_code' ), // Callback
            'cx-services-admin' // Page
        );  
        add_settings_section(
            'cx_section_footer_code', // ID
            '', // Title
            array( $this, 'print_section_info_footer_code' ), // Callback
            'cx-services-admin' // Page
        );
        
        add_settings_field(
            'cx_webfonts_embed', // ID
            'Webfont embed code', // Title 
            array( $this, 'cx_services_webfont_callback' ), // Callback
            'cx-services-admin', // Page
            'cx_section_header_code' // Section           
        );

    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {

        if( isset( $input['cx_webfonts_embed'] ) )
            $new_input['cx_webfonts_embed'] = $input['cx_webfonts_embed'];
                    
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info_header_code()
    {
        print 'Anything here will be added to the site header.';
    }
    
    /** 
     * Print the Section text
     */
    public function print_section_info_footer_code()
    {
        print 'Anything here will be added to the site footer.';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function cx_services_webfont_callback()
    {
        printf(
            '<textarea id="cx_webfonts_embed" name="cx_services[cx_webfonts_embed]">%s</textarea>',
            isset( $this->options['cx_webfonts_embed'] ) ? esc_attr( $this->options['cx_webfonts_embed']) : ''
        );
    }

}

if( is_admin() )
    $deets_settings_page = new CXSettingsPageServices();
    
?>