<template>
  <div class="profile-overview">
    <div class="side">
    </div>
    <div class="content">
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
      <div class="last-courses-workshops"
        v-if="courses.length > 0 || workshops.length > 0">
        <div class="last-workshop" v-if="workshops.length">
          <p>Last workshop</p>
          <light-workshop-preview
            :workshop="workshops[0]"
          />
        </div>
        <div class="last-course" v-if="courses.length">
          <p>Last course</p>
          <light-course-preview
            :course="courses[0]"
          />
        </div>
      </div>
    </div>
    <div class="side">
    </div>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'
import LightWorkshopPreview from '../../Components/LightWorkshopPreview'
import LightCoursePreview from '../../Components/LightCoursePreview'

export default {
  props: ['user', 'events', 'courses', 'workshops', 'comments'],
  components: {
    Link,
    LightWorkshopPreview,
    LightCoursePreview
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
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    @include r('padding-top', 36px);
    .single-month, .view-type {
      @include r('margin-bottom', 10px);
      a, a:visited {
        display: block;
      }
    }
    &.months {
      align-items: flex-end;
    }
  }
  .content {
    @include col(10 of 14, 0);
    display: flex;
    flex-direction: column;
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
    .last-courses-workshops {
      @include col(12 of 14, 0);
      @include col-before(1 of 14);
      display: flex;
      align-items: stretch;
      .last-workshop, .last-course {
        @include col(6 of 12, 0);
        height: 100%;
        p {
          @include col(1 of 1);
          @include r('margin-bottom', 15px);
        }
      }
    }
  }
}
</style>
