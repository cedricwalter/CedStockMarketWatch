function cedStockPriceTicker(divId, CNames) {
    var Symbol = "", CompName = "", Price = "", ChangeInPrice = "", PercentChangeInPrice = "";
    var flickerAPI = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(%22" + CNames + "%22)&env=store://datatables.org/alltableswithkeys";
    var StockTickerHTML = "";

    var StockTickerXML = jQuery.get(flickerAPI, function (xml) {
        jQuery(xml).find("quote").each(function () {
            Symbol = jQuery(this).attr("symbol");
            jQuery(this).find("Name").each(function () {
                CompName = jQuery(this).text();
            });
            jQuery(this).find("LastTradePriceOnly").each(function () {
                Price = jQuery(this).text();
            });
            jQuery(this).find("Change").each(function () {
                ChangeInPrice = jQuery(this).text();
            });
            jQuery(this).find("PercentChange").each(function () {
                PercentChangeInPrice = jQuery(this).text();
            });

            var PriceClass = "GreenText", PriceIcon = "up_green";
            if (parseFloat(ChangeInPrice) < 0) {
                PriceClass = "RedText";
                PriceIcon = "down_red";
            }
            StockTickerHTML = StockTickerHTML + "<span class='" + PriceClass + "'>";
            StockTickerHTML = StockTickerHTML + "<span class='quote'>" + CompName + " (" + Symbol + ")</span> ";

            StockTickerHTML = StockTickerHTML + parseFloat(Price).toFixed(2) + " ";
            StockTickerHTML = StockTickerHTML + "<span class='" + PriceIcon + "'></span>" + parseFloat(Math.abs(ChangeInPrice)).toFixed(2) + " (";
            StockTickerHTML = StockTickerHTML + parseFloat(Math.abs(PercentChangeInPrice.split('%')[0])).toFixed(2) + "%)</span>";
        });

        jQuery(divId).html(StockTickerHTML);
        jQuery(divId).jStockTicker({interval: 30, speed: 2});
    });
}