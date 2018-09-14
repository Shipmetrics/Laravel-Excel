<?php

namespace Maatwebsitevthree\Excel;

use Maatwebsitevthree\Excel\Events\Event;
use Maatwebsitevthree\Excel\Events\AfterSheet;
use Maatwebsitevthree\Excel\Events\BeforeSheet;
use Maatwebsitevthree\Excel\Events\BeforeExport;
use Maatwebsitevthree\Excel\Events\BeforeWriting;

trait RegistersCustomConcerns
{
    /**
     * @var array
     */
    private static $eventMap = [
        BeforeWriting::class => Writer::class,
        BeforeExport::class  => Writer::class,
        BeforeSheet::class   => Sheet::class,
        AfterSheet::class    => Sheet::class,
    ];

    /**
     * @param string   $concern
     * @param callable $handler
     * @param string   $event
     */
    public static function extend(string $concern, callable $handler, string $event = BeforeWriting::class)
    {
        /** @var HasEventBus $delegate */
        $delegate = static::$eventMap[$event] ?? BeforeWriting::class;

        $delegate::listen($event, function (Event $event) use ($concern, $handler) {
            if ($event->appliesToConcern($concern)) {
                $handler($event->getConcernable(), $event->getDelegate());
            }
        });
    }
}
