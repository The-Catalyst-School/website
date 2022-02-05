<template>
  <div>
    <home :page="page"
      :courses="courses"
      :workshops="workshops"
      :sentences="sentences"
      :faqs="faqs"
      v-if="page.template === 'home'" />
    <faq :page="page" v-if="page.template === 'faq'" />
    <std :page="page" v-if="page.template === 'std'" />
  </div>
</template>

<script>

import Home from './Home';
import Faq from './Faq';
import Std from './Std';
export default {
  props: ['page', 'courses', 'workshops', 'sentences', 'faqs'],
  components: {
    Home,
    Faq,
    Std
  }
};
</script>
