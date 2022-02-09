<template>
  <div class="login">
    <div>
      <form class="login-register" @submit.prevent="login">
        <h2>Login in your account</h2>
        <div class="success" v-if="success">
          {{success}}
        </div>
        <input
          v-model="form.email" :error="form.errors.email"
          label="Email"
          type="email"
          placeholder="Email"
          autofocus
          autocapitalize="off" />
        <div class="send-wrapper">
          <input
            v-model="form.password"
            :error="form.errors.password"
            placehodler="Password"
            label="Password"
            type="password" />
          <button :loading="form.processing" class="btn" type="submit">Login</button>
        </div>
        <div class="errors" v-if="errors || cErrors">
          {{errors.email}}
          {{cErrors.email}}
        </div>
        <h2 class="register">Don't have one?</h2>
        <a class="link" @click="$inertia.visitInModal($route('web.register.create'))">Click here to register</a>
      </form>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  metaInfo: { title: 'Login' },
  props: ['errors', 'success'],
  components: {
    Link
  },
  data() {
    return {
      cErrors: false,
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false,
      }),
    }
  },
  methods: {
    login() {
      this.form.post(
        this.$route('web.login.store'),
        {
          onError: (errors) => this.cErrors = errors
        }
      )
    },
  },
}
</script>
<style lang="scss" scoped>
@import '../../../sass/_mixins';
.login {
  @include r('padding', 5px 10px);
  h2 {
    &:not(.register) {
      @include r('margin-bottom', 15px);
    }
    &.register {
      @include r('margin-top', 20px);
      @include r('margin-bottom', 5px);
    }
  }
  .success {
    @include r('margin-bottom', 15px);
  }
}
</style>
