<?php
namespace common\components;

/**
 * Exception represents a Generic Error for all purposes.
 */
class GenericError extends \yii\base\UserException
{
    public $title;

    /**
     * Constructor.
     * @param string $message error message
     * @param int $code error code
     * @param \Exception $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = null, $title = null, $code = 0, \Exception $previous = null)
    {
        if ( isset($title) && ! empty($title) ) {
            $this->title = $title;
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        if (isset($this->title)) {
            return $this->title;
        } else {
            return 'Error';
        }
    }
}
