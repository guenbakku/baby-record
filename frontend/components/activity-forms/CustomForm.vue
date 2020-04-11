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
      v-model="form.custom_activity.title"
      :error-messages="objectPath.get(errors, 'custom_activity.title')"
      label="Nội dung"
      required
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
  custom_activity: {
    title: string
  }
}>

type Props = {
  data: Form & {
    activity_type_id: number
  }
  errors: ActivityError<{
    custom_activity?: {
      title?: string
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
      custom_activity: {
        title: ''
      }
    }

    const propsToForm = (props: Props['data']): Form => ({
      started: ctx.root.$moment(props.started).format('YYYY-MM-DD[T]HH:mm'),
      memo: props.memo,
      custom_activity: {
        title: props.custom_activity.title
      }
    })

    const formToProps = (form: Form): Props['data'] => ({
      started: ctx.root.$moment(form.started).toISOString(),
      memo: form.memo,
      activity_type_id: 6,
      custom_activity: {
        title: form.custom_activity.title
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
