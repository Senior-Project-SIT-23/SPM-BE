<?php

use Illuminate\Database\Seeder;
use App\Model\Rubric;
use App\Model\Criteria;
use App\Model\CriteriaDetail;
use App\Model\CriteriaScore;

class RubricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rubrics = (array)array(
            [
                'rubric_id' => '1',
                'rubric_title' => 'Programing Clinic'
            ],
            [
                'rubric_id' => '2',
                'rubric_title' => 'Midterm Exam'
            ]
        );

        $criterias = (array)array(
            [
                'criteria_id' => '1',
                'criteria_name' => 'Documents',
                'rubric_id' => '1'
            ],
            [
                'criteria_id' => '2',
                'criteria_name' => 'Presentation',
                'rubric_id' => '2'
            ],
            [
                'criteria_id' => '3',
                'criteria_name' => 'Progress of Senior Project',
                'rubric_id' => '2'
            ]
        );

        $criteria_details = (array)array(
            [
                'criteria_detail_id' => '1',
                'criteria_detail' => 'Bad',
                'criteria_id' => '1'
            ],
            [
                'criteria_detail_id' => '2',
                'criteria_detail' => 'Normal',
                'criteria_id' => '1'
            ],
            [
                'criteria_detail_id' => '3',
                'criteria_detail' => 'Good',
                'criteria_id' => '1'
            ],
            [
                'criteria_detail_id' => '4',
                'criteria_detail' => 'Excellent',
                'criteria_id' => '1'
            ],
            [
                'criteria_detail_id' => '5',
                'criteria_detail' => 'Novice',
                'criteria_id' => '2'
            ],
            [
                'criteria_detail_id' => '6',
                'criteria_detail' => 'Competent Performer',
                'criteria_id' => '2'
            ],
            [
                'criteria_detail_id' => '7',
                'criteria_detail' => 'Proficient Performer',
                'criteria_id' => '2'
            ],
            [
                'criteria_detail_id' => '8',
                'criteria_detail' => 'Expert',
                'criteria_id' => '2'
            ],
            [
                'criteria_detail_id' => '9',
                'criteria_detail' => 'Bad',
                'criteria_id' => '3'
            ],
            [
                'criteria_detail_id' => '10',
                'criteria_detail' => 'Normal',
                'criteria_id' => '3'
            ],
            [
                'criteria_detail_id' => '11',
                'criteria_detail' => 'Good',
                'criteria_id' => '3'
            ]

        );

        $criteria_scores = (array)array(
            [
                'criteria_score_id' => '1',
                'criteria_score' => '20',
                'criteria_detail_id' => '1'
            ],
            [
                'criteria_score_id' => '2',
                'criteria_score' => '50',
                'criteria_detail_id' => '2'
            ],
            [
                'criteria_score_id' => '3',
                'criteria_score' => '80',
                'criteria_detail_id' => '3'
            ],
            [
                'criteria_score_id' => '4',
                'criteria_score' => '100',
                'criteria_detail_id' => '4'
            ],
            [
                'criteria_score_id' => '5',
                'criteria_score' => '20',
                'criteria_detail_id' => '5'
            ],
            [
                'criteria_score_id' => '6',
                'criteria_score' => '50',
                'criteria_detail_id' => '6'
            ],
            [
                'criteria_score_id' => '7',
                'criteria_score' => '80',
                'criteria_detail_id' => '7'
            ],
            [
                'criteria_score_id' => '8',
                'criteria_score' => '100',
                'criteria_detail_id' => '8'
            ],
            [
                'criteria_score_id' => '9',
                'criteria_score' => '20',
                'criteria_detail_id' => '9'
            ],
            [
                'criteria_score_id' => '10',
                'criteria_score' => '50',
                'criteria_detail_id' => '10'
            ],
            [
                'criteria_score_id' => '11',
                'criteria_score' => '80',
                'criteria_detail_id' => '11'
            ]
        );

        foreach ($rubrics as $rubric) {
            $temp_rubric = new Rubric;
            $temp_rubric->rubric_id = Arr::get($rubric, 'rubric_id');
            $temp_rubric->rubric_title = Arr::get($rubric, 'rubric_title');
            $temp_rubric->save();
        }
        foreach ($criterias as $criteria) {
            $temp_criteria = new Criteria;
            $temp_criteria->criteria_id = Arr::get($criteria, 'criteria_id');
            $temp_criteria->criteria_name = Arr::get($criteria, 'criteria_name');
            $temp_criteria->rubric_id = Arr::get($criteria, 'rubric_id');
            $temp_criteria->save();
        }
        foreach ($criteria_details as $criteria_detail) {
            $temp_criteria_detail = new CriteriaDetail;
            $temp_criteria_detail->criteria_detail_id = Arr::get($criteria_detail, 'criteria_detail_id');
            $temp_criteria_detail->criteria_detail = Arr::get($criteria_detail, 'criteria_detail');
            $temp_criteria_detail->criteria_id = Arr::get($criteria_detail, 'criteria_id');
            $temp_criteria_detail->save();
        }
        foreach ($criteria_scores as $criteria_score){
            $temp_criteria_score = new CriteriaScore;
            $temp_criteria_score->criteria_score_id = Arr::get($criteria_score, 'criteria_score_id');
            $temp_criteria_score->criteria_score = Arr::get($criteria_score, 'criteria_score');
            $temp_criteria_score->criteria_detail_id = Arr::get($criteria_score, 'criteria_detail_id');
            $temp_criteria_score->save();
        }
    }
}
