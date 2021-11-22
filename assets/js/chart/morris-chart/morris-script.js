"use strict";
var morris_chart = {
    init: function () {
        Morris.Line({
            element: "morris-line-chart",
            data: [{
                    y: "2011",
                    a: 100,
                    b: 90
                },
                {
                    y: "2012",
                    a: 75,
                    b: 65
                },
                {
                    y: "2013",
                    a: 50,
                    b: 40
                },
                {
                    y: "2014",
                    a: 75,
                    b: 65
                },
                {
                    y: "2015",
                    a: 50,
                    b: 40
                },
                {
                    y: "2016",
                    a: 75,
                    b: 65
                },
                {
                    y: "2017",
                    a: 100,
                    b: 90
                }],
            xkey: "y",
            ykeys: ["a", "b"],
            lineColors: [CubaAdminConfig.primary, CubaAdminConfig.secondary],
            labels: ["Series A", "Series B"]
        })
    }
};
(function ($) {
    "use strict";
    morris_chart.init()
})(jQuery);
