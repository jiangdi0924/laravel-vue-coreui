<template>
    <div>
        <div class="row">
            <div class="col-sm-2 col-md-2">
                <div class="card card-accent-success">
                    <div class="card-block">
                        <b>关键词名称：</b>
                        <p>{{this.listInfo.name}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-accent-success">
    
                    <div class="card-block">
                        <b>论评评分：</b>
                        <p>{{this.listInfo.avg_review_rate}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-accent-success">
    
                    <div class="card-block">
                        <b>评论个数：</b>
                        <p>{{this.listInfo.avg_review_count}}</p>
    
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-accent-success">
    
                    <div class="card-block">
                        <b>卖家个数：</b>
                        <p>{{this.listInfo.avg_seller_num}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-accent-success">
    
                    <div class="card-block">
                        <b>评论总数：</b>
                        <p>{{this.listInfo.avg_review_count}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-2">
                <div class="card card-accent-success">
    
                    <div class="card-block">
                        <b>平均价格：</b>
                        <p>${{this.listInfo.avg_amount}}</p>
                    </div>
                </div>
            </div>
    
        </div>
        <div class="card">
            <div class="card-header">
                该关键词下的所有商品
            </div>
            <!--<pacman-loader v-if="loading"></pacman-loader>-->
            <div class="card-block">
                <!--<filter-bar></filter-bar>-->
                <vuetable ref="vuetable" :options="options" :api-url="url" :fields="fields" pagination-path="" :css="css.table" :sort-order="sortOrder" :multi-sort="true" :append-params="moreParams" @vuetable:pagination-data="onPaginationData">
                    <template slot="image" scope="props">
                        <img :src="props.rowData.img" :alt="props.rowData.img" width="100px" height="100px">
                    </template>
                </vuetable>
                <div class="vuetable-pagination">
                    <vuetable-pagination-info ref="paginationInfo" info-class="pagination-info"></vuetable-pagination-info>
                    <vuetable-pagination ref="pagination" :css="css.pagination" :icons="css.icons" @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PacmanLoader from './detailTabs/PacmanLoader.vue'
import accounting from 'accounting'
import moment from 'moment'
import Vuetable from 'vuetable-2/src/components/Vuetable'
import VuetablePagination from 'vuetable-2/src/components/VuetablePagination'
import VuetablePaginationInfo from 'vuetable-2/src/components/VuetablePaginationInfo'
import Vue from 'vue'
import VueEvents from 'vue-events'
import BsrAction from './BsrAction.vue'
import DetailRow from './DetailRow'
import FilterBar from './FilterBar'
import KeywordDetailOption from './KeywordDetailOption'

Vue.use(VueEvents)
Vue.component('bsr-actions', BsrAction)
Vue.component('my-detail-row', DetailRow)
Vue.component('filter-bar', FilterBar)
Vue.component('keyword-detail-option', KeywordDetailOption)
export default {
    name: 'keyword_list',
    data() {
        return {
            listInfo: '',
            loading: true,
            url: '/keyword/keyworddetail?keyword_id=' + this.$route.params.keywordId,
            largeModal: false,
            options: {
                filterByColumn: true,
                listColumns: {
                    pet: [{
                        id: '0',
                        text: 'Guinea Pig'
                    }, {
                        id: '1',
                        text: 'Dog'
                    }, {
                        id: '2',
                        text: 'Cat'
                    }, {
                        id: '3',
                        text: 'Goldfish'
                    }, {
                        id: '4',
                        text: 'Hamster'
                    }]
                },
            },
            fields: [
                {
                    name: '__sequence',
                    title: '#id',
                    titleClass: 'text-right',
                    dataClass: 'text-right'
                },
                {
                    name: '__slot:image',
                    title: '商品图片'
                },

                {
                    name: 'name',
                    title: '商品名称',
                    sortField: 'name',
                },
                {
                    name: 'asin',
                    title: '品牌',
                },
                {
                    name: 'brand',
                    title: '品牌',
                },
                {
                    name: 'review_rate',
                    title: '评分',
                },
                {
                    name: 'seller_num',
                    title: '卖家数量',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                // {
                //     name: 'avg_listing_review_count',
                //     title: '商品平局评论数',

                //     titleClass: 'text-center',
                //     dataClass: 'text-right',
                // },
                {
                    name: '__component:keyword-detail-option',
                    title: '操作',
                    titleClass: 'text-center',
                    dataClass: 'text-center'
                }
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
                { field: 'id', sortField: 'id', direction: 'desc' }
            ],
            moreParams: {}
        }
    },
    methods: {
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
        getInfo() {
            axios.post('/bsr/bsrdetail', { bsr_id: this.$route.params.bsrId })
                .then(response => {

                })
        },
        getKeywordListInfo() {
            axios.post('/keyword/keywordlist', { keyword_id: this.$route.params.keywordId })
                .then(response => {
                    this.listInfo = response.data.data[0]
                })
        }

    },
    events: {
        'filter-set'(filterText) {
            this.moreParams = {
                filter: filterText
            }
            Vue.nextTick(() => this.$refs.vuetable.refresh()
            )
        },
        'filter-reset'() {
            this.moreParams = {}
            Vue.nextTick(() => this.$refs.vuetable.refresh()
            )
        }
    },
    components: {
        PacmanLoader,
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo,
    },
    mounted() {
        // this.getInfo()
        this.getKeywordListInfo()
    }
}
</script>
<style>
.pagination {
    margin: 0;
    float: right;
}

.pagination a.page {
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 10px;
    margin-right: 2px;
}

.pagination a.page.active {
    color: white;
    background-color: #337ab7;
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 10px;
    margin-right: 2px;
}

.pagination a.btn-nav {
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 7px;
    margin-right: 2px;
}

.pagination a.btn-nav.disabled {
    color: lightgray;
    border: 1px solid lightgray;
    border-radius: 3px;
    padding: 5px 7px;
    margin-right: 2px;
    cursor: not-allowed;
}

.pagination-info {
    float: left;
}

.vuetable-th-name {
    width: 400px;
}
</style>