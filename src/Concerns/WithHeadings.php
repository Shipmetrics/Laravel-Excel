<?php

namespace Maatwebsitevthree\Excel\Concerns;

interface WithHeadings
{
    /**
     * @return array
     */
    public function headings(): array;
}
