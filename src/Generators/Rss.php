<?php

namespace Aschmelyun\BasicFeeds\Generators;

use Aschmelyun\BasicFeeds\Feed;
use Aschmelyun\BasicFeeds\Contracts\Generator;
use Aschmelyun\BasicFeeds\Exceptions\MissingRequiredAttributesException;

class Rss implements Generator
{
    public $feed;

    public $xml;

    protected $requiredBaseAttributes = [
        'title',
        'link',
        'description',
    ];

    protected $requiredEntryAttributes = [
        'title',
        'link',
        'description',
    ];

    public function __construct(Feed $feed)
    {
        $this->feed = $feed;
    }

    public static function generate(Feed $feed): string
    {
        $generator = new self($feed);

        return $generator->init()
            ->addBase()
            ->addEntries()
            ->asXml();
    }

    public function init(): self
    {
        $this->xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><rss version="2.0"></rss>');

        return $this;
    }

    public function addBase(): self
    {
        $attributes = $this->feed->attributes;

        foreach($this->requiredBaseAttributes as $required) {
            if (!isset($attributes[$required])) {
                throw new MissingRequiredAttributesException("You must include the base attribute: {$required}");
            }
        }

        $channel = $this->xml->addChild('channel');

        foreach($attributes as $element => $value) {
            $channel->addChild($element, $value);
        }

        return $this;
    }

    public function addEntries(): self
    {
        foreach($this->feed->entries as $attributes) {
            foreach($this->requiredBaseAttributes as $required) {
                if (!isset($attributes[$required])) {
                    throw new MissingRequiredAttributesException("You must include the entry attribute: {$required}");
                }
            }
    
            $entry = $this->xml->channel->addChild('item');

            foreach($attributes as $element => $value) {
                $entry->addChild($element, $value);
            }
        }

        return $this;
    }

    public function asXml(): string
    {
        return $this->xml->asXML();
    }
}