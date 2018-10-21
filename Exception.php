<?php
/**
 * Error Controller
 *
 * @package    WordPress
 * @subpackage Smart
 * @since      1.0.0
 */

namespace Kec\Smart;

/**
 * Exception Controller
 */
class Exception extends \Exception {
    /**
     * Exception message
     *
     * @var string
     */
    protected $message = 'Unknown exception';

    /**
     * Unknown
     *
     * @var string
     */
    private $string;

    /**
     * User-defined exception code
     *
     * @var int
     */
    protected $code = 0;

    /**
     * Source filename of exception
     *
     * @var string
     */
    protected $file;

    /**
     * Source line of exception
     *
     * @var int
     */
    protected $line;

    /**
     * Unknown
     *
     * @var string
     */
    private $trace;

    /**
     * Exception constructor.
     *
     * @param null $message Message.
     * @param int  $code    Code.
     *
     * @throws \Kec\Smart\Exception If no message given.
     */
    public function __construct( $message = null, $code = 0 ) {
        if ( ! $message ) {
            throw new self( 'Unknown ' . \get_class( $this ) );
        }

        parent::__construct( $message, $code );
    }

    /**
     * Return string
     *
     * @return string
     */
    public function __toString() {
        return \get_class( $this ) . " '{$this->message}' in {$this->file}({$this->line})\n {$this->getTraceAsString()}";
    }
}
