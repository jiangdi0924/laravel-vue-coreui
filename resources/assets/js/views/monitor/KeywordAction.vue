  <template>
  <div class="custom-actions">
    <button class="btn btn-success btn-sm" @click="itemAction('show', rowData, rowIndex)"><i class="icon-eye"></i></button>
    <!--<button class="btn btn-danger btn-sm" @click="itemAction('delete-item', rowData, rowIndex)">取消</button>-->
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
        this.$router.push({ name: 'keyword_deatil', params: { keywordId: data.keyword_id } })
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
