<?php

namespace app\modules\mail\controllers;

use Yii;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\HttpException;

/**
 * Default controller for the `mail` module
 */
class DefaultController extends Controller
{
    public function actionIndex($id = 0)
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

        return $this->render('index', ['content' => json_decode($response->content, true), 'type' => $id]);
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

        return $this->render('compose', ['status' => $status, 'type' => 3]);
    }

    public function actionDetails($id)
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('http://api.va-afl.su/chat/default/detail?message_id')
            ->setData(
                [
                    'message_id' => $id
                ]
            )
            ->send();

        if ($response->statusCode != 200) {
            throw new HttpException(404);
        }

        return $this->render(
            'details',
            [
                'msg' => json_decode($response->content, true)['data'],
                'type' => 0,//TODO: Сделать проверку
            ]
        );
    }
}
