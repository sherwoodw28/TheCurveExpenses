<?php
    require(dirname(__FILE__).'/../private/kernel.php');
    $website = new Website;
    $website->loadPage($website->getWholeSlug());