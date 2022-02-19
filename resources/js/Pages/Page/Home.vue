<template>
  <div>
    <section class="intro">
      <h4 class="section-title">About us</h4>
      <sentence-slider v-if="sentences" :sentences="sentences" />
    </section>
    <section class="courses">
      <h4 class="section-title">Our last Courses</h4>
      <horizontal-slider>
        <template v-slot:track>
          <course-preview
            :course="course"
            :key="`course-preview-${index}`"
            v-for="(course, index) in courses" />
        </template>
        <template v-slot:more>
          <Link :href="$route('web.course.index')">See all courses</Link>
        </template>
      </horizontal-slider>
    </section>
    <section class="next-events">
      <h4 class="section-title">Next appointments</h4>
      <div class="events-list">
        <div class="event-row" v-for="event in allEvents">
          <row-event-preview :event="event" />
        </div>
      </div>
      <div class="see-more">
        <Link :href="$route('web.event.index')">Check our calendar</Link>
      </div>
    </section>
    <section class="courses">
      <h4 class="section-title">Our last Workshops</h4>
      <horizontal-slider>
        <template v-slot:track>
          <workshop-preview
            :workshop="workshop"
            :key="`workshop-preview-${index}`"
            v-for="(workshop, index) in workshops" />
        </template>
        <template v-slot:more>
          <Link :href="$route('web.workshop.index')">See all workshops</Link>
        </template>
      </horizontal-slider>
    </section>
    <section class="faqs">
      <h4 class="section-title">Frequently Asked Questions</h4>
      <faqs :faqs="faqs" :closable="false" />
      <div class="see-more">
        <Link :href="$route('web.page.show', 'faq')">See all</Link>
      </div>
    </section>
  </div>
</template>

<script>

import dayjs from 'dayjs'
import weekday from 'dayjs/plugin/weekday'
import weekOfYear from 'dayjs/plugin/weekOfYear'
 
dayjs.extend(weekday)
dayjs.extend(weekOfYear)

import CoursePreview from '../../Components/CoursePreview'
import WorkshopPreview from '../../Components/WorkshopPreview'
import HorizontalSlider from '../../Components/HorizontalSlider'
import SentenceSlider from '../../Components/SentenceSlider'
import RowEventPreview from '../../Components/RowEventPreview'
import Faqs from '../../Components/Faqs'
import { Link } from '@inertiajs/inertia-vue'
export default {
  props: [
    'page', 'courses', 'workshops', 'sentences',
    'faqs', 'events', 'e_workshops'
  ],
  components: {
    CoursePreview,
    WorkshopPreview,
    HorizontalSlider,
    SentenceSlider,
    Faqs,
    RowEventPreview,
    Link
  },
  computed: {
    eWorkshops() {
      return this.e_workshops.map((w) => {
        w.type = 'workshop'
        return w
      })
    },
    allEvents() {
      return [...this.eWorkshops,...this.events].sort((a, b) => {
        return dayjs(a.scheduled_at).unix() - dayjs(b.scheduled_at).unix()
      })
    },
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
@import '../../../sass/_variables';
section {
  @include r('padding', 20px 30px);
  @include r('margin-bottom', 130px);
  .section-title {
    @include col(12 of 14);
    @include r('margin-bottom', 20px);
  }
  &.courses, &.workshops {
    .section-title {
      @include col-before(2 of 14);
      transform: translateX(#{relative-size(-25px)});
    }
    .slider {
      width: calc(100% + #{relative-size(60px)});
      @include r('margin-left', -30px);
    }
  }
  &.faqs, &.next-events {
    .section-title {
      @include col-before(2 of 14);
    }
    .see-more {
      @include col(10 of 14);
      @include col-before(2 of 14);
      text-align: right;
      text-transform: uppercase;
      @include r('margin-top', 18px);
    }
    .events-list {
      @include col(10 of 14);
      @include col-before(2 of 14);
    }
  }
}
</style>
