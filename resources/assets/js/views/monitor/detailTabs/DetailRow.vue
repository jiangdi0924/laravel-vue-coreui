<template>
    <div class="col-lg-12">
        <div class="inline field">
            <b>
                <p>{{ rowData.content }} </p>
            </b>
            <b>
                <p>{{ rowData.cn_content }} </p>
            </b>
        </div>
        <div class="inline field">
            <p>
                好评标签：
                <code v-for="item in rowInfo.tag" v-if="item.is_good == 1">
                    {{ item.tag }}
                </code>
            </p>
            <p>
                差评标签：
                <code v-for="item in rowInfo.tag" v-if="item.is_good == 0">
                    {{ item.tag }}
                </code>
            </p>
        </div>
        <div class="inline field">
            <div class="input-group">
                <span class="input-group-addon">
                    <button type="button" class="btn btn-sm btn-success" v-on:click="addReviews(1, rowData, rowIndex)">好评</button>
                </span>
                <input type="text" v-model="newReview" placeholder="输入标签内容" class="form-control">
                <span class="input-group-addon">
                    <button type="button" class="btn btn-sm btn-danger" v-on:click="addReviews(0, rowData, rowIndex)">差评</button>
                </span>
            </div>
        </div>
        <p>
            参考好评：
            <button v-for="item in userAddTags" v-if="item.is_good == 1" type="button" class="btn btn-sm btn-success text" @click="addReviewsByAdvice(item.is_good, item.tag)">
                <span>{{item.tag}}</span>
            </button>
        </p>
        <p>
            参考差评：
            <button v-for="item in userAddTags" v-if="item.is_good == 0" type="button" class="btn btn-sm btn-danger text" @click="addReviewsByAdvice(item.is_good, item.tag)">
                <span>{{item.tag}}</span>
            </button>
        </p>
    </div>
</template>

<script>
export default {
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number
        },
        data: {},
    },
    data() {
        return {
            ReviewsExist: [],
            newReview: '',
            review: {
                messgae: ''
            },
            rowInfo: this.rowData,
            userAddTags: []
        }
    },
    methods: {
        addReviews(type, rowData, rowIndex) {
            this.review.message = this.newReview
            axios.post('/monitor/reviewTaginsert', { review_id: rowData.id, tag: this.newReview, is_good: type, listing_id: rowData.listing_id })
                .then(response => {
                    this.$notice('标签添加成功', { duration: 2000, style: 'success' })
                    this.getAllReviews()
                })
            this.newReview = ''
        },
        getAllReviews() {
            axios.post('monitor/reviewTagshow', { listing_id: this.rowData.listing_id, review_id: this.rowData.id })
                .then(response => {
                    this.rowInfo.tag = response.data
                })
        },
        getProductAllTags() {
            axios.post('/monitor/reviewTagshow', { listing_id: this.rowData.listing_id })
                .then(response => {
                    this.userAddTags = response.data
                })
        },
        addReviewsByAdvice(type, tag) {

            axios.post('/monitor/reviewTaginsert', { review_id: this.rowData.id, tag: tag, is_good: type, listing_id: this.rowData.listing_id })
                .then(response => {
                    this.$notice('标签添加成功', { duration: 2000, style: 'success' })
                    this.getAllReviews()
                })
        }
    },
    mounted() {
        this.getProductAllTags()
    }
}
</script>
