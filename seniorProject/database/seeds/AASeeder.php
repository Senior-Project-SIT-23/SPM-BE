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
                'aa_id' => 'teststf01',
                'aa_name' => 'Teststf01 AtSIT',
                'aa_email' => 'teststf01@sit.kmutt.ac.th',
                'department' => 'IT'
            ],
            [
                'aa_id' => 'teststf02',
                'aa_name' => 'Teststf02 AtSIT',
                'aa_email' => 'teststf02@sit.kmutt.ac.th',
                'department' => 'CS'
            ],
            [
                'aa_id' => 'teststf03',
                'aa_name' => 'Teststf03 AtSIT',
                'aa_email' => 'teststf03@sit.kmutt.ac.th',
                'department' => 'DSI'
            ]
        );

        foreach ($aas as $aa) {
            $temp_aa = new AA;
            $temp_aa->aa_id = Arr::get($aa, 'aa_id');
            $temp_aa->aa_name = Arr::get($aa, 'aa_name');
            $temp_aa->aa_email = Arr::get($aa, 'aa_email');
            $temp_aa->department = Arr::get($aa, 'department');
            $temp_aa->save();
        }
    }
}
