(function (h) {
    h.fn.cedstocksingle = function (f) {
        f = h.extend({
            stock: 'AAPL',
            stockId: 'csstockId'
        }, f);
        var url = 'https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%3D%22' + f.stock + '%22&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=';
        // console.log(url);
        jQuery.getJSON(url, function (data) {
            var change = data.query.results.quote.ChangeinPercent;
            var char = '↑';

            if (change.slice(0, -1) < 0) {
                jQuery(f.stockId).children('.csstock-quote-div').children('.csstock-quote').addClass("red");
                char = '↓';
            }  else if (change.slice(0,-1) > 0) {
                jQuery(f.stockId).children('.csstock-quote-div').children('.csstock-quote').addClass("green");
                char = '↑';
            } else if (change.slice(0, -1) == 0) {
                jQuery(f.stockId).children('.csstock-quote-div').children('.csstock-quote').addClass("black");
                char = '→';
            }

            jQuery(f.stockId).children('.csstock-company').html(data.query.results.quote.Name);
            jQuery(f.stockId).children('.csstock-symbol').html(data.query.results.quote.symbol);
            jQuery(f.stockId).children('.csstock-quote-div').children('.csstock-quote').html(char + data.query.results.quote.LastTradePriceOnly);
            jQuery(f.stockId).children('.csstock-change-div').children('.csstock-change-percent').html(data.query.results.quote.ChangeinPercent);
            jQuery(f.stockId).children('.csstock-change-div').children('.csstock-change').html(data.query.results.quote.Change);
        });

    }
})(jQuery);