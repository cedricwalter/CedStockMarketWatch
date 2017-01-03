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
    <p>NASDAQ has a pre-market session from 07:00am to 09:30am, a normal trading session from 09:30am to 04:00pm and a post-market session from 04:00pm to 08:00pm (all times in EST).
    </p>
    <script src="//www.clocklink.com/embed.js"></script> <script type="text/javascript" language="JavaScript">obj=new Object;obj.clockfile="5005-green.swf";obj.TimeZone="EST"; obj.width=240;obj.height=80;obj.wmode="transparent";showClock(obj);</script>
</div>

