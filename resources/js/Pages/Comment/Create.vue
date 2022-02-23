<template>
  <div class="create-comment-wrapper">
    <div>
      <form class="create-comment" @submit.prevent="submit">
        <h2>Your opinion is important to us, help the community to grow</h2>
        <div class="success" v-if="success">
          {{success}}
        </div>
        <textarea
          v-model="form.content" :error="form.errors.content"
          label="Content"
          placeholder="Leave a comment..."
          autofocus
          autocapitalize="off" />
        <div class="errors" v-if="errors || cErrors">
          {{errors.content}}
          {{cErrors.content}}
        </div>
        <div class="send-wrapper">
          <button class="btn" @click.prevent="form.reset()">Reset form</button>
          <button
            :disabled="form.content.length === 0"
            :loading="form.processing"
            class="btn" type="submit">{{submitMsg}}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue'

export default {
  props: ['errors', 'success', 'entity', 'comment'],
  components: {
    Link
  },
  data() {
    return {
      cErrors: false,
      form: this.$inertia.form({
        content: (this.comment) ? this.comment.content : '',
        entity: this.entity
      }),
    }
  },
  methods: {
    reset() {
      this.form.content = ''
    },
    submit() {
      let route = (this.comment) ? this.$route('web.comment.update', [this.comment.id]) : this.$route('web.comment.store')
      this.form.post(
        route,
        {
          onError: (errors) => {
            let err = Object.values(errors).join('')
            this.$toast.open({
              message: err,
              type: 'error'
            })
            this.cErrors = errors
          },
          onSuccess: (msg) => {
            this.$toast.open(msg.props.success);
          },
          preserveScroll: true
        }
      )

    }
  },
  computed: {
    submitMsg() {
      return (this.comment) ? 'Edit' : 'Publish'
    }
  }
}
</script>
<style lang="scss" scoped>
@import '../../../sass/_mixins';
.create-comment-wrapper {
  @include r('padding', 5px 10px);
  h2 {
    @include r('padding-bottom', 25px);
    @include r('margin-bottom', 10px);
    border-bottom: 1px solid $black;
  }
  textarea {
    font-family: 'Neue Montreal';
    border: none;
    -webkit-appearance: none;
    width: 100%;
    @include m-font-size(20, 26);
    outline: 0;
    border-bottom: 1px solid $black;
    @include r('padding-bottom', 10px);
    @include r('margin-bottom', 10px);
    background: $white;
    color: $black;
    @include mobile-tablet {
      @include font-size(18, 23);
    }
  }
  button {
    background: $white;
    font-family: 'Neue Montreal';
    @include m-font-size(14, 17);
    @include mobile-tablet {
      @include font-size(14, 17);
    }
    &:not(:last-child) {
      @include r('margin-right', 8px);
    }
    &:hover {
      background: $black;
      color: $white;
    }
  }
  .send-wrapper {
    justify-content: flex-end;
    display: flex;
  }
  .success {
    @include r('margin-bottom', 15px);
  }
}
</style>
