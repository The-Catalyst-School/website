<template>
  <div class="lessons">
    <h3>Lessons overview</h3>
    <div class="list">
      <div class="single-lesson"
        :key="`lesson-el-${lesson.id}`"
        v-for="lesson in lessons">
        <h2 class="title">{{lesson.title}}</h2>
        <Link class="btn" :href="$route('web.lesson.show', [course.slug, lesson.slug])">
          Go to Lesson
        </Link>
      </div>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['course', 'lessons'],
  components: {
    Link,
  }
};
</script>

<style lang="scss">
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.lessons {
  width: 100%;
  .single-lesson {
    width: 100%;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid $black;
    @include r('padding-top', 8px);
    @include r('padding-bottom', 8px);
    &:first-child {
      border-top: 1px solid $black;
    }
    h2 {
      text-transform: initial;
    }
  }
}
</style>
