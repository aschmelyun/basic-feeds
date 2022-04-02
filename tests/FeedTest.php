<?php

namespace Aschmelyun\BasicFeeds\Tests;

use Aschmelyun\BasicFeeds\Feed;

class FeedTest extends TestCase
{
    /**
     * @test
     */
    public function single_entries_can_be_added_to_a_feed()
    {
        $feed = Feed::create([
            'title' => 'Example Person\'s Blog',
            'link' => 'https://example.com/blog',
            'authors' => 'Example Person',
            'feed' => 'https://example.com/feed.xml'
        ]);

        $feed->entry([
            'title' => 'Blog Post One',
            'link' => 'https://example.com/blog/post-one'
        ]);

        $expected = [
            [
                'title' => 'Blog Post One',
                'link' => 'https://example.com/blog/post-one'
            ]
        ];

        $this->assertEquals($expected, $feed->entries);
    }

    /**
     * @test
     */
    public function multiple_entries_can_be_added_to_a_feed()
    {
        $feed = Feed::create([
            'title' => 'Example Person\'s Blog',
            'link' => 'https://example.com/blog',
            'authors' => 'Example Person',
            'feed' => 'https://example.com/feed.xml'
        ]);

        $feed->entry([
            [
                'title' => 'Blog Post One',
                'link' => 'https://example.com/blog/post-one'
            ],
            [
                'title' => 'Blog Post Two',
                'link' => 'https://example.com/blog/post-two'
            ]
        ]);

        $expected = [
            [
                'title' => 'Blog Post One',
                'link' => 'https://example.com/blog/post-one'
            ],
            [
                'title' => 'Blog Post Two',
                'link' => 'https://example.com/blog/post-two'
            ]
        ];

        $this->assertEquals($expected, $feed->entries);
    }

    /**
     * @test
     */
    public function single_and_multiple_entries_can_be_added_to_a_feed()
    {
        $feed = Feed::create([
            'title' => 'Example Person\'s Blog',
            'link' => 'https://example.com/blog',
            'authors' => 'Example Person',
            'feed' => 'https://example.com/feed.xml'
        ]);

        $feed->entry([
            [
                'title' => 'Blog Post One',
                'link' => 'https://example.com/blog/post-one'
            ],
            [
                'title' => 'Blog Post Two',
                'link' => 'https://example.com/blog/post-two'
            ],
            'title' => 'Blog Post Three',
            'link' => 'https://example.com/blog/post-three'
        ]);

        $expected = [
            [
                'title' => 'Blog Post One',
                'link' => 'https://example.com/blog/post-one'
            ],
            [
                'title' => 'Blog Post Two',
                'link' => 'https://example.com/blog/post-two'
            ],
            [
                'title' => 'Blog Post Three',
                'link' => 'https://example.com/blog/post-three'
            ]
        ];

        $this->assertEquals($expected, $feed->entries);
    }
}