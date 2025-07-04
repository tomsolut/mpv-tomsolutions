<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\DeviceType;
use App\Models\Manufacturer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manufacturers = [
            'Mocom Sterilization First' => [
                'Autoklaven' => [
                    'B Futura',
                    'B Classic',
                    'S Classic 17',
                    'S Classic 22',
                    'Supreme'
                ],
                'Siegelgerät' => [
                    'Millseal Rolling',
                    'Millseal+Evo',
                    'Millseal+Manual'
                ],
                'RDG' => [
                    'Tethys H10',
                    'Tethys D60',
                    'Tethys T60',
                    'Tethys T45',
                    'Tethys H10 Plus',
                ]
            ],

            'MELAG Medizintechnik oHG' => [
                'Autoklaven' => [
                    'Vacuklav 41 B+',
                    'Vacuklav 43 B+',
                    'Vacuklav 40 B+',
                    'Vacuklav 44 B+',
                    'Vacuklav 31 B+',
                    'Vacuklav 23 B+',
                    'Vacuklav 30 B+',
                    'Vacuklav 24 B+',
                    'Vacuklav 24 BL+',
                    'Euroklav 23 VS+',
                    'Euroklav 29 VS+',
                    'MELAtronic 23 EN',
                    'MELAtronic 15 EN+',
                    'MELAtronic 23 ',
                    'Clinclave 45',
                    'Vacuclave 118',
                    'Vacucalve 118S',
                    'Vacuclave 123',
                    'Vacuclave 123S',
                    'Vacuclave 318',
                    'Vacuclave 323',
                    'Vacuclave 105',
                    'Vacuclave 305',
                    'Vacuclave 550',
                    'Vacuclave 618',
                ],
                'Siegelgerät' => [
                    'MELAseal Pro',
                    'MELAseal 200',
                    'MELAseal 100+',
                ],
                'RDG' => [
                    'Melatherm 10 Evolution',
                    'Melatherm 10',
                ]
            ],

            'Getinge Group' => [
                'Autoklaven' => [
                    'Quadro',
                    'Getinge K3+',
                    'Getinge K5+',
                    'Getinge K7+',
                ],
                'Siegelgerät' => [
                    'Getinge HS 100',
                ],
                'RDG' => [
                    'Claro WD 15',
                    'Tablo WD 14',
                ]
            ],

            'EURONDA Deutschland GmbH' => [
                'Autoklaven' => [
                    'E10 B-Autoklav',
                    'E9 NEXT Klasse-B',
                    'E8 B-Autoklav',
                    'EXL B-Autoklav',
                    'E6 B-Autoklav',
                ],
                'Siegelgerät' => [
                    'Euroseal Valida',
                    'Euromatic Plus',
                    'Euroseal',
                    'Euroseal 2001 PL',
                    'Euromatic 3G',
                    'Euroseal Infinity'
                ],
                'RDG' => [
                    'Eurosafe 60',
                ]
            ],

            'Miele Deutschland' => [
                'Autoklaven' => [
                    'CUBE  PST 1710',
                    'CUBE  PST 2210',
                    'CUBE X PST 1720',
                    'CUBE X PST 2220',
                ],
                'Siegelgerät' => [],
                'RDG' => [
                    'PG 8536 [AD LFM SST]',
                    'PG 8536 [AD OXI/ORTHOVARIO SST]',
                    'PG 8536 [AD SST]',
                    'PG 8582 CD [WW AD CM Set LAN]',
                    'PG 8582 CD [WW AD CM Set WLAN]',
                    'PG 8582 [WW AD LD Set LAN]',
                    'PG 8582 [WW AD LD Set WLAN]',
                    'PG 8582 [WW AD PD Set LAN]',
                    'PG 8582 [WW AD PD Set WLAN]',
                    'PG 8592 [WW AD CM Set LAN DOS]',
                    'PG 8592 [WW AD CM Set WLAN DOS]',
                    'PG 8592 [WW AD Set LAN DOS]',
                    'PG 8592 [WW AD Set WLAN DOS]',
                    'PWD 8531 [WS DSN IMS DWC]',
                    'PG 8581 [AD LD Set LAN]',
                    'PG 8581 [AD LD Set WLAN]',
                    'PG 8591 [WW AD Set LAN DOS]',
                    'PG 8591 [WW AD Set WLAN DOS]',
                    'PWD 8532 [WS DSN IMS DWC]',
                    'G 7882 CD',
                    'G 7881 ',
                    'PWD 8534 [WS DSN IMS DWC]',
                    'PG 8536 (AD LFM SST)',
                    'PG 8536 (AD OXI/ORTHOVARIO SST)',
                    'PG 8536 (AD SST)',
                    'PG 8536',
                ]
            ],

            'SciCan GmbH' => [
                'Autoklaven' => [
                    'BRAVO 17',
                    'BRAVO 17V',
                    'BRAVO 21V',
                    'BRAVO G4 17L',
                    'BRAVO G4 22L',
                    'BRAVO G4 28L',
                    'Statim G4 2000',
                    'Statim G4 5000',
                    'Statim Classic 2000S',
                    'Statim Classic 5000S',
                ],
                'Siegelgerät' => [],
                'RDG' => [
                    'HYDRIM C61 WD G4',
                    'HYDRIM M2 G4',
                ],
            ],

            'W&H DEUTSCHLAND GMBH' => [
                'Autoklaven' => [
                    'Lina 17',
                    'Lina 22',
                    'Lara 17',
                    'Lara 22',
                    'Lisa 17',
                    'Lisa 22',
                    'Lisa Mini',
                    'Lisa XXL',
                    'Lara XL',
                ],
                'Siegelgerät' => [
                    'Seal²',
                    'SealVal²',
                ],
                'RDG' => [
                    'Teon',
                    'Teon +',
                ],
            ],

            'IC Medical GmbH' => [
                'Autoklaven' => [
                    'Autoklav TT+ 23',
                ],
                'Siegelgerät' => [
                    'RS200 Pro+',
                ],
                'RDG' => [
                    'HD 450 Basic PRO',
                    'HD 450 Injection PRO',
                    'HYG 3',
                    'HYG 5',
                ],
            ],

            'Dentsply Sirona Deutschland GmbH' => [
                'Autoklaven' => [
                    'DAC Premium',
                    'DAC Premium Plus',
                    'DAC Professional',
                    'DAC Professional Plus',
                ],
                'Siegelgerät' => [
                    'SiroSeal Premium',
                    'SiroSeal Professional',
                ],
                'RDG' => [
                    'DAC Universal.',
                    'DAC Universal D',
                ],
            ],
        ];

        $deviceTypes = DeviceType::all();
        foreach ($manufacturers as $manufacturer => $devices) {
            $manufacturer = Manufacturer::create([
                'name' => $manufacturer,
            ]);

            foreach ($devices as $deviceType => $deviceModels) {
                $dt = $deviceTypes->where('name', $deviceType)->first();

                if (!$dt) {
                    continue;
                }

                foreach ($deviceModels as $deviceModel) {
                    Device::create([
                        'name' => $deviceModel,
                        'recall_period' => 365,
                        'manufacturer_id' => $manufacturer->id,
                        'device_type_id' => $dt->id,
                    ]);
                }
            }
        }
    }
}
