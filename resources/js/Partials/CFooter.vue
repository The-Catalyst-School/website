<template>
  <footer>
    <div class="basic-info">
      The Catalyst School<br />
      is a project by:<br /></br />
      Member<br />
      Member<br />
      Member<br />
      Member<br />
      Member<br />
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
        <li><Link href="/1-to-1">1-to-1 / Group Support</Link></li>
      </ul>
    </nav>
    <div class="counter">
      The next Project Catalyst fund will be in:<br />
      45d 20h 50m 13s
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
    a, a:visited {
      color: $yellow;
      &:hover {
        text-decoration: underline;
      }
    }
    .basic-info, .social, nav {
      @include col(2 of 14);
      ul {
        list-style: none;
        li:before {
          display: none;
        }
      }
    }
    .counter {
      flex-grow: 1;
      align-self: flex-start;
      display: flex;
      justify-content: flex-end;
    }
  }
</style>
