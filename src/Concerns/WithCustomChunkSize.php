<?php

namespace Maatwebsitevthree\Excel\Concerns;

interface WithCustomChunkSize
{
    /**
     * @return int
     */
    public function chunkSize(): int;
}
