<template>
  <div class="profile-overview">
    <Head>
      <title>My Comments - Profile - The Catalyst School</title>
    </Head>
    <div class="side">
      <side v-sticky sticky-side="both" />
    </div>
    <div class="content">
      <profile-recap :user="user" />
      <div class="last-courses-workshops">
        <comments
          :comments="comments"
          :entity="false"
          />
      </div>
    </div>
    <div class="side">
    </div>
    <mobile-side />
  </div>
</template>

<script>

import { Link, Head } from '@inertiajs/inertia-vue'
import Side from './Side'
import ProfileRecap from './Info'
import MobileSide from './MobileSide'
import Comments from '../../Components/Comments'

export default {
  props: ['user', 'comments'],
  components: {
    Link,
    Comments,
    Side,
    ProfileRecap,
    Head,
    MobileSide
  },
  computed: {
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
.profile-overview {
  @include r('padding-right', 30px);
  @include r('padding-left', 30px);
  display: flex;
  @include mobile-tablet {
    padding-left: 20px;
    padding-right: 20px;
  }
  .side {
    @include col(2 of 14);
    @include mobile-tablet {
      display: none;
    }
  }
  .content {
    @include col(10 of 14, 0);
    display: flex;
    flex-direction: column;
    @include mobile-tablet {
      @include col(1 of 1, 0);
    }
    .last-courses-workshops {
      @include col(12 of 14, 0);
      @include col-before(1 of 14);
      display: flex;
      flex-wrap: wrap;
      align-items: stretch;
      @include r('margin-bottom', 75px);
      @include mobile-tablet {
        @include col(1 of 1, 0);
        margin-left: 0;
        flex-wrap: wrap;
      }
      p {
        @include col(1 of 1);
        @include r('margin-bottom', 15px);
        @include mobile-tablet {
          @include col(1 of 1, 0);
        }
      }
    }
  }
}
</style>
<style lang="scss">
@import '../../../sass/_mixins';
.profile-overview {
  .comments {
    .heading, .list {
      @include col(1 of 1, 0);
    }
  }
}
</style>
