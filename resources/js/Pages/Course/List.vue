<template>
  <div class="courses-list">
    <Head>
      <title>Courses - The Catalyst School</title>
      <meta name="description" content="Courses archive of the Catalyst School for Project Catalyst">
    </Head>
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

import { Link, Head } from '@inertiajs/inertia-vue'
import CoursePreview from '../../Components/CoursePreview'
import CFilter from './Filter'

export default {
  props: ['courses', 'topics', 'filter_topics'],
  components: {
    Link,
    CoursePreview,
    CFilter,
    Head
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
  @include mobile-tablet {
    padding-left: 10px;
    padding-right: 10px;
    padding-top: 70px;
  }
  .list {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
  }
}
</style>
