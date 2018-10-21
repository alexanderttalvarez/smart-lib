<?php

namespace Kec\Smart\Customize\Settings;

use Kirki;
use Kec\Smart\Library;
use Kec\Smart\Singleton;

use function Theme\config;

class Footer {
	use Singleton;

	protected function init() {
		$config_id = config( 'customize.instance' );

		$panel_id = 'smart_footer_panel';
		Kirki::add_panel( $panel_id, [
			'priority'    => 210,
			'title'       => esc_attr_x( 'Footer Options', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Smart framework footer settings.', 'customizer', 'smart' ),
		] );

		$section_id = 'smart_footer_widgets_section';
		Kirki::add_section( $section_id, [
			'title'    => esc_attr_x( 'Footer Widgets', 'customizer', 'smart' ),
			'panel'    => $panel_id,
			'priority' => 10,
		] );

		/** Enable Footer Widgets */
		Kirki::add_field( $config_id, [
			'type'     => 'switch',
			'settings' => 'smart_footer_widgets',
			'label'    => esc_attr_x( 'Enable Footer Widgets', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => '1',
			'priority' => 10,
			'choices'  => [
				'on'  => esc_attr_x( 'Enable', 'customizer', 'smart' ),
				'off' => esc_attr_x( 'Disable', 'customizer', 'smart' ),
			],
		] );

		/** Footer Widgets Visibility */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_footer_widgets_visibility',
			'label'           => _x( 'Visibility', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 'initial',
			'choices'         => [
				'all-devices'        => esc_attr_x( 'Show On All Devices', 'customizer', 'smart' ),
				'hide-tablet'        => esc_attr_x( 'Hide On Tablet', 'customizer', 'smart' ),
				'hide-mobile'        => esc_attr_x( 'Hide On Mobile', 'customizer', 'smart' ),
				'hide-tablet-mobile' => esc_attr_x( 'Hide On Tablet & Mobile', 'customizer', 'smart' ),
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Fixed Footer */
		Kirki::add_field( $config_id, [
			'type'            => 'switch',
			'settings'        => 'smart_fixed_footer',
			'label'           => esc_attr_x( 'Fixed Footer', 'customizer', 'smart' ),
			'description'     => esc_attr_x( 'This option add a height to your content to keep the footer at page bottom.', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => '1',
			'priority'        => 10,
			'choices'         => [
				'on'  => esc_attr_x( 'Enable', 'customizer', 'smart' ),
				'off' => esc_attr_x( 'Disable', 'customizer', 'smart' ),
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Template */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_footer_widgets_template',
			'label'           => esc_attr_x( 'Select Template', 'customizer', 'smart' ),
			'description'     => esc_attr_x( 'Choose a template created in Theme Panel > My Library.', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => '0',
			'priority'        => 10,
			'multiple'        => 1,
			'choices'         => Library::options(),
			'active_callback' => [
				$this->has_footer_widgets(),
				$this->hasnt_footer_template(),
			],
		] );

		/** Footer Widgets Columns: Desktop */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_footer_widgets_columns',
			'label'           => esc_attr_x( 'Columns (Desktop)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 4,
			'choices'         => [
				'min'  => '1',
				'max'  => '4',
				'step' => '1',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Footer Widgets Columns: Tablet */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_footer_widgets_tablet_columns',
			'label'           => esc_attr_x( 'Columns (Tablet)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 2,
			'choices'         => [
				'min'  => '1',
				'max'  => '4',
				'step' => '1',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Footer Widgets Columns: Mobile */
		Kirki::add_field( $config_id, [
			'type'            => 'slider',
			'settings'        => 'smart_footer_widgets_mobile_columns',
			'label'           => esc_attr_x( 'Columns (Mobile)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => 1,
			'choices'         => [
				'min'  => '1',
				'max'  => '4',
				'step' => '1',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'            => 'heading',
			'settings'        => 'heading_footer_widgets_container',
			'label'           => esc_attr_x( 'Container', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Footer Widgets Add Container */
		Kirki::add_field( $config_id, [
			'type'            => 'switch',
			'settings'        => 'smart_footer_widgets_container',
			'label'           => esc_attr_x( 'Add Container', 'customizer', 'smart' ),
			'section'         => $section_id,
			'default'         => '1',
			'priority'        => 10,
			'choices'         => [
				'on'  => esc_attr_x( 'Enable', 'customizer', 'smart' ),
				'off' => esc_attr_x( 'Disable', 'customizer', 'smart' ),
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Footer Widgets Padding */
		Kirki::add_field( $config_id, [
			'type'            => 'dimensions',
			'settings'        => 'smart_footer_widgets_padding',
			'label'           => esc_attr_x( 'Padding (px)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => [
				'desktop-top'    => '30px',
				'desktop-bottom' => '30px',
				'tablet-top'     => '',
				'tablet-bottom'  => '',
				'mobile-top'     => '',
				'mobile-bottom'  => '',
			],
			'choices'         => [
				'labels' => [
					'desktop-top'    => esc_attr_x( 'Top (Desktop)', 'customizer', 'smart' ),
					'desktop-bottom' => esc_attr_x( 'Bottom (Desktop)', 'customizer', 'smart' ),
					'tablet-top'     => esc_attr_x( 'Top (Tablet)', 'customizer', 'smart' ),
					'tablet-bottom'  => esc_attr_x( 'Bottom (Tablet)', 'customizer', 'smart' ),
					'mobile-top'     => esc_attr_x( 'Top (Mobile)', 'customizer', 'smart' ),
					'mobile-bottom'  => esc_attr_x( 'Bottom (Mobile)', 'customizer', 'smart' ),
				],
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
			'output'          => [
				[
					'choice'      => 'desktop-top',
					'element'     => '#footer-widgets',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'desktop-bottom',
					'element'     => '#footer-widgets',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'tablet-top',
					'element'     => '#footer-widgets',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'tablet-bottom',
					'element'     => '#footer-widgets',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 768px)',
				],
				[
					'choice'      => 'mobile-top',
					'element'     => '#footer-widgets',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'mobile-bottom',
					'element'     => '#footer-widgets',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 480px)',
				],
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'            => 'heading',
			'settings'        => 'heading_footer_widgets_colors',
			'label'           => esc_attr_x( 'Colors', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'active_callback' => [
				$this->has_footer_widgets(),
			],
		] );

		/** Footer Widgets Background Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_widgets_background',
			'label'           => esc_attr_x( 'Background Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.background' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
			'output'          => [
				[
					'element'  => '#footer-widgets',
					'property' => 'background-color',
				],
			],
		] );

		/** Footer Widgets Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_widgets_color',
			'label'           => esc_attr_x( 'Text Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.text' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
			'output'          => [
				[
					'element'  => [
						'#footer-widgets',
						'#footer-widgets p',
						'#footer-widgets li a:before',

					],
					'property' => 'color',
				],
			],
		] );

		/** Footer Widgets Borders Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_widgets_borders',
			'label'           => esc_attr_x( 'Borders Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.border' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
			'output'          => [
				[
					'element'  => '#footer-widgets li',
					'property' => 'border-color',
				],
			],
		] );

		/** Footer Widgets Links Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_widgets_link_color',
			'label'           => esc_attr_x( 'Links Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.links.default' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
			'output'          => [
				[
					'element'  => [
						'#footer-widgets .footer-box a',
						'#footer-widgets a',

					],
					'property' => 'color',
				],
			],
		] );

		/** Footer Widgets Links Hover Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_widgets_link_color_hover',
			'label'           => esc_attr_x( 'Links Color: Hover', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.links.hover' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_widgets(),
			],
			'output'          => [
				[
					'element'  => [
						'#footer-widgets .footer-box a:hover',
						'#footer-widgets a:hover',
					],
					'property' => 'color',
				],
			],
		] );

		$section_id = 'smart_footer_bottom_section';
		Kirki::add_section( $section_id, [
			'title'    => esc_attr_x( 'Footer Bottom', 'customizer', 'smart' ),
			'panel'    => $panel_id,
			'priority' => 10,
		] );

		/** Enable Footer Bottom */
		Kirki::add_field( $config_id, [
			'type'     => 'switch',
			'settings' => 'smart_footer_bottom',
			'label'    => esc_attr_x( 'Enable Footer Bottom', 'customizer', 'smart' ),
			'section'  => $section_id,
			'default'  => '1',
			'priority' => 10,
			'choices'  => [
				'on'  => esc_attr_x( 'Enable', 'customizer', 'smart' ),
				'off' => esc_attr_x( 'Disable', 'customizer', 'smart' ),
			],
		] );

		/** Footer Bottom Visibility */
		Kirki::add_field( $config_id, [
			'type'            => 'select',
			'settings'        => 'smart_footer_bottom_visibility',
			'label'           => _x( 'Visibility', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => 'initial',
			'choices'         => [
				'all-devices'        => esc_attr_x( 'Show On All Devices', 'customizer', 'smart' ),
				'hide-tablet'        => esc_attr_x( 'Hide On Tablet', 'customizer', 'smart' ),
				'hide-mobile'        => esc_attr_x( 'Hide On Mobile', 'customizer', 'smart' ),
				'hide-tablet-mobile' => esc_attr_x( 'Hide On Tablet & Mobile', 'customizer', 'smart' ),
			],
			'active_callback' => [
				$this->has_footer_bottom(),
			],
		] );

		/** Footer Bottom Copyright */
		Kirki::add_field( $config_id, [
			'type'        => 'textarea',
			'settings'    => 'smart_footer_copyright_text',
			'label'       => esc_attr_x( 'Copyright', 'customizer', 'smart' ),
			'description' => esc_attr_x( 'Shortcodes allowed.', 'customizer', 'smart' ),
			'section'     => $section_id,
			'default'     => esc_attr_x( 'Copyright [smart_date] - Smart Theme by KEC', 'template', 'smart' ),
			'priority'    => 10,
			'active_callback' => [
				$this->has_footer_bottom(),
			],
		] );

		/** Footer Bottom Padding */
		Kirki::add_field( $config_id, [
			'type'            => 'dimensions',
			'settings'        => 'smart_footer_bottom_padding',
			'label'           => esc_attr_x( 'Padding (px)', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => [
				'desktop-top'    => '30px',
				'desktop-bottom' => '30px',
				'tablet-top'     => '',
				'tablet-bottom'  => '',
				'mobile-top'     => '',
				'mobile-bottom'  => '',
			],
			'choices'         => [
				'labels' => [
					'desktop-top'    => esc_attr_x( 'Top (Desktop)', 'customizer', 'smart' ),
					'desktop-bottom' => esc_attr_x( 'Bottom (Desktop)', 'customizer', 'smart' ),
					'tablet-top'     => esc_attr_x( 'Top (Tablet)', 'customizer', 'smart' ),
					'tablet-bottom'  => esc_attr_x( 'Bottom (Tablet)', 'customizer', 'smart' ),
					'mobile-top'     => esc_attr_x( 'Top (Mobile)', 'customizer', 'smart' ),
					'mobile-bottom'  => esc_attr_x( 'Bottom (Mobile)', 'customizer', 'smart' ),
				],
			],
			'active_callback' => [
				$this->has_footer_bottom(),
			],
			'output'          => [
				[
					'choice'      => 'desktop-top',
					'element'     => '#footer-bottom',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'desktop-bottom',
					'element'     => '#footer-bottom',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'tablet-top',
					'element'     => '#footer-bottom',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'tablet-bottom',
					'element'     => '#footer-bottom',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 768px)',
				],
				[
					'choice'      => 'mobile-top',
					'element'     => '#footer-bottom',
					'property'    => 'padding-top',
					'media_query' => '@media only screen and (min-width: 960px)',
				],
				[
					'choice'      => 'mobile-bottom',
					'element'     => '#footer-bottom',
					'property'    => 'padding-bottom',
					'media_query' => '@media only screen and (min-width: 480px)',
				],
			],
		] );

		/** Heading */
		Kirki::add_field( $config_id, [
			'type'            => 'heading',
			'settings'        => 'heading_footer_bottom_colors',
			'label'           => esc_attr_x( 'Colors', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'active_callback' => [
				$this->has_footer_bottom(),
			],
		] );

		/** Footer Bottom Background Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_bottom_background',
			'label'           => esc_attr_x( 'Background Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.background' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_bottom(),
			],
			'output'          => [
				[
					'element'  => '#footer-bottom',
					'property' => 'background-color',
				],
			],
		] );

		/** Footer Bottom Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_bottom_color',
			'label'           => esc_attr_x( 'Text Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.text' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_bottom(),
			],
			'output'          => [
				[
					'element'  => [
						'#footer-bottom',
						'#footer-bottom p',
					],
					'property' => 'color',
				],
			],
		] );

		/** Footer Bottom Links Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_bottom_link_color',
			'label'           => esc_attr_x( 'Links Color', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.links.default' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_bottom(),
			],
			'output'          => [
				[
					'element'  => [
						'#footer-bottom a',
						'#footer-bottom #footer-bottom-menu a',
					],
					'property' => 'color',
				],
			],
		] );

		/** Footer Bottom Links Hover Color */
		Kirki::add_field( $config_id, [
			'type'            => 'color-palette',
			'settings'        => 'smart_footer_bottom_link_color_hover',
			'label'           => esc_attr_x( 'Links Color: Hover', 'customizer', 'smart' ),
			'section'         => $section_id,
			'priority'        => 10,
			'default'         => config( 'colors.links.hover' ),
			'choices'         => [
				'colors' => config( 'colors.palette' ),
				'style'  => 'round',
			],
			'active_callback' => [
				$this->has_footer_bottom(),
			],
			'output'          => [
				[
					'element'  => [
						'#footer-bottom a:hover',
						'#footer-bottom #footer-bottom-menu a:hover',
					],
					'property' => 'color',
				],
			],
		] );
	}

	/**
	 * @return array
	 */
	private function has_footer_widgets(): array {
		return [
			'setting'  => 'smart_footer_widgets',
			'value'    => '1',
			'operator' => '==',
		];
	}

	/**
	 * @return array
	 */
	private function has_footer_bottom(): array {
		return [
			'setting'  => 'smart_footer_bottom',
			'value'    => '1',
			'operator' => '==',
		];
	}

	/**
	 * @return array
	 */
	private function hasnt_footer_template(): array {
		return [
			'setting'  => 'smart_footer_widgets_template',
			'value'    => '0',
			'operator' => '==',
		];
	}
}
