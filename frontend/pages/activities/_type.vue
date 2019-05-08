<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card :elevation="0">
        <v-card-actions>
          <v-btn icon :to="{name: 'activities'}" :active-class="'dummy'">
            <v-icon>keyboard_arrow_left</v-icon>
          </v-btn>
          <div class="subheading">{{ title }}</div>
          <v-spacer></v-spacer>
        </v-card-actions>
        <v-divider />
        <v-card-text>
          <component :is="component"/>
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import { getFormComponents, getFormMetas } from '~/components/forms/forms'

export default {
  components: {
    ...getFormComponents(),
  },
  computed: {
    component: function () {
      return `${ this.$route.params.type }Form`
    },
    title: function () {
      return getFormMetas()[this.$route.params.type].title
    }
  }
}
</script>
