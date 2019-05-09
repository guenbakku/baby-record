<template>
  <v-menu v-model="menu" :close-on-content-click="false">
    <template v-slot:activator="{ on }">
      <v-icon>event</v-icon>
      <span class="subheading" v-on="on">{{ date }}</span>
    </template>
    <v-date-picker
      v-model="date"
      no-title
      :locale="locale"
      :first-day-of-week="1"
      @change="menu = false"
    ></v-date-picker>
  </v-menu>
</template>

<script>
export default {
  data() {
    return {
      menu: false
    }
  },
  computed: {
    date: {
      get: function() {
        return this.$store.state.activities.date
      },
      set: function(date) {
        this.$store.commit('activities/setDate', { date })
      }
    },
    locale() {
      return this.$store.state.config.locale
    }
  }
}
</script>
