<template>
  <div v-if="currentBaby">
    <v-menu :nudge-width="100">
      <template v-slot:activator="{ on }">
        <div v-on="on">
          <span class="name">{{currentBaby.name}}</span>
          <v-avatar :tile="false" size="30px" color="grey lighten-4">
            <img :src="currentBaby.avatar" alt="avatar" />
          </v-avatar>
        </div>
      </template>

      <v-list>
        <v-list-tile avatar>
          <v-list-tile-avatar>
            <img :src="currentBaby.avatar" alt="avatar" />
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title>{{currentBaby.name}}</v-list-tile-title>
            <v-list-tile-sub-title>{{calcBabyAge(currentBaby.birthday)}}</v-list-tile-sub-title>
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
      <v-divider />
      <v-list>
        <v-list-tile
          v-for="(baby, id) in babies"
          :key="id"
          @click="changeBaby(id)"
        >
          <v-list-tile-title>{{baby.name}}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
export default {
  computed: {
    currentBaby() {
      return this.$store.getters['babies/getCurrent']
    },
    babies() {
      return this.$store.getters['babies/getBabies']
    }
  },
  methods: {
    changeBaby(id) {
      this.$store.commit('babies/setCurrent', {id})
    },
    calcBabyAge(day) {
      const birthday = new Date(day)
      const now = new Date()
      // const age = {
      //   years: 0,
      //   months: 0,
      //   days: 0
      // }

      if (birthday > now) {
        throw new Error(`Birthday can't not be a future time`)
      }

      // if (birthday.getFullYear() === now.getFullYear()) {
      //   age.months = now.getMonth() - birthday.getMonth()
      //   age.days = now.getDate() - birthday.getDate()
      //   return age
      // } else {
      //   age.years = now.getFullYear() - birthday.getFullYear()
      //   age.months = now.getMonth() - birthday.getMonth()
      //   age.months = age.months < 0 ? age.months + 12 : age.months

      // }

      // TODO: implement this function
      return "To be implemented"
    }
  }
}
</script>

<style>
.name {
  display: inline-block;
  vertical-align: middle;
  max-width: 100px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
</style>
