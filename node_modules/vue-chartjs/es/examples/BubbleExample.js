'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Bubble = require('../BaseCharts/Bubble');

var _Bubble2 = _interopRequireDefault(_Bubble);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _Bubble2.default.extend({
  mounted: function mounted() {
    this.renderChart({
      datasets: [{
        label: 'Data One',
        backgroundColor: '#f87979',
        data: [{
          x: 20,
          y: 25,
          r: 5
        }, {
          x: 40,
          y: 10,
          r: 10
        }, {
          x: 30,
          y: 22,
          r: 30
        }]
      }, {
        label: 'Data Two',
        backgroundColor: '#7C8CF8',
        data: [{
          x: 10,
          y: 30,
          r: 15
        }, {
          x: 20,
          y: 20,
          r: 10
        }, {
          x: 15,
          y: 8,
          r: 30
        }]
      }]
    }, { responsive: true, maintainAspectRatio: false });
  }
});