<?php

namespace ZFbase\Notices\Controller\Plugin;

use Countable;
use ArrayIterator;
use IteratorAggregate;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Session\Container;
use Zend\Session\ManagerInterface as Manager;
use Zend\Stdlib\SplQueue;
use ZFbase\Notices\Message;

class Notices extends AbstractPlugin implements Countable, IteratorAggregate
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Manager
     */
    protected $session;

    /**
     * Set the session manager
     *
     * @param  Manager $manager
     * @return Notices
     */
    public function setSessionManager(Manager $manager)
    {
        $this->session = $manager;
        return $this;
    }

    /**
     * Retrieve the session manager
     *
     * If none composed, lazy-loads a SessionManager instance
     *
     * @return Manager
     */
    public function getSessionManager()
    {
        if (! $this->session instanceof Manager) {
            $this->setSessionManager(Container::getDefaultManager());
        }

        return $this->session;
    }

    /**
     * Get session container for notices
     *
     * @return Container
     */
    public function getContainer()
    {
        if (null === $this->container) {
            $manager = $this->getSessionManager();
            $this->container = new Container('Notices', $manager);
        }

        return $this->container;
    }

    /**
     * Add a message
     *
     * @param  Message $message
     * @return Notices
     */
    public function addMessage(Message $message)
    {
        $container = $this->getContainer();

        if (! $container->notices instanceof SplQueue) {
            $container->notices = new SplQueue;
        }

        $container->notices->push($message);

        return $this;
    }

    /**
     * Add a message with "info" type
     *
     * @param  string  $message
     * @return Notices
     */
    public function addInfoMessage($message)
    {
        return $this->addMessage(new Message($message, Message::CLASS_INFO));
    }

    /**
     * Add a message with "success" type
     *
     * @param  string  $message
     * @return Notices
     */
    public function addSuccessMessage($message)
    {
        return $this->addMessage(new Message($message, Message::CLASS_SUCCESS));
    }

    /**
     * Add a message with "warning" type
     *
     * @param  string  $message
     * @return Notices
     */
    public function addWarningMessage($message)
    {
        return $this->addMessage(new Message($message, Message::CLASS_WARNING));
    }

    /**
     * Add a message with "error" type
     *
     * @param  string  $message
     * @return Notices
     */
    public function addErrorMessage($message)
    {
        return $this->addMessage(new Message($message, Message::CLASS_ERROR));
    }

    /**
     * Are there any messages
     *
     * @return boolean
     */
    public function hasMessages()
    {
        $container = $this->getContainer();

        if (! $container->notices instanceof SplQueue) {
            return false;
        }

        return $container->notices->count() > 0;
    }

    /**
     * Get messages
     *
     * @return type
     */
    public function getMessages()
    {
        $container = $this->getContainer();

        if ($container->notices instanceof SplQueue) {
            return $container->notices->toArray();
        }

        return [];
    }

    /**
     * Clear all messages
     *
     * @return boolean
     */
    public function clearMessages()
    {
        $container = $this->getContainer();

        if ($container->notices instanceof SplQueue) {
            unset($container->notices);
            return true;
        }

        return false;
    }
    
    
    public function popMessage()
    {
        $container = $this->getContainer();
        
        if ($container->notices instanceof SplQueue) {
            return $container->notices->dequeue();
        }

        return null;
    }

    /**
     * Complete the countable interface
     *
     * @return int
     */
    public function count()
    {
        $container = $this->getContainer();

        if ($container->notices instanceof SplQueue) {
            return $container->notices->count();
        }

        return 0;
    }

    /**
     * Complete the IteratorAggregate interface, for iterating
     *
     * @return ArrayIterator
     */
    public function getIterator()
    {
        if ($this->hasMessages()) {
            return new ArrayIterator($this->getMessages());
        }

        return new ArrayIterator;
    }
}
