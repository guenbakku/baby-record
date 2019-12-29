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

<script lang="ts">
import Vue from 'vue'
import { Location } from 'vue-router'
import BabyList from '~/components/babies/BabyList.vue'
import Loading from '~/components/core/card-text/Loading.vue'
import NoData from '~/components/core/card-text/NoData.vue'
import { State } from '~/store/babies/models'

type Data = {
  completed: boolean
}

export default Vue.extend({
  components: { BabyList, Loading, NoData },
  data(): Data {
    return {
      completed: false
    }
  },
  computed: {
    babies(): State['babies'] {
      return this.$store.state.babies.babies
    },
    isNoData(): boolean {
      return this.completed && Object.keys(this.babies || {}).length === 0
    },
    addRoute(): Location {
      return {
        name: 'babies-add'
      }
    }
  },
  mounted(): void {
    this.getBabies()
  },
  methods: {
    getBabies(): void {
      this.completed = false
      this.$store.dispatch('babies/getBabies').finally(() => {
        this.completed = true
      })
    }
  }
})
</script>
