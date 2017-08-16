import Vue from 'vue';
import Router from 'vue-router';

// Containers
import Full from '../containers/Full';

// Views
import Dashboard from '../views/Dashboard';

// Views - Pages
import Page404 from '../views/pages/Page404';
import Page500 from '../views/pages/Page500';
import Login from '../views/pages/Login';
import Register from '../views/pages/Register';

//产品监控
import Product from '../views/monitor/Product.vue';
import ProductDetail from '../views/monitor/ProductDetail.vue';
import DetailBsr from '../views/monitor/detailTabs/Bsr.vue';
import DetailSale from '../views/monitor/detailTabs/Sale.vue';
import DetailKeyword from '../views/monitor/detailTabs/Keyword.vue';
import DetailCost from '../views/monitor/detailTabs/Cost.vue';

import DetailReview from '../views/monitor/detailTabs/Review.vue';

import DetailSellingPonit from '../views/monitor/detailTabs/SellingPoint.vue';

import MyVuetable from '../views/monitor/MyVuetable.vue';
import BsrList from '../views/monitor/BsrList.vue';
import BsrDetail from '../views/monitor/BsrDetail.vue';
import KeywordList from '../views/monitor/KeywordList.vue';
import KeywordDetail from '../views/monitor/KeywordDetail.vue';

Vue.use(Router);

export default new Router({
    mode: 'hash', // hash or hash = Demo is living in GitHub.io, so required!
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes: [
        {
            path: '/',
            redirect: '/dashboard',
            name: 'Home',
            component: Full,
            meta: { title: 'Dashboard' },
            children: [
                {
                    path: 'dashboard',
                    name: 'Dashboard',
                    component: Dashboard,
                    meta: {
                        title: '商品监控'
                    },
                },
                {
                    path: 'monitor',
                    name: 'Monitor',
                    redirect: '/monitor/listing',
                    meta: {
                        title: '监控'
                    },
                    component: {
                        render(c) { return c('router-view'); }
                    },
                    children: [
                        {
                            path: 'product',
                            name: 'product',
                            component: Product,
                            meta: {
                                title: '商品列表'
                            },
                            // children: [
                            //     {
                            //         path: 'product_detail',
                            //         name: 'product_detail',
                            //         component: ProductDetail
                            //     }
                            // ]

                        },
                        {
                            path: 'product_detail/:productId',
                            name: 'product_detail',
                            component: ProductDetail,
                            meta: {
                                title: '商品详情'
                            },
                            redirect: '/monitor/product_detail/:productId/sale',
                            children: [
                                {
                                    path: 'sale',
                                    name: 'sale',
                                    component: DetailSale,
                                    meta: {
                                        title: '销售分析'
                                    }
                                },
                                {
                                    path: 'bsr',
                                    name: 'bsr',
                                    component: DetailBsr,
                                    meta: {
                                        title: 'BSR分析'
                                    }
                                },
                                {
                                    path: 'keyword',
                                    name: 'keyword',
                                    component: DetailKeyword,
                                    meta: {
                                        title: '关键词分析'
                                    }
                                },
                                {
                                    path: 'review',
                                    name: 'review',
                                    component: DetailReview,
                                    meta: {
                                        title: '评论分析'
                                    }
                                },
                                {
                                    path: 'selling_point',
                                    name: 'selling_point',
                                    component: DetailSellingPonit,
                                    meta: {
                                        title: '卖点分析'
                                    }
                                },
                                {
                                    path: 'cost',
                                    name: 'cost',
                                    component: DetailCost,
                                    meta: {
                                        title: '成本分析'
                                    }
                                }
                            ]
                        },
                        {
                            path: 'listing',
                            name: 'listing',
                            component: MyVuetable,
                            meta: {
                                title: '商品列表'
                            },
                        },
                        {
                            path: 'bsrlist',
                            name: 'bsrlist',
                            component: BsrList,
                            meta: {
                                title: '分类列表'
                            },
                        },
                        {
                            path: 'bsrDetail/:bsrId',
                            name: 'bsr_detail',
                            component: BsrDetail,
                            meta: {
                                title: '分类详情'
                            }
                        },
                        {
                            path: 'keyword_list',
                            name: 'keyword_list',
                            component: KeywordList,
                            meta: {
                                title: '关键词列表'
                            },
                        },
                        {
                            path: 'keyword_deatil/:keywordId',
                            name: 'keyword_deatil',
                            component: KeywordDetail,
                            meta: {
                                title: '关键词详情'
                            }
                        },
                    ]
                },
            ]
        },
        {
            path: '/pages',
            redirect: '/pages/p404',
            name: 'Pages',
            component: {
                render(c) { return c('router-view'); }
            },
            children: [
                {
                    path: '404',
                    name: 'Page404',
                    component: Page404
                },
                {
                    path: '500',
                    name: 'Page500',
                    component: Page500
                },
                {
                    path: 'login',
                    name: 'Login',
                    component: Login
                },
                {
                    path: 'register',
                    name: 'Register',
                    component: Register
                }
            ]
        }

    ]
});
