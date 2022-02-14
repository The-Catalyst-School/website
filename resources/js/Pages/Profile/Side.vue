<template>
  <div class="internal-side">
    <ul class="internal-nav">
      <li>
        <Link class="btn"
          :class="{'active': $page.component.startsWith('Profile/Overview')}"
          :href="$route('web.profile')">Profile Overview</Link>
      </li>
      <li>
        <Link class="btn"
          :class="{'active': $page.component.startsWith('Profile/Courses')}"
          :href="$route('web.profile.courses')">Your courses</Link>
      </li>
      <li>
        <Link class="btn"
          :class="{'active': $page.component.startsWith('Profile/Workshops')}"
          :href="$route('web.profile.workshops')">Your workshops</Link>
      </li>
      <li>
        <Link class="btn"
          :class="{'active': $page.component.startsWith('Profile/Comments')}"
          :href="$route('web.profile.comments')">Your comments</Link>
      </li>
      <div class="spacer"></div>
    </ul>
  </div>
</template>


<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: [],
  components: {
    Link
  }
}
</script>

<style lang="scss" scoped>
@import '../../../sass/_mixins';
@import '../../../sass/_variables';
.internal-side {
  @include r('padding-top', 70);
  ul.internal-nav {
    list-style: none;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    height: 80vh;
    li {
      @include r('margin-top', 6px);
      &:before {
        display: none;
      }
      width: 100%;
      a, a:visited {
        display: block;
        float: left;
      }
    }
    .spacer {
      flex-grow: 1;
    }
  }
}
</style>
