<?php
/**
 * @package     CedStockMarketWatch
 * @subpackage  com_cedstockmarketwatch
 * http://www.gnu.org/licenses/gpl-3.0.html GNU/GPL 3.0</license>
 * @copyright   Copyright (C) 2013-2016 galaxiis.com All rights reserved.
 * @license     The author and holder of the copyright of the software is Cédric Walter. The licensor and as such issuer of the license and bearer of the
 *              worldwide exclusive usage rights including the rights to reproduce, distribute and make the software available to the public
 *              in any form is Galaxiis.com
 *              see LICENSE.txt
 */

// Don't allow direct access to the module.
defined('_JEXEC') or die('Restricted access');

require_once(dirname(__FILE__) . '/helper.php');

$helper = new cedStockMarketWatch($params);

$model = $helper->getModel();

$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . "/media/mod_cedstockmarketwatch/responsive-tables.css?v=1.4.5");
$document->addScript(JUri::root() . "/media/mod_cedstockmarketwatch/responsive-tables.js?v=1.4.5");

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$layoutPath = JModuleHelper::getLayoutPath('mod_cedstockmarketwatch', 'default');
require($layoutPath);
