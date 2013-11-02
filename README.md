CMandrill - Mandrill Library for Joomla by compojoom
=======================================================

This library is based on the original PHP Wrapper developed by Mandrill:

The goal of this library is to make it easy for Joomla developers to use
this library in their extensions


Basic usage:
```php
$mandrill = new CmandrillQuery($apiKey, array( 'ssl' => 0));
$mandrill->message->send($message);
```

## COPYRIGHT AND DISCLAIMER
Compojoom Build Tools - Extension builder for Joomla! Copyright (c) 2008-2013 Compojoom.com

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the
Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/.

##Joomla extensions using this library
CMandrill - https://github.com/compojoom/cmandrill