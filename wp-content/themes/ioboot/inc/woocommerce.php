<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package ioBoot
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function ioboot_woocommerce_setup() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'ioboot_woocommerce_setup' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'ioboot_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function ioboot_woocommerce_wrapper_before() {
		?>
		<div id="primary" class="content-area col-lg-8">
			<main id="main" class="site-main" role="main"><article class="woo-article-fix">
			<?php
	}
}
add_action( 'woocommerce_before_main_content', 'ioboot_woocommerce_wrapper_before' );

if ( ! function_exists( 'ioboot_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function ioboot_woocommerce_wrapper_after() {
			?>
            </article></main><!-- #main -->
		</div><!-- #primary -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'ioboot_woocommerce_wrapper_after' );

/**
 * Set 3 columns
 */
function ioboot_woocommerce_loop_columns() {
    return 3;
}
add_filter( 'loop_shop_columns', 'ioboot_woocommerce_loop_columns' );

add_filter( 'woocommerce_enqueue_styles', 'ioboot_dequeue_styles' );
function ioboot_dequeue_styles( $enqueue_styles ) {
    unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
    //unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
    //unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
    return $enqueue_styles;
}

wp_enqueue_style( 'ioboot-woocommerce-style', get_template_directory_uri() . '/woocommerce/assets/css/woocommerce.css' );

/**
 * Remove the breadcrumbs
 */
add_action( 'init', 'ioboot_remove_wc_breadcrumbs' );
function ioboot_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

?>