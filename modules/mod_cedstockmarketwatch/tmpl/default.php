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
?>

<div class="module<?php echo $moduleclass_sfx ?>">
    <!-- Copyright (C) 2013-2016 galaxiis.com All rights reserved. -->
    <?php if ($params->get('chart_display') === 'true') { ?>
        <img src="<?php echo $model->chart ?>" alt=" "/>
    <?php } ?>

    <?php if (strlen($model->indicatorsText) > 0) {
    ?>
       <h5><?php echo $model->indicatorsText ?></h5>
    <?php
    } ?>


    <table class="cedsmresponsive">
        <tbody>
        <tr>
            <?php
            if (is_array($model->stocks)) {
                $stock = $model->stocks[0];
                foreach ($stock->fields as $field) {
                    ?>
                    <th><?php echo $field->name ?></th>
                <?php
                }
            }
            ?>
        </tr>
        <?php
        if (is_array($model->stocks)) {
        foreach ($model->stocks as $stock) { ?>
            <tr>
                <?php foreach ($stock->fields as $field) { ?>
                    <td class="<?php echo $field->valueClass ?>">
                        <?php
                        if ($field->name == 'Symbol') { ?>
                            <span class="bloc c<?php echo $stock->color ?>"></span>
                        <?php }
                        echo $field->value
                        ?>
                    </td>
                <?php } ?>
            </tr>
        <?php }
        } ?>
        </tbody>
    </table>
</div>