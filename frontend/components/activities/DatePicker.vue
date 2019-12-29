<template>
  <v-menu v-model="menu" :close-on-content-click="false">
    <template v-slot:activator="{ on }">
      <v-btn icon class="mr-2" @click="subOneDay">
        <v-icon>keyboard_arrow_left</v-icon>
      </v-btn>
      <v-icon>event</v-icon>
      <span class="subheading" v-on="on">{{ mDate }}</span>
      <v-btn icon class="ml-2" @click="addOneDay">
        <v-icon>keyboard_arrow_right</v-icon>
      </v-btn>
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
      get() {
        return this.date || this.$moment().format('YYYY-MM-DD')
      },
      set(date) {
        this.$emit('selected', date)
      }
    },
    locale() {
      return this.$store.state.config.locale
    }
  },
  methods: {
    subOneDay() {
      this.mDate = this.$moment(this.mDate)
        .subtract(1, 'days')
        .format('YYYY-MM-DD')
    },
    addOneDay() {
      this.mDate = this.$moment(this.mDate)
        .add(1, 'days')
        .format('YYYY-MM-DD')
    }
  }
}
</script>
