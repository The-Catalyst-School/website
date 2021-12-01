<template>
  <header>
    <Link href="/">Home</Link>
    <Link href="/about">About</Link>
    <Link :href="$route('web.course.index')">Courses</Link>
  </header>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  components: {
    Link,
  }
}
</script>
