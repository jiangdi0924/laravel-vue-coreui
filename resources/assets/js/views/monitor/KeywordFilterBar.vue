<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="form-group">
          <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="关键词名称">
          <button class="btn btn-primary" @click.prevent="doFilter">搜索</button>
          <button class="btn" @click.prevent="resetFilter">取消</button>
        </div>
      </form>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        filterText: ''
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
