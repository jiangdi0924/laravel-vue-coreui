<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> 变体详情
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-success" @click="largeModal = true">切换变体</button>
                        </div>
                        <div class="col-lg-2">ASIN: {{ datas.asin }}</div>
                        <div class="col-lg-2">Size: {{ datas.size }}</div>
                        <div class="col-lg-2"> Color: {{ datas.color }} </div>
                    </div>
                </div>
            </div>
            <modal title="Modal title" large v-model="largeModal" @ok="largeModal = false" effect="fade/zoom">
                <div slot="modal-header" class="modal-header">
                    <h4 class="modal-title">变体列表</h4>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>变体主图</th>
                                <th>ASIN</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in lists">
                                <td>
                                    <img v-bind:src=list.img :alt=list.img style="width: 100px;">
                                </td>
                                <td>{{ list.asin }}</td>
                                <td> {{ list.size }} </td>
                                <td> {{ list.color }} </td>
                                <td>
                                    <!--<router-link :to="'/monitor/product_detail/' + list.id + '/sale'">a</router-link>
                                                                                                <router-link :to="{ path: '/monitor/product_detail/' + list.id + '/sale' + '?_=' + (new Date).getTime()}" class="nav-link">
                                                                                                    <i class="icon-star"></i>查看</router-link>-->
                                    <button class="bbtn btn-warning" v-on:click="showVariant(list.id)">查看</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <template slot="modal-footer">
                </template>
            </modal>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> 产品详情
                </div>
                <div class="card-block">
    
                    <table class="table table-bordered">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="5">
                                    <img v-bind:src=datas.img :alt=datas.img style="width: 100px; height: 100px">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">{{ datas.name }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Boxbuy卖家：
                                    <a :href="datas.url" target="_blank">{{datas.seller_name}}</a>
                                    <!--<button class="btn btn-success">
                                                                                            <a :href="datas.url" target="_blank">查看店铺</a>
                                                                                        </button>-->
                                </td>
                                <td colspan="2">
                                    品牌: {{ datas.brand}}
    
                                    <!--<button class="btn btn-success">商标查询</button>-->
                                </td>
                            </tr>
                            <tr>
                                <td>卖家类型：{{datas.fulfillment}}</td>
                                <td>卖家数量：{{datas.competitors}} </td>
                                <td>buybox价格：{{datas.amount}}</td>
                                <td>上架时间：没有获取 </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>变体评论数：{{datas.review_count}}</td>
                                <td>变体评分：
                                    <star-rating :read-only="true" :inline="true" :show-rating="false" :increment="0.1" :fixed-points="1" :rating="datas.review_rate" :star-size="15"></star-rating>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/.col-->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <accordion :one-at-atime="checked" type="info">
                        <panel type="primary">
                            <strong slot="header">
                                <u>评论标签</u>
                            </strong>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>标签</th>
                                        <th>个数</th>
                                        <th>比例</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="detail in  tagDetail">
                                        <td> {{detail.tag}} </td>
                                        <td>{{detail.count}}</td>
                                        <td>
                                            {{detail.rate}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </panel>
                    </accordion>
    
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <!--<div class="card-header">
                                卖点
                            </div>-->
                <div class="card-block">
                    <accordion :one-at-atime="checked" type="info">
                        <panel type="primary">
                            <strong slot="header">
                                <u>卖点</u>
                            </strong>
                            <p>{{datas.features}}</p>
                            <p>{{datas.description}}</p>
                        </panel>
                    </accordion>
    
                </div>
            </div>
        </div>
    
        <div class="col-lg-12">
            <div class="card">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-2">
                            <router-link :to="'/monitor/product_detail/' + productId + '/sale'" class="btn btn-lg btn-block" active-class="aaaa">销售分析</router-link>
                        </div>
                        <div class="col-lg-2">
                            <router-link :to="'/monitor/product_detail/' + productId + '/bsr'" class="btn btn-lg btn-block" active-class="aaaa">BSR分析</router-link>
                        </div>
                        <div class="col-lg-2">
                            <router-link :to="'/monitor/product_detail/' + productId + '/keyword'" class="btn btn-lg btn-block" active-class="aaaa">关键词分析</router-link>
                        </div>
    
                        <div class="col-lg-2">
                            <router-link :to="'/monitor/product_detail/' + productId + '/review'" class="btn btn-lg btn-block" active-class="aaaa">评论分析</router-link>
                        </div>
                        <div class="col-lg-2">
                            <router-link :to="'/monitor/product_detail/' + productId + '/selling_point'" class="btn btn-lg btn-block" active-class="aaaa">卖点分析</router-link>
                        </div>
                        <div class="col-lg-2">
                            <router-link :to="'/monitor/product_detail/' + productId + '/cost'" class="btn btn-lg btn-block" active-class="aaaa">成本分析</router-link>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
        <spinner ref="spinner" size="md" fixed text=""></spinner>
    </div>
</template>

<script>
import modal from 'vue-strap/src/Modal'
import spinner from 'vue-strap/src/Spinner'
import accordion from 'vue-strap/src/Accordion'
import panel from 'vue-strap/src/Panel'
import StarRating from 'vue-star-rating'

export default {
    name: 'product_detail',
    components: { modal, spinner, accordion, panel, StarRating },
    data() {
        return {
            checked: false,
            productId: this.$route.params.productId,
            datas: '',
            asin: '',
            lists: '',
            largeModal: false,
            tagDetail: ''
        }
    },
    // beforeRouteEnter(to, from, next) {
    //     next(vm => {
    //         console.log('路有钩子执行')
    //         vm.getDetailInfo()
    //         vm.getVariantList()
    //         vm.getTagDetail()
    //     })
    // },
    mounted() {
        this.$refs.spinner.show()
        //this.$broadcast('show::spinner')

        this.getDetailInfo()
        this.getVariantList()
        this.getTagDetail()
    },
    watch: {
        '$route'(to, from) {
            // 获取最新的id 调用获取数据方法
            //this.getData(this.$route.params.productId)
            this.largeModal = false
            this.productId = this.$route.params.productId
            this.getDetailInfo()
            this.getVariantList()
            this.getTagDetail()
        }
    },
    methods: {
        getDetailInfo() {
            axios.post('monitor/asindetail', { listing_id: this.productId })
                .then(response => {
                    this.datas = response.data
                    this.$refs.spinner.hide()

                }).catch(function (error) {
                    console.log(error)
                })
        },
        getVariantList() {
            axios.post('monitor/variantlist', { amazon_model_id: this.productId })
                .then(response => {
                    this.lists = response.data
                })
        },
        showVariant(id) {
            this.$router.push({ name: 'product_detail', params: { productId: id } });
        },
        getTagDetail() {
            axios.post('monitor/tagdetail', { listing_id: this.productId })
                .then(response => {
                    this.tagDetail = response.data
                })
        }
    }
}

</script>
<style>
.aaaa {
    background-color: #63c2de;
}

a {
    text-decoration: none;
}
</style>
