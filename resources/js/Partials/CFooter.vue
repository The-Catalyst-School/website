<template>
  <footer>
    <Link href="/">Home</Link>
    <Link href="/about">About</Link>
    <Link :href="$route('web.course.index')">Courses</Link>
  </footer>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  components: {
    Link,
  }
}
</script>
