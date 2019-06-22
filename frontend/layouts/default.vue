<template>
  <v-app dark>
    <v-navigation-drawer
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <login-user />
      <v-list>
        <v-divider />
        <v-list-tile v-for="(item, i) in items" :key="i" :to="item.to" router>
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title" />
          </v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar :clipped-left="clipped" fixed app color="primary">
      <v-toolbar-side-icon @click="drawer = !drawer" />
      <v-toolbar-title v-text="title" />
      <v-spacer />
      <baby-switch />
    </v-toolbar>
    <v-content>
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <v-footer :fixed="fixed" app>
      <span>&copy; 2019</span>
    </v-footer>
    <flash />
  </v-app>
</template>

<script>
import LoginUser from '~/components/LoginUser'
import BabySwitch from '~/components/BabySwitch'
import Flash from '~/components/Flash'
import pkg from '~/package'

export default {
  components: {
    LoginUser,
    BabySwitch,
    Flash
  },
  data() {
    return {
      clipped: true,
      drawer: false,
      fixed: false,
      items: [
        {
          icon: 'apps',
          title: 'Ghi chép',
          to: '/activities'
        },
        {
          icon: 'bubble_chart',
          title: 'Em bé',
          to: '/babies'
        },
        {
          divider: true,
          icon: 'power_off',
          title: 'Đăng xuất',
          to: '/logout'
        }
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: pkg.title
    }
  }
}
</script>
