# which1ispink/session

This is a simple PHP native session wrapper

## Installation

If you're using composer it's as easy as requiring the package:

```bash
$ composer require which1ispink/session
```

Otherwise you'd have to include the src/Session.php file the old-fashioned way.

## Usage

```php
// this needs to be called in your bootstrapping code like an index.php file
Session::init();

// setting a session variable
Session::set('username', 'some_username);

// getting said variable later
Session::get('username');

// get all session contents
Session::all();

// or get all session contents including flash messages
Session::all(true);

// check if previous session variable exists (returns a boolean)
Session::has('username');

// or remove previous session variable
Session::remove('username');

// or go a step further and clear all session data
Session::clear();
```

## Flash messages
You can use flash messages that only exist for the duration of next request
```php
// add a flash message
Session::addFlashMessage('status', 'Your order has been submitted successfully!');

// get previous flash message on the next request
Session::getFlashMessage('status');

// get all flash messages currently in the session
Session::getAllFlashMessages();
```

## License

This library is licensed under the MIT license. See [License File](LICENSE.md) for more information.
