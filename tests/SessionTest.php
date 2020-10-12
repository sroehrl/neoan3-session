<?php

namespace Neoan3\Apps;

use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        new Session();
    }
    function testLogin()
    {

        Session::login('abc');
        $this->assertTrue(Session::isLoggedIn());
        $this->assertSame('abc', Session::userId());
    }
    function testRestrict()
    {
        Session::login('abc',['read']);
        $works = Session::restrict(['read']);
        $this->assertSame('abc', $works['logged_id']);
    }
    function testRestrictFails()
    {
        $this->expectException(\Exception::class);
        Session::login('abc',['read']);
        Session::restrict(['write']);
    }
    function testScopeCheck()
    {
        Session::login('abc',['read']);
        $this->assertTrue(Session::scopeCheck('read'));
    }
    function testLogout()
    {
        Session::login('abc',['read']);
        Session::logout();
        $this->assertFalse(Session::isLoggedIn());
    }
    function testTimeout()
    {
        Session::login('abc',['read']);
        Session::addToSession(['expires'=> time() - 3]);
        new Session();
        $this->assertFalse(Session::isLoggedIn());
    }

}
