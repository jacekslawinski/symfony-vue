<?php

namespace Tests;

use Doctrine\ORM\EntityManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Tests\Traits\WithFaker;

abstract class AbstractTestCase extends WebTestCase
{
    use ReloadDatabaseTrait;
    use WithFaker;

    /**
     *
     * @var Application $application
     */
    protected static $application;

    /**
     *
     * @var AbstractBrowser $client
     */
    protected static $client;

    /**
     *
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    protected function setUp(): void
    {
        static::ensureKernelShutdown();
        static::$client = static::createClient();
        static::$application = new Application(static::$client->getKernel());
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->setUpFaker();
    }

    /**
     *
     * @param string $routeUri
     * @param array $data, default: []
     * @return Crawler
     */
    protected function postRequest(string $routeUri, array $data = []): Crawler
    {
        return static::$client->request('POST', $routeUri, $data);
    }

    /**
     *
     * @param string $routeUri
     * @return Crawler
     */
    protected function getRequest(string $routeUri): Crawler
    {
        return static::$client->request('GET', $routeUri);
    }

    /**
     *
     * @param string $routeUri
     * @param array $data, default: []
     * @return Crawler
     */
    protected function patchRequest(string $routeUri, array $data = []): Crawler
    {
        return static::$client->request('PATCH', $routeUri, $data);
    }

    /**
     *
     * @param string $routeUri
     * @param array $data, default: []
     * @return Crawler
     */
    protected function putRequest(string $routeUri, array $data = []): Crawler
    {
        return static::$client->request('PUT', $routeUri, $data);
    }

    /**
     *
     * @param string $routeUri
     * @return Crawler
     */
    protected function deleteRequest(string $routeUri): Crawler
    {
        return static::$client->request('DELETE', $routeUri);
    }

    protected function getResponse()
    {
        return static::$client->getResponse();
    }
}
