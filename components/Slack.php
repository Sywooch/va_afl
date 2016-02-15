<?php
/**
 * Created by PhpStorm.
 * User: Nikita Fedoseev
 * Date: 15.02.16
 * Time: 13:58
 */

namespace app\components;

use Yii;

class Slack
{
    private $template = '{"channel": "[channel]", "username": "[username]", "text" : "[text]"}';

    private $channel;
    private $username;
    private $text;

    public function __construct($channel = '#general', $msg = '', $username = 'web')
    {
        $this->channel = $channel;
        $this->text = $msg;
        $this->username = $username;
    }

    public function addLink($link, $name = ''){
        $this->text .= "<$link".($name != '' ? "|$name" : '').'>';
    }

    public function addText($text){
        $this->text .= $text;
    }

    public function sent(){
        $request = str_replace("[channel]", $this->channel, $this->template);
        $request = str_replace("[username]", $this->username, $request);
        $request = str_replace("[text]", $this->text, $request);

        Post::sent(Yii::$app->params['slack'], ['payload' => $request]);
    }
} 