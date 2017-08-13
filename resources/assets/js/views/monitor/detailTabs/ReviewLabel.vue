<template>
    <div class="col-lg-12">

        <div class="input-group">
            <div class="row">
                <code v-for="item in rowData.tag">
                    {{ item.tag }}
                </code>
            </div>
            <div class="row">
                <span class="input-group-addon">
                    <button type="button" class="btn btn-sm btn-success" v-on:click="addReviews(1, rowData, rowIndex)">好评</button>
                </span>
                <input type="text" v-model="newReview" placeholder="输入关键词" class="form-control">
                <span class="input-group-addon">
                    <button type="button" class="btn btn-sm btn-danger" v-on:click="addReviews(0, rowData, rowIndex)">差评</button>
                </span>
            </div>
        </div>
    
    </div>
</template>
<script>
export default {
    name: 'review_label',
    props: {
        rowData: {
            type: Object,
            required: true
        },
        rowIndex: {
            type: Number
        }
    },
    data() {
        return {
            ReviewsExist: [],
            newReview: '',
            review: {
                messgae: ''
            },
            rowInfo: this.rowData
        }
    },
    methods: {
        addReviews(type, rowData, rowIndex) {
            console.log(rowData)
            console.log(rowIndex)
            this.review.message = this.newReview
            axios.post('/monitor/reviewTaginsert', { review_id: rowData.id, tag: this.newReview, is_good: type, listing_id: rowData.listing_id })
                .then(response => {
                    //this.getAllReviews()
                })
            this.newReview = ''
        },
        // getAllReviews(){
        //     axios.post('monitor/reviewTagshow', {user_id: 1,listing_id: 1})
        //     .then(response => {
        //         this.ReviewsExist = response.data[1]
        //         console.log(response)
        //     })
        // }
    },
    mounted() {
        //this.getAllReviews();
    }
}
</script>

