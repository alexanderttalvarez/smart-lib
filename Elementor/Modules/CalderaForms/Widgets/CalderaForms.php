<?php
/**
 * Caldera Forms class
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
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Widget_Base;

class CalderaForms extends Widget_Base {

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-caldera-forms';
    }

    /**
     * {@inheritdoc}
     */
    public function get_title() {
        return _x( 'Caldera Forms', 'elementor', 'smart' );
    }

    /**
     * {@inheritdoc}
     */
    public function get_icon() {
        // Upload "eicons.ttf" font via this site: http://bluejamesbond.github.io/CharacterMap/
        return 'smart-icon eicon-form-horizontal';
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
            'section_caldera_forms',
            [
                'label' => _x( 'Form', 'elementor', 'smart' ),
            ]
        );

        $this->add_control(
            'form',
            [
                'label'   => _x( 'Select Form', 'elementor', 'smart' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '0',
                'options' => $this->get_available_forms(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => _x( 'Labels', 'elementor', 'smart' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'labels_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'labels_typo',
                'selector' => '{{WRAPPER}} .caldera-grid label',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_responsive_control(
            'labels_margin',
            [
                'label'      => _x( 'Margin', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'description_heading',
            [
                'label'     => _x( 'Description', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .help-block' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typo',
                'selector' => '{{WRAPPER}} .caldera-grid .help-block',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_responsive_control(
            'description_margin',
            [
                'label'      => _x( 'Margin', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid .help-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_inputs_style',
            [
                'label' => _x( 'Inputs & Textarea', 'elementor', 'smart' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_inputs_style' );

        $this->start_controls_tab(
            'tab_inputs_normal',
            [
                'label' => _x( 'Normal', 'elementor', 'smart' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'inputs_background',
                'selector' => '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
            ]
        );

        $this->add_control(
            'inputs_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_inputs_hover',
            [
                'label' => _x( 'Hover', 'elementor', 'smart' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'inputs_hover_background',
                'selector' => '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"]):hover',
            ]
        );

        $this->add_control(
            'inputs_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"]):hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"]):hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_inputs_focus',
            [
                'label' => _x( 'Focus', 'elementor', 'smart' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'inputs_focus_background',
                'selector' => '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"]):focus',
            ]
        );

        $this->add_control(
            'inputs_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"]):focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"]):focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'inputs_typo',
                'selector'  => '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'inputs_placeholder_color',
            [
                'label'     => _x( 'Placeholder Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .form-control::-webkit-input-placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .caldera-grid .form-control::-moz-placeholder'          => 'color: {{VALUE}}',
                    '{{WRAPPER}} .caldera-grid .form-control:-ms-input-placeholder'      => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'inputs_border',
                'selector' => '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
            ]
        );

        $this->add_control(
            'inputs_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'inputs_box_shadow',
                'selector' => '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
            ]
        );

        $this->add_responsive_control(
            'inputs_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'inputs_margin',
            [
                'label'      => _x( 'Margin', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid .form-control:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => _x( 'Submit Button', 'elementor', 'smart' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => _x( 'Normal', 'elementor', 'smart' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_background',
                'selector' => '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => _x( 'Hover', 'elementor', 'smart' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_hover_background',
                'selector' => '{{WRAPPER}} .caldera-grid input[type=reset]:hover, .caldera-grid input[type=submit]:hover',
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid input[type=reset]:hover, .caldera-grid input[type=submit]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid input[type=reset]:hover, .caldera-grid input[type=submit]:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_focus',
            [
                'label' => _x( 'Focus', 'elementor', 'smart' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'button_focus_background',
                'selector' => '{{WRAPPER}} .caldera-grid input[type=reset]:focus, .caldera-grid input[type=submit]:focus',
            ]
        );

        $this->add_control(
            'button_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid input[type=reset]:focus, .caldera-grid input[type=submit]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid input[type=reset]:focus, .caldera-grid input[type=submit]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typo',
                'selector'  => '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label'      => _x( 'Margin', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_fullwidth',
            [
                'label'        => _x( 'Fullwidth Button', 'elementor', 'smart' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'block',
                'selectors'    => [
                    '{{WRAPPER}} .caldera-grid input[type=reset], .caldera-grid input[type=submit]' => 'display: {{VALUE}}; width: 100%;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_alerts_style',
            [
                'label' => _x( 'Alerts', 'elementor', 'smart' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'alerts_typo',
                'selector' => '{{WRAPPER}} .caldera-grid .alert-success, {{WRAPPER}} .has-error .help-block',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'sent_heading',
            [
                'label'     => _x( 'Success Message', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sent_background_color',
            [
                'label'     => _x( 'Background Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .alert-success' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sent_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .caldera-grid .alert-success' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'sent_border',
                'selector' => '{{WRAPPER}} .caldera-grid .alert-success',
            ]
        );

        $this->add_control(
            'sent_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid .alert-success' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'sent_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .caldera-grid .alert-success' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'error_alert_heading',
            [
                'label'     => _x( 'Error Messages', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'error_alert_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .has-error .help-block' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * {@inheritdoc}
     */
    protected function get_available_forms() {

        if ( ! is_caldera_forms_active() ) {
            return [];
        }

        $forms = \Caldera_Forms_Forms::get_forms( true, true );

        $result = [ _x( '-- Select --', 'elementor', 'smart' ) ];

        if ( ! empty( $forms ) && ! is_wp_error( $forms ) ) {
            foreach ( $forms as $form ) {
                $result[ $form['ID'] ] = $form['name'];
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function render() {
        $settings = $this->get_settings();
        $form     = $settings['form'];

        if ( '0' != $form && ! empty( $form ) ) {
            echo do_shortcode( '[caldera_form id="' . $form . '"]' );
        }
    }

}
