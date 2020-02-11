<?php

use Illuminate\Database\Seeder;

class OptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'optName' => 'sitename',
                'optValue' => 'Shiza',
            ],
            [
                'optName' => 'sitekeywords',
                'optValue' => 'shiza,ecommerce,pos,clinic,it solution,digital,software house, software development',
            ],
            [
                'optName' => 'tagline',
                'optValue' => 'Mitra IT Anda',
            ],
            [
                'optName' => 'sitedescription',
                'optValue' => 'Shiza adalah sebuah tim IT yang memberikan Anda solusi disetiap permasalahan Anda',
            ],
            [
                'optName' => 'template',
                'optValue' => 'standard',
            ],
            [
                'optName' => 'robots',
                'optValue' => 'index,follow',
            ],
            [
                'optName' => 'httpsmode',
                'optValue' => 'off',
            ],
            [
                'optName' => 'favicon',
                'optValue' => '',
            ],
            [
                'optName' => 'sitephone',
                'optValue' => '',
            ],
            [
                'optName' => 'siteaddress',
                'optValue' => '',
            ],
            [
                'optName' => 'tax',
                'optValue' => '10',
            ]
        ];

        foreach($data AS $d) {
			DB::table('options')->insert($d);
		}
    }
}
