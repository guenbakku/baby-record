<template>
  <div v-if="currentBaby">
    <v-menu :nudge-width="100">
      <template v-slot:activator="{ on }">
        <div v-on="on">
          <span class="name">{{ currentBaby.name }}</span>
          <v-avatar :tile="false" size="30px">
            <sex-icon :sex-id="currentBaby.sex_id" />
          </v-avatar>
        </div>
      </template>

      <v-list>
        <v-list-tile avatar>
          <v-list-tile-avatar>
            <sex-icon large :sex-id="currentBaby.sex_id" />
          </v-list-tile-avatar>

          <v-list-tile-content>
            <v-list-tile-title>{{ currentBaby.name }}</v-list-tile-title>
            <v-list-tile-sub-title>{{ age }}</v-list-tile-sub-title>
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
          <v-list-tile-title>{{ baby.name }}</v-list-tile-title>
        </v-list-tile>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
import DatetimeMixin from '~/mixins/datetime.mixin.js'
import SexIcon from '~/components/core/SexIcon'

export default {
  components: { SexIcon },
  mixins: [DatetimeMixin],
  computed: {
    currentBaby() {
      return this.$store.getters['babies/current']
    },
    babies() {
      return this.$store.state.babies.babies
    },
    age() {
      const age = this.calcAge(this.currentBaby.birthday)
      if (age[0] > 0) {
        return `${age[0]} tuổi ${age[1]} tháng`
      } else {
        return `${age[1]} tháng ${age[2]} ngày`
      }
    }
  },
  methods: {
    changeBaby(id) {
      this.$store.commit('babies/setCurrentId', { id })
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
