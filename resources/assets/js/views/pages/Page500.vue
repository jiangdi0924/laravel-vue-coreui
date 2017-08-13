<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="clearfix">
                        <h1 class="float-left display-3 mr-2">500</h1>
                        <h4 class="pt-1">服务器出了点问题</h4>
                        <p class="text-muted">您访问的页面暂时没办法显示,请联系我们</p>
                    </div>
                    <div class="input-prepend input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-info" type="button" @click="redirect()">点击刷新重试</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Page500',
    methods: {
        redirect() {
            var redirect = this.$route.params.redirect
            if (!_.isEmpty(redirect)) {
                window.location.href = redirect
            } else {
                location.reload(window.location.host)
            }

        }

    }
}
</script>
