<?php
namespace Profits4Purpose\GuideStar;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\Mock;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $guideStarApiKey = 'fakeKey0123456789';

    protected function getMockJsonResponse($path)
    {
        $contents = file_get_contents(__DIR__ . '/files/' . $path);
        return new Response(200, [], Stream::factory($contents));
    }

    protected function mockGuzzle(Client $guzzle, array $responses)
    {
        $guzzle->getEmitter()->attach(new Mock($responses));
    }
}
