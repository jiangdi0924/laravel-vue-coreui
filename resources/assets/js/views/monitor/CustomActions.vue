  <template>
  <div class="custom-actions">
    <button class="btn btn-success btn-sm" @click="itemAction('show', rowData, rowIndex)"><i class="icon-eye"></i></button>
    <button class="btn btn-danger btn-sm" @click="itemAction('delete-item', rowData, rowIndex)"><i class="icon-power"></i></button>
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
    itemAction(action, data, index) {
      if (action == 'show') {
        this.$router.push({ name: 'product_detail', params: { productId: data.id } })
      } else if(action == 'delete-item'){
          axios.post('monitor/cancelasin', {listing_id: data.id})
          .then(response => {
                if (response.data.response == 1){
                    this.$notice('此商品已取消监控', { duration: 2000, style: 'warning' })

                }else if (response.data.response == 0){
                    this.$notice('操作失败', { duration: 2000, style: 'error' })
                }
                     
          })
      }

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
