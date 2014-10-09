# RSSWriter

`RSSWriter` is yet another simple RSS writer library for PHP 5.3 or later. This component is Licensed under MIT license.

This library can also be used to publish Podcasts.


Implementation:

```php
<?php
$feed = new Feed();

$channel = new Channel();
$channel
	->title("Channel Title")
	->description("Channel Description")
	->link('http://blog.example.com')
	->appendTo($feed);

// RSS item
$item = new Item();
$item
	->title("Blog Entry Title")
	->description("<div>Blog body</div>")
	->link('http://blog.example.com/2012/08/21/blog-entry/')
	->appendTo($channel);

// Podcast item
$item = new Item();
$item
	->title("Some Podcast Entry")
	->description("<div>Podcast body</div>")
	->link('http://podcast.example.com/2012/08/21/podcast-entry/')
       ->enclosure('http://link-to-audio-file.com/2013/08/21/podcast.mp3', 4889, 'audio/mpeg')
	->appendTo($channel);


echo $feed;
```

Output:

```xml
<?xml version="1.0"?>
<rss version="2.0">
  <channel>
    <title>Channel Title</title>
    <link>http://blog.example.com</link>
    <description>Channel Description</description>
    <item>
      <title>Blog Entry Title</title>
      <link>http://blog.example.com/2012/08/21/blog-entry/</link>
      <description>&lt;div&gt;Blog body&lt;/div&gt;</description>
    </item>
  </channel>
</rss>
```

If you want to know APIs, please see `FeedInterface`, `ChannelInterface` and `ItemInterface`.

## License

MIT license