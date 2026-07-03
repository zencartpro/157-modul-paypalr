<?php
/**
 * paypalr.php payment module class for PayPal RESTful API payment method in Zen Cart German 1.5.7k
 * Zen Cart German Specific (zencartpro adaptations) 
 * @copyright Copyright 2003-2026 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: paypalpr.php 2026-07-03 09:11:14Z webchills $
 *
 * Last updated: v1.3.6
 */
$pprautoload_dir = __DIR__ . '/';
global $psr4Autoloader;

$psr4Autoloader->addPrefix('PayPalRestful\Admin', $pprautoload_dir . 'PayPalRestful/Admin');
$psr4Autoloader->addPrefix('PayPalRestful\Admin\Formatters', $pprautoload_dir . 'PayPalRestful/Admin/Formatters');
$psr4Autoloader->addPrefix('PayPalRestful\Api', $pprautoload_dir . 'PayPalRestful/Api');
$psr4Autoloader->addPrefix('PayPalRestful\Api\Data', $pprautoload_dir . 'PayPalRestful/Api/Data');
$psr4Autoloader->addPrefix('PayPalRestful\Common', $pprautoload_dir . 'PayPalRestful/Common');
$psr4Autoloader->addPrefix('PayPalRestful\Token', $pprautoload_dir . 'PayPalRestful/Token');
$psr4Autoloader->addPrefix('PayPalRestful\Webhooks', $pprautoload_dir . 'PayPalRestful/Webhooks');
$psr4Autoloader->addPrefix('PayPalRestful\Zc2Pp', $pprautoload_dir . 'PayPalRestful/Zc2Pp');
// -----
// The zcDate class was introduced in zc158. If the
// class isn't already loaded and the class-file is present, load it.
//
if (!class_exists('zcDate') && file_exists(DIR_WS_CLASSES . 'zcDate.php')) {
    require DIR_WS_CLASSES . 'zcDate.php';
}

// -----
// If the zcDate class is loaded (it's not for ZC versions prior to zc158),
// instantiate the class now for webhook use on zc158 and later.
//
global $zcDate;
if (class_exists('zcDate') && !isset($zcDate)) {
    $zcDate = new zcDate();
}
