<template>
    <div class="card">
        <div class="card-header">
            卖点分析
        </div>
        <!--<review-label></review-label>-->
        <pacman-loader v-if="loading"></pacman-loader>
    
        <div class="card-block" v-if="loading == false">
            <!--<h2>评论分布</h2>
        
                <table class="table">
                    <thead>
                        <tr>
                            <th>五星评论</th>
                            <th>四星评论</th>
                            <th>三星评论</th>
                            <th>二星评论</th>
                            <th>一星评论</th>
                            <th>总评论</th>
        
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {{rateStar.five_rate}}
                            </td>
                            <td>{{rateStar.four_rate}}</td>
                            <td>{{rateStar.three_rate}}</td>
                            <td>{{rateStar.two_rate}}</td>
                            <td>{{rateStar.one_rate}}</td>
                            <td>{{rateStar.total_num}}</td>
                        </tr>
                    </tbody>
                </table>-->
    
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">评论列表:</h4>
                    <!--<div class="small text-muted">说明：xxxxxx</div>-->
                </div>
            </div>
    
            <vuetable ref="vuetable" detail-row-component="DetailRow" @vuetable:cell-clicked="onCellClicked" :per-page="5" :sort-order="sortOrder" :data="allTags" :api-url="apiUrl" :fields="fields" pagination-path="" :css="css.table" :multi-sort="true" :append-params="moreParams" @vuetable:pagination-data="onPaginationData">
                <template slot="image" scope="props">
                    <button type="button" class="btn btn-sm btn-success" @click="openTabs(props.rowData)">+</button>
                </template>
            </vuetable>
            <div class="vuetable-pagination">
                <vuetable-pagination-info ref="paginationInfo" info-class="pagination-info"></vuetable-pagination-info>
                <vuetable-pagination ref="pagination" :css="css.pagination" :icons="css.icons" @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
            </div>
        </div>
    </div>
</template>
<script>
import accounting from 'accounting'
import moment from 'moment'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import DetailRow from './DetailRow'
import PacmanLoader from './PacmanLoader.vue'

// import ReviewLabel from './ReviewLabel'

Vue.use(VueEvents)
// Vue.component('review-label', ReviewLabel)
Vue.component('DetailRow', DetailRow)

export default {
    name: 'selling_point',
    // mounted() {
    //     this.getReviewinfostar()
    // },
    components: {
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo,
        PacmanLoader
    },
    data() {
        return {
            allTags: [1,2,3,4,5,6,7,8],
            loading: false,
            rateStar: [],
            productId: this.$route.params.productId,
            apiUrl: '/monitor/reviewinfo?listing_id=' + this.$route.params.productId,
            options: {
                filterByColumn: true,
            },
            fields: [
                {
                    name: '__slot:image',
                    title: '评论标签'
                },
                {
                    name: 'id',
                    title: '#id',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'reviewer',
                    title: '评论者',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'is_vp',
                    title: '真实评论',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'supports',
                    title: 'supports',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'rate',
                    title: '星级',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                },
                {
                    name: 'created_at',
                    title: '添加时间',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'formatDate|YYYY-MM-DD'
                },
                // {
                //     name: '__component:review-label',
                //     title: '操作',
                //     titleClass: 'text-center',
                //     dataClass: 'text-center'
                // }
            ],
            css: {
                table: {
                    tableClass: 'table table-bordered',
                    loadingClass: 'loading',
                    ascendingIcon: 'fa fa-sort-amount-asc fa-lg mt-2',
                    descendingIcon: 'fa fa-sort-amount-desc fa-lg mt-2',
                    handleIcon: 'glyphicon glyphicon-menu-hamburger',
                    ascendingIcon: 'icon-arrow-up-circle',
                    descendingIcon: 'icon-arrow-down-circle',
                },
                pagination: {
                    wrapperClass: 'pagination pull-right',
                    activeClass: 'btn-primary',
                    disabledClass: 'disabled',
                    pageClass: 'btn btn-border',
                    linkClass: 'btn btn-border',
                    icons: {
                        first: '',
                        prev: '',
                        next: '',
                        last: '',
                    }
                }
            },
            sortOrder: [
                { field: 'listing_id', sortField: 'listing_id', direction: 'desc' }
            ],
            moreParams: {} //更多查询
        }
    },
    methods: {
        getProductAllTags() {
            axios.post('/monitor/reviewTagshow', { listing_id: this.productId })
                .then(response => {
                    this.loading = false
                    this.allTags = response.data
                })
        },
        getReviewinfostar() {
            axios.post('/monitor/reviewinfostar', { listing_id: this.productId })
                .then(response => {
                    this.rateStar = response.data
                })
        },
        allcap(value) {
            return value.toUpperCase()
        },
        formatNumber(value) {
            return accounting.formatNumber(value, 2)
        },
        formatDate(value, fmt = 'D MMM YYYY') {
            return (value == null)
                ? ''
                : moment(value, 'YYYY-MM-DD').format(fmt)
        },
        onPaginationData(paginationData) {
            this.$refs.pagination.setPaginationData(paginationData)
            this.$refs.paginationInfo.setPaginationData(paginationData)
        },
        onChangePage(page) {
            this.$refs.vuetable.changePage(page)
        },
        onCellClicked(data, field, event) {
            console.log('cellClicked: ', field.name)
            this.$refs.vuetable.toggleDetailRow(data.id)
        },
        openTabs(rowData) {
            this.$refs.vuetable.toggleDetailRow(rowData.id)
        },
    },
    events: {
        'filter-set'(filterText) {
            this.moreParams = {
                filter: filterText
            }
            Vue.nextTick(() => this.$refs.vuetable.refresh())
        },
        'filter-reset'() {
            this.moreParams = {}
            Vue.nextTick(() => this.$refs.vuetable.refresh())
        }
    },
    mounted() {
        //this.getProductAllTags()
    }
}

</script>

<style>
/*.vuetable-th-content{
    width: 600px;
}*/
</style>

