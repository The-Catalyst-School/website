<template>
  <div class="register">
    <div>
      <form class="login-register" @submit.prevent="register">
        <h2>Create an account</h2>
        <input
          v-model="form.name"
          :error="form.errors.name"
          placeholder="Name"
          label="Name"
          type="text" autofocus autocapitalize="off" />
        <input
          v-model="form.email"
          :error="form.errors.email"
          placeholder="Email"
          label="Email" type="email" autofocus autocapitalize="off" />
        <input
          v-model="form.password"
          :error="form.errors.password"
          placeholder="Password"
          class="" label="Password" type="password" />
        <input
          v-model="form.password_confirmation"
          :error="form.errors.password_confirmation"
          placeholder="Confirm Password"
          class="" label="Confirm Password" type="password" />
        <div class="send-wrapper">
          <button
            class="btn"
            :loading="form.processing"
            type="submit">Register</button>
        </div>
        <div class="errors" v-if="errors || cErrors">
          {{errors.email}}
          {{cErrors.email}}
        </div>
        <div class="success" v-if="success">
          {{success}}
        </div>
        <div class="terms">
          By clicking “Register” I am confirming I am 16 or older and I accept the Terms of Use, the Privacy Policy, the Cookies Policy, and agree to receive news.
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['errors', 'success'],
  components: {
  },
  data() {
    return {
      cErrors: false,
      form: this.$inertia.form({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      }),
    }
  },
  methods: {
    register() {
      this.form.post(
        this.$route('web.register.store'),
        {
          onError: (errors) => {
            let err = Object.values(errors).join('')
            this.$toast.open({
              message: err,
              type: 'error'
            })
          },
          onSuccess: (page) => {
            this.$toast.open(page.props.success);
            this.$inertia.visitInModal(this.$route('web.login', {
              _query: {
                success: page.props.success
              }
            }), false)
          }
        }
      )
    },
  },
}
</script>
<style lang="scss" scoped>
@import '../../../sass/_mixins';
.register {
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
}
</style>
