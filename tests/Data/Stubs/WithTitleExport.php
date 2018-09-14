<?php

namespace Maatwebsitevthree\Excel\Tests\Data\Stubs;

use Maatwebsitevthree\Excel\Concerns\WithTitle;
use Maatwebsitevthree\Excel\Concerns\Exportable;

class WithTitleExport implements WithTitle
{
    use Exportable;

    /**
     * @return string
     */
    public function title(): string
    {
        return 'given-title';
    }
}
