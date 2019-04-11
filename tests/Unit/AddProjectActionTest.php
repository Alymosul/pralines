<?php

namespace Tests\Unit;

use App\Actions\AddProjectAction;
use Tests\TestCase;

class AddProjectActionTest extends TestCase
{
    /** @test */
    function it_retrieves_the_given_name()
    {
        $action = new AddProjectAction('dummy', '101');

        $this->assertEquals('dummy', $action->getName());
    }

    /** @test */
    function it_retrieves_the_given_client_id()
    {
        $action = new AddProjectAction('dummy', '101');

        $this->assertEquals('101', $action->getClientId());
    }
}
