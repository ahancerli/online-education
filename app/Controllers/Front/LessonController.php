<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 18.09.2020
 * Time: 12:30
 */

namespace App\Controllers\Front;


use CodeIgniter\Controller;

class LessonController extends Controller
{
    public function markAsWatched($lessonId)
    {
        $lesson = model('LessonModel')->find($lessonId);

        if (! $lesson)
            return $this->response->setJSON([
                'message' => 'Not Found'
            ])->setStatusCode(404);

        $enrollment = model('EnrollmentModel')
            ->where('course_id', $lesson['course_id'])
            ->where('user_id', user_id())
            ->first();

        if (! $enrollment)
            return $this->response->setJSON([
                'message' => 'Forbidden'
            ])->setStatusCode(403);

        $db = \Config\Database::connect();
        $builder = $db->table('lesson_watching');

        $builder->insert([
            'user_id' => user_id(),
            'lesson_id' => $lesson['id'],
            'course_id' => $lesson['course_id']
        ]);

        return $this->response->setJSON([
            'message' => 'İşlem başarılı!'
        ])->setStatusCode(200);

    }

    public function markAsUnwatched($lessonId)
    {
        $lesson = model('LessonModel')->find($lessonId);

        if (! $lesson)
            return $this->response->setJSON([
                'message' => 'Not Found'
            ])->setStatusCode(404);

        $enrollment = model('EnrollmentModel')
            ->where('course_id', $lesson['course_id'])
            ->where('user_id', user_id())
            ->first();

        if (! $enrollment)
            return $this->response->setJSON([
                'message' => 'Forbidden'
            ])->setStatusCode(403);

        $db = \Config\Database::connect();
        $builder = $db->table('lesson_watching');
        $builder->delete([
            'lesson_id' => $lessonId,
            'user_id' => user_id()
        ]);

        return $this->response->setJSON([
            'message' => 'İşlem başarılı!'
        ])->setStatusCode(200);
    }
}