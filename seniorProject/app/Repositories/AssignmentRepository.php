<?php

namespace App\Repositories;

use App\Model\AssessmentAssignment;
use App\Model\Assignment;
use App\Model\Attachment;
use App\Model\ResponsibleAssignment;
use App\Model\Rubric;
use App\Model\Criteria;
use App\Model\CriteriaDetail;
use App\Model\CriteriaScore;
use App\Model\Feedback;
use App\Model\Group;
use App\Model\SendAssignment;
use App\Model\StudentAssignment;
use App\Model\Teacher;
use App\Model\Project;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    public function createAssignment($data)
    {
        $assignment = new Assignment;
        $assignment->assignment_title = $data['assignment_title'];
        $assignment->assignment_detail = $data['assignment_detail'];
        $assignment->due_date = $data['due_date'];
        $assignment->due_time = $data['due_time'];
        $assignment->date_time = $data['due_date'] . " " . $data['due_time'];
        $assignment->rubric_id = $data['rubric_id'];
        $assignment->teacher_id = $data['teacher_id'];
        $assignment->save();

        foreach ($data['responsible_teacher'] as $value) {
            $responsible_assignment = new ResponsibleAssignment;
            $responsible_assignment->responsible_teacher_id = $value;
            $responsible_assignment->assignment_id = $assignment->id;
            $responsible_assignment->save();
        }
    }

    public function updateAssignment($data)
    {
        $assignment = Assignment::where('assignment_id', $data['assignment_id'])->first();
        $rubric_id = $assignment->rubric_id;

        foreach ($data['delete_responsible_teacher'] as $value) {
            if ($value) {
                ResponsibleAssignment::where('responsible_assignment.assignment_id', $data['assignment_id'])
                    ->where('responsible_assignment.responsible_teacher_id', "$value")->delete();
            }
        }
        if ($data['delete_attachment']) {
            foreach ($data['delete_attachment'] as $value) {
                if ($value) {
                    $attachment = Attachment::where('attachments.attachment_id', "$value")->first();
                    $keep_file_name = $attachment->keep_file_name;
                    Attachment::where('attachments.attachment_id', "$value")->delete();
                    unlink(storage_path('app/attachments/' . $keep_file_name));
                }
            }
        }

        Assignment::where('assignments.assignment_id', $data['assignment_id'])
            ->update([
                'assignments.assignment_title' => $data['assignment_title'],
                'assignments.assignment_detail' => $data['assignment_detail'],
                'assignments.due_date' => $data['due_date'],
                'assignments.due_time' => $data['due_time'],
                'assignments.date_time' => $data['due_date'] . " " . $data['due_time'],
                'assignments.teacher_id' => $data['teacher_id'],
                'assignments.rubric_id' => $data['rubric_id']
            ]);


        foreach ($data['responsible_teacher'] as $value) {
            if ($value) {
                $responsible_assignment = new ResponsibleAssignment;
                $responsible_assignment->responsible_teacher_id = $value;
                $responsible_assignment->assignment_id = $data['assignment_id'];
                $responsible_assignment->save();
            }
        }

        if ($rubric_id != $data['rubric_id']) {
            AssessmentAssignment::where('assignment_id', $data['assignment_id'])->delete();
            Feedback::where('assignment_id', $data['assignment_id'])->delete();
            StudentAssignment::where('assignment_id', $data['assignment_id'])
                ->update(['total_score' => null]);
        }
    }


    public function deleteAssignmentById($assignment_id)
    {
        ResponsibleAssignment::where('responsible_assignment.assignment_id', $assignment_id)->delete();


        $attachment = Attachment::where('attachments.assignment_id', $assignment_id)->get();
        foreach ($attachment as $value) {
            unlink(storage_path('app/attachments/' . $value->keep_file_name));
        }

        Attachment::where('attachments.assignment_id', $assignment_id)->delete();
        Assignment::where('assignments.assignment_id', $assignment_id)->delete();
    }

    public function createRubric($data)
    {
        $rubric = new Rubric;
        $rubric->rubric_title = $data['rubric_title'];
        $rubric->save();

        foreach ($data['criterions'] as $value) {
            $criteria = new Criteria;
            $criteria->criteria_name = $value['criteria_name'];
            $criteria->rubric_id = $rubric->id;
            $criteria->save();

            foreach ($value['criteria_detail'] as $temp) {
                $criteria_detail = new CriteriaDetail;
                $criteria_detail->criteria_detail = $temp['name'];
                $criteria_detail->criteria_id = $criteria->id;
                $criteria_detail->save();

                $criteria_score = new CriteriaScore();
                $criteria_score->criteria_score = $temp['value'];
                $criteria_score->criteria_detail_id = $criteria_detail->id;
                $criteria_score->save();
            }
        }
    }

    public function updateRubric($data)
    {
        Rubric::where('rubric.rubric_id', $data['rubric_id'])->update(['rubric.rubric_title' => $data['rubric_title']]);

        foreach ($data['delete_criteria'] as $value) {
            Criteria::where('criteria.criteria_id', "$value")->delete();
        }

        foreach ($data['edit_criterions'] as $value) {

            foreach ($value['delete_criteria_deteail'] as $temp) {
                CriteriaDetail::where('criteria_detail.criteria_detail_id', "$temp")->delete();
            }

            Criteria::where('criteria_id', $value['criteria_id'])->update(['criteria_name' => $value['criteria_name']]);
            foreach ($value['criteria_detail'] as $temp) {
                $criteria_score_id = $temp['criteria_detail_id'];
                CriteriaDetail::where('criteria_detail_id', $temp['criteria_detail_id'])
                    ->update(['criteria_detail' => $temp['name']]);
                CriteriaScore::where('criteria_score_id', $criteria_score_id)
                    ->update(['criteria_score' => $temp['value']]);
            }
        }

        foreach ($data['create_criterions'] as $value) {
            $criteria = new Criteria;
            $criteria->criteria_name = $value['criteria_name'];

            $criteria->rubric_id = $data['rubric_id'];
            $criteria->save();

            foreach ($value['criteria_detail'] as $temp) {
                $criteria_detail = new CriteriaDetail;
                $criteria_detail->criteria_detail = $temp['name'];
                $criteria_detail->criteria_id = $criteria->id;
                $criteria_detail->save();

                $criteria_score = new CriteriaScore();
                $criteria_score->criteria_score = $temp['value'];
                $criteria_score->criteria_detail_id = $criteria_detail->id;
                $criteria_score->save();
            }
        }
    }

    public function deleteRubric($rubric_id)
    {
        Rubric::where('rubric.rubric_id', $rubric_id)->delete();
    }

    public function getAllAssignment()
    {
        $assignments = Assignment::join('teachers', 'teachers.teacher_id', '=', 'assignments.teacher_id')->get();
        return $assignments;
    }

    public function getStudentAssignmentById($assignment_id, $student_id)
    {
        $assignment = Assignment::where('assignments.assignment_id', $assignment_id)->first();
        $teacher = Teacher::where('teacher_id', $assignment->teacher_id)->first();
        $attachment = Attachment::where('attachments.assignment_id', $assignment_id)->get();
        $response = ResponsibleAssignment::where('responsible_assignment.assignment_id', $assignment_id)->get();
        $rubric_id = $assignment->rubric_id;
        $rubric = Rubric::where('rubric.rubric_id', $rubric_id)
            ->join('criteria', 'criteria.rubric_id', '=', 'rubric.rubric_id')
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();;
        $feedback = Feedback::where('assignment_id', $assignment_id)->get();
        $student = Group::where('student_id', $student_id)->first();
        $project_id = $student->project_id;
        $status = StudentAssignment::where('project_id', $project_id)
            ->where('assignment_id', $assignment_id)->first();
        $file_assignment = SendAssignment::where('project_id', $project_id)
            ->where('assignment_id', $assignment_id)->get();
        $assesment = AssessmentAssignment::where('assignment_id', $assignment_id)
            ->where('project_id', $project_id)->get();

        $assignment->attachment = $attachment;
        $assignment->teacher = $teacher;
        $assignment->responsible_teacher = $response;
        $assignment->rubric = $rubric;
        $assignment->status = $status;
        $assignment->file_assignment = $file_assignment;
        $assignment->feedback = $feedback;
        $assignment->assessment = $assesment;

        return $assignment;
    }

    public function getAssignmentById($assignment_id)
    {
        $assignment = Assignment::where('assignment_id', $assignment_id)->first();
        $attachment = Attachment::where('assignment_id', $assignment_id)->get();
        $response = ResponsibleAssignment::where('assignment_id', $assignment_id)->get();

        $rubric_id = $assignment->rubric_id;
        $rubric = Rubric::where('rubric.rubric_id', $rubric_id)
            ->join('criteria', 'criteria.rubric_id', '=', 'rubric.rubric_id')
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();

        $assignment->attachment = $attachment;
        $assignment->criterion = $rubric;
        $assignment->resnponsible = $response;


        return $assignment;
    }

    public function getResponsibleAssignment($teacher_id)
    {
        $responsible = ResponsibleAssignment::where('responsible_assignment.responsible_teacher_id', $teacher_id)
            ->join('assignments', 'assignments.assignment_id', '=', 'responsible_assignment.assignment_id')
            ->join('teachers', 'teachers.teacher_id', '=', 'responsible_assignment.responsible_teacher_id')
            ->get();

        return $responsible;
    }

    public function getAllRubric()
    {
        $rubric = Rubric::all();
        return $rubric;
    }

    public function getRubricByID($rubric_id)
    {
        $rubric = Rubric::where('rubric.rubric_id', $rubric_id)->first();
        $criteria = Criteria::where('criteria.rubric_id', $rubric_id)
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();

        $rubric->criterions = $criteria;

        return $rubric;
    }

    public function addAttachment($data)
    {
        $assignment = Assignment::where('assignments.assignment_title', $data['assignment_title'])
            ->where('assignments.assignment_detail', $data['assignment_detail'])
            ->where('assignments.due_date', $data['due_date'])
            ->where('assignments.due_time', $data['due_time'])
            ->where('assignments.rubric_id', $data['rubric_id'])
            ->first();
        $assignment_id = $assignment->assignment_id;
        foreach ($data['attachment'] as $values) {
            if ($values) {
                $temp = $values->getClientOriginalName();
                $temp_name = pathinfo($temp, PATHINFO_FILENAME);
                $extension = pathinfo($temp, PATHINFO_EXTENSION);
                $custom_file_name = $temp_name . "_" . $this->incrementalHash() . ".$extension";
                $path = $values->storeAs('/attachments', $custom_file_name);
                $attachment = new Attachment();
                $attachment->attachment = $path;
                $attachment->attachment_name = $temp;
                $attachment->keep_file_name = $custom_file_name;
                $attachment->assignment_id = $assignment_id;
                $attachment->save();
            }
        }
    }

    public function getAllAttachment()
    {
        $attachment = Attachment::all();
        return $attachment;
    }

    public function getAttachmentByAssignmentID($assignment_id)
    {
        $attachment = Attachment::where('attachments.assignment_id', $assignment_id)->get();
        return $attachment;
    }

    public function deleteAttachment($data)
    {
        Attachment::where('attachments.attachment_id', $data['attachment_id'])->delete();
        unlink(storage_path('app/attachments/' . $data['attachment_name']));
    }


    public function sendAssignment($data)
    {
        $group = Group::where('student_id', $data['student_id'])->first();
        $project_id = $group->project_id;
        if ($data['send_file_assignment']) {
            foreach ($data['send_file_assignment'] as $values) {
                if ($values) {
                    $send_assignment = new SendAssignment;
                    $temp = $values->getClientOriginalName();
                    $assignment_id = $data['assignment_id'];
                    // $extension = pathinfo($temp, PATHINFO_EXTENSION);
                    $custom_file_name = $project_id . "_" . "$assignment_id" . "_" . "$temp";
                    $path = $values->storeAs('/send_assignment', $custom_file_name);
                    $send_assignment->send_assignment = $path;
                    $send_assignment->send_assignment_name = $custom_file_name;
                    $send_assignment->assignment_id = $data['assignment_id'];
                    $send_assignment->project_id = $project_id;
                    $send_assignment->save();
                }
            }
        }

        if ($data['delete_file_assignment']) {
            foreach ($data['delete_file_assignment'] as $values) {
                if ($values) {
                    $name = SendAssignment::where('send_assignment_id', $values)->first();
                    $send_assignment_name = $name->send_assignment_name;
                    SendAssignment::where('send_assignment_id', $values)->delete();
                    unlink(storage_path('app/send_assignment/' . $send_assignment_name));
                }
            }
        }

        $old_student_assignment = StudentAssignment::where('project_id', $project_id)
            ->where('assignment_id', $data['assignment_id'])->first();
        if ($old_student_assignment != null) {
            StudentAssignment::where('project_id', $project_id)
                ->where('assignment_id', $data['assignment_id'])
                ->update(['status' => $data['status']]);
        } else {
            $status = new StudentAssignment;
            $status->status = $data['status'];
            $status->assignment_id = $data['assignment_id'];
            $status->project_id = $project_id;
            $status->save();
        }
    }

    public function getSendAssignmentByTeacher($assignment_id, $teacher_id)
    {
        $permission = "No Permission";
        $responsible_teacher = ResponsibleAssignment::where('responsible_teacher_id', $teacher_id)
            ->where('assignment_id', $assignment_id)->first();

        if ($responsible_teacher != null) {
            $permission = "Have Permission";
        }

        $assignment = Assignment::where('assignment_id', $assignment_id)->first();
        $submisson = StudentAssignment::where('student_assignment.assignment_id', $assignment_id)
            ->join('projects', 'projects.project_id', '=', 'student_assignment.project_id')->get();

        $rubric_id = $assignment->rubric_id;
        $criteria = Criteria::where('criteria.rubric_id', $rubric_id)
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();

        $assignment->permission = $permission;
        $assignment->submission = $submisson;
        $assignment->criterions = $criteria;


        return $assignment;
    }

    public function getSendAssignment($assignment_id)
    {
        $assignment = Assignment::where('assignment_id', $assignment_id)->first();
        $submisson = StudentAssignment::where('student_assignment.assignment_id', $assignment_id)
            ->join('projects', 'projects.project_id', '=', 'student_assignment.project_id')->get();

        $rubric_id = $assignment->rubric_id;
        $criteria = Criteria::where('criteria.rubric_id', $rubric_id)
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();

        $assignment->submission = $submisson;
        $assignment->criterions = $criteria;


        return $assignment;
    }

    public function getSendAssignmentByProjecdId($assignment_id, $project_id)
    {
        $assignment = Assignment::where('assignment_id', $assignment_id)->first();

        $responsible_assignment = ResponsibleAssignment::where('assignment_id', $assignment_id)
            ->join('teachers', 'teachers.teacher_id', '=', 'responsible_assignment.responsible_teacher_id')->get();

        $submisson = StudentAssignment::where('student_assignment.assignment_id', $assignment_id)
            ->where('student_assignment.project_id', $project_id)
            ->join('projects', 'projects.project_id', '=', 'student_assignment.project_id')->first();

        $send_assignment = SendAssignment::where('assignment_id', $assignment_id)
            ->where('project_id', $project_id)->get();

        $rubric_id = $assignment->rubric_id;
        $criteria = Criteria::where('criteria.rubric_id', $rubric_id)
            ->join('criteria_detail', 'criteria_detail.criteria_id', '=', 'criteria.criteria_id')
            ->join('criteria_score', 'criteria_score.criteria_detail_id', '=', 'criteria_detail.criteria_detail_id')
            ->get();

        $assesment = AssessmentAssignment::where('assignment_id', $assignment_id)
            ->where('project_id', $project_id)->get();

        $feedback = Feedback::where('assignment_id', $assignment_id)
            ->where('feedback.project_id', $project_id)->get();

        $assignment->responsible_assignment = $responsible_assignment;
        $assignment->submission = $submisson;
        $assignment->send_assignment = $send_assignment;
        $assignment->criterions = $criteria;
        $assignment->assessment = $assesment;
        $assignment->feedback = $feedback;

        return $assignment;
    }

    public function createAssessment($data)
    {
        $criteria = Criteria::where('rubric_id', $data['rubric_id'])->get();

        $assignment = Assignment::where('assignment_id', $data['assignment_id'])->first();
        $rubric_id = $assignment->rubric_id;

        $check_assessment = AssessmentAssignment::where('assignment_id', $data['assignment_id'])
            ->where('project_id', $data['project_id'])
            ->where('responsible_assignment_id', $data['responsible_assignment'])->first();

        $num_of_criteria = count($criteria);

        $responsible_assignment = ResponsibleAssignment::where('id', $data['responsible_assignment'])->first();
        $teacher_id = $responsible_assignment->responsible_teacher_id;

        $num_of_responsible_assignment = count(ResponsibleAssignment::where('assignment_id', $data['assignment_id'])->get());

        if ($data['assessment']) {
            if ($num_of_criteria == count($data['assessment'])) {
                foreach ($data['assessment'] as $value) {
                    if ($check_assessment == null && $rubric_id == $data['rubric_id']) {
                        $assesment = new AssessmentAssignment;
                        $assesment->criteria_id = $value['criteria_id'];
                        $assesment->score = $value['score'];
                        $assesment->responsible_assignment_id = $data['responsible_assignment'];
                        $assesment->project_id = $data['project_id'];
                        $assesment->assignment_id = $data['assignment_id'];
                        $assesment->save();
                    } else {
                        AssessmentAssignment::where('assignment_id', $data['assignment_id'])
                            ->where('project_id', $data['project_id'])
                            ->where('criteria_id', $value['criteria_id'])
                            ->where('responsible_assignment_id', $data['responsible_assignment'])
                            ->update(['score' => $value['score']]);
                    }
                }
                //รวมคะแนน

                $total_num_assessment = $num_of_criteria * $num_of_responsible_assignment;
                $num_of_assessment = count(AssessmentAssignment::where('assignment_id', $data['assignment_id'])
                    ->where('project_id', $data['project_id'])->get());
                if ($total_num_assessment == $num_of_assessment) {
                    $get_assessment = AssessmentAssignment::where('assignment_id', $data['assignment_id'])
                        ->where('project_id', $data['project_id'])->sum('score');
                    StudentAssignment::where('assignment_id', $data['assignment_id'])
                        ->where('project_id', $data['project_id'])
                        ->update(['total_score' => $get_assessment / $num_of_responsible_assignment]);
                }

                //
                $old_feedback = Feedback::where('assignment_id', $data['assignment_id'])
                    ->where('project_id', $data['project_id'])
                    ->where('teacher_id', $teacher_id)->first();
                if ($old_feedback == null) {
                    $feedback = new Feedback;
                    $feedback->feedback_detail = $data['feedback'];
                    $feedback->project_id = $data['project_id'];
                    $feedback->assignment_id = $data['assignment_id'];
                    $feedback->teacher_id = $teacher_id;
                    $feedback->save();
                } else {
                    Feedback::where('assignment_id', $data['assignment_id'])
                        ->where('project_id', $data['project_id'])
                        ->where('teacher_id', $teacher_id)
                        ->update(['feedback.feedback_detail' => $data['feedback']]);
                }
            } else {
                return 'Num of Criteria is not math';
            }
        }
    }

    //Random ตัวอักษร
    public function incrementalHash($len = 5)
    {
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base) {
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -5);
    }


    //Test create attachment
    public function createAttachment($data)
    {
        foreach ($data['attachment'] as $key => $values) {
            $attachment = new Attachment();
            $temp = $values->getClientOriginalName();
            $extension = pathinfo($temp, PATHINFO_EXTENSION);
            $custom_file_name = $data['assignment_title'] . "_" . "$key" . ".$extension";
            $path = $values->storeAs('/attachments', $custom_file_name);
            $attachment->attachment = $path;
            $attachment->attachment_name = $custom_file_name;
            $attachment->save();
        }
    }
}
