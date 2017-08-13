'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Doughnut = require('../BaseCharts/Doughnut');

var _Doughnut2 = _interopRequireDefault(_Doughnut);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _Doughnut2.default.extend({
  mounted: function mounted() {
    this.renderChart({
      labels: ['VueJs', 'EmberJs', 'ReactJs', 'AngularJs'],
      datasets: [{
        backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
        data: [40, 20, 80, 10]
      }]
    }, { responsive: true, maintainAspectRatio: false });
  }
});