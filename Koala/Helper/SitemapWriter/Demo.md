
```php
<?php
header('Content-Type:application/xml; charset=utf-8');
$feed = new \Koala\Helper\SitemapWriter\Sitemap();
$item = new \Koala\Helper\SitemapWriter\Item();
$item
  ->loc('http://www.example1.com')
  ->lastmod(date('Y-m-d', time()))
  ->changefreq('always')
  ->priority('1.0')
  ->appendTo($feed);
$item=clone $item;
$item->clearAttr();
$item
  ->loc('http://www.example1.com')
  ->lastmod(date('Y-m-d', time()))
  ->changefreq('always')
  ->priority('1.0')
  ->appendTo($feed);
echo $feed
```

Output:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset>
  <url>
    <loc>http://www.example1.com</loc>
    <lastmod>2014-10-10</lastmod>
    <changefreq>always</changefreq>
    <priority>1.0</priority>
  </url>
  <url>
    <loc>http://www.example1.com</loc>
    <lastmod>2014-10-10</lastmod>
    <changefreq>always</changefreq>
    <priority>1.0</priority>
  </url>
</urlset>
```