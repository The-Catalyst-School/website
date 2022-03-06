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
          v-model="form.password"
          :error="form.errors.password"
          placeholder="New Password"
          class="" label="New Password" type="password" />
        <input
          v-model="form.password_confirmation"
          :error="form.errors.password_confirmation"
          placeholder="Confirm Password"
          class="" label="Confirm Password" type="password" />
        <div class="send-wrapper">
          <button
            class="btn"
            :loading="form.processing"
            type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ['errors', 'success', 'user'],
  components: {
  },
  data() {
    return {
      cErrors: false,
      form: this.$inertia.form({
        name: this.user.name,
        password: '',
        password_confirmation: '',
      }),
    }
  },
  methods: {
    register() {
      this.$inertia.post(this.$route('web.profile.update.store'),
      {
        name: this.form.name,
        password: this.form.password,
        password_confirmation: this.form.password_confirmation,
      },
      {
        preserveScroll: true,
        onError: (errors) => {
          let err = Object.values(errors).join('')
          this.$toast.open({
            message: err,
            type: 'error'
          })
        },
        onSuccess: (msg) => {
          this.$toast.open({
            message: msg.props.success,
          });
        }
      })
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
