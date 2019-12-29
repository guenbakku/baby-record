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
      v-model.number="form.pump_milk_activity.duration"
      :error-messages="objectPath.get(errors, 'pump_milk_activity.duration')"
      label="Thời gian"
      suffix="phút"
      required
      type="number"
    />
    <v-text-field
      v-model.number="form.pump_milk_activity.volume"
      :error-messages="objectPath.get(errors, 'pump_milk_activity.volume')"
      label="Lượng sữa"
      suffix="ml"
      required
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
import { createComponent, SetupContext } from '@vue/composition-api'
import { ActivityForm, ActivityError, declareProps } from './models'
import useForm from './use-form'

/* eslint-disable camelcase */
type Form = ActivityForm<{
  pump_milk_activity: {
    duration: number
    volume: number
  }
}>

type Props = {
  data: Form & {
    activity_type_id: number
  }
  errors: ActivityError<{
    pump_milk_activity?: {
      duration?: string
      volume?: string
    }
  }>
}
/* eslint-enable camelcase */

export default createComponent({
  props: declareProps<Props['data'], Props['errors']>(),
  setup(props: Props, ctx: SetupContext) {
    const initForm: Form = {
      started: ctx.root.$moment().format('YYYY-MM-DD[T]HH:mm'),
      memo: '',
      pump_milk_activity: {
        duration: 0,
        volume: 0
      }
    }

    const propsToForm = (props: Props['data']) => ({
      started: ctx.root.$moment(props.started).format('YYYY-MM-DD[T]HH:mm'),
      memo: props.memo,
      pump_milk_activity: {
        duration: Math.floor(props.pump_milk_activity.duration / 60), // To minutes
        volume: props.pump_milk_activity.volume
      }
    })

    const formToProps = (form: Form) => ({
      started: ctx.root.$moment(form.started).toISOString(),
      memo: form.memo,
      activity_type_id: 3,
      pump_milk_activity: {
        duration: form.pump_milk_activity.duration * 60, // To seconds
        volume: form.pump_milk_activity.volume
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
