<?php

use Profits4Purpose\GuideStar\AdvancedSearch;
use Profits4Purpose\GuideStar\TestCase;

class AdvancedSearchTest extends TestCase
{
    public function testCanDoAdvancedKeywordSearch()
    {
        $api = new AdvancedSearch(getenv('ADVANCED_SEARCH_API_KEY'));
        if (!getenv('ADVANCED_SEARCH_API_KEY')) {
            $this->mockGuzzle($api->getHttpClient(), [$this->getMockJsonResponse('search.json')]);
        }

        $result = $api->search('london');
        $this->assertEquals(10, count($result->hits));
    }

}
