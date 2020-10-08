<template>
  <v-app dark>
    <v-navigation-drawer
      v-if="isAuthenticated"
      v-model="drawer"
      :mini-variant="miniVariant"
      :clipped="clipped"
      fixed
      app
    >
      <login-user />
      <v-list>
        <v-divider />
        <template v-for="(item, i) in items">
          <v-divider v-if="item.divider && i > 0" :key="i + '_divider'" />
          <v-list-tile :key="i" :to="item.to" router>
          <v-list-tile-action>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-tile-action>
          <v-list-tile-content>
            <v-list-tile-title v-text="item.title" />
          </v-list-tile-content>
        </v-list-tile>
        </template>
      </v-list>
    </v-navigation-drawer>
    <v-toolbar
      v-if="isAuthenticated"
      :clipped-left="clipped"
      fixed
      app
      color="primary"
    >
      <v-toolbar-side-icon @click="drawer = !drawer" />
      <v-toolbar-title v-text="headerTitle" />
      <v-spacer />
      <baby-switch v-if="useBabySwitch" />
    </v-toolbar>
    <v-content>
      <v-container>
        <nuxt />
      </v-container>
    </v-content>
    <v-footer :fixed="fixed" app>
      <span class="ml-3">
        {{ title }} &copy; {{ $moment().format('YYYY') }} - v.{{ version }}
      </span>
    </v-footer>
    <flash />
  </v-app>
</template>

<script>
import '~/assets/icomoon/style.css'
import { mapGetters, mapState } from 'vuex'
import LoginUser from '~/components/core/LoginUser'
import BabySwitch from '~/components/core/BabySwitch'
import Flash from '~/components/core/Flash'
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
          icon: 'icon-record',
          title: 'Ghi chép',
          to: '/activities'
        },
        {
          icon: 'icon-baby',
          title: 'Em bé',
          to: '/babies'
        },
        {
          divider: true,
          icon: 'icon-logout',
          title: 'Đăng xuất',
          to: '/logout'
        }
      ],
      miniVariant: false,
      right: true,
      rightDrawer: false,
      title: pkg.title,
      version: pkg.version
    }
  },
  computed: {
    ...mapGetters('auth', ['isAuthenticated']),
    ...mapState('config', ['headerTitle', 'useBabySwitch'])
  }
}
</script>
