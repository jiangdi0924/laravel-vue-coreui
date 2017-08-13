'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Line = require('../BaseCharts/Line');

var _Line2 = _interopRequireDefault(_Line);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _Line2.default.extend({
  mounted: function mounted() {
    this.renderChart({
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
        label: 'Data One',
        backgroundColor: '#f87979',
        data: [40, 39, 10, 40, 39, 80, 40]
      }]
    }, { responsive: true, maintainAspectRatio: false });
  }
});