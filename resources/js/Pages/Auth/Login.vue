<template>
  <div class="p-6 bg-indigo-800 min-h-screen flex justify-center items-center">
    <div class="w-full max-w-md">
      <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
        <div class="px-10 py-12">
          <h1 class="text-center font-bold text-3xl">Welcome Back!</h1>
          <div class="mx-auto mt-6 w-24 border-b-2" />
          <input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
          <input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
          <label class="mt-6 select-none flex items-center" for="remember">
            <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
            <span class="text-sm">Remember Me</span>
          </label>
        </div>
        <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
          <button :loading="form.processing" class="ml-auto btn-indigo" type="submit">Login</button>
        </div>
        <a @click="$inertia.visitInModal($route('web.register.create'))">Register</a>
      </form>
      <div class="errors" v-if="errors">
        {{errors.email}}
      </div>
      <div class="errors" v-if="cErrors">
        {{cErrors.email}}
      </div>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  metaInfo: { title: 'Login' },
  props: ['errors'],
  components: {
    Link
  },
  data() {
    return {
      cErrors: false,
      form: this.$inertia.form({
        email: 'aaa@aaa.com',
        password: 'ciaociao',
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
