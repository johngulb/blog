<?php

/**
 * The class handles the url replacements.
 *
 * @package    \Optml\Inc
 * @author     Optimole <friends@optimole.com>
 */
final class Optml_Url_Replacer extends Optml_App_Replacer {

	use Optml_Validator;
	use Optml_Normalizer;

	/**
	 * Cached object instance.
	 *
	 * @var Optml_Url_Replacer
	 */
	protected static $instance = null;

	/**
	 * Class instance method.
	 *
	 * @codeCoverageIgnore
	 * @static
	 * @since  1.0.0
	 * @access public
	 * @return Optml_Url_Replacer
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			add_action( 'after_setup_theme', array( self::$instance, 'init' ) );
		}

		return self::$instance;
	}

	/**
	 * The initialize method.
	 */
	public function init() {

		add_filter( 'optml_replace_image', array( $this, 'build_image_url' ), 10, 2 );

		if ( ! parent::init() ) {
			return; // @codeCoverageIgnore
		}

		Optml_Quality::$default_quality = $this->to_accepted_quality( $this->settings->get_quality() );
		Optml_Image::$watermark         = new Optml_Watermark( $this->settings->get_site_settings()['watermark'] );

		add_filter( 'optml_content_url', array( $this, 'build_image_url' ), 1, 2 );
	}

	/**
	 * Returns a signed image url authorized to be used in our CDN.
	 *
	 * @param string $url The url which should be signed.
	 * @param array  $args Dimension params; Supports `width` and `height`.
	 *
	 * @return string
	 */
	public function build_image_url(
		$url, $args = array(
			'width'  => 'auto',
			'height' => 'auto',
		)
	) {

		if ( apply_filters( 'optml_dont_replace_url', false, $url ) ) {
			return $url;
		}

		$is_slashed = strpos( $url, '\/' ) !== false;

		$url = $is_slashed ? stripslashes( $url ) : $url;

		if ( strpos( $url, Optml_Config::$service_url ) !== false ) {
			return $url;
		}
		if ( ! $this->is_valid_mimetype_from_url( $url ) ) {
			return $url;
		}
		if ( isset( $args['quality'] ) && ! empty( $args['quality'] ) ) {
			$args['quality'] = $this->to_accepted_quality( $args['quality'] );
		}

		// this will authorize the image
		if ( ! empty( $this->site_mappings ) ) {
			$url = str_replace( array_keys( $this->site_mappings ), array_values( $this->site_mappings ), $url );
		}

		$new_url = $this->strip_image_size_from_url( $url );

		if ( $new_url !== $url ) {
			list( $args['width'], $args['height'] ) = $this->parse_dimensions_from_filename( $url );
			$url = $new_url;
		}
		$args['width']  = (int) $args['width'];
		$args['height'] = (int) $args['height'];
		if ( $args['width'] > 0 && $args['height'] > 0 ) {
			list( $args['width'], $args['height'] ) = wp_constrain_dimensions( $args['width'], $args['height'], $this->max_width, $this->max_height );
		} elseif ( $args['width'] > 0 ) {
			$args['width'] = $args['width'] > $this->max_width ? $this->max_width : $args['width'];
		} elseif ( $args['height'] > 0 ) {
			$args['height'] = $args['height'] > $this->max_height ? $this->max_height : $args['height'];
		}

		$new_url = ( new Optml_Image( $url, $args ) )->get_url( $this->settings->use_lazyload() ? false : $this->is_allowed_site );

		return $is_slashed ? addcslashes( $new_url, '/' ) : $new_url;
	}

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @codeCoverageIgnore
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'optimole-wp' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @codeCoverageIgnore
	 * @access public
	 * @since  1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden.
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'optimole-wp' ), '1.0.0' );
	}
}
