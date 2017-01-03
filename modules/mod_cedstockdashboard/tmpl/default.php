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

$document = JFactory::getDocument();

$document->addStyleSheet(JUri::base().'/media/mod_cedstockdashboard/css.css?v=1.4.5');
$document->addScript(JUri::base().'/media/mod_cedstockdashboard/js.js?v=1.4.5');

$document->addScriptDeclaration("
        jQuery(document).ready(function () {
            jQuery('csdcontainer').cedstockdashboard({
                        stocks: \"" . $stocks . "\".split(',')
                        });
        });
        ");

?>
<div class="module<?php echo $moduleclass_sfx ?>">
	<div class="csdcontainer">

		<div class="csdstock" id="stock-1">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

		<div class="csdstock" id="stock-2">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

		<div class="csdstock" id="stock-3">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

		<div class="csdstock" id="stock-4">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

		<div class="csdstock" id="stock-5">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

		<div class="csdstock" id="stock-6">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

		<div class="csdstock" id="stock-7">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

		<div class="csdstock" id="stock-8">
			<a href="#" class="csdSymbolLink">
				<span class="csdsymbol">unknown</span>
				<span class="csdchange">0.00%</span>
			</a>
		</div>

	</div>
	<div style="clear: both"/>
</div>