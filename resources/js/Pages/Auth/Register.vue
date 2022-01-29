<template>
  <div>
    <h1>Register</h1>
    <form class="" @submit.prevent="register">
      <input v-model="form.name" :error="form.errors.name" class="" label="Name" type="text" autofocus autocapitalize="off" />
      <input v-model="form.email" :error="form.errors.email" class="" label="Email" type="email" autofocus autocapitalize="off" />
      <input v-model="form.password" :error="form.errors.password" class="" label="Password" type="password" />
      <button :loading="form.processing" class="" type="submit">Login</button>
    </form>
    <div class="errors" v-if="errors">
      {{errors.email}}
    </div>
      <div class="errors" v-if="cErrors">
        {{cErrors.email}}
      </div>
  </div>
</template>

<script>
export default {
  props: ['errors'],
  components: {
  },
  data() {
    return {
      cErrors: false,
      form: this.$inertia.form({
        name: '',
        email: '',
        password: '',
      }),
    }
  },
  methods: {
    register() {
      this.form.post(
        this.$route('web.register.store'),
        {
          onError: (errors) => this.cErrors = errors
        }
      )
    },
  },
}
</script>
