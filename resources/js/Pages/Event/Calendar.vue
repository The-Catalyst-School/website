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
    <div class="month">
      <div class="header">
        <div class="weekdays">
          <div class="weekday"
            :key="`weekday-${day}`"
            v-for="day in weekdays">
            {{day}}
          </div>
        </div>
        <div class="days">
          <div class="single-day"
            :class="{'current-month': day.isCurrentMonth}"
            v-for="day in days"
          >
            <div class="content">
              <div class="day">
                {{day.dayOfMonth | paddingZero(2)}}
              </div>
              <div class="events" v-if="day.events.length > 0">
                <event-preview
                  :key="`event-preview-${event.id}`"
                  :event="event"
                  v-for="event in day.events" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="side months">
      <div class="single-month" v-for="month in months">
        <Link class="btn"
          :class="{'active': (month.format('MMYYYY')) === initialDate.format('MMYYYY')}"
          :href="$route('web.event.index', [month.format('YYYY-MM')])">
          {{month | dateFormat('MMMM YYYY')}}
        </Link>
      </div>
    </div>
    <div class="mobile-side">
      <div class="on-left">
        <div class="btn active"
          v-if="!viewListOpen && $page.component.startsWith('Event/Calendar')"
          @click="viewListOpen = !viewListOpen">
          By view
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
                  :href="$route('web.event.index', [month.format('YYYY-MM')])">
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
import EventPreview from '../../Components/EventPreview'

export default {
  props: ['date','events', 'workshops'],
  components: {
    Link,
    EventPreview,
    Head
  },
  data() {
    return {
      weekdays: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
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
    initialYear() {
      return dayjs(this.initialDate).format("YYYY")
    },
    initialMonth() {
      return dayjs(this.initialDate).format("M")
    },
    currentMonthDays() {
      return this.createDaysForCurrentMonth(this.initialYear, this.initialMonth)
    },
    previousMonthDays() {
      return this.createDaysForPreviousMonth(this.initialYear, this.initialMonth)
    },
    nextMonthDays() {
      return this.createDaysForNextMonth(this.initialYear, this.initialMonth)
    },
    days() {
      let days = [...this.previousMonthDays, ...this.currentMonthDays, ...this.nextMonthDays]
      days.forEach((day) => {
        let events = this.events.filter((e) => dayjs(e.scheduled_at).format('YYYY-MM-DD') === day.date)
        let workshops = this.localWorkshops.filter((e) => dayjs(e.scheduled_at).format('YYYY-MM-DD') === day.date)
        day.events = [...events, ...workshops]
      })
      return days
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
  },
  methods: {
    createDaysForCurrentMonth(year, month) {
      return [...Array(this.getNumberOfDaysInMonth(year, month))].map((day, index) => {
        return {
          date: dayjs(`${year}-${month}-${index + 1}`).format("YYYY-MM-DD"),
          dayOfMonth: index + 1,
          isCurrentMonth: true
        };
      });
    },
    createDaysForPreviousMonth(year, month) {
      const firstDayOfTheMonthWeekday = this.getWeekday(this.currentMonthDays[0].date);
      const previousMonth = dayjs(`${year}-${month}-01`).subtract(1, "month");

      // Cover first day of the month being sunday (firstDayOfTheMonthWeekday === 0)
      const visibleNumberOfDaysFromPreviousMonth = firstDayOfTheMonthWeekday
        ? firstDayOfTheMonthWeekday - 1
        : 6;

      const previousMonthLastMondayDayOfMonth = dayjs(this.currentMonthDays[0].date)
        .subtract(visibleNumberOfDaysFromPreviousMonth, "day")
        .date();
 
      return [...Array(visibleNumberOfDaysFromPreviousMonth)].map((day, index) => {
        return {
          date: dayjs(
            `${previousMonth.year()}-${previousMonth.month() +
              1}-${previousMonthLastMondayDayOfMonth + index}`
          ).format("YYYY-MM-DD"),
          dayOfMonth: previousMonthLastMondayDayOfMonth + index,
          isCurrentMonth: false
        };
      });
    },
    createDaysForNextMonth(year, month) {
      const lastDayOfTheMonthWeekday = this.getWeekday(
        `${year}-${month}-${this.currentMonthDays.length}`
      );
      const nextMonth = dayjs(`${year}-${month}-01`).add(1, "month");
      const visibleNumberOfDaysFromNextMonth = lastDayOfTheMonthWeekday
        ? 7 - lastDayOfTheMonthWeekday
        : lastDayOfTheMonthWeekday;
      return [...Array(visibleNumberOfDaysFromNextMonth)].map((day, index) => {
        return {
          date: dayjs(
            `${nextMonth.year()}-${nextMonth.month() + 1}-${index + 1}`
          ).format("YYYY-MM-DD"),
          dayOfMonth: index + 1,
          isCurrentMonth: false
        };
      });
    },
    getWeekday(date) {
      return dayjs(date).weekday()
    },
    getNumberOfDaysInMonth(year, month) {
      return dayjs(`${year}-${month}-01`).daysInMonth();
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
  .month {
    @include col(10 of 14, 0);
    display: flex;
    flex-direction: column;
    @include mobile-tablet {
      @include col(5 of 5, 0);
      overflow-x: auto;
      overflow-y: hidden;
    }
    .header {
      @include mobile-tablet {
        @include col(8 of 4, 0);
      }
    }
    .weekdays, .days {
      width: 100%;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      .weekday, .single-day {
        width: math.div(100%, 7);
        border-bottom: 1px solid $black;
        @include r('padding', 10);
        @include mobile-tablet {
          padding: 5px;
        }
      }
      .single-day {
        border-right: 1px solid $black;
        border-bottom: 1px solid $black;
        padding-top: 9%;
        position: relative;
        @include mobile-tablet {
          padding-top: 14%;
        }
        &.current-month {
          .content {
            opacity: 1;
          }
        }
        &:nth-child(7n + 1) {
          border-left: 1px solid $black;
        }
        .content {
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          @include r('padding', 10);
          opacity: 0.5;
          display: flex;
          flex-direction: column;
          @include mobile-tablet {
            padding: 5px;
          }
          .events {
            flex-grow: 1;
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
          }
        }
      }
    }
  }
}
</style>
<style lang="scss">
@use 'sass:math';
@import '../../../sass/_mixins';
.calendar-wrapper .month .days .single-day {
  &:nth-child(7n) {
    .events .event-preview .info {
      right: calc(100% + #{relative-size(6)}) !important;
      left: auto;
      @include mobile-tablet {
        right: auto !important;
        left: 50% !important;
      }
    }
  }
}
</style>
