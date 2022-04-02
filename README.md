# Basic Feeds

This package provides a basic way of generating RSS 2 and Atom XML feeds in PHP using a simplified syntax. There are no external dependencies as this package relies on the built-in [SimpleXMLElement](https://www.php.net/manual/en/class.simplexmlelement.php) class.

## Installation

```bash
composer require aschmelyun/basic-feeds
```

## Usage

Initialize a feed by using the `Feed::create()` method, passing in an array of attributes needed to set up your feed's base.

```php
use Aschmelyun\BasicFeeds\Feed;

$feed = Feed::create([
    'link' => 'https://example.com/blog',
    'authors' => 'Andrew Schmelyun',
    'title' => 'My Example Blog',
    'feed' => 'https://example.com/feed.xml',
]);
```

Then use the `entry()` method on the Feed object to attach entries to your feed.

```php
$feed->entry([
    'title' => 'Post One',
    'link' => 'https://example.com/blog/post-one',
    'summary' => 'This is my summary',
    'content' => '<p>This is my example content!</p>'
]);
```

The `entry()` method can also expect multiple items at once, using a nested array.

```php
$feed->entry([
        'title' => 'Post Two',
        'link' => 'https://example.com/blog/post-two',
        'summary' => 'This is my second summary',
        'content' => '<p>This is my second example content!</p>'
    ], [
        'title' => 'Post Three',
        'link' => 'https://example.com/blog/post-three',
        'summary' => 'This is my third summary',
        'content' => '<p>This is my third example content!</p>'
    ]);
```

You can then use either the `asAtom()` or `asRss()` method to compile the feed to the requested format and return it as an XML string:

```php
$xml = $feed->asAtom(); // $feed->asRss();
```

## Requirements

There are a few required attributes, and they change based on the format(s) you choose.

For `Feed::create()` they are:

- **RSS**: `title`, `link`, `description`
- **Atom**: `title`, `link`, `authors`, `feed`

For `entry()` they are:

- **RSS**: `title`, `link`, `description`
- **Atom**: `title`, `link`, `summary`, `content`

## Extending

This package comes with an [interface](https://github.com/aschmelyun/basic-feeds/blob/main/src/Contracts/Generator.php) that you can use to help extend off of this package to create your own feed generator.

Check out the [Atom](https://github.com/aschmelyun/basic-feeds/blob/main/src/Generators/Atom.php) and [RSS](https://github.com/aschmelyun/basic-feeds/blob/main/src/Generators/Rss.php) classes to see how the included feed generators are structured.

## Testing

If you don't already have PHPUnit required in your current project, install this package with dev dependencies:

```bash
composer require aschmelyun/basic-feeds --dev
```

Then run the PHPUnit tests:

```bash
./vendor/bin/phpunit
```

## License

This package is licensed under the The MIT License. See [LICENSE](https://github.com/aschmelyun/basic-feeds/blob/main/LICENSE) for more details.