<?php
/**
 * Contact Form class
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

class ContactForm extends Widget_Base {

    /**
     * {@inheritdoc}
     */
    public function get_name() {
        return 'smart-contact-form-7';
    }

    /**
     * {@inheritdoc}
     */
    public function get_title() {
        return _x( 'Contact Form 7', 'elementor', 'smart' );
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
            'section_contact_form_7',
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
                    '{{WRAPPER}} .wpcf7 label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'labels_typo',
                'selector' => '{{WRAPPER}} .wpcf7 label',
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
                    '{{WRAPPER}} .wpcf7 label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'labels_alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 label' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'invalid_label_heading',
            [
                'label'     => _x( 'Not Valid Notices', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'invalid_label_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 span.wpcf7-not-valid-tip' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'invalid_label_typo',
                'selector' => '{{WRAPPER}} .wpcf7 span.wpcf7-not-valid-tip',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
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
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)',
            ]
        );

        $this->add_control(
            'inputs_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):hover',
            ]
        );

        $this->add_control(
            'inputs_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):hover' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):focus',
            ]
        );

        $this->add_control(
            'inputs_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'inputs_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio):focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'inputs_typo',
                'selector'  => '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)',
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
                    '{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-form-control::-webkit-input-placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-form-control::-moz-placeholder'          => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-form-control:-ms-input-placeholder'      => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'inputs_border',
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)',
            ]
        );

        $this->add_control(
            'inputs_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'inputs_box_shadow',
                'selector' => '{{WRAPPER}} .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)',
            ]
        );

        $this->add_responsive_control(
            'inputs_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpcf7 .wpcf7-form-control:not(.wpcf7-submit):not(.wpcf7-checkbox):not(.wpcf7-radio)' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => '{{WRAPPER}} .wpcf7 input.wpcf7-submit',
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit' => 'color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpcf7 input.wpcf7-submit:hover',
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit:hover' => 'border-color: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .wpcf7 input.wpcf7-submit:focus',
            ]
        );

        $this->add_control(
            'button_focus_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_focus_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'      => 'button_typo',
                'selector'  => '{{WRAPPER}} .wpcf7 input.wpcf7-submit',
                'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'button_border',
                'selector' => '{{WRAPPER}} .wpcf7 input.wpcf7-submit',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} input.wpcf7-submit',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpcf7 input.wpcf7-submit' => 'display: {{VALUE}}; width: 100%;',
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
                'selector' => '{{WRAPPER}} .wpcf7 div.wpcf7-response-output',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'alerts_border',
                'selector' => '{{WRAPPER}} .wpcf7 div.wpcf7-response-output',
            ]
        );

        $this->add_control(
            'alerts_border_radius',
            [
                'label'      => _x( 'Border Radius', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-response-output' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'alerts_box_shadow',
                'selector' => '{{WRAPPER}} div.wpcf7-response-output',
            ]
        );

        $this->add_responsive_control(
            'alerts_padding',
            [
                'label'      => _x( 'Padding', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-response-output' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alerts_margin',
            [
                'label'      => _x( 'Margin', 'elementor', 'smart' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-response-output' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'alerts_alignment',
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
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-response-output' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sent_heading',
            [
                'label'     => _x( 'Sent Success', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'sent_background',
            [
                'label'     => _x( 'Background Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-mail-sent-ok' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sent_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-mail-sent-ok' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sent_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-mail-sent-ok' => 'border-color: {{VALUE}};',
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
            'error_background',
            [
                'label'     => _x( 'Background Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-mail-sent-ng' => 'background-color: {{VALUE}};',
                ],
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
            'error_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-mail-sent-ng' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'invalid_alert_heading',
            [
                'label'     => _x( 'Not Valid', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'invalid_alert_background',
            [
                'label'     => _x( 'Background Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-validation-errors' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'invalid_alert_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-validation-errors' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'invalid_alert_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-validation-errors' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'spam_heading',
            [
                'label'     => _x( 'Spam Blocked', 'elementor', 'smart' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'spam_background',
            [
                'label'     => _x( 'Background Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-spam-blocked' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'spam_color',
            [
                'label'     => _x( 'Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-spam-blocked' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'spam_border_color',
            [
                'label'     => _x( 'Border Color', 'elementor', 'smart' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 div.wpcf7-spam-blocked' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    /**
     * {@inheritdoc}
     */
    protected function get_available_forms() {

        if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
            return [];
        }

        $forms = \WPCF7_ContactForm::find( [
            'orderby' => 'title',
            'order'   => 'ASC',
        ] );

        if ( empty( $forms ) ) {
            return [];
        }

        $result = [ _x( '-- Select --', 'elementor', 'smart' ) ];

        foreach ( $forms as $item ) {
            $key            = sprintf( '%1$s::%2$s', $item->id(), $item->title() );
            $result[ $key ] = $item->title();
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function render() {
        $settings = $this->get_settings();

        $form = $settings['form'];
        $data = explode( '::', $form );

        if ( '0' != $form && ! empty( $data ) && 2 === count( $data ) ) {
            echo do_shortcode( sprintf( '[contact-form-7 id="%1$d" title="%2$s"]', $data[0], $data[1] ) );
        }
    }

}
