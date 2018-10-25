<?php
/**
 * Ninja Forms class
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

class NinjaForms extends Widget_Base {

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-ninja-forms';
    }

    /**
     * {@inheritdoc}
     */
    public function get_title() {
        return _x( 'Ninja Forms', 'elementor', 'smart' );
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
            'section_ninja_forms',
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

        $this->add_control(
            'form_title',
            [
                'label'        => _x( 'Hide Title', 'elementor', 'smart' ),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'return_value' => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .nf-form-title' => 'display: {{VALUE}};',
                ],
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
                    '{{WRAPPER}} .nf-field-label label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'labels_typo',
                'selector' => '{{WRAPPER}} .nf-field-label label',
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
                    '{{WRAPPER}} .nf-field-label label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .nf-field-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typo',
                'selector' => '{{WRAPPER}} .nf-field-description',
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
                    '{{WRAPPER}} .nf-field-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
            ]
        );

        $this->add_control(
            'inputs_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"]):hover',
            ]
        );

        $this->add_control(
            'inputs_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"]):hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"]):hover' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"]):focus',
            ]
        );

        $this->add_control(
            'inputs_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"]):focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"]):focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'inputs_typo',
                'selector'  => '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
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
                    '{{WRAPPER}} .ninja-forms-field::-webkit-input-placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ninja-forms-field::-moz-placeholder'          => 'color: {{VALUE}}',
                    '{{WRAPPER}} .ninja-forms-field:-ms-input-placeholder'      => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'inputs_border',
                'selector' => '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
            ]
        );

        $this->add_control(
            'inputs_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'inputs_box_shadow',
                'selector' => '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])',
            ]
        );

        $this->add_responsive_control(
            'inputs_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'invalid_inputs_heading',
            [
                'label'     => _x( 'Not Valid Input', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'invalid_inputs_border_color',
            [
                'label'     => _x( 'Input Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nf-error .ninja-forms-field:not([type="button"]):not([type="checkbox"]):not([type="radio"])' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'invalid_inputs_color',
            [
                'label'     => _x( 'Text Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nf-error-msg' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'invalid_inputs_typo',
                'selector' => '{{WRAPPER}} .nf-error-msg',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
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
                'selector' => '{{WRAPPER}} .ninja-forms-field[type="button"]',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field[type="button"]' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .ninja-forms-field[type="button"]:hover',
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field[type="button"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field[type="button"]:hover' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .ninja-forms-field[type="button"]:focus',
            ]
        );

        $this->add_control(
            'button_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field[type="button"]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .ninja-forms-field[type="button"]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typo',
                'selector'  => '{{WRAPPER}} .ninja-forms-field[type="button"]',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .ninja-forms-field[type="button"]',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .ninja-forms-field[type="button"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .ninja-forms-field[type="button"]',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .ninja-forms-field[type="button"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .ninja-forms-field[type="button"]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .ninja-forms-field[type="button"]' => 'display: {{VALUE}}; width: 100%;',
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
                'selector' => '{{WRAPPER}} .nf-response-msg, {{WRAPPER}} .nf-form-fields-required, {{WRAPPER}} .nf-error-wrap .nf-error-required-error',
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
            'sent_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nf-response-msg' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'error_heading',
            [
                'label'     => _x( 'Sent Error', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'error_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-mail-sent-ng' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'required_alert_heading',
            [
                'label'     => _x( 'Required Fields Notice', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'required_alert_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .nf-form-fields-required' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .nf-error-wrap .nf-error-required-error' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * {@inheritdoc}
     */
    protected function get_available_forms() {

        if ( ! class_exists( 'Ninja_Forms' ) ) {
            return [];
        }

        $forms = \Ninja_Forms()->form()->get_forms();

        $result = [ _x( '-- Select --', 'elementor', 'smart' ) ];

        if ( ! empty( $forms ) && ! is_wp_error( $forms ) ) {
            foreach ( $forms as $form ) {
                $result[ $form->get_id() ] = $form->get_setting( 'title' );
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
            echo do_shortcode( '[ninja_form id="' . $form . '"]' );
        }
    }

}
