<?php

use godforhire\Toast\ToastNotifier;
use PHPUnit\Framework\TestCase;

class ToastTest extends TestCase
{
    protected $session;

    protected $toast;

    public function setUp()
    {
        $this->session = Mockery::spy('godforhire\Toast\SessionStore');

        $this->toast = new ToastNotifier($this->session);
    }

    /** @test */
    function it_can_interact_with_a_message_as_an_array()
    {
        $this->toast->message('Welcome Aboard', 'one', 'two');

        $this->assertEquals('Welcome Aboard', $this->toast->messages[0]['message']);

    }

    /** @test */
    public function it_displays_default_toast_notifications()
    {
        $this->toast->message('Welcome Aboard');

        $this->assertCount(1, $this->toast->messages);

        $message = $this->toast->messages[0];

        $this->assertEquals('', $message->title);
        $this->assertEquals('Welcome Aboard', $message->message);
        $this->assertEquals('info', $message->level);
        $this->assertEquals(false, $message->important);
        $this->assertEquals(false, $message->overlay);

        $this->assertSessionIsToasted();
    }

    /** @test */
    public function it_displays_multiple_toast_notifications()
    {
        $this->toast->message('Welcome Aboard');
        $this->toast->message('Welcome Aboard Again');

        $this->assertCount(2, $this->toast->messages);

        $this->assertSessionIsToasted(2);
    }

    /** @test */
    function it_displays_success_toast_notifications()
    {
        $this->toast->message('Welcome Aboard')->success();

        $message = $this->toast->messages[0];

        $this->assertEquals('', $message->title);
        $this->assertEquals('Welcome Aboard', $message->message);
        $this->assertEquals('success', $message->level);
        $this->assertEquals(false, $message->important);
        $this->assertEquals(false, $message->overlay);

        $this->assertSessionIsToasted();
    }

    /** @test */
    function it_displays_danger_toast_notifications()
    {
        $this->toast->message('Uh Oh')->danger();

        $message = $this->toast->messages[0];

        $this->assertEquals('', $message->title);
        $this->assertEquals('Uh Oh', $message->message);
        $this->assertEquals('danger', $message->level);
        $this->assertEquals(false, $message->important);
        $this->assertEquals(false, $message->overlay);

        $this->assertSessionIsToasted();
    }

    /** @test */
    function it_displays_warning_toast_notifications()
    {
        $this->toast->message('Warning Warning')->warning();

        $message = $this->toast->messages[0];

        $this->assertEquals('', $message->title);
        $this->assertEquals('Warning Warning', $message->message);
        $this->assertEquals('warning', $message->level);
        $this->assertEquals(false, $message->important);
        $this->assertEquals(false, $message->overlay);

        $this->assertSessionIsToasted();
    }

    /** @test */
    function it_displays_important_toast_notifications()
    {
        $this->toast->message('Welcome Aboard')->important();

        $message = $this->toast->messages[0];

        $this->assertEquals('', $message->title);
        $this->assertEquals('Welcome Aboard', $message->message);
        $this->assertEquals('info', $message->level);
        $this->assertEquals(true, $message->important);
        $this->assertEquals(false, $message->overlay);

        $this->assertSessionIsToasted();
    }

    /** @test */
    function it_builds_an_overlay_toast_notification()
    {
        $this->toast->message('Thank You')->overlay();

        $message = $this->toast->messages[0];

        $this->assertEquals('Notice', $message->title);
        $this->assertEquals('Thank You', $message->message);
        $this->assertEquals('info', $message->level);
        $this->assertEquals(false, $message->important);
        $this->assertEquals(true, $message->overlay);

        $this->toast->clear();

        $this->toast->overlay('Overlay message.', 'Overlay Title');

        $message = $this->toast->messages[0];

        $this->assertEquals('Overlay Title', $message->title);
        $this->assertEquals('Overlay message.', $message->message);
        $this->assertEquals('info', $message->level);
        $this->assertEquals(false, $message->important);
        $this->assertEquals(true, $message->overlay);

        $this->assertSessionIsToasted();
    }

    /** @test */
    function it_clears_all_messages()
    {
        $this->toast->message('Welcome Aboard');

        $this->assertCount(1, $this->toast->messages);

        $this->toast->clear();

        $this->assertCount(0, $this->toast->messages);
    }

    /** @test */
    function it_is_macroable()
    {
        $this->toast->macro('passthru', function ($message) {
            return $message;
        });

        $this->assertEquals('Macroable Message', $this->toast->passthru('Macroable Message'));
    }

    protected function assertSessionIsToasted($times = 1)
    {
        $this->session
            ->shouldHaveReceived('toast')
            ->with('toast_notification', $this->toast->messages)
            ->times($times);
    }
}