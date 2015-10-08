# PhpKairos

PhpKairos is a nice client for the [Kairos Face Recognition API](https://www.kairos.com)

> **status: Stable**
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
> If you already have a composer installed or your existing project use it, you can install/add PhpKairos via Composer [https://packagist.org/packages/ympons/phpkairos](https://packagist.org/packages/ympons/phpkairos), it is linked to this GitHub repository ( so it is everytime updated ), and add it as dependecy to your project.
    
    php composer.phar require "ympons/phpkairos:dev-master" --update-no-dev

## Usage
PhpKairos specify autoload information, Composer generates a vendor/autoload.php file. You can simply include this file and you will get autoloading for free and declare the use of PhpKairos Client with fully qualified name.

```php
require "vendor/autoload.php";
use PhpKairos\PhpKairos;
```

### Client initialization

```php
$api     = 'http://api.kairos.com/';
$app_id  = 'your_app_id';
$app_key = 'your_app_key';
$client = new PhpKairos( $api, $app_id, $app_key );
```

### Enroll an image
The image parameter must be a publicly accessible URL or Base64 encoded photo.
```php
$image        = 'http://media.kairos.com/kairos-elizabeth.jpg';
$subject_id   = 'subject1';
$gallery_name = 'gallerytest1';
$options      = [
  'selector' => 'SETPOSE',
  'symmetricFill' => true
];

$response = $client->enroll($image, $subject_id, $gallery_name, $options);
$result   = $response->getBody()->getContents();
```

### Recognize an image
The image parameter must be a publicly accessible URL or Base64 encoded photo.
```php
$image        = 'http://media.kairos.com/kairos-elizabeth.jpg';
$gallery_name = 'gallerytest1';

$response = $client->recognize($image, $gallery_name);
$result   = $response->getBody()->getContents();
```

### Detect image attributes
The image parameter must be a publicly accessible URL or Base64 encoded photo.
```php
$encodedImage = 'iVBORw0KGgoAAA ... ABJRU5ErkJggg==\r\n';

$response = $client->detect($encodedImage);
$result   = $response->getBody()->getContents();
```

### List galleries
Lists out all the galleries you have created.
```php
$response = $client->listGalleries();
$result   = $response->getBody()->getContents();
```

### View a gallery
Lists out all the subjects you have enrolled in a gallery
```php
$gallery_name = 'gallerytest1';

$response = $client->viewGallery($gallery_name);
$result   = $response->getBody()->getContents();
```

### Remove a gallery
```php
$gallery_name = 'gallerytest1';

$response = $client->removeGallery($gallery_name);
$result   = $response->getBody()->getContents();
```

### Remove a subject
Removes a subject you have enrolled within a gallery
```php
$subject_id   = 'subject1';
$gallery_name = 'gallerytest1';

$response = $client->removeSubject($subject_id, $gallery_name);
$result   = $response->getBody()->getContents();
```
