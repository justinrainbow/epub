# ePub Reader

## Usage

```php
<?php

$reader = new \ePub\Reader();
$epub = $reader->load('my-book.epub');

printf("Title: %s\n", $epub->getMetadata()->get('title'));
```


## Resources

 * http://www.hxa.name/articles/content/epub-guide_hxa7241_2007.html
