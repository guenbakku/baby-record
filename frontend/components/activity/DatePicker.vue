<template>
  <v-menu v-model="menu" :close-on-content-click="false">
    <template v-slot:activator="{ on }">
      <v-icon>event</v-icon>
      <span class="subheading" v-on="on">{{ mDate }}</span>
    </template>
    <v-date-picker
      v-model="mDate"
      no-title
      :locale="locale"
      :first-day-of-week="1"
      @change="menu = false"
    ></v-date-picker>
  </v-menu>
</template>

<script>
export default {
  props: {
    date: {
      type: String,
      default: null
    }
  },
  data() {
    return {
      menu: false
    }
  },
  computed: {
    mDate: {
      get: function() {
        return this.date || this.$moment().format('YYYY-MM-DD')
      },
      set: function(date) {
        this.$emit('selected', date)
      }
    },
    locale() {
      return this.$store.state.config.locale
    }
  }
}
</script>
