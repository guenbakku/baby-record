<template>
  <div>
    <v-speed-dial
      v-model="fab"
      bottom
      right
      fixed
      direction="top"
      transition="slide-y-reverse-transition"
    >
      <template v-slot:activator>
        <v-btn v-model="fab" color="green" dark fab>
          <v-icon>add</v-icon>
          <v-icon>close</v-icon>
        </v-btn>
      </template>
      <v-btn
        v-for="(dialog, key) in dialogs"
        :key="key"
        :color="color"
        :to="{ name: 'activities-type', params: { type: key} }"
        dark
        small
      >
        {{ dialog.title }}
        <v-icon>add</v-icon>
      </v-btn>
    </v-speed-dial>
  </div>
</template>

<script>
import { getFormMetas } from '~/components/forms/forms'

export default {
  name: 'SpeedDial',
  data: () => ({
    color: 'primary',
    fab: false
  }),
  computed: {
    dialogs: function () {
      return getFormMetas()
    }
  }
}
</script>

<style>
.v-speed-dial__list {
  align-items: flex-end !important;
  left: auto !important;
  right: -7px !important;
  width: auto !important;
}
</style>
