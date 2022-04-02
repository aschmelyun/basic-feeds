<?php

namespace Aschmelyun\BasicFeeds;

use Aschmelyun\BasicFeeds\Generators\Atom;
use Aschmelyun\BasicFeeds\Generators\Rss;
use Aschmelyun\BasicFeeds\Exceptions\MissingRequiredAttributesException;

class Feed
{
    public $attributes;

    public $entries = [];

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public static function create(array $attributes): Feed
    {
        return new Feed($attributes);
    }

    public function entry(array $attributes): Feed
    {
        // this handles nested arrays of attributes being passed into this method
        foreach($attributes as $index => $attribute) {
            if (is_array($attribute)) {
                $this->entries[] = $attribute;

                unset($attributes[$index]);
                continue;
            }
        }

        // if the entire $attributes array was nested arrays, it should be empty and we can continue
        if (empty($attributes)) {
            return $this;
        }

        // this handles if a single array of attributes was passed in to this method
        $this->entries[] = $attributes;

        return $this;
    }

    public function asAtom(): string
    {
        return Atom::generate($this);
    }

    public function asRss(): string
    {
        return Rss::generate($this);
    }
}