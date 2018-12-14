# MW-LinkHelper
A Referrer blocking solution for Mediawiki

## Install
* Clone the respository, rename it to LinkHelper and copy to extensions folder
* Add `wfLoadExtension('LinkHelper');` to your LocalSettings.php

## Configuration
* `$wgLinkHelperInterwikiWhitelist`: an array holding the interwikis to make interwiki links not be armored.
