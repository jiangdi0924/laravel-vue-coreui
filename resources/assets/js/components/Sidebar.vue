<template>
    <div class="sidebar">
        <nav class="sidebar-nav">
            <ul class="nav">
                <li class="nav-item">
                    <router-link :to="'/dashboard'" class="nav-link">
                        <i class="icon-speedometer"></i> Dashboard
                    </router-link>
                </li>
    
                <router-link tag="li" class="nav-item nav-dropdown" :to="{ path: '/monitor'}" disabled>
                    <div class="nav-link nav-dropdown-toggle" @click="handleClick">
                        <i class="icon-bell"></i>监控</div>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <router-link :to="'/monitor/listing'" class="nav-link" exact>
                                <i class="icon-bag"></i>商品监控</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/monitor/bsrlist'" class="nav-link" exact>
                                <i class="icon-tag"></i>BSR监控</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/monitor/keyword_list'" class="nav-link" exact>
                                <i class="icon-bulb"></i>关键词监控</router-link>
                        </li>
                    </ul>
                </router-link>
                <!--<li class="divider"></li>
                <li class="nav-item nav-dropdown">
                    <a class="nav-link nav-dropdown-toggle" href="#" @click="handleClick">
                        <i class="icon-star"></i> Pages</a>
                    <ul class="nav-dropdown-items">
                        <li class="nav-item">
                            <router-link :to="'/pages/login'" class="nav-link" exact>
                                <i class="icon-star"></i> Login</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/pages/register'" class="nav-link" exact>
                                <i class="icon-star"></i> Register</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/pages/404'" class="nav-link" exact>
                                <i class="icon-star"></i> Error 404</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/pages/500'" class="nav-link" exact>
                                <i class="icon-star"></i> Error 500</router-link>
                        </li>
                    </ul>
                </li>-->
            </ul>
        </nav>
    </div>
</template>
<script>

export default {
    name: 'sidebar',
    methods: {
        handleClick(e) {
            e.preventDefault()
            e.target.parentElement.classList.toggle('open')
        }
    }
}
</script>

<style lang="css">
.nav-link {
    cursor: pointer;
}
</style>
