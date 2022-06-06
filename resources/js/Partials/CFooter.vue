<template>
  <footer>
    <div class="basic-info">
      The Catalyst School
      <br />
      <br />
      <br />
      <br />
      <br />
    </div>
    <div class="social">
      Follow us:<br /><br />
      <ul>
        <li><a href="https://discord.gg/7tqJKQScZN" target="_blank">Discord</a></li>
        <li><a href="https://t.me/TheCatalystSchool" target="_blank">Telegram</a></li>
        <li><a href="https://www.youtube.com/channel/UCIPvRvMoxhmHLUuPPcsMmmg?sub_confirmation=1" target="_blank">Youtube</a></li>
        <li><a href="https://twitter.com/school_catalyst" target="_blank">Twitter</a></li>
        <li><a href="https://github.com/The-Catalyst-School" target="_blank">Github</a></li>
      </ul>
    </div>
    <nav>
      <ul>
        <li><Link :href="$route('web.course.index')">Courses</Link></li>
        <li><Link :href="$route('web.workshop.index')">Workshops</Link></li>
        <li><Link href="/about">About</Link></li>
        <li><Link href="/calendar">Calendar</Link></li>
        <li><a
          href="https://docs.google.com/forms/d/e/1FAIpQLSd9zvxtLtXKEcYEJas6Idj1YmA2kGyK27mIR-38eWITPUhHZw/viewform"
          target="_blank">
            1-to-1 / Group Support
          </a>
        </li>
      </ul>
    </nav>
    <div class="counter">
      Stake with&nbsp;<a href="https://pool.pm/47cb5e8b0e65d199cdfbe035d3c26d0260614f922460ff2b51c45e10" target="_blank">[LEARN] pool.</a>
    </div>
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
    @include m-font-size(14, 17);
    display: flex;
    align-items: flex-end;
    @include mobile-tablet {
      @include font-size(14, 17);
      padding: 20px 10px;
      flex-wrap: wrap;
    }
    a, a:visited {
      color: $yellow;
      &:hover {
        text-decoration: underline;
      }
    }
    .basic-info, .social, nav {
      @include col(2 of 14);
      @include mobile-tablet {
        @include col(1 of 2);
      }
      ul {
        list-style: none;
        li:before {
          display: none;
        }
      }
    }
    nav {
      @include mobile-tablet {
        margin-top: 15px;
      }
    }
    .counter {
      flex-grow: 1;
      align-self: flex-start;
      display: flex;
      justify-content: flex-end;
      @include mobile-tablet {
        @include col(1 of 1);
        justify-content: flex-start;
        margin-top: 15px;
      }
    }
  }
</style>
