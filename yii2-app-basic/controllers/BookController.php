<?php

namespace app\controllers;

use app\models\Book;
use app\repositories\AuthorRepository;
use app\repositories\BookRepository;
use app\requests\BookRequest;
use app\services\BookService;
use app\services\FileService;
use app\services\SubscriptionService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class BookController extends Controller
{
    private $bookRepository;
    private $authorRepository;
    private $bookService;
    private $fileService;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id , $module, $config);
        $this->bookRepository = new BookRepository();
        $this->authorRepository = new AuthorRepository();
        $this->fileService = new FileService();
        $this->bookService = new BookService(
            $this->bookRepository,
            $this->authorRepository,
            Yii::createObject(SubscriptionService::class),
            $this->fileService
        );
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $books = $this->bookRepository->findAll()->all();
        return $this->render('index', ['books' => $books]);
    }

    public function actionView($id)
    {
        $book = $this->findModel($id);
        return $this->render('view', ['model' => $book]);
    }

    public function actionCreate()
    {
        $book = new Book();
        $request = new BookRequest();

        if ($request->load(Yii::$app->request->post())) {
            $request->cover_photo_file = UploadedFile::getInstance($request, 'cover_photo_file');
            
            if ($request->validate()) {
                $authorIds = (array)$request->authors;
                $coverFile = $request->cover_photo_file;

                if ($this->bookService->create($book, $authorIds, $coverFile, $request)) {
                    return $this->redirect(['view', 'id' => $book->id]);
                }
            }
        }

        $authors = $this->authorRepository->findAll()->all();
        return $this->render('create', [
            'model' => $book,
            'request' => $request,
            'authors' => $authors,
        ]);
    }

    public function actionUpdate($id)
    {
        $book = $this->findModel($id);
        $request = new BookRequest();
        $request->loadFromBook($book);

        if ($request->load(Yii::$app->request->post())) {
            $request->cover_photo_file = UploadedFile::getInstance($request, 'cover_photo_file');
            
            if ($request->validate()) {
                $authorIds = (array)$request->authors;
                $coverFile = $request->cover_photo_file;

                if ($this->bookService->update($book, $authorIds, $coverFile)) {
                    return $this->redirect(['view', 'id' => $book->id]);
                }
            }
        }

        $authors = $this->authorRepository->findAll()->all();
        return $this->render('update', [
            'model' => $book,
            'request' => $request,
            'authors' => $authors,
        ]);
    }

    public function actionDelete($id)
    {
        $book = $this->findModel($id);
        $this->bookService->delete($book);
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $book = $this->bookRepository->findById($id);
        if ($book === null) {
            throw new NotFoundHttpException('Книга не найдена.');
        }
        return $book;
    }
}
