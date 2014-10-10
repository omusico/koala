# RSSWriter

`RSSWriter` is yet another simple RSS writer library for PHP 5.3 or later. This component is Licensed under MIT license.

This library can also be used to publish Podcasts.


Implementation:

```php
<?php

header('Content-Type:application/xml; charset=utf-8');

$feed = new \Koala\Helper\RSSWriter\Feed('<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"/>');

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
// $item->clearAttr();
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
	//->comments('http://dallas.example.com/feedback/1983/06/joebob.htm', 20)//will enable ns prefix [slash] !
	->comments('http://dallas.example.com/feedback/1983/06/joebob.htm')
	->pubDate(time())
	->source('Los Angeles Herald-Examiner', 'http://la.example.com/rss.xml')
	->appendTo($channel);

echo $feed;
```

Output:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
  <channel>
    <title>Channel Title</title>
    <link>http://blog.example.com</link>
    <description>Channel Description</description>
    <category domain="http://domain">Media</category>
    <cloud domain="server.example.com" path="/rpc" port="80" protocol="xml-rpc" registerProcedure="cloud.notify"/>
    <atom:link href="http://dallas.example.com/rss.xml" rel="slef" type="application/rss+xml"/>
    <docs>http://www.rssboard.org/rss-specification</docs>
    <generator>Microsoft Spaces v1.1</generator>
    <managingEditor>luksa@dallas.example.com (Frank Luksa)</managingEditor>
    <rating>(PICS-1.1 "http://www.rsac.org/ratingsv01.html" l by "webmaster@example.com" on "2007.01.29T10:09-0800" r (n 0 s 0 v 0 l 0))</rating>
    <webMaster>helpdesk@dallas.example.com</webMaster>
    <language>epo</language>
    <copyright>Copyright 2007 Dallas Times-Herald</copyright>
    <pubDate>Thu, 09 Oct 2014 21:52:43 +0800</pubDate>
    <lastBuildDate>Thu, 09 Oct 2014 21:52:43 +0800</lastBuildDate>
    <ttl>3600</ttl>
    <skipDays>
      <day>Saturday</day>
      <day>Sunday</day>
    </skipDays>
    <skipHours>
      <hour>0</hour>
      <hour>1</hour>
      <hour>2</hour>
      <hour>22</hour>
      <hour>23</hour>
    </skipHours>
    <textInput>
      <description>Your aggregator supports the textInput element. What software are you using?</description>
      <link>http://www.cadenhead.org/textinput.php</link>
      <name>query</name>
      <title>TextInput Inquiry</title>
    </textInput>
    <image>
      <title>Dallas Times-Herald</title>
      <link>http://dallas.example.com</link>
      <description>Read the Dallas Times-Herald</description>
      <url>http://dallas.example.com/masthead.gif</url>
      <width>32</width>
      <height>96</height>
    </image>
    <item>
      <title>Blog Entry Title</title>
      <link>http://blog.example.com/2012/08/21/blog-entry/</link>
      <description>&lt;div&gt;Blog body&lt;/div&gt;</description>
      <atom:link href="http://dallas.example.com/rss.xml" rel="slef" type="application/rss+xml"/>
    </item>
    <item>
      <title>Some Podcast Entry</title>
      <link>http://podcast.example.com/2012/08/21/podcast-entry/</link>
      <description>&lt;div&gt;Podcast body&lt;/div&gt;</description>
      <category domain="http://domain">news</category>
      <source url="http://la.example.com/rss.xml">Los Angeles Herald-Examiner</source>
      <guid isPermaLink="true">http://dallas.example.com/1983/05/06/joebob.htm</guid>
      <atom:link href="http://dallas.example.com/rss.xml" rel="slef" type="application/rss+xml"/>
      <pubDate>Thu, 09 Oct 2014 21:52:43 +0800</pubDate>
      <comments>http://dallas.example.com/feedback/1983/06/joebob.htm</comments>
      <slash:comments>20</slash:comments>
      <enclosure url="http://link-to-audio-file.com/2013/08/21/podcast.mp3" type="audio/mpeg" length="4889"/>
      <author>jbb@dallas.example.com (Joe Bob Briggs)</author>
    </item>
  </channel>
</rss>
```

If you want to know APIs, please see `FeedInterface`, `ChannelInterface` and `ItemInterface`.

## License

MIT license