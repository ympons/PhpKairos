<?php

namespace PhpKairos\Test;

use PhpKairos\PhpKairos;

class PhpKairosTest extends \PHPUnit_Framework_TestCase 
{
  const API_HOST = 'http://api.kairos.com/';
  const APP_ID   = 'e2a8eaa7';
  const APP_KEY  = '4092e4a45070bca728644e9285f084b4';

  public function testEnroll()
  {
    $client = $this->createClient();
    
    $image        = 'http://media.kairos.com/kairos-elizabeth.jpg';
    $subject_id   = 'subject1';
    $gallery_name = 'gallerytest1';
    $options      = [
      'selector' => 'SETPOSE',
      'symmetricFill' => true
    ];
    
    $response = $client->enroll($image, $subject_id, $gallery_name, $options);
    
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotEmpty($response->getBody()->getContents());
  }
  
  public function testRecognize()
  {
    $client = $this->createClient();
    
    $image        = 'http://media.kairos.com/kairos-elizabeth.jpg';
    $gallery_name = 'gallerytest1';
    
    $response = $client->recognize($image, $gallery_name);
    
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotEmpty($response->getBody()->getContents());
  }
  
  public function testDetect()
  {
    $client = $this->createClient();
    
    $image = 'http://media.kairos.com/kairos-elizabeth.jpg';
    
    $response = $client->detect($image);
    
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotEmpty($response->getBody()->getContents());
  }
  
  public function testListGalleries()
  {
    $client = $this->createClient();
    
    $response = $client->listGalleries();
    
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotEmpty($response->getBody()->getContents());
  }
  
  public function testViewGallery()
  {
    $client = $this->createClient();
    
    $gallery_name = 'gallerytest1';
    
    $response = $client->viewGallery($gallery_name);
    
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotEmpty($response->getBody()->getContents());
  }

  public function testRemoveSubject()
  {
    $client = $this->createClient();
    
    $subject_id   = 'subject1';
    $gallery_name = 'gallerytest1';
    
    $response = $client->removeSubject($subject_id, $gallery_name);
    
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotEmpty($response->getBody()->getContents());  
  }

  public function testRemoveGallery()
  {
    $client = $this->createClient();
    
    $gallery_name = 'gallerytest1';
    
    $response = $client->removeGallery($gallery_name);
    
    $this->assertEquals(200, $response->getStatusCode());
    $this->assertNotEmpty($response->getBody()->getContents());
  }

  private function createClient() 
  {
    return new PhpKairos(self::API_HOST, self::APP_ID, self::APP_KEY);
  }
}
