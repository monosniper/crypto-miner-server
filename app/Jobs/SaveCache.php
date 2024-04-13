<?php

namespace App\Jobs;

use App\Services\CacheService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class SaveCache implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?string $path,
        public string $name,
        public ?string $id,
        public $value,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = $this->path ?? $this->name;
        Cache::forget($path);
        Cache::put(
            $path,
            $this->value ?: CacheService::getDefaultValue($this->name)()
        );
    }
}
