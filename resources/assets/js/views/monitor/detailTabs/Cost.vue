<template>
    <div class="card">
        <div class="card-header">
        </div>
        <pacman-loader v-if="loading"></pacman-loader>
        <div class="card-block" v-if="loading == false">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table table-bordered">
                        <tr>
                            <td>卖家售价</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="seller_price" placeholder="seller_price" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>我的售价</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="my_price" placeholder="my_price" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>平台费</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="channel_fee" placeholder="channel_fee" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>拣货费</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="picking_fee" placeholder="picking_fee" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>重量运费</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="weight_shipping_fee" placeholder="weight_shipping_fee" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>仓储费</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="warehousing_fee" placeholder="warehousing_fee" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>头程运费</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="headline_shipping_fee" placeholder="headline_shipping_fee" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>推广占比</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        %
                                    </span>
                                    <input type="text" v-model="promotion_rate" placeholder="promotion_rate" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>利润率</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        %
                                    </span>
                                    <input type="text" v-model="profit_rate" placeholder="profit_rate" class="form-control">
                                </div>
                            </td>
                        </tr>
    
                    </table>
                </div>
                <div class="col-lg-5">
                    <table class="table">
                        <tr>
                            <td>推广费用</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="promotion" placeholder="promotion" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>净利</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="profit" placeholder="profit" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>FOB价格</td>
                            <td>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        $
                                    </span>
                                    <input type="text" v-model="fob_price" placeholder="fob_price" class="form-control">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td rowspan="2">
                                <div class="input-group">
                                    <button class="btn btn-success" @click="getUserEditInfo()">提交</button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
    
        </div>
    </div>
</template>
<script>
    import PacmanLoader from './PacmanLoader.vue'

    export default {
    name: 'cost',
    data() {
        return {
            loading: true,
            seller_price: 0,
            my_price: 0,
            channel_fee: 0,
            picking_fee: 0,
            weight_shipping_fee: 0,
            warehousing_fee: 0,
            headline_shipping_fee: 0,
            promotion_rate: 0,
            profit_rate: 0
        }
    },
    components:{
        PacmanLoader
    },
    computed: {
        fob_price: function () {
            return this.my_price - this.channel_fee - this.picking_fee - this.weight_shipping_fee - this.warehousing_fee - this.headline_shipping_fee - this.my_price * this.profit_rate * 0.01 - this.my_price * this.promotion_rate * 0.01
        },
        profit: function () {
            return this.my_price * this.profit_rate * 0.01
        },
        promotion: function () {
            return this.my_price * this.promotion_rate * 0.01
        }
    },
    methods: {
        getUserEditInfo() {
            axios.post('/monitor/calculate',
                {
                    listing_id: this.$route.params.productId,
                    seller_price: this.seller_price,
                    my_price: this.my_price,
                    channel_fee: this.channel_fee,
                    picking_fee: this.picking_fee,
                    weight_shipping_fee: this.weight_shipping_fee,
                    warehousing_fee: this.warehousing_fee,
                    headline_shipping_fee: this.headline_shipping_fee,
                    promotion_rate: this.promotion_rate,
                    profit_rate: this.profit_rate
                }).then(response => {
                    this.$notice('编辑成功', { duration: 2000, style: 'success' })
                })
        },
        getUserCloumn(){
            axios.post('/monitor/calculatelist', {listing_id: this.$route.params.productId})
                .then(response => {
                    if (! _.isEmpty(response.data)){
                        this.seller_price = response.data[0].seller_price
                        this.my_price = response.data[0].my_price
                        this.channel_fee = response.data[0].channel_fee
                        this.picking_fee = response.data[0].picking_fee
                        this.weight_shipping_fee = response.data[0].weight_shipping_fee
                        this.warehousing_fee = response.data[0].warehousing_fee
                        this.headline_shipping_fee = response.data[0].headline_shipping_fee
                        this.promotion_rate = response.data[0].promotion_rate
                        this.profit_rate = response.data[0].profit_rate
                    }
                    this.loading = false
                })
        }
    },
    mounted() {
        this.getUserCloumn()
    }

}
</script>
