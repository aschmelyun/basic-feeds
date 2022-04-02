<?php

namespace Aschmelyun\BasicFeeds\Tests\Generators;

use Aschmelyun\BasicFeeds\Feed;
use Aschmelyun\BasicFeeds\Exceptions\MissingRequiredAttributesException;
use Aschmelyun\BasicFeeds\Tests\TestCase;

class RssTest extends TestCase
{
    /**
     * @test
     */
    public function initializing_an_empty_rss_feed_throws_an_exception()
    {
        $this->expectException(MissingRequiredAttributesException::class);
        $this->expectExceptionMessage('You must include the base attribute: title');

        $feed = Feed::create([])
            ->asRss();
    }

    /**
     * @test
     */
    public function initializing_an_rss_feed_with_a_missing_required_attribute_throws_an_exception()
    {
        $this->expectException(MissingRequiredAttributesException::class);
        $this->expectExceptionMessage('You must include the base attribute: description');

        $feed = Feed::create([
            'title' => 'Example Feed',
            'link' => 'https://example.com',
        ])
            ->asRss();
    }

    /**
     * @test
     */
    public function can_initialize_an_rss_feed_with_no_entries()
    {
        $feed = Feed::create([
            'title' => 'Example Feed',
            'link' => 'https://example.com',
            'description' => 'Example Feed'
        ])
            ->asRss();

        $this->assertStringContainsString('Example Feed', $feed);
    }

    /**
     * @test
     */
    public function can_initialize_an_rss_feed_with_entries()
    {
        $feed = Feed::create([
            'title' => 'Example Feed',
            'link' => 'https://example.com',
            'description' => 'Example Feed',
        ])
            ->entry([
                'title' => 'Example Entry',
                'link' => 'https://example.com/example-entry',
                'description' => 'Example Entry',
            ])
            ->asRss();

        $this->assertStringContainsString('Example Entry', $feed);
    }
}