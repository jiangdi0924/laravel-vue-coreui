'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _vue = require('vue');

var _vue2 = _interopRequireDefault(_vue);

var _chart = require('chart.js');

var _chart2 = _interopRequireDefault(_chart);

var _options = require('../helpers/options');

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _vue2.default.extend({
  render: function render(createElement) {
    return createElement('div', [createElement('canvas', {
      attrs: {
        id: this.chartId,
        width: this.width,
        height: this.height
      },
      ref: 'canvas'
    })]);
  },

  props: {
    chartId: {
      default: 'line-chart',
      type: String
    },
    width: {
      default: 400,
      type: Number
    },
    height: {
      default: 400,
      type: Number
    }
  },

  data: function data() {
    return {
      defaultOptions: {
        scales: {
          yAxes: [{
            ticks: {
              beginAtZero: true
            },
            gridLines: {
              display: false
            }
          }],
          xAxes: [{
            gridLines: {
              display: false
            }
          }]
        }
      }
    };
  },


  methods: {
    renderChart: function renderChart(data, options) {
      var chartOptions = (0, _options.mergeOptions)(this.defaultOptions, options);

      this._chart = new _chart2.default(this.$refs.canvas.getContext('2d'), {
        type: 'line',
        data: data,
        options: chartOptions
      });
      this._chart.generateLegend();
    }
  },
  beforeDestroy: function beforeDestroy() {
    this._chart.destroy();
  }
});