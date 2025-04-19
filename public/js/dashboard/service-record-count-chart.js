"use strict";

// Class definition
var KTServiceRecordCountChart = function () {
    var chart = {
        self: null,
        rendered: false
    };

    // Private methods
    var initChart = function (chart) {
        var element = document.getElementById("kt_service_record_count_chart");

        if (!element) {
            return;
        }

        var height = parseInt(KTUtil.css(element, 'height'));
        var labelColor = KTUtil.getCssVariableValue('--bs-gray-500');
        var borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');
        var baseprimaryColor = KTUtil.getCssVariableValue('--bs-primary');
        var lightprimaryColor = KTUtil.getCssVariableValue('--bs-primary');
        var basesuccessColor = KTUtil.getCssVariableValue('--bs-success');
        var lightsuccessColor = KTUtil.getCssVariableValue('--bs-success');


        // Function to get the current and previous month names in Bengali with ' মাসে'
        function getBengaliMonthNames() {
            // Month names in Bengali
            const bengaliMonths = [
                'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর'
            ];

            const now = new Date();
            const currentMonth = bengaliMonths[now.getMonth()]; // Get current month name in Bengali
            const previousMonth = bengaliMonths[new Date(now.setMonth(now.getMonth() - 1)).getMonth()]; // Get previous month name in Bengali

            // Add suffix ' মাসে' to each month
            return {
                currentMonth: currentMonth + ' মাসে',
                previousMonth: previousMonth + ' মাসে'
            };
        }

        // Get the month names in Bengali
        const { currentMonth, previousMonth } = getBengaliMonthNames();


        var options = {
            series: [
                {
                    name: currentMonth,
                    data: serviceRecordChartData.current
                },
                {
                    name: previousMonth,
                    data: serviceRecordChartData.last
                }
            ],
            chart: {
                fontFamily: 'inherit',
                type: 'area',
                height: height,
                toolbar: {
                    show: false
                }
            },
            plotOptions: {},
            legend: {
                show: true,
                position: 'top',
                labels: {
                    colors: labelColor
                }
            },
            dataLabels: {
                enabled: false
            },
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.4,
                    opacityTo: 0.2,
                    stops: [15, 120, 100]
                }
            },
            stroke: {
                curve: 'smooth',
                show: true,
                width: 3,
                colors: [baseprimaryColor, basesuccessColor]
            },
            xaxis: {
                categories: serviceRecordChartData.dates,
                title: {
                    text: 'তারিখ',
                    style: {
                        color: labelColor,
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    rotate: -45,
                    rotateAlways: false, // true দিলে অনেক সময় label skip করে
                    style: {
                        colors: labelColor,
                        fontSize: '11px'
                    },
                    trim: true, // বড় label কাটবে
                    hideOverlappingLabels: false, // দরকার হলে overlapping হলেও দেখাবে
                    formatter: function(val) {
                        return val;
                    }
                },
                tickPlacement: 'on',
                crosshairs: {
                    position: 'front',
                    stroke: {
                        color: [baseprimaryColor, basesuccessColor],
                        width: 1,
                        dashArray: 3
                    }
                },
                tooltip: {
                    enabled: true,
                    offsetY: 0,
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'পরিসেবা সংখ্যা',
                    style: {
                        color: labelColor,
                        fontSize: '14px',
                        fontWeight: 'bold'
                    }
                },
                labels: {
                    style: {
                        colors: labelColor,
                        fontSize: '12px'
                    },
                    formatter: function (val) {
                        return en2bnNumber(Math.round(val));
                    }
                }
            },
            states: {
                normal: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                hover: {
                    filter: {
                        type: 'none',
                        value: 0
                    }
                },
                active: {
                    allowMultipleDataPointsSelection: false,
                    filter: {
                        type: 'none',
                        value: 0
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px'
                },
                y: {
                    formatter: function (val) {
                        return en2bnNumber(val) + ' টি';
                    }
                }
            },
            colors: [lightprimaryColor, lightsuccessColor],
            grid: {
                borderColor: borderColor,
                strokeDashArray: 4,
                yaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            markers: {
                strokeColor: [baseprimaryColor, basesuccessColor],
                strokeWidth: 3
            }
        };

        chart.self = new ApexCharts(element, options);

        // Set timeout to properly get the parent elements width
        setTimeout(function () {
            chart.self.render();
            chart.rendered = true;
        }, 200);
    }

    // Public methods
    return {
        init: function () {
            initChart(chart);

            // Update chart on theme mode change
            KTThemeMode.on("kt.thememode.change", function () {
                if (chart.rendered) {
                    chart.self.destroy();
                }

                initChart(chart);
            });
        }
    }
}();

// Webpack support
if (typeof module !== 'undefined') {
    module.exports = KTServiceRecordCountChart;
}

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTServiceRecordCountChart.init();
});