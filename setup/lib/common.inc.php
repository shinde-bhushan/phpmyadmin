<?php
/**
 * Loads libraries/common.inc.php and preforms some additional actions
 */

declare(strict_types=1);

use PhpMyAdmin\Config\ConfigFile;
use PhpMyAdmin\DatabaseInterface;

chdir('..');

if (! file_exists(ROOT_PATH . 'libraries/common.inc.php')) {
    die('Bad invocation!');
}

$isMinimumCommon = true;

require_once ROOT_PATH . 'libraries/common.inc.php';

// use default error handler
restore_error_handler();

// Save current language in a cookie, required since we set $isMinimumCommon
$GLOBALS['config']->setCookie('pma_lang', (string) $GLOBALS['lang']);
$GLOBALS['config']->set('is_setup', true);

$GLOBALS['ConfigFile'] = new ConfigFile();
$GLOBALS['ConfigFile']->setPersistKeys(
    [
        'DefaultLang',
        'ServerDefault',
        'UploadDir',
        'SaveDir',
        'Servers/1/verbose',
        'Servers/1/host',
        'Servers/1/port',
        'Servers/1/socket',
        'Servers/1/auth_type',
        'Servers/1/user',
        'Servers/1/password',
    ]
);

$GLOBALS['dbi'] = DatabaseInterface::load();

// allows for redirection even after sending some data
ob_start();
