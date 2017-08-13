'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});

var _Bar = require('../BaseCharts/Bar');

var _Bar2 = _interopRequireDefault(_Bar);

var _reactiveData = require('../mixins/reactiveData');

var _reactiveData2 = _interopRequireDefault(_reactiveData);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _Bar2.default.extend({
  mixins: [_reactiveData2.default],
  data: function data() {
    return {
      chartData: ''
    };
  },
  created: function created() {
    this.fillData();
  },
  mounted: function mounted() {
    var _this = this;

    this.renderChart(this.chartData, { responsive: true, maintainAspectRatio: false });

    setInterval(function () {
      _this.fillData();
    }, 5000);
  },


  methods: {
    fillData: function fillData() {
      this.chartData = {
        labels: ['January' + this.getRandomInt(), 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
          label: 'Data One',
          backgroundColor: '#f87979',
          data: [this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt(), this.getRandomInt()]
        }]
      };
    },
    getRandomInt: function getRandomInt() {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
    }
  }
});