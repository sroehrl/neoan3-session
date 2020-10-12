<?php

namespace Neoan3\Apps;

use Neoan3\Apps\SessionOOP;
use PHPUnit\Framework\TestCase;

class SessionOOPTest extends TestCase
{

    public function testValidate()
    {
        $c = new SessionOOP();
        $this->expectException(\Exception::class);
        $c->validate();
    }

    public function testSetSecret()
    {
        $c = new SessionOOP();
        $c->logout();
        $c->setSecret('pre-');
        $c->assign('abc',['read']);
        $this->assertSame('abc', $c->validate()->getUserId());
    }


    public function testAssign()
    {
        $c = new SessionOOP();
        $c->setSecret('pre-');
        $c->assign('abc', ['read'],['and'=>'some']);
        $this->assertSame('abc', $c->validate()->getUserId());
        $this->assertSame('some', $c->validate()->getPayload()['and']);
    }
    public function testRestrictFail()
    {
        $c = new SessionOOP();
        $c->setSecret('pre-');
        $c->assign('abc', ['read']);
        $this->expectException(\Exception::class);
        $c->restrict('write');
    }
    public function testRestrict()
    {
        $c = new SessionOOP();
        $c->setSecret('pre-');
        $c->assign('abc', ['read']);
        $valid = $c->restrict('read');
        $this->assertSame('abc', $valid->getUserId());
    }
}
