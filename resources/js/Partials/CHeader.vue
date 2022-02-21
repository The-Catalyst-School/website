<template>
  <header class="site-header">
    <div class="logo" :class="{'nav-open': isNavOpen}">
      <Link :href="$route('web.index')">
        <img class="logo-black" src="/images/logo.svg" />
        <img class="logo-white" src="/images/logo-white.svg" />
      </Link>
    </div>
    <div class="hamburger" :class="{'nav-open': isNavOpen}" @click="toggleNav">
      <span>&nbsp;</span>
      <span>&nbsp;</span>
      <span>&nbsp;</span>
    </div>
    <div class="nav-login" :class="{'nav-open': isNavOpen}">
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
        <button class="logout" @click.prevent="logout($route('web.logout'))" v-if="user">Logout</button>
        <Link :href="$route('web.profile')" v-if="user">
          {{user.name}}
          <img class="real-avatar"
           v-if="user.avatar_url"
           :src="user.avatar_url" />
          <img class="real-avatar"
           v-if="!user.avatar_url"
           src="/images/avatars/1-1.svg" />
        </Link>
        <div class="night" @click="changeNight">{{nightText}}</div>
      </div>
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
  data() {
    return {
      isNavOpen: false
    }
  },
  computed: {
    user() {
      return this.$page.props.auth.user
    },
    nightText() {
      if (JSON.parse(window.localStorage.getItem('night'))) {
        return 'Day'
      }
      return 'Night'
    }
  },
  methods: {
    login(route) {
      this.$inertia.visitInModal(route, false)
    },
    logout(route) {
      this.$inertia.delete(route, {
        preserveScroll: true,
        onError(e) {
          this.$toast.open({
            msg: e.comment,
            type: 'error'
          })
        },
        onSuccess: (msg) => {
          this.$toast.open(msg.props.success);
        }
      })
    },
    changeNight() {
      this.$root.$emit('toggle-night')
    },
    toggleNav() {
      this.isNavOpen = !this.isNavOpen
    }
  },
  mounted() {
    this.$inertia.on('start', () => { this.isNavOpen = false }) 
  }
}
</script>

<style lang="scss" scoped>
  @use 'sass:math';
  @import '../../sass/_mixins';
  header.site-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    z-index: 1000;
    @include r('padding', 20px 30px);
    @include mobile-tablet {
      padding: 14px 20px;
      align-items: center;
    }
    .logo {
      @include col(5 of 14);
      position: relative;
      @include mobile-tablet {
        @include col(5 of 6, 0);
        z-index: 11;
      }
      a, a:visited {
        display: block;
      }
      img {
        float: left;
        width: auto;
        @include r('height', 16px);
        @include mobile-tablet {
          height: 18px;
          max-width: none;
        }
        &.logo-white {
          position: absolute;
          top: 0;
          left: relative-size(math.div($default-gutter, 2));
          @include mobile-tablet {
            left: 0px;
          }
        }
      }
      @include mobile-tablet {
        &.nav-open {
          .logo-black {
            opacity: 0 !important;
          }
          .logo-white {
            opacity: 1 !important;
          }
        }
      }
    }
    .hamburger {
      display: none;
      width: 40px;
      height: 40px;
      position: absolute;
      top: 4px;
      right: 10px;
      z-index: 10;
      span {
        width: 20px;
        height: 1px;
        background: $black;
        display: block;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%) translateY(-50%);
        @include transition('transform, opacity');
        &:nth-child(1) {
          transform: translateX(-50%) translateY(calc(-50% - 7px));
        }
        &:nth-child(3) {
          transform: translateX(-50%) translateY(calc(-50% + 7px));
        }
      }
      &.nav-open {
        span {
          background: $white;
          &:nth-child(1) {
            transform: translateX(-50%) translateY(-50%) rotate(-45deg);
          }
          &:nth-child(2) {
            opacity: 0;
          }
          &:nth-child(3) {
            transform: translateX(-50%) translateY(-50%) rotate(45deg);
          }
        }
      }
      @include mobile-tablet {
        display: block;
      }
    }
    .nav-login {
      @include col(9 of 14, 0);
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      @include mobile-tablet {
        position: fixed;
        width: 100%;
        background: $black;
        top: 0;
        left: 0;
        color: $white;
        transform: translateY(-100%);
        flex-direction: column;
        &.nav-open {
          transform: translateY(0%);
        }
      }
    }
    .nav-wrapper {
      flex-grow: 1;
      @include col(7 of 9, 0);
      @include m-font-size(14, 17);
      @include mobile-tablet {
        @include font-size(18, 23);
        @include col(1 of 1, 40px);
        padding-top: 60px;
        padding-bottom: 20px;
      }
      nav {
        ul {
          display: flex;
          list-style: none;
          justify-content: flex-end;
          @include mobile-tablet {
            flex-direction: column;
            justify-content: flex-start;
          }
          li {
            text-transform: uppercase;
            &:not(:last-child) {
              @include r('padding', 0px 38px 0 0);
            }
            @include mobile-tablet {
              padding: 0 5px 0 0;
              &:before {
                display: none;
              }
            }
            a, a:visited {
              @include mobile-tablet {
                color: $white !important;
              }
              &.active, &:hover {
                text-decoration: underline;
              }
            }
          }
        }
      }
    }
    .login-wrapper {
      @include col(2 of 9);
      @include m-font-size(14, 17);
      text-transform: uppercase;
      text-align: right;
      display: flex;
      justify-content: flex-end;
      align-items: flex-end;
      @include mobile-tablet {
        @include font-size(18, 13);
        @include col(1 of 1, 40px);
        padding-bottom: 20px;
        justify-content: flex-start;
        align-items: flex-start;
        flex-direction: column;
      }
      .login {
        cursor: pointer;
      }
      a, a:visited {
        display: flex;
        align-items: flex-end;
        @include mobile-tablet {
          color: $white;
          align-items: center;
        }
      }
      .real-avatar {
        @include r('width', 20px);
        @include mobile-tablet {
          width: 20px;
          filter: invert(1);
          margin-left: 4px;
        }
      }
      button {
        font-family: 'Neue Montreal';
        @include m-font-size(14, 17);
        text-transform: uppercase;
        -webkit-appearance: initial;
        border: none;
        background: transparent;
        cursor: pointer;
        color: $black;
        @include mobile-tablet {
          color: $white;
          @include font-size(18, 13);
        }
      }
      a, button, img, div {
        @include r('margin-left', 3px);
        @include mobile-tablet {
          margin-left: 0px;
          &:not(img) {
            margin-bottom: 6px;
          }
        }
      }
    }
  }
</style>
<style lang="scss">
  body {
    header.site-header .logo .logo-white {
      opacity: 0;
    }
    &.is-night {
      header.site-header .logo .logo-white {
        opacity: 1;
      }
      header.site-header .logo .logo-black {
        opacity: 0;
      }
    }
  }
</style>
