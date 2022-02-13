<template>
  <div class="filter">
    <div class="current">
      <div class="btn active" @click="active = !active">Filter by</div>
      <div class="btn active"
        v-for="t in filterTopics"
        v-if="filterTopics.length > 0">
        <Link
          preserve-scroll
          :href="$route('web.course.index', {
            '_query': newDelQuery(t.id, 'topic')
          })">
          {{t.title}}
        </Link>
      </div>
      <div class="btn active" @click="active = true">+</div>
    </div>
    <slide-up-down
      class="internal-wrapper" :active="active" :duration="500">
      <div class="filter-wrapper">
        <div class="topics">
          <div class="label">Topics</div>
          <div class="list">
            <div class="single-topics" v-for="topic in topics">
              <Link
                preserve-scroll
                :href="$route('web.course.index', {
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
  props: ['months', 'topics', 'filterTopics'],
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
      if (this.filterTopics) {
        res['topics'] = this.filterTopics.map((e) => parseInt(e.id))
      }
      return res
    }
  },
  methods: {
    newQuery(arg, t) {
      let res = JSON.parse(JSON.stringify(this.currentQuery))
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
    @include r('margin-bottom', 7px);
    @include r('padding-right', 40px);
    @include r('padding-left', 40px);
    & > * {
      @include r('margin-right', 7px);
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
    a, a:visited {
      color: $yellow;
    }
    .topics {
      @include col(4 of 14);
      .list {
        column-count: 4;
        @include r('column-gap', $default-gutter);
      }
    }
    .topics {
      .label {
        width: 100%;
        @include r('margin-bottom', 7px);
      }
      .list {
        width: 100%;
      }
    }
  }
}
</style>
