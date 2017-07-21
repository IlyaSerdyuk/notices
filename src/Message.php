<?php

namespace ZFbase\Notices;

use InvalidArgumentException;

class Message
{
    // Classes
    const CLASS_SUCCESS = 'success';
    const CLASS_INFO = 'info';
    const CLASS_WARNING = 'warning';
    const CLASS_ERROR = 'danger';

    /**
     * Title
     *
     * @var string
     */
    protected $title;

    /**
     * Class
     *
     * @var string
     */
    protected $class;

    /**
     * Constructor
     *
     * @param string $title
     * @param string $class
     */
    public function __construct($title, $class)
    {
        $this->setTitle($title);
        $this->setClass($class);
    }

    /**
     * Set the title
     *
     * @param string $title
     * @return Message
     */
    public function setTitle($title)
    {
        $this->title = (string) $title;
        return $this;
    }

    /**
     * Get the title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the class
     *
     * @param  type $class
     * @return Message
     * @throws InvalidArgumentException
     */
    public function setClass($class)
    {
        if (! in_array($class, self::getClassList())) {
            throw new InvalidArgumentException(sprintf('Class "%s" is not allowed', $class));
        }

        $this->class = (string) $class;
        return $this;
    }

    /**
     * Get the class
     *
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * Get allowed classes
     *
     * @return array|string[]
     */
    public static function getClassList()
    {
        return [
            self::CLASS_SUCCESS,
            self::CLASS_INFO,
            self::CLASS_WARNING,
            self::CLASS_ERROR,
        ];
    }
}
