<?php

/**
 * Arconix FAQ Plugin
 *
 * This is the base class which sets the version, loads dependencies and gets the plugin running
 *
 * @since   1.7.0
 */
final class Improved_FAQ_Plugin {

	/**
	 * Plugin version.
	 *
	 * @since   1.7.0
	 * @var     string	$version        Plugin version
	 */
	const version = '1.7.0';

	/**
	 * Post Type Settings
	 *
	 * @since   1.7.0
	 * @var     array   $settings       Post Type default settings
	 */
	protected $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.7.0
	 */
	public function __construct() {
		$this->settings = $this->get_settings();
	}

	/**
	 * Load the plugin instructions
	 *
	 * @since   1.7.0
	 */
	public function init() {
		$this->register_post_type();
		$this->register_taxonomy();
		$this->load_public();

		if ( is_admin() ) {
			$this->load_admin();
			$this->load_metaboxes();
		}
	}

	/**
	 * Set up our Custom Post Type
	 *
	 * @since   1.7.0
	 */
	private function register_post_type() {
		$settings = $this->settings;

		$names = array(
			'post_type_name' => 'faq',
			'singular'       => 'FAQ',
			'plural'         => 'FAQs',
		);

		$pt = new Arconix_CPT_Register( 'improved-faq' );
		$pt->add( $names, $settings['post_type']['args'] );
	}

	/**
	 * Register the Post Type Taxonomy
	 *
	 * @since   1.7.0
	 */
	private function register_taxonomy() {
		$settings = $this->settings;

		$tax = new Arconix_Taxonomy_Register( 'improved-faq' );
		$tax->add( 'group', 'faq', $settings['taxonomy']['args'] );
	}

	/**
	 * Load the Public-facing components of the plugin
	 *
	 * @since   1.7.0
	 */
	private function load_public() {
		$p = new Improved_FAQ_Public();

		$p->init();
	}

	/**
	 * Loads the admin functionality
	 *
	 * @since   1.7.0
	 */
	private function load_admin() {
		new Improved_FAQ_Admin();
	}

	/**
	 * Set up the Post Type Metabox
	 *
	 * @since   1.7.0
	 */
	private function load_metaboxes() {
		$m = new Improved_FAQ_Metaboxes();

		$m->init();
	}

	/**
	 * Get the default Post Type and Taxonomy registration settings
	 *
	 * Settings are stored in a filterable array for customization purposes
	 *
	 * @since   1.7.0
	 * @return  array           Default registration settings
	 */
	public function get_settings() {
		$settings = array(
			'post_type' => array(
				'args' => array(
					'public'            => true,
					'menu_position'     => 20,
					'menu_icon'         => 'dashicons-editor-help',
					'has_archive'       => false,
					'supports'          => array( 'title', 'editor', 'revisions', 'page-attributes' ),
					'rewrite'           => array( 'with_front' => false ),
				),
			),
			'taxonomy'  => array(
				'args' => array(
					'hierarchical'              => false,
					'show_ui'                   => true,
					'query_var'                 => true,
					'rewrite'                   => array( 'with_front' => false ),
				),
			),
		);

		return apply_filters( 'arconix_faq_defaults', $settings );
	}
}
