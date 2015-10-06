# PhpKairos

PhpKairos is a good SDK to work with Kairos (https://www.kairos.com)

> **status: Development**
> Please [report any bugs](https://github.com/ympons/PhpKairos/issues) you find so that we can improve the library for everyone.

#### Requires
- PHP Version >= 5.5

## Installation

Main public repository of PhpKairos is hosted at [https://github.com/ympons/PhpKairos.git](https://github.com/ympons/PhpKairos.git).

To install most recent version of library, just type
    
    git clone https://github.com/ympons/PhpKairos.git

where you want its file to be located.

If you have not already installed globally, you have to download composer. Just run this command inside your PhpKairos directory.
```bash
php -r "readfile('https://getcomposer.org/installer');" | php
```
Now get the required libraries to work with PhpKairos:
```bash
php composer.phar --no-dev install
```
###### Note:
> If you already have a composer installed or your existing project use it, you can install/add PhpKairos via Composer [https://packagist.org/packages/ympons/phpkairos](https://packagist.org/packages/ympons/phpkairos), it is linked to this GitHub repository ( so it is everityme updated ), and add it as dependecy to your project.
    
    php composer.phar require "ympons/phpkairos:dev-master" --update-no-dev

## Usage
PhpKairos specify autoload information, Composer generates a vendor/autoload.php file. You can simply include this file and you will get autoloading for free and declare the use of PhpKairos Client with fully qualified name.

```php
require "vendor/autoload.php";
use PhpKairos\PhpKairos;
```
