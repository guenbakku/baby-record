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
        dark
        small
        @click="openDialog(dialog)"
      >
        {{ dialog.title }}
        <v-icon>add</v-icon>
      </v-btn>
    </v-speed-dial>
    <v-dialog v-model="dialog" fullscreen transition="dialog-bottom-transition">
      <v-card>
        <v-toolbar dark color="primary">
          <v-btn icon dark @click="dialog = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>
            {{ title }}
          </v-toolbar-title>
          <v-spacer />
          <baby-switch />
        </v-toolbar>
        <v-card-text>
          <component :is="component" />
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { getFormComponents, getFormMetas } from '~/components/forms/forms'
import BabySwitch from '~/components/BabySwitch'

export default {
  name: 'SpeedDial',
  components: {
    ...getFormComponents(),
    BabySwitch
  },
  data: () => ({
    color: 'primary',
    fab: false,
    dialog: false,
    dialogs: getFormMetas(),
    title: null,
    component: null
  }),
  methods: {
    openDialog: function (dialog) {
      this.dialog = !this.dialog
      this.title = dialog.title
      this.component = dialog.component
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
