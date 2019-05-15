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
      v-model.number="form.temperature_activity.temperature"
      :error-messages="
        $objectPath.get(errors, 'temperature_activity.temperature', null)
      "
      label="Nhiệt độ"
      suffix="°C"
      required
      type="number"
      step="0.1"
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
        temperature_activity: {
          temperature: 0
        }
      }
    }
  },
  methods: {
    transformPropToData(prop) {
      return {
        started: this.$moment(prop.started).format('YYYY-MM-DD[T]HH:mm'),
        memo: prop.memo,
        temperature_activity: {
          temperature: prop.temperature_activity.temperature
        }
      }
    },
    transformDataToProp(form) {
      return {
        started: this.$moment(form.started)
          .utc()
          .format('YYYY-MM-DD HH:mm:ss'),
        memo: form.memo,
        activity_type_id: 5,
        temperature_activity: {
          temperature: form.temperature_activity.temperature
        }
      }
    }
  }
}
</script>
