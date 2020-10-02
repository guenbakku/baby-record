<template>
  <div>
    <v-text-field
      v-model="form.started"
      :error-messages="objectPath.get(errors, 'started')"
      label="Bắt đầu"
      required
      type="datetime-local"
    />
    <v-text-field
      v-model.number="form.bottle_milk_activity.duration"
      :error-messages="objectPath.get(errors, 'bottle_milk_activity.duration')"
      label="Thời gian"
      suffix="phút"
      required
      type="number"
    />
    <v-text-field
      v-model.number="form.bottle_milk_activity.fomular_volume"
      :error-messages="
        objectPath.get(errors, 'bottle_milk_activity.fomular_volume')
      "
      label="Lượng sữa công thức"
      suffix="ml"
      type="number"
    />
    <v-text-field
      v-model.number="form.bottle_milk_activity.breast_volume"
      :error-messages="
        objectPath.get(errors, 'bottle_milk_activity.breast_volume')
      "
      label="Lượng sữa mẹ"
      suffix="ml"
      type="number"
    />
    <v-text-field
      v-model="form.memo"
      :error-messages="objectPath.get(errors, 'memo')"
      label="Ghi chú"
    />
  </div>
</template>

<script lang="ts">
import { defineComponent, SetupContext } from '@vue/composition-api'
import { ActivityForm, ActivityError, declareProps } from './models'
import useForm from './use-form'

/* eslint-disable camelcase */
type Form = ActivityForm<{
  bottle_milk_activity: {
    duration: number
    breast_volume: number
    fomular_volume: number
  }
}>

type Props = {
  data: Form
  errors: ActivityError<{
    bottle_milk_activity?: {
      duration?: string
      breast_volume?: string
      fomular_volume?: string
    }
  }>
}
/* eslint-enable camelcase */

export default defineComponent({
  props: declareProps<Props['data'], Props['errors']>(),
  setup(props: Props, ctx: SetupContext) {
    const initForm: Form = {
      started: ctx.root.$moment().format('YYYY-MM-DD[T]HH:mm'),
      memo: '',
      bottle_milk_activity: {
        duration: 0,
        breast_volume: 0,
        fomular_volume: 0
      }
    }

    const propsToForm = (props: Props['data']) => ({
      started: ctx.root.$moment(props.started).format('YYYY-MM-DD[T]HH:mm'),
      memo: props.memo,
      bottle_milk_activity: {
        duration: Math.floor(props.bottle_milk_activity.duration / 60), // To minutes
        breast_volume: props.bottle_milk_activity.breast_volume,
        fomular_volume: props.bottle_milk_activity.fomular_volume
      }
    })

    const formToProps = (form: Form) => ({
      started: ctx.root.$moment(form.started).toISOString(),
      memo: form.memo,
      bottle_milk_activity: {
        duration: form.bottle_milk_activity.duration * 60, // To seconds
        breast_volume: form.bottle_milk_activity.breast_volume,
        fomular_volume: form.bottle_milk_activity.fomular_volume
      }
    })

    const { form, getData } = useForm<Props['data'], Form>(
      initForm,
      props.data,
      propsToForm,
      formToProps
    )

    return {
      form,
      getData,
      objectPath: ctx.root.$objectPath
    }
  }
})
</script>
