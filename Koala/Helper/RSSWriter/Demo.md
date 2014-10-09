# RSSWriter

`RSSWriter` is yet another simple RSS writer library for PHP 5.3 or later. This component is Licensed under MIT license.

This library can also be used to publish Podcasts.


Implementation:

```php
<?php
$feed = new \Koala\Helper\RSSWriter\Feed();

$channel = new \Koala\Helper\RSSWriter\Channel();
$channel
	->atomlink(array('href' => 'http://dallas.example.com/rss.xml', 'rel' => 'slef', 'type' => 'application/rss+xml'))
	->title("Channel Title")
	->description("Channel Description")
	->link('http://blog.example.com')
	->managingEditor('luksa@dallas.example.com (Frank Luksa)')
	->category('Media', 'domain')
	->cloud(array('domain' => 'server.example.com', 'path' => '/rpc', 'port' => 80, 'protocol' => 'xml-rpc', 'registerProcedure' => 'cloud.notify'))
	->copyright('Copyright 2007 Dallas Times-Herald')
	->docs('http://www.rssboard.org/rss-specification')
	->generator('Microsoft Spaces v1.1')
	->language('epo')
	->rating('(PICS-1.1 "http://www.rsac.org/ratingsv01.html" l by "webmaster@example.com" on "2007.01.29T10:09-0800" r (n 0 s 0 v 0 l 0))')
	->webMaster('helpdesk@dallas.example.com')
	->lastBuildDate(time())
	->pubDate(time())
	->ttl(3600)
	->skipDays(array('Saturday', 'Sunday'))
	->skipHours(array(0, 1, 2, 22, 23))
	->textInput(array('description' => 'Your aggregator supports the textInput element. What software are you using?', 'link' => 'http://www.cadenhead.org/textinput.php', 'name' => 'query', 'title' => 'TextInput Inquiry'))
	->appendTo($feed);
// RSS image
$image = new \Koala\Helper\RSSWriter\Image();
$image
	->title("Dallas Times-Herald")
	->description("Read the Dallas Times-Herald")
	->link('http://dallas.example.com')
	->url('http://dallas.example.com/masthead.gif')
	->width(32)
	->height(96)
	->appendTo($channel);
// RSS item
$item = new \Koala\Helper\RSSWriter\Item();
$item
	->atomlink(array('href' => 'http://dallas.example.com/rss.xml', 'rel' => 'slef', 'type' => 'application/rss+xml'))
	->title("Blog Entry Title")
	->description("<div>Blog body</div>")
	->link('http://blog.example.com/2012/08/21/blog-entry/')
	->appendTo($channel);

// Podcast item
$item = new \Koala\Helper\RSSWriter\Item();
$item
	->atomlink(array('href' => 'http://dallas.example.com/rss.xml', 'rel' => 'slef', 'type' => 'application/rss+xml'))
	->title("Some Podcast Entry")
	->description("<div>Podcast body</div>")
	->link('http://podcast.example.com/2012/08/21/podcast-entry/')
	->category('news', 'http://domain')
	->guid('http://dallas.example.com/1983/05/06/joebob.htm', 'false')
	->enclosure('http://link-to-audio-file.com/2013/08/21/podcast.mp3', 4889, 'audio/mpeg')
	->author('jbb@dallas.example.com (Joe Bob Briggs)')
	->comments('http://dallas.example.com/feedback/1983/06/joebob.htm', 20)
	->pubDate(time())
	->source('Los Angeles Herald-Examiner', 'http://la.example.com/rss.xml')
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