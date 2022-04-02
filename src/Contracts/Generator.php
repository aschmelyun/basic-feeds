<?php

namespace Aschmelyun\BasicFeeds\Contracts;

use Aschmelyun\BasicFeeds\Feed;

interface Generator
{
    /**
     * Initializes the class and performs generation of the feed, returns compiled XML
     *
     * @param Feed $feed
     * @return string
     */
    public static function generate(Feed $feed): string;

    /**
     * Initializes the $xml attribute with a new SimpleXMLElement class
     *
     * @return self
     */
    public function init(): self;

    /**
     * Adds the base elements for a particular feed
     *
     * @return self
     */
    public function addBase(): self;

    /**
     * Adds each of the entry elements, in a loop based on $feed->entries, for a particular feed
     *
     * @return self
     */
    public function addEntries(): self;

    /**
     * Returns back the compiled XML using SimpleXMLElement's asXML() method
     *
     * @return string
     */
    public function asXml(): string;
}