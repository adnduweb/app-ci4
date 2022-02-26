/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
var __webpack_exports__ = {};
/*!**************************************************************************!*\
  !*** ./resources/backend/core/js/custom/documentation/charts/chartjs.js ***!
  \**************************************************************************/
 // Class definition

var KTGeneralChartJS = function () {
  // Randomizer function
  function getRandom() {
    var min = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
    var max = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 100;
    return Math.floor(Math.random() * (max - min) + min);
  }

  function generateRandomData() {
    var min = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : 1;
    var max = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 100;
    var count = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 10;
    var arr = [];

    for (var i = 0; i < count; i++) {
      arr.push(getRandom(min, max));
    }

    return arr;
  } // Private functions


  var example1 = function example1() {
    // Define chart element
    var ctx = document.getElementById('kt_chartjs_1'); // Define colors

    var primaryColor = KTUtil.getCssVariableValue('--bs-primary');
    var dangerColor = KTUtil.getCssVariableValue('--bs-danger');
    var successColor = KTUtil.getCssVariableValue('--bs-success'); // Define fonts

    var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif'); // Chart labels

    var labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']; // Chart data

    var data = {
      labels: labels,
      datasets: [{
        label: 'Dataset 1',
        data: generateRandomData(1, 100, 12),
        backgroundColor: primaryColor,
        stack: 'Stack 0'
      }, {
        label: 'Dataset 2',
        data: generateRandomData(1, 100, 12),
        backgroundColor: dangerColor,
        stack: 'Stack 1'
      }, {
        label: 'Dataset 3',
        data: generateRandomData(1, 100, 12),
        backgroundColor: successColor,
        stack: 'Stack 2'
      }]
    }; // Chart config

    var config = {
      type: 'bar',
      data: data,
      options: {
        plugins: {
          title: {
            display: false
          }
        },
        responsive: true,
        interaction: {
          intersect: false
        },
        scales: {
          x: {
            stacked: true
          },
          y: {
            stacked: true
          }
        }
      }
    }; // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/

    var myChart = new Chart(ctx, config);
  };

  var example2 = function example2() {
    // Define chart element
    var ctx = document.getElementById('kt_chartjs_2'); // Define colors

    var primaryColor = KTUtil.getCssVariableValue('--bs-primary');
    var dangerColor = KTUtil.getCssVariableValue('--bs-danger');
    var successColor = KTUtil.getCssVariableValue('--bs-success'); // Define fonts

    var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif'); // Chart labels

    var labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July']; // Chart data

    var data = {
      labels: labels,
      datasets: [{
        label: 'Dataset 1',
        data: generateRandomData(1, 50, 7),
        borderColor: primaryColor,
        backgroundColor: 'transparent'
      }, {
        label: 'Dataset 2',
        data: generateRandomData(1, 50, 7),
        borderColor: dangerColor,
        backgroundColor: 'transparent'
      }]
    }; // Chart config

    var config = {
      type: 'line',
      data: data,
      options: {
        plugins: {
          title: {
            display: false
          }
        },
        responsive: true
      }
    }; // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/

    var myChart = new Chart(ctx, config);
  };

  var example3 = function example3() {
    // Define chart element
    var ctx = document.getElementById('kt_chartjs_3'); // Define colors

    var primaryColor = KTUtil.getCssVariableValue('--bs-primary');
    var dangerColor = KTUtil.getCssVariableValue('--bs-danger');
    var successColor = KTUtil.getCssVariableValue('--bs-success');
    var warningColor = KTUtil.getCssVariableValue('--bs-warning');
    var infoColor = KTUtil.getCssVariableValue('--bs-info'); // Chart labels

    var labels = ['January', 'February', 'March', 'April', 'May']; // Chart data

    var data = {
      labels: labels,
      datasets: [{
        label: 'Dataset 1',
        data: generateRandomData(1, 100, 5),
        backgroundColor: [primaryColor, dangerColor, successColor, warningColor, infoColor]
      }]
    }; // Chart config

    var config = {
      type: 'pie',
      data: data,
      options: {
        plugins: {
          title: {
            display: false
          }
        },
        responsive: true
      }
    }; // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/

    var myChart = new Chart(ctx, config);
  };

  var example4 = function example4() {
    // Define chart element
    var ctx = document.getElementById('kt_chartjs_4'); // Define colors

    var primaryColor = KTUtil.getCssVariableValue('--bs-primary');
    var dangerColor = KTUtil.getCssVariableValue('--bs-danger');
    var dangerLightColor = KTUtil.getCssVariableValue('--bs-light-danger'); // Define fonts

    var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif'); // Chart labels

    var labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']; // Chart data

    var data = {
      labels: labels,
      datasets: [{
        label: 'Dataset 1',
        data: generateRandomData(50, 100, 12),
        borderColor: primaryColor,
        backgroundColor: 'transparent',
        stack: 'combined'
      }, {
        label: 'Dataset 2',
        data: generateRandomData(1, 60, 12),
        backgroundColor: dangerColor,
        borderColor: dangerColor,
        stack: 'combined',
        type: 'bar'
      }]
    }; // Chart config

    var config = {
      type: 'line',
      data: data,
      options: {
        plugins: {
          title: {
            display: false
          }
        },
        responsive: true,
        interaction: {
          intersect: false
        },
        scales: {
          y: {
            stacked: true
          }
        }
      },
      defaults: {
        font: {
          family: 'inherit'
        }
      }
    }; // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/

    var myChart = new Chart(ctx, config);
  };

  var example5 = function example5() {
    // Define chart element
    var ctx = document.getElementById('kt_chartjs_5'); // Define colors

    var infoColor = KTUtil.getCssVariableValue('--bs-info');
    var infoLightColor = KTUtil.getCssVariableValue('--bs-light-info');
    var warningColor = KTUtil.getCssVariableValue('--bs-warning');
    var warningLightColor = KTUtil.getCssVariableValue('--bs-light-warning');
    var primaryColor = KTUtil.getCssVariableValue('--bs-primary');
    var primaryLightColor = KTUtil.getCssVariableValue('--bs-light-primary'); // Define fonts

    var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif'); // Chart labels

    var labels = ['January', 'February', 'March', 'April', 'May', 'June']; // Chart data

    var data = {
      labels: labels,
      datasets: [{
        label: 'Dataset 1',
        data: generateRandomData(20, 80, 6),
        borderColor: infoColor,
        backgroundColor: infoLightColor
      }, {
        label: 'Dataset 2',
        data: generateRandomData(10, 60, 6),
        backgroundColor: warningLightColor,
        borderColor: warningColor
      }, {
        label: 'Dataset 3',
        data: generateRandomData(0, 80, 6),
        backgroundColor: primaryLightColor,
        borderColor: primaryColor
      }]
    }; // Chart config

    var config = {
      type: 'radar',
      data: data,
      options: {
        plugins: {
          title: {
            display: false
          }
        },
        responsive: true
      }
    }; // Init ChartJS -- for more info, please visit: https://www.chartjs.org/docs/latest/

    var myChart = new Chart(ctx, config);
  };

  return {
    // Public Functions
    init: function init() {
      // Global font settings: https://www.chartjs.org/docs/latest/general/fonts.html
      Chart.defaults.font.size = 13;
      Chart.defaults.font.family = KTUtil.getCssVariableValue('--bs-font-sans-serif');
      example1();
      example2();
      example3();
      example4();
      example5();
    }
  };
}(); // On document ready


KTUtil.onDOMContentLoaded(function () {
  KTGeneralChartJS.init();
});
/******/ })()
;