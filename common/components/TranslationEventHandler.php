<?php

namespace common\components;

use common\models\Message;
use common\models\SourceMessage;

class TranslationEventHandler
{
    /**
     * @param \yii\i18n\MissingTranslationEvent $event
     */
    public static function missingTranslation($event)
    {
        //http://fanyi.baidu.com/v2transapi?from=zh&query=世界&to=en
        // 当语言没命中的时候用百度翻译并保存到数据库
        $model = SourceMessage::find()->where(['category' => $event->category, 'message' => $event->message])->one();
        if ($model == null) {
            $model = new SourceMessage();
            $model->category = $event->category;
            $model->message = $event->message;
            $model->save();
        }
        $messageModel = Message::find()->where(['id' => $model->id, 'language' => $event->language])->one();
        if ($messageModel == null) {
            $messageModel = new Message();
            $messageModel->language = $event->language;
            $messageModel->id = $model->id;
            $messageModel->translation = self::translate($event->message, 'en', self::parseLanguage($event->language));
            $messageModel->save();
        }
        $event->translatedMessage = $messageModel->translation;
    }

    public static function parseLanguage($language)
    {
        // 参考百度翻译api自己添加其他语言的map（yii - baidu）
        $languageMap = [
            'zh-CN' => 'zh'
        ];
        return $languageMap[$language];
    }

    //百度翻译
    public static function translate($text, $from , $to)
    {
        $url = "http://fanyi.baidu.com/v2transapi";
        $data = array (
            'from' => $from,
            'to' => $to,
            'query' => $text
        );
        $data = http_build_query($data);
        $ch = curl_init ();
        curl_setopt ($ch, CURLOPT_URL, $url );
        curl_setopt ($ch, CURLOPT_REFERER, "http://fanyi.baidu.com" );
        curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; rv:37.0) Gecko/20100101 Firefox/37.0' );
        curl_setopt ($ch, CURLOPT_HEADER, 0 );
        curl_setopt ($ch, CURLOPT_POST, 1 );
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $data );
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ($ch, CURLOPT_TIMEOUT, 10 );
        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, true);

        if (!isset($result['trans_result']['data']['0']['dst'])){
            return false;
        }
        return $result['trans_result']['data']['0']['dst'];
    }
}