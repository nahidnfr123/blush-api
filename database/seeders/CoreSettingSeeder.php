<?php

namespace Database\Seeders;

use App\Models\CoreSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoreSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        CoreSetting::create();

        $keyValuePars = [
            [
                'key' => 'developer_percentage', 'value' => 10,
                'validator' => ['required' => true, 'type' => 'number', 'rules' => 'required|number']
            ],
            [
                'key' => 'locale', 'value' => 'en',
                'validator' => ['required' => true, 'type' => 'string', 'rules' => 'required|string', 'in' => ['en', 'bn']]
            ],
            [
                'key' => 'timezone', 'value' => 'Asia/Dhaka',
                'validator' => ['required' => true, 'type' => 'string', 'rules' => 'required|string']
            ],
            [
                'key' => 'currency_name', 'value' => 'Bangladeshi Taka',
                'validator' => ['required' => true, 'type' => 'string', 'rules' => 'required|string', 'in' => ['Bangladeshi Taka', 'US Dollar', 'Euro', 'Pound']]
            ],
            [
                'key' => 'currency_code', 'value' => 'bdt',
                'validator' => ['required' => true, 'type' => 'string', 'rules' => 'required|string', 'in' => ['bdt', 'usd', 'eur', 'gbp']]
            ],
            [
                'key' => 'currency_symbol', 'value' => '৳',
                'validator' => ['required' => true, 'type' => 'string', 'rules' => 'required|string', 'in' => ['৳', '$', '€', '£']]
            ],


        ];
        foreach ($keyValuePars as $keyValuePar) {
            CoreSetting::firstOrCreate(['key' => $keyValuePar['key']], [
                'key' => $keyValuePar['key'], 'value' => $keyValuePar['value'],
                'validator' => json_encode($keyValuePar['validator']),
            ]);
        }
    }
}
