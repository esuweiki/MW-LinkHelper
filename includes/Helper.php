<?php
namespace LinkHelper;

class Helper {
    public static function armorLink($link) {
        $specialPage = \SpecialPage::getTitleFor('ExternalLink');
        $result = $specialPage->getLinkURL("target=$link");

        return $result;
    }
}
