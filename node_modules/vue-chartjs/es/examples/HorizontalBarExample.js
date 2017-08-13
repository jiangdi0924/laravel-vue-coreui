'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _HorizontalBar = require('../BaseCharts/HorizontalBar');

var _HorizontalBar2 = _interopRequireDefault(_HorizontalBar);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _HorizontalBar2.default.extend({
  mounted: function mounted() {
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
      datasets: [{
        label: 'Data One',
        backgroundColor: '#f87979',
        data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11]
      }]
    }, { responsive: true, maintainAspectRatio: false });
  }
});