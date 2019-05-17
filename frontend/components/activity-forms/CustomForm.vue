<template>
  <form>
    <v-text-field
      v-model="form.started"
      :error-messages="errors.started"
      label="Bắt đầu"
      required
      type="datetime-local"
    />
    <v-text-field
      v-model.number="form.custom_activity.title"
      :error-messages="$objectPath.get(errors, 'custom_activity.title', null)"
      label="Nội dung"
      required
    />
    <v-text-field
      v-model="form.memo"
      :error-messages="errors.memo"
      label="Ghi chú"
    />
  </form>
</template>

<script>
import FormMixin from './form.mixin.js'

export default {
  mixins: [FormMixin],
  data() {
    return {
      form: {
        started: this.$moment().format('YYYY-MM-DD[T]HH:mm'),
        memo: null,
        custom_activity: {
          title: null
        }
      }
    }
  },
  methods: {
    transformPropToData(prop) {
      return {
        started: this.$moment(prop.started).format('YYYY-MM-DD[T]HH:mm'),
        memo: prop.memo,
        custom_activity: {
          title: prop.custom_activity.title
        }
      }
    },
    transformDataToProp(form) {
      return {
        started: this.$moment(form.started).toISOString(),
        memo: form.memo,
        activity_type_id: 6,
        custom_activity: {
          title: form.custom_activity.title
        }
      }
    }
  }
}
</script>
