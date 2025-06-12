<?php
/**
 * paypalr.php payment module for PayPal RESTful API payment method in Zen Cart German 1.5.7j
 *
 * @copyright Copyright 2003-2025 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: paypalpr.php 2025-04-30 11:21:14Z webchills $
 */
global $psr4Autoloader;

$psr4Autoloader->addPrefix('PayPalRestful\Admin', DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/PayPalRestful/Admin');
$psr4Autoloader->addPrefix('PayPalRestful\Admin\Formatters', DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/PayPalRestful/Admin/Formatters');
$psr4Autoloader->addPrefix('PayPalRestful\Api', DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/PayPalRestful/Api');
$psr4Autoloader->addPrefix('PayPalRestful\Api\Data', DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/PayPalRestful/Api/Data');
$psr4Autoloader->addPrefix('PayPalRestful\Common', DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/PayPalRestful/Common');
$psr4Autoloader->addPrefix('PayPalRestful\Token', DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/PayPalRestful/Token');
$psr4Autoloader->addPrefix('PayPalRestful\Zc2Pp', DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/PayPalRestful/Zc2Pp');