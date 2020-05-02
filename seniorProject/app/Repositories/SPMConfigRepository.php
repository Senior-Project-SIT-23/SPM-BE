<?php

namespace App\Repositories;

use App\Model\SPMConfig;

class SPMConfigRepository implements SPMConfigRepositoryInterface
{
    public function createConfig($data)
    {
        $spm_config = new SPMConfig();
        $spm_config->year_of_study = $data['year_of_study'];
        $spm_config->number_of_member_min = $data['number_of_member_min'];
        $spm_config->number_of_member_max = $data['number_of_member_max'];
        $spm_config->student_one_more_group = $data['student_one_more_group'];
        $spm_config->save();
    }

    public function getConfig()
    {
        $spm_config = SPMConfig::all();
        return $spm_config;
    }

    public function getConfigByYear($year_of_study)
    {
        $spm_config = SPMConfig::where('year_of_study', "$year_of_study")->first();
        return $spm_config;
    }
}
