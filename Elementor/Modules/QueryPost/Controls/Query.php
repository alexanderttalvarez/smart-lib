<?php
/**
 * Posts Query class
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart\Elementor\Modules\QueryPost\Controls;

use Elementor\Base_Data_Control;

class Query extends Base_Data_Control {
    const CONTROL_ID = 'smart-query-posts';

    /**
     * {@inheritdoc}
     */
    public function get_type() {
        return self::CONTROL_ID;
    }

    /**
     * {@inheritdoc}
     */
    protected function get_default_settings() {
        return [
            'label_block' => true,
            'multiple'    => false,
            'options'     => [],
            'post_type'   => 'all',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function enqueue() {
        wp_register_script(
            'smart-query-post',
            get_parent_theme_file_uri() . '/vendor/kec/smart-lib/Elementor/assets/js/query-post.js',
            [ 'jquery' ],
            '1.0.0'
        );

        wp_enqueue_script( 'smart-query-post' );
    }

    /**
     * {@inheritdoc}
     */
    public function content_template() {
        $control_uid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <label for="<?php echo $control_uid; ?>" class="elementor-control-title">{{{ data.label }}}</label>
            <div class="elementor-control-input-wrapper">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select id="<?php echo $control_uid; ?>" class="elementor-select2" type="select2" {{ multiple }} data-setting="{{ data.name }}">
                    <# _.each( data.options, function( option_title, option_value ) {
                    var value = data.controlValue;
                    if ( typeof value == 'string' ) {
                    var selected = ( option_value === value ) ? 'selected' : '';
                    } else if ( null !== value ) {
                    var value = _.values( value );
                    var selected = ( -1 !== value.indexOf( option_value ) ) ? 'selected' : '';
                    }
                    #>
                    <option {{ selected }} value="{{ option_value }}">{{{ option_title }}}</option>
                    <# } ); #>
                </select>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }
}
