<template>
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Combined All Table
                    </div>
                    <div class="card-block">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品主图</th>
                                <th style="width: 30%">产品名称</th>
                                <th>商品BSR及品类</th>
                                <th>品牌</th>
                                <th>评论</th>
                                <th>竞争对手</th>
                                <th>评分</th>
                                <th>卖家数量</th>
                                <!--<th>链接</th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in datas">
                                <td ><a v-on:click="detail(item.id)">{{ item.id }}</a></td>
                                <td>
                                    <img v-bind:src = item.img :alt= item.img style="width: 100px; height: 100px" >
                                </td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.bsr_name }}</td>
                                <td>{{ item.brand }}</td>
                                <td>{{ item.comments }}</td>
                                <td>{{ item.competitors }}</td>
                                <td>{{ item.score }}</td>
                                <td>{{ item.followers }}</td>
                                <!--<td>{{ item.url }}</td>-->
                            </tr>
                            </tbody>
                        </table>
                        <nav>
                            <!--<ul class="pagination">-->
                                <!--<li class="page-item"><a class="page-link" href="#">Prev</a></li>-->
                                <!--<li class="page-item active">-->
                                    <!--<a class="page-link" href="#">1</a>-->
                                <!--</li>-->
                                <!--<li class="page-item"><a class="page-link" href="#">2</a></li>-->
                                <!--<li class="page-item"><a class="page-link" href="#">3</a></li>-->
                                <!--<li class="page-item"><a class="page-link" href="#">4</a></li>-->
                                <!--<li class="page-item"><a class="page-link" href="#">Next</a></li>-->
                            <!--</ul>-->
                            <pagination :current-page="pageOne.currentPage"
                                        :total-pages="pageOne.totalPages"
                                        :visible-pages="pageOne.visiblePages"
                                        @page-changed="pageOneChanged">
                            </pagination>
                        </nav>
                    </div>
                </div>
            </div><!--/.col-->
        </div><!--/.row-->


    </div>

</template>

<script>
    import Pagination from '../common/Pagination.vue'

    export default {
        components:{ Pagination },
        name: 'product',
        data() {
            return {
                pageOne: {
                    currentPage: 1,
                    totalPages: 0,
                    visiblePages:1
                },
                filters: {
                    product_name: false,
                    product_nam: false,
                    product_nae: false,
                    product_nme: false,
                    product_ame: false,
                },
                datas: []

            }
        },
        methods: {
            pageOneChanged (pageNum) {
                this.pageOne.currentPage = pageNum
                this.getPageInfo()
            },
            getPageInfo (){
                axios.post('monitor/productdetail', {current_page: this.pageOne.currentPage, per_page: 5, filters: this.filters})
                    .then(response => {
                        this.datas = response.data.data
                        this.pageOne.totalPages = response.data.last_page
                        if (response.data.last_page < 5){
                            this.pageOne.visiblePages = response.data.last_page
                        }
                    }).catch(function (error) {
                    console.log(error)
                })
            },
            detail (productId) {
                this.$router.push({ name: 'product_detail', params: { productId: productId }})
            }
        },
        mounted (){
            this.getPageInfo()
        }
    }
</script>
