<template>
  <v-card-text>
    <v-icon color="warning">error</v-icon>
    <slot>Không tải được dữ liệu</slot>
  </v-card-text>
</template>

<script lang="ts">
import { defineComponent } from '@vue/composition-api'
export default defineComponent({})
</script>
