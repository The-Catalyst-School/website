<template>
  <div class="profile-recap">
    <div class="avatar">
      <div class="fake-avatar"
      @click="createAvatar($route('web.profile.avatar.create'))"
      v-if="!user.avatar"></div>
      <img class="real-avatar"
      @click="createAvatar($route('web.profile.avatar.create'))"
      :src="user.avatar_url"
      v-if="user.avatar" />
    </div>
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
  },
  methods: {
    createAvatar(route) {
      this.$inertia.visitInModal(route, false, 4)
    },
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
.profile-recap {
  @include col(1 of 1, 0);
  @include r('padding-bottom', 15px);
  border-bottom: 1px solid $black;
  @include r('margin-bottom', 50px);
  display: flex;
  @include mobile-tablet {
    flex-wrap: wrap;
    margin-bottom: 25px;
  }
  .avatar {
    @include col(1 of 10, 0);
    @include mobile-tablet {
      @include col(1 of 1, 0);
      margin-bottom: 20px;
      display: flex;
      justify-content: center;
    }
    .fake-avatar {
      width: 100%;
      height: 0;
      padding-top: 100%;
      position: relative;
      @include mobile-tablet {
        width: 40%;
      }
      &:after {
        content: 'Set Avatar';
        top: 0;
        left: 0;
        width: 80%;
        height: 80%;
        border-radius: 100%;
        background: $black;
        position: absolute;
        display: flex;
        justify-content: center;
        align-items: center;
        color: $white;
        cursor: pointer;
      }
    }
    .real-avatar {
      cursor: pointer;
      @include transition('opacity');
      @include mobile-tablet {
        width: 40%;
      }
      &:hover {
        opacity: 0.8;
      }
    }
  }
  .public, .private {
    @include col(4 of 10);
    @include mobile-tablet {
      @include col(1 of 1, 0);
      margin-bottom: 20px;
    }
    p {
      @include r('margin-bottom', 6px);
    }
    .single-info {
      @include m-font-size(20, 26);
      @include mobile-tablet {
        @include font-size(18, 23);
      }
    }
  }
}
</style>
