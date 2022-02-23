<template>
  <div class="subscribers">
    <h3>Students of this course</h3>
    <div class="list">
      <div class="single-person"
        v-for="user in users">
        <img class="real-avatar"
         v-if="!user.avatar_url"
         src="/images/avatars/1-1.svg" />
        <img class="real-avatar"
         v-if="user.avatar_url"
         :src="user.avatar_url" />
      </div>
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['users'],
  components: {
    Link,
  }
};
</script>

<style lang="scss">
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.subscribers {
  width: 100%;
  .list {
    display: flex;
    justify-content: flex-start;
    flex-wrap: wrap;
  }
  .single-person {
    @include r('width', 30px);
    @include r('margin-bottom', 6px);
    @include r('margin-right', 6px);
  }
}
</style>
