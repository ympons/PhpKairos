<?php

/*
 * This file is part of the PhpKairos SDK
 *
 * (c) Yaismel Miranda <yaismel.miranda@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpKairos;

use PhpKairos\Exceptions\PhpKairosException;

/**
 * The PhpKairos class
 *
 * @author Yaismel Miranda <yaismel.miranda@gmail.com>
 */
class PhpKairos 
{
  /**
   * @var GuzzleHttp\Client $client
   */
  private $client;

  /**
   * Class Constructor
   *
   * @param string $url       The Kairos Face Recognition url.
   * @param string $app_id    The app id.
   * @param string $app_key   The app key.
   */
  public function __construct( $url = 'http://api.kairos.com/', $app_id = '', $app_key = '' )
  { 
    $options = [
      'base_uri' => $url,
      'headers' => [
        'app_id' => $app_id,
        'app_key' => $app_key
      ]
    ];
    
    self::configureDefaults($options);

    // Initialize the client
    try
    {
      $this->client = new \GuzzleHttp\Client($options);
    }
    catch (\Exception $e)
    {
      // Wrap any exception to PhpKairosException
      throw new PhpKairosException($e);
    }
  }

  private function getClient()
  {
    return $this->client;
  }

  private static function configureDefaults(array &$options)
  {
    $options['headers']['User-Agent'] = 'PhpKairos/1.0';
    $options['headers']['Content-Type'] = 'application/json';
  }

  /**
   * Takes a photo, finds the faces within it, and stores the faces into a gallery you create.
   *
   * @param uri|base64  $image
   * @param string      $subject_id
   * @param string      $gallery_name
   * @param array       $options
   * 
   * @return Psr\Http\Message\ResponseInterface
   */
  public function enroll($image, $subject_id, $gallery_name, array $options = array())
  {
    $params = [
          'image' => $image,
          'subject_id' => $subject_id,
          'gallery_name' => $gallery_name
    ];
    $params = $params + $options;
    return $this->client->post('enroll', [ 'json' => $params ]);
  }

  /**
   * Takes an photo, finds the faces within it, and tries to match them against the faces you have already enrolled into a gallery.
   *
   * @param uri|base64  $image
   * @param string      $gallery_name
   * @param array       $options
   *
   * @return Psr\Http\Message\ResponseInterface
   */
  public function recognize($image, $gallery_name, array $options = array())
  {
    $params = [
          'image' => $image,
          'gallery_name' => $gallery_name
    ];
    $params = $params + $options;
    
    return $this->client->post('recognize', [ 'json' => $params ]);
  }

  /**
   * Takes a photo and returns the facial features it finds.
   *
   * @param uri|base64  $image
   * @param array       $options
   *
   * @return Psr\Http\Message\ResponseInterface
   */
  public function detect($image, array $options = array())
  {
    $params = [ 'image' => $image ];
    $params = $params + $options;
    
    return $this->client->post('detect', [ 'json' => $params ]);  
  }

  /**
   * Lists out all the galleries you have created.
   *
   * @return Psr\Http\Message\ResponseInterface
   */  
  public function listGalleries(array $options = array())
  {
    return $this->client->post('gallery/list_all', [ 'json' => $options ]);      
  }

  /**
   * Lists out all the faces you have enrolled in a gallery.
   *
   * @param string $gallery_name
   *
   * @return Psr\Http\Message\ResponseInterface
   */
  public function viewGallery($gallery_name, array $options = array()) 
  {
    $params = [ 'gallery_name' => $gallery_name ];
    $params = $params + $options;
    
    return $this->client->post('gallery/view', [ 'json' => $params ]);   
  }

  /**
   * Removes a gallery and all of its subjects.
   *
   * @param string $gallery_name
   *
   * @return Psr\Http\Message\ResponseInterface
   */
  public function removeGallery($gallery_name) 
  {
    $params = [ 'gallery_name' => $gallery_name ];
    
    return $this->client->post('gallery/remove', [ 'json' => $params ]);      
  }

  /**
   * Removes a face you have enrolled within a gallery.
   *
   * @param string      $subject_id
   * @param string      $gallery_name
   *
   * @return Psr\Http\Message\ResponseInterface
   */
  public function removeSubject($subject_id, $gallery_name)
  {
    $params = [
          'subject_id' => $subject_id,
          'gallery_name' => $gallery_name
    ];
    
    return $this->client->post('gallery/remove_subject', [ 'json' => $params ]);
  }
}

