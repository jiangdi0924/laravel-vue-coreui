<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="clearfix">
            <h1 class="float-left display-3 mr-2">404</h1>
            <h4 class="pt-1">这个页面，不存在的</h4>
            <p class="text-muted">找不到您要访问的页面</p>
          </div>
          <div class="input-prepend input-group">
            <span class="input-group-btn">
              <button class="btn btn-info" type="button" v-on:click="redirect()">点击返回首页</button>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Page404',
  methods: {
    redirect(){
        this.$router.push({ name: 'Dashboard'})
    }

  }
}
</script>
