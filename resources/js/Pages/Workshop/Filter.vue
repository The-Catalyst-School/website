<template>
  <div class="filter">
    <div class="current">
      <div class="btn active" @click="active = !active">Filter by</div>
      <div class="btn active" v-if="filterMonth">
        <Link
          preserve-scroll
          :href="$route('web.workshop.index', {
            '_query': newDelQuery(filterMonth, 'month')
          })">
          {{filterMonth | dateFormat('MMMM YYYY')}}
        </Link>
      </div>
      <div class="btn active"
        v-for="t in filterTopics"
        v-if="filterTopics.length > 0">
        <Link
          preserve-scroll
          :href="$route('web.workshop.index', {
            '_query': newDelQuery(t.id, 'topic')
          })">
          {{t.title}}
        </Link>
      </div>
      <div class="btn active with-image" @click="active = true">
        <img src="/images/plus.svg" />
      </div>
    </div>
    <slide-up-down
      class="internal-wrapper" :active="active" :duration="500">
      <div class="filter-wrapper">
        <div class="months">
          <div class="label">Month</div>
          <div class="list">
            <div class="single-month" v-for="month in months">
              <Link
                preserve-scroll
                :href="$route('web.workshop.index', {
                  '_query': newQuery(month, 'month')
                })">
                {{month | dateFormat('MMMM YYYY')}}
              </Link>
            </div>
          </div>
        </div>
        <div class="topics">
          <div class="label">Topics</div>
          <div class="list">
            <div class="single-topics" v-for="topic in topics">
              <Link
                preserve-scroll
                :href="$route('web.workshop.index', {
                  '_query': newQuery(topic.id, 'topic')
                })">
                {{topic.title}}
              </Link>
            </div>
          </div>
        </div>
      </div>
    </slide-up-down>
  </div>
</template>

<script>

import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['months', 'topics', 'filterMonth', 'filterTopics'],
  components: {
    Link,
  },
  data() {
    return {
      active: false
    }
  },
  computed: {
    currentQuery() {
      let res = {}
      if (this.filterMonth) {
        res['month'] = this.filterMonth
      }
      if (this.filterTopics) {
        res['topics'] = this.filterTopics.map((e) => parseInt(e.id))
      }
      return res
    }
  },
  methods: {
    newQuery(arg, t) {
      let res = JSON.parse(JSON.stringify(this.currentQuery))
      if (t === 'month') {
        res.month = arg
      }
      if (t === 'topic') {
        if (res.topics) {
          if (res.topics.indexOf(arg) === -1) {
            res.topics = [arg,...res.topics]
          }
        } else {
          res.topics = [arg]
        }
      }
      return res
    },
    newDelQuery(arg, t) {
      let res = JSON.parse(JSON.stringify(this.currentQuery))
      if (t === 'month') {
        res.month = null
      }
      if (t === 'topic') {
        let idx = res.topics.indexOf(arg)
        if (idx > -1) {
          res.topics.splice(idx, 1)
        }
      }
      return res
    }
  }
};
</script>

<style lang="scss" scoped>
@import '../../../sass/_mixins';
.filter {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  .current {
    @include col(1 of 1);
    display: flex;
    flex-wrap: wrap;
    @include r('padding-right', 40px);
    @include r('padding-left', 40px);
    @include mobile-tablet {
      padding-left: 20px;
      padding-right: 20px;
    }
    & > * {
      @include r('margin-right', 7px);
      @include r('margin-bottom', 6px);
    }
    a, a:visited {
      color: $yellow;
    }
  }
  .filter-wrapper {
    width: 100%;
    background: $black;
    color: $yellow;
    @include r('padding', 9px 30px);
    display: flex;
    text-transform: uppercase;
    flex-wrap: wrap;
    @include mobile-tablet {
      padding: 10px 10px;
    }
    a, a:visited {
      color: $yellow;
    }
    .months, .topics {
      @include col(1 of 1, 0);
      display: flex;
      align-items: flex-start;
      @include mobile-tablet {
        flex-wrap: wrap;
        margin-bottom: 15px;
      }
      .label {
        @include col(2 of 14);
        @include r('margin-bottom', 7px);
        @include mobile-tablet {
          @include col(1 of 1);
        }
      }
      .list {
        @include col(12 of 14, 0);
        display: flex;
        flex-wrap: wrap;
        @include mobile-tablet {
          @include col(1 of 1);
        }
        & > div:not(:last-child):after {
          content: '•';
          @include r('margin-left', 5px);
          @include r('margin-right', 5px);
        }
      }
    }
  }
}
</style>
