<template>
  <header>
    <Link href="/">Home</Link>
    <Link href="/about">About</Link>
    <Link :href="$route('web.course.index')">Courses</Link>
    <Link :href="$route('web.workshop.index')">Workshops</Link>
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
