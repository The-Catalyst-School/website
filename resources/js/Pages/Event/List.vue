<template>
  <div class="calendar-wrapper">
    <Head>
      <title>Events calendar - The Catalyst School</title>
      <meta name="description" content="The Catalyst School and Project Catalyst events calendar.">
    </Head>
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
        <h2>No events for {{initialDate | dateFormat('MMMM YYYY')}}</h2>
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
    <div class="mobile-side">
      <div class="on-left">
        <div class="btn active"
          v-if="!viewListOpen && $page.component.startsWith('Event/Calendar')"
          @click="viewListOpen = !viewListOpen">
          By Month
        </div>
        <div class="btn active"
          v-if="!viewListOpen && $page.component.startsWith('Event/List')"
          @click="viewListOpen = !viewListOpen">
          By Day
        </div>
        <div class="btn active plus with-image"
          v-if="!viewListOpen"
          @click="viewListOpen = !viewListOpen">
          <img src="/images/plus.svg" />
        </div>
        <div class="view-list">
          <slide-up-down :active="viewListOpen" :duration="500">
            <div class="real-list">
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
          </slide-up-down>
        </div>
      </div>
      <div class="on-right">
        <div class="btn active"
          v-if="!monthListOpen"
          @click="monthListOpen = !monthListOpen">
          {{initialDate | dateFormat('MMM YYYY')}}
        </div>
        <div class="btn active plus with-image"
          v-if="!monthListOpen"
          @click="monthListOpen = !monthListOpen">
            <img src="/images/plus.svg" />
          </div>
        <div class="month-list">
          <slide-up-down :active="monthListOpen" :duration="500">
            <div class="real-list">
              <div class="single-month" v-for="month in months">
                <Link class="btn"
                  :class="{'active': (month.format('MMYYYY')) === initialDate.format('MMYYYY')}"
                  :href="$route('web.event.list', [month.format('YYYY-MM')])">
                  {{month | dateFormat('MMMM YYYY')}}
                </Link>
              </div>
            </div>
          </slide-up-down>
        </div>
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

import { Link, Head } from '@inertiajs/inertia-vue'
import RowEventPreview from '../../Components/RowEventPreview'

export default {
  props: ['date','events', 'workshops'],
  components: {
    Link,
    RowEventPreview,
    Head
  },
  data() {
    return {
      monthListOpen: false,
      viewListOpen: false
    }
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
  @include mobile-tablet {
    padding-left: 20px;
    padding-right: 20px;
  }
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
    @include mobile-tablet {
      display: none;
    }
  }
  .mobile-side {
    display: none;
    position: fixed;
    bottom: 0;
    left: 0;
    padding: 20px;
    justify-content: flex-end;
    width: 100%;
    .on-left, .on-right {
      width: 50%;
      display: flex;
      &.on-right {
        justify-content: flex-end;
      }
      .plus {
        margin-left: 6px;
      }
      .month-list, .view-list {
        position: fixed;
        width: 100%;
        bottom: 0;
        left: 0;
        padding-left: 20px;
        padding-right: 20px;
        background: linear-gradient(180deg, transparent 0%, $yellow 80%);
        & > div {
          .real-list {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-end;
            padding-bottom: 14px;
            a, a:visited {
              display: block;
              margin-bottom: 6px;
              &:not(.active) {
                background: $yellow;
              }
            }
          }
        }
        &.view-list {
          & > div {
            .real-list {
              align-items: flex-start;
            }
          }
        }
      }
    }
    @include mobile-tablet {
      display: flex;
    }
  }
  .events-list {
    @include col(10 of 14, 0);
    display: flex;
    flex-direction: column;
    @include mobile-tablet {
      @include col(1 of 1, 0);
    }
  }
  .no-events {
    text-align: center;
    h2 {
      text-transform: initial;
    }
  }
}
</style>
