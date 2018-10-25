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
        return __( 'ACF', 'smart' );
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
        return [ 'oceanwp-elements' ];
    }

    /**
     * {@inheritdoc}
     */
    protected function _register_controls() {

        $this->start_controls_section(
            'section_acf',
            [
                'label' => __( 'ACF', 'smart' ),
            ]
        );

        $this->add_control(
            'field_name',
            [
                'label'   => __( 'Field Name', 'smart' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'field_type',
            [
                'label'   => __( 'Field Type', 'smart' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => __( 'Text', 'smart' ),
                    'link' => __( 'Link', 'smart' ),
                ],
            ]
        );

        $this->add_control(
            'link_text',
            [
                'label'     => __( 'Link Text', 'smart' ),
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
                'label'     => __( 'Link Target', 'smart' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'self',
                'options'   => [
                    'self'  => __( 'Self', 'smart' ),
                    'blank' => __( 'Blank', 'smart' ),
                ],
                'condition' => [
                    'field_type' => 'link',
                ],
            ]
        );

        $this->add_control(
            'link_nofollow',
            [
                'label'     => __( 'Add Nofollow', 'smart' ),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'field_type' => 'link',
                ],
            ]
        );

        $this->add_control(
            'field_label',
            [
                'label'   => __( 'Label', 'smart' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => [ 'active' => true ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'   => __( 'Icon', 'smart' ),
                'type'    => Controls_Manager::ICON,
                'default' => '',
            ]
        );

        $this->add_control(
            'icon_align',
            [
                'label'     => __( 'Icon Position', 'smart' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'left',
                'options'   => [
                    'left'  => __( 'Before', 'smart' ),
                    'right' => __( 'After', 'smart' ),
                ],
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_indent',
            [
                'label'     => __( 'Icon Spacing', 'smart' ),
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
                'label'     => __( 'Alignment', 'smart' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'smart' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'smart' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'smart' ),
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
                'label' => __( 'Field', 'smart' ),
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
                'label'     => __( 'Color', 'smart' ),
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
                'label'     => __( 'Label', 'smart' ),
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
                'label'     => __( 'Color', 'smart' ),
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
                'label'     => __( 'Icon', 'smart' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __( 'Color', 'smart' ),
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
                'label'     => __( 'Size', 'smart' ),
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
