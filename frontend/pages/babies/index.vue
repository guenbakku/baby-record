<template>
  <v-layout row wrap class="pd-5">
    <v-flex xs12>
      <v-card>
        <loading v-if="!completed" />
        <no-data v-else-if="isNoData" />
        <baby-list v-else :babies="babies" />
      </v-card>
    </v-flex>
    <v-btn fixed dark fab bottom right color="success" :to="addRoute">
      <v-icon>add</v-icon>
    </v-btn>
  </v-layout>
</template>

<script>
import BabyList from '~/components/babies/BabyList'
import Loading from '~/components/Loading'
import NoData from '~/components/NoData'

export default {
  components: { BabyList, Loading, NoData },
  data() {
    return {
      completed: false
    }
  },
  computed: {
    babies() {
      return this.$store.state.babies.babies
    },
    isNoData() {
      return this.completed && Object.keys(this.babies || {}).length === 0
    },
    addRoute() {
      return {
        name: 'babies-add'
      }
    }
  },
  mounted() {
    this.getBabies()
  },
  methods: {
    getBabies() {
      this.completed = false
      this.$store.dispatch('babies/getBabies').then(res => {
        this.completed = true
      })
    }
  }
}
</script>
