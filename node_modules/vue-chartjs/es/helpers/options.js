'use strict';

Object.defineProperty(exports, "__esModule", {
  value: true
});
exports.mergeOptions = mergeOptions;

var _merge = require('lodash/fp/merge');

var _merge2 = _interopRequireDefault(_merge);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

function mergeOptions(obj, src) {
  return (0, _merge2.default)(obj, src);
}