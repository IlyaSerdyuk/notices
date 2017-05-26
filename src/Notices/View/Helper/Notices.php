<?php

namespace ZFbase\Notices\View\Helper;

use InvalidArgumentException;
use Zend\View\Helper\AbstractHelper;
use Zend\View\Helper\EscapeHtml;
use Zend\View\Helper\TranslatorAwareTrait;
use ZFbase\Notices\Controller\Plugin\Notices as PluginNotices;
use ZFbase\Notices\Message;

class Notices extends AbstractHelper
{
    use TranslatorAwareTrait;

    /**
     * Flag whether to escape messages
     *
     * @var bool
     */
    protected $autoEscape = true;

    /**
     * Html escape helper
     *
     * @var EscapeHtml
     */
    protected $escapeHtmlHelper;

    /**
     * Template for the template for message tags
     *
     * @var string
     */
    protected $messageTemplateString = '<div class="alert alert-{class} alert-dismissible" role="alert">'
                                     . '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
                                     . '<strong>{label}</strong> {text}'
                                     . '</div>';

    /**
     * Notices plugin
     *
     * @var PluginNotices
     */
    protected $pluginNotices;

    /**
     * Label for status
     *
     * @var array|string[]
     */
    protected $labelsForClasses = [
        Message::CLASS_SUCCESS => 'Well done!',
        Message::CLASS_INFO => 'Information!',
        Message::CLASS_WARNING => 'Warning!',
        Message::CLASS_ERROR => 'Error!',
    ];

    /**
     * Render all messages
     *
     * @return string
     */
    public function render()
    {
        $markup = '';

        $pluginNotices = $this->getPluginNotices();
        if ($pluginNotices->hasMessages()) {
            $messages = $pluginNotices->getMessages();
            $pluginNotices->clearMessages();
            
            foreach ($messages as $message) {
                $markup .= $this->renderMessage($message);
            }
        }

        return $markup;
    }

    /**
     * Magic render all messages
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Render message
     *
     * @param Message $message
     * @return string
     */
    protected function renderMessage(Message $message)
    {
        $escapeHtml = $this->getEscapeHtmlHelper();
        $translator = $this->getTranslator();
        $translatorTextDomain = $this->getTranslatorTextDomain();


        $title = $message->getTitle();

        if ($translator !== null) {
            $title = $translator->translate($title, $translatorTextDomain);
        }

        if ($this->getAutoEscape()) {
            $title = $escapeHtml($title);
        }


        $class = $message->getClass();
        $label = $this->getLabelByClass($class);

        return str_replace(
            ['{class}', '{label}', '{text}'],
            [ $class,    $label,    $title ],
            $this->messageTemplateString);
    }

    /**
     * Set whether or not auto escaping should be used
     *
     * @param  bool $autoEscape
     * @return self
     */
    public function setAutoEscape($autoEscape = true)
    {
        $this->autoEscape = (bool) $autoEscape;
        return $this;
    }

    /**
     * Return whether auto escaping is enabled or disabled
     *
     * return bool
     */
    public function getAutoEscape()
    {
        return $this->autoEscape;
    }

    /**
     *
     *
     * @param  string $messageTemplateString
     * @return Notices
     */
    public function setMessageTemplateString($messageTemplateString)
    {
        $this->messageTemplateString = (string) $messageTemplateString;
        return $this;
    }

    /**
     *
     *
     * @return string
     */
    public function getMessageTemplateString()
    {
        return $this->messageTemplateString;
    }

    /**
     * Set the notices plugin
     *
     * @param  PluginNotices $pluginNotices
     * @return Notices
     */
    public function setPluginNotices(PluginNotices $pluginNotices)
    {
        $this->pluginNotices = $pluginNotices;
        return $this;
    }

    /**
     * Get the notices plugin
     *
     * @return PluginNotices
     */
    public function getPluginNotices()
    {
        if (null === $this->pluginNotices) {
            $this->setPluginNotices(new PluginNotices);
        }

        return $this->pluginNotices;
    }

    /**
     * Retrieve the escapeHtml helper
     *
     * @return EscapeHtml
     */
    protected function getEscapeHtmlHelper()
    {
        if ($this->escapeHtmlHelper) {
            return $this->escapeHtmlHelper;
        }

        if (method_exists($this->getView(), 'plugin')) {
            $this->escapeHtmlHelper = $this->view->plugin('escapehtml');
        }

        if (! $this->escapeHtmlHelper instanceof EscapeHtml) {
            $this->escapeHtmlHelper = new EscapeHtml;
        }

        return $this->escapeHtmlHelper;
    }

    /**
     * Set label for message's class
     *
     * @param  string $class
     * @param  string $label
     * @throws InvalidArgumentException
     */
    public function setLabelByClass($class, $label)
    {
        if (! in_array($class, Message::getClassList())) {
            throw new InvalidArgumentException(sprintf('Class "%s" is not allowed', $class));
        }

        $this->labelsForClasses[$class] = $label;
    }

    /**
     * Get label for message's class
     *
     * @param  string $class
     * @return string
     * @throws InvalidArgumentException
     */
    public function getLabelByClass($class)
    {
        if (! in_array($class, Message::getClassList())) {
            throw new InvalidArgumentException(sprintf('Class "%s" is not allowed', $class));
        }

        return $this->labelsForClasses[$class];
    }
}
