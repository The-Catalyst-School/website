<template>
  <div class="event-preview"
    :class="[eventType]">
    <div class="label">{{label}}</div>
    <div class="date">
      {{event.scheduled_at | dateFormat('DD.MM.YYYY HH:mm')}}
    </div>
    <div class="title">
      <a v-if="eventType !== 'workshop'"
        :href="event.link" target="_blank">{{event.title}}</a>
      <Link
        v-if="eventType === 'workshop'"
        :href="$route('web.workshop.show', event.slug)">
        {{event.title}}
      </Link>
    </div>
    <div class="actions">
      <Link
        class="btn"
        :method="actionMethod" as="button" type="button"
        :href="$route(actionRoute, event.id)">
        {{actionText}}
      </Link>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['event'],
  components: {
    Link
  },
  data() {
    return {
    }
  },
  computed: {
    label() {
      if (this.eventType === 'workshop') {
        return 'w'
      }
      if (this.event.special) {
        return '!'
      }
      return 'E'
    },
    eventType() {
      if (!this.event.type) {
        return 'generic'
      }
      return this.event.type
    },
    actionText() {
      return (this.event.subscribed) ? 'Unsubscribe' : 'Subscribe'
    },
    actionMethod() {
      return (this.event.subscribed) ? 'delete' : 'post'
    },
    actionRoute() {
      let route = 'web.'
      if (this.eventType === 'workshop') {
        route = route + 'workshop'
      } else {
        route = route + 'event'
      }
      if (this.event.subscribed) {
        route = route + '.unsubscribe'
      } else {
        route = route + '.subscribe'
      }
      return route
    }
  },
  methods: {
  }
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.event-preview {
  position: relative;
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid $black;
  align-items: center;
  @include r('padding', 6px 0);
  .label {
  }
  .label {
    background: $black;
    color: $yellow;
    text-transform: uppercase;
    @include r('border-radius', 12px);
    @include r('width', 24px);
    @include r('height', 24px);
    @include r('padding', 4.5px 0);
    cursor: pointer;
    text-align: center;
  }
  .date {
    @include col(3 of 10);
    @include m-font-size(20, 26);
  }
  .title {
    @include col(6 of 10);
    @include m-font-size(20, 26);
  }
  .actions {
    @include col(1 of 10);
    padding-right: 0;
    display: flex;
    justify-content: flex-end;
  }
}
</style>
