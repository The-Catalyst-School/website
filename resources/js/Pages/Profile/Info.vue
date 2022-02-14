<template>
  <div class="profile-recap">
    <div class="public">
      <p>Public information</p>
      <div class="single-info">Username: {{user.name}}</div>
    </div>
    <div class="private">
      <p>Private information</p>
      <div class="single-info">Email: {{user.email}}</div>
      <div class="single-info">Reset password</div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['user'],
  components: {
  },
  computed: {
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
.profile-recap {
  @include col(1 of 1);
  @include r('padding-bottom', 15px);
  border-bottom: 1px solid $black;
  @include r('margin-bottom', 50px);
  display: flex;
  .public, .private {
    @include col(5 of 10, 0);
    p {
      @include r('margin-bottom', 6px);
    }
    .single-info {
      @include m-font-size(20, 26);
    }
  }
}
</style>
