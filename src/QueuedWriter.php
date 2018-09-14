<?php

namespace Maatwebsitevthree\Excel;

use Traversable;
use Illuminate\Support\Collection;
use Maatwebsitevthree\Excel\Jobs\CloseSheet;
use Maatwebsitevthree\Excel\Jobs\QueueExport;
use Maatwebsitevthree\Excel\Concerns\FromQuery;
use Maatwebsitevthree\Excel\Jobs\SerializedQuery;
use Maatwebsitevthree\Excel\Jobs\AppendDataToSheet;
use Maatwebsitevthree\Excel\Jobs\StoreQueuedExport;
use Maatwebsitevthree\Excel\Concerns\FromCollection;
use Maatwebsitevthree\Excel\Jobs\AppendQueryToSheet;
use Maatwebsitevthree\Excel\Concerns\WithMultipleSheets;
use Maatwebsitevthree\Excel\Concerns\WithCustomChunkSize;
use Maatwebsitevthree\Excel\Concerns\WithCustomQuerySize;

class QueuedWriter
{
    /**
     * @var Writer
     */
    protected $writer;

    /**
     * @var int
     */
    protected $chunkSize;

    /**
     * @param Writer $writer
     */
    public function __construct(Writer $writer)
    {
        $this->writer    = $writer;
        $this->chunkSize = config('excel.exports.chunk_size', 1000);
    }

    /**
     * @param object      $export
     * @param string      $filePath
     * @param string|null $disk
     * @param string|null $writerType
     *
     * @return \Illuminate\Foundation\Bus\PendingDispatch
     */
    public function store($export, string $filePath, string $disk = null, string $writerType = null)
    {
        $tempFile = $this->writer->tempFile();

        $jobs = $this->buildExportJobs($export, $tempFile, $writerType);

        $jobs->push(new StoreQueuedExport($tempFile, $filePath, $disk));

        return QueueExport::withChain($jobs->toArray())->dispatch($export, $tempFile, $writerType);
    }

    /**
     * @param object $export
     * @param string $tempFile
     * @param string $writerType
     *
     * @return Collection
     */
    private function buildExportJobs($export, string $tempFile, string $writerType)
    {
        $sheetExports = [$export];
        if ($export instanceof WithMultipleSheets) {
            $sheetExports = $export->sheets();
        }

        $jobs = new Collection;
        foreach ($sheetExports as $sheetIndex => $sheetExport) {
            if ($sheetExport instanceof FromCollection) {
                $jobs = $jobs->merge($this->exportCollection($sheetExport, $tempFile, $writerType, $sheetIndex));
            } elseif ($sheetExport instanceof FromQuery) {
                $jobs = $jobs->merge($this->exportQuery($sheetExport, $tempFile, $writerType, $sheetIndex));
            }

            $jobs->push(new CloseSheet($sheetExport, $tempFile, $writerType, $sheetIndex));
        }

        return $jobs;
    }

    /**
     * @param FromCollection $export
     * @param string         $filePath
     * @param string         $writerType
     * @param int            $sheetIndex
     *
     * @return Collection
     */
    private function exportCollection(
        FromCollection $export,
        string $filePath,
        string $writerType,
        int $sheetIndex
    ) {
        return $export
            ->collection()
            ->chunk($this->getChunkSize($export))
            ->map(function ($rows) use ($writerType, $filePath, $sheetIndex, $export) {
                if ($rows instanceof Traversable) {
                    $rows = iterator_to_array($rows);
                }

                return new AppendDataToSheet(
                    $export,
                    $filePath,
                    $writerType,
                    $sheetIndex,
                    $rows
                );
            });
    }

    /**
     * @param FromQuery $export
     * @param string    $filePath
     * @param string    $writerType
     * @param int       $sheetIndex
     *
     * @return Collection
     */
    private function exportQuery(
        FromQuery $export,
        string $filePath,
        string $writerType,
        int $sheetIndex
    ) {
        $query = $export->query();

        $count = $export instanceof WithCustomQuerySize ? $export->querySize() : $query->count();
        $spins = ceil($count / $this->getChunkSize($export));

        $jobs = new Collection();

        for ($page = 1; $page <= $spins; $page++) {
            $serializedQuery = new SerializedQuery(
                $query->forPage($page, $this->getChunkSize($export))
            );

            $jobs->push(new AppendQueryToSheet(
                $export,
                $filePath,
                $writerType,
                $sheetIndex,
                $serializedQuery
            ));
        }

        return $jobs;
    }

    /**
     * @param object|WithCustomChunkSize $export
     *
     * @return int
     */
    private function getChunkSize($export): int
    {
        if ($export instanceof WithCustomChunkSize) {
            return $export->chunkSize();
        }

        return $this->chunkSize;
    }
}
