<?php
/**
 * Created by PhpStorm.
 * User: nfedoseev
 * Date: 27.08.2016
 * Time: 10:06
 */

namespace app\components\internal\api\chat;


use Yii;
use yii\httpclient\Client;

class NewCounter
{
    public static function get(){
        try{
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl('http://api.va-afl.su/chat/default/new')
                ->setData(
                    [
                        'vid' => Yii::$app->user->identity->vid
                    ]
                )
                ->send();
            if($response->content){
                $data = json_decode($response->content);
                if($data->data->new){
                    return (int) $data->data->new;
                }
            }

            return 0;
        }catch(\Exception $ex){
            return 0;
        }
    }
}