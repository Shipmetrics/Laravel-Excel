<?php

namespace Maatwebsitevthree\Excel\Concerns;

interface WithCustomCsvSettings
{
    /**
     * @return array
     */
    public function getCsvSettings(): array;
}
