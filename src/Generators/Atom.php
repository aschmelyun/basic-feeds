<?php

namespace Aschmelyun\BasicFeeds\Generators;

use Aschmelyun\BasicFeeds\Feed;
use Aschmelyun\BasicFeeds\Contracts\Generator;
use Aschmelyun\BasicFeeds\Exceptions\MissingRequiredAttributesException;

class Atom implements Generator
{
    public $feed;

    public $xml;

    protected $requiredBaseAttributes = [
        'title',
        'link',
        'authors',
        'feed',
    ];

    protected $requiredEntryAttributes = [
        'title',
        'link',
        'summary',
        'content',
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
            ->asXML();
    }

    public function init(): self
    {
        $this->xml = new \SimpleXMLElement(
            '<?xml version="1.0" encoding="utf-8"?>
            <feed xmlns="http://www.w3.org/2005/Atom" xmlns:content="http://purl.org/rss/1.0/modules/content/"></feed>'
        );

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

        if (!isset($attributes['id'])) {
            $attributes['id'] = $attributes['link'];
        }

        if (!isset($attributes['updated'])) {
            $attributes['updated'] = date('c');
        }

        $link = $this->xml->addChild('link');
        $link->addAttribute('href', $attributes['link']);

        $atomLink = $this->xml->addChild('atom:link');
        $atomLink->addAttribute('href', $attributes['feed']);
        $atomLink->addAttribute('rel', 'self');
        $atomLink->addAttribute('type', 'application/rss+xml');

        $authors = $this->xml->addChild('author');
        $authors->addChild('name', $attributes['authors']);

        unset(
            $attributes['link'],
            $attributes['feed'],
            $attributes['authors']
        );

        foreach($attributes as $element => $value) {
            $this->xml->addChild($element, $value);
        }

        return $this;
    }

    public function addEntries(): self
    {
        foreach($this->feed->entries as $attributes) {

            foreach($this->requiredEntryAttributes as $required) {
                if (!isset($attributes[$required])) {
                    throw new MissingRequiredAttributesException("You must include the entry attribute: {$required}");
                }
            }

            if (!isset($attributes['id'])) {
                $attributes['id'] = $attributes['link'];
            }

            if (!isset($attributes['updated'])) {
                $attributes['updated'] = date('c');
            }
    
            $entry = $this->xml->addChild('entry');
    
            $link = $entry->addChild('link');
            $link->addAttribute('href', $attributes['link']);
            $link->addAttribute('rel', 'alternate');
    
            $content = $entry->addChild('content', $attributes['content']);
            $content->addAttribute('type', 'html');

            $node = dom_import_simplexml($content);
            $nodeOwnerDocument = $node->ownerDocument;
            $node->appendChild($nodeOwnerDocument->createCDATASection($attributes['content']));

            unset(
                $attributes['link'],
                $attributes['content']
            );

            foreach($attributes as $element => $value) {
                $entry->addChild($element, $value);
            }
        }

        return $this;
    }

    public function asXML(): string
    {
        return $this->xml->asXML();
    }
}