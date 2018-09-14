<?php

namespace Maatwebsitevthree\Excel\Tests\Data\Stubs;

use Illuminate\Support\Collection;
use Maatwebsitevthree\Excel\Concerns\Exportable;
use Maatwebsitevthree\Excel\Concerns\WithMapping;
use Maatwebsitevthree\Excel\Concerns\FromCollection;

class WithMappingExport implements FromCollection, WithMapping
{
    use Exportable;

    /**
     * @return Collection
     */
    public function collection()
    {
        return collect([
            ['A1', 'B1', 'C1'],
            ['A2', 'B2', 'C2'],
        ]);
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            'mapped-' . $row[0],
            'mapped-' . $row[1],
            'mapped-' . $row[2],
        ];
    }
}
