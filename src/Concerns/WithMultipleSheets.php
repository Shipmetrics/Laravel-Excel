<?php

namespace Maatwebsitevthree\Excel\Concerns;

interface WithMultipleSheets
{
    /**
     * @return array
     */
    public function sheets(): array;
}
