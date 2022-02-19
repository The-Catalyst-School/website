<template>
  <div class="profile-overview">
    <Head>
      <title>My Workshops - Profile - The Catalyst School</title>
    </Head>
    <div class="side">
      <side v-sticky sticky-side="both" />
    </div>
    <div class="content">
      <profile-recap :user="user" />
      <div class="last-courses-workshops"
        v-if="workshops.length > 0">
        <p>Last workshops subscribed</p>
        <div class="list">
          <light-workshop-preview
            :key="`light-w-${workshop.id}`"
            v-for="workshop in workshops"
            :workshop="workshop"
          />
        </div>
      </div>
      <div class="no-results"
        v-if="workshops.length === 0">
        <h2>No results</h2>
      </div>
    </div>
    <div class="side">
    </div>
  </div>
</template>

<script>

import { Link, Head } from '@inertiajs/inertia-vue'
import Side from './Side'
import ProfileRecap from './Info'
import LightWorkshopPreview from '../../Components/LightWorkshopPreview'

export default {
  props: ['user', 'workshops'],
  components: {
    Link,
    LightWorkshopPreview,
    Side,
    ProfileRecap,
    Head
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
  .side {
    @include col(2 of 14);
  }
  .content {
    @include col(10 of 14, 0);
    display: flex;
    flex-direction: column;
    .last-courses-workshops {
      @include col(12 of 14, 0);
      @include col-before(1 of 14);
      display: flex;
      flex-wrap: wrap;
      align-items: stretch;
      @include r('margin-bottom', 75px);
      p {
        @include col(1 of 1);
        @include r('margin-bottom', 15px);
      }
      .list {
        @include col(1 of 1, 0);
        display: flex;
        flex-wrap: wrap;
        .workshop-preview {
          @include col(1 of 2);
        }
      }
    }
    .no-results {
      text-align: center;
      h2 {
        text-transform: initial;
      }
    }
  }
}
</style>
