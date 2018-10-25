<?php
/**
 * Acf class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Elementor\Modules\Acf\Widgets;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

class Acf extends Widget_Base {

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-acf';
    }

    /**
     * {@inheritdoc}
     */
    public function get_title() {
        return _x( 'ACF', 'elementor', 'smart' );
    }

    /**
     * {@inheritdoc}
     */
    public function get_icon() {
        // Upload "eicons.ttf" font via this site: http://bluejamesbond.github.io/CharacterMap/
        return 'smart-icon eicon-post';
    }

    /**
     * {@inheritdoc}
     */
    public function get_categories() {
        return [ 'smart-elements' ];
    }

    /**
     * {@inheritdoc}
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_acf',
            [
                'label' => _x( 'ACF', 'elementor', 'smart' ),
            ]
        );

        $this->add_control(
            'field_name',
            [
                'label'   => _x( 'Field Name', 'elementor', 'smart' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'field_type',
            [
                'label'   => _x( 'Field Type', 'elementor', 'smart' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => _x( 'Text', 'elementor', 'smart' ),
                    'link' => _x( 'Link', 'elementor', 'smart' ),
                ],
            ]
        );

        $this->add_control(
            'link_text',
            [
                'label'     => _x( 'Link Text', 'elementor', 'smart' ),
                'type'      => Controls_Manager::TEXT,
                'condition' => [
                    'field_type' => 'link',
                ],
                'dynamic'   => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'link_target',
            [
                'label'     => _x( 'Link Target', 'elementor', 'smart' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'self',
                'options'   => [
                    'self'  => _x( 'Self', 'elementor', 'smart' ),
                    'blank' => _x( 'Blank', 'elementor', 'smart' ),
                ],
                'condition' => [
                    'field_type' => 'link',
                ],
            ]
        );

        $this->add_control(
            'link_nofollow',
            [
                'label'     => _x( 'Add Nofollow', 'elementor', 'smart' ),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'field_type' => 'link',
                ],
            ]
        );

        $this->add_control(
            'field_label',
            [
                'label'   => _x( 'Label', 'elementor', 'smart' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'   => _x( 'Icon', 'elementor', 'smart' ),
                'type'    => Controls_Manager::ICON,
                'default' => '',
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'     => _x( 'Icon Position', 'elementor', 'smart' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => _x( 'Before', 'elementor', 'smart' ),
                    'right' => _x( 'After', 'elementor', 'smart' ),
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'     => _x( 'Icon Spacing', 'elementor', 'smart' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'condition' => [
                    'icon!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .smart-acf .elementor-align-icon-right' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .smart-acf .elementor-align-icon-left'  => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => _x( 'Alignment', 'elementor', 'smart' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => _x( 'Left', 'elementor', 'smart' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => _x( 'Center', 'elementor', 'smart' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => _x( 'Right', 'elementor', 'smart' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .smart-acf' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => _x( 'Field', 'elementor', 'smart' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'field_typography',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .smart-acf .smart-acf-field',
            ]
        );

        $this->add_control(
            'field_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .smart-acf .smart-acf-field' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_label_style',
            [
                'label'     => _x( 'Label', 'elementor', 'smart' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'field_label!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'label_typography',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_4,
                'selector'  => '{{WRAPPER}} .smart-acf .smart-acf-label',
                'condition' => [
                    'field_label!' => '',
                ],
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .smart-acf .smart-acf-label' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'field_label!' => '',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label'     => _x( 'Icon', 'elementor', 'smart' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .smart-acf .smart-acf-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'     => _x( 'Size', 'elementor', 'smart' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 5,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .smart-acf .smart-acf-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * {@inheritdoc}
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $type     = $settings['field_type'];

        $this->add_render_attribute( 'wrap', 'class', 'smart-acf' );

        if ( ! empty( $settings['icon'] ) ) {
            $this->add_render_attribute( 'icon', 'class', [
                'smart-acf-icon',
                'elementor-align-icon-' . $settings['icon_align'],
            ] );
        }

        $this->add_render_attribute( 'label', 'class', 'smart-acf-label' );
        $this->add_render_attribute( 'field', 'class', 'smart-acf-field' );

        $this->add_render_attribute( 'link', 'class', 'smart-acf-field' );
        $this->add_render_attribute( 'link', 'href', esc_url( get_field( $settings['field_name'] ) ) );
        $this->add_render_attribute( 'link', 'target', '_' . $settings['link_target'] );

        if ( true == $settings['link_nofollow'] ) {
            $this->add_render_attribute( 'link', 'rel', 'nofollow' );
        } ?>

        <div <?php echo $this->get_render_attribute_string( 'wrap' ); ?>>
            <?php
            if ( ! empty( $settings['icon'] ) && 'left' == $settings['icon_align'] ) { ?>
                <span <?php echo $this->get_render_attribute_string( 'icon' ); ?>>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				</span>
                <?php
            } ?>

            <?php
            if ( ! empty( $settings['field_label'] ) ) { ?>
                <span <?php echo $this->get_render_attribute_string( 'label' ); ?>>
					<?php echo esc_attr( $settings['field_label'] ); ?>
				</span>
            <?php } ?>

            <?php
            if ( 'text' == $type ) { ?>
                <span <?php echo $this->get_render_attribute_string( 'field' ); ?>>
					<?php echo do_shortcode( get_field( $settings['field_name'] ) ); ?>
				</span>
                <?php
            } else if ( 'link' == $type ) { ?>
                <a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
                    <?php
                    if ( ! empty( $settings['link_text'] ) ) {
                        echo esc_attr( $settings['link_text'] );
                    } else {
                        echo do_shortcode( get_field( $settings['field_name'] ) );
                    } ?>
                </a>
                <?php
            } ?>

            <?php
            if ( ! empty( $settings['icon'] ) && 'right' == $settings['icon_align'] ) { ?>
                <span <?php echo $this->get_render_attribute_string( 'icon' ); ?>>
					<i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
				</span>
                <?php
            } ?>
        </div>

        <?php
    }
}
