
```php
<?php
header('Content-Type:application/xml; charset=utf-8');
$feed = new \Koala\Helper\OpenNewsWriter\OpenNews();
$feed
  ->webSite('http://www.baidu.com')
  ->webMaster('example@domain.com')
  ->updatePeri('100');

$item = new \Koala\Helper\OpenNewsWriter\Item();
$item
  ->title('互联网新闻开放协议')
  ->link('http://www.baike.com/wiki/互联网新闻开放协议')
  ->description('互联网新闻开放协议')
  ->text('互联网新闻开放协议是百度新闻搜索制定的搜索引擎新闻源收录标准，网站可将发布的新闻内容制作成遵循此开放协议的XML格式的网页（独立于原有的新闻发布形式）供搜索引擎索引，将网站发布的新闻信息主动、及时地告知百度搜索引擎。')
  ->image('http://a3.att.hudong.com/63/60/01000000000000119086078322763_s.jpg')
  ->headlineImg('')
  ->keywords('互联网新闻 开放协议')
  ->category('开放协议')
  ->author('baike')
  ->source('baike')
  ->pubDate(time())
  ->appendTo($feed);
$item = clone $item;
$item->clearAttr();
//more ...
echo $feed;
```

Output:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<document>
  <webSite>http://www.baidu.com</webSite>
  <webMaster>example@domain.com</webMaster>
  <updatePeri>100</updatePeri>
  <item>
    <title>互联网新闻开放协议</title>
    <link>http://www.baike.com/wiki/互联网新闻开放协议</link>
    <description>互联网新闻开放协议</description>
    <text>互联网新闻开放协议是百度新闻搜索制定的搜索引擎新闻源收录标准，网站可将发布的新闻内容制作成遵循此开放协议的XML格式的网页（独立于原有的新闻发布形式）供搜索引擎索引，将网站发布的新闻信息主动、及时地告知百度搜索引擎。</text>
    <category>开放协议</category>
    <source>baike</source>
    <keywords>互联网新闻 开放协议</keywords>
    <image>http://a3.att.hudong.com/63/60/01000000000000119086078322763_s.jpg</image>
    <headlineImg/>
    <pubDate>Fri, 10 Oct 2014 14:26:09 +0800</pubDate>
    <author>baike</author>
  </item>
</document>
```