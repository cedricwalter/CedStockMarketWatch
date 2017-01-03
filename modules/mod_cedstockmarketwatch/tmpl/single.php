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

$stock = $model->stocks[0];

?>

<div class="module<?php echo $moduleclass_sfx ?>">
    <!-- Copyright (C) 2013-2016 galaxiis.com All rights reserved. -->
    <?php if ($params->get('chart_display') === 'true') { ?>
        <img src="//chart.finance.yahoo.com/t?s=<?php echo $stock->symbol ?>&amp;width=<?php echo $params->get('width', 300)?>&amp;height=<?php echo $params->get('height', 180)?>" alt="<?php echo $stock->name ?>"/>
    <?php } ?>

    <table class="cedsmresponsive">
        <tbody>
        <tr>
            <?php
            $stock = $model->stocks[0];
            foreach ($stock->fields as $field) {
                ?>
                <th><?php echo $field->name ?></th>
            <?php } ?>
        </tr>
        <tr>
            <?php foreach ($stock->fields as $field) { ?>
                <td class="<?php echo $field->valueClass ?>">
                    <?php
                    if ($field->name == 'Symbol') {
                        ?>
                        <span class="c<?php echo $stock->color ?>"></span>
                    <?php
                    }
                    echo $field->value
                    ?>
                </td>
            <?php } ?>
        </tr>
        </tbody>
    </table>
</div>