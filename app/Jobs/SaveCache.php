<?php

namespace App\Jobs;

use App\Models\User;
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

    public string $name;
    public ?string $path;
    public mixed $value;
    public ?User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $options,
    ) {
        $this->path = $this->options['path'] ?? null;
        $this->name = $this->options['name'];
        $this->value = $this->options['value'];
        $this->user = $this->options['user'] ?? null;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = $this->path ?? $this->name;
        Cache::forget($path);
        Cache::put(
            $path,
            $this->value ?: CacheService::getDefaultValue($this->name, $this->user)()
        );
    }
}
