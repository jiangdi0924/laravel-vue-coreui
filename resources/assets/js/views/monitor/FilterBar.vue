<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="form-group">
          <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="商品名称， Asin, 品牌">
          <button class="btn btn-primary" @click.prevent="doFilter">搜索</button>
          <button class="btn" @click.prevent="resetFilter">取消</button>
        </div>
      </form>
    </div>
</template>

<script>
  export default {
    props: {
      placeholder: {
            type: String,
            default: ''
      }
    },
    data () {
      return {
        filterText: '',
      }
    },
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      }
    }
  }
</script>
<style>
.filter-bar {
  padding: 10px;
}
</style>
