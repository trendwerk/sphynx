<?php
namespace Trendwerk\TrendPress;

use Timber\Timber;

$timber = new Timber();
Timber::$dirname = array('templates/base', 'templates');

$theme = new Theme();
$theme->init();
