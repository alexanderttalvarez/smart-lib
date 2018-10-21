<?php
/**
 * Customizer Control: smart-heading.
 *
 * @package     WordPress
 * @subpackage  Smart
 * @see         https://github.com/BraadMartin/components
 * @license     http://opensource.org/licenses/https://opensource.org/licenses/MIT
 * @since       1.0
 * @version     1.0
 */

namespace Kec\Smart\Customize\Control;

/**
 * Range control
 */
class Heading extends \Kirki_Control_Base {

	/** @inheritdoc */
	public $type = 'heading';

	/** @inheritdoc */
	public function enqueue() {
		wp_enqueue_style(
			'smart-heading',
			\Theme\asset_path( 'styles/customizer.css' ),
			[],
			\Theme\config( 'theme.version' )
		);
	}

	/** @inheritdoc */
	protected function content_template() {
		?>
		<h4 class="smart-customizer-heading">{{{ data.label }}}</h4>
		<?php
	}
}
