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
      v-model.number="form.bottle_milk_activity.duration"
      :error-messages="
        $objectPath.get(errors, 'bottle_milk_activity.duration', null)
      "
      label="Thời gian"
      suffix="phút"
      required
      type="number"
    />
    <v-text-field
      v-model.number="form.bottle_milk_activity.fomular_volume"
      :error-messages="
        $objectPath.get(errors, 'bottle_milk_activity.fomular_volume', null)
      "
      label="Lượng sữa công thức"
      suffix="ml"
      type="number"
    />
    <v-text-field
      v-model.number="form.bottle_milk_activity.breast_volume"
      :error-messages="
        $objectPath.get(errors, 'bottle_milk_activity.breast_volume', null)
      "
      label="Lượng sữa mẹ"
      suffix="ml"
      type="number"
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
        bottle_milk_activity: {
          duration: 0,
          breast_volume: 0,
          fomular_volume: 0
        }
      }
    }
  },
  methods: {
    transformPropToData(prop) {
      return {
        started: this.$moment(prop.started).format('YYYY-MM-DD[T]HH:mm'),
        memo: prop.memo,
        bottle_milk_activity: {
          duration: Math.floor(prop.bottle_milk_activity.duration / 60), // To minutes
          breast_volume: prop.bottle_milk_activity.breast_volume,
          fomular_volume: prop.bottle_milk_activity.fomular_volume
        }
      }
    },
    transformDataToProp(form) {
      return {
        started: this.$moment(form.started).toISOString(),
        memo: form.memo,
        activity_type_id: 1,
        bottle_milk_activity: {
          duration: form.bottle_milk_activity.duration * 60, // To seconds
          breast_volume: form.bottle_milk_activity.breast_volume,
          fomular_volume: form.bottle_milk_activity.fomular_volume
        }
      }
    }
  }
}
</script>
