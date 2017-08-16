<template>
    <div class="card">
        <!--<div class="card-header">
                           评论分析
                        </div>-->
        <pacman-loader v-if="loading"></pacman-loader>
    
        <div class="card-block" v-if="loading == false">
            <!--<h2>Boybox价格/运费趋势图4</h2>-->
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">Boybox价格/运费趋势图</h4>
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
            <price-and-ship-fee v-if="dataIsLoading==true" :data="chart.buyboxPrice"></price-and-ship-fee>
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">卖家数量变化趋势图</h4>
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
    
            <line-chart v-if="dataIsLoading==true" :data="chart.sellerNumber"></line-chart>
    
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">B卖家库存变化趋势图</h4>
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
    
            <line-chart v-if="dataIsLoading==true" :data="chart.sellerCouponNumber"></line-chart>    
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">其他卖家列表</h4>
                    <div class="small text-muted">说明：xxxxxx</div>
                </div>
                <div class="col-sm-7 hidden-sm-down">
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>店铺logo</th>
                        <th>卖家名称</th>
                        <th>当前变体价格</th>
                        <th>当前变体运费</th>
                        <th>卖家类型</th>
                        <th>操作</th>
    
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="keyword in AsinOtherSeller">
                        <td>
                            <img v-bind:src=keyword.logo :alt=keyword.logo style="width: 100px;">
                        </td>
                        <td>{{ keyword.sell_name }}</td>
                        <td>{{keyword.amount}}</td>
                        <td>{{keyword.shipping_fee}}</td>
                        <td>{{keyword.fulfillment}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
import LineChart from './LineChart.vue';

import PriceAndShipFee from './PriceAndShipFee.vue';
import PacmanLoader from './PacmanLoader.vue'

export default {
    name: 'sale',
    data() {
        return {
            loading: true,
            productId: this.$route.params.productId,
            dataIsLoading: false,
            chart: {
                datas: [],
                buyboxPrice: {
                    period: 7,
                    labels: [],
                    datasets: [
                        {
                            label: 'buybox价格',
                            borderColor: '#f87979',
                            data: []
                        },
                        {
                            label: 'buybox运费',
                            borderColor: 'rgb(75, 192, 192)',
                            data: []
                        }
                    ]
                },
                sellerNumber: {
                    labels: [],
                    datasets: [
                        {
                            label: '卖家数量',
                            borderColor: '#f87979',
                            data: []
                        }
                    ]
                },
                sellerCouponNumber: {
                    labels: [],
                    datasets: [
                        {
                            label: '库存数量',
                            borderColor: '#f87979',
                            data: []
                        }
                    ]
                }
            },
            AsinOtherSeller: []

        }
    },
    //    beforeRouteEnter (to, from, next) {
    //        next(vm => {
    //            vm.getChartDatas()
    //            vm.getAsinOtherSeller()
    //        })
    //    },
    components: {
        PriceAndShipFee,
        LineChart,
        PacmanLoader
    },
    methods: {
        getChartDatas() {
            axios.post('/monitor/graph').then(response => {
                var labels = []
                var price = []
                var shipping = []

                var quantity = []

                var seller_num = []
                _.forEach(response.data, function (value, date) {
                    labels.push(date)
                    _.forEach(value, function (item) {
                        price.push(item.amount)
                        shipping.push(item.shipping_fee)
                        seller_num.push(item.seller_num)
                        quantity.push(item.quantity)
                    })
                })
                this.chart.buyboxPrice.labels = labels
                this.chart.buyboxPrice.datasets[0].data = price
                this.chart.buyboxPrice.datasets[1].data = shipping

                this.chart.sellerNumber.labels = labels
                this.chart.sellerNumber.datasets[0].data = seller_num

                this.chart.sellerCouponNumber.labels = labels
                this.chart.sellerCouponNumber.datasets[0].data = quantity

                this.dataIsLoading = true
            })
        },
        getAsinOtherSeller() {
            axios.post('/monitor/asinotherseller', { listing_id: this.productId })
                .then(response => {
                    this.AsinOtherSeller = response.data
                    this.loading = false
                })
        }
    },
    mounted() {
        //        this.getChartDatas()
        //        this.getAsinOtherSeller()
    },
    created() {
        this.getChartDatas()
        this.getAsinOtherSeller()
    }
}

</script>
