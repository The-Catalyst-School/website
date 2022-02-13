<template>
  <div class="workshops-list">
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

import { Link } from '@inertiajs/inertia-vue'
import WorkshopPreview from '../../Components/WorkshopPreview'
import CFilter from './Filter'

export default {
  props: ['workshops', 'months', 'topics', 'filter_month', 'filter_topics'],
  components: {
    Link,
    WorkshopPreview,
    CFilter
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
