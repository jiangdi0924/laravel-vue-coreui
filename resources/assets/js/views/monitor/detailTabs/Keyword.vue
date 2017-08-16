<template>
    <div class="card">
        <div class="card-header">
            我监控的关键词
            <button type="button" class="btn btn-success" @click="largeModal = true">添加关键词</button>
            <modal title="Modal title" large v-model="largeModal" @ok="largeModal = false" effect="fade/zoom">
                <div slot="modal-header" class="modal-header">
                    <h4 class="modal-title">添加广告搜索关键词</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
    
                        <span class="input-group-addon">
                            ASIN
                        </span>
                        <input type="text" placeholder="请输入ASIN" v-model="userAddKeywords" class="form-control">
                    </div>
                </div>
                <div class="modal-footer" slot="modal-footer">
                    <button type="button" class="btn btn-default" @click="largeModal = false">取消</button>
                    <button type="button" class="btn btn-success" @click="submitKeywords()">提交</button>
                </div>
            </modal>
        </div>
    
        <pacman-loader v-if="loading"></pacman-loader>
    
        <div class="card-block" v-if="loading == false">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">关键词排名列表</h4>
                    <div class="small text-muted">说明：xxxxxx</div>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>关键词</th>
                        <th>自然排名</th>
                        <th>广告排名</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="keyword in keywordLists">
                        <td>{{keyword.name}}</td>
                        <td>{{keyword.rate}}</td>
                        <td></td>
                        <td>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">关键词变化趋势图</h4>
                    <div class="small text-muted">说明：xxxxxx</div>
                </div>
                <div class="col-sm-7 hidden-sm-down">
                    <!--<button type="button" class="btn btn-primary float-right">
                                                <i class="icon-cloud-download"></i>
                                            </button>-->
                    <div role="toolbar" aria-label="Toolbar with button groups" class="btn-toolbar float-right">
                        <div data-toggle="buttons" aria-label="First group" class="btn-group mr-1">
                            <label class="btn btn-outline-secondary active">
                                <input type="radio" name="options" id="option1"> Day
                            </label>
                            <label class="btn btn-outline-secondary ">
                                <input type="radio" name="options" id="option2" checked="checked"> Month
                            </label>
                            <label class="btn btn-outline-secondary">
                                <input type="radio" name="options" id="option3"> Year
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <line-chart v-if="isLoad == true" :data="chart.keywordsRate"></line-chart>
        </div>
    </div>
</template>
<script>
import LineChart from './LineChart.vue';
import Modal from 'vue-strap/src/Modal'
import PacmanLoader from './PacmanLoader.vue'

export default {
    name: 'keyword',
    data() {
        return {
            loading: true,
            isLoad: false,
            userAddKeywords: '',
            largeModal: false,
            chart: {
                datas: [],
                priceShipFee: {
                    labels: ['201701'],
                    datasets: [
                        {
                            label: 'buybox价格',
                            borderColor: '#f87979',
                            data: [40]
                        },
                        {
                            label: 'buybox运费',
                            borderColor: 'rgb(75, 192, 192)',
                            data: [10]
                        }
                    ]
                },
                keywordsRate: {}
            },
            keywordLists: []
        }
    },
    components: {
        LineChart,
        Modal,
        PacmanLoader
    },
    methods: {
        getAsinOtherSeller() {
            axios.post('/monitor/userkeywordrate', { listing_id: this.$route.params.productId })
                .then(response => {
                    this.keywordLists = response.data
                })
        },
        submitKeywords() {
            axios.post('/monitor/insertkeywords', { keywords: this.userAddKeywords, listing_id: this.$route.params.productId })
                .then(response => {
                    console.log(response.data)
                    this.$notice('关键词添加成功，稍后来观察统计', { duration: 2000, style: 'success' })

                    // this.getAsinOtherSeller()
                    // this.getKeywordrate()
                    // if (response.data == 1) {
                    //     console.log('关键词添加成功')
                    // }
                })
            this.largeModal = false;
        },
        getKeywordrate() {
            axios.post('/monitor/userkeywordratechart', { listing_id: this.$route.params.productId })
                .then(response => {
                    var labels = []
                    var datasets = []

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
                    this.chart.keywordsRate.labels = labels
                    this.chart.keywordsRate.datasets = datasets
                    this.isLoad = true
                    this.loading = false
                })
        }
    },
    mounted() {
        this.getAsinOtherSeller()
        this.getKeywordrate()
    }
}
</script>
