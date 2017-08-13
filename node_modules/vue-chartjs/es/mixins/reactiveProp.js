'use strict';

var _stringify = require('babel-runtime/core-js/json/stringify');

var _stringify2 = _interopRequireDefault(_stringify);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

module.exports = {
  props: {
    chartData: {
      required: true
    }
  },

  watch: {
    'chartData': {
      handler: function handler(newData, oldData) {
        if (oldData) {
          var chart = this._chart;

          var newDatasetLabels = newData.datasets.map(function (dataset) {
            return dataset.label;
          });

          var oldDatasetLabels = oldData.datasets.map(function (dataset) {
            return dataset.label;
          });

          var oldLabels = (0, _stringify2.default)(oldDatasetLabels);
          var newLabels = (0, _stringify2.default)(newDatasetLabels);

          if (newLabels === oldLabels && oldData.datasets.length === newData.datasets.length) {
            newData.datasets.forEach(function (dataset, i) {
              chart.data.datasets[i] = dataset;
            });

            chart.data.labels = newData.labels;
            chart.update();
          } else {
            chart.destroy();
            this.renderChart(this.chartData, this.options);
          }
        }
      }
    }
  }
};