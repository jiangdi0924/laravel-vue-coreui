<template>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
    
            </div>
            <div class="card-block">
                <button type="button" class="btn btn-secondary" @click="largeModal = true">切换变体2</button>
            </div>
        </div>
        <modal title="Modal title" large v-model="largeModal" @ok="largeModal = false" effect="fade/zoom">
            <div slot="modal-header" class="modal-header">
                <h4 class="modal-title">Modal title</h4>
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
                                <img v-bind:src=list.url :alt=list.url style="width: 100px; height: 100px">
                            </td>
                            <td>{{ list.asin }}</td>
                            <td> {{ list.size }} </td>
                            <td> {{ list.color }} </td>
                            <td>
                                <router-link :to="{ name: 'product_detail', params: { productId: list.id } } + 'sale'" class="nav-link" exact><i class="icon-star"></i> Error 222</router-link>
                                <button class="bbtn btn-warning" v-on:click="showVariant(list.id)">查看</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </modal>
        <!--/.col-->
        <!--<ul>
                <li v-for="item in lists">
                    <button v-on:click="showVariant(item.id)">链接</button>
                </li>
            </ul>-->
    </div>
</template>
<script>
import modal from 'vue-strap/src/Modal'
export default {
    name: 'variant',
    props: {
        productId: {
            type: String,
            required: true
        },
    },
    components: {
        modal
    },
    data() {
        return {
            lists: '',
            largeModal: false
        }
    },
    methods: {
        getVariantList() {
            axios.post('monitor/variantlist', { amazon_model_id: this.productId })
                .then(response => {
                    console.log(response.data)
                    this.lists = response.data
                })
        },
        showVariant(id) {
            console.log(id);
            this.$router.replace({ name: 'product_detail', params: { productId: id } });
        }
    },
    mounted() {
        this.getVariantList()
    }
}
</script>
