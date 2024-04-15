<?php

namespace Database\Seeders;

use App\Enums\CacheName;
use App\Models\ConfigurationGroup;
use App\Services\CacheService;
use Illuminate\Database\Seeder;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oc = [
            [ 'title' => 'Rocky Linux 9.x' ],
            [ 'title' => 'Mikrotik CHR' ],
            [ 'title' => 'CentOS 7 x64' ],
            [ 'title' => 'CentOS 8 x64' ],
            [ 'title' => 'CentOS 9 x64' ],
            [ 'title' => 'AlmaLinux 8 x64' ],
            [ 'title' => 'AlmaLinux 9 x64' ],
            [ 'title' => 'Debian 10 x64' ],
            [ 'title' => 'Debian 11 x64' ],
            [ 'title' => 'Debian 12 x64' ],
            [ 'title' => 'Ubuntu 20 x64' ],
            [ 'title' => 'Ubuntu 22 x64' ],
        ];

        $ram = [
            [ 'title' => '1 Gb', 'price' => 10 ],
            [ 'title' => '2 Gb', 'price' => 15 ],
            [ 'title' => '4 Gb', 'price' => 35 ],
            [ 'title' => '8 Gb', 'price' => 70 ],
            [ 'title' => '12 Gb', 'price' => 100 ],
            [ 'title' => '16 Gb', 'price' => 150 ],
            [ 'title' => '24 Gb', 'price' => 200 ],
            [ 'title' => '32 Gb', 'price' => 250 ],
            [ 'title' => '64 Gb', 'price' => 450 ],
            [ 'title' => '128 Gb', 'price' => 800 ],
            [ 'title' => '256 Gb', 'price' => 1550 ],
        ];

        $cpu = [
            [ 'title' => 'Xeon 1x2.60 GHz', 'price' => 20 ],
            [ 'title' => 'Xeon 2x2.60 GHz', 'price' => 35 ],
            [ 'title' => 'Xeon 3x2.60 GHz', 'price' => 50 ],
            [ 'title' => 'Xeon 4x2.60 GHz', 'price' => 65 ],
            [ 'title' => 'Xeon 6x2.60 GHz', 'price' => 100 ],
            [ 'title' => 'Xeon 8x2.60 GHz', 'price' => 140 ],
            [ 'title' => 'Intel Pentium Processor G3250 2x3.2GHz', 'price' => 40 ],
            [ 'title' => 'Intel Celeron G1610 2x2.4GHz', 'price' => 25 ],
            [ 'title' => 'Intel Dual Core G530 2x2.4GHz', 'price' => 30 ],
            [ 'title' => 'Intel Core i3-2130 4x3.4GHz (HT)', 'price' => 40 ],
            [ 'title' => 'Intel Dual Core G850 2x2.9GHz', 'price' => 45 ],
            [ 'title' => 'Intel Xeon E3-1220V2/V3 Quad Core 4x3.1 Ghz', 'price' => 25 ],
            [ 'title' => 'Intel Core i5-2400 4x3.1GHz', 'price' => 35 ],
            [ 'title' => 'Intel Xeon E3-1240 V3 Quad Core 4x3.40GHz', 'price' => 30 ],
            [ 'title' => 'AMD FX-6300 6x3.5GHz', 'price' => 140 ],
            [ 'title' => 'Intel Dual Core G530 2x2.4GHz', 'price' => 40 ],
            [ 'title' => 'Intel Xeon E3-1230V5/V6 8x3.5 Ghz (HT)', 'price' => 30 ],
            [ 'title' => 'AMD FX-8320 8x3.5GHz', 'price' => 160 ],
            [ 'title' => '2x Intel Xeon L5630 16x2.13GHz (HT)', 'price' => 180 ],
            [ 'title' => '2x Intel Xeon E5-2683v4 [32 ядра / 64 потока 2.10 GHz - 3.00 GHz]', 'price' => 250 ],
            [ 'title' => 'AMD EPYC™ 7402P [24 ядер / 48 потоков 2.80 GHz - 3.35 GHz]', 'price' => 240 ],
            [ 'title' => 'AMD Ryzen™ 9 7950X [16 ядер / 32 потока 4.50 GHz - 5.70 Ghz]', 'price' => 190 ],
            [ 'title' => 'AMD Ryzen™ 9 5950X [16 ядер / 32 потока 3.40 GHz - 4.90 Ghz]', 'price' => 160 ],
        ];

        $gpu = [
            [ 'title' => 'Radeon RX 580 4Gb', 'price' => 60 ],
            [ 'title' => 'GeForce GTX 1050 Ti 4GB', 'price' => 50 ],
            [ 'title' => 'RX 5700 XT 1605MHz', 'price' => 150 ],
            [ 'title' => 'Radeon VII 1400MHz PCI-E 3.0', 'price' => 280 ],
            [ 'title' => 'GTX 1060 1506MHz PCI-E 3.0', 'price' => 80 ],
            [ 'title' => 'Radeon RX 5700', 'price' => 140 ],
            [ 'title' => 'GTX 1070 Founders Edition 8GB', 'price' => 160 ],
            [ 'title' => 'RTX 2060 OC 6G', 'price' => 260 ],
            [ 'title' => 'RTX 3080', 'price' => 300 ],
            [ 'title' => 'RTX 3080 TI', 'price' => 450 ],
            [ 'title' => 'RTX 3090', 'price' => 600 ],
            [ 'title' => 'RTX 3090 TI', 'price' => 650 ],
            [ 'title' => 'RTX 4080', 'price' => 800 ],
            [ 'title' => 'RTX 4080 SUPER', 'price' => 850 ],
            [ 'title' => 'RTX 4090', 'price' => 960 ],
        ];

        $port = [
            [ 'title' => '1 Gbps', 'price' => 0 ],
            [ 'title' => '10 Gbps', 'price' => 100 ],
            [ 'title' => '1 Tbps', 'price' => 300 ],
        ];

        $traffic = [
            [ 'title' => '2 Tb', 'price' => 0 ],
            [ 'title' => '10 Tb', 'price' => 80 ],
            [ 'title' => 'Unlimited', 'price' => 240 ],
        ];

        $ipv = [
            [ 'title' => '4', 'price' => 0 ],
            [ 'title' => '6', 'price' => 20 ],
        ];

        $canFarmNft = [
            [ 'title' => 'Нет', 'price' => 0 ],
            [ 'title' => 'Да', 'price' => 40 ],
        ];

        $ip_count = [
            [ 'title' => '1', 'price' => 0 ],
            [ 'title' => '2', 'price' => 5 ],
            [ 'title' => '3', 'price' => 10 ],
            [ 'title' => '4', 'price' => 15 ],
        ];

        $gpu_count = [
            [ 'title' => '1' ],
            [ 'title' => '2' ],
            [ 'title' => '4' ],
            [ 'title' => '8' ],
            [ 'title' => '16' ],
        ];

        $notifications = [
            [ 'title' => 'Нет', 'price' => 0 ],
            [ 'title' => 'На почту', 'price' => 10 ],
            [ 'title' => 'В телеграм', 'price' => 10 ],
            [ 'title' => 'В телеграм и на почту', 'price' => 15 ],
        ];

        $disk = [
            [ 'title' => '20GB NVME', 'price' => 20 ],
            [ 'title' => '30GB NVME', 'price' => 35 ],
            [ 'title' => '50GB NVME', 'price' => 70 ],
            [ 'title' => '124GB NVME', 'price' => 220 ],
            [ 'title' => '256GB NVME', 'price' => 340 ],
            [ 'title' => '512GB NVME', 'price' => 450 ],
            [ 'title' => '1TB NVME', 'price' => 620 ],
        ];

        $location = [
            [ 'title' => 'Австрия' ],
            [ 'title' => 'Бельгия' ],
            [ 'title' => 'Болгария' ],
            [ 'title' => 'Бразилия' ],
            [ 'title' => 'Великобритания' ],
            [ 'title' => 'Венгрия' ],
            [ 'title' => 'Германия' ],
            [ 'title' => 'Гонконг' ],
            [ 'title' => 'Дания' ],
            [ 'title' => 'Ирландия' ],
            [ 'title' => 'Испания' ],
            [ 'title' => 'Италия' ],
            [ 'title' => 'Казахстан' ],
            [ 'title' => 'Канада' ],
            [ 'title' => 'Нидерланды' ],
            [ 'title' => 'Норвегия' ],
            [ 'title' => 'ОАЭ' ],
            [ 'title' => 'Польша' ],
            [ 'title' => 'Румыния' ],
            [ 'title' => 'Сербия' ],
            [ 'title' => 'Сингапур' ],
            [ 'title' => 'США' ],
            [ 'title' => 'Турция' ],
            [ 'title' => 'Украина' ],
            [ 'title' => 'Франция' ],
            [ 'title' => 'Чехия' ],
            [ 'title' => 'Швейцария' ],
            [ 'title' => 'Швеция' ],
            [ 'title' => 'Эстония' ],
            [ 'title' => 'Япония' ],
        ];

        $data = [
            [
                'slug' => 'configuration.php',
                'priority' => 0,
                'fields' => [
                    [
                        'slug' => 'type',
                        'type' => 'text',
                        'priority' => 0,
                    ],
                    [
                        'slug' => 'location',
                        'priority' => 1,
                        'options' => $location
                    ],
                ]
            ],
            [
                'slug' => 'oc',
                'priority' => 1,
                'fields' => [
                    [
                        'slug' => 'oc',
                        'priority' => 0,
                        'options' => $oc
                    ],
                ]
            ],
            [
                'slug' => 'base',
                'priority' => 2,
                'fields' => [
                    [
                        'slug' => 'cpu',
                        'priority' => 0,
                        'options' => $cpu
                    ],
                    [
                        'slug' => 'ram',
                        'priority' => 1,
                        'options' => $ram
                    ],
                    [
                        'slug' => 'disk',
                        'priority' => 2,
                        'options' => $disk
                    ],
                    [
                        'slug' => 'gpu',
                        'priority' => 3,
                        'options' => $gpu
                    ],
                    [
                        'slug' => 'gpu_count',
                        'priority' => 4,
                        'options' => $gpu_count
                    ],
                ]
            ],
            [
                'slug' => 'network',
                'priority' => 3,
                'fields' => [
                    [
                        'slug' => 'ipv',
                        'priority' => 0,
                        'options' => $ipv
                    ],
                    [
                        'slug' => 'ip_count',
                        'priority' => 1,
                        'options' => $ip_count
                    ],
                    [
                        'slug' => 'port',
                        'priority' => 2,
                        'options' => $port
                    ],
                    [
                        'slug' => 'traffic',
                        'priority' => 3,
                        'options' => $traffic
                    ],
                ]
            ],
            [
                'slug' => 'additional',
                'priority' => 4,
                'fields' => [
                    [
                        'slug' => 'notifications',
                        'priority' => 0,
                        'options' => $notifications
                    ],
                    [
                        'slug' => 'canFarmNft',
                        'priority' => 1,
                        'options' => $canFarmNft
                    ],
                ]
            ],
            [
                'slug' => 'coins',
                'priority' => 5,
                'fields' => [
                    [
                        'slug' => 'coins',
                        'priority' => 0,
                        'type' => 'coins'
                    ],
                ]
            ],
            [
                'slug' => 'comment',
                'priority' => 6,
                'fields' => [
                    [
                        'slug' => 'comment',
                        'priority' => 0,
                        'type' => 'comment'
                    ],
                ]
            ],
        ];

        foreach ($data as $group) {
            $_group = new ConfigurationGroup();

            $_group->slug = $group['slug'];
            $_group->priority = $group['priority'];

            $_group->saveQuietly();

            if(isset($group['fields'])) {
                foreach ($group['fields'] as $field) {
                    $_field = $_group->fields()->createQuietly([
                        'slug' => $field['slug'],
                        'priority' => $field['priority'],
                        'type' => $field['type'] ?? 'select',
                    ]);

                    if(isset($field['options'])) {
                        $options = [];

                        foreach ($field['options'] as $option) {
                            $options[] = [
                                'title' => $option['title'],
                                'price' => $option['price'] ?? 0,
                            ];
                        }

                        $_field->options()->createManyQuietly($options);
                    }
                }
            }
        }

        CacheService::save(CacheName::CONFIGURATION);
    }
}
