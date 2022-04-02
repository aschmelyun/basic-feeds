<?php

namespace Aschmelyun\BasicFeeds\Tests\Generators;

use Aschmelyun\BasicFeeds\Feed;
use Aschmelyun\BasicFeeds\Exceptions\MissingRequiredAttributesException;
use Aschmelyun\BasicFeeds\Tests\TestCase;

class AtomTest extends TestCase
{
    /**
     * @test
     */
    public function initializing_an_empty_atom_feed_throws_an_exception()
    {
        $this->expectException(MissingRequiredAttributesException::class);
        $this->expectExceptionMessage('You must include the base attribute: title');

        $feed = Feed::create([])
            ->asAtom();
    }

    /**
     * @test
     */
    public function initializing_an_atom_feed_with_a_missing_required_attribute_throws_an_exception()
    {
        $this->expectException(MissingRequiredAttributesException::class);
        $this->expectExceptionMessage('You must include the base attribute: feed');

        $feed = Feed::create([
            'title' => 'Example Feed',
            'link' => 'https://example.com',
            'authors' => 'Example Name',
        ])
            ->asAtom();
    }

    /**
     * @test
     */
    public function can_initialize_an_atom_feed_with_no_entries()
    {
        $feed = Feed::create([
            'title' => 'Example Feed',
            'link' => 'https://example.com',
            'authors' => 'Example Name',
            'feed' => 'https://example.com/feed.xml',
        ])
            ->asAtom();

        $this->assertStringContainsString('Example Feed', $feed);
    }

    /**
     * @test
     */
    public function can_initialize_an_atom_feed_with_entries()
    {
        $feed = Feed::create([
            'title' => 'Example Feed',
            'link' => 'https://example.com',
            'authors' => 'Example Name',
            'feed' => 'https://example.com/feed.xml',
        ])
            ->entry([
                'title' => 'Example Entry',
                'link' => 'https://example.com/example-entry',
                'summary' => 'Example Entry',
                'content' => 'Example Entry',
            ])
            ->asAtom();

        $this->assertStringContainsString('Example Entry', $feed);
    }

    /**
     * @test
     */
    public function can_initialize_an_atom_feed_with_a_specified_updated_date()
    {
        $feed = Feed::create([
            'title' => 'Example Feed',
            'link' => 'https://example.com',
            'authors' => 'Example Name',
            'feed' => 'https://example.com/feed.xml',
            'updated' => date('c', strtotime('01-01-2022'))
        ])
            ->entry([
                'title' => 'Example Entry',
                'link' => 'https://example.com/example-entry',
                'summary' => 'Example Entry',
                'content' => 'Example Entry',
            ])
            ->asAtom();

        $this->assertStringContainsString('2022-01-01', $feed);
    }
}