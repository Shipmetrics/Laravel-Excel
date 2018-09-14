<?php

namespace Maatwebsitevthree\Excel\Concerns;

interface WithCustomStartCell
{
    /**
     * @return string
     */
    public function startCell(): string;
}
