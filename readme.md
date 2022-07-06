# Easy toast notifications for your Laravel apps

This composer package offers **Bootstrap 5** toast notifications and modals for your Laravel applications.

---

_This package is derived from laracasts/flash_

---

## Installation

Begin by pulling in the package through Composer.

```bash
composer require godforhire/toast
```

## Usage

Within your controllers, before you perform a redirect, make a call to the `toast()` function.

```php
public function store()
{
    toast('Toast message!');

    return home();
}
```

Toast themes follow the Bootstrap contextual classes:

- `toast('Toast message')->info()`: Set the toast theme to "info"
- `toast('Toast message')->success()`: Set the toast theme to "success"
- `toast('Toast message')->warning()`: Set the toast theme to "warning"
- `toast('Toast message')->danger()`: Set the toast theme to "danger"

If no class is passed, the default is set to "info".

Except for overlays, toast messages are automatically dismissed after 5 seconds, but if you wish to change this, use the delay method:
- `toast('Message')->danger()->delay(10000)`


Add `important()` to manually dismiss a toast message:
- `toast('Message')->danger()->important()`

To render the message as an overlay/modal, use: 

- `toast('Toast message')->overlay()`
  
You can also add a title:

- `toast()->overlay('Modal Message', 'Modal Title')`

With this message toasted to the session, you may now display it in your view(s). Because toast messages and overlays are so common, we provide a template out of the box to get you started. You're free to use - and even modify to your needs - this template how you see fit.

```html
@include('toast::message')
```

In your application template, add the following code to toggle the toast messages/modal:

```html
    $('.toast-overlay-modal').modal('show');
    $('.toast').toast('show');
```

If you need to modify the toast message partials, you can run:

```bash
php artisan vendor:publish --provider="godforhire\Toast\ToastServiceProvider"
```

Please refer to the official Bootstrap 5 documentation for positioning the toast messages: https://getbootstrap.com/docs/5.1/components/toasts/

The two package views will now be located in the `resources/views/vendor/toast/` directory.

## Multiple Toast Messages

Need to toast multiple toast messages to the session? No problem.

```php
toast('Toast message 1')->info();
toast('Toast message 2')->warning()->important();
toast('Toast message 3')->warning()->important();

return redirect('somewhere');
```

You'll now see three toast messages upon redirect.

You can also mix in an overlay to display both:

```php
toast('Toast message 1')->info();
toast()->overlay('Toast message', 'Notice')->important();

return redirect('somewhere');
```

If you redirect to another controller and create toast message there, it will be appended to the collection.

## Multiple Modal Messages

While it is possible to display multiple modals, they will be stacked on top of each other. This will also result in multiple background overlays, causing the background to increase in darkness with each modal. 