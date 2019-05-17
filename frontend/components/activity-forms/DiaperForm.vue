<template>
  <form>
    <v-text-field
      v-model="form.started"
      :error-messages="errors.started"
      label="Bắt đầu"
      required
      type="datetime-local"
    />
    <v-layout row nowrap>
      <v-flex x12>
        <v-checkbox
          v-model="form.diaper_activity.is_pee"
          :error-message="
            $objectPath.get(errors, 'diaper_activity.is_pee', null)
          "
          color="primary"
          label="Có tè"
        />
      </v-flex>
      <v-flex x12>
        <v-checkbox
          v-model="form.diaper_activity.is_shit"
          :error-message="
            $objectPath.get(errors, 'diaper_activity.is_shit', null)
          "
          color="primary"
          label="Có ị"
        />
      </v-flex>
    </v-layout>
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
        diaper_activity: {
          is_pee: false,
          is_shit: false
        }
      }
    }
  },
  methods: {
    transformPropToData(prop) {
      return {
        started: this.$moment(prop.started).format('YYYY-MM-DD[T]HH:mm'),
        memo: prop.memo,
        diaper_activity: {
          is_pee: prop.diaper_activity.is_pee,
          is_shit: prop.diaper_activity.is_shit
        }
      }
    },
    transformDataToProp(form) {
      return {
        started: this.$moment(form.started).toISOString(),
        memo: form.memo,
        activity_type_id: 4,
        diaper_activity: {
          is_pee: form.diaper_activity.is_pee,
          is_shit: form.diaper_activity.is_shit
        }
      }
    }
  }
}
</script>
