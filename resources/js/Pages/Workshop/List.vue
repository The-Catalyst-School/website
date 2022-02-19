<template>
  <div class="workshops-list">
    <Head>
      <title>Workshops - The Catalyst School</title>
      <meta name="description" content="Workshops archive of the Catalyst School for Project Catalyst">
    </Head>
    <div class="list">
      <workshop-preview
        :workshop="workshop"
        :key="`cours-preview-${index}`"
        v-for="(workshop, index) in workshops" />
    </div>
    <c-filter
      :topics="topics"
      :months="months"
      :filter-month="filter_month"
      :filter-topics="filter_topics"
       />
  </div>
</template>

<script>

import { Link, Head } from '@inertiajs/inertia-vue'
import WorkshopPreview from '../../Components/WorkshopPreview'
import CFilter from './Filter'

export default {
  props: ['workshops', 'months', 'topics', 'filter_month', 'filter_topics'],
  components: {
    Link,
    WorkshopPreview,
    CFilter,
    Head
  }
};
</script>

<style lang="scss" scoped>
@import '../../../sass/_mixins';
.workshops-list {
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
