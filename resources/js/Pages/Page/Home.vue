<template>
  <div>
    <section class="intro">
      <h4 class="section-title">About us</h4>
      <sentence-slider />
    </section>
    <section class="courses">
      <h4 class="section-title">Our last Courses</h4>
      <horizontal-slider>
        <template v-slot:track>
          <course-preview
            :course="course"
            :key="`cours-preview-${index}`"
            v-for="(course, index) in courses"
            class="course-preview" />
          <course-preview
            :course="course"
            :key="`course-preview-${index}`"
            v-for="(course, index) in courses"
            class="course-preview" />
        </template>
        <template v-slot:more>
          <Link :href="$route('web.course.index')">See all courses</Link>
        </template>
      </horizontal-slider>
    </section>
  </div>
</template>

<script>

import CoursePreview from '../../Components/CoursePreview'
import HorizontalSlider from '../../Components/HorizontalSlider'
import SentenceSlider from '../../Components/SentenceSlider'
import { Link } from '@inertiajs/inertia-vue'
export default {
  props: ['page', 'courses'],
  components: {
    CoursePreview,
    HorizontalSlider,
    SentenceSlider,
    Link
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
@import '../../../sass/_variables';
section {
  @include r('padding', 20px 30px);
  @include r('margin-bottom', 130px);
  .section-title {
    @include col(12 of 14);
    @include r('margin-bottom', 20px);
  }
  &.courses {
    .section-title {
      @include col-before(2 of 14);
    }
  }
}
</style>
