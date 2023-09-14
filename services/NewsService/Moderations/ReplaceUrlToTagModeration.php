<?php

declare(strict_types=1);

namespace app\services\NewsService\Moderations;

use app\services\NewsService\DTO\NewsRequestTransfer;

class ReplaceUrlToTagModeration implements NewsModerationInterface
{
    /**
     * @param NewsRequestTransfer $requestTransfer
     * @return void
     */
    public function handle(NewsRequestTransfer $requestTransfer): void
    {
        $requestTransfer->setTitle($this->replaceUrl($requestTransfer->getTitle()));
        $requestTransfer->setDescription($this->replaceUrl($requestTransfer->getDescription()));
        $requestTransfer->setText($this->replaceUrl($requestTransfer->getText()));
    }

    /**
     * @param string $text
     * @return string
     */
    function replaceUrl(string $text): string
    {
        $text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
        $ret = ' ' . $text;
        $ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
        $ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\" rel=\"nofollow\">\\2</a>", $ret);
        $ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);

        return substr($ret, 1);
    }
}