<?php

namespace App\Http\Controllers;

use App\Repositories\AnnouncementRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;


class AnnouncementController extends Controller
{
    private $announcement;

    public function __construct(AnnouncementRepositoryInterface $announcement)

    {
        $this->announcement = $announcement;
    }

    public function storeAnnoucement(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'announcement_title' => 'required',
            'announcement_detail' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();


        if ($data['teacher_id']) {

            $this->announcement->createAnnouncement($data);

            $has_attachment = Arr::get($data, 'attachment');
            if ($has_attachment) {
                $this->announcement->addAttachment($data);
            }
            return response()->json('สำเร็จ', 200);
        } else if ($data['aa_id']) {
            $this->announcement->createAnnouncement($data);

            $has_attachment = Arr::get($data, 'attachment');
            if ($has_attachment) {
                $this->announcement->addAttachment($data);
            }
            return response()->json('สำเร็จ', 200);
        } else {
            return response()->json('Have to teacher_id or aa_id only one!!', 500);
        }
    }

    public function editAnnoucement(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'announcement_id' => 'required',
            'announcement_title' => 'required',
            'announcement_detail' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();

        $this->announcement->editAnnoucement($data);

        $has_attachment = Arr::get($data, 'attachment');
        if ($has_attachment) {
            $this->announcement->addAttachment($data);
        }

        return response()->json('สำเร็จ', 200);
    }

    public function deleteAnnoucement(Request $request)
    {
        $messages = [
            'required' => 'The :attribute field is required.',
        ];

        //ตรวจสอบข้อมูล
        $validator =  Validator::make($request->all(), [
            'announcement_id' => 'required'
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 500);
        }

        $data = $request->all();
        $this->announcement->deleteAnnoucement($data);
        return response()->json('สำเร็จ', 200);
    }

    public function indexAllAnnoucement()
    {
        $announcement = $this->announcement->getAllAnnouncement();
        return response()->json($announcement, 200);
    }

    public function indexAnnoucement($announcement_id)
    {
        $announcement = $this->announcement->getAnnouncement($announcement_id);
        return response()->json($announcement, 200);
    }
}
