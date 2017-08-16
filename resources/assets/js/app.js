/* jshint esversion: 6 */

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from 'vue';
import App from './App.vue';
import router from './router';
//plugins
import NProgress from 'nprogress'; // Progress 进度条
import 'nprogress/nprogress.css';// Progress 进度条 样式
import VueNotice from 'vue-notice'

Vue.use(VueNotice, options)
var options = {
    // notice duration, default is 5000
    duration: 2000,

    // global style, based on built-in style
    style: {
        fontSize: '14px'
    },

    // global themes, will overide corresponding built-in theme
    themes: {
        // will override
        info: {
            color: 'blue'
        },

        // will create new theme
        rainbow: {
            backgroundImage: 'linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet)',
            color: 'white'
        }
    }
}


/**
 * 拦截器
 */


window.axios.interceptors.request.use(function (config) {
    //在请求发送之前做一些事
    return config;
}, function (error) {
    //当出现请求错误是做一些事
    return Promise.reject(error);
});

//添加一个返回拦截器
window.axios.interceptors.response.use(function (response) {
    //对返回的数据进行一些处理
    console.log(response.status)
    return response;
}, function (error) {
    console.log(error)
    switch (error.response.status) {
        case 401:
            localStorage.removeItem('token');
            router.replace({
                path: '/pages/login',
                query: { redirect: router.currentRoute.fullPath }
            })
        case 404:
            router.replace({
                path: '/pages/404',
                query: { redirect: router.currentRoute.fullPath }
            })
        // case 500:
        //     router.replace({
        //         path: '/pages/500',
        //         query: { redirect: router.currentRoute.fullPath }
        //     })
        default:
            break;
    }
    return Promise.reject(error);
});



router.beforeEach((to, from, next) => {
    NProgress.start(); // 开启Progress
    if (_.isEmpty(localStorage.getItem('token'))) {
        if (to.name === 'Login' || to.name == 'Register') {
            next();
        } else {
            return next({ path: '/pages/login' });
        }
    } else {
        if (to.name === 'Login' || to.name === 'Register') {
            return next({ path: '/dashboard' });
        } else {
            next();
        }
    }
})

router.afterEach(() => {
    NProgress.done(); // 结束Progress
});

Vue.component('App', require('./App.vue'));

/* eslint-disable no-new */
const app = new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: { App },
});
