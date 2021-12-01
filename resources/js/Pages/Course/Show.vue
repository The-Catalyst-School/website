<template>
  <div>
    <h1>{{course.title}}</h1>
    <h2>This is the course page.</h2>
    <div class="lessons-list" v-if="course.lessons">
      <div v-for="(lesson, index) in course.lessons" class="single-lesson">
        <Link :href="$route('web.lesson.show', [course.slug, lesson.slug])">
          {{lesson.title}}
        </Link>
      </div>
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
