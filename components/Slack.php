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
    private $template = '{"channel": "[channel]", "username": "[username]", "text" : "[text]", "attachments" : [[attachments]] }';

    private $channel;
    private $username;
    private $text;
    private $attachments;

    public function __construct($channel = '#general', $msg = '', $username = 'web', $attachments = '')
    {
        $this->channel = $channel;
        $this->text = $msg;
        $this->username = $username;
        $this->attachments = $attachments;
    }

    public function addLink($link, $name = ''){
        $this->text .= "<$link".($name != '' ? "|$name" : '').'>';
    }

    public function addText($text){
        $this->text .= $text;
    }

    public function addAttachments($text){
        $this->attachments = $text;
    }

    public function sent(){
        $request = str_replace("[channel]", $this->channel, $this->template);
        $request = str_replace("[username]", $this->username, $request);
        $request = str_replace("[text]", $this->text, $request);
        $request = str_replace("[attachments]", $this->attachments, $request);
        Yii::trace($request);

        Post::sent(Yii::$app->params['slack'], ['payload' => $request]);
    }
} 