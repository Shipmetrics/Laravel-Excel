<?php

namespace Maatwebsitevthree\Excel\Tests\Data\Stubs;

use Illuminate\Database\Query\Builder;
use Maatwebsitevthree\Excel\Concerns\FromQuery;
use Maatwebsitevthree\Excel\Events\BeforeSheet;
use Maatwebsitevthree\Excel\Concerns\Exportable;
use Maatwebsitevthree\Excel\Concerns\WithEvents;
use Maatwebsitevthree\Excel\Concerns\WithMapping;
use Maatwebsitevthree\Excel\Tests\Data\Stubs\Database\User;

class FromUsersQueryExportWithMapping implements FromQuery, WithMapping, WithEvents
{
    use Exportable;

    /**
     * @return Builder
     */
    public function query()
    {
        return User::query();
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeSheet::class   => function (BeforeSheet $event) {
                $event->sheet->chunkSize(10);
            },
        ];
    }

    /**
     * @param User $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            'name' => $row->name,
        ];
    }
}
