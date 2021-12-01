<template>
  <header>
    <Link href="/">Home</Link>
    <Link href="/about">About</Link>
    <Link :href="$route('web.course.index')">Courses</Link>
    <Link :href="$route('web.workshop.index')">Workshops</Link>
    <Link :href="$route('web.workshop.index')">Workshops</Link>
    <Link :href="$route('web.login')" v-if="!user">Login</Link>
    <Link method="delete" as="button" :href="$route('web.logout')" v-if="user">Logout {{user.name}}</Link>
  </header>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['auth'],
  components: {
    Link,
  },
  computed: {
    user() {
      return this.$page.props.auth.user
    }
  }
}
</script>
