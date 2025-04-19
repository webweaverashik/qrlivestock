"use strict";

// Class definition
var KTRegisteredLivestockCountChart = function () {
     var chart = {
          self: null,
          rendered: false
     };

     // Private methods
     var initChart = function () {
          var element = document.getElementById("registered_livestock_count_chart");

          if (!element) {
               return;
          }

          var height = parseInt(KTUtil.css(element, 'height'));
          var labelColor = KTUtil.getCssVariableValue('--bs-gray-900');
          var borderColor = KTUtil.getCssVariableValue('--bs-border-dashed-color');

          var categories = livestockTypeChartData.map(item => item.type);
          var seriesData = livestockTypeChartData.map(item => item.total);

          var options = {
               series: [{
                    name: 'সংখ্যা',
                    data: seriesData
               }],
               chart: {
                    fontFamily: 'inherit',
                    type: 'bar',
                    height: height,
                    toolbar: {
                         show: false
                    }
               },
               plotOptions: {
                    bar: {
                         horizontal: false,
                         columnWidth: ['28%'],
                         borderRadius: 5,
                         dataLabels: {
                              position: "top" // top, center, bottom
                         },
                         startingShape: 'flat'
                    },
               },
               legend: {
                    show: false
               },
               dataLabels: {
                    enabled: true,
                    offsetY: -28,
                    style: {
                         fontSize: '13px',
                         colors: [labelColor]
                    },
                    formatter: function (val) {
                         return en2bnNumber(val);
                    }
               },
               stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
               },
               xaxis: {
                    title: {
                         text: 'গবাদি প্রাণির ধরণ', // Axis title text
                         style: {
                              color: KTUtil.getCssVariableValue('--bs-gray-600'),
                              fontSize: '14px',
                              fontWeight: 600
                         }
                    },
                    categories: categories,
                    axisBorder: {
                         show: false,
                    },
                    axisTicks: {
                         show: false
                    },
                    labels: {
                         style: {
                              colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                              fontSize: '13px'
                         }
                    },
                    crosshairs: {
                         fill: {
                              gradient: {
                                   opacityFrom: 0,
                                   opacityTo: 0
                              }
                         }
                    }
               },
               yaxis: {
                    title: {
                         text: 'সংখ্যা', // Y-axis title
                         style: {
                              color: KTUtil.getCssVariableValue('--bs-gray-600'),
                              fontSize: '14px',
                              fontWeight: 600
                         }
                    },
                    labels: {
                         style: {
                              colors: KTUtil.getCssVariableValue('--bs-gray-500'),
                              fontSize: '13px'
                         },
                         formatter: function (val) {
                              return en2bnNumber(val);
                         }
                    }
               },
               fill: {
                    opacity: 1
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
                         fontSize: '14px'
                    },
                    y: {
                         formatter: function (val) {
                              return en2bnNumber(val) + ' টি';
                         }
                    }
               },
               colors: [KTUtil.getCssVariableValue('--bs-primary'), KTUtil.getCssVariableValue('--bs-primary-light')],
               grid: {
                    borderColor: borderColor,
                    strokeDashArray: 4,
                    yaxis: {
                         lines: {
                              show: true
                         }
                    }
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
               initChart();

               // Update chart on theme mode change
               KTThemeMode.on("kt.thememode.change", function () {
                    if (chart.rendered) {
                         chart.self.destroy();
                    }

                    initChart();
               });
          }
     }
}();

// Webpack support
if (typeof module !== 'undefined') {
     module.exports = KTRegisteredLivestockCountChart;
}

// On document ready
KTUtil.onDOMContentLoaded(function () {
     KTRegisteredLivestockCountChart.init();
});