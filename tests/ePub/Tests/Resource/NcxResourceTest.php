<?php

namespace ePub\Tests\Resource;

use ePub\Tests\BaseTest;

class NcxResourceTest extends BaseTest
{
    public function testExtractingChaptersFromNcx()
    {
        $epub = $this->getFixtureEpub('the_velveteen_rabbit.epub');
        
        $this->assertCount(5, $epub->navigation->chapters);
        $this->assertEquals("List of Illustrations", $epub->navigation->chapters[2]->title);
    }
    
}