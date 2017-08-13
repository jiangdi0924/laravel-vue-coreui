'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Bar = require('../BaseCharts/Bar');

var _Bar2 = _interopRequireDefault(_Bar);

var _reactiveProp = require('../mixins/reactiveProp');

var _reactiveProp2 = _interopRequireDefault(_reactiveProp);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _Bar2.default.extend({
  mixins: [_reactiveProp2.default],

  mounted: function mounted() {
    this.renderChart(this.chartData);
  }
});