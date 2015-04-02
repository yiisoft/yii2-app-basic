<?php

use yii\db\Schema;
use yii\db\Migration;
use callmez\wechat\models\Wechat;
use callmez\wechat\models\Rule;
use callmez\wechat\models\RuleKeyword;

class m150402_051920_initWechatData extends Migration
{

    public function safeUp()
    {
        $wechat = new Wechat;
        $wechat->setAttributes([
            'name' => '示例公众号',
            'hash' => 'shili',
            'token' => 'lL2hcT4c41H3wL21Hlftlz4A4w22j12L',
            'account' => 'example',
            'original' => 'gh_example12345',
            'type' => Wechat::TYPE_SUBSCRIBE,
            'app_id' => 'wxd8cce40cc50ce6c7',
            'app_secret' => '8e850dfed1befa106ea0bbe7cb67ad25',
            'encoding_type' => Wechat::ENCODING_COMPATIBLE,
            'encoding_aes_key' => '8J4In8J3R3ppqWgQkCXhOvU1ZxaPFa5eSDZ8u3XNy45',
            'avatar' => 'example_avatar.png',
            'qr_code' => 'example_qr_code.png',
            'address' => '测试地址',
            'description' => '该条记录并不是真实的公众号记录.只作为本地测试示例使用',
            'username' => 'example@qq.com',
            'password' => 'example',
            'status' => Wechat::STATUS_ACTIVE,
        ]);
        echo "\nexample测试示例公众号数据创建" . ($wechat->save() ? '成功' : '失败') ."\n";

        $rule = new Rule;
        $rule->setAttributes([
            'wid' => $wechat->id,
            'name' => '示例规则',
            'module' => 'example',
            'status' => Rule::STATUS_ACTIVE,
        ]);
        echo "\nexample示例规则数据创建" . ($rule->save() ? '成功' : '失败') ."\n";

        $ruleKeyword = new RuleKeyword;
        $ruleKeyword->setAttributes([
            'rid' => $rule->id,
            'keyword' => 'example',
            'type' => RuleKeyword::TYPE_MATCH
        ]);
        echo "\nexample示例规则关键字数据创建" . ($ruleKeyword->save() ? '成功' : '失败') ."\n";
    }
    
    public function safeDown()
    {

    }
}
