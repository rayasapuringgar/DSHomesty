<?php
/**
 * Gamajorooms Registerable Interface
 *
 * @package   Gamajorooms_Registerable
 * @author    Gary Jones
 * @link      http://gamajorooms.com/registerable
 * @copyright 2013 Gary Jones
 * @license   GPL-2.0+
 * @version   1.0.0
 */

/**
 * Handle registration for something like a post type or taxonomy.
 *
 * @package Gamajorooms_Registerable
 * @author  Gary Jones
 */
interface Gamajorooms_Registerable {
	public function register();
	public function unregister();
	public function set_args( $args = null );
	public function get_args();
}
