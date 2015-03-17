<?php

use Profits4Purpose\GuideStar\AdvancedSearch;
use Profits4Purpose\GuideStar\TestCase;

class SearchTest extends TestCase
{
    public function testCanDoBasicKeywordSearch()
    {
        $api = new AdvancedSearch(getenv('ADVANCED_SEARCH_API_KEY'));
        if (!getenv('ADVANCED_SEARCH_API_KEY')) {
            $this->mockGuzzle($api->getHttpClient(), [$this->getMockJsonResponse('search.json')]);
        }

        $result = $api->search('london');
        $this->assertObjectHasAttribute('hits', $result);
        $this->assertEquals(10, count($result->hits));
    }

    public function testCanLookupByEin()
    {
        $api = new AdvancedSearch(getenv('ADVANCED_SEARCH_API_KEY'));
        if (!getenv('ADVANCED_SEARCH_API_KEY')) {
            $this->mockGuzzle($api->getHttpClient(), [$this->getMockJsonResponse('ein-lookup.json')]);
        }

        $result = $api->lookupEin('13-5661935');
        $this->assertObjectHasAttribute('organization_name', $result);
    }

    public function testCanGetCount()
    {
        $api = new AdvancedSearch(getenv('ADVANCED_SEARCH_API_KEY'));
        if (!getenv('ADVANCED_SEARCH_API_KEY')) {
            $this->mockGuzzle($api->getHttpClient(), [$this->getMockJsonResponse('search-count.json')]);
        }

        $count = $api->count('london');
        $this->assertGreaterThan(0, $count);
    }

}
