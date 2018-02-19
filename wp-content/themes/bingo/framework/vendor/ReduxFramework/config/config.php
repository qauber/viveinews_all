<?php

/**
 *  redq admin panel settings .
 * @since       Version 1.0
 */



if (!class_exists('redq_admin_config')) {

    class redq_admin_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {


            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }



        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'bingo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'bingo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }


        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../options/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../options/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'bingo'), $this->theme->display('Name'));

            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'bingo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'bingo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'bingo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'bingo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }








            $this->sections[] = array(
                'title'     => __('Home Settings', 'bingo'),
           //     'desc'      => __('Redux Framework was created with the developer in mind. It allows for any theme developer to have an advanced theme panel with most of the features a developer would need. For more information check out the Github repo at: <a href="https://github.com/ReduxFramework/Redux-Framework">https://github.com/ReduxFramework/Redux-Framework</a>', 'bingo'),
                'icon'      => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(



                    array(
                        'id'        => 'bingo-favicon',
                        'type'      => 'media',
                        'url'       => true,
                        'title'     => __('Custom Logo', 'bingo'),
                        'compiler'  => 'true',
                        //'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc'      => __('Upload custom Logo.', 'bingo'),
                        'default'   => '',

                    ),


                    array(
                        'id'        => 'bingo-pre-loader-button',
                        'type'      => 'switch',
                        'title'     => __('Preloader On Off', 'bingo'),
                        'default'   => false,
                    ),


                    array(
                        'id'        => 'bingo-custom-css',
                        'type'      => 'ace_editor',
                        'title'     => __('Custom CSS ', 'bingo'),
                        'subtitle'  => __('Paste your custom CSS code here.', 'bingo'),
                        'mode'      => 'css',
                        'theme'     => 'monokai',
                         'default'   => '',

                    ),


                    array(
                        'id'        => 'bingo-custom-js',
                        'type'      => 'ace_editor',
                        'title'     => __('Tracking code', 'bingo'),
                        'subtitle'  => __('Paste your JS code here.', 'bingo'),
                        'mode'      => 'javascript',
                        'theme'     => 'chrome',
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-slider',
                        'type'      => 'text',
                        'title'     => __('Home Slider shortcode', 'bingo'),
                        'desc'     => __('Please give the shortcode of the slider you want to show in the homepage of bingo', 'bingo'),
                     'default'   => false,
                    ),





                ),
            );





            $this->sections[] = array(
                'icon'      => 'el-icon-paper-clip',
                'title'     => __('Header Settings', 'bingo'),
                'fields'    => array(


                    array(
                        'id'        => 'bingo-share-button',
                        'type'      => 'switch',
                        'title'     => __('Social Icons', 'bingo'),
                        'default'   => true,
                    ),



                    array(
                        'id'        => 'bingo-buy-button',
                        'type'      => 'switch',
                        'title'     => __('Buy button', 'bingo'),
                        'default'   => true,
                    ),

                    array(
                        'id'        => 'bingo-buy-button-link',
                        'type'      => 'text',
                        'title'     => __('Buy button link', 'bingo'),
                        'required'  => array('bingo-buy-button', '=', '1'),
                         'default'   => '',
                    ),
                    array(
                        'id'        => 'bingo-phone-header',
                        'type'      => 'text',
                        'title'     => __('Phone number in header', 'bingo'),
                        'default'   => '',
                    ),
                    array(
                        'id'        => 'bingo-email-header',
                        'type'      => 'text',
                        'title'     => __('Email in header', 'bingo'),
                        'default'   => '',
                    ),

                )
            );


            $this->sections[] = array(
                'icon' => 'el-icon-braille',
                'title' => __('Top Nav Options', 'bingo'),
                'fields' => array(

                    array(
                        'id'        => 'bingo-top-language',
                        'type'      => 'switch',
                        'title'     => __('Show Language ', 'bingo'),
                        'default'   => true,
                    ),

                    array(
                        'id'        => 'bingo-language',
                        'type'      => 'multi_text',
                        'title'     => __('Language', 'bingo'),
                        'required'  => array('bingo-top-language', '=', '1'),

                        'default'   => array(
                            'en' => 'EN',
                            'de' => 'DE',
                            'it' => 'IT',
                            'fr' => 'FR',
                        )
                    ),

                    array(
                        'id'        => 'bingo-login-option',
                        'type'      => 'switch',
                        'title'     => __('Login options', 'bingo'),
                        'default'   => true,
                    ),

                    array(
                        'id'       => 'bingo-wpml-select',
                        'type'     => 'select',
                        'title'    => __('WPML language show type', 'bingo'),
                        'subtitle' => __('Select the type how you want to show language selector', 'bingo'),
                        'desc'     => __('This select type will only work if WPML activated in your theme', 'bingo'),
                        // Must provide key => value pairs for select options
                        'options'  => array(
                            'code' => 'Language Code',
                            'name' => 'Language Name',
                            'flag' => 'Flag'
                        ),
                        'default'  => 'name',
                    ),


                )
            );



            $this->sections[] = array(
                'icon'  => 'el-icon-link',
                'title' => __('Social Options', 'bingo'),
                'fields' => array(
                    array(
                        'id'        => 'bingo-facebook-link',
                        'type'      => 'text',
                        'title'     => __('Facebook', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-twitter-link',
                        'type'      => 'text',
                        'title'     => __('Twitter', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-google-link',
                        'type'      => 'text',
                        'title'     => __('Google', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-linkedin-link',
                        'type'      => 'text',
                        'title'     => __('Linkedin', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-pinterest-link',
                        'type'      => 'text',
                        'title'     => __('Pinterest', 'bingo'),
                         'default'   => '',

                    ),

                )
            );
            $this->sections[] = array(
                'icon'  => 'el-icon-photo',
                'title' => __('Contact info', 'bingo'),
                'fields' => array(
                    array(
                        'id'        => 'bingo-contact-location',
                        'type'      => 'textarea',
                        'title'     => __('Your location', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-contact-email',
                        'type'      => 'text',
                        'title'     => __('Email', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-contact-phone',
                        'type'      => 'textarea',
                        'title'     => __('Phone numbers', 'bingo'),
                         'default'   => '',

                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-photo',
                'title'     => __('Footer Options', 'bingo'),
                'fields'    => array(

                    array(
                        'id'        => 'bingo-partners-on-off',
                        'type'      => 'switch',
                        'title'     => __('Our partners On Off from all pages', 'bingo'),
                        'default'   => true,
                    ),


                    array(
                        'id'        => 'bingo-twitter-feed',
                        'type'      => 'switch',
                        'title'     => __('Show Tweets', 'bingo'),


                        'default'   => true,
                    ),
                    array(
                        'id'        => 'bingo-twitter-handle',
                        'type'      => 'text',
                        'title'     => __('Your Twitter username', 'bingo'),
                         'default'   => '',

                    ),

                    array(
                        'id'        => 'bingo-twitter-consumer-key',
                        'type'      => 'text',
                        'title'     => __('Twitter API Auth Key', 'bingo'),
                         'default'   => '',

                    ),

                    array(
                        'id'        => 'bingo-twitter-consumer-secret',
                        'type'      => 'text',
                        'title'     => __('Twitter API Auth Secret', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-twitter-user-token',
                        'type'      => 'text',
                        'title'     => __('Your Twitter Auth Token', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-twitter-user-secret',
                        'type'      => 'text',
                        'title'     => __('Your Twitter Auth Secret', 'bingo'),
                         'default'   => '',

                    ),
                    array(
                        'id'        => 'bingo-twitter-num-tweets',
                        'type'      => 'slider',
                        'title'     => __('Number of Tweets', 'bingo'),
                        'min'       => 1,
                        'max'       => 10,
                        'step'      => 1,
                        'default'   => 5
                    ),
                    array(
                        'id'               => 'footer-editor-text',
                        'type'             => 'editor',
                        'title'            => __('Footer Text', 'bingo'),
                        'subtitle'         => __('Enter the text you want to show as footer text', 'bingo'),
                        'default'          => 'Powered by UOUApps.',
                        'args'   => array(
                            'teeny'            => true,
                            'textarea_rows'    => 10
                        )
                    ),

                )
            );
            
            $this->sections[] = array(
                'icon'      => 'el-icon-photo',
                'title'     => __('Mail options', 'bingo'),
                'fields'    => array(
                    
                    //options for Mail for admin and moderators
                    array(
                        'id'        => 'bingo-send-email-to-editor',
                        'type'      => 'switch',
                        'title'     => __('Send email to editor about new video', 'bingo'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'bingo-send-email-to-administrator',
                        'type'      => 'switch',
                        'title'     => __('Send email to administrator about new video', 'bingo'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'bingo-new-video-email-subject',
                        'type'      => 'text',
                        'title'     => __('Subject of email about new video', 'bingo'),
                        'default'   => '',
                    ),
                    array(
                        'id'        => 'bingo-new-video-email-message',
                        'type'      => 'textarea',
                        'title'     => __('Message of email about new video', 'bingo'),
                        'default'   => '',
                        'description' => __('You can use shortcode: <br/> [user] - insert username <br/> [link] - post url <br/> [link_edit] - link for edit video','bingo')
                    ),
                    
                    //options for Mail for available users
                    array(
                        'id'        => 'bingo-send-email-to-available',
                        'type'      => 'switch',
                        'title'     => __('Send email to available CJ about a new video', 'bingo'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'bingo-available-mail-use-locations',
                        'type'      => 'switch',
                        'title'     => __('Send email to available CJ use locations directionality. If this options is off, then email will send to all available CJ', 'bingo'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'bingo-available-mail-subject',
                        'type'      => 'text',
                        'title'     => __('Subject of email about a new video', 'bingo'),
                        'default'   => '',
                    ),
                    array(
                        'id'        => 'bingo-available-mail-message',
                        'type'      => 'textarea',
                        'title'     => __('Message of email about a new video', 'bingo'),
                        'default'   => '',
                        'description' => __('You can use shortcode: <br/> [user] - insert username <br/> [link] - post url <br/> [location] - video location <br/> [agreement] - link for agreement with CJ','bingo')
                    ),
                )
            );

            $this->sections[] = array(
                'icon'      => 'el-icon-website',
                'title'     => __('Styling Options', 'bingo'),
                'fields'    => array(

                    array(
                        'id'        => 'bingo-body-color',
                        'type'      => 'color',
                        'title'     => __('Body Colour', 'bingo'),
                         'default'   => '',


                        'validate'  => 'color',
                    ),


                    array(
                        'id'          => 'bingo-opt-typography',
                        'type'        => 'typography', 
                        'title'       => __('Typography', 'bingo'),
                        'google'      => true, 
                        'font-backup' => true,
                        'output'      => array('body'),
                        'units'       =>'px',
                        'subtitle'    => __('Typography option with each property can be called individually.', 'bingo'),
                        'default'     => '',
                    ),




                    array(
                        'id'        => 'bingo-background',
                        'type'      => 'background',
                        'output'    => array('body'),
                        'title'     => __('Body Background', 'bingo'),
                        'subtitle'  => __('Body background with image, color, etc.', 'bingo'),
                         'default'   => '',

                    ),

                    array(
                        'id'       => 'bingo-color-primary',
                        'type'     => 'color',
                        'title'    => __('Primary Color', 'bingo'),
                        'subtitle' => __('Primary color for color scheme', 'bingo'),
                        'desc'     => __('Choose your primary color for color scheme', 'bingo'),
                        'default'  => '#a7c034',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'bingo-color-secondary',
                        'type'     => 'color',
                        'title'    => __('Secondary Color', 'bingo'),
                        'subtitle' => __('secondary color for color scheme', 'bingo'),
                        'desc'     => __('Choose your secondary color for color scheme', 'bingo'),
                        'default'  => '#738424',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'bingo-button-hover-primary',
                        'type'     => 'color',
                        'title'    => __('Button primary hover color', 'bingo'),
                        'subtitle' => __('Primary color for button hover', 'bingo'),
                        'desc'     => __('Choose your Primary color for button hover', 'bingo'),
                        'default'  => '#96ac2f',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'bingo-button-hover-secondary',
                        'type'     => 'color',
                        'title'    => __('Button secondary hover color', 'bingo'),
                        'subtitle' => __('secondary color for button hover', 'bingo'),
                        'desc'     => __('Choose your secondary color for button hover', 'bingo'),
                        'default'  => '#61701e',
                        'validate' => 'color',
                    ),

                    array(
                        'id'       => 'bingo-button-text-color',
                        'type'     => 'color',
                        'title'    => __('Button text color', 'bingo'),
                        'subtitle' => __('color for button text', 'bingo'),
                        'desc'     => __('Choose your color for button text', 'bingo'),
                        'default'  => '#423338',
                        'validate' => 'color',
                    ),



                )
            );




            $theme_info  = '<div class="redux-framework-section-desc">';
            $theme_info .= '<p class="redux-framework-theme-data description theme-uri">' . __('<strong>Theme URL:</strong> ', 'bingo') . '<a href="' . $this->theme->get('ThemeURI') . '" target="_blank">' . $this->theme->get('ThemeURI') . '</a></p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-author">' . __('<strong>Author:</strong> ', 'bingo') . $this->theme->get('Author') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-version">' . __('<strong>Version:</strong> ', 'bingo') . $this->theme->get('Version') . '</p>';
            $theme_info .= '<p class="redux-framework-theme-data description theme-description">' . $this->theme->get('Description') . '</p>';
            $tabs = $this->theme->get('Tags');
            if (!empty($tabs)) {
                $theme_info .= '<p class="redux-framework-theme-data description theme-tags">' . __('<strong>Tags:</strong> ', 'bingo') . implode(', ', $tabs) . '</p>';
            }
            $theme_info .= '</div>';

            if (file_exists(dirname(__FILE__) . '/../README.md')) {
                $this->sections['theme_docs'] = array(
                    'icon'      => 'el-icon-list-alt',
                    'title'     => __('Documentation', 'bingo'),
                    'fields'    => array(
                        array(
                            'id'        => '17',
                            'type'      => 'raw',
                            'markdown'  => true,
                            'content'   => file_get_contents(dirname(__FILE__) . '/../README.md')
                        ),
                    ),
                );
            }


            $this->sections[] = array(
                'title'     => __('Import / Export', 'bingo'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'bingo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );




            if (file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
                $tabs['docs'] = array(
                    'icon'      => 'el-icon-book',
                    'title'     => __('Documentation', 'bingo'),
                    'content'   => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
                );
            }
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'bingo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'bingo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'bingo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'bingo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'bingo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'bingo_option_data',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => false,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Bingo Options', 'bingo'),
                'page_title'        => __('Bingo Options', 'bingo'),

                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyBj4Lx93qjbVn9_p3Kqx178aDp4G6YrFeg', // Must be defined to add google fonts to the typography module

                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => 'bingo_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.

                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE


            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/probaldhar',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://twitter.com/probaldhar',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://linkedin.com/probaldhar/',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }

            } else {

            }


        }

    }

    global $reduxConfig;
    $reduxConfig = new redq_admin_config();
}


if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;


if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';


        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
