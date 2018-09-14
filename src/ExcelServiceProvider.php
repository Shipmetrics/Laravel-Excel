<?php

namespace Maatwebsitevthree\Excel;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Mixins\StoreCollection;
use Maatwebsite\Excel\Console\ExportMakeCommand;
use Maatwebsite\Excel\Mixins\DownloadCollection;
use Illuminate\Contracts\Routing\ResponseFactory;
use Laravel\Lumen\Application as LumenApplication;

class ExcelServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if ($this->app instanceof LumenApplication) {
                $this->app->configure('excelvthree');
            } else {
                $this->publishes([
                    $this->getConfigFile() => config_path('excel.php'),
                ], 'config');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            'excelvthree'
        );

        $this->app->bind('excelvthree', function () {
            return new Excel(
                $this->app->make(Writer::class),
                $this->app->make(QueuedWriter::class),
                $this->app->make(ResponseFactory::class),
                $this->app->make('filesystem')
            );
        });

        $this->app->alias('excelvthree', Excel::class);
        $this->app->alias('excelvthree', Exporter::class);

        Collection::mixin(new DownloadCollection);
        Collection::mixin(new StoreCollection);

        $this->commands([
            ExportMakeCommand::class,
        ]);
    }

    /**
     * @return string
     */
    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'excelvthree.php';
    }
}
