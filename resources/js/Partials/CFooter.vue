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

<style lang="scss">
  @import '../../sass/_variables';
  @import '../../sass/_mixins';
  footer {
    background: $black;
    color: $yellow;
    @include r('padding', 20px 30px);
    @include m-font-size(12, 15);
    a, a:visited {
      color: $yellow;
    }
  }
</style>
