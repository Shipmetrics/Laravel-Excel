<?php

namespace Maatwebsitevthree\Excel\Tests\Data\Stubs;

use Maatwebsitevthree\Excel\Events\AfterSheet;
use Maatwebsitevthree\Excel\Events\BeforeSheet;
use Maatwebsitevthree\Excel\Concerns\Exportable;
use Maatwebsitevthree\Excel\Concerns\WithEvents;
use Maatwebsitevthree\Excel\Events\BeforeExport;
use Maatwebsitevthree\Excel\Events\BeforeWriting;

class ExportWithEvents implements WithEvents
{
    use Exportable;

    /**
     * @var callable
     */
    public $beforeExport;

    /**
     * @var callable
     */
    public $beforeWriting;

    /**
     * @var callable
     */
    public $beforeSheet;

    /**
     * @var callable
     */
    public $afterSheet;

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => $this->beforeExport ?? function () {
            },
            BeforeWriting::class => $this->beforeWriting ?? function () {
            },
            BeforeSheet::class   => $this->beforeSheet ?? function () {
            },
            AfterSheet::class    => $this->afterSheet ?? function () {
            },
        ];
    }
}
