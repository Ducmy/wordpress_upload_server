<?php
/**
 * fPsychology functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @subpackage fPsychology
 * @author tishonator
 * @since fPsychology 1.0.0
 *
 */

/**
 * Set a constant that holds the theme's minimum supported PHP version.
 */
define( 'FPSYCHOLOGY_MIN_PHP_VERSION', '5.6' );

/**
 * Immediately after theme switch is fired we we want to check php version and
 * revert to previously active theme if version is below our minimum.
 */
add_action( 'after_switch_theme', 'fpsychology_test_for_min_php' );

/**
 * Switches back to the previous theme if the minimum PHP version is not met.
 */
function fpsychology_test_for_min_php() {

	// Compare versions.
	if ( version_compare( PHP_VERSION, FPSYCHOLOGY_MIN_PHP_VERSION, '<' ) ) {
		// Site doesn't meet themes min php requirements, add notice...
		add_action( 'admin_notices', 'fpsychology_min_php_not_met_notice' );
		// ... and switch back to previous theme.
		switch_theme( get_option( 'theme_switched' ) );
		return false;

	};
}

/**
 * An error notice that can be displayed if the Minimum PHP version is not met.
 */
function fpsychology_min_php_not_met_notice() {
	?>
	<div class="notice notice-error is_dismissable">
		<p>
			<?php esc_html_e( 'You need to update your PHP version to run this theme.', 'fpsychology' ); ?> <br />
			<?php
			printf(
				/* translators: 1 is the current PHP version string, 2 is the minmum supported php version string of the theme */
				esc_html__( 'Actual version is: %1$s, required version is: %2$s.', 'fpsychology' ),
				PHP_VERSION,
				FPSYCHOLOGY_MIN_PHP_VERSION
			); // phpcs: XSS ok.
			?>
		</p>
	</div>
	<?php
}


require_once( trailingslashit( get_template_directory() ) . 'customize-pro/class-customize.php' );

if ( ! function_exists( 'fpsychology_setup' ) ) :
/**
 * fPsychology setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 */
function fpsychology_setup() {

	load_theme_textdomain( 'fpsychology', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( "title-tag" );

	// add custom header
    add_theme_support( 'custom-header', array (
                       'default-image'          => '',
                       'random-default'         => '',
                       'flex-height'            => true,
                       'flex-width'             => true,
                       'uploads'                => true,
                       'width'                  => 900,
                       'height'                 => 100,
                       'default-text-color'        => '#000000',
                       'wp-head-callback'       => 'fpsychology_header_style',
                    ) );

    // add custom logo
    add_theme_support( 'custom-logo', array (
                       'width'                  => 145,
                       'height'                 => 36,
                       'flex-height'            => true,
                       'flex-width'             => true,
                    ) );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );

	// add the visual editor to resemble the theme style
	add_editor_style( 'css/editor-style.css' );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Primary Menu', 'fpsychology' ),
		'footer'    => __( 'Footer Menu', 'fpsychology' ),
	) );

	

	// add Custom background				 
	add_theme_support( 'custom-background', 
				   array ('default-color'  => '#FFFFFF')
				 );

	add_theme_support( 'post-thumbnails' );


	global $content_width;
	if ( ! isset( $content_width ) )
		$content_width = 900;

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form', 'comment-list',
	) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(

		'widgets' => array(
			'sidebar-widget-area' => array(
				'search',
				'recent-posts',
				'categories',
				'archives',
			),

			'homepage-column-1-widget-area' => array(
				'text_business_info'
			),

			'homepage-column-2-widget-area' => array(
				'text_about'
			),

			'footer-column-1-widget-area' => array(
				'recent-comments'
			),

			'footer-column-2-widget-area' => array(
				'recent-posts'
			),

			'footer-column-3-widget-area' => array(
				'calendar'
			),
		),

		'posts' => array(
			'home',
			'blog',
			'about',
			'contact'
		),

		// Create the custom image attachments used as slides
		'attachments' => array(
			'image-slide-1' => array(
				'post_title' => _x( 'Slider Image 1', 'Theme starter content', 'fpsychology' ),
				'file' => 'images/slider/1.jpg', // URL relative to the template directory.
			),
			'image-slide-2' => array(
				'post_title' => _x( 'Slider Image 2', 'Theme starter content', 'fpsychology' ),
				'file' => 'images/slider/2.jpg', // URL relative to the template directory.
			),
			'image-slide-3' => array(
				'post_title' => _x( 'Slider Image 3', 'Theme starter content', 'fpsychology' ),
				'file' => 'images/slider/3.jpg', // URL relative to the template directory.
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'fpsychology_slider_display' => 1,
			'fpsychology_slide1_image' => '{{image-slider-1}}',
			'fpsychology_slide1_content' => _x( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Theme starter content', 'fpsychology' ),
			'fpsychology_slide2_image' => '{{image-slider-2}}',
			'fpsychology_slide2_content' => _x( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Theme starter content', 'fpsychology' ),
			'fpsychology_slide3_image' => '{{image-slider-3}}',
			'fpsychology_slide3_content' => _x( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_facebook' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_twitter' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_linkedin' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_instagram' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_rss' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_tumblr' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_youtube' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_pinterest' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_vk' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_flickr' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_social_vine' => _x( '#', 'Theme starter content', 'fpsychology' ),
			'fpsychology_header_phone' => _x( 'info@example.com', 'Theme starter content', 'fpsychology' ),
			'fpsychology_header_email' => _x( '1.555.555.555', 'Theme starter content', 'fpsychology' ),
		),

		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'fpsychology' ),
				'items' => array(
					'link_home',
					'page_blog',
					'page_contact',
					'page_about',
				),
			),

			// Assign a menu to the "primary" location.
			'primary' => array(
				'name' => __( 'Primary Menu', 'fpsychology' ),
				'items' => array(
					'link_home',
					'page_blog',
					'page_contact',
					'page_about',
				),
			),

			// Assign a menu to the "footer" location.
			'footer' => array(
				'name' => __( 'Footer Menu', 'fpsychology' ),
				'items' => array(
					'link_home',
					'page_about',
					'page_blog',
					'page_contact',
				),
			),
		),
	);

	$starter_content = apply_filters( 'fpsychology_starter_content', $starter_content );
	add_theme_support( 'starter-content', $starter_content );
}
endif; // fpsychology_setup
add_action( 'after_setup_theme', 'fpsychology_setup' );

/**
 * the main function to load scripts in the fPsychology theme
 * if you add a new load of script, style, etc. you can use that function
 * instead of adding a new wp_enqueue_scripts action for it.
 */
function fpsychology_load_scripts() {

	// load main stylesheet.
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array( ) );
	wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/css/animate.css', array( ) );
	wp_enqueue_style( 'fpsychology-style', get_stylesheet_uri(), array( ) );
	
	wp_enqueue_style( 'fpsychology-fonts', fpsychology_fonts_url(), array(), null );
	
	// Load thread comments reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
	
	// Load Utilities JS Script
	wp_enqueue_script( 'viewportchecker', get_template_directory_uri() . '/js/viewportchecker.js',
			array( 'jquery' ) );
			
	wp_enqueue_script( 'fpsychology-js', get_template_directory_uri() . '/js/utilities.js',
		array( 'jquery', 'viewportchecker' ) );
		
	$data = array(
		'loading_effect' => ( get_theme_mod('fpsychology_animations_display', 1) == 1 ),
	);
	wp_localize_script('fpsychology-js', 'fpsychology_options', $data);

	wp_enqueue_script( 'mobile.customized', get_template_directory_uri() . '/js/jquery.mobile.customized.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery.easing.1.3', get_template_directory_uri() . '/js/jquery.easing.1.3.js', array( 'jquery' ) );
	wp_enqueue_script( 'camera', get_template_directory_uri() . '/js/camera.min.js', array( 'jquery' ) );
}

add_action( 'wp_enqueue_scripts', 'fpsychology_load_scripts' );

/**
 *	Load google font url used in the fPsychology theme
 */
function fpsychology_fonts_url() {

    $fonts_url = '';
 
    /* Translators: If there are characters in your language that are not
    * supported by PT Sans, translate this to 'off'. Do not translate
    * into your own language.
    */
    $opensansfont = _x( 'on', 'Open Sans font: on or off', 'fpsychology' );

    if ( 'off' !== $opensansfont ) {
        $font_families = array();
 
        $font_families[] = 'Open Sans';
 
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),
            'subset' => urlencode( 'latin,cyrillic-ext,cyrillic,latin-ext' ),
        );
 
        $fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
    }
 
    return $fonts_url;
}

/**
 * Display html code of all social sites
 */
function fpsychology_display_social_sites() {

	echo '<ul class="header-social-widget">';

	$socialURL = get_theme_mod('fpsychology_social_facebook');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Facebook', 'fpsychology') . '" class="facebook16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_twitter');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Twitter', 'fpsychology') . '" class="twitter16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_linkedin');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on LinkeIn', 'fpsychology') . '" class="linkedin16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_instagram');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Instagram', 'fpsychology') . '" class="instagram16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_rss');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow our RSS Feeds', 'fpsychology') . '" class="rss16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_tumblr');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Tumblr', 'fpsychology') . '" class="tumblr16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_youtube');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Youtube', 'fpsychology') . '" class="youtube16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_pinterest');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Pinterest', 'fpsychology') . '" class="pinterest16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_vk');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on VK', 'fpsychology') . '" class="vk16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_flickr');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Flickr', 'fpsychology') . '" class="flickr16"></a></li>';
	}

	$socialURL = get_theme_mod('fpsychology_social_vine');
	if ( !empty($socialURL) ) {

		echo '<li><a href="' . esc_url( $socialURL ) . '" title="' . __('Follow us on Vine', 'fpsychology') . '" class="vine16"></a></li>';
	}

	echo '</ul>';
}

/**
 *	Used to load the content for posts and pages.
 */
function fpsychology_the_content() {

	// Display Thumbnails if thumbnail is set for the post
	if ( has_post_thumbnail() ) {
?>

		<a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
								
<?php
	}
	the_content( __( 'Read More', 'fpsychology') );
}

/**
 * Display website's logo image
 */
function fpsychology_show_website_logo_image_and_title() {

	if ( has_custom_logo() ) {

        the_custom_logo();
    }

    $header_text_color = get_header_textcolor();

    if ( 'blank' !== $header_text_color ) {
    
        echo '<div id="site-identity">';
        echo '<a href="' . esc_url( home_url('/') ) . '" title="' . esc_attr( get_bloginfo('name') ) . '">';
        echo '<h1 class="entry-title">' . esc_html( get_bloginfo('name') ) . '</h1>';
        echo '</a>';
        echo '<strong>' . esc_html( get_bloginfo('description') ) . '</strong>';
        echo '</div>';
    }
}

/**
 *	Displays the copyright text.
 */
function fpsychology_show_copyright_text() {

	$footerText = get_theme_mod('fpsychology_footer_copyright', null);

	if ( !empty( $footerText ) ) {

		echo esc_html( $footerText ) . ' | ';		
	}
}

/**
 *	widgets-init action handler. Used to register widgets and register widget areas
 */
function fpsychology_widgets_init() {
	
	// Register Sidebar Widget.
	register_sidebar( array (
						'name'	 		 =>	 __( 'Sidebar Widget Area', 'fpsychology'),
						'id'		 	 =>	 'sidebar-widget-area',
						'description'	 =>  __( 'The sidebar widget area', 'fpsychology'),
						'before_widget'	 =>  '',
						'after_widget'	 =>  '',
						'before_title'	 =>  '<div class="sidebar-before-title"></div><h3 class="sidebar-title">',
						'after_title'	 =>  '</h3><div class="sidebar-after-title"></div>',
					) );
					
	/**
	 * Add Homepage Columns Widget areas
	 */
	register_sidebar( array (
							'name'			 =>  __( 'Homepage Column #1', 'fpsychology' ),
							'id' 			 =>  'homepage-column-1-widget-area',
							'description'	 =>  __( 'The Homepage Column #1 widget area', 'fpsychology' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="sidebar-title">',
							'after_title'	 =>  '</h2><div class="sidebar-after-title"></div>',
						) );
						
	register_sidebar( array (
							'name'			 =>  __( 'Homepage Column #2', 'fpsychology' ),
							'id' 			 =>  'homepage-column-2-widget-area',
							'description'	 =>  __( 'The Homepage Column #2 widget area', 'fpsychology' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="sidebar-title">',
							'after_title'	 =>  '</h2><div class="sidebar-after-title"></div>',
						) );

	// Register Footer Column #1
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #1', 'fpsychology' ),
							'id' 			 =>  'footer-column-1-widget-area',
							'description'	 =>  __( 'The Footer Column #1 widget area', 'fpsychology' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #2
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #2', 'fpsychology' ),
							'id' 			 =>  'footer-column-2-widget-area',
							'description'	 =>  __( 'The Footer Column #2 widget area', 'fpsychology' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
	
	// Register Footer Column #3
	register_sidebar( array (
							'name'			 =>  __( 'Footer Column #3', 'fpsychology' ),
							'id' 			 =>  'footer-column-3-widget-area',
							'description'	 =>  __( 'The Footer Column #3 widget area', 'fpsychology' ),
							'before_widget'  =>  '',
							'after_widget'	 =>  '',
							'before_title'	 =>  '<h2 class="footer-title">',
							'after_title'	 =>  '</h2><div class="footer-after-title"></div>',
						) );
}

add_action( 'widgets_init', 'fpsychology_widgets_init' );

/**
 * Displays the slider
 */
function fpsychology_display_slider() { ?>

	<div class="camera_wrap camera_emboss" id="camera_wrap">
		<?php
			// display slides
			for ( $i = 1; $i <= 3; ++$i ) {

					$defaultSlideImage = get_template_directory_uri().'/images/slider/' . $i .'.jpg';

					$slideContent = get_theme_mod( 'fpsychology_slide'.$i.'_content' );
					$slideImage = get_theme_mod( 'fpsychology_slide'.$i.'_image', $defaultSlideImage );
				?>
					<div data-thumb="<?php echo esc_attr( $slideImage ); ?>" data-src="<?php echo esc_attr( $slideImage ); ?>">
						<?php if ($slideContent) : ?>
								<div class="camera_caption fadeIn">
									<?php echo $slideContent; ?>
								</div>
						<?php endif; ?>
					</div>
<?php		} ?>
	</div><!-- #camera_wrap -->
<?php 
}

/**
 *	Displays the single content.
 */
function fpsychology_the_content_single() {

	// Display Thumbnails if thumbnail is set for the post
	if ( has_post_thumbnail() ) {

		the_post_thumbnail();
	}
	the_content( __( 'Read More...', 'fpsychology') );
}

if ( ! function_exists( 'fpsychology_sanitize_checkbox' ) ) :
	/**
	 * Sanitization callback for 'checkbox' type controls. This callback sanitizes `$checked`
	 * as a boolean value, either TRUE or FALSE.
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function fpsychology_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	}
endif; // fpsychology_sanitize_checkbox

if ( ! function_exists( 'fpsychology_sanitize_html' ) ) :

	function fpsychology_sanitize_html( $html ) {
		return wp_filter_post_kses( $html );
	}

endif; // fpsychology_sanitize_html

if ( ! function_exists( 'fpsychology_sanitize_url' ) ) :

	function fpsychology_sanitize_url( $url ) {
		return esc_url_raw( $url );
	}

endif; // fpsychology_sanitize_url

/**
 * Register theme settings in the customizer
 */
function fpsychology_customize_register( $wp_customize ) {

    /**
	 * Add Social Sites Section
	 */
	$wp_customize->add_section(
		'fpsychology_social_section',
		array(
			'title'       => __( 'Social Sites', 'fpsychology' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add facebook url
	$wp_customize->add_setting(
		'fpsychology_social_facebook',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_facebook',
        array(
            'label'          => __( 'Facebook Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_facebook',
            'type'           => 'text',
            )
        )
	);

	// Add twitter url
	$wp_customize->add_setting(
		'fpsychology_social_twitter',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_twitter',
        array(
            'label'          => __( 'Twitter Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_twitter',
            'type'           => 'text',
            )
        )
	);

	// Add LinkedIn url
	$wp_customize->add_setting(
		'fpsychology_social_linkedin',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_linkedin',
        array(
            'label'          => __( 'LinkedIn Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_linkedin',
            'type'           => 'text',
            )
        )
	);

	// Add Instagram url
	$wp_customize->add_setting(
		'fpsychology_social_instagram',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_instagram',
        array(
            'label'          => __( 'instagram Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_instagram',
            'type'           => 'text',
            )
        )
	);

	// Add RSS Feeds url
	$wp_customize->add_setting(
		'fpsychology_social_rss',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_rss',
        array(
            'label'          => __( 'RSS Feeds URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_rss',
            'type'           => 'text',
            )
        )
	);

	// Add Tumblr url
	$wp_customize->add_setting(
		'fpsychology_social_tumblr',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_tumblr',
        array(
            'label'          => __( 'Tumblr Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_tumblr',
            'type'           => 'text',
            )
        )
	);

	// Add YouTube channel url
	$wp_customize->add_setting(
		'fpsychology_social_youtube',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_youtube',
        array(
            'label'          => __( 'YouTube channel URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_youtube',
            'type'           => 'text',
            )
        )
	);

	// Add Pinterest page url
	$wp_customize->add_setting(
		'fpsychology_social_pinterest',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_pinterest',
        array(
            'label'          => __( 'Pinterest Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_pinterest',
            'type'           => 'text',
            )
        )
	);

	// Add VK page url
	$wp_customize->add_setting(
		'fpsychology_social_vk',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_vk',
        array(
            'label'          => __( 'VK Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_vk',
            'type'           => 'text',
            )
        )
	);

	// Add Flickr page url
	$wp_customize->add_setting(
		'fpsychology_social_flickr',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_flickr',
        array(
            'label'          => __( 'Flickr Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_flickr',
            'type'           => 'text',
            )
        )
	);

	// Add Vine page url
	$wp_customize->add_setting(
		'fpsychology_social_vine',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_url',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_social_vine',
        array(
            'label'          => __( 'Vine Page URL', 'fpsychology' ),
            'section'        => 'fpsychology_social_section',
            'settings'       => 'fpsychology_social_vine',
            'type'           => 'text',
            )
        )
	);
	
	/**
	 * Add Slider Section
	 */
	$wp_customize->add_section(
		'fpsychology_slider_section',
		array(
			'title'       => __( 'Slider', 'fpsychology' ),
			'capability'  => 'edit_theme_options',
		)
	);

	// Add display slider option
	$wp_customize->add_setting(
			'fpsychology_slider_display',
			array(
					'default'           => 0,
					'sanitize_callback' => 'fpsychology_sanitize_checkbox',
			)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_slider_display',
							array(
								'label'          => __( 'Display Slider on a Static Front Page', 'fpsychology' ),
								'section'        => 'fpsychology_slider_section',
								'settings'       => 'fpsychology_slider_display',
								'type'           => 'checkbox',
							)
						)
	);
	
	// Add slide 1 content
	$wp_customize->add_setting(
		'fpsychology_slide1_content',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_html',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_slide1_content',
        array(
            'label'          => __( 'Slide #1 Content', 'fpsychology' ),
            'section'        => 'fpsychology_slider_section',
            'settings'       => 'fpsychology_slide1_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 1 background image
	$wp_customize->add_setting( 'fpsychology_slide1_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '1.jpg',
    		'sanitize_callback' => 'fpsychology_sanitize_url'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fpsychology_slide1_image',
			array(
				'label'   	 => __( 'Slide 1 Image', 'fpsychology' ),
				'section' 	 => 'fpsychology_slider_section',
				'settings'   => 'fpsychology_slide1_image',
			) 
		)
	);
	
	// Add slide 2 content
	$wp_customize->add_setting(
		'fpsychology_slide2_content',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_html',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_slide2_content',
        array(
            'label'          => __( 'Slide #2 Content', 'fpsychology' ),
            'section'        => 'fpsychology_slider_section',
            'settings'       => 'fpsychology_slide2_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 2 background image
	$wp_customize->add_setting( 'fpsychology_slide2_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '2.jpg',
    		'sanitize_callback' => 'fpsychology_sanitize_url'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fpsychology_slide2_image',
			array(
				'label'   	 => __( 'Slide 2 Image', 'fpsychology' ),
				'section' 	 => 'fpsychology_slider_section',
				'settings'   => 'fpsychology_slide2_image',
			) 
		)
	);
	
	// Add slide 3 content
	$wp_customize->add_setting(
		'fpsychology_slide3_content',
		array(
		    'sanitize_callback' => 'fpsychology_sanitize_html',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_slide3_content',
        array(
            'label'          => __( 'Slide #3 Content', 'fpsychology' ),
            'section'        => 'fpsychology_slider_section',
            'settings'       => 'fpsychology_slide3_content',
            'type'           => 'textarea',
            )
        )
	);
	
	// Add slide 3 background image
	$wp_customize->add_setting( 'fpsychology_slide3_image',
		array(
			'default' => get_template_directory_uri().'/images/slider/' . '3.jpg',
    		'sanitize_callback' => 'fpsychology_sanitize_url'
		)
	);

    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fpsychology_slide3_image',
			array(
				'label'   	 => __( 'Slide 3 Image', 'fpsychology' ),
				'section' 	 => 'fpsychology_slider_section',
				'settings'   => 'fpsychology_slide3_image',
			) 
		)
	);

	/**
	 * Add Footer Section
	 */
	$wp_customize->add_section(
		'fpsychology_footer_section',
		array(
			'title'       => __( 'Footer', 'fpsychology' ),
			'capability'  => 'edit_theme_options',
		)
	);
	
	// Add footer copyright text
	$wp_customize->add_setting(
		'fpsychology_footer_copyright',
		array(
		    'default'           => '',
		    'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'fpsychology_footer_copyright',
        array(
            'label'          => __( 'Copyright Text', 'fpsychology' ),
            'section'        => 'fpsychology_footer_section',
            'settings'       => 'fpsychology_footer_copyright',
            'type'           => 'text',
            )
        )
	);
	
	/**
	 * Add Animations Section
	 */
	$wp_customize->add_section(
		'fpsychology_animations_display',
		array(
			'title'       => __( 'Animations', 'fpsychology' ),
			'capability'  => 'edit_theme_options',
		)
	);

	// Add display Animations option
	$wp_customize->add_setting(
			'fpsychology_animations_display',
			array(
					'default'           => 1,
					'sanitize_callback' => 'fpsychology_sanitize_checkbox',
			)
	);

	$wp_customize->add_control( new WP_Customize_Control( $wp_customize,
						'fpsychology_animations_display',
							array(
								'label'          => __( 'Enable Animations', 'fpsychology' ),
								'section'        => 'fpsychology_animations_display',
								'settings'       => 'fpsychology_animations_display',
								'type'           => 'checkbox',
							)
						)
	);
}

add_action('customize_register', 'fpsychology_customize_register');

function fpsychology_header_style() {

    $header_text_color = get_header_textcolor();

    if ( ! has_header_image()
        && ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color
             || 'blank' === $header_text_color ) ) {

        return;
    }

    $headerImage = get_header_image();
?>
    <style type="text/css">
        <?php if ( has_header_image() ) : ?>

                #header-main-fixed {background-image: url("<?php echo esc_url( $headerImage ); ?>");}

        <?php endif; ?>

        <?php if ( get_theme_support( 'custom-header', 'default-text-color' ) !== $header_text_color
                    && 'blank' !== $header_text_color ) : ?>

                #header-main-fixed, #header-main-fixed h1.entry-title {color: #<?php echo sanitize_hex_color_no_hash( $header_text_color ); ?>;}

        <?php endif; ?>
    </style>
<?php
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function fpsychology_skip_link_focus_fix() {
	// The following is minified via `terser --compress --mangle -- js/skip-link-focus-fix.js`.
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'fpsychology_skip_link_focus_fix' );

?>
