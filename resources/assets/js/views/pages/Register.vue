<template>
    <div class="app flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mx-2">

                        <form @submit.prevent="signUp">
                            <div class="card-block p-2">
                                <h1>注 册</h1>
                                <p class="text-muted">创建你的用户账号</p>
                                <div class="input-group mb-1">
                                    <span class="input-group-addon"><i class="icon-user"></i></span>
                                    <input type="text" class="form-control" v-model="register.name"
                                           placeholder="请填写用户昵称">
                                </div>

                                <div class="input-group mb-1">
                                    <span class="input-group-addon">@</span>
                                    <input type="text" class="form-control" v-model="register.email"
                                           placeholder="请填写用户Email">
                                </div>

                                <div class="input-group mb-1">
                                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                                    <input type="password" class="form-control" v-model="register.password"
                                           placeholder="请填写用户密码">
                                </div>

                                <button type="submit" class="btn btn-block btn-success">创 建</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Register',
        data(){
            return {
                register: {
                    name: "",
                    email: "",
                    password: ""
                }
            }
        },
        methods: {
            signUp(){
                axios.post('/register', this.register)
                    .then(response => {
                        let user = response.data.user;
                        if (! _.isEmpty(user)){
                            this.$notice('注册成功', { duration: 2000, style: 'success' })
                            this.$router.push('pages/login')
                        } else {
                            this.$notice('注册失败', { duration: 2000, style: 'error' })
                        }

                    })
            }
        }
    }
</script>
