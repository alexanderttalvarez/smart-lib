<?php
/**
 * WPForms class
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

class Wpforms extends Widget_Base {

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-wpforms';
    }

    /**
     * {@inheritdoc}
     */
    public function get_title() {
        return _x( 'WPForms', 'elementor', 'smart' );
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
            'section_wpforms',
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
            'hide_form_title_description',
            [
                'label'   => _x( 'Hide Title & Description', 'elementor', 'smart' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'no',
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
                    '{{WRAPPER}} .wpforms-field label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'labels_typo',
                'selector' => '{{WRAPPER}} .wpforms-field label',
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
                    '{{WRAPPER}} .wpforms-field label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpforms-form .wpforms-field-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typo',
                'selector' => '{{WRAPPER}} .wpforms-form .wpforms-field-description',
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
                    '{{WRAPPER}} .wpforms-form .wpforms-field-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select',
            ]
        );

        $this->add_control(
            'inputs_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):hover, {{WRAPPER}} .wpforms-field textarea:hover, {{WRAPPER}} .wpforms-field select:hover',
            ]
        );

        $this->add_control(
            'inputs_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):hover, {{WRAPPER}} .wpforms-field textarea:hover, {{WRAPPER}} .wpforms-field select:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):hover, {{WRAPPER}} .wpforms-field textarea:hover, {{WRAPPER}} .wpforms-field select:hover' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .wpforms-field textarea:focus, {{WRAPPER}} .wpforms-field select:focus',
            ]
        );

        $this->add_control(
            'inputs_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .wpforms-field textarea:focus, {{WRAPPER}} .wpforms-field select:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]):focus, {{WRAPPER}} .wpforms-field textarea:focus, {{WRAPPER}} .wpforms-field select:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'inputs_typo',
                'selector'  => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select',
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
                    '{{WRAPPER}} .wpforms-field input::-webkit-input-placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpforms-field input::-moz-placeholder'          => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpforms-field input:-ms-input-placeholder'      => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'inputs_border',
                'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select',
            ]
        );

        $this->add_control(
            'inputs_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'inputs_box_shadow',
                'selector' => '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select',
            ]
        );

        $this->add_responsive_control(
            'inputs_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpforms-field input:not([type=radio]):not([type=checkbox]):not([type=submit]):not([type=button]):not([type=image]):not([type=file]), {{WRAPPER}} .wpforms-field textarea, {{WRAPPER}} .wpforms-field select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpforms-form .wpforms-field input.wpforms-error, {{WRAPPER}} .wpforms-form .wpforms-field textarea.wpforms-error, {{WRAPPER}} .wpforms-form .wpforms-field select.wpforms-error' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'invalid_inputs_border',
                'selector' => '{{WRAPPER}} .wpforms-form .wpforms-field input.wpforms-error, {{WRAPPER}} .wpforms-form .wpforms-field textarea.wpforms-error, {{WRAPPER}} .wpforms-form .wpforms-field select.wpforms-error',
            ]
        );

        $this->add_control(
            'invalid_inputs_color',
            [
                'label'     => _x( 'Text Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-form label.wpforms-error' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'invalid_inputs_typo',
                'selector' => '{{WRAPPER}} .wpforms-form label.wpforms-error',
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
                'selector' => '{{WRAPPER}} .wpforms-submit-container .wpforms-submit',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpforms-submit-container .wpforms-submit:hover',
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit:hover' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpforms-submit-container .wpforms-submit:focus',
            ]
        );

        $this->add_control(
            'button_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typo',
                'selector'  => '{{WRAPPER}} .wpforms-submit-container .wpforms-submit',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .wpforms-submit-container .wpforms-submit',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .wpforms-submit-container .wpforms-submit',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpforms-submit-container .wpforms-submit' => 'display: {{VALUE}}; width: 100%;',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_success_message_style',
            [
                'label' => _x( 'Success Message', 'elementor', 'smart' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sent_typo',
                'selector' => '{{WRAPPER}} .wpforms-confirmation-container-full',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_control(
            'sent_background_color',
            [
                'label'     => _x( 'Background Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-confirmation-container-full' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sent_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpforms-confirmation-container-full' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'sent_border',
                'selector' => '{{WRAPPER}} .wpforms-confirmation-container-full',
            ]
        );

        $this->add_control(
            'sent_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpforms-confirmation-container-full' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpforms-confirmation-container-full' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * {@inheritdoc}
     */
    protected function get_available_forms() {

        if ( ! class_exists( 'WPForms' ) ) {
            return [];
        }

        $args = [
            'post_type'      => 'wpforms',
            'posts_per_page' => - 1,
        ];

        $forms = get_posts( $args );

        $result = [ _x( '-- Select --', 'elementor', 'smart' ) ];

        if ( ! empty( $forms ) && ! is_wp_error( $forms ) ) {
            foreach ( $forms as $form ) {
                $result[ $form->ID ] = $form->post_title;
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

        if ( 'yes' == $settings['hide_form_title_description'] ) {
            $form_title       = false;
            $form_description = false;
        } else {
            $form_title       = true;
            $form_description = true;
        }

        if ( '0' != $form && ! empty( $form ) ) {
            echo wpforms_display( $form, $form_title, $form_description );
        }
    }

}
