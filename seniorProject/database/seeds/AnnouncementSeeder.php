<?php

use Illuminate\Database\Seeder;
use App\Model\Announcement;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $announcements = (array) array(
            [
                'announcement_id' => '1',
                'announcement_title' => 'Programming Clinic รอบ 2 (พบครั้งละ 1 กลุ่ม กลุ่มละ 30 นาทีตามความสมัครใจ) เน้นคุยเรื่องการพัฒนาโปรแกรม',
                'announcement_detail' => 'วันที่ 15 และ 17 เมย. 2563 ',
                'announcement_date' => '2020-7-10',
                'teacher_id' => '1',
            ],
            [
                'announcement_id' => '2',
                'announcement_title' => 'ตารางนัดประเมินงานคลีนิก SW Process (5-8 May 2020)',
                'announcement_detail' => 'ตารางนัดประเมินงานคลีนิก SW Process (5-8 May 2020)
                การนัดคุยครั้งนี้ จะคุยกันโดยใช้ Microsoft team กลุ่ม INT206 ใน Channel ของกลุ่มโปรเจค ให้สมาชิกในทีม join meeting ที่อ.สร้างไว้ใน channel ตามเวลานัด อ.อาจจะเลท 1-25 นาที (จากการคุยกับกลุ่มก่อนหน้า)
                ให้ทีมเตรียมเอกสาร/หลักฐาน การดำเนินงานในโปรเจคจบที่เกี่ยวข้องกับ SW Process Clinic ที่มี เช่น
                การเก็บข้อมูล (เช่น แบบสอบถาม)
                การวางแผน (release plan, sprint plan)
                เครื่องมือที่ใช้ในการจัดการ
                การทดสอบ (acceptance criteria, test cases)
                หากไม่สามารถเข้าคุยตามนัดได้ ให้แจ้งอาจารย์ล่วงหน้าเพื่อสลับกลุ่ม/ย้ายเวลา',
                'announcement_date' => '2020-7-10',
                'aa_id' => '11',
            ]
        );

        foreach ($announcements as $announcement) {
            $temp_announcement = new Announcement;
            $temp_announcement->announcement_id = Arr::get($announcement, 'announcement_id');
            $temp_announcement->announcement_title = Arr::get($announcement, 'announcement_title');
            $temp_announcement->announcement_detail = Arr::get($announcement, 'announcement_detail');
            $temp_announcement->announcement_date = Arr::get($announcement, 'announcement_date');
            $temp_announcement->teacher_id = Arr::get($announcement, 'teacher_id');
            $temp_announcement->aa_id = Arr::get($announcement, 'aa_id');
            $temp_announcement->save();
        }
    }
}
