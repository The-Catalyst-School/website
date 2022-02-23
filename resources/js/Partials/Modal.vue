<template>
  <div class="modal" v-if="modal" @close="close">
    <div class="bkg" @click="close"></div>
    <div class="wrapper" :class="col">
      <component v-if="modal" :is="modal.component" v-bind="modal.page.props" />
    </div>
  </div>
</template>

<script>
import Axios from "axios"
import {
  hrefToUrl,
  mergeDataIntoQueryString,
} from "@inertiajs/inertia"

export default {
  data() {
    return {
      modal: false,
    };
  },
  computed: {
    col() {
      if (this.modal.col) {
        return `col-${this.modal.col}`
      }
      return ''
    }
  },
  beforeMount() {
    this.$inertia.visitInModal = (url, onSuccess, col) => {
      this.visitInModal(url, onSuccess, col)
    }
    this.$inertia.on("success", (event) => {
      if (this.modal) {
        if (typeof this.modal.onSuccess === "function") {
          this.modal.onSuccess(event)
        }
      }
      this.close()
    })
  },
  methods: {
    close() {
      if (this.modal) {
        // remove the 'X-Inertia-Modal' and 'X-Inertia-Modal-Redirect-Back' headers for future requests
        this.modal.removeBeforeEventListener()
      }
      this.modal = false
    },
    visitInModal(url, onSuccess, col) {
      let data = {};
      [url, data] = mergeDataIntoQueryString("get", hrefToUrl(url), {});
      Axios({
        method: "get",
        url: url,
        data: {},
        params: data,
        headers: {
          Accept: "text/html, application/xhtml+xml",
          "X-Requested-With": "XMLHttpRequest",
          "X-Inertia": true,
          "X-Inertia-Modal": true,
          "X-Inertia-Version": this.$page.version,
        },
      }).then((response) => {
        const Inertia = this.$inertia;
        const page = response.data;
        return Promise.resolve(Inertia.resolveComponent(page.component)).then(
          (component) => {
            const clone = page
            // const clone = JSON.parse(JSON.stringify(page));
            // clone.props = Inertia.transformProps(clone.props);
            const removeBeforeEventListener = Inertia.on("before", (event) => {
              // make sure the backend knows we're requesting from within a modal
              event.detail.visit.headers["X-Inertia-Modal"] = true;
              if (onSuccess) {
                event.detail.visit.headers[
                  "X-Inertia-Modal-Redirect-Back"
                ] = true;
              }
            });
            this.modal = {
              component,
              onSuccess,
              removeBeforeEventListener,
              page: clone,
              col: col
            };
          }
        );
      });
    },
  },
};
</script>

<style lang="scss" scoped>
@use 'sass:math';
@import '../../sass/_mixins';
@import '../../sass/_variables';
.modal {
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  z-index: 10000;
  .bkg {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: 0;
    background: rgba(0,0,0,0.3);
    cursor: pointer;
  }
  .wrapper {
    @include col(4 of 14, 0);
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    background: $white;
    border: 1px solid $black;
    z-index: 1;
    @for $i from 1 through 14 {
      &.col-#{$i} {
        @include col($i of 14, 0);
      }
    }
    @include mobile-tablet {
      width: calc(100% - 40px) !important;
    }
  }
}
</style>
