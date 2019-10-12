<template>
  <router-link :to="editRoute" tag="div" class="item">
    <v-list-tile>
      <v-list-tile-avatar>
        <sex-icon color="grey" large :sex-id="baby.sex_id" />
      </v-list-tile-avatar>

      <v-list-tile-content>
        <v-list-tile-title>{{ baby.name }}</v-list-tile-title>
        <v-list-tile-sub-title>
          {{ baby.birthday | moment('L') }} ({{ age }})
        </v-list-tile-sub-title>
      </v-list-tile-content>

      <v-list-tile-action>
        <v-icon>keyboard_arrow_right</v-icon>
      </v-list-tile-action>
    </v-list-tile>
  </router-link>
</template>

<script>
import DatetimeMixin from '~/mixins/datetime.mixin'
import SexIcon from '~/components/core/SexIcon'

export default {
  components: { SexIcon },
  mixins: [DatetimeMixin],
  props: {
    baby: {
      type: Object,
      default: () => {}
    }
  },
  computed: {
    editRoute() {
      return {
        name: 'babies-edit-id',
        params: {
          id: this.baby.id
        }
      }
    },
    age() {
      const age = this.calcAge(this.baby.birthday)
      if (age[0] > 0) {
        return `${age[0]} tuổi ${age[1]} tháng`
      } else {
        return `${age[1]} tháng ${age[2]} ngày`
      }
    }
  }
}
</script>

<style scoped lang="stylus">
.item {
  padding: 10px 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
  cursor: pointer;

  &:active {
    background: rgba(255, 255, 255, 0.3);
  }

  &:first-child {
    border-top: none;
  }
}
</style>
