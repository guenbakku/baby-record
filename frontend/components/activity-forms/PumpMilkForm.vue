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
      v-model.number="form.pump_milk_activity.duration"
      :error-messages="
        $objectPath.get(errors, 'pump_milk_activity.duration', null)
      "
      label="Thời gian"
      suffix="phút"
      required
      type="number"
    />
    <v-text-field
      v-model.number="form.pump_milk_activity.volume"
      :error-messages="
        $objectPath.get(errors, 'pump_milk_activity.volume', null)
      "
      label="Lượng sữa"
      suffix="ml"
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
        pump_milk_activity: {
          duration: 0,
          volume: 0
        }
      }
    }
  },
  methods: {
    transformPropToData(prop) {
      return {
        started: this.$moment(prop.started).format('YYYY-MM-DD[T]HH:mm'),
        memo: prop.memo,
        pump_milk_activity: {
          duration: Math.floor(prop.pump_milk_activity.duration / 60), // To minutes
          volume: prop.pump_milk_activity.volume
        }
      }
    },
    transformDataToProp(form) {
      return {
        started: this.$moment(form.started).toISOString(),
        memo: form.memo,
        activity_type_id: 3,
        pump_milk_activity: {
          duration: form.pump_milk_activity.duration * 60, // To seconds
          volume: form.pump_milk_activity.volume
        }
      }
    }
  }
}
</script>
