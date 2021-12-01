<template>
  <div>
    <h1>{{lesson.title}}</h1>
    <h2>This is the lesson page.</h2>
    <h3>Course: {{lesson.course.title}}</h3>
  </div>
</template>

<script>
export default {
  props: ['lesson']
};
</script>
