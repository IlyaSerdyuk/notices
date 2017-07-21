# Notices for Zend Framework 2/3

Extension for displaying messages in Zend Framework 2/3 and Twitter bootstrap 3 applications.


## Installation

Add to layout:
```html
<?= $this->notices() ?>
```


## How use

Send messages from the controllers:

```php
class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $this->notices()->addSuccessMessage('You successfully read this important alert message.');
        $this->notices()->addInfoMessage('This alert needs your attention, but it's not super important.');
        $this->notices()->addWarningMessage('Better check yourself, you're not looking too good.');
        $this->notices()->addErrorMessage('Change a few things up and try submitting again.');
    }
}
```

Output:

```html
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Well done!</strong>
    You successfully read this important alert message.
</div>


<div class="alert alert-info alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Heads up!</strong>
    This alert needs your attention, but it's not super important.
</div>


<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Warning!</strong>
    Better check yourself, you're not looking too good.
</div>


<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Oh snap!</strong>
    Change a few things up and try submitting again.
</div>
```


## How to configure

You can customize the output template, turn off escaping and change the label of messages.
To do this, add to config file (config/autoload/global.php):

```php
return [
    'view_helper_config' => [
        'notices' => [
            'auto_escape' => true,
            'template_string' => '<div class="alert alert-{class} alert-dismissible" role="alert">{text}</div>',
            'label_for_status' => [
                Message::CLASS_SUCCESS => 'Успешно:',
                Message::CLASS_INFO => 'Информация:',
                Message::CLASS_WARNING => 'Предупреждение:',
                Message::CLASS_ERROR => 'Ошибка:',
            ],
        ],
    ],
];
```
