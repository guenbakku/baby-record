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
      v-model.number="form.measurement_activity.height"
      :error-messages="objectPath.get(errors, 'measurement_activity.height')"
      label="Chiều cao"
      suffix="cm"
      type="number"
      step="1"
    />
    <v-text-field
      v-model.number="form.measurement_activity.weight"
      :error-messages="objectPath.get(errors, 'measurement_activity.weight')"
      label="Cân nặng"
      suffix="kg"
      type="number"
      step="1"
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
  measurement_activity: {
    height?: number
    weight?: number
  }
}>

type Props = {
  data: Form
  errors: ActivityError<{
    measurement_activity?: {
      height?: string
      weight?: string
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
      measurement_activity: {
        height: undefined,
        weight: undefined
      }
    }

    const propsToForm = (props: Props['data']) => ({
      started: ctx.root.$moment(props.started).format('YYYY-MM-DD[T]HH:mm'),
      memo: props.memo,
      measurement_activity: {
        height: props.measurement_activity.height,
        weight: props.measurement_activity.weight
      }
    })

    const formToProps = (form: Form) => ({
      started: ctx.root.$moment(form.started).toISOString(),
      memo: form.memo,
      measurement_activity: {
        height: form.measurement_activity.height,
        weight: form.measurement_activity.weight
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
