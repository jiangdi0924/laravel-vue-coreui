<template>
    <div class="card">
        <!--<div class="card-header">
                                                                                                                评论分析
                                                                                                            </div>-->
    
        <pacman-loader v-if="loading"></pacman-loader>
        <div class="card-block" v-if="loading == false">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">BSR变化趋势图</h4>
                    <div class="small text-muted">说明：xxxxxx</div>
                </div>
                <div class="col-sm-7 hidden-sm-down">
                    <div role="toolbar" aria-label="Toolbar with button groups" class="btn-toolbar float-right">
                        <div data-toggle="buttons" aria-label="First group" class="btn-group mr-1">
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="options" id="option1"> Day
                            </label>
                            <label class="btn btn-outline-secondary active">
                                <input type="radio" name="options" id="option2" checked="checked"> Month
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="options" id="option3"> Year
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <bsr-chart v-if="isLoad==true" :data="chart.bsr"></bsr-chart>
        </div>
    </div>
</template>
<script>
import BsrChart from './BsrChart.vue'
import PacmanLoader from './PacmanLoader.vue'

export default {
    name: 'bsr',
    data() {
        return {
            loading: true,
            isLoad: false,
            productId: this.$route.params.productId,
            chart: {
                datas: [],
                bsr: {
                    labels: [],
                    datasets: []
                }
            }
        }
    },
    components: {
        BsrChart,
        PacmanLoader
    },
    methods: {
        getChartDatas() {
            axios.post('/monitor/bsrinfo', { listing_id: this.productId }).then(response => {
                var labels = []
                var datasets = []
                if (_.isEmpty(response.data)){
                    this.loading = false
                    return
                } 

                _.forEach(response.data[0].value, function (item) {
                    _.forEach(item, function (count, date) {
                        labels.push(date)
                    })
                })
                _.forEach(response.data, function (obj, key) {

                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    var dataset = {}
                    dataset.label = obj.name
                    dataset.borderColor = "rgb(" + r + "," + g + "," + b + ")"
                    dataset.data = []
                    _.forEach(obj.value, function (item) {
                        _.forEach(item, function (count, date) {
                            dataset.data.push(count)
                        })
                    })
                    datasets[key] = dataset
                })
                this.chart.bsr.labels = labels
                this.chart.bsr.datasets = datasets
                this.isLoad = true
                this.loading = false
            })
        }
    },

    mounted() {
        this.getChartDatas();
    }
}

</script>
