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
      <button
        v-if="$page.props.auth.user"
        class="btn on-desktop"
        @click.prevent="subscribe($route(actionRoute, event.id))">
        {{actionText}}
      </button>
      <button
        v-if="$page.props.auth.user"
        class="btn on-mobile active with-image"
        @click.prevent="subscribe($route(actionRoute, event.id))">
        <img src="/images/plus.svg" v-if="!event.subscribed" />
        <img src="/images/minus.svg" v-if="event.subscribed" />
      </button>
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
    subscribe(route) {
      this.$inertia.visit(route, {
        method: this.actionMethod,
        preserveScroll: true,
        onError(errors) {
          let err = Object.values(errors).join('')
          this.$toast.open({
            message: err,
            type: 'error'
          })
        },
        onSuccess: (msg) => {
          this.$toast.open(msg.props.success);
        }
      })
    }
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
  @include mobile-tablet {
    padding: 6px 0;
    flex-wrap: wrap;
  }
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
    @include mobile-tablet {
      order: 1;
      width: 28px;
      height: 28px;
      border-radius: 100%;
    }
  }
  .date {
    @include col(3 of 10);
    @include m-font-size(20, 26);
    @include mobile-tablet {
      @include font-size(18, 23);
      order: 2;
      @include col(6 of 10);
    }
  }
  .title {
    @include col(6 of 10);
    @include m-font-size(20, 26);
    @include mobile-tablet {
      @include col(1 of 1, 0);
      @include font-size(14, 17);
      order: 4;
    }
  }
  .actions {
    @include col(1 of 10);
    padding-right: 0;
    display: flex;
    justify-content: flex-end;
    @include mobile-tablet {
      order: 3;
      @include col(3 of 10, 0);
    }
    .btn {
      @include mobile-tablet {
        &.on-mobile {
          display: flex !important;
        }
      }
    }
  }
}
</style>
