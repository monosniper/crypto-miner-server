<?php

namespace App\Filament\Resources\RefResource\Pages;

use App\Filament\Resources\RefResource;
use App\Models\Ref;
use Exception;
use Filament\Resources\Pages\CreateRecord;

class CreateRef extends CreateRecord
{
    protected static string $resource = RefResource::class;

    /**
     * @throws Exception
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        function generateCode() {
            return strtoupper(bin2hex(random_bytes(4)));
        }

        $code = generateCode();

        while (Ref::where('code', $code)->exists()) {
            $code = generateCode();
        }

        $data['code'] = $code;

        return $data;
    }
}
