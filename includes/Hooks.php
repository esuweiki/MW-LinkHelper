<?php

namespace LinkHelper;

class Hooks {
    /**
     *
     * Used when generating internal and interwiki links in LinkRenderer, just before the function returns a value.
     *
     * @param \MediaWiki\Linker\LinkRenderer $linkRenderer : the LinkRenderer object
     * @param \MediaWiki\Linker\LinkTarget $target : the LinkTarget that the link is pointing to
     * @param $isKnown : boolean indicating whether the page is known or not
     * @param $text : the contents that the <a> tag should have; either a plain, unescaped string or a HtmlArmor object.
     * @param $attribs : the final HTML attributes of the <a> tag, after processing, in associative array form.
     * @param $ret : the value to return if your hook returns false.
     *
     * @return bool
     *
     * If you return true, an <a> element with HTML attributes $attribs and contents $html will be returned.
     * If you return false, $ret will be returned.
     */
    public static function onHtmlPageLinkRendererEnd(\MediaWiki\Linker\LinkRenderer $linkRenderer,
                                                     \MediaWiki\Linker\LinkTarget $target,
                                                     $isKnown, &$text, &$attribs, &$ret) {
        if ( !$target->isExternal() ) {
            // local link
            return true;
        }

        $config = \MediaWiki\MediaWikiServices::getInstance()->getInstance()->getMainConfig();
        $whitelist = $config->get( 'LinkHelperInterwikiWhitelist' );
        if ( in_array($target->getInterwiki(), $whitelist) ) {
            // in interwiki whitelist
            return true;
        }

        $url = Helper::armorLink($target->getLinkURL());

        $attribs['href'] = $url;
        $ret = \Html::rawElement('a', $attribs, \HtmlArmor::getHtml($text));

        return false;
    }

    /**
     *
     * Called before the HTML for external links is returned, used for modifying external link HTML
     *
     * @param $url : The URL of the external link
     * @param $text : The link text that would normally be displayed on the page
     * @param $link : The link HTML if you choose to override the default.
     * @param $attribs : Link attributes (added in MediaWiki 1.15, r48223)
     * @param $linktype : Type of external link, e.g. 'free', 'text', 'autonumber'. Gets added to the css classes.
     *
     * @return bool
     *
     * You need to return false if you want to modify the HTML of external links,
     * returning true will produce the normal external link HTML, regardless of if $link is set to something.
     *
     * Please note that you will need to include all parts of the HTML in $link,
     * including the <a> tag, if you choose to return false.
     *
     */
    public static function onLinkerMakeExternalLink(&$url, &$text, &$link, &$attribs, $linktype) {
        $url = Helper::armorLink($url);

        return true;
    }

}
