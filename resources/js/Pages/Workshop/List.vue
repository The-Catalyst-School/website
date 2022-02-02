<template>
  <div class="workshops-list">
    <div class="list">
      <workshop-preview
        :workshop="workshop"
        :key="`cours-preview-${index}`"
        v-for="(workshop, index) in workshops" />
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import WorkshopPreview from '../../Components/WorkshopPreview'

export default {
  props: ['workshops'],
  components: {
    Link,
    WorkshopPreview
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
