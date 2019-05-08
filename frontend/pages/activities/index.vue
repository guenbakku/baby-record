<template>
  <v-layout row nowrap>
    <v-flex xs12>
      <v-layout row nowrap>
        <v-flex xs12>
          <v-card class="table">
            <v-card-actions style="justify-content: center">
              <date-picker />
            </v-card-actions>
            <v-layout row nowrap>
              <v-flex xs6 class="cell">
                <span class="header">Bú mẹ</span>
                1 lần/20 phút
              </v-flex>
              <v-flex xs6 class="cell">
                <span class="header">Bú bình</span>
                3 lần/500 ml <br /> (SM: 100ml, CT: 400ml)
              </v-flex>
            </v-layout>
            <v-layout row nowrap>
              <v-flex xs6 class="cell">
                <span class="header">Tã</span>
                2 lần (ị: 1 lần, tè: 2 lần)
              </v-flex>
              <v-flex xs6 class="cell">
                <span class="header">Vắt sữa</span>
                3 lần/500ml
              </v-flex>
            </v-layout>
          </v-card>
        </v-flex>
      </v-layout>

      <v-layout row nowrap class="mt-3">
        <v-flex xs12>
          <v-card>
            <activity :activity="{ activity_type: { code: 'breast_milk_activity' } }"/>
            <activity :activity="{ activity_type: { code: 'bottle_milk_activity' } }"/>
            <activity />
          </v-card>
        </v-flex>
      </v-layout>
    </v-flex>
    <speed-dial />
  </v-layout>
</template>

<script>
import Activity from '~/components/activity/Activity'
import DatePicker from '~/components/activity/DatePicker'
import SpeedDial from '~/components/SpeedDial'

export default {
  components: {
    Activity,
    DatePicker,
    SpeedDial
  }
}
</script>

<style scoped>
.table .row {
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}
.table .row:first-child {
  border-top: none;
}
.table .cell {
  border-left: 1px solid rgba(255, 255, 255, 0.1);
  padding: 4px
}
.table .cell:first-child {
  border-left: none
}
.table .header {
  display: block;
  color: rgba(255, 255, 255, 0.7);
  font-weight: bold
}
</style>
