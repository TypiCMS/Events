<?php

use TypiCMS\Modules\Events\Models\Event;

class EventsControllerTest extends TestCase
{
    public function testAdminIndex()
    {
        $response = $this->call('GET', 'admin/events');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreFails()
    {
        $input = [];
        $this->call('POST', 'admin/events', $input);
        $this->assertRedirectedToRoute('admin.events.create');
        $this->assertSessionHasErrors();
    }

    public function testStoreSuccess()
    {
        $object = new Event();
        $object->id = 1;
        Event::shouldReceive('create')->once()->andReturn($object);
        $input = ['start_date' => '2014-03-10', 'end_date' => '2014-03-10'];
        $this->call('POST', 'admin/events', $input);
        $this->assertRedirectedToRoute('admin.events.edit', ['id' => 1]);
    }

    public function testStoreSuccessWithRedirectToList()
    {
        $object = new Event();
        $object->id = 1;
        Event::shouldReceive('create')->once()->andReturn($object);
        $input = ['start_date' => '2014-03-10', 'end_date' => '2014-03-10', 'exit' => true];
        $this->call('POST', 'admin/events', $input);
        $this->assertRedirectedToRoute('admin.events.index');
    }
}
