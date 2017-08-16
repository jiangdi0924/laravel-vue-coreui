<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
    
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> 商品列表
                </div>
                <div class="card-block">
                    <modal title="Modal title" large v-model="largeModal" @ok="largeModal = false" effect="fade/zoom">
                        <div slot="modal-header" class="modal-header">
                            <h4 class="modal-title">添加商品监控</h4>
                        </div>
                        <div class="modal-body">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    Asin或者商品链接:
                                </span>
                                <input type="text" v-model="info" placeholder="请输入Asin或者商品链接" class="form-control">
    
                            </div>
    
                        </div>
                        <div class="modal-footer" slot="modal-footer">
                            <button type="button" class="btn btn-default" @click="largeModal = false">取消</button>
                            <button type="button" class="btn btn-success" @click="addAsin()">提交</button>
                        </div>
                    </modal>
    
                    <div class="row">
                        <div class="col-sm-5">
                            <filter-bar placeholder="商品图片"></filter-bar>
                        </div>
                        <div class="col-sm-7 hidden-sm-down">
                            <div role="toolbar" aria-label="Toolbar with button groups" class="btn-toolbar float-right">
                                <button type="button" class="btn btn-success" @click="largeModal = true">添加商品</button>
                            </div>
                        </div>
                    </div>
    
                    <vuetable ref="vuetable" :options="options" api-url="/monitor/productdetail" :fields="fields" pagination-path="" :css="css.table" :sort-order="sortOrder" :multi-sort="true" :append-params="moreParams" @vuetable:pagination-data="onPaginationData">
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
import CustomActions from './CustomActions'
import DetailRow from './DetailRow'
import FilterBar from './FilterBar'
import Modal from 'vue-strap/src/Modal'

Vue.use(VueEvents)
Vue.component('custom-actions', CustomActions)
Vue.component('my-detail-row', DetailRow)
Vue.component('filter-bar', FilterBar)

export default {
    components: {
        Vuetable,
        VuetablePagination,
        VuetablePaginationInfo,
        Modal,
    },
    data() {
        return {
            info: '',
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
                // {
                //   name: '__checkbox',
                //   titleClass: 'text-center',
                //   dataClass: 'text-center',
                // },

                {
                    name: '__slot:image',
                    title: '商品图片'
                },
                {
                    name: 'name',
                    title: '商品名称',
                    sortField: 'name',
                    dataClass: 'center aligned'
                },
                {
                    name: 'asin',
                    title: 'Asin',
                    sortField: 'asin',
                },
                {
                    name: 'brand',
                    title: '品牌',
                },
                {
                    name: 'bsr_name',
                    title: 'BSR名称',
                    titleClass: 'text-center',
                    dataClass: 'text-center',
                },
                {
                    name: 'comments',
                    title: '评论',

                    titleClass: 'text-center',
                    dataClass: 'text-right',
                },
                {
                    name: 'competitors',
                    title: '竞争对手',

                    titleClass: 'text-center',
                    dataClass: 'text-right',
                },
                {
                    name: 'score',
                    title: '评分',

                    titleClass: 'text-center',
                    dataClass: 'text-right',
                },
                {
                    name: 'followers',
                    title: '卖家数量',

                    titleClass: 'text-center',
                    dataClass: 'text-right',
                },
                {
                    name: 'created_at',
                    title: '添加时间',

                    titleClass: 'text-center',
                    dataClass: 'text-center',
                    callback: 'formatDate|YYYY-MM-DD'
                },
                {
                    name: '__component:custom-actions',
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
        addAsin() {
            axios.post('/monitor/addasin', { info: this.info })
                .then(response => {
                    console.log(response.data.response)
                    if (response.data.response == 1) {
                        this.largeModal = false
                        this.$notice('添加商品成功，请24小时之后查看监控数据', { duration: 3000, style: 'success' })
                        Vue.nextTick(() => this.$refs.vuetable.refresh()
                        )
                    } else {
                        this.$notice('添加失败，请确认数据格式是否正确，然后再提交', { duration: 3000, style: 'error' })
                    }
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