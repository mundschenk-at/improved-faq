<?php
/**
 *  This file is part of Improved FAQ for WordPress.
 *
 *  Copyright 2018 Peter Putzer.
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; either version 2
 *  of the License, or (at your option) any later version.
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
 *  ***
 *
 *  @package mundschenk-at/improved-faq
 *  @license http://www.gnu.org/licenses/gpl-2.0.html
 *
 *  @wordpress-plugin
 *  Plugin Name: Improved FAQ
 *  Plugin URI: https://code.mundschenk.at/improved-faq/
 *  Description: Improved FAQ provides an easy way to add FAQ items to your website.
 *  Author: Peter Putzer
 *  Author URI: https://code.mundschenk.at
 *  Version: 0.0.1
 *  License: GNU General Public License v2 or later
 *  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *  Text Domain: arconix-faq
 *  Domain Path: /translations
 *
 *  ***
 *
 *  Based on Arconix FAQ by John Gardner.
 */

/**
 * Load requirements class in a PHP 5.2 compatible manner.
 */
require_once dirname( __FILE__ ) . '/vendor/mundschenk-at/check-wp-requirements/src/class-mundschenk-wp-requirements.php';

/**
 * Load the plugin after checking for the necessary PHP version.
 *
 * It's necessary to do this here because main class relies on namespaces.
 */
function mundschenk_run_improved_faq() {

	$requirements = new Mundschenk_WP_Requirements( 'Improved FAQ', __FILE__, 'improved-faq', array(
		'php'       => '5.6.0',
		'multibyte' => false,
		'utf-8'     => false,
	) );

	if ( $requirements->check() ) {
		// Autoload the rest of our classes.
		require_once __DIR__ . '/vendor/autoload.php';

		// Create the plugin.
		$plugin = new Improved_FAQ_Plugin();

		// Start the plugin for real.
		$plugin->init();
	}
}
mundschenk_run_improved_faq();
