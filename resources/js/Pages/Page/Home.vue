<template>
  <div>
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
import { Link } from '@inertiajs/inertia-vue'
export default {
  props: ['page', 'courses'],
  components: {
    CoursePreview,
    HorizontalSlider,
    Link
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
@import '../../../sass/_variables';
section {
  .section-title {
    @include col(12 of 14, math.div($default-gutter, 2));
    @include col-before(2 of 14);
    @include r('margin-bottom', 20px);
  }
}
</style>
