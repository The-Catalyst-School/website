<template>
  <div class="intro-heading">
    <div class="heading">
      <div class="date">{{ course.updated_at | dateFormat('DD.MM.YYYY') }}</div>
      <div class="teacher" v-if="course.teacher">With {{course.teacher}}</div>
      <div class="estimated" v-if="course.estimated_time">
        Estimated time: {{course.estimated_time}}
      </div>
    </div>
    <div class="title">
      <h1>
        <Link :href="$route('web.course.show', course.slug)">
          {{course.title}}
        </Link>
      </h1>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['course'],
  components: {
    Link
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.intro-heading {
  .heading {
    display: flex;
    justify-content: space-between;
    @include mobile-tablet {
      flex-wrap: wrap;
    }
    .date {
      @include col(2 of 8, 0);
    }
    .teacher {
      @include col(4 of 8);
    }
    .date, .teacher, .estimated {
      @include mobile-tablet {
        @include col(1 of 1, 0);
      }
    }
  }
  @include mobile-tablet {
    display: flex;
    flex-direction: column;
  }
  .heading, .title {
    @include mobile-tablet {
      @include col(1 of 1);
    }
  }
  .heading {
    @include mobile-tablet {
      order: 2;
    }
  }
  .title {
    @include mobile-tablet {
      order: 1;
    }
  }
}
</style>
