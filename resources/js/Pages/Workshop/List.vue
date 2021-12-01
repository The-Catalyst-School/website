<template>
  <div>
    <h1>This is the workshop archive.</h1>
    <div class="list">
      <div v-for="(workshop, index) in workshops" class="workshop-preview">
        <Link :href="$route('web.workshop.show', workshop.slug)">
          {{workshop.title}}
        </Link>
      </div>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['workshops'],
  components: {
    Link
  }
};
</script>
