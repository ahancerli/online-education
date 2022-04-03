<?php
/**
 * Created by PhpStorm.
 * User: gokhandemirer
 * Date: 6.09.2020
 * Time: 19:25
 */

namespace App\Controllers\Front;


use App\Models\CourseModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;
use Config\Database;

class CourseController extends Controller
{
    public function __construct()
    {
        helper('auth');
    }

    public function index($slug)
    {
        $courseModel = new CourseModel();
        $course = $courseModel
            ->join('users', 'users.id = courses.user_id')
            ->join('enrollments', 'enrollments.course_id = courses.id', 'LEFT')
            ->join('ratings', 'ratings.course_id = courses.id', 'LEFT')
            ->where('courses.slug', $slug)
            ->groupBy('courses.id')
            ->select('courses.*, users.name AS instructor_name, users.description AS instructor_description, 
            users.profile_image AS instructor_image, users.title AS instructor_title, COUNT(enrollments.id) AS student_count,
            COUNT(ratings.point) AS rating_count')
            ->selectAvg('ratings.point', 'avg_point')
            ->first();

        if (!$course)
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $sections = model('SectionModel')->where('course_id', $course['id'])->orderBy('id', 'ASC')->findAll();
        $lessons = model('LessonModel')->where('course_id', $course['id'])->where('status', true)->findAll();

        $enrolled = $this->checkEnrolled($course['id']);

        $db = Database::connect();

        $relatedCourses = [];

        $categoryId = $db
            ->table('course_category')
            ->where('course_id', $course['id'])
            ->select('category_id')
            ->get()
            ->getResultArray();

        $categoryId = array_map(function ($item) {
            return intval($item['category_id']);
        }, $categoryId);

        $comments = model('CommentModel')
            ->select('comments.comment AS comment, comments.created_at AS created_at, ratings.point AS point, 
            users.name AS user_name, users.profile_image AS profile_image')
            ->join('users', 'users.id = comments.user_id')
            ->join('ratings', 'ratings.comment_id = comments.id')
            ->where('comments.course_id', $course['id'])
            ;

        $commentCount = $comments->countAllResults(false);

        $commentLimit = $this->request->getGet('comment_limit') ?? 5;

        $comments = $comments->findAll($commentLimit, 0);

        $comments = array_map(function ($comment) {
            $comment['created_at'] = Time::parse($comment['created_at'], 'Europe/Istanbul', 'tr_TR')->toFormattedDateString();
            return $comment;
        }, $comments);

        $instructorCourses = $courseModel->where('user_id', $course['user_id'])->countAllResults();

        $ratingPercent = model('RatingModel')
            ->select('point, COUNT(*) AS count')
            ->where('course_id', $course['id'])
            ->groupBy('point')
            ->findAll();

        $totalRatingCount = array_sum(array_column($ratingPercent, 'count'));

        foreach ($ratingPercent as $key => $value) {
            $ratingPercent[$value['point']] = round($value['count'] / $totalRatingCount * 100);
            unset($ratingPercent[$key]);
        }

        if (count($categoryId) > 0) {
            $relatedCourses = $courseModel
                ->join('users', 'users.id = courses.user_id')
                ->join('course_category', 'course_category.course_id = courses.id', 'LEFT')
                ->join('comments', 'comments.course_id = courses.id', 'LEFT')
                ->groupBy('courses.id')
                ->select('courses.*, users.name AS instructor_name, course_category.category_id, COUNT(comments.id) AS comment_count')
                ->where('courses.id !=', $course['id'])
                ->whereIn('course_category.category_id', $categoryId)
                ->findAll(4, 0);
        }

        $pageTitle = $course['title'];

        return view('front/course/index', compact(
            'course', 'sections', 'lessons', 'comments', 'relatedCourses', 'instructorCourses', 'enrolled', 'ratingPercent', 'commentCount', 'pageTitle'
        ));
    }

    public function showPlayer($courseSlug, $vimeoId)
    {
        $courseModel = new CourseModel();
        $course = $courseModel->where('slug', $courseSlug)->first();

        if (!$course)
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $lessonModel = model('LessonModel');

        $currentLesson = $lessonModel
            ->where('course_id', $course['id'])
            ->where('vimeo_id', $vimeoId)
            ->where('status', true)
            ->first();

        if (!$currentLesson)
            return redirect()->to('/');

        $enrolled = $this->checkEnrolled($course['id']);

        if (!$enrolled)
            return redirect()->to('/');

        $sections = model('SectionModel')
            ->where('course_id', $course['id'])
            ->orderBy('id', 'ASC')
            ->findAll();

        $lessons = model('LessonModel')
            ->select('lessons.*')
            ->selectCount('lesson_watching.id', 'watched')
            ->join('lesson_watching', 'lesson_watching.lesson_id = lessons.id', 'LEFT')
            ->where('lessons.course_id', $course['id'])
            ->where('lessons.status', true)
            ->groupBy('lessons.id')
            ->findAll();

        foreach ($lessons as $lesson) {
            if ($lesson['id'] == $currentLesson['id']) {
                $currentLesson['watched'] = $lesson['watched'];
                break;
            }
        }

        $db = \Config\Database::connect();
        $builder = $db->table('lesson_watching');

        $watchedLessonCount = $builder
            ->where('course_id', $course['id'])
            ->where('user_id', user_id())
            ->countAllResults();

        return view('front/course/player', compact('course', 'sections', 'currentLesson', 'lessons', 'enrolled', 'watchedLessonCount'));
    }

    public function addComment()
    {
        $rules = [
            'course_id' => 'required|numeric',
            'comment' => 'required',
            'point' => 'numeric'
        ];

        if (!$this->validate($rules))
            return $this->response->setJSON([
                'errors' => $this->validator->getErrors()
            ])->setStatusCode(422);

        $postData = $this->request->getPost();

        $enrolled = $this->checkEnrolled($postData['course_id']);

        if (!$enrolled)
            return $this->response->setJSON([
                'message' => 'No authority.'
            ])->setStatusCode(403);

        $postData['user_id'] = user_id();
        $commentId = model('CommentModel')->insert($postData);

        model('RatingModel')->insert([
            'course_id' => $postData['course_id'],
            'comment_id' => $commentId,
            'user_id' => $postData['user_id'],
            'point' => $postData['point'] ?? 0,
        ]);

        return $this->response->setJSON([
            'message' => 'Değerlendirmeniz için teşekkür ederiz. Onaylandıktan sonra görüntülenecektir.'
        ])->setStatusCode(200);
    }

    public function completeCourse($courseId)
    {
        if (! $this->checkEnrolled($courseId))
            return $this->response->setJSON([
                'message' => 'Forbidden'
            ])->setStatusCode(403);

        $lessonCount = model('LessonModel')->where('course_id', $courseId)->countAllResults();

        $db = \Config\Database::connect();
        $builder = $db->table('lesson_watching');

        $watchedLessonCount = $builder
            ->where('course_id', $courseId)
            ->where('user_id', user_id())
            ->countAllResults();

        if ($lessonCount != $watchedLessonCount)
            return $this->response->setJSON([
                'message' => 'Kursu tamamlayabilmeniz için tüm dersleri izlemeniz gerekiyor'
            ])->setStatusCode(403);

        $certificateModel = model('CertificateModel');

        $certificate = $certificateModel->where('user_id', user_id())->where('course_id', $courseId)->first();

        if ($certificate)
            return $this->response->setJSON([
                'message' => 'Kursu daha önce tamamlandınız'
            ])->setStatusCode(403);

        $certificateModel->insert([
            'user_id' => user_id(),
            'course_id' => $courseId
        ]);

        return $this->response->setJSON([
            'message' => 'Kursu başarıyla tamamladınız ve sertifika almaya hak kazandınız. Sertifikanız onaylandıktan sonra e-postanıza gönderilecektir.'
        ])->setStatusCode(200);
    }

    private function checkEnrolled($courseId)
    {
        $enrolled = false;

        if (logged_in()) {
            $enrollment = model('EnrollmentModel')->where('user_id', user_id())->where('course_id', $courseId)->first();
            if ($enrollment)
                $enrolled = true;
        }

        return $enrolled;
    }
}