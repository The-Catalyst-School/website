<template>
  <div class="profile-overview">
    <Head>
      <title>Profile - The Catalyst School</title>
    </Head>
    <div class="side">
      <side v-sticky sticky-side="both" />
    </div>
    <div class="content">
      <profile-recap :user="user" />
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
      <div class="next-appointments">
        <h4>Next appointments</h4>
        <div class="events-list">
          <div class="event-row" v-for="event in allEvents">
            <row-event-preview :event="event" />
          </div>
          <div class="no-events" v-if="allEvents.length === 0">
            <h2>No events</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="side">
    </div>
    <mobile-side />
  </div>
</template>

<script>

import dayjs from 'dayjs'
import weekday from 'dayjs/plugin/weekday'
import weekOfYear from 'dayjs/plugin/weekOfYear'
 
dayjs.extend(weekday)
dayjs.extend(weekOfYear)

import { Link, Head } from '@inertiajs/inertia-vue'
import MobileSide from './MobileSide'
import Side from './Side'
import ProfileRecap from './Info'
import LightWorkshopPreview from '../../Components/LightWorkshopPreview'
import LightCoursePreview from '../../Components/LightCoursePreview'
import RowEventPreview from '../../Components/RowEventPreview'

export default {
  props: ['user', 'events', 'courses', 'workshops', 'comments', 'e_workshops'],
  components: {
    Link,
    LightWorkshopPreview,
    LightCoursePreview,
    RowEventPreview,
    Side,
    ProfileRecap,
    Head,
    MobileSide
  },
  data() {
    return {
      listOpen: false
    }
  },
  computed: {
    localWorkshops() {
      return this.e_workshops.map((w) => {
        w.type = 'workshop'
        return w
      })
    },
    allEvents() {
      return [...this.localWorkshops,...this.events].sort((a, b) => {
        return dayjs(a.scheduled_at).unix() - dayjs(b.scheduled_at).unix()
      })
    },
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
      @include col(8 of 10, 0);
      @include col-before(1 of 10);
      display: flex;
      align-items: stretch;
      @include r('margin-bottom', 75px);
      @include mobile-tablet {
        @include col(1 of 1, 0);
        margin-left: 0;
        flex-wrap: wrap;
      }
      .last-workshop, .last-course {
        @include col(4 of 8, 0);
        height: 100%;
        @include mobile-tablet {
          @include col(1 of 1, 0);
          height: auto;
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
    .next-appointments {
      @include col(10 of 10, 0);
      h4 {
        @include col(8 of 10);
        @include col-before(1 of 10);
        @include r('margin-bottom', 15px);
        @include mobile-tablet {
          @include col(1 of 1, 0);
          margin-left: 0;
        }
      }
      .events-list {
        @include col(10 of 10, 0);
        display: flex;
        flex-direction: column;
      }
      .no-events {
        text-align: center;
        h2 {
          text-transform: initial;
        }
      }
    }
  }
}
</style>
