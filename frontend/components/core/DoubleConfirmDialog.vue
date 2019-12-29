<template>
  <v-dialog v-model="dialog" max-width="600px">
    <template v-slot:activator="{ on }">
      <slot name="activator" :on="on"></slot>
    </template>
    <v-card>
      <v-card-title class="title">
        <slot name="title">
          <v-icon color="warning" class="mr-1">warning</v-icon> Xác nhận
        </slot>
      </v-card-title>
      <v-divider />
      <v-card-text>
        <slot name="message">Bạn có chắc chắn thực hiện thao tác này?</slot>
      </v-card-text>
      <v-card-text class="pt-0 pb-0">
        <v-text-field v-model="inputValue" outline single-line required />
      </v-card-text>
      <v-divider />
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="info" flat @click="dialog = false">
          Hủy
        </v-btn>
        <v-btn
          color="warning"
          flat
          :loading="loading"
          :disabled="!isMatched"
          @click="$emit('confirmed')"
        >
          OK
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script lang="ts">
import { createComponent, ref, computed } from '@vue/composition-api'

type Props = {
  loading: boolean
  checkValue: string | undefined
}

export default createComponent({
  props: {
    loading: {
      type: Boolean,
      default: false
    },
    checkValue: {
      type: String,
      default: undefined
    }
  },
  setup(props: Props) {
    const dialog = ref(false)
    const inputValue = ref('')
    const isMatched = computed(() => inputValue.value === props.checkValue)

    return {
      dialog,
      inputValue,
      isMatched
    }
  }
})
</script>
