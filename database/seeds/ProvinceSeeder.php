<?php

use App\Province;
use Illuminate\Database\Seeder;

use function GuzzleHttp\json_decode;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = file_get_contents(base_path('/database/provinsi.json'));
        $data = json_decode($file, true);

        Province::insert($data);
    }
}
