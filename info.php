<?php

/**
 * libGitHubAPI
 *
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Ralf Hertsch <ralf.hertsch@phpmanufaktur.de>
 * @link https://addons.phpmanufaktur.de/de/addons/libgithubapi.php
 * @copyright 2012 phpManufaktur by Ralf Hertsch
 * @license MIT License (MIT) http://www.opensource.org/licenses/MIT
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('WB_PATH')) {
    if (defined('LEPTON_VERSION')) include(WB_PATH.'/framework/class.secure.php');
} else {
    $oneback = "../";
    $root = $oneback;
    $level = 1;
    while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
        $root .= $oneback;
        $level += 1;
    }
    if (file_exists($root.'/framework/class.secure.php')) {
        include($root.'/framework/class.secure.php');
    } else {
        trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!",
                $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
    }
}
// end include class.secure.php


$module_directory = 'lib_githubapi';
$module_name = 'libGitHubAPI';
$module_function = (defined('LEPTON_VERSION')) ? 'library' : 'snippet';
$module_version = '0.12';
$module_status = 'Stable';
$module_platform = '2.8';
$module_author = 'Ralf Hertsch - Berlin (Germany)';
$module_license = 'MIT License (MIT)';
$module_description = 'Library to access the GitHub API';
$module_home = 'https://addons.phpmanufaktur.de/de/addons/libgithubapi.php';
$module_guid = '6B9CCCF4-C715-49B0-95BC-E46C99C80D2B';

?>