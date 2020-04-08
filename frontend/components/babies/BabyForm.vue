<template>
  <div>
    <v-text-field
      v-model="form.name"
      :error-messages="errors ? errors.name : undefined"
      label="Tên"
    />
    <v-text-field
      v-model="form.birthday"
      :error-messages="errors ? errors.birthday : undefined"
      label="Ngày tháng năm sinh"
      required
      type="date"
    />
    <v-select
      v-model="form.sex_id"
      :items="sexes"
      :loading="isInitializing"
      :error-messages="errors ? errors.sex_id : undefined"
      label="Giới tính"
    ></v-select>
  </div>
</template>

<script lang="ts">
import {
  createComponent,
  onMounted,
  ref,
  watch,
  SetupContext
} from '@vue/composition-api'
import { useStore } from '@u3u/vue-hooks'
import { Baby, BabyError, Code, SexId } from './models'
import useForm from './use-form'
import { RootState } from '~/store/models'
import useInitializationStatus from '~/hooks/use-initialization-status'

type Form = Omit<Baby, 'id' | 'user_id'>

type Props = {
  data: Baby
  errors: BabyError
}

export default createComponent({
  props: {
    data: {
      type: Object as () => Props['data'],
      default: () => ({})
    },
    errors: {
      type: Object as () => Props['errors'],
      default: () => {}
    }
  },
  setup(props: Props, ctx: SetupContext) {
    const store = useStore<RootState>()

    const {
      isInitializing,
      isInitializationSuccess,
      isInitializationError,
      setInitializing,
      setInitializationSuccess,
      setInitializationError
    } = useInitializationStatus()

    const sexes = ref<Code[]>([])
    const getSexCodes = () => {
      return store.value
        .dispatch('codes/viewCode', { model: 'sexes' })
        .then(res => {
          sexes.value = res.data.data.codes
          return res
        })
        .catch(err => {
          throw err
        })
    }

    const initForm: Form = {
      birthday: '',
      name: '',
      sex_id: SexId.boy
    }

    const { form, getData, updateForm } = useForm<Props['data'], Form>(
      initForm,
      props.data
    )

    watch(() => props.data, data => updateForm(data))

    onMounted(() => {
      setInitializing()
      Promise.all([getSexCodes()])
        .then(_ => {
          setInitializationSuccess()
          ctx.emit('initialized')
        })
        // eslint-disable-next-line handle-callback-err
        .catch(_ => {
          setInitializationError()
        })
    })

    return {
      form,
      sexes,
      isInitializing,
      isInitializationSuccess,
      isInitializationError,
      getData
    }
  }
  // data() {
  //   return {
  //     form: {
  //       name: null,
  //       birthday: this.$moment().format('YYYY-MM-DD'),
  //       sex_id: null
  //     },
  //     sexes: []
  //   }
  // },
  // watch: {
  //   data: {
  //     immediate: true,
  //     handler(val) {
  //       if (Object.keys(val || {}).length > 0) {
  //         this.form = JSON.parse(JSON.stringify(val))
  //       }
  //     }
  //   }
  // },
  // mounted() {
  //   this.setInitializing()
  //   Promise.all([this.getSexCodes()])
  //     .then(_ => {
  //       this.setInitializationSuccess()
  //       this.$emit('initialized')
  //     })
  //     // eslint-disable-next-line handle-callback-err
  //     .catch(_ => {
  //       this.setInitializationError()
  //     })
  // },
  // methods: {
  //   getData() {
  //     return JSON.parse(JSON.stringify(this.form))
  //   },
  //   getSexCodes() {
  //     return this.$store
  //       .dispatch('codes/viewCode', { model: 'sexes' })
  //       .then(res => {
  //         this.sexes = res.data.data.codes
  //         return res
  //       })
  //       .catch(err => {
  //         throw err
  //       })
  //   }
  // }
})
</script>
