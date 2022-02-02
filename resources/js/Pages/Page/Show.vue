<template>
  <div>
    <home :page="page"
      :courses="courses"
      :workshops="workshops"
      v-if="page.template === 'home'" />
    <std :page="page" v-if="page.template === 'std'" />
  </div>
</template>

<script>

import Home from './Home';
import Std from './Std';
export default {
  props: ['page', 'courses', 'workshops'],
  components: {
    Home,
    Std
  }
};
</script>
