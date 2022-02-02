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
            v-for="(course, index) in courses" />
          <course-preview
            :course="course"
            :key="`course-preview-${index}`"
            v-for="(course, index) in courses" />
        </template>
        <template v-slot:more>
          <Link :href="$route('web.course.index')">See all courses</Link>
        </template>
      </horizontal-slider>
    </section>
    <section class="courses">
      <h4 class="section-title">Our last Workshops</h4>
      <horizontal-slider>
        <template v-slot:track>
          <workshop-preview
            :workshop="workshop"
            :key="`workshops-preview-${index}`"
            v-for="(workshop, index) in workshops" />
          <workshop-preview
            :workshop="workshop"
            :key="`workshop-preview-${index}`"
            v-for="(workshop, index) in workshops" />
        </template>
        <template v-slot:more>
          <Link :href="$route('web.workshop.index')">See all workshops</Link>
        </template>
      </horizontal-slider>
    </section>
  </div>
</template>

<script>

import CoursePreview from '../../Components/CoursePreview'
import WorkshopPreview from '../../Components/WorkshopPreview'
import HorizontalSlider from '../../Components/HorizontalSlider'
import SentenceSlider from '../../Components/SentenceSlider'
import { Link } from '@inertiajs/inertia-vue'
export default {
  props: ['page', 'courses', 'workshops'],
  components: {
    CoursePreview,
    WorkshopPreview,
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
  &.courses, &.workshops {
    .section-title {
      @include col-before(2 of 14);
      transform: translateX(#{relative-size(-25px)});
    }
    .slider {
      width: calc(100% + #{relative-size(60px)});
      @include r('margin-left', -30px);
    }
  }
}
</style>
