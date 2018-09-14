<?php

namespace Maatwebsitevthree\Excel\Concerns;

use Illuminate\Database\Query\Builder;

interface FromQuery
{
    /**
     * @return Builder
     */
    public function query();
}
