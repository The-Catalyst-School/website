<template>
  <header class="site-header">
    <div class="logo">The Catalyst School</div>
    <div class="nav-wrapper">
      <nav role="navigation">
        <ul>
          <li><Link href="/">Home</Link></li>
          <li><Link :href="$route('web.course.index')">Courses</Link></li>
          <li><Link :href="$route('web.workshop.index')">Workshops</Link></li>
          <li><Link href="/about">About</Link></li>
          <li><Link href="/calendar">Calendar</Link></li>
          <li><Link href="/1-to-1">1-to-1 / Group Support</Link></li>
        </ul>
      </nav>
    </div>
    <div class="login-wrapper">
      <Link :href="$route('web.login')" v-if="!user">Login</Link>
      <Link method="delete" as="button" :href="$route('web.logout')" v-if="user">Logout {{user.name}}</Link>
    </div>
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

<style lang="scss" scoped>
  @import '../../sass/_mixins';
  header.site-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    @include r('padding', 20px 30px);
    .nav-wrapper {
      flex-grow: 1;
      @include m-font-size(12, 15);
      nav {
        ul {
          display: flex;
          justify-content: flex-end;
          li {
            @include r('padding', 0px 19px);
            text-transform: uppercase;
          }
        }
      }
    }
    .login-wrapper {
      @include m-font-size(12, 15);
      text-transform: uppercase;
    }
  }
</style>
