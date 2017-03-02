<?php namespace App\Tests\Models;

use AppBundle\Models\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    /**
     * Post Model Tests
     * @test
     */
    public function testUser()
    {
        $post = new Post();

        $post->setBody('This is a post');
        $this->assertEquals($post->getBody(), 'This is a post');

        $date = new \DateTime();

        $post->setCreatedAt($date);
        $this->assertEquals($post->getcreatedAt(), $date);

        $post->setUpdatedAt($date);
        $this->assertEquals($post->getUpdatedAt(), $date);
    }

}