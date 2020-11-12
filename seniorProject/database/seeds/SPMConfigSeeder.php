<?php

use Illuminate\Database\Seeder;
use App\Model\SPMConfig;

class SPMConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spm_configs = (array) array(
            [
                'id' => '1',
                'year_of_study' => '2019',
                'number_of_member_min' => '1',
                'number_of_member_max' => '3',
                'student_one_more_group' => false,
            ]
        );

        foreach ($spm_configs as $spm_config) {
            $temp_spm_config = new SPMConfig;
            $temp_spm_config->id = Arr::get($spm_config, 'id');
            $temp_spm_config->year_of_study = Arr::get($spm_config, 'year_of_study');
            $temp_spm_config->number_of_member_min = Arr::get($spm_config, 'number_of_member_min');
            $temp_spm_config->number_of_member_max = Arr::get($spm_config, 'number_of_member_max');
            $temp_spm_config->student_one_more_group = Arr::get($spm_config, 'student_one_more_group');
            $temp_spm_config->save();
        }
    }
}
