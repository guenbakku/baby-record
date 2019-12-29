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
      v-model.number="form.temperature_activity.temperature"
      :error-messages="
        objectPath.get(errors, 'temperature_activity.temperature')
      "
      label="Nhiệt độ"
      suffix="°C"
      required
      type="number"
      step="0.1"
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
  temperature_activity: {
    temperature: number
  }
}>

type Props = {
  data: Form & {
    activity_type_id: number
  }
  errors: ActivityError<{
    temperature_activity?: {
      temperature?: string
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
      temperature_activity: {
        temperature: 0
      }
    }

    const propsToForm = (props: Props['data']) => ({
      started: ctx.root.$moment(props.started).format('YYYY-MM-DD[T]HH:mm'),
      memo: props.memo,
      temperature_activity: {
        temperature: props.temperature_activity.temperature
      }
    })

    const formToProps = (form: Form) => ({
      started: ctx.root.$moment(form.started).toISOString(),
      memo: form.memo,
      activity_type_id: 5,
      temperature_activity: {
        temperature: form.temperature_activity.temperature
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
