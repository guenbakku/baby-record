<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-card>
        <v-card-actions>
          <v-btn icon :to="{ name: 'activities' }" :active-class="'dummy'">
            <v-icon>keyboard_arrow_left</v-icon>
          </v-btn>
          <span class="subheading">{{ title }}</span>
        </v-card-actions>
        <v-divider />
        <v-card-text>
          <component :is="component" />
        </v-card-text>
      </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
import { loadComponents, getMaps } from '~/components/forms/maps'

export default {
  components: {
    ...loadComponents()
  },
  computed: {
    component: function() {
      return getMaps()[this.$route.params.type].component
    },
    title: function() {
      return getMaps()[this.$route.params.type].title
    }
  }
}
</script>
