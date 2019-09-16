<template>
  <v-layout row wrap class="pd-5">
    <v-flex xs12>
      <v-card>
        <loading v-if="!completed" />
        <no-data v-else-if="isNoData">
          Chưa có thông tin em bé nào cả. <br />
          Hãy thêm thông tin em bé để bắt đầu sử dụng.
        </no-data>
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
import Loading from '~/components/core/Loading'
import NoData from '~/components/core/NoData'

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
      this.$store.dispatch('babies/getBabies').finally(() => {
        this.completed = true
      })
    }
  }
}
</script>
