<?php

namespace Maatwebsitevthree\Excel\Concerns;

use Maatwebsitevthree\Excel\Excel;
use Illuminate\Foundation\Bus\PendingDispatch;
use Maatwebsitevthree\Excel\Exceptions\NoFilenameGivenException;
use Maatwebsitevthree\Excel\Exceptions\NoFilePathGivenException;

trait Exportable
{
    /**
     * @param string      $fileName
     * @param string|null $writerType
     *
     * @throws NoFilenameGivenException
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(string $fileName = null, string $writerType = null)
    {
        $fileName = $fileName ?? $this->fileName ?? null;

        if (null === $fileName) {
            throw new NoFilenameGivenException();
        }

        return resolve(Excelvthree::class)->download($this, $fileName, $writerType ?? $this->writerType ?? null);
    }

    /**
     * @param string      $filePath
     * @param string|null $disk
     * @param string|null $writerType
     *
     * @throws NoFilePathGivenException
     * @return bool|PendingDispatch
     */
    public function store(string $filePath = null, string $disk = null, string $writerType = null)
    {
        $filePath = $filePath ?? $this->filePath ?? null;

        if (null === $filePath) {
            throw new NoFilePathGivenException();
        }

        return resolve(Excelvthree::class)->store(
            $this,
            $filePath,
            $disk ?? $this->disk ?? null,
            $writerType ?? $this->writerType ?? null
        );
    }

    /**
     * @param string|null $filePath
     * @param string|null $disk
     * @param string|null $writerType
     *
     * @throws NoFilePathGivenException
     * @return PendingDispatch
     */
    public function queue(string $filePath = null, string $disk = null, string $writerType = null)
    {
        $filePath = $filePath ?? $this->filePath ?? null;

        if (null === $filePath) {
            throw new NoFilePathGivenException();
        }

        return resolve(Excelvthree::class)->queue(
            $this,
            $filePath,
            $disk ?? $this->disk ?? null,
            $writerType ?? $this->writerType ?? null
        );
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @throws NoFilenameGivenException
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return $this->download();
    }
}
