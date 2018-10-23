<?php

namespace Kec\Smart;

use Kirki;
use function App\config;
use function App\asset_path;

class Customize {
	use Singleton;

	protected function init() {
		add_action( 'customize_register', [ $this, 'custom_controls' ] );
		add_action( 'customize_register', [ $this, 'customize_register' ], 11 );
		add_action( 'customize_preview_init', [ $this, 'customize_preview_init' ] );
		add_action( 'customize_register', [ $this, 'remove_customize_sections' ], 11 );

		add_filter( 'kirki/dynamic_css/method', function () {
			return get_theme_mod( 'smart_customizer_styling', config( 'customize.output', 'inline' ) );
		} );

		add_filter( 'kirki_config', function ( $config ) {
			return wp_parse_args( [
				'disable_loader' => true,
			], $config );
		} );

		Kirki::add_config( config( 'customize.instance' ), config( 'customize.options' ) );

		Customize\Settings\General::get_instance();
		Customize\Settings\Footer::get_instance();
	}

	/**
	 * Adds custom controls
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Customize_Manager $wp_customize WordPress Customizer manager.
	 */
	public function custom_controls( $wp_customize ) {
		$wp_customize->register_control_type( 'Kec\\Smart\\Customize\\Control\\Heading' );

		// Register our custom control with Kirki
		add_filter( 'kirki/control_types', function ( $controls ) {
			$controls['heading'] = 'Kec\\Smart\\Customize\\Control\\Heading';

			return $controls;
		} );
	}

	/**
	 * Core modules
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Customize_Manager $wp_customize WordPress Customizer manager.
	 */
	public static function customize_register( $wp_customize ) {
		// Tweak default controls
		$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

		$wp_customize->selective_refresh->add_partial( 'blogname', [
			'selector'        => '.brand',
			'render_callback' => function () {
				bloginfo( 'name' );
			},
		] );
	}

	/**
	 * Remove customizer unnecessary sections
	 *
	 * @since 1.0.0
	 *
	 * @param \WP_Customize_Manager $wp_customize WordPress Customizer manager.
	 */
	public static function remove_customize_sections( $wp_customize ) {

		// Remove core sections
		$wp_customize->remove_section( 'colors' );
		$wp_customize->remove_section( 'themes' );
		$wp_customize->remove_section( 'background_image' );

		// Remove core controls
		$wp_customize->remove_control( 'header_textcolor' );
		$wp_customize->remove_control( 'background_color' );
		$wp_customize->remove_control( 'background_image' );
		$wp_customize->remove_control( 'display_header_text' );

		// Remove default settings
		$wp_customize->remove_setting( 'background_color' );
		$wp_customize->remove_setting( 'background_image' );
	}

	/**
	 * Loads js file for customizer preview
	 *
	 * @since 1.0.0
	 */
	public function customize_preview_init() {
		wp_enqueue_style( 'smart/customizer.css', asset_path( 'styles/customizer.css' ), [], null, 'all' );
		wp_enqueue_script( 'smart/customizer.js', asset_path( 'scripts/customizer.js' ), [ 'customize-preview' ], null, true );
	}
}
