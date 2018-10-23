<?php

namespace Kec\Smart\Customize\Settings;

use Kec\Smart\Layout;
use Kirki;
use Kec\Smart\Library;
use Kec\Smart\Singleton;

use function App\config;

class General {
	use Singleton;

	protected function init() {
		$config_id = config( 'customize.instance' );

		$panel_id = 'smart_general_panel';
		Kirki::add_panel( $panel_id, [
			'priority'    => 210,
			'title'       => esc_attr_x( 'General Options', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Smart framework general settings.', 'customizer', 'smart' ),
		] );

		$section_id = 'smart_general_styling';
		Kirki::add_section( $section_id, [
			'title'    => esc_attr_x( 'General Styling', 'customizer', 'smart' ),
			'panel'    => $panel_id,
			'priority' => 10,
		] );

		/** Styling */
		Kirki::add_field( $config_id, [
			'type'        => 'radio-buttonset',
			'settings'    => 'smart_customizer_styling',
			'label'       => esc_attr_x( 'Styling Options Location', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'If you choose Custom File, a CSS file will be created in your uploads folder.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'default'     => 'inline',
			'priority'    => 10,
			'choices'     => [
				'inline' => esc_attr_x( 'WP Head', 'customizer', 'smart' ),
				'file'   => esc_attr_x( 'Custom File', 'customizer', 'smart' ),
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'     => 'heading',
			'settings' => 'heading_general_colors',
			'label'    => esc_attr_x( 'Colors', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
		] );

		/** Primary Color */
		Kirki::add_field( $config_id, [
			'type'        => 'color-palette',
			'settings'    => 'smart_primary_color',
			'label'       => esc_attr_x( 'Primary Color', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Color used for text.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'priority'    => 10,
			'default'     => config( 'colors.text' ),
			'choices'     => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'output'      => [
				[
					'element'  => self::primary_color_selectors( 'texts' ),
					'property' => 'border-color',
				],
			],
		] );

		/** Links Color */
		Kirki::add_field( $config_id, [
			'type'        => 'color-palette',
			'settings'    => 'smart_links_color',
			'label'       => esc_attr_x( 'Links Color', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Color used for links.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'priority'    => 10,
			'default'     => config( 'colors.links.default' ),
			'choices'     => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'output'      => [
				[
					'element'  => [
						'a:link',
						'a:visited',
					],
					'property' => 'color',
				],
			],
		] );

		/** Links Color: Hover */
		Kirki::add_field( $config_id, [
			'type'        => 'color-palette',
			'settings'    => 'smart_links_color_hover',
			'label'       => esc_attr_x( 'Links Color: Hover', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Color used for links when mouse is over.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'priority'    => 10,
			'default'     => config( 'colors.links.hover' ),
			'choices'     => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'output'      => [
				[
					'element'  => [
						'a:hover',
						'a:active',
					],
					'property' => 'color',
				],
			],
		] );

		/** Main Border Color */
		Kirki::add_field( $config_id, [
			'type'        => 'color-palette',
			'settings'    => 'smart_main_border_color',
			'label'       => esc_attr_x( 'Main Border Color', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Color used for borders.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'priority'    => 10,
			'default'     => config( 'colors.border' ),
			'choices'     => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'output'      => [
				[
					'element'  => self::main_border_selectors(),
					'property' => 'border-color',
				],
			],
		] );

		/** Site Background Color */
		Kirki::add_field( $config_id, [
			'type'        => 'color-palette',
			'settings'    => 'smart_background_color',
			'label'       => esc_attr_x( 'Background Color', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Color used for page background.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'priority'    => 10,
			'default'     => config( 'colors.background' ),
			'choices'     => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'output'      => [
				[
					'element'  => 'body',
					'property' => 'background-color',
				],
			],
		] );

		/** Overlay Color */
		Kirki::add_field( $config_id, [
			'type'        => 'color',
			'settings'    => 'smart_overlay_color',
			'label'       => esc_attr_x( 'Overlay Color', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Color used for page overlay.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'priority'    => 10,
			'default'     => config( 'colors.overlay' ),
			'choices'     => [
				'alpha' => true,
			],
			'output'      => [
				[
					'element'  => '#overlay',
					'property' => 'background-color',
				],
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'     => 'heading',
			'settings' => 'heading_general_site_background',
			'label'    => esc_attr_x( 'Site background', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
		] );

		/** Site Background Image */
		Kirki::add_field( $config_id, [
			'type'     => 'image',
			'settings' => 'smart_background_image',
			'label'    => esc_attr_x( 'Background Image', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
			'default'  => '',
			'output'   => [
				[
					'element'  => 'body',
					'property' => 'background-image',
				],
			],
		] );

		/** Site Background Image Position */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_background_image_position',
			'label'           => _x( 'Position', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 'initial',
			'choices'         => [
				'initial'       => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'top left'      => esc_attr_x( 'Top Left', 'customizer', 'smart' ),
				'top center'    => esc_attr_x( 'Top Center', 'customizer', 'smart' ),
				'top right'     => esc_attr_x( 'Top Right', 'customizer', 'smart' ),
				'center left'   => esc_attr_x( 'Center Left', 'customizer', 'smart' ),
				'center center' => esc_attr_x( 'Center Center', 'customizer', 'smart' ),
				'center right'  => esc_attr_x( 'Center Right', 'customizer', 'smart' ),
				'bottom left'   => esc_attr_x( 'Bottom Left', 'customizer', 'smart' ),
				'bottom center' => esc_attr_x( 'Bottom Center', 'customizer', 'smart' ),
				'bottom right'  => esc_attr_x( 'Bottom Right', 'customizer', 'smart' ),
			],
			'active_callback' => [
				$this->has_background_image(),
			],
			'output'          => [
				[
					'element'  => 'body',
					'property' => 'background-position',
				],
			],
		] );

		/** Site Background Image Attachment */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_background_image_attachment',
			'label'           => _x( 'Attachment', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 'initial',
			'choices'         => [
				'initial' => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'scroll'  => esc_attr_x( 'Scroll', 'customizer', 'smart' ),
				'fixed'   => esc_attr_x( 'Fixed', 'customizer', 'smart' ),
			],
			'active_callback' => [
				$this->has_background_image(),
			],
			'output'          => [
				[
					'element'  => 'body',
					'property' => 'background-attachment',
				],
			],
		] );

		/** Site Background Image Repeat */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_background_image_repeat',
			'label'           => _x( 'Repeat', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 'initial',
			'choices'         => [
				'initial'   => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'no-repeat' => esc_html_x( 'No-repeat', 'customizer', 'smart' ),
				'repeat'    => esc_html_x( 'Repeat', 'customizer', 'smart' ),
				'repeat-x'  => esc_html_x( 'Repeat-x', 'customizer', 'smart' ),
				'repeat-y'  => esc_html_x( 'Repeat-y', 'customizer', 'smart' ),
			],
			'active_callback' => [
				$this->has_background_image(),
			],
			'output'          => [
				[
					'element'  => 'body',
					'property' => 'background-repeat',
				],
			],
		] );

		/** Site Background Image Size */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_background_image_size',
			'label'           => _x( 'Size', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 'initial',
			'choices'         => [
				'initial' => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'auto'    => esc_attr_x( 'Auto', 'customizer', 'smart' ),
				'cover'   => esc_attr_x( 'Cover', 'customizer', 'smart' ),
				'contain' => esc_attr_x( 'Contain', 'customizer', 'smart' ),

			],
			'active_callback' => [
				$this->has_background_image(),
			],
			'output'          => [
				[
					'element'  => 'body',
					'property' => 'background-size',
				],
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'     => 'heading',
			'settings' => 'heading_general_site_layout',
			'label'    => esc_attr_x( 'Site Layout', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
		] );

		/** Main Layout Style */
		Kirki::add_field( $config_id, [
			'type'     => 'radio-buttonset',
			'settings' => 'smart_main_layout_style',
			'label'    => esc_attr_x( 'Layout Style', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 'wide',
			'priority' => 10,
			'choices'  => [
				'wide'  => esc_attr_x( 'Wide', 'customizer', 'smart' ),
				'boxed' => esc_attr_x( 'Boxed', 'customizer', 'smart' ),
			],
		] );

		/** Main Container Width */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_main_container_width',
			'label'           => esc_attr_x( 'Main Container Width (px)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 1140,
			'priority'        => 10,
			'choices'         => [
				'min'  => '0',
				'max'  => '4096',
				'step' => '1',
			],
			'active_callback' => [
				$this->has_wide_layout(),
			],
			'output'          => [
				[
					'element'  => '#content-wrap',
					'property' => 'max-width',
					'units'    => 'px',
				],
			],
		] );

		/** Boxed Width */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_boxed_width',
			'label'           => esc_attr_x( 'Boxed Width (px)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 1280,
			'priority'        => 10,
			'choices'         => [
				'min'  => '0',
				'max'  => '4000',
				'step' => '1',
			],
			'active_callback' => [
				$this->has_boxed_layout(),
			],
			'output'          => [
				[
					'element'  => '#main',
					'property' => 'max-width',
					'units'    => 'px',
				],
			],
		] );

		/** Content Width */
		Kirki::add_field( $config_id, [
			'type'     => 'slider',
			'settings' => 'smart_content_width',
			'label'    => esc_attr_x( 'Content Width (%)', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 72,
			'priority' => 10,
			'choices'  => [
				'min'  => '0',
				'max'  => '100',
				'step' => '1',
			],
			'output'   => [
				[
					'element'  => [
						'.content-area',
						'.content-left-sidebar .content-area',
					],
					'property' => 'width',
					'units'    => '%',
				],
			],
		] );

		/** Sidebar Width */
		Kirki::add_field( $config_id, [
			'type'     => 'slider',
			'settings' => 'smart_sidebar_width',
			'label'    => esc_attr_x( 'Sidebar Width (%)', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 28,
			'priority' => 10,
			'choices'  => [
				'min'  => '0',
				'max'  => '100',
				'step' => '1',
			],
			'output'   => [
				[
					'element'  => [
						'.widget-area',
						'.content-left-sidebar .widget-area',
					],
					'property' => 'width',
					'units'    => '%',
				],
			],
		] );

		$section_id = 'smart_general_pages';
		Kirki::add_section( $section_id, [
			'title'    => esc_attr_x( 'Pages', 'customizer', 'smart' ),
			'panel'    => $panel_id,
			'priority' => 10,
		] );

		/** Page Layout */
		Kirki::add_field( $config_id, [
			'type'     => 'radio-image',
			'settings' => 'smart_single_page_layout',
			'label'    => esc_html_x( 'Default Layout', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 'right-sidebar',
			'priority' => 10,
			'choices'  => $this->layout_options(),
		] );

		/** Both Sidebars Style */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_single_page_both_sidebars_style',
			'label'           => esc_html_x( 'Both Sidebars: Style', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 'scs-style',
			'priority'        => 10,
			'multiple'        => 1,
			'active_callback' => [
				$this->has_both_sidebars_layout(),
			],
			'choices'         => [
				'ssc-style' => esc_html_x( 'Sidebar / Sidebar / Content', 'customizer', 'smart' ),
				'scs-style' => esc_html_x( 'Sidebar / Content / Sidebar', 'customizer', 'smart' ),
				'css-style' => esc_html_x( 'Content / Sidebar / Sidebar', 'customizer', 'smart' ),
			],
		] );

		/** Both Sidebars Content Width */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_single_page_both_sidebars_content_width',
			'label'           => esc_attr_x( 'Content Width (%)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 60,
			'priority'        => 10,
			'active_callback' => [
				$this->has_both_sidebars_layout(),
			],
			'choices'         => [
				'min'  => '0',
				'max'  => '100',
				'step' => '1',
			],
			'output'          => [
				[
					'element'     => 'body.page.content-both-sidebars .content-area',
					'media_query' => '@media only screen and (min-width: 960px)',
					'property'    => 'width',
					'units'       => '%',
				],
				[
					'element'       => [
						'body.page.content-both-sidebars.scs-style .widget-area.sidebar-secondary',
						'body.page.content-both-sidebars.ssc-style .widget-area',
					],
					'media_query'   => '@media only screen and (min-width: 960px)',
					'property'      => 'left',
					'value_pattern' => '-$%',
				],
			],
		] );

		/** Both Sidebars Sidebar Width */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_single_page_both_sidebars_sidebars_width',
			'label'           => esc_attr_x( 'Sidebar Width (%)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 20,
			'priority'        => 10,
			'active_callback' => [
				$this->has_both_sidebars_layout(),
			],
			'choices'         => [
				'min'  => '0',
				'max'  => '100',
				'step' => '1',
			],
			'output'          => [
				[
					'element'     => 'body.page.content-both-sidebars .widget-area',
					'media_query' => '@media only screen and (min-width: 960px)',
					'property'    => 'width',
					'units'       => '%',
				],
				[
					'element'     => 'body.page.content-both-sidebars.scs-style .content-area',
					'media_query' => '@media only screen and (min-width: 960px)',
					'property'    => 'left',
					'units'       => '%',
				],
				[
					'element'       => 'body.page.content-both-sidebars.ssc-style .content-area',
					'media_query'   => '@media only screen and (min-width: 960px)',
					'property'      => 'left',
					'value_pattern' => 'calc($ * 2)%',
				],
			],
		] );

		/** Content Padding */
		Kirki::add_field( $config_id, [
			'type'     => 'dimensions',
			'settings' => 'smart_page_content_padding',
			'label'    => esc_attr_x( 'Content Padding (px)', 'customizer', 'smart' ),
			'section'  => $section_id,
			'choices'  => [
				'labels' => [
					'desktop-top'    => esc_attr_x( 'Top (Desktop)', 'customizer', 'smart' ),
					'desktop-bottom' => esc_attr_x( 'Bottom (Desktop)', 'customizer', 'smart' ),
					'tablet-top'     => esc_attr_x( 'Top (Tablet)', 'customizer', 'smart' ),
					'tablet-bottom'  => esc_attr_x( 'Bottom (Tablet)', 'customizer', 'smart' ),
					'mobile-top'     => esc_attr_x( 'Top (Mobile)', 'customizer', 'smart' ),
					'mobile-bottom'  => esc_attr_x( 'Bottom (Mobile)', 'customizer', 'smart' ),
				],
			],
			'default'  => [
				'desktop-top'    => '30px',
				'desktop-bottom' => '30px',
				'tablet-top'     => '20px',
				'tablet-bottom'  => '20px',
				'mobile-top'     => '15px',
				'mobile-bottom'  => '15px',
			],
			'output'   => [
				[
					'choice'      => 'desktop-top',
					'element'     => '#main #content-wrap',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'desktop-bottom',
					'element'     => '#main #content-wrap',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'tablet-top',
					'element'     => '#main #content-wrap',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 768px)',
				],
				[
					'choice'      => 'tablet-bottom',
					'element'     => '#main #content-wrap',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 768px)',
				],
				[
					'choice'      => 'mobile-top',
					'element'     => '#main #content-wrap',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 480px)',
				],
				[
					'choice'      => 'mobile-bottom',
					'element'     => '#main #content-wrap',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 480px)',
				],
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'     => 'heading',
			'settings' => 'heading_general_page_title',
			'label'    => esc_attr_x( 'Page title', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
		] );

		/** Page Title Visibility */
		Kirki::add_field( $config_id, [
			'type'     => 'select',
			'settings' => 'smart_page_header_visibility',
			'label'    => esc_attr_x( 'Visibility', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 'all-devices',
			'priority' => 10,
			'multiple' => 1,
			'choices'  => [
				'all-devices'        => esc_attr_x( 'Show On All Devices', 'customizer', 'smart' ),
				'hide-tablet'        => esc_attr_x( 'Hide On Tablet', 'customizer', 'smart' ),
				'hide-mobile'        => esc_attr_x( 'Hide On Mobile', 'customizer', 'smart' ),
				'hide-tablet-mobile' => esc_attr_x( 'Hide On Tablet & Mobile', 'customizer', 'smart' ),
			],
		] );

		/** Page Title Heading Tag */
		Kirki::add_field( $config_id, [
			'type'     => 'select',
			'settings' => 'smart_page_header_heading_tag',
			'label'    => esc_attr_x( 'Heading Tag', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 'h1',
			'priority' => 10,
			'multiple' => 1,
			'choices'  => [
				'h1'   => esc_attr_x( 'H1', 'customizer', 'smart' ),
				'h2'   => esc_attr_x( 'H2', 'customizer', 'smart' ),
				'h3'   => esc_attr_x( 'H3', 'customizer', 'smart' ),
				'h4'   => esc_attr_x( 'H4', 'customizer', 'smart' ),
				'h5'   => esc_attr_x( 'H5', 'customizer', 'smart' ),
				'h6'   => esc_attr_x( 'H6', 'customizer', 'smart' ),
				'div'  => esc_attr_x( 'div', 'customizer', 'smart' ),
				'span' => esc_attr_x( 'span', 'customizer', 'smart' ),
				'p'    => esc_attr_x( 'p', 'customizer', 'smart' ),
			],
		] );

		/** Page Title Style */
		Kirki::add_field( $config_id, [
			'type'     => 'select',
			'settings' => 'smart_page_header_style',
			'label'    => esc_attr_x( 'Style', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => '',
			'priority' => 10,
			'multiple' => 1,
			'choices'  => [
				''                 => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'centered'         => esc_attr_x( 'Centered', 'customizer', 'smart' ),
				'centered-minimal' => esc_attr_x( 'Centered Minimal', 'customizer', 'smart' ),
				'background-image' => esc_attr_x( 'Background Image', 'customizer', 'smart' ),
				'hidden'           => esc_attr_x( 'Hidden', 'customizer', 'smart' ),
			],
		] );

		/** Page Title Background Image */
		Kirki::add_field( $config_id, [
			'type'            => 'image',
			'settings'        => 'smart_page_header_bg_image',
			'label'           => esc_attr_x( 'Image', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => '',
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
		] );

		/** Page Title Background Image Position */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_page_header_bg_image_position',
			'label'           => esc_attr_x( 'Position', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 'top center',
			'priority'        => 10,
			'multiple'        => 1,
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
			'choices'         => [
				'initial'       => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'top left'      => esc_attr_x( 'Top Left', 'customizer', 'smart' ),
				'top center'    => esc_attr_x( 'Top Center', 'customizer', 'smart' ),
				'top right'     => esc_attr_x( 'Top Right', 'customizer', 'smart' ),
				'center left'   => esc_attr_x( 'Center Left', 'customizer', 'smart' ),
				'center center' => esc_attr_x( 'Center Center', 'customizer', 'smart' ),
				'center right'  => esc_attr_x( 'Center Right', 'customizer', 'smart' ),
				'bottom left'   => esc_attr_x( 'Bottom Left', 'customizer', 'smart' ),
				'bottom center' => esc_attr_x( 'Bottom Center', 'customizer', 'smart' ),
				'bottom right'  => esc_attr_x( 'Bottom Right', 'customizer', 'smart' ),
			],
		] );

		/** Page Title Background Image Attachment */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_page_header_bg_image_attachment',
			'label'           => esc_attr_x( 'Attachment', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 'initial',
			'priority'        => 10,
			'multiple'        => 1,
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
			'choices'         => [
				'initial' => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'scroll'  => esc_attr_x( 'Scroll', 'customizer', 'smart' ),
				'fixed'   => esc_attr_x( 'Fixed', 'customizer', 'smart' ),
			],
		] );

		/** Page Title Background Image Repeat */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_page_header_bg_image_repeat',
			'label'           => esc_attr_x( 'Repeat', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 'no-repeat',
			'priority'        => 10,
			'multiple'        => 1,
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
			'choices'         => [
				'initial'   => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'no-repeat' => esc_attr_x( 'No-repeat', 'customizer', 'smart' ),
				'repeat'    => esc_attr_x( 'Repeat', 'customizer', 'smart' ),
				'repeat-x'  => esc_attr_x( 'Repeat-x', 'customizer', 'smart' ),
				'repeat-y'  => esc_attr_x( 'Repeat-y', 'customizer', 'smart' ),
			],
		] );

		/** Page Title Background Image Size */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_page_header_bg_image_size',
			'label'           => esc_attr_x( 'Size', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 'cover',
			'priority'        => 10,
			'multiple'        => 1,
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
			'choices'         => [
				'initial' => esc_attr_x( 'Default', 'customizer', 'smart' ),
				'auto'    => esc_attr_x( 'Auto', 'customizer', 'smart' ),
				'cover'   => esc_attr_x( 'Cover', 'customizer', 'smart' ),
				'contain' => esc_attr_x( 'Contain', 'customizer', 'smart' ),
			],
		] );

		/** Page Title Background Image Height */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_page_header_bg_image_height',
			'label'           => esc_attr_x( 'Height (px)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 400,
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
			'choices'         => [
				'min'  => '0',
				'max'  => '800',
				'step' => '1',
			],
		] );

		/** Page Title Background Image Overlay Opacity */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_page_header_bg_image_overlay_opacity',
			'label'           => esc_attr_x( 'Overlay Opacity', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 0.5,
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
			'choices'         => [
				'min'  => '0',
				'max'  => '1',
				'step' => '0.1',
			],
		] );

		/** Page Title Background Image Overlay Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color',
			'settings'        => 'smart_page_header_bg_image_overlay_color',
			'label'           => esc_attr_x( 'Overlay Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.overlay' ),
			'active_callback' => [
				$this->has_page_title_background_image(),
			],
		] );

		/** Page Title Padding */
		Kirki::add_field( $config_id, [
			'type'     => 'dimensions',
			'settings' => 'smart_page_header_padding',
			'label'    => esc_attr_x( 'Content Padding (px)', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
			'default'  => [
				'desktop-top'    => '34px',
				'desktop-bottom' => '34px',
				'tablet-top'     => '',
				'tablet-bottom'  => '',
				'mobile-top'     => '',
				'mobile-bottom'  => '',
			],
			'choices'  => [
				'labels' => [
					'desktop-top'    => esc_attr_x( 'Top (Desktop)', 'customizer', 'smart' ),
					'desktop-bottom' => esc_attr_x( 'Bottom (Desktop)', 'customizer', 'smart' ),
					'tablet-top'     => esc_attr_x( 'Top (Tablet)', 'customizer', 'smart' ),
					'tablet-bottom'  => esc_attr_x( 'Bottom (Tablet)', 'customizer', 'smart' ),
					'mobile-top'     => esc_attr_x( 'Top (Mobile)', 'customizer', 'smart' ),
					'mobile-bottom'  => esc_attr_x( 'Bottom (Mobile)', 'customizer', 'smart' ),
				],
			],
			'output'   => [
				[
					'choice'      => 'desktop-top',
					'element'     => '.page-header',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'desktop-bottom',
					'element'     => '.page-header',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'tablet-top',
					'element'     => '.page-header',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 768px)',
				],
				[
					'choice'      => 'tablet-bottom',
					'element'     => '.page-header',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 768px)',
				],
				[
					'choice'      => 'mobile-top',
					'element'     => '.page-header',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 480px)',
				],
				[
					'choice'      => 'mobile-bottom',
					'element'     => '.page-header',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 480px)',
				],
			],
		] );

		/** Page Title Background Color */
		Kirki::add_field( $config_id, [
			'type'     => 'color-palette',
			'settings' => 'smart_page_header_background_color',
			'label'    => esc_attr_x( 'Background Color', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
			'default'  => config( 'colors.background' ),
			'choices'  => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
		] );

		/** Page Title Color */
		Kirki::add_field( $config_id, [
			'type'     => 'color-palette',
			'settings' => 'smart_page_header_title_color',
			'label'    => esc_attr_x( 'Text Color', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
			'default'  => config( 'colors.text' ),
			'choices'  => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'output'   => [
				[
					'element'  => [
						'.page-header .page-header-title',
						'.page-header.background-image-page-header .page-header-title',
					],
					'property' => 'color',
					'suffix'   => '!important',
				],
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'     => 'heading',
			'settings' => 'heading_general_search_page',
			'label'    => esc_attr_x( 'Search Page', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
		] );

		/** Search Source */
		Kirki::add_field( $config_id, [
			'type'     => 'select',
			'settings' => 'smart_search_source',
			'label'    => esc_attr_x( 'Source', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 'any',
			'priority' => 10,
			'multiple' => 1,
			'choices'  => $this->get_post_types(),
		] );

		/** Search Page Layout */
		Kirki::add_field( $config_id, [
			'type'     => 'radio-image',
			'settings' => 'smart_search_page_layout',
			'label'    => esc_html_x( 'Layout', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 'right-sidebar',
			'priority' => 10,
			'choices'  => $this->layout_options(),
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'     => 'heading',
			'settings' => 'heading_general_error_page',
			'label'    => esc_attr_x( '404 Error Page', 'customizer', 'smart' ),
			'section'  => $section_id,
			'priority' => 10,
		] );

		/** Scroll To Top */
		Kirki::add_field( $config_id, [
			'type'        => 'radio-buttonset',
			'settings'    => 'smart_scroll_top',
			'label'       => esc_attr_x( 'Blank Page', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Enable this option to remove all the elements and have full control of the 404 error page.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'default'     => 'off',
			'priority'    => 10,
			'choices'     => [
				'on'  => esc_attr_x( 'Enabled', 'customizer', 'smart' ),
				'off' => esc_attr_x( 'Disabled', 'customizer', 'smart' ),
			],
		] );

		/** Error Page Layout */
		Kirki::add_field( $config_id, [
			'type'     => 'radio-image',
			'settings' => 'smart_error_page_layout',
			'label'    => esc_html_x( 'Layout', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => 'full-width',
			'priority' => 10,
			'choices'  => [
				'full-width'  => config( 'theme.uri' ) . '/assets/images/fw.png',
				'full-screen' => config( 'theme.uri' ) . '/assets/images/fs.png',
			],
		] );

		/** Template */
		Kirki::add_field( $config_id, [
			'type'        => 'select',
			'settings'    => 'smart_error_page_template',
			'label'       => esc_attr_x( 'Select Template', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Choose a template created in Theme Panel > My Library.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'default'     => '0',
			'priority'    => 10,
			'multiple'    => 1,
			'choices'     => Library::options(),
		] );

		add_filter( "kirki_{$config_id}_dynamic_css", function ( $styles ) {
			$styles .= self::get_instance()->page_header_overlay_css();
			$styles .= self::get_instance()->page_header_css();

			return $styles;
		} );
	}

	/**
	 * Outputs Custom CSS for the page title overlay
	 *
	 * @since 1.0.0
	 */
	public function page_header_overlay_css(): string {

		// Only needed for the background-image style
		if ( 'background-image' !== Layout::get_page_header_style() ) {
			return '';
		}

		// Global vars
		$opacity       = get_theme_mod( 'smart_page_header_bg_image_overlay_opacity', '0.5' );
		$overlay_color = get_theme_mod( 'smart_page_header_bg_image_overlay_color', config( 'colors.overlay' ) );

		$opacity       = $opacity ?: '0.5';
		$opacity       = apply_filters( 'smart/post_title_bg_overlay', $opacity );
		$overlay_color = $overlay_color ?: config( 'colors.overlay' );
		$overlay_color = apply_filters( 'smart/post_title_bg_overlay_color', $overlay_color );

		// Define css var
		$css = '';

		// Get page header overlay opacity
		if ( ! empty( $opacity ) && '0.5' !== $opacity ) {
			$css .= 'opacity:' . $opacity . ';';
		}

		// Get page header overlay color
		if ( ! empty( $overlay_color ) && config( 'colors.overlay' ) !== $overlay_color ) {
			$css .= 'background-color:' . $overlay_color . ';';
		}

		// Return CSS
		$output = '';
		if ( ! empty( $css ) ) {
			$output .= '.background-image-page-header-overlay{' . $css . '}';
		}

		// Return output css
		return $output;
	}

	/**
	 * Outputs Custom CSS for the page title
	 *
	 * @since 1.0.0
	 */
	public function page_header_css(): string {

		if ( ! Layout::has_page_header() ) {
			return '';
		}

		// Define var
		$css = '';

		// Customize background color
		$bg_color = get_theme_mod( 'smart_page_header_background_color', config( 'colors.background' ) );

		$bg_color = $bg_color ?: config( 'colors.background' );
		$bg_color = apply_filters( 'smart/page_title_background_color', $bg_color );

		if ( ! empty( $bg_color ) && config( 'colors.background' ) !== $bg_color ) {
			$css .= 'background-color: ' . $bg_color . ';';
		}

		// Background image Style
		if ( Layout::get_page_header_style() === 'background-image' ) {

			// Add background image
			$bg_img = get_theme_mod( 'smart_page_header_bg_image' );

			// Put the filter before generating the image url
			$bg_img = apply_filters( 'smart/page_header_background_image', $bg_img );

			// Generate image URL if using ID
			if ( is_numeric( $bg_img ) ) {
				$bg_img = wp_get_attachment_image_src( $bg_img, 'full' );
				$bg_img = $bg_img[0];
			}

			$bg_img = $bg_img ?: null;

			// Immage attrs
			$bg_img_position   = get_theme_mod( 'smart_page_header_bg_image_position', 'top center' );
			$bg_img_attachment = get_theme_mod( 'smart_page_header_bg_image_attachment', 'initial' );
			$bg_img_repeat     = get_theme_mod( 'smart_page_header_bg_image_repeat', 'no-repeat' );
			$bg_img_size       = get_theme_mod( 'smart_page_header_bg_image_size', 'cover' );

			$bg_img_position   = $bg_img_position ?: 'top center';
			$bg_img_position   = apply_filters( 'smart/post_title_bg_image_position', $bg_img_position );
			$bg_img_attachment = $bg_img_attachment ?: 'initial';
			$bg_img_attachment = apply_filters( 'smart/post_title_bg_image_attachment', $bg_img_attachment );
			$bg_img_repeat     = $bg_img_repeat ?: 'no-repeat';
			$bg_img_repeat     = apply_filters( 'smart/post_title_bg_image_repeat', $bg_img_repeat );
			$bg_img_size       = $bg_img_size ?: 'cover';
			$bg_img_size       = apply_filters( 'smart/post_title_bg_image_size', $bg_img_size );

			if ( $bg_img ) {

				// Add css for background image
				$css .= 'background-image: url( ' . $bg_img . ' ) !important;';

				// Background position
				if ( ! empty( $bg_img_position ) && 'top center' !== $bg_img_position && 'initial' !== $bg_img_position ) {
					$css .= 'background-position:' . $bg_img_position . ';';
				}

				// Background attachment
				if ( ! empty( $bg_img_attachment ) && 'initial' !== $bg_img_attachment ) {
					$css .= 'background-attachment:' . $bg_img_attachment . ';';
				}

				// Background repeat
				if ( ! empty( $bg_img_repeat ) && 'no-repeat' !== $bg_img_repeat && 'initial' !== $bg_img_repeat ) {
					$css .= 'background-repeat:' . $bg_img_repeat . ';';
				}

				// Background size
				if ( ! empty( $bg_img_size ) && 'cover' !== $bg_img_size && 'initial' !== $bg_img_size ) {
					$css .= 'background-size:' . $bg_img_size . ';';
				}
			}

			// Custom height
			$title_height = get_theme_mod( 'smart_page_header_bg_image_height', '400' );

			$title_height = $title_height ?: '400';
			$title_height = apply_filters( 'smart/post_title_height', $title_height );

			if ( ! empty( $title_height ) && '400' !== $title_height ) {
				$css .= 'height:' . $title_height . 'px;';
			}
		}

		// Apply all css to the page-header class
		$output = '';
		if ( ! empty( $css ) ) {
			$output = '.page-header { ' . $css . ' }';
		}

		// Return output
		return $output;
	}

	/**
	 * Get post types
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	private function get_post_types( $args = [] ): array {
		$post_type_args = [
			'show_in_nav_menus' => true,
		];

		if ( ! empty( $args['post_type'] ) ) {
			$post_type_args['name'] = $args['post_type'];
		}

		$_post_types = get_post_types( $post_type_args, 'objects' );

		$post_types        = [];
		$post_types['any'] = esc_html_x( 'All Post Types', 'customizer', 'smart' );

		foreach ( $_post_types as $post_type => $object ) {
			$post_types[ $post_type ] = $object->label;
		}

		return $post_types;
	}

	/**
	 * Returns an array with page layout options
	 *
	 * @return array
	 */
	private function layout_options(): array {
		return apply_filters( 'smart/page_layout_options', [
			'right-sidebar' => config( 'theme.uri' ) . '/assets/images/rs.png',
			'left-sidebar'  => config( 'theme.uri' ) . '/assets/images/ls.png',
			'full-width'    => config( 'theme.uri' ) . '/assets/images/fw.png',
			'full-screen'   => config( 'theme.uri' ) . '/assets/images/fs.png',
			'both-sidebars' => config( 'theme.uri' ) . '/assets/images/bs.png',
		] );
	}

	/**
	 * Both Sidebars callback
	 *
	 * @return array
	 */
	private function has_page_title_background_image(): array {
		return [
			'setting'  => 'smart_page_header_style',
			'value'    => 'background-image',
			'operator' => '==',
		];
	}

	/**
	 * Both Sidebars callback
	 *
	 * @return array
	 */
	private function has_both_sidebars_layout(): array {
		return [
			'setting'  => 'smart_single_page_layout',
			'value'    => 'both-sidebars',
			'operator' => '==',
		];
	}

	/**
	 * Wide Layout callback
	 *
	 * @return array
	 */
	private function has_wide_layout(): array {
		return [
			'setting'  => 'smart_main_layout_style',
			'value'    => 'wide',
			'operator' => '==',
		];
	}

	/**
	 * Boxed Layout callback
	 *
	 * @return array
	 */
	private function has_boxed_layout(): array {
		return [
			'setting'  => 'smart_main_layout_style',
			'value'    => 'boxed',
			'operator' => '==',
		];
	}

	/**
	 * Background image callback
	 *
	 * @return array
	 */
	private function has_background_image(): array {
		return [
			'setting'  => 'smart_background_image',
			'value'    => '',
			'operator' => '!=',
		];
	}

	/**
	 * Generates arrays of elements to target
	 *
	 * @since 1.0.0
	 *
	 * @param string $return Array key.
	 *
	 * @return array|mixed
	 */
	private static function primary_color_selectors( $return ) {

		$selectors = [
			'texts'       => apply_filters( 'smart/primary_texts', [
				'a:hover',
				'.blog-entry.post .blog-entry-header .entry-title a:hover',
				'.blog-entry.post .blog-entry-readmore a:hover',
				'.blog-entry.thumbnail-entry .blog-entry-category a',
				'ul.meta li a:hover',
				'.dropcap',
				'body #wp-calendar caption',
				'.comment-author .comment-meta .comment-reply-link',
				'#respond #cancel-comment-reply-link:hover',
				'input[type=checkbox]:checked:before',
			] ),
			'backgrounds' => apply_filters( 'ocean_primary_backgrounds', [
				'input[type="button"]',
				'input[type="reset"]',
				'input[type="submit"]',
				'button[type="submit"]',
				'.button',
				'#site-navigation-wrap .dropdown-menu > li.btn > a > span',
				'.thumbnail:hover i',
				'.post-quote-content',
				'.omw-modal .omw-close-modal',
				'body .contact-info-widget.big-icons li:hover i',
				'body div.wpforms-container-full .wpforms-form input[type=submit]',
				'body div.wpforms-container-full .wpforms-form button[type=submit]',
				'body div.wpforms-container-full .wpforms-form .wpforms-page-button',
			] ),
			'borders'     => apply_filters( 'ocean_primary_borders', [
				'.widget-title',
				'blockquote',
				'#searchform-dropdown',
				'.dropdown-menu .sub-menu',
				'.blog-entry.large-entry .blog-entry-readmore a:hover',
				'.oceanwp-newsletter-form-wrap input[type="email"]:focus',
				'.social-widget li.oceanwp-email a:hover',
				'#respond #cancel-comment-reply-link:hover',
				'body .contact-info-widget.big-icons li:hover i',
				'#footer-widgets .oceanwp-newsletter-form-wrap input[type="email"]:focus',
			] ),
		];

		// Return array
		return \in_array( $return, [ 'texts', 'backgrounds', 'borders' ] ) ? $selectors[ $return ] : [];
	}

	/**
	 * Returns array of elements and border style to apply
	 *
	 * @since 1.0.0
	 */
	private static function main_border_selectors() {

		return apply_filters( 'ocean_border_color_elements', [

			// General
			'table th',
			'table td',
			'hr',

			// Blog
			'.blog-entry.post',

			'.blog-entry.grid-entry .blog-entry-inner',

			'.blog-entry.thumbnail-entry .blog-entry-bottom',

			'.single-post .entry-title',

			'.single nav.post-navigation',
			'.single nav.post-navigation .nav-links .nav-previous',

			'#comments',
			'.comment-body',
			'#respond #cancel-comment-reply-link',

			// Widgets
			'body #wp-calendar caption',
			'body #wp-calendar th',
			'body #wp-calendar tbody',

			'body .tagcloud a',
		] );
	}
}
