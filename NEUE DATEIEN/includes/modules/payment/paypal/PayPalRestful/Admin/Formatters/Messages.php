<?php
/**
 * A class that formats admin messageStack messages for use by the
 * admin_notifications method of the PayPal Restful payment module.
 *
 * @copyright Copyright 2023-2025 Zen Cart Development Team
 * @license https://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Messages 2025-09-15 webchills
 * 
 * Last updated: v1.2.0
 */
namespace PayPalRestful\Admin\Formatters;

class Messages extends \messageStack
{
    /**
     * The $class param is unused in admin-side implementations
     * but this signature matches catalog-side class to allow
     * for simpler sharing of code that could run in either
     */
    public function output($class = null)
    {
        $this->table_data_parameters = 'class="pprNotification"';
        return $this->tableBlock($this->errors);
    }
}