<template>
  <header class="site-header">
    <div class="logo">
      <Link href="/">
        The Catalyst School
      </Link>
    </div>
    <div class="nav-wrapper">
      <nav role="navigation">
        <ul>
          <li>
            <Link :class="{'active': $page.component.startsWith('Course') || $page.component.startsWith('Lesson')}"
              :href="$route('web.course.index')">
              Courses
            </Link>
          </li>
          <li>
            <Link
              :class="{'active': $page.component.startsWith('Workshop')}"
              :href="$route('web.workshop.index')">
              Workshops
            </Link>
          </li>
          <li>
            <Link
              :class="{'active': $page.url === '/about'}"
              :href="$route('web.page.show', 'about')">
              About
            </Link>
          </li>
          <li>
            <Link
              :class="{'active': $page.url === '/faq'}"
              :href="$route('web.page.show', 'faq')">
              FAQ
            </Link>
          </li>
          <li>
            <Link
              :class="{'active': $page.component.startsWith('Event')}"
              :href="$route('web.event.index')">
              Calendar
            </Link>
          </li>
          <li>
            <Link
              :class="{'active': $page.url === '/1-to-1'}"
              :href="$route('web.page.show', '1-to-1')">
              1-to-1 / Group Support
            </Link>
          </li>
        </ul>
      </nav>
    </div>
    <div class="login-wrapper">
      <a class="login" @click="login($route('web.login'))" v-if="!user">Login</a>
      <Link method="delete" as="button" :href="$route('web.logout')" v-if="user">Logout</Link>
      <Link :href="$route('web.profile')" v-if="user">{{user.name}}</Link>
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
  },
  methods: {
    login(route) {
      this.$inertia.visitInModal(route, false)
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
    z-index: 1000;
    @include r('padding', 20px 30px);
    .logo {
      @include col(6 of 14);
    }
    .nav-wrapper {
      flex-grow: 1;
      @include col(6.5 of 14);
      @include m-font-size(12, 15);
      nav {
        ul {
          display: flex;
          list-style: none;
          li {
            @include r('padding', 0px 38px 0 0);
            text-transform: uppercase;
            a, a:visited {
              &.active, &:hover {
                text-decoration: underline;
              }
            }
          }
        }
      }
    }
    .login-wrapper {
      @include col(1.5 of 14);
      @include m-font-size(12, 15);
      text-transform: uppercase;
      text-align: right;
      .login {
        cursor: pointer;
      }
      button {
        font-family: 'Neue Montreal';
        @include m-font-size(12, 15);
        text-transform: uppercase;
        -webkit-appearance: initial;
        border: none;
        background: transparent;
        cursor: pointer;
      }
    }
  }
</style>
