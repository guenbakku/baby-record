<template>
  <div>
    <v-text-field
      v-model="form.started"
      :error-messages="errors.started"
      label="Bắt đầu"
      required
      type="datetime-local"
    />
    <v-text-field
      v-model.number="form.breast_milk_activity.duration"
      :error-messages="
        $objectPath.get(errors, 'breast_milk_activity.duration', null)
      "
      label="Thời gian"
      suffix="phút"
      required
      type="number"
    />
    <v-text-field
      v-model="form.memo"
      :error-messages="errors.memo"
      label="Ghi chú"
    />
  </div>
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
        breast_milk_activity: {
          duration: 0
        }
      }
    }
  },
  methods: {
    transformPropToData(prop) {
      return {
        started: this.$moment(prop.started).format('YYYY-MM-DD[T]HH:mm'),
        memo: prop.memo,
        breast_milk_activity: {
          duration: Math.floor(prop.breast_milk_activity.duration / 60) // To minutes
        }
      }
    },
    transformDataToProp(form) {
      return {
        started: this.$moment(form.started).toISOString(),
        memo: form.memo,
        activity_type_id: 2,
        breast_milk_activity: {
          duration: form.breast_milk_activity.duration * 60 // To seconds
        }
      }
    }
  }
}
</script>
