  <template>
    <div class="custom-actions">
        <button class="btn btn-success btn-sm" @click="addAsin()" v-if="rowData.is_monitor == 0">
            <i class="icon-bell"></i>
        </button>
        <button class="btn btn-danger btn-sm" @click="cancelAsin()" v-else-if="rowData.is_monitor == 1">
            <i class="icon-power"></i>
            </button>
    
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
        }
    },
    methods: {
        addAsin() {
            axios.post('/monitor/addasin', { info: this.rowData.asin })
                .then(response => {
                    if (response.data.response == "1") {
                        this.$notice('添加商品成功，请24小时之后查看监控数据', { duration: 3000, style: 'success' })
                    } else {
                        this.$notice('添加失败，请确认数据格式是否正确，然后再提交', { duration: 3000, style: 'error' })

                    }

                })
        },
        cancelAsin() {
            axios.post('monitor/cancelasin', { listing_id: this.rowData.listing_id })
                .then(response => {
                    if (response.data.response == 1) {
                        this.$notice('此商品已取消监控', { duration: 3000, style: 'warning' })

                    } else if (response.data.response == 0) {
                        this.$notice('操作失败', { duration: 3000, style: 'error' })
                    }

                })
        }
    }
}
</script>

  <style>
.custom-actions button.ui.button {
    padding: 8px 8px;
}

.custom-actions button.ui.button>i.icon {
    margin: auto !important;
}
</style>
