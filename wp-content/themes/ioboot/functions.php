<?php
/**
 * ioBoot functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ioBoot
 */

if ( ! function_exists( 'ioboot_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ioboot_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ioBoot, use a find and replace
		 * to change 'ioboot' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ioboot', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'ioboot' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ioboot_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'ioboot_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ioboot_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'ioboot_content_width', 640 );
}
add_action( 'after_setup_theme', 'ioboot_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ioboot_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ioboot' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ioboot' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'ioboot_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ioboot_scripts() {
	wp_enqueue_style( 'ioboot-bootstrap', get_template_directory_uri() . '/css/bootstrap.css' );
    wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'ioboot-style', get_stylesheet_uri() );

	wp_enqueue_script( 'ioboot-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	wp_enqueue_style( 'ioboot-font', 'https://fonts.googleapis.com/css?family=Saira+Semi+Condensed:400,700' );

    wp_enqueue_script( 'ioboot-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '6.x.x', true );
    wp_enqueue_script( 'ioboot-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery'), '1.0.0', true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ioboot_scripts' );

/**
 * ioTheme comment
 */
if ( ! function_exists( 'ioboot_comment_form' ) ) :
    function ioboot_comment_form() {
        $commenter = wp_get_current_commenter();
        $req      = get_option( 'require_name_email' );
        $html_req = ( $req ? " required='required'" : '' );
        $consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
        $fields   =  array(
            'author'  => '<p class="comment-form-author form-group col-md-4">' .
                '<input class="form-control" placeholder="' .  esc_attr__( 'Name', 'ioboot' ) . ( $req ? ' *' : '' )  . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' /></p>',
            'email'   => '<p class="comment-form-email form-group col-md-4">' .
                '<input class="form-control" placeholder="' .  esc_attr__( 'Email', 'ioboot' ) . ( $req ? ' *' : '' )  . '" id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $html_req . ' /></p>',
            'url'     => '<p class="comment-form-url form-group col-md-4"> ' .
                '<input class="form-control" placeholder="' . esc_attr__( 'Website', 'ioboot' ) . '" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" maxlength="200" /></p></div>',
            'cookies' => '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' .
                '<label for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'ioboot' ) . '</label></p>',
        );
        $fields = apply_filters( 'comment_form_default_fields', $fields );
        $comments_args = array(
            'fields'               => $fields,
            'comment_field'        => '<div class="form-row"><p class="comment-form-comment form-group col-md-12"><textarea class="form-control" placeholder="' . esc_attr__( 'Message...', 'ioboot' ) . '" id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required"></textarea></p>',
            'class_submit'         => 'submit btn btn-primary',

        );

        comment_form($comments_args);
    }
endif;

/**
 * Add Bootstrap button for nav
 */
add_filter('next_posts_link_attributes', 'ioboot_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'ioboot_posts_link_attributes');

function ioboot_posts_link_attributes() {
    return 'class="btn btn-secondary btn-sm"';
}

//Password form
function ioboot_get_the_password_form() {
    global $post;
    $label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
    $output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form form-inline" method="post">
	<p>' . __( 'This content is password protected. To view it please enter your password below:', 'ioboot' ) . '</p>
	<div class="form-group"><label for="' . $label . '">' . __( 'Password:', 'ioboot' ) . ' <input class="form-control mx-sm-3" name="post_password" id="' . $label . '" type="password" size="20" /></label> <input class="btn btn-primary" type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form', 'ioboot' ) . '" /></div></form>
	';

    return $output ;
}
add_filter( 'the_password_form', 'ioboot_get_the_password_form' );

/**
 * Registers an editor stylesheet for the theme.
 */
function ioboot_add_editor_styles() {
    add_editor_style( 'css/editor-style.css' );
    $font_url = str_replace( ',', '%2C', '//fonts.googleapis.com/css?family=Saira+Semi+Condensed:400,700' );
    add_editor_style( $font_url );
}
add_action( 'admin_init', 'ioboot_add_editor_styles' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}
