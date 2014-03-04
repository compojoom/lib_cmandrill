CMandrill - Mandrill Library for Joomla by compojoom
=======================================================

This library is based on the original PHP Wrapper developed by Mandrill:

The goal of this library is to make it easy for Joomla developers to use
this library in their extensions


Basic usage:

```php
include 'PATH_TO_CMANDRILL_LIBRARY/include.php';
$mandrill = new CmandrillQuery($apiKey, $ssl, $cache);
$mandrill->messages->send($message);
```

## Building installable Joomla zip package from github
In order to build the installation packages of this library you need to have
the following tools:

- A command line environment. Bash under Linux / Mac OS X . On Windows
  you will need to run most tools using an elevated privileges (administrator)
  command prompt.
- The PHP CLI binary in your path

- Command line Subversion and Git binaries(*)

- PEAR and Phing installed, with the Net_FTP and VersionControl_SVN PEAR
  packages installed

You will also need the following path structure on your system

- lib_cmandrill - This repository
- buildtools - Compojoom build tools (https://github.com/compojoom/buildtools)

Copy the builds/build.properties.txt to builds/build.properties.

In your command line environment navigate to the build folder and type:

```
phing
```

The Zip package will be created and stored in packages/libraries/lib_cmandrill


## COPYRIGHT AND DISCLAIMER
CMandrill libray for Joomla! Copyright (c) 2008-2013 Compojoom.com

This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the
Free Software Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see http://www.gnu.org/licenses/.

##Joomla extensions using this library
CMandrill - https://github.com/compojoom/cmandrill