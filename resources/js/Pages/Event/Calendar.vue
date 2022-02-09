<template>
  <div class="calendar-wrapper">
    <div class="side">
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
    <div class="side">
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
import EventPreview from '../../Components/EventPreview'

export default {
  props: ['events'],
  components: {
    Link,
    EventPreview
  },
  data() {
    return {
      weekdays: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
      initialDate: "2022-02-09 16:32:31"
    }
  },
  computed: {
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
        day.events = this.events.filter((e) => e.scheduled_at === day.date)
      })
      return days
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
@import '../../../sass/_mixins';
.calendar-wrapper {
  @include r('padding-right', 30px);
  @include r('padding-left', 30px);
  display: flex;
  .side {
    @include col(2 of 14);
  }
  .month {
    @include col(10 of 14, 0);
    display: flex;
    flex-direction: column;
    .weekdays, .days {
      width: 100%;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      .weekday, .single-day {
        width: (100%/7);
        border-bottom: 1px solid $black;
        @include r('padding', 10);
      }
      .single-day {
        border-right: 1px solid $black;
        border-bottom: 1px solid $black;
        padding-top: 9%;
        position: relative;
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
          .events {
            flex-grow: 1;
            display: flex;
            align-items: flex-end;
          }
        }
      }
    }
  }
}
</style>
