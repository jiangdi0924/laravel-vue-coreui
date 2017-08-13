<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card-group mb-0">
                        <div class="card p-2">
                            <form @submit.prevent="logIn">
                                <div class="card-block">
                                    <h1>登录</h1>
                                    <p class="text-muted">已有账号登录系统</p>
                                    <div class="input-group mb-1">
                                        <span class="input-group-addon">
                                            <i class="icon-user"></i>
                                        </span>
                                        <input type="text" class="form-control" v-model="email" placeholder="Email">
                                    </div>
                                    <div class="input-group mb-2">
                                        <span class="input-group-addon">
                                            <i class="icon-lock"></i>
                                        </span>
                                        <input type="password" v-model="password" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="submit" class="btn btn-primary px-2">登陆</button>
                                        </div>
                                        <div class="col-6 text-right">
                                            <button type="button" class="btn btn-link px-0" v-on:click="forgetPassword()">忘记密码</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card card-inverse card-primary py-3 hidden-md-down" style="width:44%">
                            <div class="card-block text-center">
                                <div>
                                    <h2>注册</h2>
                                    <p>还没有账号？点击下方按钮，马上注册获取登录账号。</p>
                                    <button v-on:click="register()" type="button" class="btn btn-primary active mt-1">立即注册!</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Login',
    data() {
        return {
            email: '',
            password: ''
        }
    },
    methods: {
        logIn() {
            axios.post('/login', { email: this.email, password: this.password })
                .then(response => {

                    if (response.data == 'Not Authenticated') {
                         this.$notice('账号填写错误请核实', { duration: 3000, style: 'error' })

                    } else {
                        let token = response.data.token;
                        if (token) {
                            localStorage.setItem('token', token);
                            this.setHttpHeader();
                            this.$router.push('/dashboard');
                        }
                    }


                })
        },
        register() {
            this.$router.push('/pages/register');
        },
        forgetPassword() {
            this.$notice('找回密码请联系技术部：游佳', { duration: 5000, style: 'warning' })
        },
        setHttpHeader() {
            window.axios.defaults.headers.common = {
                'X-CSRF-TOKEN': window.Laravel.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Authorization': 'Bearer' + localStorage.getItem('token'),
                'Access-Control-Allow-Origin': '*'
            };
        }
    }
}
</script>
