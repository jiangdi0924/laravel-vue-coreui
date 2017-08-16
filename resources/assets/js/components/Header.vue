<template>
    <navbar>
        <button class="navbar-toggler mobile-sidebar-toggler hidden-lg-up" type="button" @click="mobileSidebarToggle">
            &#9776;</button>
        <a class="navbar-brand" href="#"></a>
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler sidebar-toggler" href="#" @click="sidebarToggle">&#9776;</a>
            </li>
            <!--<li class="nav-item px-1">
                <a class="nav-link" href="#">Dashboard</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="#">Users</a>
            </li>
            <li class="nav-item px-1">
                <a class="nav-link" href="#">Settings</a>
            </li>-->
        </ul>
        <ul class="nav navbar-nav ml-auto">
            <!--<li class="nav-item hidden-md-down">
                <a class="nav-link" href="#"><i class="icon-bell"></i><span
                        class="badge badge-pill badge-danger">5</span></a>
            </li>
            <li class="nav-item hidden-md-down">
                <a class="nav-link" href="#"><i class="icon-list"></i></a>
            </li>
            <li class="nav-item hidden-md-down">
                <a class="nav-link" href="#"><i class="icon-location-pin"></i></a>
            </li>-->
            <dropdown size="nav" class="nav-item">
        <span slot="button">
          <span class="hidden-md-down" >{{ user.name }}</span>
        </span>
                <div slot="dropdown-menu" class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center"><strong>设置</strong></div>

                    <!--<a class="dropdown-item" href="#"><i class="fa fa-user"></i> Profile</a>-->
                    <!--<a class="dropdown-item" href="#"><i class="fa fa-wrench"></i> Settings</a>-->
                    <!--<a class="dropdown-item" href="#"><i class="fa fa-usd"></i> Payments<span class="badge badge-default">42</span></a>-->
                    <!--<a class="dropdown-item" href="#"><i class="fa fa-file"></i> Projects<span class="badge badge-primary">42</span></a>-->
                    <div class="divider"></div>
                    <a class="dropdown-item" v-on:click="logOut()"><i class="fa fa-lock"></i>退出登录</a>
                </div>
            </dropdown>
            <li class="nav-item hidden-md-down">
                <a class="nav-link navbar-toggler aside-menu-toggler"></a>
            </li>
        </ul>
    </navbar>
</template>
<script>

    import navbar from './Navbar'
    import {dropdown} from 'vue-strap'

    export default {
        name: 'header',
        components: {
            navbar,
            dropdown
        },
        data(){
            return {
                user: {
                    name: '',
                }
            }
        },
        methods: {
            userInfo() {
                axios.get('/userInfo')
                    .then(response => {
                        this.user.name = response.data
                    })
            },
            logOut () {
                localStorage.removeItem('token')
                this.$router.push('/pages/login');
            },
            sidebarToggle (e) {
                e.preventDefault()
                document.body.classList.toggle('sidebar-hidden')
            },
            mobileSidebarToggle (e) {
                e.preventDefault()
                document.body.classList.toggle('sidebar-mobile-show')
            },
            asideToggle (e) {
                e.preventDefault()
                document.body.classList.toggle('aside-menu-hidden')
            }
        },
        mounted() {
            this.userInfo()
        }
    }
</script>

<style lang="css">

    .dropdown-toggle::after {
        /*display: none !important;*/
    }
</style>
