<?php

namespace app\controllers;

use app\models\Author;
use app\repositories\AuthorRepository;
use app\requests\AuthorRequest;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class AuthorController extends Controller
{
    private $authorRepository;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authorRepository = new AuthorRepository();
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
        $authors = $this->authorRepository->findAll()->all();
        return $this->render('index', ['authors' => $authors]);
    }

    public function actionView($id)
    {
        $author = $this->findModel($id);
        return $this->render('view', ['model' => $author]);
    }

    public function actionCreate()
    {
        $author = new Author();
        $request = new AuthorRequest();

        if ($request->load(Yii::$app->request->post()) && $request->validate()) {
            $request->fillAuthor($author);
            
            if ($this->authorRepository->save($author)) {
                return $this->redirect(['view', 'id' => $author->id]);
            }
        }

        return $this->render('create', [
            'model' => $author,
            'request' => $request,
        ]);
    }

    public function actionUpdate($id)
    {
        $author = $this->findModel($id);
        $request = new AuthorRequest();
        $request->loadFromAuthor($author);

        if ($request->load(Yii::$app->request->post()) && $request->validate()) {
            $request->fillAuthor($author);
            
            if ($this->authorRepository->save($author)) {
                return $this->redirect(['view', 'id' => $author->id]);
            }
        }

        return $this->render('update', [
            'model' => $author,
            'request' => $request,
        ]);
    }

    public function actionDelete($id)
    {
        $author = $this->findModel($id);
        $this->authorRepository->delete($author);
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $author = $this->authorRepository->findById($id);
        if ($author === null) {
            throw new NotFoundHttpException('Автор не найден.');
        }
        return $author;
    }
}
