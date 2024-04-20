<?php

namespace App\Jobs;

use App\Enums\CacheName;
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

    public CacheName $name;
    public ?string $path;
    public mixed $value;
    public ?User $user;
    protected CacheService $service;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public array $options
    ) {
        $this->path = $this->options['path'] ?? null;
        $this->name = $this->options['name'];
        $this->value = $this->options['value'];
        $this->user = $this->options['user'] ?? null;

        $this->service = new CacheService();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $path = $this->path ?? $this->name->value;
        Cache::forget($path);
        Cache::put(
            $path,
            $this->value ?: $this->service->getDefaultValue($this->name, $this->user)(),
            $this->service->ttl,
        );
    }
}
