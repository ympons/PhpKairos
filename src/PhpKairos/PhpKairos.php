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
   * @param string $hostname  The Kairos url.
   * @param string $app_id    The server port.
   * @param string $app_key   An old connection Token to reuse,
   */
  public function __construct( $url = '', $app_id = '', $app_key = '' )
  { 
    $options['base_uri'] = $url;
    $options['defaults']['headers']['app_id'] = $app_id;
    $options['defaults']['headers']['app_key'] = $app_key;
    
    self::resolveOptions($options);
    
    // Initialize the client
    $this->client = new GuzzleHttp\Client($options);
  }
  
  private static function resolveOptions(array &$options)
  {
    $options['defaults']['headers']['User-Agent'] = isset($options['defaults']['headers']['User-Agent']) ? $options['defaults']['headers']['User-Agent'] : 'PhpKairos/1.0';
    $options['defaults']['headers']['Accept'] = isset($options['defaults']['headers']['Accept']) ? $options['defaults']['headers']['Accept'] : 'application/json';
    $options['defaults']['headers']['Content-Type'] = isset($options['defaults']['headers']['Content-Type']) ? $options['defaults']['headers']['Content-Type'] : 'application/json';
  }
  
  /**
   * Takes a photo, finds the faces within it, and stores the faces into a gallery you create.
   *
   * @param uri|base64  $image
   * @param string      $subject_id
   * @param string      $gallery_name
   *
   * @return mixed
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
   *
   * @return mixed
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
   *
   * @return mixed
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
   * @return mixed
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
   * @return mixed
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
   * @return mixed
   */
  public function removeGallery($gallery_name, array $options = array()) 
  {
    $params = [ 'gallery_name' => $gallery_name ];
    $params = $params + $options;
    
    return $this->client->post('gallery/remove', [ 'json' => $params ]);      
  }
   
  /**
   * Removes a face you have enrolled within a gallery.
   *
   * @param string      $subject_id
   * @param string      $gallery_name
   *
   * @return mixed
   */
  public function removeSubject($subject_id, $gallery_name, array $options = array()) 
  {
    $params = [
          'subject_id' => $subject_id,
          'gallery_name' => $gallery_name
    ];
    $params = $params + $options;
    
    return $this->client->post('gallery/remove_subject', [ 'json' => $params ]);   
  }
}

