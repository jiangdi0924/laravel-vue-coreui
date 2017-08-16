<template>
    <div class="card">
        <div class="card-header">
            评论分析
        </div>
        <pacman-loader v-if="loading"></pacman-loader>
    
        <div class="card-block" v-if="loading == false">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">评分饼状图：</h4>
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
            <review-chart></review-chart>
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">评分趋势图：</h4>
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
            <line-chart v-if="dataIsLoading == true" :data="chart.reviews"></line-chart>
        </div>
    </div>
</template>
<script>
import ReviewChart from './ReviewChart.vue'
import LineChart from './LineChart.vue'
import PacmanLoader from './PacmanLoader.vue'

export default {
    name: 'review',
    components: {
        ReviewChart,
        LineChart,
        PacmanLoader
    },
    data() {
        return {
            loading: true,
            dataIsLoading: false,
            chart: {
                datas: [],
                reviews: {
                    labels: [],
                    datasets: [
                        {
                            label: '评论数',
                            borderColor: '#f87979',
                            data: []
                        }
                    ]
                },
            }
        }
    },
    methods: {
        getReviews() {
            axios.post('/monitor/reviewgraph', { listing_id: this.productId }).then(response => {
                var labels = []
                var total = []
                _.forEach(response.data, function (value, date) {
                    labels.push(date)
                    total.push(value.total)
                })
                this.chart.reviews.labels = labels
                this.chart.reviews.datasets[0].data = total

                this.dataIsLoading = true
                this.loading = false
            })
        }
    },
    mounted() {
        this.getReviews()
    }

}
</script>
