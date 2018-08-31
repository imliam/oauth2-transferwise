<?php

namespace League\OAuth2\Client\Test\Provider;

use PHPUnit\Framework\TestCase;
use Mockery as m;

class TransferwiseResourceOwnerTest extends TestCase
{
    public function testUrlIsNullWithoutDomainOrNickname()
    {
        $user = new \ImLiam\OAuth2\Client\Provider\TransferwiseResourceOwner;

        $url = $user->getUrl();

        $this->assertNull($url);
    }

    public function testUrlIsDomainWithoutNickname()
    {
        $domain = uniqid();
        $user = new \ImLiam\OAuth2\Client\Provider\TransferwiseResourceOwner;
        $user->setDomain($domain);

        $url = $user->getUrl();

        $this->assertEquals($domain, $url);
    }

    public function testUrlIsNicknameWithoutDomain()
    {
        $nickname = uniqid();
        $user = new \ImLiam\OAuth2\Client\Provider\TransferwiseResourceOwner(['login' => $nickname]);

        $url = $user->getUrl();

        $this->assertEquals($nickname, $url);
    }
}
