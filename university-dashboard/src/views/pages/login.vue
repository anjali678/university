<template>
  <div id="login" class="bg-gradient-primary d-flex align-items-center">
    <!-- Full height container with a custom class for flexbox layout -->
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-8">
          <div class="card o-hidden border-0 shadow-lg my-4">
            <div class="card-body p-0">
              <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-10">
                  <div class="p-4">
                    <div class="text-center">
                      <h1 class="h4 text-gray-900 my-4">Welcome Back!</h1>
                    </div>
                    <form class="user pb-4" @submit.prevent="login">
                      <div class="form-group pb-2">
                        <input type="email" class="form-control form-control-user"
                               id="exampleInputEmail" aria-describedby="emailHelp"
                               placeholder="Enter Email Address..."
                               v-model="email" required>
                      </div>
                      <div class="form-group pb-2">
                        <input type="password" class="form-control form-control-user"
                               id="exampleInputPassword" placeholder="Password"
                               v-model="password" required>
                      </div>
                      <div class="form-group" v-if="error">
                        <span class="text-danger">{{ error }}</span>
<!--                        <div class="custom-control custom-checkbox small">-->
<!--                          <input type="checkbox" class="custom-control-input" id="customCheck">-->
<!--                          <label class="custom-control-label" for="customCheck">Remember-->
<!--                            Me</label>-->
<!--                        </div>-->
                      </div>
                      <button type="submit" class="btn btn-primary btn-user btn-block">
                        Login
                      </button>
                    </form>
<!--                    <hr>-->
<!--                    <div class="text-center">-->
<!--                      <a class="small" href="forgot-password.html">Forgot Password?</a>-->
<!--                    </div>-->
<!--                    <div class="text-center">-->
<!--                      <a class="small" href="register.html">Create an Account!</a>-->
<!--                    </div>-->
                  </div>
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
import axios from '../../axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async login() {
      try {
        await axios.get('/sanctum/csrf-cookie');
        await axios.post('/login', {
          email: this.email,
          password: this.password
        });

        await this.$store.dispatch('fetchUser');
        this.$router.push({ name: 'dashboard' });
      } catch (err) {
        this.error = 'Invalid credentials, please try again.';
      }
    }
  }
};
</script>

<style scoped>

</style>
