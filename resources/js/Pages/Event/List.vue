<template>
  <div class="calendar-wrapper">
    <div class="side">
      <div class="view-type">
        <Link class="btn"
          :class="{'active': $page.component.startsWith('Event/Calendar')}"
          :href="$route('web.event.index', [initialDate.format('YYYY-MM')])">
          Month view
        </Link>
      </div>
      <div class="view-type">
        <Link class="btn"
          :class="{'active': $page.component.startsWith('Event/List')}"
          :href="$route('web.event.list', [initialDate.format('YYYY-MM')])">
          Day view
        </Link>
      </div>
    </div>
    <div class="events-list">
      <div class="event-row" v-for="event in allEvents">
        <row-event-preview :event="event" />
      </div>
      <div class="no-events" v-if="allEvents.length === 0">
        <h2>No events</h2>
      </div>
    </div>
    <div class="side months">
      <div class="single-month" v-for="month in months">
        <Link class="btn"
          :class="{'active': (month.format('MMYYYY')) === initialDate.format('MMYYYY')}"
          :href="$route('web.event.list', [month.format('YYYY-MM')])">
          {{month | dateFormat('MMMM YYYY')}}
        </Link>
      </div>
    </div>
  </div>
</template>

<script>

import dayjs from 'dayjs'
import weekday from 'dayjs/plugin/weekday'
import weekOfYear from 'dayjs/plugin/weekOfYear'
 
dayjs.extend(weekday)
dayjs.extend(weekOfYear)

import { Link } from '@inertiajs/inertia-vue'
import RowEventPreview from '../../Components/RowEventPreview'

export default {
  props: ['date','events', 'workshops'],
  components: {
    Link,
    RowEventPreview
  },
  computed: {
    initialDate() {
      if (this.date) {
        return dayjs(this.date)
      }
      return dayjs()
    },
    localWorkshops() {
      return this.workshops.map((w) => {
        w.type = 'workshop'
        return w
      })
    },
    allEvents() {
      return [...this.localWorkshops,...this.events].sort((a, b) => {
        return dayjs(a.scheduled_at).unix() - dayjs(b.scheduled_at).unix()
      })
    },
    months() {
      let months = []
      let cache = this.initialDate.startOf('month')
      let previous = Array.from({length: 6}).map((el, i) => {
        let newDate = cache.subtract(
          dayjs.duration({'days': 1})
        ).startOf('month')
        cache = newDate
        return newDate
      }).reverse()
      cache = this.initialDate.endOf('month')
      let next = Array.from({length: 6}).map((el, i) => {
        let newDate = cache.add(
          dayjs.duration({'days' : 1})
        ).endOf('month')
        cache = newDate
        return newDate
      })
      return [...previous,...[this.initialDate.startOf('month')],...next]
    }
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../../sass/_mixins';
.calendar-wrapper {
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
  .events-list {
    @include col(10 of 14, 0);
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
</style>
