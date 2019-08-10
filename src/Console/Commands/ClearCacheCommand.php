<?php
namespace KnF\LaravelJmsSerializer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ClearCacheCommand extends Command
{
    protected $signature = 'jms:clear-cache';

    protected $description = 'Clears the JMSSerializer\'s cache';

    public function handle(Filesystem $filesystem)
    {
        $this->info('Clearing cache...');

        $dir = config('serializer.cache_dir');
        if (empty($dir)) {
            $this->error('Cache dir not set');
            return 1;
        }

        foreach ($filesystem->files($dir) as $file) {
            $filesystem->delete($file->getPathname());
        }

        foreach ($filesystem->directories($dir) as $item) {
            $filesystem->deleteDirectory($item, true);
        }

        $this->info('Cleared!');

        return 0;
    }
}
