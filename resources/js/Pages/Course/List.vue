<template>
  <div>
    <h1>This is the courses archive.</h1>
    <div class="list">
      <div v-for="(course, index) in courses" class="course-preview">
        <Link :href="$route('web.course.show', course.slug)">
          {{course.title}}
        </Link>
      </div>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['courses'],
  components: {
    Link
  }
};
</script>
