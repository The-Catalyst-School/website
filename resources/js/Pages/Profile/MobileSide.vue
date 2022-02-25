<template>
  <div class="mobile-side">
    <div class="btn active"
      v-if="!listOpen && $page.component.startsWith('Profile/Overview')"
      @click="listOpen = !listOpen">
      Profile Section
    </div>
    <div class="btn active"
      v-if="!listOpen && $page.component.startsWith('Profile/Courses')"
      @click="listOpen = !listOpen">
      Your courses
    </div>
    <div class="btn active"
      v-if="!listOpen && $page.component.startsWith('Profile/Workshops')"
      @click="listOpen = !listOpen">
      Your workshops
    </div>
    <div class="btn active"
      v-if="!listOpen && $page.component.startsWith('Profile/Comments')"
      @click="listOpen = !listOpen">
      Your comments
    </div>
    <div class="btn active plus with-image"
      v-if="!listOpen"
      @click="listOpen = !listOpen">
      <img src="/images/plus.svg" />
    </div>
    <slide-up-down :active="listOpen" :duration="500">
      <div class="slider-wrapper">
        <side />
      </div>
    </slide-up-down>
  </div>
</template>

<script>
import Side from './Side'

export default {
  props: [],
  components: {
    Side,
  },
  data() {
    return {
      listOpen: false
    }
  },
}
</script>

<style lang="scss" scoped>
  @use 'sass:math';
  @import '../../../sass/_mixins';
  .mobile-side {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    padding: 20px;
    width: 100%;
    justify-content: flex-start;
    padding-bottom: 0;
    .btn {
      margin-right: 6px;
      margin-bottom: 20px;
    }
    & > div:not(.btn) {
      width: 100%;
      .slider-wrapper {
      }
    }
    @include mobile-tablet {
      display: flex;
    }
  }
</style>
