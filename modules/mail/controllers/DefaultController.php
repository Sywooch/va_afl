<?php

namespace app\modules\mail\controllers;

use Yii;
use yii\httpclient\Client;
use yii\web\Controller;

/**
 * Default controller for the `mail` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://api.va-afl.su/chat/default/list')
            ->setData(
                [
                    'vid' => Yii::$app->user->identity->vid
                ]
            )
            ->send();

        return $this->render('index', ['content' => json_decode($response->content, true)]);
    }

    public function actionCompose()
    {
        $status = 0;

        if (Yii::$app->request->post()) {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('post')
                ->setUrl('http://api.va-afl.su/chat/default/send')
                ->setData(
                    [
                        'from' => Yii::$app->user->identity->vid,
                        'text' => Yii::$app->request->post('text'),
                        'chat_topic' => Yii::$app->request->post('topic'),
                        'to' => Yii::$app->request->post('to'),
                        'chat_separated' => true
                    ]
                )
                ->send();

            $status = ($response->statusCode == 200 ? 2 : 1);
        }

        return $this->render('compose', ['status' => $status]);
    }

    public function actionList()
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://api.va-afl.su/chat/default/list')
            ->setData(
                [
                    'vid' => Yii::$app->user->identity->vid
                ]
            )
            ->send();

        return $this->render(
            'index',
            [
                'content' => $response->content
            ]
        );
    }

    public function actionDetail()
    {
        return $this->render('detail');
    }
}
