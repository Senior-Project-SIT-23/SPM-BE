<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use App\Model\AA;

class AASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aas = (array) array(
            [
                'aa_id' => '11',
                'aa_name' => 'Pornthip',
                'aa_email' => 'pornthip@sit.kmutt.ac.th',
                'department' => 'IT'
            ],
            [
                'aa_id' => '12',
                'aa_name' => 'Rapeeporn',
                'aa_email' => 'Rapeeporn@sit.kmutt.ac.th',
                'department' => 'CS'
            ],
            [
                'aa_id' => '13',
                'aa_name' => 'AA_DSI_NAME',
                'aa_email' => 'Dsi@sit.kmutt.ac.th',
                'department' => 'DSI'
            ]
        );

        foreach($aas as $aa){
            $temp_aa = new AA;
            $temp_aa->aa_id = Arr::get($aa,'aa_id');
            $temp_aa->aa_name = Arr::get($aa,'aa_name');
            $temp_aa->aa_email = Arr::get($aa,'aa_email');
            $temp_aa->department = Arr::get($aa,'department');
            $temp_aa->save();
        }

    }
}
