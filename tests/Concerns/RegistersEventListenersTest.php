<?php

namespace Maatwebsitevthree\Excel\Tests\Concerns;

use Maatwebsitevthree\Excel\Sheet;
use Maatwebsitevthree\Excel\Writer;
use Maatwebsitevthree\Excel\Tests\TestCase;
use Maatwebsitevthree\Excel\Events\AfterSheet;
use Maatwebsitevthree\Excel\Events\BeforeSheet;
use Maatwebsitevthree\Excel\Events\BeforeExport;
use Maatwebsitevthree\Excel\Events\BeforeWriting;
use Maatwebsitevthree\Excel\Tests\Data\Stubs\ExportWithEvents;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Maatwebsitevthree\Excel\Tests\Data\Stubs\BeforeExportListener;
use Maatwebsitevthree\Excel\Tests\Data\Stubs\ExportWithRegistersEventListeners;

class RegistersEventListenersTest extends TestCase
{
    /**
     * @test
     */
    public function events_get_called()
    {
        $event = new ExportWithRegistersEventListeners();

        $eventsTriggered = 0;

        $event::$beforeExport = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeExport::class, $event);
            $this->assertInstanceOf(Writer::class, $event->writer);
            $eventsTriggered++;
        };

        $event::$beforeWriting = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeWriting::class, $event);
            $this->assertInstanceOf(Writer::class, $event->writer);
            $eventsTriggered++;
        };

        $event::$beforeSheet = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(BeforeSheet::class, $event);
            $this->assertInstanceOf(Sheet::class, $event->sheet);
            $eventsTriggered++;
        };

        $event::$afterSheet = function ($event) use (&$eventsTriggered) {
            $this->assertInstanceOf(AfterSheet::class, $event);
            $this->assertInstanceOf(Sheet::class, $event->sheet);
            $eventsTriggered++;
        };

        $this->assertInstanceOf(BinaryFileResponse::class, $event->download('filename.xlsx'));
        $this->assertEquals(4, $eventsTriggered);
    }

    /**
     * @test
     */
    public function can_have_invokable_class_as_listener()
    {
        $event = new ExportWithEvents();

        $event->beforeExport = new BeforeExportListener(function ($event) {
            $this->assertInstanceOf(BeforeExport::class, $event);
            $this->assertInstanceOf(Writer::class, $event->writer);
        });

        $this->assertInstanceOf(BinaryFileResponse::class, $event->download('filename.xlsx'));
    }
}
