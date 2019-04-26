<template>
  <v-speed-dial v-model="fab" bottom right fixed :direction="direction">
    <template v-slot:activator>
      <v-btn v-model="fab" color="green" dark fab>
        <v-icon>add</v-icon>
        <v-icon>close</v-icon>
      </v-btn>
    </template>
    <v-btn dark small :color="color">
      Sữa mẹ
      <v-icon>add</v-icon>
    </v-btn>
    <v-btn dark small :color="color">
      Sữa bình
      <v-icon>add</v-icon>
    </v-btn>
    <v-btn dark small :color="color">
      Vắt sữa
      <v-icon>add</v-icon>
    </v-btn>
    <v-btn dark small :color="color">
      Thay bỉm
      <v-icon>add</v-icon>
    </v-btn>
  </v-speed-dial>
</template>

<script>
export default {
  name: 'SpeedDial',
  data: () => ({
    color: 'red',
    fab: false,
    direction: 'top'
  })
}
</script>

<style>
.v-speed-dial__list {
  align-items: flex-end !important;
  left: auto !important;
  right: -7px !important;
  width: auto !important;
}
</style>
