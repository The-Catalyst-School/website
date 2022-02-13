<template>
  <div class="courses-list">
    <div class="list">
      <course-preview
        :course="course"
        :key="`cours-preview-${index}`"
        v-for="(course, index) in courses" />
    </div>
    <c-filter
      :topics="topics"
      :filter-topics="filter_topics"
       />
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import CoursePreview from '../../Components/CoursePreview'
import CFilter from './Filter'

export default {
  props: ['courses', 'topics', 'filter_topics'],
  components: {
    Link,
    CoursePreview,
    CFilter
  }
};
</script>

<style lang="scss" scoped>
@import '../../../sass/_mixins';
.courses-list {
  @include r('padding-top', 150px);
  @include r('padding-right', 30px);
  @include r('padding-left', 30px);
  width: 100%;
  .list {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
  }
}
</style>
