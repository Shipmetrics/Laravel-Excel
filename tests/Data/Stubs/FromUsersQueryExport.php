<?php

namespace Maatwebsitevthree\Excel\Tests\Data\Stubs;

use Illuminate\Database\Query\Builder;
use Maatwebsitevthree\Excel\Concerns\FromQuery;
use Maatwebsitevthree\Excel\Concerns\Exportable;
use Maatwebsitevthree\Excel\Concerns\WithCustomChunkSize;
use Maatwebsitevthree\Excel\Tests\Data\Stubs\Database\User;

class FromUsersQueryExport implements FromQuery, WithCustomChunkSize
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
     * @return int
     */
    public function chunkSize(): int
    {
        return 10;
    }
}
