<?php

namespace app\controllers;

use app\repositories\AuthorRepository;
use yii\web\Controller;

class ReportController extends Controller
{
    private $authorRepository;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->authorRepository = new AuthorRepository();
    }

    public function actionTopAuthors($year = null)
    {
        if ($year === null) {
            $year = date('Y');
        }

        $authors = $this->authorRepository->findTopByYear($year, 10);

        return $this->render('top-authors', [
            'authors' => $authors,
            'year' => $year,
        ]);
    }
}
