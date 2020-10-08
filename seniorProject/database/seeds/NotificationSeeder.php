<?php

use Illuminate\Database\Seeder;
use App\Model\Notification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notifications = (array) array(
            [
                'notification_id' => '1',
                'notification_creater' => 'Siam Yamsaengsung',
                'notification_detail' => 'create assignment : Programing Clinic: Midterm',
                'assignment_id' => '1'
            ],
            [
                'notification_id' => '2',
                'notification_creater' => 'Siam Yamsaengsung',
                'notification_detail' => 'create assignment : Midterm กรรมการสอบ',
                'assignment_id' => '1'
            ],
            [
                'notification_id' => '3',
                'notification_creater' => 'Siam Yamsaengsung',
                'notification_detail' => 'create announcement : Programming Clinic รอบ 2 (พบครั้งละ 1 กลุ่ม กลุ่มละ 30 นาทีตามความสมัครใจ) เน้นคุยเรื่องการพัฒนาโปรแกรม',
                'announcement_id' => '1'
            ],
            [
                'notification_id' => '4',
                'notification_creater' => 'Pornthip Sirijutikul',
                'notification_detail' => 'create announcement : ตารางนัดประเมินงานคลีนิก SW Process (5-8 May 2020)',
                'announcement_id' => '2'
            ]
        );

        foreach ($notifications as $notification) {
            $temp_notification = new Notification;
            $temp_notification->notification_id = Arr::get($notification, 'notification_id');
            $temp_notification->notification_creater = Arr::get($notification, 'notification_creater');
            $temp_notification->notification_detail = Arr::get($notification, 'notification_detail');
            $temp_notification->assignment_id = Arr::get($notification, 'assignment_id');
            $temp_notification->announcement_id = Arr::get($notification, 'announcement_id');
            $temp_notification->save();
        }
    }
}
