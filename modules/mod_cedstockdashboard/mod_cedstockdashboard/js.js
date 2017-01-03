(function (h) {
    h.fn.cedstockdashboard = function (f) {
        f = h.extend({
            stocks : ['NVDA', 'EBAY', 'INTC', 'AAPL', 'MSFT', 'GOOG', 'FB', 'TWTR']
        }, f);

    var stocksUrl = f.stocks.join('%20');

    var url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%3D%22' + stocksUrl + '%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';

        jQuery.getJSON(url, function(data) {

        for (var i = 0; i < data.query.results.quote.length; i++) {
            var stockId = '#stock-' + (i + 1);
            var change = data.query.results.quote[i].ChangeinPercent;

            if (change.slice(0,-1) < 0) {
                jQuery(stockId).css('background-color', '#db5959');
            }  else if (change.slice(0,-1) > 0) {
                jQuery(stockId).css('background-color', '#68b665');
            } else if (change.slice(0,-1) == 0) {
                jQuery(stockId).css('background-color', '#fdca41');
            }

            jQuery(stockId).children('.csdSymbolLink').children('.csdsymbol').html(data.query.results.quote[i].symbol);
            jQuery(stockId).children('.csdSymbolLink').children('.csdchange').html(change);
            jQuery(stockId).children('.csdSymbolLink').attr("href", "https://finance.yahoo.com/quote/" + f.stocks[i]);
        }
    });

}
    })(jQuery);