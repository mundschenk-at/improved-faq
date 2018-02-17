<?php
/**
 *  This file is part of Improved FAQ for WordPress.
 *
 *  Copyright 2018 Peter Putzer.
 *  Copyright 2012-2016 John Gardner.
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2
 *  of the License, or ( at your option ) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 *  @package mundschenk-at/improved-faq
 *  @license http://www.gnu.org/licenses/gpl-2.0.html GPLv2 or later
 */

/**
 * Class covers the administrative side of the plugin
 *
 * @author      John Gardner
 * @link        http://arconixpc.com/plugins/arconix-faq
 * @license     GPLv2 or later
 * @since       1.4.0
 */
class Improved_FAQ_Admin extends Arconix_CPT_Admin {

	/**
	 * The url path to this plugin.
	 *
	 * @since   1.6.0
	 * @access  private
	 * @var     string      $url    The url path to this plugin
	 */
	private $url;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @since   1.4.0
	 */
	public function __construct() {
		$this->url = trailingslashit( plugin_dir_url( dirname( __FILE__ ) ) );

		parent::__construct( 'faq', 'improved-faq' );
	}

	/**
	 * Get our hooks into WordPress
	 *
	 * Overrides the parent function so we can add our class-specific hooks
	 *
	 * @since   1.2.0
	 */
	public function init() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		parent::init();
	}

	/**
	 * Includes admin scripts.
	 *
	 * To prevent the file from being loaded, add support to your theme
	 *
	 * @example add_theme_support( 'arconix-faq', 'admin-css' );
	 *
	 * @since 1.2.0
	 */
	public function admin_scripts() {
		if ( ! current_theme_supports( 'arconix-faq', 'admin-css' ) && apply_filters( 'pre_register_arconix_faq_admin_css', true ) ) {
			wp_enqueue_style( 'arconix-faq-admin', $this->url . 'css/admin.css', false, Improved_FAQ_Plugin::VERSION );
		}
	}

	/**
	 * Choose the specific columns we want to display
	 *
	 * @since   0.9
	 * @param   array $columns    Existing column array.
	 *
	 * @return  string            New array of columns
	 */
	public function columns_define( $columns ) {
		// Add Answer column.
		$columns =
			array_slice( $columns, 0, 2, true ) +
			[ 'faq_content' => __( 'Answer', 'arconix-faq' ) ] +
			array_slice( $columns, 2, null, true );

		// Add Shortcode column.
		$columns =
			array_slice( $columns, 0, 3, true ) +
			[ 'faq_shortcode' => __( 'Shortcode', 'arconix-faq' ) ] +
			array_slice( $columns, 3, null, true );

		return apply_filters( 'arconix_faq_admin_column_define', $columns );
	}

	/**
	 * Filter the data that shows up in the columns we defined above
	 *
	 * @since   0.9
	 * @global  stdObj  $post       WP Post Object
	 *
	 * @param   array $column     Column to populate value.
	 */
	public function column_value( $column ) {
		global $post;

		switch ( $column ) {
			case 'faq_content':
				the_excerpt();
				break;
			case 'faq_groups':
				echo get_the_term_list( $post->ID, 'group', '', ', ', '' );
				break;
			case 'faq_shortcode':
				printf( '[faq p=%d]', get_the_ID() );
				break;
			default:
				break;
		}
	}
}
