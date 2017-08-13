<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
    
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> BSR分类列表
    
                </div>
                <div class="card-block">
                    <modal title="Modal title" large v-model="largeModal" @ok="largeModal = false" effect="fade/zoom">
                        <div slot="modal-header" class="modal-header">
                            <h4 class="modal-title">添加BSR</h4>
                        </div>
                        <div class="modal-body">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    URL
                                </span>
                                <input type="text" placeholder="请输入url" v-model="url" class="form-control">
                            </div>
    
                        </div>
                        <div class="modal-footer" slot="modal-footer">
                            <button type="button" class="btn btn-default" @click="largeModal = false">取消</button>
                            <button type="button" class="btn btn-success" @click="addBsr()">提交</button>
                        </div>
                    </modal>
    
                    <div class="row">
                        <div class="col-sm-5">
                            <bsr-filter-bar></bsr-filter-bar>
                        </div>
                        <div class="col-sm-7 hidden-sm-down">
                            <div role="toolbar" aria-label="Toolbar with button groups" class="btn-toolbar float-right">
                                <button type="button" class="btn btn-success" @click="largeModal = true">添加BSR</button>
                            </div>
                        </div>
                    </div>
                    <vuetable ref="vuetable" :options="options" api-url="/bsr/bsrlist" :fields="fields" pagination-path="" :css="css.table" :sort-order="sortOrder" :multi-sort="true" :append-params="moreParams" @vuetable:pagination-data="onPaginationData">
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
        <!--/.col-->
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
import BsrAction from './BsrAction.vue'
import DetailRow from './DetailRow'
import FilterBar from './BsrFilterBar'
import Modal from 'vue-strap/src/Modal'

Vue.use(VueEvents)
Vue.component('bsr-actions', BsrAction)
Vue.component('my-detail-row', DetailRow)
Vue.component('bsr-filter-bar', FilterBar)

export default {
    components: {
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo,
        Modal,
    },
    data() {
        return {
            url: '',
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
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                // {
                //   name: '__checkbox',
                //   titleClass: 'text-center',
                //   dataClass: 'text-center',
                // },
                {
                    name: 'name',
                    title: '品类名称',
                    sortField: 'name',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                {
                    name: 'avg_amount',
                    title: '商品平均价格',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                {
                    name: 'avg_seller_num',
                    title: '商品平均卖家数',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                {
                    name: 'avg_brand',
                    title: '品牌数量',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                {
                    name: 'avg_listing_review_count',
                    title: '商品评论数',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                {
                    name: '__component:bsr-actions',
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
        formatDate(value, fmt = 'YYYY MM DD') {
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
        addBsr() {
            axios.post('/bsr/bsradd', { url: this.url })
                .then(response => {
                    this.largeModal = false
                    this.$notice('链接添加成功', { duration: 2000, style: 'success' })
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
    mounted() {
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






/*.vuetable-th-name {
    width: 250px;
}*/
</style>