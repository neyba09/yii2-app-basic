<?php

namespace app\controllers;

use app\models\Subscription;
use app\repositories\AuthorRepository;
use app\requests\SubscriptionRequest;
use app\services\SubscriptionService;
use Yii;
use yii\web\Controller;

class SubscriptionController extends Controller
{
    private SubscriptionService $subscriptionService;
    private AuthorRepository $authorRepository;

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->subscriptionService = new SubscriptionService(new \app\repositories\SubscriptionRepository());
        $this->authorRepository = new AuthorRepository();
    }

    public function actionCreate()
    {
        $subscription = new Subscription();
        $request = new SubscriptionRequest();

        if ($request->load(Yii::$app->request->post()) && $request->validate()) {
            $request->fillSubscription($subscription);

            if ($this->subscriptionService->createSubscription($subscription)) {
                Yii::$app->session->setFlash('success', 'Вы успешно подписались!');

                return $this->redirect(['site/index']);
            }
        }

        $authors = $this->authorRepository->findAll()->all();
        return $this->render('create', [
            'model' => $subscription,
            'request' => $request,
            'authors' => $authors,
        ]);
    }
}
