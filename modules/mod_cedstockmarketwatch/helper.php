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
require_once(JPATH_SITE . '/libraries/cedsimplepie/vendor/autoload.php');

class cedStockMarketWatch
{
	const BASE_CHART_URL = 'https://chart.finance.yahoo.com/z?';
	const BASE_YDL_URL = 'https://query.yahooapis.com/v1/public/yql?q=';

	private $chartUrl;
	private $symbols = array();
	private $fields = null;
	private $indicatorsText = "";
	private $params;

	public function __construct($params)
	{
		$this->params   = $params;
		$this->chartUrl = $this->getChartUrl($params);

		$this->symbols[] = '"' . $params->get('stock_id') . '"';

		if ($params->get('comparing_ids') != '')
		{
			$z = explode(',', $params->get('comparing_ids'));
			foreach ($z as $v)
			{
				$this->symbols[] = '"' . trim($v) . '"';
			}
		}

		$this->fields = $params->get('fields');

		return $this;
	}

	public function getModel()
	{
		$data        = new stdClass();
		$data->chart = $this->getChart();
		$quotes      = $this->getQuoteData();

		$data->indicatorsText = is_array($this->params->get('technical_indicator')) && $this->indicatorsText != "" ? JText::_('ACTIVE_INDICATORS') . " " . $this->indicatorsText : "";

		$hasData = (is_array($quotes) && sizeof($quotes) > 0);

		if ($hasData)
		{
			$data->stocks = array();
			$colorArray   = array(
				'0' => "1A5488",
				'1' => "48ae37",
				'2' => "f5110c",
				'3' => "c30beb",
				'4' => "FF9900",
				'5' => "FFCC00",
				'6' => "FF3399",
			);

			$color        = 0;
			$comparingIds = $this->params->get('comparing_ids', '');
			if (strlen($comparingIds) > 0)
			{
				foreach ($quotes as $stock)
				{
					$stockModel     = $this->getStockModel($colorArray, $color, $stock);
					$data->stocks[] = $stockModel;
				}
			}
			else
			{
				$stockModel     = $this->getStockModel($colorArray, $color, $quotes);
				$data->stocks[] = $stockModel;
			}
		}
		else
		{
			$data->stocks = null;
		}

		return $data;
	}

	private function getChartUrl($params)
	{
		$qs = '&amp;p=';

		if ($params->get('moving_average_indicator') != '')
		{
			$indicators = explode(',', $params->get('moving_average_indicator'));
			foreach ($indicators as $indicator)
			{
				$k[] = 'm' . trim($indicator);
			}

			$qs .= implode(',', $k);
		}

		if ($params->get('exponential_moving_average_indicator') != '')
		{
			$indicators = explode(',', $params->get('exponential_moving_average_indicator'));
			foreach ($indicators as $indicator)
			{
				$t[] = 'e' . trim($indicator);
			}

			$qs .= implode(',', $t);
		}

		if (is_array($params->get('technical_indicator')))
		{
			$pieces = $params->get('technical_indicator');
			$texts  = array();
			foreach ($pieces as $indicator)
			{
				if ($indicator != "")
				{
					$texts[] = JText::_("INDICATOR_" . $indicator);
				}
			}
			$this->indicatorsText = implode(', ', $texts);
			$qs .= implode(',', $pieces);
		}

		$var = $params->get('comparing_ids');
		if (strlen($var) > 0)
		{
			$stocks = explode(',', $var);
			foreach ($stocks as $stock)
			{
				$c[] = strtoupper(trim($stock));
			}
			$qs .= '&amp;c=' . implode(',', $c);
		}

		$lang = JFactory::getLanguage();

		$urls = array(
			's' => $params->get('stock_id'),
			't' => $params->get('time_span'),
			'q' => $params->get('chart_type'),
			'l' => $params->get('chart_scale'),
			'z' => $params->get('chart_image_size'),

			'width'  => $params->get('width', 300),
			'height' => $params->get('height', 180),
			'lang'   => $lang->getDefault()
		);

		$url = http_build_query($urls, '', '&amp;');
		$url .= $qs;

		return $url;
	}


	private function getChart()
	{
		return $this->protocol . self::BASE_CHART_URL . $this->chartUrl;
	}

	private function getQuoteData()
	{
		$symbols = implode(',', $this->symbols);

		$query = rawurlencode(sprintf('select * from yahoo.finance.quotes where symbol in (%s)', $symbols));
		$url   = $this->protocol.self::BASE_YDL_URL . $query . '&format=json&diagnostics=true&env=http%3A%2F%2Fdatatables.org%2Falltables.env';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		$data = curl_exec($curl);
		curl_close($curl);

		return json_decode($data, true)['query']['results']['quote'];
	}

	function splitAtUpperCase($s)
	{
		return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
	}

	/**
	 * @param $value
	 *
	 * @return string
	 */
	private function getStatusCssClassName($value)
	{
		if (strpos($value, '-') === 0)
		{
			return 'cedstockmneg';
		}
		elseif (strpos($value, '+') === 0)
		{
			return 'cedstockmpos';
		}
		else
		{
			return 'cedstockmno';
		}
	}

	/**
	 * @param $colorArray
	 * @param $color
	 * @param $stock
	 *
	 * @return stdClass
	 */
	private function getStockModel($colorArray, &$color, $stock)
	{
		$stockModel         = new stdClass();
		$stockModel->color  = $colorArray[$color++];
		$stockModel->name   = $stock['Name'];
		$stockModel->symbol = $stock['symbol'];

		$fields = array();
		if (is_array($this->fields))
		{
			foreach ($this->fields as $field)
			{
				if (array_key_exists($field, $stock))
				{
					$attribute             = new stdClass();
					$attribute->name       =     JText::_("FIELD_".  str_replace(" ", "_", strtoupper(implode(" ", $this->splitAtUpperCase($field)))));
					$attribute->value      = $stock[$field];
					$attribute->valueClass = ($attribute->name == 'Symbol') ? "t" . $stockModel->color : $this->getStatusCssClassName($attribute->value);

					$fields[] = $attribute;
				}
			}
		}
		$stockModel->fields = $fields;

		return $stockModel;
	}

}
