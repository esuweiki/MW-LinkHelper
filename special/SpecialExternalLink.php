<?php
namespace LinkHelper;

class SpecialExternalLink extends \UnlistedSpecialPage {

    private $query = array();

    public function __construct() {
        parent::__construct('ExternalLink');
    }

    private static function getMainUrl() {
        $mainPage = \Title::newMainPage();
        return $mainPage->getLinkURL();
    }

    public function execute($par) {
        // must-call
        $this->setHeaders();

        $target = $this->getRequest()->getVal("target", "");
        if ($target) {
            $this->getOutput()->redirect($target, '301');
        } else {
            $this->getOutput()->redirect($this->getMainUrl(), '302');
        }
    }
}
