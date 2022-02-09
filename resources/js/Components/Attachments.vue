<template>
  <div class="section-attachments">
    <h4>Additional resources</h4>
    <div class="attachments-list">
      <div class="single-attachment"
        :key="`attachment-${attachment.id}`"
        v-for="attachment in attachments">
        <div class="attachment-title">{{attachment.title}}</div>
        <div class="actions">
          <a :href="attachment.file" class="btn" target="_blank">Open</a>
          <a :href="attachment.file" class="btn" target="_blank" download>Download</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
export default {
  props: ['attachments'],
  components: {
    Link,
  },
  data() {
    return {
    }
  },
  methods: {
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.section-attachments {
  h4 {
    @include col(14 of 14);
    @include r('margin-bottom', 15);
  }
  .attachments-list {
    @include col(14 of 14);
    .single-attachment {
      border-bottom: 1px solid $black;
      @include r('padding-top', 8px);
      @include r('padding-bottom', 8px);
      display: flex;
      justify-content: space-between;
      align-items: center;
      .attachment-title {
        flex-grow: 1;
        @include m-font-size(20, 26);
      }
      &:first-child {
        border-top: 1px solid $black;
      }
    }
  }
}
</style>
