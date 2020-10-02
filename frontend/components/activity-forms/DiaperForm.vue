<template>
  <div>
    <v-text-field
      v-model="form.started"
      :error-messages="objectPath.get(errors, 'started')"
      label="Bắt đầu"
      required
      type="datetime-local"
    />
    <v-layout row nowrap>
      <v-flex x12>
        <v-checkbox
          v-model="form.diaper_activity.is_pee"
          :error-message="objectPath.get(errors, 'diaper_activity.is_pee')"
          color="primary"
          label="Có tè"
        />
      </v-flex>
      <v-flex x12>
        <v-checkbox
          v-model="form.diaper_activity.is_shit"
          :error-message="objectPath.get(errors, 'diaper_activity.is_shit')"
          color="primary"
          label="Có ị"
        />
      </v-flex>
    </v-layout>
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
  diaper_activity: {
    is_pee: boolean
    is_shit: boolean
  }
}>

type Props = {
  data: Form
  errors: ActivityError<{
    diaper_activity?: {
      is_pee?: string
      is_shit?: string
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
      diaper_activity: {
        is_pee: false,
        is_shit: false
      }
    }

    const propsToForm = (props: Props['data']) => ({
      started: ctx.root.$moment(props.started).format('YYYY-MM-DD[T]HH:mm'),
      memo: props.memo,
      diaper_activity: {
        is_pee: props.diaper_activity.is_pee,
        is_shit: props.diaper_activity.is_shit
      }
    })

    const formToProps = (form: Form) => ({
      started: ctx.root.$moment(form.started).toISOString(),
      memo: form.memo,
      diaper_activity: {
        is_pee: form.diaper_activity.is_pee,
        is_shit: form.diaper_activity.is_shit
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
